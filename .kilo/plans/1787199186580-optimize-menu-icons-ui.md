# Kế Hoạch Tối Ưu Hệ Thống Menu, Icon và Giao Diện Toàn Diện (Header, Mega Menu & Mobile)

## 1. Mục tiêu
- Tối ưu hóa toàn bộ hệ thống Navigation: Desktop Header, Dropdown/Mega Menu, Avatar Profile Dropdown, Language Switcher, Drawer Menu (Mobile) và Mobile Bottom Navigation.
- Nâng cấp bộ icon sang bộ đồng bộ, hiện đại, sắc nét (sử dụng FontAwesome 6 Pro / SVG Iconify Ant Design & Lucide phong cách gaming e-commerce).
- Cải thiện trải nghiệm responsive, hiệu ứng hover, animation mượt mà, layout kính mờ / bo góc chuẩn hiện đại (modern card UI), chống giật hoặc tràn layout khi tên user hay số dư dài.

---

## 2. Chi tiết các hạng mục thay đổi

### A. Tối ưu Header & Navigation Bar (Desktop)
1. **Logo & Brand:**
   - Giữ tỉ lệ logo cân đối, căn giữa theo trục dọc với navbar.
2. **Menu Links & Icons:**
   - Cập nhật icon đẹp, đồng bộ với kích thước 16-18px có background icon nhẹ hoặc icon màu hiện đại:
     - *Trang Chủ*: `ant-design:home-outlined` hoặc `fa-solid fa-house-chimney`
     - *Danh Mục*: `ant-design:appstore-outlined` hoặc `fa-solid fa-layer-group` (có badge số lượng hoặc icon mũi tên xoay mượt khi hover)
     - *Nạp Tiền*: `ant-design:wallet-outlined` / `fa-solid fa-wallet` (kèm badge nổi bật "Khuyến mãi/Bonus")
     - *Lịch Sử*: `ant-design:history-outlined` / `fa-solid fa-clock-rotate-left`
     - *Tin Tức*: `ant-design:read-outlined` / `fa-solid fa-newspaper`
     - *Tiếp Thị Liên Kết*: `ant-design:share-alt-outlined` / `fa-solid fa-handshake` kết hợp badge "Hot/Kiếm tiền" bắt mắt.
3. **Mega Menu Danh Mục:**
   - Thiết kế lại layout Mega Menu 3-4 cột có chia nhóm rõ ràng: *Tài Khoản Game*, *Random Account*, *Dịch Vụ Game*.
   - Icon / Thumbnail từng danh mục có bo góc tròn mềm mại (`border-radius: 8px`), hover hiệu ứng scale nhẹ và sáng bóng (`background: var(--bg-hover)`).
4. **Dropdown Nạp Tiền:**
   - Giao diện thẻ item rõ ràng gồm Icon phương thức riêng biệt (Thẻ cào: `fa-credit-card`, Ngân hàng/QR: `fa-building-columns`, USDT/Crypto: `fa-bitcoin-sign` hoặc `fa-cube`).

---

### B. Tối ưu Cụm Người Dùng (User Area & Controls)
1. **Language Switcher & Theme Toggle:**
   - Nút chuyển ngôn ngữ thiết kế pill-badge bo tròn hiện đại, dropdown chọn quốc gia mượt mà.
   - Nút Dark/Light mode animation xoay nhẹ.
2. **Cụm Thông Tin User & Avatar:**
   - Username và Số dư hiển thị dạng compact chip, có tooltip khi số tiền quá dài.
   - Avatar hiển thị viền gradient gaming hoặc status active xanh lá cây.
   - Dropdown profile Ant-Design style:
     - Header: Card user info gồm avatar, tên, email, số dư nổi bật với nút Nạp nhanh.
     - Danh sách menu item: Tài khoản, Nạp tiền, Lịch sử mua, Biến động số dư, Admin Panel (nếu role admin), Đăng xuất (màu đỏ nhẹ).

---

### C. Tối ưu Drawer Menu Mobile & Mobile Bottom Nav
1. **Offcanvas Mobile Drawer:**
   - Header Drawer hiển thị Logo hoặc User Profile thu nhỏ nếu đã đăng nhập.
   - Menu phân cấp dạng accordion mượt mà (Danh Mục, Nạp Tiền bấm xổ xuống trơn tru, không giật màn hình).
   - Thiết kế các item dạng card list rộng rãi, dễ bấm trên màn cảm ứng (`min-height: 44px`).
   - Thêm nút liên hệ nhanh / mạng xã hội ở chân drawer.
2. **Mobile Bottom Navigation Bar:**
   - Giữ cố định dưới đáy màn hình, hiệu ứng glassmorphism (`backdrop-filter: blur(12px)`).
   - 5 nút chính: Trang chủ, Danh mục, Nạp tiền (nút tròn nổi bật ở giữa - Floating Action Button), Lịch sử, Tài khoản.
   - Icon active có hiệu ứng đổi màu primary và chấm indicator nhỏ bên dưới.

---

## 3. Các file sẽ chỉnh sửa
1. `resources/views/layouts/user/header.blade.php`: Cấu trúc lại Header, Mega Menu, Dropdown, Drawer Mobile.
2. `resources/views/layouts/user/footer.blade.php`: Cập nhật Mobile Bottom Nav đồng bộ icon & Floating Button.
3. `public/css/style.css`: Bổ sung CSS cho Mega Menu nâng cao, Modern Glassmorphism, Floating Navigation, Accordion Mobile.

---

## 4. Kế hoạch kiểm thử & nghiệm thu
- [ ] Kiểm tra hiển thị trên Desktop (1920x1080, 1440x900, 1366x768).
- [ ] Kiểm tra hiển thị trên Tablet (iPad 768px - 1024px) khi xoay ngang / dọc.
- [ ] Kiểm tra trên Mobile (iPhone SE, iPhone 12/14 Pro Max, Android 360px - 414px).
- [ ] Kiểm tra tương thích Dark Mode / Light Mode cho tất cả menu, mega menu, mobile drawer và bottom bar.
- [ ] Chạy `php artisan view:clear` và xác nhận không có lỗi layout / JS console.
