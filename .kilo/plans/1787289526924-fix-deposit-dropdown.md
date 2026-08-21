# Fix dropdown Nạp Tiền

## Goal
Dropdown Nạp Tiền desktop luôn nền trắng, chỉ mở từ nút thật, chỉ chứa Nạp thẻ cào và Ngân hàng / QR. Không ảnh hưởng Trang Chủ, Danh Mục, mobile.

## Root cause
`resources/views/layouts/user/footer.blade.php` chứa nhiều rule chung cho `.nav-mega-dropdown > .mega-menu`, cùng rule cũ full-width và dark-theme. Các rule này chồng lên `.deposit-mega-menu`, tạo nền xám/transparent và vùng hover rộng.

## Plan
1. Trong `resources/views/layouts/user/footer.blade.php`, xóa các rule Nạp Tiền cũ, trùng lặp tại vùng cuối style inline. Giữ rule chung của Danh Mục nguyên vẹn.
2. Thêm một block desktop cuối cùng, chỉ chọn `.nav-mega-dropdown:has(> .deposit-mega-menu)`:
   - `position: relative`; `li` không nhận pointer events.
   - Chỉ `.nav-menu-trigger` và `.deposit-mega-menu` nhận pointer events.
   - Xóa pseudo-element bridge của trigger/panel.
   - `.deposit-mega-menu` là `position: absolute`, ngay dưới trigger, `width: max-content`, `background: #fff`, `border: 1px solid #e5e7eb`, `box-shadow` nhẹ, `z-index: 1100`.
   - Khi đóng: `display: block`, `opacity: 0`, `visibility: hidden`, `pointer-events: none`; không dùng `[hidden]` để CSS hover hoạt động.
   - Khi `:has(> .nav-menu-trigger:hover)` hoặc `:has(> .deposit-mega-menu:hover)`: hiện panel. Không dùng `li:hover`, `focus-within`, hay bridge.
   - Ép `background: #fff` cho panel, container, grid, hai item trong light/dark theme. Dark mode cho Nạp Tiền vẫn trắng theo yêu cầu.
   - Item chỉ nhận hover bên trong panel; trạng thái hover `#fff7f7`, không tạo vùng xám bên ngoài.
3. Trong `resources/views/layouts/user/header.blade.php`, giữ đúng 2 liên kết: Nạp thẻ cào và Ngân hàng / QR. Không đổi button Nạp Tiền, Danh Mục, Trang Chủ.
4. Rà `public/js/app.js`: state click hiện tại được phép mở menu. Desktop hover phải thắng state cũ hoặc state cũ phải không tạo panel full-width. Không đổi mobile accordion.
5. Chạy kiểm tra:
   - `C:\xampp\php\php.exe -l resources\views\layouts\user\header.blade.php`
   - `C:\xampp\php\php.exe -l resources\views\layouts\user\footer.blade.php`
   - `C:\xampp\php\php.exe artisan view:cache`
   - `git diff --check`
6. Browser desktop >=1200px: kiểm tra điểm ngoài nút Nạp Tiền không mở menu; rê từ nút vào panel giữ menu; rê vào từng item chỉ đổi item; panel trắng ở light/dark; Trang Chủ và Danh Mục không đổi. Browser mobile <1200px: Nạp Tiền vẫn mở accordion qua click.

## Risks
- CSS inline legacy có `!important`; block Nạp Tiền cuối phải có selector cụ thể hơn hoặc cùng specificity và đặt sau các rule cũ.
- CSS `:has()` cần browser hiện đại. Website đã dùng `:has()` trong CSS hiện tại.
