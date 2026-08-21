<footer class="footer" style="margin-top:auto;padding:36px 0 20px;">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:40px;margin-bottom:32px;flex-wrap:wrap;">
            <!-- Left Side: Brand Info -->
            <div style="flex:1 1 320px;max-width:400px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                    @if(config_get('site_logo_footer', config_get('site_logo')))
                        <img src="{{ asset(config_get('site_logo_footer', config_get('site_logo'))) }}" alt="{{ config_get('site_name') }}" width="140" height="36" style="height:36px; width:auto; object-fit:contain;" loading="lazy">
                    @else
                        <span class="brand-text" style="font-weight:800;font-size:1.3rem;color:var(--primary,#dc2626);">{{ config_get('site_name', 'ShopGame') }}</span>
                    @endif
                </div>
                <p style="font-size:0.88rem;line-height:1.7;margin:0 0 16px;color:#64748b;">
                    {{ config_get('site_description', 'Hệ thống cung cấp tài khoản game uy tín hàng đầu, tự động 24/7.') }}
                </p>
                <div style="display:flex;gap:12px;align-items:center;">
                    @if(config_get('facebook'))
                    <a href="{{ config_get('facebook') }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook" style="color:#1877f2;font-size:1.4rem;transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-facebook"></i></a>
                    @endif
                    @if(config_get('youtube'))
                    <a href="{{ config_get('youtube') }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube" style="color:#ff0000;font-size:1.4rem;transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-youtube"></i></a>
                    @endif
                    @if(config_get('telegram'))
                    <a href="{{ config_get('telegram') }}" target="_blank" rel="noopener noreferrer" aria-label="Telegram" style="color:#0088cc;font-size:1.4rem;transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-telegram"></i></a>
                    @endif
                </div>
            </div>

            <!-- Right Side: Links Columns -->
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(140px, 1fr));gap:28px;flex:2 1 500px;">
                <div class="footer-col">
                    <h4 style="color:#1a1a1a;font-size:0.9rem;font-weight:700;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px;">Truy cập nhanh</h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                        <li><a href="/" class="footer-link">Trang Chủ</a></li>
                        <li><a href="{{ route('profile.deposit-card') }}" class="footer-link">Nạp Tiền</a></li>
                        <li><a href="{{ route('profile.transaction-history') }}" class="footer-link">Lịch Sử Mua</a></li>
                        <li><a href="{{ route('news.index') }}" class="footer-link">Tin Tức</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 style="color:#1a1a1a;font-size:0.9rem;font-weight:700;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px;">Hỗ trợ</h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                        <li><a href="{{ config_get('zalo') ? 'https://zalo.me/' . config_get('zalo') : '#' }}" class="footer-link" {{ config_get('zalo') ? 'target="_blank" rel="noopener noreferrer"' : '' }}>Liên hệ</a></li>
                        <li><a href="{{ route('faq') }}" class="footer-link">Câu hỏi thường gặp</a></li>
                        <li><a href="{{ route('terms') }}" class="footer-link">Điều khoản sử dụng</a></li>
                        <li><a href="{{ route('privacy') }}" class="footer-link">Chính sách bảo mật</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 style="color:#1a1a1a;font-size:0.9rem;font-weight:700;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px;">Liên hệ</h4>
                    <div class="footer-contact-list" style="display:flex;flex-direction:column;gap:10px;font-size:0.85rem;color:#64748b;">
                        @if(config_get('email'))
                        <div>Email: <a href="mailto:{{ config_get('email') }}" class="footer-link" style="color:var(--text-color,#1e293b);font-weight:500;">{{ config_get('email') }}</a></div>
                        @endif
                        @if(config_get('phone'))
                        <div>Hotline: <a href="tel:{{ config_get('phone') }}" class="footer-link" style="color:var(--primary,#dc2626);font-weight:700;">{{ config_get('phone') }}</a></div>
                        @endif
                        @if(config_get('working_hours'))
                        <div>Giờ làm việc: <span style="font-weight:500;color:var(--text-color,#1e293b);">{{ config_get('working_hours') }}</span></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom-bar" style="border-top:1px solid #e5e7eb;padding:20px 0;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;font-size:0.8rem;">
            <div>© {{ date('Y') }} {{ config_get('site_name') }}. Tất cả quyền được bảo lưu.</div>
            <div style="display:flex;align-items:center;gap:8px;">
                @if(config_get('zalo'))
                    <a href="https://zalo.me/{{ config_get('zalo') }}" target="_blank" rel="noopener noreferrer" style="color:#0068ff;text-decoration:none;font-weight:600;">Zalo: {{ config_get('zalo') }}</a>
                @endif
            </div>
        </div>
    </div>
</footer>

@once
<style id="final-header-account-tweaks">
    /* Account/profile-only tweaks live here. Navbar dropdown interaction now lives
       exclusively in public/css/navbar-hover-hotfix.css. */
    html body nav.navbar .nav-user > .ant-header-lang-dropdown,
    html body #avatarDropdown .profile-language-section {
        display: none !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }

    html body nav.navbar {
        --nav-fast: 140ms;
        --nav-normal: 180ms;
        --nav-ease: cubic-bezier(.2,.8,.2,1);
    }

    html body nav.navbar .theme-toggle,
    html body nav.navbar .nav-toggle,
    html body nav.navbar .nav-avatar,
    html body nav.navbar .btn-nav-login,
    html body nav.navbar .btn-nav-register,
    html body nav.navbar .btn-mobile-login,
    html body nav.navbar .btn-mobile-reg,
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

    @media (hover: hover) and (pointer: fine) {
        html body nav.navbar .theme-toggle:hover,
        html body nav.navbar .nav-toggle:hover,
        html body nav.navbar .nav-avatar:hover {
            border-color: rgba(220,38,38,.28) !important;
            background: rgba(220,38,38,.055) !important;
            box-shadow: 0 5px 14px rgba(15,23,42,.07) !important;
        }

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

    @media (hover: hover) and (pointer: fine) {
        [data-theme="dark"] body #avatarDropdown .dropdown-item:hover {
            background: #2a1d1d !important;
            border-color: #4b2427 !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        html body nav.navbar .theme-toggle,
        html body nav.navbar .nav-toggle,
        html body nav.navbar .nav-avatar,
        html body #avatarDropdown * {
            animation-duration: .01ms !important;
            transition-duration: .01ms !important;
            transition-delay: 0s !important;
        }
    }
</style>
@endonce
