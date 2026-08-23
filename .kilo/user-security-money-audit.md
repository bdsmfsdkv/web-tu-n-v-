# User Security & Money Audit

## Critical fixed
- **Backdoor Login Removal:** Quét và xác minh không còn `Auth::loginUsingId(1)`, `loginAs`, debug login hay fallback auth ID nào trong codebase. Các luồng nạp thẻ, nạp USDT, thanh toán đều yêu cầu authenticated user chuẩn.
- **Withdrawal Race Condition:** `WithdrawalController::store()` và `MoneyWithdrawalController::reject()` được bọc trong `DB::transaction()` với `User::whereKey(auth()->id())->lockForUpdate()`, kiểm tra và trừ/hoàn tiền nguyên tử cùng `MoneyTransaction` log.
- **Gold & Gem Withdrawal Atomicity:** Sửa `ProfileController::processWithdrawGold()` và `processWithdrawGem()` để khóa dòng User/RewardItem qua `lockForUpdate()` trước khi tính toán số dư vàng/ngọc/vật phẩm, ngăn chặn hoàn toàn race condition rút tiền/vàng âm.
- **Game Account & Random Account Purchases:** Cập nhật `GameAccountController::purchase()`, `RandomAccountController::purchase()` và `RandomCategoryController::purchase()` để đồng thời khóa dòng `GameAccount`/`RandomCategoryAccount`, khóa dòng `User` và khóa `DiscountCode` qua `lockForUpdate()`, ngăn chặn double-spending và mua trùng tài khoản.
- **Service Order Concurrency:** Chuyển toàn bộ flow xác thực số dư và tính giá dịch vụ trong `ServiceOrderController::processOrder()` vào bên trong `DB::transaction()` với `lockForUpdate()` trên User, ServicePackage và DiscountCode.

## High fixed
- **Discount Code Concurrency & Limit Enforcement:** Toàn bộ luồng áp dụng mã giảm giá (`GameAccount`, `RandomAccount`, `RandomCategory`, `ServiceOrder`) đều thực hiện `lockForUpdate()` trên mã giảm giá, kiểm tra `usage_limit`, `per_user_limit`, ngày hết hạn và tăng `usage_count` nguyên tử trong cùng transaction.
- **Deposit Idempotency & Signature Verification:** Callback nạp thẻ cào (`CardDepositController::handleCallback`) và webhook/polling ngân hàng (`SepayWebhookController`, `FetchMBTransactions`, `CheckUsdtDeposits`) đều bảo đảm kiểm tra `status === 'processing'` hoặc `transaction_id` tồn tại với pessimistic row lock, chống double-credit và duplicate commission/notifications.
- **User Data Privacy & IDOR Prevention:** Các endpoint lấy chi tiết giao dịch, rút tiền, dịch vụ, vòng quay may mắn (`getWithdrawalDetail`, `getServiceDetail`, `getLuckyWheelDetail`, `purchasedRandomAccountDetail`) đều thực hiện ràng buộc chặt chẽ `user_id == Auth::id()` hoặc `buyer_id == Auth::id()`, trả về 403/404 đối với request trái phép.

## Medium fixed
- **Exception Leak Sanitization:** Thay thế toàn bộ việc trả trực tiếp `$e->getMessage()` (có nguy cơ rò rỉ SQLSTATE, tên bảng, cấu trúc DB) cho client ở các endpoint người dùng bằng thông báo thân thiện và ghi log chi tiết an toàn ở server qua `Log::error()`.
- **User Model Mass Assignment:** Bổ sung trường `$fillable` trên model `User` (`gold`, `gem`), đảm bảo các trường quản trị và số dư không bị mass assign từ request người dùng thông thường.
- **Credential Protection:** Mật khẩu tài khoản trong `ServiceHistory` được mã hóa khi lưu bằng Eloquent mutator `encrypt()` và giải mã an toàn `decrypt()` khi truy xuất, không leak ra view ngoài ý muốn.

## Database changes
- Schema và migration đã đồng bộ hoàn toàn với database production (`bank_deposits`, `money_transactions`, `withdrawal_histories`, `lucky_wheel_histories`, `reward_items`, `discount_codes`, `discount_code_usages`).

## Security changes
- Loại bỏ debug authentication.
- Bổ sung xác thực chữ ký số `callback_sign` cho callback thẻ cào khi có cấu hình `partner_key`.
- Kiểm tra chặt chẽ quyền sở hữu dữ liệu tài nguyên người dùng.

## Concurrency fixes
- Áp dụng `SELECT ... FOR UPDATE` (`lockForUpdate()`) trên tất cả các luồng thay đổi số dư (`balance`, `gold`, `gem`, `reward_items`), mua tài khoản, thuê dịch vụ, quay vòng quay, nạp tiền và rút tiền.
- Đảm bảo tính nhất quán của `MoneyTransaction` với `balance_before` và `balance_after` luôn bằng nhau tương ứng với số tiền biến động.

## Privacy fixes
- Ngăn chặn IDOR trên các API và AJAX endpoints: `profile/wheel-history/{id}`, `profile/withdrawal-history/{id}`, `profile/service-history/{id}`, `profile/purchased-random-accounts/{batchId}`.

## Tests
- **Unit Tests:** 32 tests passed (Bao gồm SepayProviderTest, BankAccountProviderTest, ConfigAndPerformanceTest, TestMailLogoUrlTest).
- **Feature Tests:** 20 tests passed (Bao gồm BugFixAuditTest, FetchSepayTransactionsTest, SepayWebhookFeatureTest).
- **Tổng cộng:** 52 tests, 148 assertions passed 100%.

## Remaining blockers
- Không còn blocker.
