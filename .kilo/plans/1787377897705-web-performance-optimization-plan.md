# Kế Hoạch Tối Ưu Tốc Độ Tải Trang Web (Web Performance Optimization)

## 1. Nguyên Nhân Khiến Web Load Lâu (Root Cause Analysis)

### A. Phía Backend / Database (Server-side bottlenecks)
1. **Truy vấn Database trang chủ nặng & chưa có Database Index tối ưu**:
   - `HomeController@index` thực hiện nhiều câu truy vấn con nặng (Subqueries & GROUP BY trên `game_accounts`, `random_category_accounts`, `service_histories`), tính tổng (`SUM`), đếm (`COUNT`), tìm giá nhỏ nhất (`MIN`).
   - Bảng `game_accounts` và `random_category_accounts` thiếu chỉ mục (index) phức hợp trên các cột thường xuyên lọc / gom nhóm: `(game_category_id, status, price)` và `(random_category_id, status, price)`.
   - Lọc bảng `money_transactions` theo tháng/năm bằng hàm `whereMonth('created_at', ...)` và `whereYear(...)` khiến MySQL không sử dụng được index của cột `created_at` (Full Table Scan).
   - Chưa áp dụng bộ nhớ đệm (Cache) cho dữ liệu trang chủ ít biến động (như danh sách GameGroups, Categories thống kê, Services, Vòng quay may mắn).

2. **Cấu hình Cache Driver trong `.env` đang ở mức cơ bản**:
   - `CACHE_DRIVER=file` và `SESSION_DRIVER=file` đọc ghi file I/O trên ổ đĩa cục bộ.

3. **Cấu hình Config helper (`config_get`) gọi đơn lẻ từng key**:
   - Trên mỗi lượt render Blade, hàng chục lượt gọi `config_get('key')` truy vấn riêng lẻ vào Cache/DB thay vì tải gộp trước tất cả settings một lần vào bộ nhớ.

---

### B. Phía Frontend / Assets (Client-side bottlenecks)
1. **Nhiều thư viện CDN bên ngoài chặn render (Render-Blocking External Resources)**:
   - File CSS và JS tải từ nhiều nguồn bên ngoài: `fonts.googleapis.com`, `cdn.jsdelivr.net` (Ant Design CSS nặng ~300KB+), `cdnjs.cloudflare.com` (FontAwesome 6), `code.jquery.com`, `code.iconify.design`, `translate.google.com`, `static.cloudflareinsights.com`.
   - Chưa dùng thuộc tính tải bất đồng bộ (`defer`/`async`) hoặc tải font tối ưu (`font-display: swap`).
   - CDN nước ngoài có độ trễ kết nối (DNS lookup + TLS Handshake) cao hơn khi truy cập từ Việt Nam.

2. **Chưa có Lazy Loading cho hình ảnh banner, thumbnail danh mục**:
   - Trang chủ và các trang danh mục tải toàn bộ ảnh thumbnail cùng lúc, làm nghẽn băng thông tải trang.
   - Chưa khai báo thuộc tính `loading="lazy"` và `decoding="async"` trên toàn bộ ảnh sản phẩm / avatar.

3. **Preloader nhân tạo và tài nguyên đè nhau**:
   - Có đoạn mã preloader dùng `setTimeout` chờ DOMContentLoaded rồi mới ẩn, gây cảm giác web bị khựng/chậm trễ.

---

## 2. Kế Hoạch Tối Ưu Chi Tiết (Actionable Optimization Plan)

### Giai đoạn 1: Tối ưu Database & Backend Query
- [ ] **Tạo Migration bổ sung Index**:
  - Thêm composite index vào `game_accounts`: `(game_category_id, status, price)`.
  - Thêm composite index vào `random_category_accounts`: `(random_category_id, status, price)`.
  - Thêm index vào `money_transactions`: `(type, created_at, user_id)`.
  - Thêm index vào `service_histories`: `(game_service_id)`.
  - Thêm index vào `lucky_wheel_histories`: `(lucky_wheel_id)`.
- [ ] **Tối ưu câu truy vấn trong `HomeController@index`**:
  - Viết lại câu truy vấn `topDepositors`: thay `whereMonth`/`whereYear` bằng `whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])` để tận dụng index của `created_at`.
  - Đưa toàn bộ block dữ liệu tĩnh/bán tĩnh của trang chủ vào `Cache::remember` với thời gian thích hợp (ví dụ 60s - 300s, tự động xóa cache khi Admin cập nhật danh mục).
- [ ] **Tối ưu hóa `config_get`**:
  - Khởi tạo nạp toàn bộ cấu hình vào static array / runtime cache ngay trong Service Provider để các hàm `config_get` đọc trực tiếp từ memory 0ms.

---

### Giai đoạn 2: Tối ưu Frontend & Tốc độ Tải Assets
- [ ] **Tối ưu CSS & CDN bên ngoài trong `head.blade.php`**:
  - Bổ sung `dns-prefetch` & `preconnect` cho các CDN trọng yếu.
  - Tải Google Translate JS theo dạng lazy/on-demand (chỉ tải khi người dùng bấm chọn ngôn ngữ, không tải mặc định chặn web).
  - Tải Ant Design CSS tối giản hoặc chỉ import các component thực tế cần dùng thay vì file full bundle.
  - Thêm `loading="lazy"` và `decoding="async"` vào toàn bộ thẻ `<img>` trang chủ, danh mục, tài khoản.
- [ ] **Tối ưu hóa Preloader**:
  - Loại bỏ các khoảng delay `setTimeout` không cần thiết để trang web hiển thị nội dung ngay khi DOM sẵn sàng.

---

### Giai đoạn 3: Bật Cache Laravel & Tinh Chỉnh Môi Trường (Production Optimization)
- [ ] Chạy các lệnh tối ưu hóa của Laravel Framework:
  - `php artisan config:cache`
  - `php artisan route:cache`
  - `php artisan view:cache`
- [ ] Đảm bảo HTTP Response headers hỗ trợ Browser Caching cho static assets (CSS, JS, WebP/PNG).

---

## 3. Kế Hoạch Kiểm Thử & Đo Lường (Validation Plan)
- [ ] Đo thời gian phản hồi máy chủ (TTFB - Time To First Byte) trước và sau khi tối ưu.
- [ ] Kiểm tra số lượng SQL queries trang chủ bằng Laravel Telescope hoặc debug log (giảm từ 15-20 queries xuống còn 1-2 queries khi có Cache).
- [ ] Kiểm tra điểm số Google PageSpeed Insights / Lighthouse và tốc độ tải thực tế trên trình duyệt.
- [ ] Đảm bảo tất cả tính năng lọc giá, hiển thị Flash Sale, Top nạp tiền vẫn hoạt động chính xác 100%.
