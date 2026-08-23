# Production Audit Final

## Critical Fixed
- **Auto Bank / Fetch Endpoint Isolation**
  - **Root cause:** Khả năng tồn tại public trigger gọi trực tiếp Artisan fetch command.
  - **File:** `routes/api.php`, `routes/web.php`, `app/Console/Kernel.php`
  - **Fix:** Chỉ kích hoạt background qua Laravel Scheduler / Artisan CLI (`php artisan fetch:mb-transactions`) hoặc SePay Webhook có xác thực Bearer token/Apikey và lock transaction. Không expose bất kỳ public fetch trigger nào.
  - **Test:** `SepayWebhookFeatureTest`, `FetchSepayTransactionsTest` passed.

- **Card Deposit Callback Verification & Idempotency**
  - **Root cause:** Callback nạp thẻ chưa xác thực `callback_sign` theo `md5(partner_key + pin + serial)` khi cấu hình partner_key, tiềm ẩn nguy cơ giả lập callback nạp tiền.
  - **File:** `app/Http/Controllers/User/CardDepositController.php`
  - **Fix:** Xác thực `callback_sign` trước khi xử lý, sử dụng `DB::transaction()` và `lockForUpdate()` trên `CardDeposit` và `User`, chỉ cộng tiền đúng 1 lần cho trạng thái `processing`, ghi log `MoneyTransaction` và Affiliate commission atomic.
  - **Test:** `BugFixAuditTest::test_card_deposit_callback_rejects_invalid_signature_when_partner_key_configured`, `BugFixAuditTest::test_card_deposit_callback_idempotency_and_atomic_balance` passed.

- **Lucky Wheel Double-Spend & History Isolation**
  - **Root cause:** Lịch sử chi tiết vòng quay có thể xem chéo nếu thiếu filter `user_id`, và transaction trừ balance cần bảo đảm atomic dưới tải cao.
  - **File:** `app/Http/Controllers/User/LuckyCategoryController.php`, `app/Http/Controllers/User/ProfileController.php`
  - **Fix:** `spin()` khóa user balance qua `lockForUpdate()`, kiểm tra đủ tiền và trừ chi phí trước khi cộng phần thưởng; `getLuckyWheelDetail()` và `luckyWheelHistory()` filter chính xác `Auth::id()`.
  - **Test:** `BugFixAuditTest::test_lucky_wheel_history_isolation_and_atomic_spin` passed.

- **Money Operations & Withdrawal Atomicity**
  - **Root cause:** `WithdrawalController::store()` và `MoneyWithdrawalController::reject()` cập nhật số dư không qua lock, thiếu ghi nhận dòng biến động số dư.
  - **File:** `app/Http/Controllers/User/WithdrawalController.php`, `app/Http/Controllers/Admin/MoneyWithdrawalController.php`, `app/Http/Controllers/User/InstallmentController.php`
  - **Fix:** Bổ sung `lockForUpdate()`, transaction atomicity và `MoneyTransaction` log cho các luồng rút tiền, từ chối hoàn tiền và thanh toán trả góp.
  - **Test:** PHPUnit test suite passed.

## High Fixed
- **BankDeposit Schema Alignment & Idempotency**
  - **Root cause:** Bảng `bank_deposits` sử dụng primary key `transaction_id` (string), không có cột `status` và `id` auto-increment. Code cũ gọi `updateOrCreate` với field `status` không có trong schema.
  - **File:** `app/Console/Commands/FetchMBTransactions.php`, `app/Http/Controllers/Api/SepayWebhookController.php`, `app/Http/Controllers/User/ProfileController.php`, `resources/views/user/profile/deposit-atm.blade.php`
  - **Fix:** Xóa bỏ tham chiếu `status` trên `BankDeposit`, truy vấn và phân biệt bản ghi theo `transaction_id` duy nhất, thêm lock chống trùng lặp.
  - **Test:** `FetchSepayTransactionsTest`, `SepayWebhookFeatureTest` passed.

- **Admin Game Category Deletion & Filesystem Cleanup**
  - **Root cause:** Xóa danh mục khi còn tài khoản con hoặc xóa ảnh trên filesystem trước khi DB transaction hoàn tất có thể gây mất đồng bộ.
  - **File:** `app/Http/Controllers/Admin/GameCategoryController.php`
  - **Fix:** Chặn xóa vật lý danh mục nếu còn tài khoản game liên quan, thực hiện xóa liên kết flash sale và xóa file trên storage an toàn trong transaction.
  - **Test:** `BugFixAuditTest::test_admin_cannot_delete_game_category_with_existing_accounts` passed.

## Medium Fixed
- **Route Duplication Clean-up**
  - **Root cause:** `routes/web.php` require `routes/admin.php` trong khi `RouteServiceProvider` đã đăng ký group `routes/admin.php`.
  - **File:** `routes/web.php`
  - **Fix:** Bỏ `require admin.php` trong `web.php`, tránh duplicate route registration và tối ưu tốc độ `route:cache`.
  - **Test:** `php artisan route:list` passed không có lỗi xung đột.

- **Flash Notification & Polling Double Display Prevention**
  - **Root cause:** Polling kiểm tra ATM nạp tiền có thể trả lại giao dịch cũ nếu không truyền `since` hoặc `after_id` hợp lệ.
  - **File:** `app/Http/Controllers/User/ProfileController.php`, `resources/views/user/profile/deposit-atm.blade.php`
  - **Fix:** `checkDepositAtm` chỉ trả kết quả khi có giao dịch mới hơn `after_id` (transaction_id) hoặc `since`, ngăn ngừa popup nạp tiền lặp lại.

- **Clean Debug Statements & Backdoor Checks**
  - **Root cause:** Tồn tại `// dd(...)` thừa trong controller.
  - **File:** `app/Http/Controllers/User/CardDepositController.php`, `app/Http/Controllers/Auth/FacebookController.php`
  - **Fix:** Đã dọn dẹp toàn bộ. Quét toàn bộ repo không còn `loginUsingId(1)` hay backdoor login.

## Environment Issues
- **PHP extension `fileinfo` (finfo):**
  - Môi trường XAMPP hiện tại đã bật `fileinfo` (`ext-fileinfo` active).
  - Code `UploadHelper` đã có sẵn cơ chế bắt exception và fallback thông báo rõ ràng cho sysadmin nếu triển khai trên server chưa bật `extension=fileinfo` trong `php.ini`.

## Database Changes
- Giữ nguyên schema production hiện tại, không drop hay sửa migration cũ.
- Đồng bộ toàn bộ Eloquent Model và Controller khớp với schema thực tế của `bank_deposits`, `card_deposits`, `lucky_wheel_histories`.

## Security Changes
- Xác thực chữ ký `callback_sign` thẻ cào.
- Khóa bi quan (`lockForUpdate`) toàn bộ thao tác số dư người dùng (Nạp thẻ, SePay, USDT, Trả góp, Rút tiền, Quay vòng quay).
- Phân quyền và filter dữ liệu theo `Auth::id()` ngăn IDOR/data leakage.

## Tests Executed
- `php artisan test`: **50 tests passed (138 assertions)**.
- `php -l`: Syntax check 100% passed trên toàn bộ files đã chỉnh sửa.
- `php artisan optimize:clear` & `php artisan route:list`: Pass hoàn toàn.

## Remaining Issues
- Không còn critical/high blocker nào trong code base.

## Deployment Checklist
1. Chạy `php artisan optimize:clear` và `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`.
2. Đảm bảo cron job chạy `php artisan schedule:run` mỗi phút.
3. Kiểm tra cấu hình `payment.card.partner_id`, `payment.card.partner_key`, `sepay_token` trong trang Admin Settings.
