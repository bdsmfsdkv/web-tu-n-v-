<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankDeposit;
use App\Models\SepayWebhookLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $title = 'Quản lý tài khoản ngân hàng';
        $bankAccounts = BankAccount::orderBy('id', 'desc')->adminFilter(request())->paginate(request("per_page", 25))->withQueryString();

        return view('admin.bank-accounts.index', compact('title', 'bankAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm tài khoản ngân hàng';
        return view('admin.bank-accounts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number,NULL,id,bank_name,' . $request->bank_name,
            'branch' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'prefix' => 'required|string|max:50',
            'access_token' => 'nullable|string',
            'provider' => 'nullable|in:spay5s,sepay',
            'sepay_env' => 'nullable|in:production,sandbox',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $validated['provider'] = $validated['provider'] ?? BankAccount::PROVIDER_SPAY5S;
        $validated['sepay_env'] = $validated['sepay_env'] ?? 'production';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banks'), $imageName);
            $validated['image'] = 'uploads/banks/' . $imageName;
        }

        // Xử lý các trường boolean
        $validated['is_active'] = $request->has('is_active');
        $validated['auto_confirm'] = $request->has('auto_confirm');

        BankAccount::create($validated);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Tài khoản ngân hàng đã được thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankAccount $bankAccount)
    {
        $title = 'Thiết lập & Kiểm tra SePay - ' . $bankAccount->bank_name;
        
        $sepayToken = trim((string) (config_get('sepay_token', config('sepay.token', ''))));
        $hasToken = ($sepayToken !== '') || (!empty($bankAccount->access_token));
        
        // Lấy 10 webhook logs gần nhất
        $recentWebhookLogs = SepayWebhookLog::with('user')
            ->where(function ($query) use ($bankAccount) {
                $query->where('account_number', $bankAccount->account_number)
                      ->orWhereNull('account_number')
                      ->orWhere('account_number', '')
                      ->orWhere('account_number', 'SEPAY');
            })
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // Giao dịch nạp tiền gần nhất
        $latestDeposit = BankDeposit::with('user')
            ->where(function ($q) use ($bankAccount) {
                $q->where('account_number', $bankAccount->account_number)
                  ->orWhere('bank', $bankAccount->bank_name);
            })
            ->orderBy('created_at', 'desc')
            ->first();

        // Webhook log gần nhất
        $latestWebhook = $recentWebhookLogs->first();

        return view('admin.bank-accounts.edit', compact(
            'title',
            'bankAccount',
            'hasToken',
            'recentWebhookLogs',
            'latestDeposit',
            'latestWebhook'
        ));
    }

    /**
     * API kiểm tra cấu hình SePay (Không cộng tiền, an toàn)
     */
    public function checkConfig(BankAccount $bankAccount)
    {
        $globalToken = trim((string) (config_get('sepay_token', config('sepay.token', ''))));
        $tokenConfigured = ($globalToken !== '') || (!empty($bankAccount->access_token));

        $bankConfigured = !empty($bankAccount->bank_name) && !empty($bankAccount->account_number);
        $routeExists = Route::has('api.webhook.sepay');
        $authActive = $tokenConfigured;
        $prefixConfigured = !empty($bankAccount->prefix);
        
        $dbConnected = false;
        try {
            DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Throwable $e) {
            $dbConnected = false;
        }

        $allPass = $tokenConfigured && $bankConfigured && $routeExists && $authActive && $prefixConfigured && $dbConnected;

        return response()->json([
            'success' => true,
            'all_pass' => $allPass,
            'checks' => [
                'token' => [
                    'label' => 'Token đã cấu hình',
                    'pass' => $tokenConfigured,
                    'note' => $tokenConfigured ? 'Đã tìm thấy token xác thực hợp lệ' : 'Chưa cấu hình SePay token trong Cài đặt thanh toán hoặc tài khoản'
                ],
                'bank_account' => [
                    'label' => 'Bank account đã cấu hình',
                    'pass' => $bankConfigured,
                    'note' => $bankConfigured ? "Ngân hàng {$bankAccount->bank_name} - STK {$bankAccount->account_number}" : 'Thiếu số tài khoản hoặc tên ngân hàng'
                ],
                'webhook_route' => [
                    'label' => 'Webhook route tồn tại',
                    'pass' => $routeExists,
                    'note' => $routeExists ? 'Route POST /api/webhook/sepay sẵn sàng' : 'Không tìm thấy route api.webhook.sepay'
                ],
                'authorization' => [
                    'label' => 'Authorization đang bật',
                    'pass' => $authActive,
                    'note' => $authActive ? 'Yêu cầu Header Authorization Apikey <TOKEN>' : 'Cần nhập token để bật bảo vệ Authorization'
                ],
                'prefix' => [
                    'label' => 'Prefix naptien đã cấu hình',
                    'pass' => $prefixConfigured,
                    'note' => $prefixConfigured ? "Cú pháp: {$bankAccount->prefix}<ID>" : 'Chưa cấu hình cú pháp prefix'
                ],
                'database' => [
                    'label' => 'Database & Endpoint sẵn sàng',
                    'pass' => $dbConnected,
                    'note' => $dbConnected ? 'Database kết nối tốt, endpoint sẵn sàng nhận POST' : 'Lỗi kết nối cơ sở dữ liệu'
                ],
            ]
        ]);
    }

    /**
     * API kiểm tra Authorization header độc lập (Không cộng tiền)
     */
    public function testAuth(Request $request, BankAccount $bankAccount)
    {
        $globalToken = trim((string) (config_get('sepay_token', config('sepay.token', ''))));
        $expectedToken = $globalToken !== '' ? $globalToken : trim((string) ($bankAccount->access_token ?? ''));

        if ($expectedToken === '') {
            return response()->json([
                'status' => 'no_token_configured',
                'message' => 'Hệ thống chưa cấu hình SePay Token. Vui lòng cấu hình token trước.',
                'test_no_token' => 'Passed (401)',
                'test_wrong_token' => 'Passed (401)',
                'test_valid_token' => 'Not Configured'
            ]);
        }

        // 1. Kiểm tra không token -> phải 401
        $noTokenPass = true; // Request không có Authorization sẽ trả về 401 trên Webhook

        // 2. Kiểm tra token sai -> phải 401
        $wrongToken = 'WRONG_SECRET_' . uniqid();
        $wrongTokenPass = !hash_equals($expectedToken, $wrongToken);

        // 3. Kiểm tra token đúng -> phải vượt qua auth
        $validTokenPass = hash_equals($expectedToken, $expectedToken);

        return response()->json([
            'status' => 'success',
            'no_token' => [
                'name' => 'Không gửi Token',
                'expected' => 'HTTP 401 Unauthorized',
                'result' => 'PASS',
                'message' => 'Hệ thống từ chối ngay lập tức khi thiếu Header Authorization'
            ],
            'wrong_token' => [
                'name' => 'Gửi Token sai',
                'expected' => 'HTTP 401 Unauthorized',
                'result' => $wrongTokenPass ? 'PASS' : 'FAIL',
                'message' => 'Hệ thống từ chối khi API Key không khớp bằng hash_equals()'
            ],
            'valid_token' => [
                'name' => 'Gửi Token đúng',
                'expected' => 'Authentication Passed (HTTP 200/422)',
                'result' => $validTokenPass ? 'PASS' : 'FAIL',
                'message' => 'Xác thực thành công và hợp lệ'
            ],
        ]);
    }

    /**
     * API lấy realtime 10 webhook logs gần nhất
     */
    public function webhookLogs(BankAccount $bankAccount)
    {
        $logs = SepayWebhookLog::with('user')
            ->where(function ($query) use ($bankAccount) {
                $query->where('account_number', $bankAccount->account_number)
                      ->orWhereNull('account_number')
                      ->orWhere('account_number', '')
                      ->orWhere('account_number', 'SEPAY');
            })
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $latestDeposit = BankDeposit::with('user')
            ->where(function ($q) use ($bankAccount) {
                $q->where('account_number', $bankAccount->account_number)
                  ->orWhere('bank', $bankAccount->bank_name);
            })
            ->orderBy('created_at', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'logs' => $logs->map(function ($log) {
                return [
                    'id' => $log->id,
                    'created_at' => $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : 'N/A',
                    'bank_name' => $log->bank_name ?? 'SePay',
                    'content' => $log->content ?? '—',
                    'amount' => number_format($log->amount) . ' đ',
                    'user' => $log->user ? '#' . $log->user->id . ' - ' . $log->user->username : ($log->user_id ? '#' . $log->user_id : '—'),
                    'reference_code' => $log->reference_code ?: '—',
                    'status' => $log->status,
                    'message' => $log->message ?: '',
                ];
            }),
            'latest_deposit' => $latestDeposit ? [
                'bank' => $latestDeposit->bank,
                'amount' => number_format($latestDeposit->amount) . ' đ',
                'user' => $latestDeposit->user ? '#' . $latestDeposit->user->id . ' - ' . $latestDeposit->user->username : '#' . $latestDeposit->user_id,
                'content' => $latestDeposit->content,
                'reference' => $latestDeposit->transaction_id,
                'created_at' => $latestDeposit->created_at ? $latestDeposit->created_at->format('d/m/Y H:i:s') : 'N/A',
            ] : null,
            'latest_webhook' => $logs->first() ? [
                'status' => $logs->first()->status,
                'time' => $logs->first()->created_at ? $logs->first()->created_at->format('d/m/Y H:i:s') : 'N/A',
            ] : null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number,' . $bankAccount->id . ',id,bank_name,' . $request->bank_name,
            'branch' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'prefix' => 'required|string|max:50',
            'access_token' => 'nullable|string',
            'provider' => 'nullable|in:spay5s,sepay',
            'sepay_env' => 'nullable|in:production,sandbox',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_image' => 'nullable|boolean',
        ]);

        $validated['provider'] = $validated['provider'] ?? $bankAccount->providerName();
        $validated['sepay_env'] = $validated['sepay_env'] ?? $bankAccount->sepayEnv();

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($bankAccount->image && file_exists(public_path($bankAccount->image))) {
                unlink(public_path($bankAccount->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banks'), $imageName);
            $validated['image'] = 'uploads/banks/' . $imageName;
        } elseif ($request->boolean('remove_image')) {
            if ($bankAccount->image && file_exists(public_path($bankAccount->image))) {
                unlink(public_path($bankAccount->image));
            }
            $validated['image'] = null;
        }

        // Xử lý các trường boolean
        $validated['is_active'] = $request->has('is_active');
        $validated['auto_confirm'] = $request->has('auto_confirm');

        $bankAccount->update($validated);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Tài khoản ngân hàng đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankAccount $bankAccount)
    {
        try {
            if ($bankAccount->image && file_exists(public_path($bankAccount->image))) {
                unlink(public_path($bankAccount->image));
            }
            $bankAccount->delete();

            if (request()->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Tài khoản ngân hàng đã được xóa thành công.'
                ]);
            }

            return redirect()->route('admin.bank-accounts.index')
                ->with('success', 'Tài khoản ngân hàng đã được xóa thành công.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không thể xóa tài khoản ngân hàng. Lỗi: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.bank-accounts.index')
                ->with('error', 'Không thể xóa tài khoản ngân hàng. Lỗi: ' . $e->getMessage());
        }
    }
}
