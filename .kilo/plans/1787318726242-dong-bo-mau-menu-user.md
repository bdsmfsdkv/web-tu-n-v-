# Kế hoạch đồng bộ màu menu người dùng

## Mục tiêu

Đưa toàn bộ menu người dùng đang hoạt động về một hệ màu lấy từ `--primary`, giữ tương phản light/dark và không thay đổi bố cục hay hành vi mở menu. Bỏ ngoại lệ màu xanh trên trang vòng quay. Không sửa menu admin hoặc mã mobile menu hiện không được render.

## Phạm vi

- Navbar desktop và trạng thái hover/active/open.
- Drawer/accordion tablet, mobile và nút hamburger.
- Mega menu Danh Mục, menu Nạp Tiền và item con.
- Dropdown tài khoản/avatar.
- Sidebar hồ sơ người dùng.
- Light mode và dark mode.

## Các bước

1. Chuẩn hóa token màu trong `public/css/style.css`:
   - Bổ sung giá trị RGB tương ứng cho `--primary` ở light/dark để tạo nền, viền, glow có alpha mà không lặp mã đỏ.
   - Khai báo token ngữ nghĩa dùng chung cho menu: accent, nền accent nhẹ, viền accent và glow; mọi token dẫn xuất từ `--primary`/RGB tương ứng.
   - Giữ màu trung tính riêng cho chữ, nền, viền vì chúng không phải màu thương hiệu.

2. Dọn lớp màu navbar cuối cùng trong `public/css/navbar-hover-hotfix.css`:
   - Cho `--nav-active` và các nền/viền active, hover, open dùng token menu chung thay vì `#dc2626`, `#f87171`, `#fff1f2` và `rgba(220, 38, 38, ...)`.
   - Áp dụng cùng token cho icon, mũi tên, item mega menu và menu Nạp Tiền.
   - Xóa toàn bộ khối `lucky-*` ép xanh; giữ nguyên cơ chế hover/open, kích thước và responsive.

3. Đồng bộ các lớp override có độ ưu tiên cao:
   - Trong `public/css/mobile-header-final.css`, thay màu cố định của hamburger mở, active/pressed item, hover item và dropdown tài khoản bằng token menu.
   - Trong phần selector menu của `public/css/ui-fixes.css`, thay màu cố định cho navbar, menu Nạp Tiền, avatar/dropdown và dark mode bằng token chung.
   - Không chỉnh các màu đỏ ngoài phạm vi menu như toast, card, form hoặc nút nội dung.

4. Đồng bộ nguồn style cũ còn tác động:
   - Trong phần navbar và mobile drawer của `resources/views/layouts/user/header.blade.php`, thay nền/viền accent cố định bằng token chung; giữ màu riêng có ý nghĩa cho từng phương thức thanh toán và badge trạng thái.
   - Trong phần menu liên quan của `public/css/style.css`, dùng token chung cho active/hover/glow; không sửa component không phải menu.
   - Trong `public/css/legacy-compat.css`, đưa hover/active của `.profile-sidebar` về cùng accent, nền nhẹ và viền accent ở cả light/dark.

5. Gỡ dấu vết ngoại lệ vòng quay trong `resources/views/layouts/user/header.blade.php`:
   - Xóa `$isLuckyNav`, `navbar-lucky-page`, `lucky-nav-scope`, `lucky-nav-active`, `lucky-nav-hover`.
   - Giữ nguyên logic xác định route active chuẩn để Danh Mục vẫn active trên route `lucky.*`.
   - Chỉ gỡ phần ngoại lệ màu hiện có, không đụng thay đổi khác trong file bẩn.

6. Kiểm tra hồi quy:
   - Chạy tìm kiếm tĩnh trên các selector menu để xác nhận không còn mã đỏ/xanh cố định dùng cho accent; cho phép màu riêng của icon thanh toán, badge và màu trung tính.
   - Chạy test Laravel hiện có để bắt lỗi render Blade/route.
   - Kiểm tra thủ công desktop >=1200px: hover/active/open của Trang Chủ, Danh Mục, Nạp Tiền, menu con và avatar dropdown.
   - Kiểm tra tablet/mobile <=1199px: hamburger đóng/mở, accordion Danh Mục/Nạp Tiền, pressed/active và cuộn menu.
   - Kiểm tra sidebar hồ sơ ở desktop/mobile.
   - Lặp các ca trên light/dark và ít nhất trang chủ, trang vòng quay, trang nạp tiền, trang hồ sơ; xác nhận trang vòng quay không còn menu xanh.
   - Xác nhận focus-visible vẫn dễ nhận biết và chữ/icon đạt tương phản đọc được.

## Ràng buộc

- Không thêm dependency, JS hoặc abstraction mới.
- Không sửa `resources/views/layouts/user/menu-mobile.blade.php` hay `.mobile-bottom-nav`: hiện không được render và bị stylesheet chính thức ẩn.
- Không sửa sidebar admin.
- Không thay đổi hành vi menu, route active, spacing, animation hoặc màu ngữ nghĩa của phương thức thanh toán/badge.
- Bảo toàn mọi thay đổi không liên quan đang có trong worktree.
