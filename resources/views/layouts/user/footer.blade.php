<footer class="footer" style="margin-top:auto;padding:32px 0 20px;">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand -->
            <div class="footer-brand">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                    @if(config_get('site_logo_footer', config_get('site_logo')))
                        <img src="{{ asset(config_get('site_logo_footer', config_get('site_logo'))) }}" alt="{{ config_get('site_name') }}" width="120" height="32" style="height:32px; width:auto; object-fit:contain;" loading="lazy">
                    @else
                        <span class="brand-text" style="font-weight:700;font-size:1.2rem;">{{ config_get('site_name', 'ShopGame') }}</span>
                    @endif
                </div>
                <p style="font-size:0.85rem;line-height:1.7;margin:0;">
                    {{ config_get('site_description') }}
                </p>
            </div>

            <!-- Quick Links -->
            <div class="footer-col">
                <h4>Truy cập nhanh</h4>
                <ul>
                    <li><a href="/" class="footer-link">Trang Chủ</a></li>
                    <li><a href="{{ route('profile.deposit-card') }}" class="footer-link">Nạp Tiền</a></li>
                    <li><a href="{{ route('profile.transaction-history') }}" class="footer-link">Lịch Sử Mua</a></li>
                    <li><a href="{{ route('news.index') }}" class="footer-link">Tin Tức</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="footer-col">
                <h4>Hỗ trợ</h4>
                <ul>
                    <li><a href="{{ config_get('zalo') ? 'https://zalo.me/' . config_get('zalo') : '#' }}" class="footer-link" {{ config_get('zalo') ? 'target="_blank" rel="noopener noreferrer"' : '' }}>Liên hệ</a></li>
                    <li><a href="{{ route('faq') }}" class="footer-link">Câu hỏi thường gặp</a></li>
                    <li><a href="{{ route('terms') }}" class="footer-link">Điều khoản sử dụng</a></li>
                    <li><a href="{{ route('privacy') }}" class="footer-link">Chính sách bảo mật</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-col">
                <h4>Liên hệ</h4>
                <div class="footer-contact-list" style="display:flex;flex-direction:column;gap:10px;font-size:0.85rem;">
                    <div>Email: <a href="mailto:{{ config_get('email') }}" class="footer-link">{{ config_get('email') }}</a></div>
                    <div>Hotline: {{ config_get('phone') }}</div>
                    <div>Giờ làm việc: {{ config_get('working_hours') }}</div>
                </div>
                <div style="display:flex;gap:10px;margin-top:16px;">
                    @if(config_get('facebook'))
                    <a href="{{ config_get('facebook') }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook" style="color:#1877f2;font-size:1.5rem;"><i class="fab fa-facebook"></i></a>
                    @endif
                    @if(config_get('youtube'))
                    <a href="{{ config_get('youtube') }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube" style="color:#ff0000;font-size:1.5rem;"><i class="fab fa-youtube"></i></a>
                    @endif
                    @if(config_get('telegram'))
                    <a href="{{ config_get('telegram') }}" target="_blank" rel="noopener noreferrer" aria-label="Telegram" style="color:#0088cc;font-size:1.5rem;"><i class="fab fa-telegram"></i></a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
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

<!-- Mobile Bottom Nav with Glassmorphism & Floating Action Button -->
<nav class="mobile-bottom-nav">
    <div class="mobile-bottom-nav-container">
        <a href="/" class="bottom-nav-item {{ request()->is('/') ? 'active' : '' }}">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:home-outlined"></span>
            </div>
            <span class="bottom-nav-label">Trang chủ</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        <a href="/#categories" class="bottom-nav-item">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:appstore-outlined"></span>
            </div>
            <span class="bottom-nav-label">Danh mục</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        
        <!-- Floating Center Action Button for Deposit -->
        <a href="javascript:void(0)" class="bottom-nav-item bottom-nav-fab" onclick="document.getElementById('depositMethodModal').style.display='flex'">
            <div class="bottom-fab-btn">
                <i class="fa-solid fa-wallet"></i>
                <div class="bottom-fab-pulse"></div>
            </div>
            <span class="bottom-nav-label fab-label">Nạp tiền</span>
        </a>

        <a href="{{ route('profile.transaction-history') }}" class="bottom-nav-item {{ request()->routeIs('profile.transaction-history') ? 'active' : '' }}">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:history-outlined"></span>
            </div>
            <span class="bottom-nav-label">Lịch sử</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        @if(Auth::check())
        <a href="/profile" class="bottom-nav-item {{ request()->is('profile*') && !request()->routeIs('profile.transaction-history') ? 'active' : '' }}">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:user-outlined"></span>
            </div>
            <span class="bottom-nav-label">Tài khoản</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        @else
        <a href="{{ route('login') }}" class="bottom-nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:login-outlined"></span>
            </div>
            <span class="bottom-nav-label">Đăng nhập</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        @endif
    </div>
</nav>
