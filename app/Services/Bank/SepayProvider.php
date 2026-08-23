<?php

namespace App\Services\Bank;

use App\Models\BankAccount;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Adapter cho SePay User API v2.
 *
 * Nhiệm vụ duy nhất: gọi GET {base}/transactions và chuẩn hóa kết quả về
 * đúng format mà FetchMBTransactions đang dùng:
 *
 *   ['magiaodich' => string, 'sotien' => float, 'noidung' => string]
 *
 * Provider KHÔNG cộng tiền, KHÔNG ghi database giao dịch. Toàn bộ logic
 * cộng tiền / chống trùng vẫn nằm ở command như trước.
 */
class SepayProvider
{
    public const NAME = 'sepay';

    /** Các giá trị transfer_type được coi là tiền vào. */
    protected const INCOMING_TYPES = ['in', 'credit', 'money_in', 'incoming', 'deposit'];

    protected array $config;

    public function __construct(?array $config = null)
    {
        if ($config !== null) {
            $this->config = $config;
        } else {
            $baseConfig = (array) config('sepay', []);
            // Ưu tiên config lưu trong Database (từ Admin), fallback về config/sepay.php (.env)
            $dbEnabled = function_exists('config_get') ? config_get('sepay_enabled', null) : null;
            if ($dbEnabled !== null) {
                $baseConfig['enabled'] = (bool) $dbEnabled;
            }

            $dbToken = function_exists('config_get') ? config_get('sepay_token', null) : null;
            if ($dbToken !== null && trim((string) $dbToken) !== '') {
                $baseConfig['token'] = trim((string) $dbToken);
            }

            $dbEnv = function_exists('config_get') ? config_get('sepay_env', null) : null;
            if ($dbEnv !== null && trim((string) $dbEnv) !== '') {
                $baseConfig['env'] = trim((string) $dbEnv);
            }

            $this->config = $baseConfig;
        }
    }

    /**
     * Tích hợp SePay có được bật hay không (SEPAY_ENABLED).
     */
    public function isEnabled(): bool
    {
        return (bool) ($this->config['enabled'] ?? false);
    }

    /**
     * Môi trường đang dùng: sandbox | production (ưu tiên theo tài khoản nếu có cấu hình).
     */
    public function environment(?BankAccount $bankAccount = null): string
    {
        $accEnv = strtolower(trim((string) ($bankAccount->sepay_env ?? '')));
        if ($accEnv === 'sandbox' || $accEnv === 'production') {
            return $accEnv;
        }

        $env = strtolower(trim((string) ($this->config['env'] ?? 'sandbox')));

        return $env === 'production' ? 'production' : 'sandbox';
    }

    public function isSandbox(?BankAccount $bankAccount = null): bool
    {
        return $this->environment($bankAccount) === 'sandbox';
    }

    /**
     * Base URL đã được kiểm tra khớp môi trường của tài khoản.
     */
    public function baseUrl(?BankAccount $bankAccount = null): string
    {
        $env = $this->environment($bankAccount);
        $expected = rtrim((string) ($this->config['base_urls'][$env] ?? ''), '/');

        if ($expected === '') {
            throw new SepayApiException("Thiếu base URL cho môi trường SePay '{$env}'.");
        }

        $override = trim((string) ($this->config['base_url'] ?? ''));

        if ($override === '') {
            return $expected;
        }

        $override = rtrim($override, '/');
        $overrideHost = strtolower((string) parse_url($override, PHP_URL_HOST));
        $expectedHost = strtolower((string) parse_url($expected, PHP_URL_HOST));

        if ($overrideHost !== $expectedHost) {
            throw new SepayApiException(
                "SEPAY_BASE_URL (host: {$overrideHost}) không khớp SEPAY_ENV={$env} (host mong đợi: {$expectedHost}). "
                . 'Không dùng token sandbox với production và ngược lại.'
            );
        }

        return $override;
    }

    /**
     * Token dùng cho tài khoản: ưu tiên token riêng của BankAccount, fallback SEPAY_TOKEN.
     * Không bao giờ log / trả về giá trị này ra output.
     */
    public function tokenFor(?BankAccount $bankAccount = null): string
    {
        $token = trim((string) ($bankAccount->access_token ?? ''));

        if ($token === '') {
            $token = trim((string) ($this->config['token'] ?? ''));
        }

        if ($token === '') {
            throw new SepayApiException('Chưa cấu hình SePay token (SEPAY_TOKEN hoặc access_token của tài khoản).');
        }

        return $token;
    }

    /**
     * Lấy danh sách giao dịch tiền vào của một tài khoản, đã chuẩn hóa.
     *
     * @return array<int, array{magiaodich: string, sotien: float, noidung: string, sepay_id: string|null, sepay_date: string|null}>
     *
     * @throws SepayApiException
     */
    public function fetchTransactions(BankAccount $bankAccount): array
    {
        $token = $this->tokenFor($bankAccount);
        $baseUrl = $this->baseUrl($bankAccount);
        $limit = max(1, (int) ($this->config['limit'] ?? 50));
        $maxPages = max(1, (int) ($this->config['max_pages'] ?? 5));
        $sinceId = $this->sinceIdFor($bankAccount);

        $raw = [];
        $page = 1;

        do {
            $query = ['limit' => $limit, 'page' => $page];

            if ($sinceId !== null) {
                $query['since_id'] = $sinceId;
            }

            $payload = $this->request($baseUrl . '/transactions', $query, $token);
            $items = $this->extractData($payload);
            $raw = array_merge($raw, $items);

            $hasMore = count($items) > 0
                && $page < $maxPages
                && $this->hasNextPage($payload, $page, count($items), $limit);

            $page++;
        } while ($hasMore);

        $normalized = $this->normalizeMany($raw, $bankAccount);

        return $normalized;
    }

    /**
     * Gọi API và trả về payload đã decode.
     *
     * @throws SepayApiException
     */
    protected function request(string $url, array $query, string $token): array
    {
        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->connectTimeout(max(1, (int) ($this->config['connect_timeout'] ?? 10)))
                ->timeout(max(1, (int) ($this->config['timeout'] ?? 15)))
                ->retry(
                    max(1, (int) ($this->config['retries'] ?? 2)),
                    max(0, (int) ($this->config['retry_delay_ms'] ?? 500)),
                    function ($exception, $request = null) {
                        if ($exception instanceof ConnectionException) {
                            return true;
                        }

                        $status = method_exists($exception, 'response') && $exception->response
                            ? $exception->response->status()
                            : null;

                        return $status === 429 || ($status !== null && $status >= 500);
                    },
                    throw: false
                )
                ->get($url, $query);
        } catch (ConnectionException $e) {
            throw new SepayApiException('Không kết nối được SePay API (timeout hoặc lỗi mạng).');
        }

        if (!$response->successful()) {
            throw new SepayApiException($this->describeHttpError($response), $response->status());
        }

        $payload = $response->json();

        if (!is_array($payload)) {
            throw new SepayApiException('SePay API trả về dữ liệu không phải JSON hợp lệ.', $response->status());
        }

        $status = $payload['status'] ?? null;
        $isFailure = ($status === 'error' || $status === 'fail' || $status === false)
            || (is_numeric($status) && (int) $status >= 400);

        if ($isFailure) {
            $message = (string) ($payload['message'] ?? $payload['error'] ?? 'Unknown error');
            throw new SepayApiException('SePay API báo lỗi: ' . $this->sanitize($message), $response->status());
        }

        return $payload;
    }

    /**
     * Diễn giải lỗi HTTP thành message an toàn (không chứa token).
     */
    protected function describeHttpError(Response $response): string
    {
        $status = $response->status();

        $known = [
            400 => 'Request không hợp lệ (400).',
            401 => 'Token SePay không hợp lệ hoặc đã hết hạn (401). Kiểm tra SEPAY_TOKEN và SEPAY_ENV.',
            403 => 'Token SePay không có quyền truy cập endpoint này (403).',
            404 => 'Endpoint SePay không tồn tại (404). Kiểm tra SEPAY_BASE_URL.',
            422 => 'Tham số gửi lên SePay không hợp lệ (422).',
            429 => 'Bị SePay giới hạn tần suất (429). Sẽ thử lại ở lần quét sau.',
        ];

        if (isset($known[$status])) {
            return $known[$status];
        }

        if ($status >= 500) {
            return "SePay API đang lỗi phía server ({$status}). Sẽ thử lại ở lần quét sau.";
        }

        return "SePay API trả về HTTP {$status}.";
    }

    /**
     * Lấy mảng giao dịch từ response. Không giả định response là raw array.
     */
    protected function extractData(array $payload): array
    {
        $candidates = [
            $payload['data'] ?? null,
            $payload['transactions'] ?? null,
            $payload['data']['transactions'] ?? null,
        ];

        foreach ($candidates as $candidate) {
            if (is_array($candidate) && $this->isListOfRows($candidate)) {
                return $candidate;
            }
        }

        // Trường hợp API trả về thẳng một list (không có wrapper).
        if ($this->isListOfRows($payload)) {
            return $payload;
        }

        return [];
    }

    protected function isListOfRows(array $value): bool
    {
        if ($value === []) {
            return true;
        }

        foreach ($value as $key => $row) {
            if (!is_int($key) || !is_array($row)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Đọc meta pagination để biết còn trang tiếp theo hay không.
     */
    protected function hasNextPage(array $payload, int $currentPage, int $returned, int $limit): bool
    {
        $meta = $payload['meta'] ?? [];
        $pagination = is_array($meta) ? ($meta['pagination'] ?? $meta) : [];

        if (is_array($pagination) && $pagination !== []) {
            $totalPages = $pagination['total_pages'] ?? $pagination['last_page'] ?? null;
            $current = $pagination['current_page'] ?? $pagination['page'] ?? $currentPage;

            if ($totalPages !== null) {
                return (int) $current < (int) $totalPages;
            }

            $total = $pagination['total'] ?? $pagination['count_total'] ?? null;
            $perPage = (int) ($pagination['per_page'] ?? $pagination['limit'] ?? $limit);

            if ($total !== null && $perPage > 0) {
                return ((int) $current * $perPage) < (int) $total;
            }
        }

        // Không có meta đáng tin: chỉ sang trang tiếp nếu trang này đầy.
        return $returned >= $limit;
    }

    /**
     * Chuẩn hóa nhiều giao dịch, chỉ giữ tiền vào của đúng số tài khoản.
     *
     * @return array<int, array{magiaodich: string, sotien: float, noidung: string, sepay_id: string|null, sepay_date: string|null}>
     */
    public function normalizeMany(array $rows, ?BankAccount $bankAccount = null): array
    {
        $result = [];
        $seen = [];

        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }

            if (!$this->belongsToAccount($row, $bankAccount)) {
                continue;
            }

            $normalized = $this->normalizeOne($row);

            if ($normalized === null) {
                continue;
            }

            // Chống trùng ngay trong cùng một response.
            if (isset($seen[$normalized['magiaodich']])) {
                continue;
            }

            $seen[$normalized['magiaodich']] = true;
            $result[] = $normalized;
        }

        return $result;
    }

    /**
     * Chuẩn hóa 1 giao dịch SePay. Trả về null nếu không phải tiền vào hoặc thiếu mã.
     *
     * @return array{magiaodich: string, sotien: float, noidung: string, sepay_id: string|null, sepay_date: string|null}|null
     */
    public function normalizeOne(array $row): ?array
    {
        $amountIn = $this->toAmount($row['amount_in'] ?? null);
        $amountOut = $this->toAmount($row['amount_out'] ?? null);
        $type = strtolower(trim((string) ($row['transfer_type'] ?? '')));

        // Chỉ xử lý tiền vào.
        if ($amountIn <= 0) {
            return null;
        }

        if ($amountOut > 0) {
            return null;
        }

        if ($type !== '' && !in_array($type, self::INCOMING_TYPES, true)) {
            return null;
        }

        $transactionId = $this->resolveTransactionId($row);

        if ($transactionId === null) {
            return null;
        }

        return [
            'magiaodich' => $transactionId,
            'sotien' => $amountIn,
            'noidung' => trim((string) ($row['transaction_content'] ?? $row['content'] ?? '')),
            'sepay_id' => isset($row['id']) ? (string) $row['id'] : null,
            'sepay_date' => isset($row['transaction_date']) ? (string) $row['transaction_date'] : null,
        ];
    }

    /**
     * Mã giao dịch dùng làm bank_deposits.transaction_id (PRIMARY KEY).
     *
     * Có prefix để tuyệt đối không đụng vào namespace mã giao dịch của SPAY5S.
     */
    public function resolveTransactionId(array $row): ?string
    {
        $source = strtolower(trim((string) ($this->config['transaction_id_source'] ?? 'auto')));
        $reference = trim((string) ($row['reference_number'] ?? ''));
        $id = trim((string) ($row['id'] ?? ''));

        $value = match ($source) {
            'id' => $id,
            'reference_number' => $reference,
            default => $reference !== '' ? $reference : $id,
        };

        if ($value === '') {
            return null;
        }

        $prefix = (string) ($this->config['transaction_id_prefix'] ?? 'SEPAY-');
        $transactionId = $prefix . $value;

        // bank_deposits.transaction_id là varchar(255).
        return mb_substr($transactionId, 0, 255);
    }

    /**
     * Giao dịch có thuộc tài khoản đang quét hay không.
     */
    protected function belongsToAccount(array $row, ?BankAccount $bankAccount): bool
    {
        if ($bankAccount === null || !($this->config['filter_account_number'] ?? true)) {
            return true;
        }

        $expected = preg_replace('/\D+/', '', (string) $bankAccount->account_number);

        if ($expected === '' || $expected === null) {
            return true;
        }

        $actual = preg_replace('/\D+/', '', (string) ($row['account_number'] ?? ''));

        // Không có account_number trong response => không loại bỏ.
        if ($actual === '' || $actual === null) {
            return true;
        }

        return $actual === $expected;
    }

    protected function toAmount(mixed $value): float
    {
        if ($value === null || $value === '') {
            return 0.0;
        }

        if (is_string($value)) {
            $value = str_replace([',', ' '], '', $value);
        }

        return is_numeric($value) ? (float) $value : 0.0;
    }

    /* ------------------------------------------------------------------
     | since_id cursor (tùy chọn, mặc định tắt)
     |------------------------------------------------------------------*/

    protected function cursorKey(BankAccount $bankAccount): string
    {
        return 'sepay:since_id:' . $this->environment() . ':' . $bankAccount->getKey();
    }

    protected function cache()
    {
        $store = $this->config['cursor_store'] ?? null;

        return $store ? Cache::store($store) : Cache::store();
    }

    public function sinceIdFor(BankAccount $bankAccount): ?string
    {
        if (!($this->config['use_since_id'] ?? false)) {
            return null;
        }

        try {
            $value = $this->cache()->get($this->cursorKey($bankAccount));
        } catch (\Throwable $e) {
            Log::warning('SePay: không đọc được since_id cursor.', ['reason' => $e->getMessage()]);

            return null;
        }

        return ($value === null || $value === '') ? null : (string) $value;
    }

    /**
     * Chỉ được gọi SAU KHI toàn bộ giao dịch của lần quét đã xử lý thành công.
     */
    public function rememberSinceId(BankAccount $bankAccount, array $normalizedTransactions): void
    {
        if (!($this->config['use_since_id'] ?? false) || $normalizedTransactions === []) {
            return;
        }

        $maxId = null;

        foreach ($normalizedTransactions as $transaction) {
            $id = $transaction['sepay_id'] ?? null;

            if ($id === null || !is_numeric($id)) {
                continue;
            }

            if ($maxId === null || (int) $id > (int) $maxId) {
                $maxId = (string) $id;
            }
        }

        if ($maxId === null) {
            return;
        }

        try {
            $this->cache()->forever($this->cursorKey($bankAccount), $maxId);
        } catch (\Throwable $e) {
            // Không cập nhật được cursor thì lần sau quét lại từ đầu:
            // an toàn vì transaction_id là PRIMARY KEY nên không cộng tiền 2 lần.
            Log::warning('SePay: không lưu được since_id cursor.', ['reason' => $e->getMessage()]);
        }
    }

    /**
     * Loại bỏ mọi thứ trông giống token khỏi message trước khi log.
     */
    protected function sanitize(string $message): string
    {
        $message = preg_replace('/Bearer\s+\S+/i', 'Bearer ***', $message) ?? $message;
        $message = preg_replace('/(token|access_token|authorization)\s*[=:]\s*\S+/i', '$1=***', $message) ?? $message;

        return mb_substr($message, 0, 300);
    }
}
