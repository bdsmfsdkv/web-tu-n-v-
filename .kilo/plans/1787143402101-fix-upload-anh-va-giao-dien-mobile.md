# Kế hoạch: Sửa lỗi không upload được ảnh/logo + lỗi giao diện mobile

Dự án: Laravel **10.48.29** tại `C:\xampp\htdocs` (XAMPP, PHP 8.2.12, serve từ htdocs root qua `.htaccess` rewrite vào `public/`).

**Không có build pipeline**: không có `package.json`, `node_modules`, `vite.config.js`, không có `@vite()` trong blade nào. `tailwind.config.js` và `postcss.config.js` là rác Breeze còn lại, hoàn toàn vô tác dụng — không có class Tailwind nào trong views. **Mọi sửa đổi CSS phải viết trực tiếp vào `public/css/*.css`**, không chạy npm.

CSS đang được load (`resources/views/layouts/user/head.blade.php:54-55`): chỉ `public/css/style.css` (5756 dòng) và `public/css/legacy-compat.css` (1029 dòng). Trong 27 file ở `public/assets/css/` chỉ `auth.css` được link.

---

## Phần 0 — Hai lỗi chặn (phải làm trước, nếu không mọi thứ khác vô nghĩa)

### 0.1 `APP_KEY` không hợp lệ → toàn site trả 500

- `.env:3` → `APP_KEY=base64:GIU_NGUYEN_APP_KEY_HIEN_TAI` (placeholder chưa thay).
- Đã kiểm chứng: `base64_decode(...)` = **16 byte**, cipher `AES-256-CBC` (`config/app.php`) cần 32 byte. Resolve container `encrypter` ném `RuntimeException: Unsupported cipher or incorrect key length`.
- `EncryptCookies` là middleware đầu tiên của group `web` (`app/Http/Kernel.php:33`) → **mọi** request HTTP fail, không chỉ POST upload.
- Bằng chứng trong log: `storage/logs/laravel-2026-08-19.log` → `MissingAppKeyException`.

**Việc cần làm:**
1. Chạy `C:\xampp\php\php.exe artisan key:generate` **trong đúng thư mục `C:\xampp\htdocs`** (`php` không có trong PATH; chạy sai cwd sẽ khiến `.env` không được load, `APP_ENV` rơi về `production` và key = NULL — đúng như log ngày 19/08).
2. Xác minh: `php artisan tinker` hoặc script kiểm tra resolve `encrypter` thành công.

**Tác dụng phụ cần biết:** đổi `APP_KEY` làm mọi cookie/session hiện có mất hiệu lực → tất cả user bị đăng xuất. Không mất dữ liệu vì key cũ chưa từng hợp lệ nên chưa có gì được mã hoá bằng nó.

### 0.2 MySQL không chạy

Đã kiểm chứng: kết nối `127.0.0.1:3306` bị refuse (`SQLSTATE[HY000] [2002]`). Bật MySQL trong XAMPP Control Panel trước khi test.

---

## Phần 1 — Sửa lỗi upload ảnh/logo

### 1.1 `public/storage` là folder copy thủ công, KHÔNG phải junction (nguyên nhân chính của "upload logo mà không hiện")

Đã kiểm chứng:
- `cmd /c dir "C:\xampp\htdocs\public"` → `<DIR> storage` (không phải `<JUNCTION>`); `dir /AL` không tìm thấy reparse point nào.
- Timestamp folder = `08/19/2026 10:32 AM`, nội dung trùng khớp 1:1 với `storage/app/public` (27 file) → ai đó copy tay lúc 10:32, rồi 10:38 chạy artisan sai cwd và gặp lỗi APP_KEY.

Hệ quả: `UploadHelper` ghi file vào `storage/app/public/config/...` và trả URL `/storage/config/...` (đã kiểm chứng `Storage::url('public/config/test.jpg')` → `/storage/config/test.jpg`), nhưng thư mục `public/storage` là bản copy tĩnh → **file mới không bao giờ xuất hiện** → ảnh 404, logo không đổi.

**Việc cần làm:**
1. Backup `public/storage` (hoặc chỉ cần xác nhận nó là bản copy của `storage/app/public` — đã xác nhận trùng khớp hoàn toàn).
2. Xoá `public/storage` (thư mục copy).
3. Chạy `C:\xampp\php\php.exe artisan storage:link` tại `C:\xampp\htdocs`. Trên Windows, `Illuminate\Filesystem\Filesystem::link()` dùng `mklink /J` (junction) → **không cần quyền admin** (đã kiểm chứng trong `vendor/.../Filesystem.php`).
4. Xác minh: `cmd /c dir public` phải hiện `<JUNCTION> storage [C:\xampp\htdocs\storage\app\public]`.
5. Xác minh qua HTTP: mở `http://localhost/storage/config/1781972577_1466f7bb91e18660647c5444eb7ca3f1.jpg` → phải trả 200. Nếu 403/404 thì Apache thiếu `Options FollowSymLinks` cho `C:\xampp\htdocs` trong `httpd.conf` (chỉ xử lý nếu thực sự gặp).
6. Test end-to-end: Admin → Cài đặt → Chung → upload logo mới → kiểm tra file mới nằm trong `storage/app/public/config/` **và** truy cập được qua `/storage/config/...`, header hiện logo mới.

**Không đổi** `FILESYSTEM_DISK=local` trong `.env`. `UploadHelper::upload()` (`app/Helpers/UploadHelper.php:48,60`) dùng prefix `public/` trên disk `local` và dựa vào cơ chế rewrite `public/` → `/storage/` của `Storage::url()`. Đổi thành `public` sẽ tạo `storage/app/public/public/...` và URL `/storage/public/...` → hỏng thêm. Ghi chú refactor này ở Phần 3.

### 1.2 `GameGroupController` không hề xử lý file thumbnail

`app/Http/Controllers/Admin/GameGroupController.php`:
- `:15` khai báo `private const UPLOAD_DIR = 'game-groups';` nhưng **không dùng ở đâu**; `UploadHelper` được import (`:7`) nhưng không gọi.
- `:33-37` và `:70-74` validate thiếu rule `thumbnail`.
- `:41` / `:78` `$data = $request->all();` → chứa object `UploadedFile` cho key `thumbnail`; `thumbnail` là fillable (`app/Models/GameGroup.php:15`) → `GameGroup::create($data)` / `update($data)` ném exception, bị `catch` ở `:52-58` / `:89-95` nuốt và chỉ hiện flash "Có lỗi xảy ra".
- Form có gửi file thật: `resources/views/admin/game-groups/create.blade.php:49` và `edit.blade.php:70` (`<input type="file" name="thumbnail">`), `enctype="multipart/form-data"` đã có (`create:21`, `edit:21-22`).
- Bằng chứng từng chạy được: `storage/app/public/game-groups/1782031086_....gif` theo đúng convention đặt tên của `UploadHelper`.

**Việc cần làm** (theo đúng pattern của `GameCategoryController::store/update`):
1. Thêm rule `'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'` vào cả `store` và `update`.
2. Trong `store`: `unset($data['thumbnail'])` trước khi create, rồi `if ($request->hasFile('thumbnail')) $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);`
3. Trong `update`: xoá ảnh cũ bằng `UploadHelper::deleteByUrl($gameGroup->thumbnail)` trước khi upload ảnh mới; nếu không có file mới thì giữ nguyên giá trị cũ (đừng để `$request->all()` ghi đè thành null/object).
4. Test: thêm mới + sửa danh mục mẹ có ảnh, xác nhận ảnh hiện ở trang index và ở frontend.

### 1.3 Validation favicon lệch với `accept` của input

- `app/Http/Controllers/Admin/ConfigController.php:142` → `'site_favicon' => 'nullable|mimes:ico,png|max:1024'`
- `resources/views/admin/settings/partials/general.blade.php:181` → `accept="image/jpeg,image/png,image/jpg,image/gif"`

Người dùng chọn được `.jpg`/`.gif` nhưng bị validation từ chối. **Việc cần làm:** sửa `accept` của input favicon thành `image/png,image/x-icon,.ico` và ghi rõ giới hạn 1MB trong label. (Chọn siết input thay vì nới validation — favicon nên là png/ico.)

### 1.4 Rà soát các form upload còn lại

Đã kiểm chứng là **đúng** (không cần sửa), chỉ cần smoke-test sau khi xong 0.1 + 1.1:
- Tất cả form có file input đều đã có `enctype="multipart/form-data"`.
- `resources/views/admin/settings/partials/general.blade.php:10-11` có `enctype`; tên input (`site_logo`, `site_logo_footer`, `site_favicon`, `site_banner[]`, `site_share_image`, `remove_banners[]`) khớp với `ConfigController::updateGeneral` (`:149-210`).
- Giới hạn PHP đủ rộng: `upload_max_filesize=40M`, `post_max_size=40M`, `file_uploads=1`, `memory_limit=512M`, `upload_tmp_dir=C:\xampp\tmp`.
- `bootstrap/cache/` không có `config.php` → không bị config cache cũ.

Một điểm mong manh cần sửa nhẹ: `partials/general.blade.php:308` bind vào `document.querySelector('form')` (form **đầu tiên** trong DOM) để sync CKEditor. Trang `settings/index.blade.php:71-88` include 6 form; hiện form general tình cờ đứng đầu nên chạy đúng, nhưng đổi thứ tự sẽ âm thầm làm mất `top_deposit_reward`. Sửa thành selector theo `id` của form general.

---

## Phần 2 — Sửa lỗi giao diện mobile

Tất cả các mục dưới đây đã được kiểm chứng bằng cách đọc CSS/blade thật, không phải suy đoán.

### 2.1 `.category-grid` bị ép 5 cột từ trong `<head>`, không có media query — ƯU TIÊN CAO

`resources/views/layouts/user/head.blade.php:121-123`:
```css
.category-grid { grid-template-columns: repeat(5, 1fr); }
```
Inline `<style>` này nằm **sau** `style.css` nên override `style.css:1395` (4 cột) ở mọi độ rộng. Trên điện thoại nó chỉ "sống sót" nhờ rule mobile dùng `!important` (`style.css:5395`, `:5553` → `repeat(2,1fr) !important`). Trong khoảng 769–1024px thì render 5 cột chật cứng. `.category-grid` dùng 3 lần ở `user/home.blade.php:462, 509, 544`.

**Sửa:** xoá block này khỏi `head.blade.php`, chuyển vào `public/css/style.css` cạnh `:1395` kèm bậc breakpoint đầy đủ (5 cột ≥1200px → 4 cột ≥992px → 3 cột ≥769px → 2 cột ≤768px), rồi bỏ `!important` ở `:5395` / `:5553`.

### 2.2 Thiếu hoàn toàn breakpoint 769–991px

Toàn bộ 7 `@media` trong `style.css` đều là `max-width` và đều ≤768 trừ 420/480/600: các dòng 3282, 3713, 4877, 5076, 5512, 5718, 5731. `legacy-compat.css` có 5 media ở 372, 531 (992px), 568, 581, 690.

Hệ quả: tablet và điện thoại xoay ngang nhận nguyên layout desktop.

**Sửa:** thêm một block `@media (max-width: 991px)` trong `style.css` xử lý các grid chính (`.category-grid`, `.account-grid`, `.fs-grid`, `.review-grid`) và các layout flex 2 cột. Đặt block này **trước** block `max-width: 768px` để thứ tự cascade đúng.

### 2.3 `padding-top: 64px` hardcode trong khi navbar mobile cao 52px

- `resources/views/layouts/user/app.blade.php:9` → `<main style="padding-top:64px;flex:1;">`
- `public/css/style.css:5104-5107` → `.nav-container { height: 52px }` ở `@media (max-width: 768px)`

→ khoảng trống chết 12px trên mobile.

**Sửa:** bỏ inline style, đổi thành `<main class="site-main">`, định nghĩa `.site-main { padding-top: 64px; flex: 1; }` trong `style.css` và `@media (max-width:768px) { .site-main { padding-top: 52px; } }`. Kiểm tra thêm `body { padding-bottom }` cho mobile bottom nav (`style.css:4877+`) không bị chồng lấn.

### 2.4 `user/profile/installments.blade.php` — trang profile duy nhất không co lại được

`resources/views/user/profile/installments.blade.php`:
- `:7` → `<div class="profile-layout" style="display: flex; gap: 24px;">` — class `.profile-layout` **không tồn tại** trong `style.css` lẫn `legacy-compat.css` (đã grep). Inline `display:flex` không có breakpoint nào → sidebar 280px (`legacy-compat.css:573-579`) nằm cạnh bảng 8 cột ngay trên điện thoại.
- `:16` → `<div class="table-responsive">` — class Bootstrap, nhưng **Bootstrap không được load ở layout user**; `.table-responsive` chỉ tồn tại trong theme admin (`public/cmsbvq/...`) → wrapper này không có `overflow-x` gì cả.
- `:17-27` → bảng inline 8 cột: Mã #, Tài khoản, Tổng giá, Đã trả, Còn lại, Hạn chót, Trạng thái, Hành động.

15 trang profile khác đều dùng `.profile-content`, class này có `flex-direction: column` ở ≤768px (`legacy-compat.css:563-572`).

**Sửa:** đổi `:7` thành `<div class="profile-content">` (bỏ inline style), đổi `:16` thành wrapper có `overflow-x: auto` giống `.history-table-container` (`legacy-compat.css:746-750`) — dùng luôn class đó cho nhất quán.

### 2.5 Bảng giá dịch vụ mất toàn bộ CSS

`resources/views/user/service/show.blade.php:122-135` dùng `.service__price-section`, `.service__price-container`, `.service__price-table`, `.service__price-row`, `.service__price-col--*`. Các class này **chỉ được định nghĩa trong `public/assets/css/service.css`** (20 chỗ, dòng 189-513), mà file đó **không được link từ bất kỳ blade nào** (chỉ `assets/css/auth.css` được link). Block `<style>` tại `show.blade.php:8` không định nghĩa chúng.

→ bảng render thô, không có wrapper overflow → tràn ngang trên mobile.

**Sửa:** thêm `@push('css')<link rel="stylesheet" href="{{ asset('assets/css/service.css') }}">@endpush` vào `show.blade.php` (stack `css` đã có ở `head.blade.php:152`), rồi kiểm tra `service.css` có `overflow-x: auto` cho `.service__price-container`; nếu chưa có thì bổ sung. Đồng thời rà `service.css` xem có xung đột với `style.css` không (nó là file legacy).

### 2.6 Bảng không có wrapper overflow ở `withdraw-gem.blade.php`

`resources/views/user/profile/withdraw-gem.blade.php:465` → `<table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">` trần, không wrapper, không `data-label`.

**Sửa:** bọc bằng `.history-table-container`.

*(Đã kiểm tra và KHÔNG cần sửa: `deposit-usdt.blade.php:521` — bảng `.custom-table` đã nằm trong `.table-container` có `overflow-x: auto` định nghĩa tại chính file đó, dòng 200. Tất cả `.history-table` khác đều đã có wrapper.)*

### 2.7 `.product-gallery { min-width: 320px }` tràn trên máy 320–360px

`public/css/legacy-compat.css:360-362`. Với `.container` padding 16px mỗi bên (`style.css:5389-5391`), 320px min-width vượt quá vùng khả dụng.

**Sửa:** thêm reset trong `@media (max-width: 768px)`: `.product-gallery { min-width: 0; width: 100%; }`.

### 2.8 Overflow đang bị che, không phải đã sửa

`public/css/style.css:6-10`:
```css
html, body { overflow-x: hidden; max-width: 100vw; }
```
Đây là lý do các lỗi tràn biểu hiện thành **nội dung bị cắt/bóp méo** chứ không phải thanh scroll ngang.

**Sửa:** **giữ nguyên** rule này (bỏ đi sẽ làm site trông tệ hơn ngay), nhưng khi verify từng mục 2.1-2.7 thì tạm comment nó lại trong DevTools để nhìn ra chỗ nào còn tràn thật.

### 2.9 Admin panel chặn pinch-zoom

`resources/views/layouts/admin/head.blade.php:3` → `user-scalable=0, minimal-ui`. Đây là lỗi accessibility (WCAG 1.4.4).

**Sửa:** đổi thành `<meta name="viewport" content="width=device-width, initial-scale=1.0">`.
*(Layout user `head.blade.php:5` dùng `initial-scale=1.0, maximum-scale=5.0` — chấp nhận được, không cần sửa.)*

### 2.10 Inline style override rule mobile ở trang chi tiết acc

`resources/views/user/account/detail.blade.php:61` → `class="account-grid"` kèm inline `grid-template-columns: repeat(auto-fill, minmax(200px, 1fr))`, override `style.css:5407-5409` (2 cột, không có `!important`). Kết quả xuống 1 cột trên mobile — dùng được nhưng không đúng ý định.

**Sửa:** bỏ inline `grid-template-columns`, để CSS trong `style.css` quyết định.

### 2.11 Dọn code mobile nav chết (chống nhầm lẫn về sau)

Menu mobile **đang hoạt động** là: hamburger `#navToggle` ở `layouts/user/header.blade.php:79-81` + offcanvas `#navLinks` + overlay `#navOverlay:265`, toggle bằng `public/js/app.js:49-78` (breakpoint JS 768 khớp CSS), cộng bottom tab bar ở `layouts/user/footer.blade.php:69-97`.

Các thứ **chết** cần xoá:
- `resources/views/layouts/user/menu-mobile.blade.php` — không được `@include` ở đâu, class của nó không tồn tại trong CSS đang load.
- `resources/views/layouts/user/header.blade copy.php` — file backup rác, tên có dấu cách.
- `public/assets/js/mobile-menu.js`, `public/assets/css/mobile-menu.css` — không được link.
- Rule `.nav-toggle` bị lặp 2 lần: `style.css:3284-3286` và `:5118-5121` → gộp lại 1 chỗ.

**Không xoá** các file khác trong `public/assets/css/` ở bước này (`responsive-fixes.css`, `header-responsive.css`, `home.css`, `category.css`, `profile.css`... đều không được link nhưng có thể tái dùng — mục 2.5 là ví dụ). Chỉ ghi chú lại.

---

## Phần 3 — Rủi ro bảo mật phát hiện kèm (nên xử lý cùng lúc)

### 3.1 `public/terminal.php` — endpoint public không xác thực, RCE-adjacent. XOÁ.

```php
// public/terminal.php:4-6
$app->make(Kernel::class)->call('key:generate', ['--quiet' => true]);
$app->make(Kernel::class)->call('storage:link');
$app->make(Kernel::class)->call('app:clear');
```
Bất kỳ ai truy cập `http://<host>/terminal.php` đều **regenerate được `APP_KEY`** (đăng xuất toàn bộ user) và clear cache. Không có auth, không có kiểm tra IP/env. Ngoài ra `app:clear` không phải command Laravel hợp lệ (đúng là `optimize:clear`) nên script này còn ném lỗi ở dòng cuối.

**Việc cần làm:** xoá `public/terminal.php`. Dùng CLI ở Phần 0/1 thay thế.

### 3.2 `.env` để lộ / cấu hình dev trên môi trường có thể truy cập

`.env:4` → `APP_DEBUG=true`. Nếu host này không phải máy dev cá nhân thì stack trace Whoops đang phơi đường dẫn, query SQL và cấu hình ra ngoài. Xác nhận với người dùng đây là môi trường gì; nếu là production thì `APP_DEBUG=false`.

### 3.3 `RewardItemController` cho phép upload SVG

`app/Http/Controllers/Admin/RewardItemController.php:46,77` → `mimes:...,svg,...`. SVG là vector cho stored-XSS (chứa `<script>`). **Sửa:** bỏ `svg` khỏi rule.

---

## Phần 4 — Việc dọn dẹp không bắt buộc (làm sau, KHÔNG làm trong lần này)

Ghi lại để không mất dấu, nhưng đừng gộp vào PR sửa lỗi:

1. **Rule validation thiếu `max`**: `GameAccountController:62-63,118-119`, `GameCategoryController:48,107`, `RandomCategoryController:57,116`, `RandomCategoryAccountController:61,159`, `GameServiceController:40,87`, `LuckyWheelController:62-63,155-156` (cái này còn thiếu cả `mimes`). File quá lớn sẽ bị `ValidatePostSize` chặn thành 413 chứ không ra lỗi field đẹp.
2. **`BankAccountController:46-51,95-105`** dùng `$image->move(public_path('uploads/banks'), ...)`, đi đường riêng không qua `UploadHelper`/storage. Nên thống nhất.
3. **`UploadHelper::upload()`** nên chuyển sang `Storage::disk('public')` để không phụ thuộc vào cơ chế rewrite `public/` → `/storage/` và không vỡ nếu ai đó đổi `FILESYSTEM_DISK`. Việc này cần migrate giá trị URL đang lưu trong bảng `configs` và các bảng khác → làm riêng, có script migrate.
4. **`UploadHelper:55`** đặt tên file `time() . '_' . md5(originalName)` → 2 người upload cùng tên file trong cùng 1 giây sẽ ghi đè nhau. Đổi sang `Str::random()` hoặc `uniqid()`.
5. **`UploadHelper::deleteByUrl()`** (`:98`) `str_replace('/storage', 'public', $url)` không xử lý URL ngoài. Các giá trị seed như `https://imgur.com/hIFVXRo.png` (`ConfigSeeder.php:25-29`) sẽ tạo path rác và log error vô hại. Nên `return false` sớm nếu URL không bắt đầu bằng `/storage`.
6. **CKEditor không có upload adapter**: load từ CDN ở `partials/general.blade.php:291`, `partials/terms.blade.php:44`, `lucky-wheels/create.blade.php:243`, `edit.blade.php:294` nhưng không config `simpleUpload` → kéo-thả ảnh vào editor sẽ không có tác dụng. Nếu người dùng kỳ vọng dán ảnh vào nội dung được thì đây là một yêu cầu riêng cần làm thêm endpoint upload.
7. **`composer.json:10`** khai `laravel/framework: ^11.0` nhưng bản cài thực tế là **10.48.29**. Cần làm rõ trước khi ai đó chạy `composer update` và làm vỡ app.
8. Xoá `check_wheel_hist.php` ở root (script debug) và `shopgame.sql` (dump DB nằm trong web root — nếu `.htaccess` hỏng thì tải về được).
9. `tailwind.config.js`, `postcss.config.js` vô tác dụng → xoá hoặc dựng build pipeline thật.

---

## Trình tự thực thi

```
1. Bật MySQL trong XAMPP                                    (0.2)
2. php artisan key:generate  (đúng cwd C:\xampp\htdocs)      (0.1)  ← verify: site trả 200
3. Xoá public/terminal.php                                  (3.1)
4. Xoá folder public/storage rồi php artisan storage:link    (1.1)  ← verify: dir hiện <JUNCTION>
5. Test upload logo → verify ảnh hiện ở header               (1.1)
6. Sửa GameGroupController store/update                      (1.2)
7. Sửa accept của input favicon + selector form CKEditor     (1.3, 1.4)
8. Sửa mobile: 2.1 → 2.2 → 2.3 → 2.4 → 2.5 → 2.6 → 2.7 → 2.9 → 2.10
9. Dọn code mobile nav chết                                  (2.11)
10. Bỏ svg khỏi RewardItemController                         (3.3)
```

## Cách kiểm chứng

Không có test suite chạy được cho phần này (`phpunit.xml` có, nhưng không có test nào cho upload hay view). Verify bằng tay:

**Upload:**
- Admin → Cài đặt → Chung: upload từng field `site_logo`, `site_logo_footer`, `site_favicon` (dùng .png), `site_share_image`, `site_banner` (nhiều file). Sau mỗi lần: file mới phải xuất hiện trong `storage/app/public/config/`, URL `/storage/config/<tên>` phải trả 200, và ảnh phải đổi ở header (`layouts/user/header.blade.php:76,86`) / footer (`footer.blade.php:7`) / favicon (`head.blade.php:38-40`).
- Admin → Danh mục mẹ: thêm mới + sửa, có ảnh → ảnh hiện ở list.
- Smoke test 1 form upload khác đã hoạt động sẵn (Danh mục game hoặc Tài khoản game) để chắc chắn Phần 0/1.1 không làm hỏng gì.
- Kiểm tra `storage/logs/laravel-*.log` sạch sau khi test.

**Mobile:** DevTools responsive, kiểm tra ở 360px, 414px, 768px, 900px (khoảng bị bỏ quên), 1024px, 1280px trên các trang: home (`/`), chi tiết acc, chi tiết dịch vụ (bảng giá — mục 2.5), `profile/installments` (mục 2.4), `profile/withdraw-gem` (mục 2.6), `profile/deposit-usdt`. Với mỗi trang: không có scroll ngang khi tạm bỏ `overflow-x: hidden`, hamburger mở/đóng được, bottom nav không che nội dung, không có khoảng trống 12px dưới navbar.

## Câu hỏi còn mở

1. Host này là máy dev cá nhân hay có người ngoài truy cập được? Quyết định `APP_DEBUG` (3.2) và mức độ gấp của 3.1.
2. Có kỳ vọng chèn ảnh trực tiếp vào nội dung CKEditor (bài viết / điều khoản) không? Nếu có thì cần thêm endpoint upload cho editor (mục 4.6) — hiện chưa có, và đây có thể chính là cái người dùng gọi là "không up ảnh lên web được" nếu triệu chứng nằm ở trình soạn thảo chứ không phải form logo.
