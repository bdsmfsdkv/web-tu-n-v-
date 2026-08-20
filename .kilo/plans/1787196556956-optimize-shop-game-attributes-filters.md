# Kế hoạch tối ưu hóa chức năng Shop bán acc game (8 Tựa Game trọng điểm)

## 1. Mục tiêu và Phạm vi
Tối ưu hóa hệ thống đăng bán, quản lý và tìm kiếm/lọc tài khoản game theo chuẩn chuyên biệt cho 8 tựa game phổ biến nhất:
1. **Blox Fruits (Roblox)**
2. **Roblox (Chung)**
3. **Free Fire**
4. **FC Mobile (FIFA Mobile)**
5. **Liên Quân Mobile**
6. **Tốc Chiến (Wild Rift)**
7. **PUBG Mobile**
8. **Ngọc Rồng Online (NRO)**

---

## 2. Thiết kế thuộc tính mẫu (Attributes Preset) & Bộ lọc chuẩn từng game

### 2.1. Danh sách cấu hình thuộc tính chuẩn cho từng game
Tạo bảng tra cứu/cấu hình định nghĩa sẵn các trường đặc trưng cho 8 game:

| Game | Các thuộc tính chuẩn (Key - Label) | Các giá trị gợi ý / Dropdown options |
| :--- | :--- | :--- |
| **Liên Quân Mobile** | - `Rank`: Đồng, Bạc, Vàng, Bạch Kim, Kim Cương, Tinh Anh, Cao Thủ, Chiến Tướng<br>- `Tướng`: Số lượng tướng (VD: 50, 80, 115)<br>- `Trang Phục`: Số lượng skin (VD: 100, 200, 350)<br>- `Bậc Ngọc`: Ngọc 90 / Chưa 90<br>- `Đăng ký`: Trắng thông tin, FB, Garena, SĐT | Dropdown Rank, Input số lượng Skin/Tướng, Dropdown tình trạng đăng ký |
| **Free Fire** | - `Rank`: Đồng, Bạc, Vàng, Bạch Kim, Kim Cương, Huyền Thoại, Đại Cao Thủ<br>- `Skin Súng VIP`: AK Rồng Xanh, Scar Cá Mập, MP40 Mãng Xà, M1014 Long Tộc...<br>- `Đăng ký`: Trắng thông tin, Facebook, Google, VK<br>- `Pet`: Có / Không / Full | Dropdown Rank, Checkbox/Multi-select Skin súng, Dropdown tình trạng liên kết |
| **Blox Fruits (Roblox)** | - `Level`: Max (2550), 2000+, 1500+ (Sea 2/3)<br>- `Trái Ác Quỷ (Devil Fruit)`: Kitsune, Leopard, Dragon, Dough, Venom, Buddha, Portal...<br>- `Melee V2 (Võ thuật)`: Godhuman, Superhuman, Electric Claw, Dragon Talon, Sharkman Karate, Death Step<br>- `Kiếm Mythical (Swords)`: Cursed Dual Katana (CDK), True Triple Katana (TTK), Hallow Scythe, Dark Blade (Yoru)<br>- `Tộc V4 (Race V4)`: Human, Mink, Fishman, Skypiea, Ghoul, Cyborg (Full gear / Chưa full) | Dropdown Level, Dropdown Trái Ác Quỷ chính, Multi-select Melee & Swords, Dropdown Tộc V4 |
| **Roblox (Chung)** | - `Số dư Robux`: Robux Clean (VD: 1000, 5000, 10000+)<br>- `Năm tạo Acc`: 2015 - 2024<br>- `Gamepass`: Blox Fruits, King Legacy, Anime Defenders, Pet Simulator 99...<br>- `Tình trạng Pin / Mail`: Trắng email / Chưa đổi PIN / Đã gỡ mail | Input Robux, Dropdown Tình trạng thông tin bảo mật |
| **FC Mobile** | - `OVR Đội Hình`: 90-95, 96-100, 101-105, 106+<br>- `Giá trị đội hình`: 100M - 5B+ Coins<br>- `Cầu thủ nổi bật`: R9, Gullit, Zidane, Messi, Ronaldo, Mbappe...<br>- `Đăng nhập`: EA Account, Facebook, Google Play, Apple ID | Dropdown khoảng OVR, Input Giá trị đội hình, Dropdown Cầu thủ VIP |
| **Tốc Chiến** | - `Rank`: Sắt, Đồng, Bạc, Vàng, Bạch Kim, Lục Bảo, Kim Cương, Cao Thủ, Đại Cao Thủ, Thách Đấu<br>- `Số Tướng`: Số lượng tướng<br>- `Số Skin`: Số lượng skin<br>- `Skin Tối Thượng / Thần Thoại`: Có / Không | Dropdown Rank, Input Tướng/Skin |
| **PUBG Mobile** | - `Rank`: Đồng, Bạc, Vàng, Bạch Kim, Kim Cương, Cao Thủ, Quán Quân, Chí Tôn<br>- `Skin Nâng Cấp (Súng Lab)`: M416 Băng, M416 Glacier, AWM Godzilla, AKM Băng...<br>- `Bộ Trang Phục VIP`: X-Suit (Pharaoh, Poseidon, Silvanus...), Đồ Bape, Cổ Điển...<br>- `Liên kết`: Trắng thông tin, Twitter/X, Facebook, Mail | Dropdown Rank, Multi-select Súng nâng cấp, Multi-select X-Suit, Dropdown Liên kết |
| **Ngọc Rồng Online** | - `Máy Chủ (Server)`: Vũ Trụ 1 -> 13, Sao Đen, Indo...<br>- `Hành Tinh`: Trái Đất, Namếc, Xayda<br>- `Sức Mạnh`: Sơ sinh, 1.5tr, 15tr, 40tr, 1.5 tỷ, 80 tỷ...<br>- `Đệ Tử`: Sơ sinh, Skill 2 Kamejoko/Masenko, Skill 3 Ttln/Kaioken, Chưa có đệ<br>- `Bông Tai Porata`: Cấp 1, Cấp 2, Chưa có<br>- `Đăng ký`: Nick ảo (trắng thông tin), Gmail ảo, Đăng ký thật | Dropdown Server, Dropdown Hành tinh, Dropdown Mức sức mạnh, Dropdown Đệ tử, Dropdown Bông tai |

---

## 3. Kế hoạch triển khai chi tiết

### Bước 1: Tạo Config Preset thuộc tính (PHP Config Helper)
- Tạo file cấu hình `config/game_attributes.php` chứa danh sách 8 game, các template thuộc tính mặc định, nhãn hiển thị và danh sách gợi ý (presets).
- Giúp code gọn, chuẩn hóa key không bị gõ sai chính tả (`Rank` vs `rank`, `Tướng` vs `Số tướng`).

### Bước 2: Tối ưu Giao diện Admin Đăng Bán Tài Khoản (`admin/accounts/create.blade.php`, `admin/accounts/edit.blade.php`)
- Khi chọn **Danh mục game (Game Category)**:
  - Tự động nhận diện game thông qua `platform` hoặc `game_group` hoặc `slug` của danh mục.
  - Hiển thị nút **"Nạp mẫu thuộc tính nhanh"** theo tựa game tương ứng (1-click điền sẵn các trường chuẩn như Rank, Trái ác quỷ, Melee, Tướng, Trang phục, Sức mạnh...).
  - Cung cấp gợi ý (Datalist / Dropdown) để Admin không cần gõ tay thủ công từ đầu.
  - Vẫn giữ nguyên khả năng thêm/sửa/xóa trường tùy biến (`details` dynamic).

### Bước 3: Tối ưu Bộ Lọc và Hiển Thị Phía Người Dùng (`user/category/show.blade.php`, `GameCategoryController.php`)
- **Tối ưu thanh tìm kiếm/bộ lọc (Filter bar)**:
  - Hiển thị bộ lọc thông minh: Thay vì chỉ có các ô input text tự do, tự động biến các key chuẩn thành dropdown/select nếu có danh sách options (VD: Chọn Rank, Chọn Hành tinh, Chọn Server...).
  - Lọc theo khoảng giá mượt mà (có sẵn các mức giá nhanh: Dưới 50k, 50k - 200k, 200k - 500k, 500k - 1tr, Trên 1tr).
- **Tối ưu Card hiển thị tài khoản**:
  - Format nhãn thuộc tính nổi bật (Badges) đẹp mắt, gọn gàng trên mobile và desktop.
  - Hiển thị icon hoặc tag tương ứng với các thuộc tính VIP (VD: Trái V4, CDK, Súng Lab, Rank Cao Thủ...).

### Bước 4: Tạo Seeder Khởi Tạo Dữ Liệu 8 Game Chuẩn (`database/seeders/PresetGamesSeeder.php`)
- Tạo Game Groups:
  - Blox Fruits & Roblox
  - Liên Quân Mobile
  - Free Fire
  - FC Mobile
  - PUBG Mobile
  - LMHT Tốc Chiến
  - Ngọc Rồng Online
- Tạo các Danh mục Game (Game Category) phân loại rõ:
  - Nick Blox Fruits Max Level / Có Trái Mythical / Có CDK
  - Nick Free Fire Giàu Skin Súng / Rank Cao
  - Nick Liên Quân Full Tướng / Skin VIP / Trắng Thông Tin
  - Nick Ngọc Rồng Sơ Sinh / Sức Mạnh Khủng / Có Đệ Tử
  - Nick FC Mobile Đội Hình OVR Khủng
  - Nick PUBG Mobile Skin Băng Max / X-Suit
- Tạo tài khoản demo mẫu có đầy đủ thuộc tính chuẩn để test ngay lập tức.

---

## 4. Kế hoạch Kiểm Thử (Validation Plan)
1. **Kiểm tra Admin**:
   - Chọn lần lượt 8 danh mục game khi thêm tài khoản mới.
   - Bấm nạp mẫu thuộc tính nhanh -> Đảm bảo các input hiển thị đầy đủ, đúng trường.
   - Lưu tài khoản -> Kiểm tra database JSON `details` lưu chuẩn xác.
2. **Kiểm tra Giao diện Người Dùng (Client)**:
   - Truy cập từng danh mục game.
   - Sử dụng bộ lọc theo Rank, Thuộc tính, Khoảng giá -> Đảm bảo lọc chính xác kết quả.
   - Kiểm tra giao diện xem trên máy tính & điện thoại (Mobile Responsive).
