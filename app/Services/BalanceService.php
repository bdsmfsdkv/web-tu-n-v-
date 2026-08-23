<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use Illuminate\Support\Facades\DB;
use LogicException;

/**
 * Điểm vào duy nhất cho mọi thay đổi số dư (tiền / vàng / ngọc).
 *
 * Lý do tồn tại: trước đây mỗi controller tự đọc `Auth::user()->balance` rồi ghi lại
 * một giá trị TUYỆT ĐỐI (`update(['balance' => $before - $price])`). Giá trị đó được
 * đọc từ model đã nạp sẵn trong session, NGOÀI transaction và KHÔNG khóa dòng, nên:
 *
 *   1. Hai request mua song song đều thấy cùng `$before` => người dùng mua được 2 món
 *      với số tiền của 1 món (double-spend).
 *   2. Một giao dịch nạp tiền chạy xen giữa sẽ bị ghi đè mất (lost update).
 *
 * Service này luôn khóa dòng user bằng `SELECT ... FOR UPDATE` trước khi đọc số dư,
 * và ghi lịch sử `money_transactions` trong cùng transaction để `amount` luôn bằng
 * `balance_after - balance_before`.
 */
class BalanceService
{
    /** Các cột tài nguyên được phép thao tác. */
    private const RESOURCE_COLUMNS = ['balance', 'gold', 'gem'];

    /**
     * Khóa dòng user và trả về bản ghi hiện tại (số dư đáng tin cậy nhất).
     *
     * @throws LogicException nếu gọi ngoài transaction (khóa sẽ bị nhả ngay lập tức).
     */
    public function lock(int $userId): object
    {
        $this->assertInTransaction();

        $row = DB::table('users')
            ->where('id', $userId)
            ->lockForUpdate()
            ->first(['id', 'balance', 'gold', 'gem', 'total_deposited', 'total_commission']);

        if ($row === null) {
            throw new LogicException('Không tìm thấy người dùng #' . $userId . ' để khóa số dư.');
        }

        return $row;
    }

    /**
     * Trừ tiền và ghi lịch sử. Trả về ['before' => int, 'after' => int].
     *
     * @param  int         $amount       Số tiền dương cần trừ.
     * @param  string      $type         Loại giao dịch trong money_transactions.
     * @param  string|null $insufficient Thông báo khi không đủ số dư.
     * @throws InsufficientBalanceException
     */
    public function charge(
        int $userId,
        int $amount,
        string $description,
        string $type = 'purchase',
        ?string $referenceId = null,
        ?string $insufficient = null
    ): array {
        $amount = $this->assertPositiveOrZero($amount);
        $row = $this->lock($userId);
        $before = (int) $row->balance;

        if ($before < $amount) {
            throw new InsufficientBalanceException($insufficient ?? 'Số dư không đủ để thực hiện giao dịch.');
        }

        $after = $before - $amount;

        // Ràng buộc `balance >= amount` được lặp lại trong WHERE như một lớp bảo vệ thứ hai:
        // nếu vì lý do nào đó khóa không có tác dụng, câu lệnh sẽ không cập nhật dòng nào.
        $affected = DB::table('users')
            ->where('id', $userId)
            ->where('balance', '>=', $amount)
            ->update(['balance' => DB::raw('balance - ' . $amount)]);

        if ($affected !== 1) {
            throw new InsufficientBalanceException($insufficient ?? 'Số dư không đủ để thực hiện giao dịch.');
        }

        if ($amount > 0) {
            $this->recordTransaction($userId, $type, -$amount, $before, $after, $description, $referenceId);
        }

        return ['before' => $before, 'after' => $after];
    }

    /**
     * Cộng tiền và ghi lịch sử. Trả về ['before' => int, 'after' => int].
     */
    public function credit(
        int $userId,
        int $amount,
        string $description,
        string $type = 'deposit',
        ?string $referenceId = null
    ): array {
        $amount = $this->assertPositiveOrZero($amount);
        $row = $this->lock($userId);
        $before = (int) $row->balance;
        $after = $before + $amount;

        DB::table('users')
            ->where('id', $userId)
            ->update(['balance' => DB::raw('balance + ' . $amount)]);

        if ($amount > 0) {
            $this->recordTransaction($userId, $type, $amount, $before, $after, $description, $referenceId);
        }

        return ['before' => $before, 'after' => $after];
    }

    /**
     * Trừ tài nguyên phi tiền tệ (gold/gem) một cách nguyên tử, không ghi money_transactions.
     *
     * @throws InsufficientBalanceException
     */
    public function chargeResource(int $userId, string $column, int $amount, ?string $insufficient = null): array
    {
        $column = $this->assertResourceColumn($column);
        $amount = $this->assertPositiveOrZero($amount);
        $row = $this->lock($userId);
        $before = (int) $row->{$column};

        if ($before < $amount) {
            throw new InsufficientBalanceException($insufficient ?? 'Số dư không đủ để thực hiện giao dịch.');
        }

        $affected = DB::table('users')
            ->where('id', $userId)
            ->where($column, '>=', $amount)
            ->update([$column => DB::raw($column . ' - ' . $amount)]);

        if ($affected !== 1) {
            throw new InsufficientBalanceException($insufficient ?? 'Số dư không đủ để thực hiện giao dịch.');
        }

        return ['before' => $before, 'after' => $before - $amount];
    }

    /**
     * Cộng tài nguyên phi tiền tệ (gold/gem) một cách nguyên tử.
     */
    public function creditResource(int $userId, string $column, int $amount): array
    {
        $column = $this->assertResourceColumn($column);
        $amount = $this->assertPositiveOrZero($amount);
        $row = $this->lock($userId);
        $before = (int) $row->{$column};

        DB::table('users')
            ->where('id', $userId)
            ->update([$column => DB::raw($column . ' + ' . $amount)]);

        return ['before' => $before, 'after' => $before + $amount];
    }

    /**
     * Cộng tiền nạp: tăng cả balance và total_deposited trong một lần.
     */
    public function creditDeposit(
        int $userId,
        int $amount,
        string $description,
        ?string $referenceId = null,
        string $type = 'deposit'
    ): array {
        $result = $this->credit($userId, $amount, $description, $type, $referenceId);

        if ($amount > 0) {
            DB::table('users')
                ->where('id', $userId)
                ->update(['total_deposited' => DB::raw('total_deposited + ' . $amount)]);
        }

        return $result;
    }

    /**
     * Ghi một dòng lịch sử biến động số dư.
     */
    public function recordTransaction(
        int $userId,
        string $type,
        int $amount,
        int $before,
        int $after,
        string $description,
        ?string $referenceId = null
    ): void {
        $now = now();

        DB::table('money_transactions')->insert([
            'user_id' => $userId,
            'type' => $type,
            'amount' => $amount,
            'balance_before' => $before,
            'balance_after' => $after,
            'description' => $description,
            'reference_id' => $referenceId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function assertInTransaction(): void
    {
        if (DB::transactionLevel() === 0) {
            throw new LogicException(
                'BalanceService phải được gọi bên trong DB transaction, nếu không khóa dòng sẽ bị nhả ngay.'
            );
        }
    }

    private function assertPositiveOrZero(int $amount): int
    {
        if ($amount < 0) {
            throw new LogicException('Số tiền thao tác không được âm: ' . $amount);
        }

        return $amount;
    }

    private function assertResourceColumn(string $column): string
    {
        if (!in_array($column, self::RESOURCE_COLUMNS, true)) {
            throw new LogicException('Cột tài nguyên không hợp lệ: ' . $column);
        }

        return $column;
    }
}
