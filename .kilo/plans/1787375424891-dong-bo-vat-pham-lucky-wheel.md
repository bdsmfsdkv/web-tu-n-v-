# Kế hoạch đồng bộ cấu hình vật phẩm phần thưởng cho Lucky Wheel giữa Panel Admin và Web

## 1. Hiện trạng & Vấn đề
- **Hiện trạng:**
  - Vòng quay (`lucky_wheels`) có 8 ô phần thưởng cấu hình JSON `config`. Mỗi ô có thể chọn loại phần thưởng: `gem`, `gold`, `empty`, `money`, `item`, `random_account`.
  - Nếu chọn `item`, ô thưởng có thể gán `reward_item_id` từ bảng `reward_items`.
  - Trong `LuckyWheelController@create` và `edit`, dropdown "Vật phẩm liên kết" hiện load toàn bộ danh sách `RewardItem` (hoặc chưa phân nhóm / lọc trực quan theo vòng quay hiện tại).
  - Khi lưu vòng quay, `LuckyWheelController` tự động gán `lucky_wheel_id` cho các `RewardItem` được chọn trong `config`.
  - Tại trang web người dùng (`detail.blade.php`), hệ thống hiển thị số dư vật phẩm trúng vòng quay theo `$rewardItems->first()`, nếu không có thì fallback về `$user->gem`. Khi quay trúng `item`, response trả về `new_gem` là số dư vật phẩm vừa trúng và cập nhật DOM `.user-balance`.

- **Điểm cần đồng bộ và tối ưu cho thuận tiện:**
  1. **Admin Form (Create/Edit Lucky Wheel):**
     - UI/UX khi chọn "Loại phần thưởng": Tự động ẩn/hiển thị trường "Vật phẩm liên kết" phù hợp (chỉ hiện khi chọn `item` hoặc làm nổi bật khi chọn `item`).
     - Danh sách dropdown `reward_item_id` trong form vòng quay cần hiển thị rõ ràng thông tin (Tên vật phẩm, Tên game, Đơn vị tính).
     - Hỗ trợ xem nhanh các vật phẩm đang gắn với vòng quay này hoặc thêm nhanh liên kết vật phẩm.
  2. **Quản lý Kho thưởng (Reward Items Admin):**
     - Trang danh sách Kho Thưởng lọc và hiển thị chính xác vòng quay liên kết.
  3. **Đồng bộ với Web (User Frontend):**
     - Đảm bảo khi vòng quay có gán vật phẩm thưởng (loại `item`), Web hiển thị chính xác tên đơn vị vật phẩm (VD: Kim Cương, Quân Huy, Xu...), số dư hiện có của vật phẩm tương ứng cho vòng quay đó.
     - Sau khi người dùng quay trúng vật phẩm loại `item`, cập nhật tức thì số dư và đơn vị trên giao diện chi tiết vòng quay (`detail.blade.php`) mà không bị lệch hay ghi nhầm "KIM CƯƠNG" nếu vật phẩm là loại khác.
     - Nút "Rút Quà" dẫn trực tiếp đến trang rút vật phẩm với `reward_item_id` được chọn sẵn nếu có.

---

## 2. Các bước triển khai chi tiết

### Bước 1: Chuẩn hóa logic Controller và Form Admin (`LuckyWheelController` & Views)
1. **Controller (`app/Http/Controllers/Admin/LuckyWheelController.php`):**
   - Trong method `create()` và `edit()`, chuẩn hóa việc truy vấn `$rewardItems` đang hoạt động, gom nhóm hoặc format nhãn rõ ràng: `[Tên Game] Tên vật phẩm (Đơn vị)`.
   - Đảm bảo validation `config.*.reward_item_id` kiểm tra tính hợp lệ khi `reward_type === 'item'`.
2. **View Edit & Create (`resources/views/admin/lucky-wheels/edit.blade.php` & `create.blade.php`):**
   - Thêm tương tác JS nhỏ: Khi người dùng đổi `reward_type` trong ô thưởng:
     - Nếu chọn `item`: Hiển thị / highlight dropdown "Vật phẩm liên kết" và gợi ý điền tên hiển thị tương ứng.
     - Nếu chọn loại khác (`gem`, `gold`, `money`, `empty`, `random_account`): Cho phép disable hoặc ẩn nhẹ dropdown vật phẩm liên kết để tránh nhầm lẫn.
   - Thêm nhãn / link mở nhanh quản lý vật phẩm thưởng (`admin.reward-items.index`) ngay trong form cấu hình.

### Bước 2: Tinh chỉnh hiển thị Web Frontend (`LuckyCategoryController` & `detail.blade.php`)
1. **Controller (`app/Http/Controllers/User/LuckyCategoryController.php`):**
   - Đảm bảo `$rewardItems` truyền sang view lấy đúng các vật phẩm được cấu hình trong `config` của vòng quay hiện tại hoặc có `lucky_wheel_id == $wheel->id`.
   - Trong method `spin()`: Trả về đầy đủ thông tin `reward_unit` và `reward_item_id` cùng với `new_item_balance` trong JSON response.
2. **View Detail Web (`resources/views/user/wheel/detail.blade.php`):**
   - Box "BẠN ĐANG CÓ":
     - Hiển thị đúng đơn vị `$unitName` theo vật phẩm chính của vòng quay (hoặc liệt kê các vật phẩm có thể trúng).
     - Link "Rút Quà": Truyền kèm query param hoặc liên kết trực tiếp tới vật phẩm liên kết (`route('profile.withdraw-gem', ['item' => $linkedItem->id])`).
   - JS Xử lý sau khi quay:
     - Cập nhật số dư `.user-balance` và đơn vị khi trúng phần thưởng loại `item`.

### Bước 3: Kiểm tra và đồng bộ trang Rút Quà (`withdraw-gem.blade.php` & `ProfileController`)
1. **`app/Http/Controllers/User/ProfileController.php` & `withdraw-gem.blade.php`:**
   - Cho phép nhận tham số `item` từ URL (ví dụ `?item_id=X`) để tự động kích hoạt (active) thẻ vật phẩm tương ứng khi người dùng bấm "Rút Quà" từ trang chi tiết vòng quay sang.

---

## 3. Kế hoạch xác thực (Validation Plan)
1. **Kiểm tra Admin:**
   - Vào `Admin -> Vòng quay -> Chỉnh sửa`: Đổi loại phần thưởng thành `item`, chọn vật phẩm liên kết, lưu cấu hình thành công.
   - Kiểm tra bảng `reward_items` cập nhật đúng `lucky_wheel_id`.
2. **Kiểm tra Web User:**
   - Vào trang chi tiết vòng quay `/wheel/{slug}`:
     - Kiểm tra box "BẠN ĐANG CÓ" hiển thị đúng số dư vật phẩm và đơn vị tính (Unit).
     - Thực hiện quay (hoặc quay thử): popup và số dư cập nhật đồng bộ.
     - Bấm nút "Rút Quà": chuyển sang trang rút quà với đúng vật phẩm của vòng quay.
