# UI Overhaul Plan — ShopAcc Game Store

## Goal
Dọn dẹp CSS trùng lặp, thống nhất design system, cải thiện giao diện đẹp hơn, tối ưu responsive cho mọi thiết bị (điện thoại, tablet, laptop, desktop).

## Decisions
- **Primary color:** Giữ `#dc2626` (red)
- **Font:** Chỉ dùng Inter, bỏ Roboto → tiết kiệm ~100KB
- **Bottom nav mobile:** Giữ lại
- **Breakpoint system:** Thống nhất 5 breakpoints: 480 / 768 / 1024 / 1280 / 1536px

---

## Tasks (Ordered)

### Phase 1: Dọn dẹp CSS trùng lặp & Design Tokens

**Task 1.1** — Tạo CSS Design Tokens (đầu file `style.css`)
- Thêm spacing tokens: `--space-xs: 4px`, `--space-sm: 8px`, `--space-md: 16px`, `--space-lg: 24px`, `--space-xl: 32px`, `--space-2xl: 48px`
- Thêm shadow tokens: `--shadow-sm`, `--shadow-md`, `--shadow-lg`, `--shadow-xl`
- Thêm radius tokens: `--radius-sm: 6px`, `--radius-md: 8px`, `--radius-lg: 12px`, `--radius-xl: 16px`
- Existing color vars giữ nguyên

**Task 1.2** — Xoá CSS trùng lặp trong `head.blade.php`
- Xoá toàn bộ `<style>` block inline trong `head.blade.php` (lines 59-125 approx) — tất cả đã có trong `style.css`
- Giữ lại chỉ `<link>` tags và `<script>` tags
- Xoá duplicate `:root` vars, `.ant-btn-primary`, `.ant-pagination`, `.ant-menu-item-selected`, `.ant-input:focus`, `.brand-icon`, `.category-card`, `.category-grid` rules

**Task 1.3** — Xoá CSS trùng lặp trong `style.css`
- Xoá `:root` block thứ 2 (line ~24-26, chỉ có `--ant-primary-color`)
- Merge vào `:root` block chính (line ~13-21)
- Xoá `body { font-family }` line 311, giữ declaration duy nhất ở cuối file (sẽ update ở Task 2.1)

**Task 1.4** — Thống nhất `body { font-family }` 
- Chỉ giữ 1 declaration: `body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }`
- Xoá `"Roboto"` khỏi tất cả font-family declarations
- Trong `head.blade.php`, đổi Google Fonts link: bỏ `family=Roboto:...`, chỉ giữ Inter

### Phase 2: Thống nhất Breakpoints

**Task 2.1** — Consolidate breakpoints trong `style.css`
- Gộp tất cả `@media` queries thành 5 blocks rõ ràng (cuối file):
  ```
  /* Mobile Small */  @media (max-width: 480px) { ... }
  /* Mobile */        @media (max-width: 768px) { ... }
  /* Tablet */        @media (max-width: 1024px) { ... }
  /* Laptop */        @media (max-width: 1280px) { ... }
  /* Desktop */       @media (min-width: 1281px) { ... }
  ```
- Xoá các breakpoint lẻ: 420px, 576px, 600px, 640px — merge rules vào 480px hoặc 768px tùy ngữ cảnh
- Xoá category-grid responsive rules khỏi `head.blade.php` (đã move vào `style.css`)

**Task 2.2** — Navbar breakpoint
- Thống nhất hamburger menu trigger: `max-width: 1024px` (hiện tại 1200px quá rộng, 768px quá hẹp)
- Update `app.js` `innerWidth` check tương ứng: `<= 1024`
- Mega menu full-width chỉ trên `min-width: 1025px`

**Task 2.3** — Grid columns final
| Breakpoint | Category Grid | Account Grid |
|---|---|---|
| ≤480px | 2 cols, gap 8px | 2 cols, gap 8px |
| ≤768px | 2 cols, gap 12px | 2 cols, gap 12px |
| ≤1024px | 3 cols, gap 14px | 3 cols, gap 14px |
| ≤1280px | 4 cols, gap 16px | 3 cols, gap 16px |
| ≥1281px | 5 cols, gap 20px | 4 cols, gap 20px |
- Xoá tất cả `!important` trên grid rules — chỉ dùng source order

### Phase 3: Cải thiện UI Components

**Task 3.1** — Card redesign
- `.category-card`: border `1px solid #e5e7eb` (bỏ red border), `border-radius: var(--radius-lg)`, hover thêm `box-shadow: var(--shadow-lg)` + subtle `border-color: var(--primary-light)`, bỏ dùng GIF image làm CTA → thay bằng styled button text `"Xem ngay →"`
- `.account-card`: thống nhất 1 definition duy nhất, `border-radius: var(--radius-lg)`, `overflow: hidden`, hover shadow `var(--shadow-md)`
- `.auth-card`: thống nhất `max-width: 440px` cho cả login và register

**Task 3.2** — Button system 
- Thống nhất tất cả buttons dùng design tokens:
  ```css
  .btn { padding: 8px 16px; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; }
  .btn-sm { padding: 6px 12px; font-size: 0.8rem; }
  .btn-lg { padding: 12px 24px; font-size: 1rem; }
  ```
- `.action-btn`, `.filter-btn`, `.ecom-btn` đều inherit base `.btn` sizing concept
- Active state: `transform: scale(0.97)` thay vì `scale(0.98)`
- Tất cả buttons trên mobile có `min-height: 44px` (touch target)

**Task 3.3** — Navbar improvements
- Desktop: giảm `.nav-links a` padding `6px 12px` → `8px 14px` cho dễ bấm hơn
- Mobile offcanvas: tăng width `290px` → `300px`, thêm `box-shadow: -8px 0 30px rgba(0,0,0,0.15)`
- Xoá duplicate preloader — chỉ giữ `#pagePreloader` trong `header.blade.php`, sửa màu spinner dùng `var(--primary)` thay vì `--bs-primary`
- Xoá `#global-preloader` trong `head.blade.php`

**Task 3.4** — Footer cleanup
- Move inline styles sang CSS classes trong `style.css`
- Dùng CSS variables cho colors thay vì hardcoded `#333`, `#1a1a1a`, `#4a4a4a`
- Fix "Liên hệ" link `href="#"` → link đến trang contact hoặc Zalo

**Task 3.5** — Shadows & Elevation system
```css
--shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
--shadow-md: 0 4px 12px rgba(0,0,0,0.08);
--shadow-lg: 0 8px 24px rgba(0,0,0,0.1);
--shadow-xl: 0 12px 32px rgba(0,0,0,0.12);
```
- Replace tất cả magic-number shadows trong codebase bằng tokens tương ứng

**Task 3.6** — Login/Register page
- Merge CSS chung giữa login và register thành 1 shared stylesheet section trong `style.css` (hoặc `legacy-compat.css`)
- Xoá `@push('css')` duplicate trong cả 2 files
- Thống nhất `max-width: 440px` cho `.auth-card`

### Phase 4: Responsive Polish

**Task 4.1** — Hero section mobile
- ≤768px: grid `1fr`, hero-left order 2, hero-right order 1
- ≤480px: banner min-height `160px`, slide-content p `display: none`
- Top deposit panel: `max-height: 300px` trên mobile, scrollable

**Task 4.2** — Filter bar mobile
- ≤768px: inputs stack full-width, buttons cũng full-width
- ≤1024px: 2 columns grid

**Task 4.3** — Product detail (ecom layout) mobile
- ≤1024px: flex-direction column, right panel full-width
- Gallery thumbs: horizontal scroll row trên mobile

**Task 4.4** — Profile page mobile
- ≤768px: sidebar full-width, main full-width, stacked
- Sidebar collapse thành accordion/dropdown trên mobile (optional, can skip)

**Task 4.5** — Bottom mobile nav polish
- Fix active state: use `request()->routeIs()` instead of hardcoded class
- Ensure `z-index` above floating support buttons
- Dark mode styles

**Task 4.6** — Form inputs iOS zoom prevention
- All inputs/selects on mobile get `font-size: 16px` to prevent iOS auto-zoom

### Phase 5: Dark Mode Fixes

**Task 5.1** — Fix dark mode gaps
- Preloader spinner: `var(--primary)` not `--bs-primary` or `--ant-primary`
- Footer inline colors → CSS var overrides
- Live purchase toast accent: `var(--primary)` not `#0d6efd`
- Profile page embedded dark styles → move to `style.css` or `legacy-compat.css`

### Phase 6: Performance

**Task 6.1** — Font optimization
- Remove Roboto from Google Fonts URL in `head.blade.php`
- Add `font-display: swap` to font link
- Remove `tailwind.config.js` Figtree reference (unused)

**Task 6.2** — Remove unused preloader
- Delete `#global-preloader` markup and CSS from `head.blade.php`
- Keep only `#pagePreloader` in `header.blade.php`

---

## Files Affected
| File | Changes |
|---|---|
| `public/css/style.css` | Major: design tokens, consolidated breakpoints, component redesign, shadow system |
| `public/css/legacy-compat.css` | Minor: remove conflicting account-card styles, add auth shared styles |
| `resources/views/layouts/user/head.blade.php` | Remove duplicate inline styles, update font link |
| `resources/views/layouts/user/header.blade.php` | Fix preloader color, navbar tweaks |
| `resources/views/layouts/user/footer.blade.php` | Move inline styles to classes, fix links, bottom nav active state |
| `resources/views/layouts/user/app.blade.php` | Minor cleanup |
| `resources/views/user/login.blade.php` | Remove `@push('css')`, use shared auth styles |
| `resources/views/user/register.blade.php` | Remove `@push('css')`, use shared auth styles |
| `resources/views/user/home.blade.php` | Category card CTA change (GIF → button) |
| `resources/views/user/category/show.blade.php` | No structural changes, inherits grid fixes |
| `resources/views/user/account/detail.blade.php` | Inherits ecom layout responsive fixes |
| `resources/views/user/profile/profile.blade.php` | Move inline dark styles to stylesheet |
| `public/js/app.js` | Update innerWidth breakpoint to 1024 |
| `tailwind.config.js` | Remove Figtree font reference |

## Risks
- **Ant Design CSS override:** Removing duplicate selectors may expose Ant Design defaults. Test pagination, buttons after changes.
- **`!important` removal on grids:** Some inline-style grids in Blade templates may override. Need to check no template has `style="grid-template-columns:..."` that fights.
- **GIF CTA replacement on category cards:** Visual change users will notice. The GIF `/img/tag_69e1555d8bab7.gif` with imgur fallback will be replaced by a CSS button.

## Validation
1. Test all pages on Chrome DevTools at: 375px (iPhone SE), 390px (iPhone 14), 768px (iPad), 1024px (iPad Pro landscape), 1280px (laptop), 1440px (desktop)
2. Toggle dark mode on each page
3. Test hamburger menu open/close at 1024px boundary
4. Test bottom mobile nav active states on different routes
5. Verify no iOS input zoom on mobile
6. Check Lighthouse performance score before/after (font savings)

## Out of Scope
- Google Translate integration cleanup
- Removing Ant Design CSS dependency
- Restructuring Blade component architecture
- Adding CSS preprocessor (Sass/PostCSS)
- Fake purchase toast ethical concerns
