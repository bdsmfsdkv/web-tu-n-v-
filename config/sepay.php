<?php

/*
|--------------------------------------------------------------------------
| Cấu hình SePay API v2
|--------------------------------------------------------------------------
| KHÔNG hard-code token ở đây. Tất cả giá trị nhạy cảm lấy từ .env.
| Tích hợp này là ADD-ON: các tài khoản ngân hàng đang dùng SPAY5S không
| bị ảnh hưởng bởi bất kỳ giá trị nào bên dưới.
*/

return [

    // Bật/tắt toàn bộ tích hợp SePay. false => hệ thống chạy y như trước (SPAY5S).
    'enabled' => env('SEPAY_ENABLED', false),

    // 'sandbox' (test mode) hoặc 'production'.
    'env' => env('SEPAY_ENV', 'sandbox'),

    // Base URL cố định theo môi trường. Dùng để chặn việc gửi token sandbox lên production.
    'base_urls' => [
        'sandbox' => 'https://userapi-sandbox.sepay.vn/v2',
        'production' => 'https://userapi.sepay.vn/v2',
    ],

    // Ghi đè base URL (tùy chọn). Nếu đặt, host phải khớp với môi trường ở trên.
    'base_url' => env('SEPAY_BASE_URL'),

    // Token mặc định dùng cho mọi tài khoản có provider = sepay.
    // Có thể ghi đè riêng từng tài khoản bằng cột bank_accounts.access_token.
    'token' => env('SEPAY_TOKEN'),

    // Tối đa số giao dịch lấy mỗi request.
    'limit' => (int) env('SEPAY_LIMIT', 50),

    // Số trang tối đa quét mỗi lần chạy (chặn vòng lặp vô hạn khi API trả meta lạ).
    'max_pages' => (int) env('SEPAY_MAX_PAGES', 5),

    // Timeout HTTP (giây).
    'timeout' => (int) env('SEPAY_TIMEOUT', 15),
    'connect_timeout' => (int) env('SEPAY_CONNECT_TIMEOUT', 10),

    // Số lần thử lại khi lỗi mạng / 5xx / 429.
    'retries' => (int) env('SEPAY_RETRIES', 2),
    'retry_delay_ms' => (int) env('SEPAY_RETRY_DELAY_MS', 500),

    // Tiền tố cho transaction_id để KHÔNG trùng với mã giao dịch SPAY5S.
    'transaction_id_prefix' => env('SEPAY_TRANSACTION_ID_PREFIX', 'SEPAY-'),

    // Nguồn lấy mã giao dịch: auto (reference_number, fallback id) | reference_number | id
    'transaction_id_source' => env('SEPAY_TRANSACTION_ID_SOURCE', 'auto'),

    // Chỉ nhận giao dịch của đúng số tài khoản đã cấu hình trong bank_accounts.
    'filter_account_number' => (bool) env('SEPAY_FILTER_ACCOUNT_NUMBER', true),

    // Dùng con trỏ since_id (lưu ở cache) thay vì luôn quét N giao dịch mới nhất.
    // Mặc định TẮT: quét lại vẫn an toàn vì transaction_id là PRIMARY KEY.
    'use_since_id' => (bool) env('SEPAY_USE_SINCE_ID', false),

    // Cache store dùng để lưu con trỏ since_id (chỉ dùng khi use_since_id = true).
    'cursor_store' => env('SEPAY_CURSOR_STORE'),

];
