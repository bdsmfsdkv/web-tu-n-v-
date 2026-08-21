<footer class="footer" style="margin-top:auto;padding:36px 0 20px;">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:40px;margin-bottom:32px;flex-wrap:wrap;">
            <!-- Left Side: Brand Info -->
            <div style="flex:1 1 320px;max-width:400px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                    <?php if(config_get('site_logo_footer', config_get('site_logo'))): ?>
                        <img src="<?php echo e(asset(config_get('site_logo_footer', config_get('site_logo')))); ?>" alt="<?php echo e(config_get('site_name')); ?>" width="140" height="36" style="height:36px; width:auto; object-fit:contain;" loading="lazy">
                    <?php else: ?>
                        <span class="brand-text" style="font-weight:800;font-size:1.3rem;color:var(--primary,#dc2626);"><?php echo e(config_get('site_name', 'ShopGame')); ?></span>
                    <?php endif; ?>
                </div>
                <p style="font-size:0.88rem;line-height:1.7;margin:0 0 16px;color:#64748b;">
                    <?php echo e(config_get('site_description', 'Hệ thống cung cấp tài khoản game uy tín hàng đầu, tự động 24/7.')); ?>

                </p>
                <div style="display:flex;gap:12px;align-items:center;">
                    <?php if(config_get('facebook')): ?>
                    <a href="<?php echo e(config_get('facebook')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook" style="color:#1877f2;font-size:1.4rem;transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-facebook"></i></a>
                    <?php endif; ?>
                    <?php if(config_get('youtube')): ?>
                    <a href="<?php echo e(config_get('youtube')); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube" style="color:#ff0000;font-size:1.4rem;transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                    <?php if(config_get('telegram')): ?>
                    <a href="<?php echo e(config_get('telegram')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Telegram" style="color:#0088cc;font-size:1.4rem;transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-telegram"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Side: Links Columns -->
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(140px, 1fr));gap:28px;flex:2 1 500px;">
                <!-- Quick Links -->
                <div class="footer-col">
                    <h4 style="color:#1a1a1a;font-size:0.9rem;font-weight:700;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px;">Truy cập nhanh</h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                        <li><a href="/" class="footer-link">Trang Chủ</a></li>
                        <li><a href="<?php echo e(route('profile.deposit-card')); ?>" class="footer-link">Nạp Tiền</a></li>
                        <li><a href="<?php echo e(route('profile.transaction-history')); ?>" class="footer-link">Lịch Sử Mua</a></li>
                        <li><a href="<?php echo e(route('news.index')); ?>" class="footer-link">Tin Tức</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="footer-col">
                    <h4 style="color:#1a1a1a;font-size:0.9rem;font-weight:700;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px;">Hỗ trợ</h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                        <li><a href="<?php echo e(config_get('zalo') ? 'https://zalo.me/' . config_get('zalo') : '#'); ?>" class="footer-link" <?php echo e(config_get('zalo') ? 'target="_blank" rel="noopener noreferrer"' : ''); ?>>Liên hệ</a></li>
                        <li><a href="<?php echo e(route('faq')); ?>" class="footer-link">Câu hỏi thường gặp</a></li>
                        <li><a href="<?php echo e(route('terms')); ?>" class="footer-link">Điều khoản sử dụng</a></li>
                        <li><a href="<?php echo e(route('privacy')); ?>" class="footer-link">Chính sách bảo mật</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-col">
                    <h4 style="color:#1a1a1a;font-size:0.9rem;font-weight:700;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px;">Liên hệ</h4>
                    <div class="footer-contact-list" style="display:flex;flex-direction:column;gap:10px;font-size:0.85rem;color:#64748b;">
                        <?php if(config_get('email')): ?>
                        <div>Email: <a href="mailto:<?php echo e(config_get('email')); ?>" class="footer-link" style="color:var(--text-color,#1e293b);font-weight:500;"><?php echo e(config_get('email')); ?></a></div>
                        <?php endif; ?>
                        <?php if(config_get('phone')): ?>
                        <div>Hotline: <a href="tel:<?php echo e(config_get('phone')); ?>" class="footer-link" style="color:var(--primary,#dc2626);font-weight:700;"><?php echo e(config_get('phone')); ?></a></div>
                        <?php endif; ?>
                        <?php if(config_get('working_hours')): ?>
                        <div>Giờ làm việc: <span style="font-weight:500;color:var(--text-color,#1e293b);"><?php echo e(config_get('working_hours')); ?></span></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom-bar" style="border-top:1px solid #e5e7eb;padding:20px 0;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;font-size:0.8rem;">
            <div>© <?php echo e(date('Y')); ?> <?php echo e(config_get('site_name')); ?>. Tất cả quyền được bảo lưu.</div>
            <div style="display:flex;align-items:center;gap:8px;">
                <?php if(config_get('zalo')): ?>
                    <a href="https://zalo.me/<?php echo e(config_get('zalo')); ?>" target="_blank" rel="noopener noreferrer" style="color:#0068ff;text-decoration:none;font-weight:600;">Zalo: <?php echo e(config_get('zalo')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<?php if (! $__env->hasRenderedOnce('415f08ba-9181-4946-a47c-4d1d1d22790d')): $__env->markAsRenderedOnce('415f08ba-9181-4946-a47c-4d1d1d22790d'); ?>
<style id="final-header-account-tweaks">
    /* Language selector now lives only inside THÔNG TIN TÀI KHOẢN. */
    html body nav.navbar .nav-user > .ant-header-lang-dropdown,
    html body #avatarDropdown .profile-language-section {
        display: none !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }

    /* ===== FINAL NAV INTERACTIONS: one timing/easing for the whole header ===== */
    html body nav.navbar {
        --nav-fast: 140ms;
        --nav-normal: 180ms;
        --nav-ease: cubic-bezier(.2,.8,.2,1);
    }

    html body nav.navbar .nav-link-item,
    html body nav.navbar .theme-toggle,
    html body nav.navbar .nav-toggle,
    html body nav.navbar .nav-avatar,
    html body nav.navbar .btn-nav-login,
    html body nav.navbar .btn-nav-register,
    html body nav.navbar .btn-mobile-login,
    html body nav.navbar .btn-mobile-reg,
    html body nav.navbar .dropdown-link-card,
    html body nav.navbar .mega-menu-item,
    html body #avatarDropdown .dropdown-item,
    html body #avatarDropdown .dropdown-btn-deposit {
        transition:
            color var(--nav-fast) ease,
            background-color var(--nav-fast) ease,
            border-color var(--nav-fast) ease,
            box-shadow var(--nav-normal) ease,
            transform var(--nav-normal) var(--nav-ease),
            opacity var(--nav-fast) ease !important;
    }

    html body nav.navbar .nav-arrow {
        transition: transform var(--nav-normal) var(--nav-ease), color var(--nav-fast) ease !important;
    }

    /* Fine-pointer hover only: avoids sticky hover states on phones. */
    @media (hover: hover) and (pointer: fine) {
        html body nav.navbar .nav-link-item:hover {
            color: #dc2626 !important;
            background: rgba(220,38,38,.075) !important;
        }

        html body nav.navbar .theme-toggle:hover,
        html body nav.navbar .nav-toggle:hover,
        html body nav.navbar .nav-avatar:hover {
            border-color: rgba(220,38,38,.28) !important;
            background: rgba(220,38,38,.055) !important;
            box-shadow: 0 5px 14px rgba(15,23,42,.07) !important;
        }

        html body nav.navbar .dropdown-link-card:hover,
        html body nav.navbar .mega-menu-item:hover,
        html body #avatarDropdown .dropdown-item:hover {
            color: #dc2626 !important;
            background: #fff7f7 !important;
            border-color: rgba(220,38,38,.18) !important;
            transform: translate3d(2px,0,0) !important;
        }

        html body #avatarDropdown .dropdown-btn-deposit:hover {
            filter: none !important;
            transform: translate3d(0,-1px,0) !important;
            box-shadow: 0 7px 16px rgba(220,38,38,.18) !important;
        }
    }

    /* ===== DESKTOP: Danh Mục + Nạp Tiền use the same clean animation ===== */
    @media (min-width: 1200px) {
        html body nav.navbar .nav-dropdown {
            position: relative !important;
            padding-bottom: 7px !important;
            margin-bottom: -7px !important;
        }

        /* Small invisible bridge: easy to move into Nạp Tiền without making it stay open too long. */
        html body nav.navbar .nav-dropdown::after {
            content: "" !important;
            position: absolute !important;
            top: calc(100% - 7px) !important;
            left: -10px !important;
            width: calc(100% + 20px) !important;
            height: 15px !important;
            z-index: 1095 !important;
            pointer-events: auto !important;
        }

        html body nav.navbar .nav-dropdown > .modern-dropdown-menu {
            display: block !important;
            top: calc(100% - 1px) !important;
            left: -10px !important;
            width: 330px !important;
            min-width: 330px !important;
            margin: 0 !important;
            padding: 10px !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0,-6px,0) !important;
            transform-origin: top left !important;
            border-radius: 14px !important;
            box-shadow: 0 16px 40px rgba(15,23,42,.16) !important;
            transition:
                opacity var(--nav-fast) ease,
                transform var(--nav-normal) var(--nav-ease),
                visibility 0s linear var(--nav-normal) !important;
            will-change: transform, opacity !important;
            backface-visibility: hidden !important;
        }

        html body nav.navbar .nav-dropdown:hover > .modern-dropdown-menu,
        html body nav.navbar .nav-dropdown:focus-within > .modern-dropdown-menu,
        html body nav.navbar .nav-dropdown.deposit-click-open > .modern-dropdown-menu {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translate3d(0,0,0) !important;
            transition-delay: 0s !important;
        }

        /* Old JS may keep deposit-hover-open for 700ms. Do not let that class keep the menu visible after the mouse leaves. */
        html body nav.navbar.navbar .nav-links .nav-dropdown.deposit-hover-open:not(:hover):not(:focus-within):not(.deposit-click-open) > .modern-dropdown-menu {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0,-6px,0) !important;
        }

        html body nav.navbar.navbar .nav-links .nav-dropdown.deposit-hover-open:not(:hover):not(:focus-within):not(.deposit-click-open) > .nav-link-item .nav-arrow {
            transform: rotate(0deg) !important;
        }

        html body nav.navbar .nav-mega-dropdown > .mega-menu {
            display: block !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0,-6px,0) !important;
            transform-origin: top center !important;
            transition:
                opacity var(--nav-fast) ease,
                transform var(--nav-normal) var(--nav-ease),
                visibility 0s linear var(--nav-normal) !important;
            will-change: transform, opacity !important;
            backface-visibility: hidden !important;
        }

        html body nav.navbar .nav-mega-dropdown:hover > .mega-menu,
        html body nav.navbar .nav-mega-dropdown:focus-within > .mega-menu {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translate3d(0,0,0) !important;
            transition-delay: 0s !important;
        }

        html body nav.navbar .nav-dropdown:hover > .nav-link-item .nav-arrow,
        html body nav.navbar .nav-dropdown:focus-within > .nav-link-item .nav-arrow,
        html body nav.navbar .nav-dropdown.deposit-click-open > .nav-link-item .nav-arrow,
        html body nav.navbar .nav-mega-dropdown:hover > .nav-link-item .nav-arrow,
        html body nav.navbar .nav-mega-dropdown:focus-within > .nav-link-item .nav-arrow {
            transform: rotate(180deg) !important;
        }

        /* Never fade/hide sibling deposit choices on hover. */
        html body nav.navbar .modern-dropdown-menu > li,
        html body nav.navbar .modern-dropdown-menu:has(> li:hover) > li:not(:hover) {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: none !important;
            filter: none !important;
        }
    }

    /* ===== DESKTOP: remove hover gap + make Nạp Tiền display like Danh Mục ===== */
    @media (min-width: 1200px) and (hover: hover) and (pointer: fine) {
        /* Make the dropdown owners fill the full 64px header height.
           The mouse can travel straight down to the panel without leaving :hover. */
        html body nav.navbar .nav-links > li.nav-mega-dropdown,
        html body nav.navbar .nav-links > li.nav-dropdown {
            display: flex !important;
            height: 64px !important;
            min-height: 64px !important;
            margin: 0 !important;
            padding: 0 !important;
            align-items: center !important;
        }

        html body nav.navbar .nav-links > li.nav-dropdown {
            position: relative !important;
        }

        html body nav.navbar .nav-links > li.nav-dropdown::after {
            content: none !important;
            display: none !important;
            pointer-events: none !important;
        }

        /* Remove the old full-menu-width invisible bridge.
           Nạp Tiền now gets the same real hover boundary as Danh Mục. */
        html body nav.navbar .nav-links > li.nav-dropdown > .modern-dropdown-menu::before {
            content: none !important;
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            pointer-events: none !important;
        }

        /* Danh Mục panel begins exactly where the header ends. */
        html body nav.navbar .nav-mega-dropdown > .mega-menu {
            top: 64px !important;
        }

        /* Turn the old small Nạp Tiền popup into a full-width mega panel. */
        html body nav.navbar .nav-dropdown > .modern-dropdown-menu {
            position: fixed !important;
            top: 64px !important;
            right: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            min-width: 0 !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 18px max(20px, calc((100vw - 1260px) / 2 + 20px)) 22px !important;
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)) !important;
            gap: 16px !important;
            list-style: none !important;
            background: rgba(255,255,255,.99) !important;
            border-top: 1px solid #f1f5f9 !important;
            border-right: 0 !important;
            border-bottom: 1px solid #e5e7eb !important;
            border-left: 0 !important;
            border-radius: 0 !important;
            box-shadow: 0 18px 35px rgba(15,23,42,.10) !important;
            transform-origin: top center !important;
            z-index: 1050 !important;
        }

        html body nav.navbar .modern-dropdown-menu > li {
            display: block !important;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 14px !important;
            list-style: none !important;
            background: #f8fafc !important;
            border: 1px solid #eef2f7 !important;
            border-radius: 12px !important;
        }

        html body nav.navbar .modern-dropdown-menu > li > .dropdown-link-card {
            display: flex !important;
            width: 100% !important;
            min-height: 74px !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 12px 14px !important;
            align-items: center !important;
            gap: 13px !important;
            color: #374151 !important;
            background: #fff !important;
            border: 1px solid #edf0f4 !important;
            border-radius: 8px !important;
            box-shadow: none !important;
            transform: none !important;
        }

        html body nav.navbar .modern-dropdown-menu > li > .dropdown-link-card:hover {
            color: #dc2626 !important;
            background: #fff !important;
            border-color: rgba(220,38,38,.28) !important;
            box-shadow: 0 7px 18px rgba(15,23,42,.06) !important;
            transform: translateY(-1px) !important;
        }

        html body nav.navbar .modern-dropdown-menu .dropdown-link-icon-box {
            width: 40px !important;
            height: 40px !important;
            min-width: 40px !important;
            flex: 0 0 40px !important;
            border-radius: 9px !important;
        }

        html body nav.navbar .modern-dropdown-menu .dropdown-link-title {
            display: block !important;
            color: #111827 !important;
            font-size: .88rem !important;
            font-weight: 800 !important;
            line-height: 1.3 !important;
        }

        html body nav.navbar .modern-dropdown-menu .dropdown-link-desc {
            display: block !important;
            margin-top: 4px !important;
            color: #6b7280 !important;
            font-size: .73rem !important;
            line-height: 1.35 !important;
        }

        [data-theme="dark"] body nav.navbar .nav-dropdown > .modern-dropdown-menu {
            background: rgba(23,23,23,.99) !important;
            border-color: #2a2a2a !important;
        }

        [data-theme="dark"] body nav.navbar .modern-dropdown-menu > li {
            background: #1d1d1d !important;
            border-color: #2d2d2d !important;
        }

        [data-theme="dark"] body nav.navbar .modern-dropdown-menu > li > .dropdown-link-card {
            color: #d1d5db !important;
            background: #222 !important;
            border-color: #303030 !important;
        }

        [data-theme="dark"] body nav.navbar .modern-dropdown-menu .dropdown-link-title {
            color: #f3f4f6 !important;
        }

        [data-theme="dark"] body nav.navbar .modern-dropdown-menu .dropdown-link-desc {
            color: #9ca3af !important;
        }
    }

    /* ===== TABLET/MOBILE: fix blurred hamburger panel ===== */
    @media (max-width: 1199px) {
        html body .nav-overlay {
            position: fixed !important;
            top: 56px !important;
            right: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            z-index: 11940 !important;
            background: rgba(15,23,42,.26) !important;
            -webkit-backdrop-filter: none !important;
            backdrop-filter: none !important;
            filter: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transition: opacity var(--nav-normal) ease, visibility 0s linear var(--nav-normal) !important;
        }

        html body .nav-overlay.show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transition-delay: 0s !important;
        }

        html body nav.navbar .nav-links {
            z-index: 12030 !important;
            background: #fff !important;
            -webkit-backdrop-filter: none !important;
            backdrop-filter: none !important;
            filter: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0,-9px,0) !important;
            transform-origin: top center !important;
            transition:
                opacity var(--nav-fast) ease,
                transform var(--nav-normal) var(--nav-ease),
                visibility 0s linear var(--nav-normal) !important;
            will-change: transform, opacity !important;
            backface-visibility: hidden !important;
        }

        html body nav.navbar .nav-links.show {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translate3d(0,0,0) !important;
            transition-delay: 0s !important;
        }

        html body nav.navbar .nav-links .nav-link-item {
            transform: none !important;
        }

        html body nav.navbar .nav-links .nav-link-item:active,
        html body nav.navbar .nav-dropdown.open > .nav-link-item,
        html body nav.navbar .nav-mega-dropdown.open > .nav-link-item {
            color: #dc2626 !important;
            background: rgba(220,38,38,.075) !important;
        }

        /* Animate submenus without display:none/block jumps. */
        html body nav.navbar .modern-dropdown-menu,
        html body nav.navbar .mega-menu {
            display: block !important;
            position: static !important;
            width: 100% !important;
            min-width: 100% !important;
            max-height: 0 !important;
            margin: 0 !important;
            padding: 0 6px !important;
            overflow: hidden !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0,-4px,0) !important;
            border-width: 0 !important;
            box-shadow: none !important;
            transition:
                max-height 240ms var(--nav-ease),
                opacity var(--nav-fast) ease,
                transform var(--nav-normal) var(--nav-ease),
                margin var(--nav-normal) ease,
                padding var(--nav-normal) ease,
                visibility 0s linear 240ms !important;
            will-change: max-height, opacity, transform !important;
        }

        html body nav.navbar .nav-dropdown.open > .modern-dropdown-menu {
            max-height: 320px !important;
            margin: 4px 0 7px !important;
            padding: 6px !important;
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translate3d(0,0,0) !important;
            border-width: 1px !important;
            transition-delay: 0s !important;
        }

        html body nav.navbar .nav-mega-dropdown.open > .mega-menu {
            max-height: min(68vh,720px) !important;
            margin: 4px 0 7px !important;
            padding: 6px !important;
            overflow-y: auto !important;
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translate3d(0,0,0) !important;
            border-width: 1px !important;
            transition-delay: 0s !important;
        }

        html body nav.navbar .nav-dropdown.open > .nav-link-item .nav-arrow,
        html body nav.navbar .nav-mega-dropdown.open > .nav-link-item .nav-arrow {
            transform: rotate(180deg) !important;
        }

        html body nav.navbar .dropdown-link-card:active,
        html body nav.navbar .mega-menu-item:active {
            color: #dc2626 !important;
            background: #fff1f2 !important;
        }
    }

    [data-theme="dark"] body nav.navbar .nav-links {
        background: #171717 !important;
    }

    @media (hover: hover) and (pointer: fine) {
        [data-theme="dark"] body nav.navbar .dropdown-link-card:hover,
        [data-theme="dark"] body nav.navbar .mega-menu-item:hover,
        [data-theme="dark"] body #avatarDropdown .dropdown-item:hover {
            background: #2a1d1d !important;
            border-color: #4b2427 !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        html body nav.navbar *,
        html body .nav-overlay,
        html body #avatarDropdown * {
            animation-duration: .01ms !important;
            transition-duration: .01ms !important;
            transition-delay: 0s !important;
        }
    }

    /* Explicit click state for both category and deposit menus. */
    html body nav.navbar .nav-menu-trigger {
        appearance: none;
        border: 0;
        cursor: pointer;
        font: inherit;
    }

    /* Native state. Must defeat every legacy display rule. */
    html body nav.navbar .mega-menu[hidden],
    html body nav.navbar .modern-dropdown-menu[hidden] {
        display: none !important;
    }

    /* Button keeps :focus after tap/click. This explicit state must beat it. */
    html body nav.navbar .nav-mega-dropdown.menu-closed > .mega-menu {
        display: none !important;
        max-height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        opacity: 0 !important;
        visibility: hidden !important;
        pointer-events: none !important;
        transform: translate3d(0, -4px, 0) !important;
        border-width: 0 !important;
    }

    html body nav.navbar .nav-mega-dropdown.menu-closed > .nav-menu-trigger .nav-arrow {
        transform: rotate(0deg) !important;
    }

    /* Desktop panels open from visible trigger or panel only, never empty LI area. */
    @media (min-width: 1200px) and (hover: hover) and (pointer: fine) {
        html body nav.navbar .nav-dropdown:not(:has(> .nav-link-item:hover)):not(:has(> .modern-dropdown-menu:hover)):not(:focus-within):not(.deposit-click-open) > .modern-dropdown-menu,
        html body nav.navbar .nav-mega-dropdown:not(:has(> .nav-link-item:hover)):not(:has(> .mega-menu:hover)):not(:focus-within) > .mega-menu {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0, -6px, 0) !important;
            transition-delay: 0s, 0s, var(--nav-normal) !important;
        }

        html body nav.navbar .nav-dropdown:has(> .nav-link-item:hover) > .modern-dropdown-menu,
        html body nav.navbar .nav-dropdown:has(> .modern-dropdown-menu:hover) > .modern-dropdown-menu,
        html body nav.navbar .nav-mega-dropdown:has(> .nav-link-item:hover) > .mega-menu,
        html body nav.navbar .nav-mega-dropdown:has(> .mega-menu:hover) > .mega-menu {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translate3d(0, 0, 0) !important;
            transition-delay: 0s !important;
        }
    }

    /* Final desktop menu. Ignore all legacy hover/pointer states above. */
    @media (min-width: 1200px) {
        html body nav.navbar .nav-mega-dropdown:not(:has(> .deposit-mega-menu)) > .mega-menu {
            display: block !important;
            top: 64px !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0, -6px, 0) !important;
        }

        html body nav.navbar .nav-mega-dropdown:not(:has(> .deposit-mega-menu)):hover > .mega-menu,
        html body nav.navbar .nav-mega-dropdown:not(:has(> .deposit-mega-menu)):focus-within > .mega-menu {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0, -6px, 0) !important;
        }

        html body nav.navbar .nav-mega-dropdown:not(:has(> .deposit-mega-menu)).menu-open > .mega-menu {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translate3d(0, 0, 0) !important;
        }

        html body nav.navbar .nav-mega-dropdown.menu-open > .nav-menu-trigger {
            color: #dc2626 !important;
            background: rgba(220,38,38,.075) !important;
        }

        html body nav.navbar .nav-mega-dropdown.menu-open > .nav-menu-trigger .nav-arrow {
            transform: rotate(180deg) !important;
        }
    }

    /* Category panel uses one plain surface, without gray card wrappers. */
    html body nav.navbar .mega-menu-column,
    html body nav.navbar .mega-menu-column .mega-menu-list {
        background: transparent !important;
        border-color: transparent !important;
        box-shadow: none !important;
    }

    html body nav.navbar .mega-menu-column {
        padding: 14px 0 !important;
        border-radius: 0 !important;
    }

    html body nav.navbar .mega-menu-column .mega-menu-item {
        background: transparent !important;
        border-color: transparent !important;
    }

    html body nav.navbar .mega-menu-column .mega-menu-item:hover {
        background: #fff7f7 !important;
        border-color: rgba(220,38,38,.18) !important;
    }

    [data-theme="dark"] body nav.navbar .mega-menu-column,
    [data-theme="dark"] body nav.navbar .mega-menu-column .mega-menu-list,
    [data-theme="dark"] body nav.navbar .mega-menu-column .mega-menu-item {
        background: transparent !important;
        border-color: transparent !important;
        box-shadow: none !important;
    }

    /* Deposit is a compact white dropdown, not a full-width mega menu. */
    @media (min-width: 1200px) and (hover: hover) and (pointer: fine) {
        html body nav.navbar .nav-mega-dropdown:has(> .deposit-mega-menu) {
            position: relative !important;
            pointer-events: none !important;
        }

        html body nav.navbar .nav-mega-dropdown:has(> .deposit-mega-menu) > .nav-menu-trigger,
        html body nav.navbar .nav-mega-dropdown:has(> .deposit-mega-menu) > .deposit-mega-menu {
            pointer-events: auto !important;
        }

        /* Panel touches trigger. No invisible bridge can open it from surrounding space. */
        html body nav.navbar .nav-mega-dropdown:has(> .deposit-mega-menu) > .nav-menu-trigger::after {
            content: none !important;
            display: none !important;
            pointer-events: none !important;
        }

        html body nav.navbar .nav-mega-dropdown:has(> .deposit-mega-menu) > .deposit-mega-menu {
            display: block !important;
            position: absolute !important;
            top: 100% !important;
            right: auto !important;
            left: 0 !important;
            width: max-content !important;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 8px !important;
            background: #fff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 24px rgba(15,23,42,.12) !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0,-4px,0) !important;
            z-index: 1100 !important;
        }

        html body nav.navbar .nav-mega-dropdown:has(> .deposit-mega-menu) > .deposit-mega-menu::before,
        html body nav.navbar .nav-mega-dropdown:has(> .deposit-mega-menu) > .deposit-mega-menu::after {
            content: none !important;
            display: none !important;
        }

        html body nav.navbar .nav-mega-dropdown:has(> .deposit-mega-menu):has(> .nav-menu-trigger:hover) > .deposit-mega-menu,
        html body nav.navbar .nav-mega-dropdown:has(> .deposit-mega-menu):has(> .deposit-mega-menu:hover) > .deposit-mega-menu {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translate3d(0,0,0) !important;
        }

        html body nav.navbar .deposit-mega-menu .mega-menu-container {
            width: auto !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }

        html body nav.navbar .deposit-mega-menu .deposit-menu-grid {
            display: flex !important;
            width: max-content !important;
            gap: 4px !important;
            background: #fff !important;
        }

        html body nav.navbar .deposit-mega-menu .mega-menu-item {
            width: auto !important;
            min-height: 40px !important;
            padding: 8px 10px !important;
            background: #fff !important;
            border: 1px solid transparent !important;
            box-shadow: none !important;
        }

        html body nav.navbar .deposit-mega-menu .mega-menu-item:hover {
            background: #fff7f7 !important;
            border-color: rgba(220,38,38,.18) !important;
        }

        [data-theme="dark"] body nav.navbar .deposit-mega-menu,
        [data-theme="dark"] body nav.navbar .deposit-mega-menu .mega-menu-container,
        [data-theme="dark"] body nav.navbar .deposit-mega-menu .deposit-menu-grid,
        [data-theme="dark"] body nav.navbar .deposit-mega-menu .mega-menu-item {
            background: #fff !important;
        }

        [data-theme="dark"] body nav.navbar .deposit-mega-menu .mega-menu-item:hover {
            background: #fff7f7 !important;
        }
    }
</style>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\resources\views/layouts/user/footer.blade.php ENDPATH**/ ?>