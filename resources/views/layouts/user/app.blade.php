<!DOCTYPE html>
<html lang="vi">
@include('layouts.user.head')
<body style="min-height:100vh;display:flex;flex-direction:column;margin:0;">
    <!-- 4-Dot Antd Preloader -->
    <div id="pagePreloader" class="kc-preloader">
        <span class="antd-spin"><i></i><i></i><i></i><i></i></span>
    </div>
    <div id="fui-toast"></div>
    <!-- Navbar -->
    @include('layouts.user.header')
    
    <main style="padding-top:64px;flex:1;">
        @yield('content')
    </main>

    @include('layouts.user.footer')

    <!-- Deposit Method Modal -->
    <div id="depositMethodModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(15,23,42,0.65);z-index:10000;align-items:flex-end;justify-content:center;" onclick="if(event.target===this)this.style.display='none'">
        <div class="deposit-modal-content" style="border-radius:16px 16px 0 0;padding:24px 20px 32px;width:100%;max-width:480px;animation:slideUpModal .25s ease-out;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                <h3 class="deposit-modal-title" style="font-size:1.1rem;font-weight:700;margin:0;">Chọn phương thức nạp</h3>
                <button class="deposit-modal-close" onclick="document.getElementById('depositMethodModal').style.display='none'" style="background:none;border:none;font-size:1.3rem;cursor:pointer;padding:4px;">✕</button>
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <a href="{{ route('profile.deposit-card') }}" class="deposit-modal-link" style="display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;border:1px solid #e5e7eb;text-decoration:none;transition:all .2s;">
                    <div class="deposit-modal-icon-bg card-icon-bg" style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <span class="iconify card-icon" data-icon="ant-design:credit-card-outlined" style="font-size:1.4rem;"></span>
                    </div>
                    <div>
                        <div class="deposit-modal-text" style="font-weight:600;font-size:0.95rem;">Nạp thẻ cào</div>
                        <div class="deposit-modal-subtext" style="font-size:0.78rem;margin-top:2px;">Viettel, Vinaphone, Mobifone...</div>
                    </div>
                    <span class="iconify deposit-modal-arrow" style="margin-left:auto;font-size:1.2rem;" data-icon="ant-design:right-outlined"></span>
                </a>
                <a href="{{ route('profile.deposit-atm') }}" class="deposit-modal-link" style="display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;border:1px solid #e5e7eb;text-decoration:none;transition:all .2s;">
                    <div class="deposit-modal-icon-bg atm-icon-bg" style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <span class="iconify atm-icon" data-icon="ant-design:bank-outlined" style="font-size:1.4rem;"></span>
                    </div>
                    <div>
                        <div class="deposit-modal-text" style="font-weight:600;font-size:0.95rem;">Nạp ngân hàng</div>
                        <div class="deposit-modal-subtext" style="font-size:0.78rem;margin-top:2px;">Chuyển khoản tự động, nhận tiền ngay</div>
                    </div>
                    <span class="iconify deposit-modal-arrow" style="margin-left:auto;font-size:1.2rem;" data-icon="ant-design:right-outlined"></span>
                </a>
                @if (config_get('payment.usdt.active', true))
                <a href="{{ route('profile.deposit-usdt') }}" class="deposit-modal-link" style="display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;border:1px solid #e5e7eb;text-decoration:none;transition:all .2s;">
                    <div class="deposit-modal-icon-bg usdt-icon-bg" style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-brands fa-usps usdt-icon" style="font-size:1.4rem;"></i>
                    </div>
                    <div>
                        <div class="deposit-modal-text" style="font-weight:600;font-size:0.95rem;">Nạp USDT</div>
                        <div class="deposit-modal-subtext" style="font-size:0.78rem;margin-top:2px;">Thanh toán bằng tiền điện tử</div>
                    </div>
                    <span class="iconify deposit-modal-arrow" style="margin-left:auto;font-size:1.2rem;" data-icon="ant-design:right-outlined"></span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <style>
        @keyframes slideUpModal { from { transform: translateY(100%); } to { transform: translateY(0); } }
        .deposit-modal-content { background: #ffffff; }
        .deposit-modal-title { color: #111827; }
        .deposit-modal-close { color: #9ca3af; }
        .deposit-modal-link { color: inherit; border-color: #e5e7eb; }
        .deposit-modal-text { color: #111827; }
        .deposit-modal-subtext { color: #6b7280; }
        .deposit-modal-arrow { color: #d1d5db; }
        .card-icon-bg { background: #fef2f2; }
        .card-icon { color: var(--primary); }
        .atm-icon-bg { background: #f0fdf4; }
        .atm-icon { color: #16a34a; }
        .usdt-icon-bg { background: #fef3c7; }
        .usdt-icon { color: #d97706; }

        [data-theme="dark"] .deposit-modal-content { background: #262626; border-top: 1px solid #404040; }
        [data-theme="dark"] .deposit-modal-title { color: #f9fafb; }
        [data-theme="dark"] .deposit-modal-close { color: #6b7280; }
        [data-theme="dark"] .deposit-modal-link { border-color: #404040; color: #f9fafb; }
        [data-theme="dark"] .deposit-modal-link:hover { background: #171717; }
        [data-theme="dark"] .deposit-modal-text { color: #f9fafb; }
        [data-theme="dark"] .deposit-modal-subtext { color: #9ca3af; }
        [data-theme="dark"] .card-icon-bg { background: rgba(220, 38, 38, 0.1); }
        [data-theme="dark"] .atm-icon-bg { background: rgba(22, 163, 74, 0.1); }
    </style>

    @if(config_get('floating_contact_enabled', true))
    <!-- Collapsible Floating Support Widget -->
    <div class="floating-support" id="floatingSupport">
        <div class="support-items-list" id="supportItemsList">
            <a href="https://zalo.me/{{ config_get('zalo', '0123456789') }}" target="_blank" rel="noopener noreferrer" class="support-item zalo" title="Hỗ trợ Zalo" aria-label="Hỗ trợ Zalo">
                <img src="https://shopaccgamev2.tuanori.vn/images/zalo.webp" alt="Zalo" width="24" height="24" loading="lazy" decoding="async">
                <span class="support-text">Chat Zalo</span>
            </a>
            <a href="{{ config_get('facebook', 'https://facebook.com') }}" target="_blank" rel="noopener noreferrer" class="support-item messenger" title="Hỗ trợ Facebook" aria-label="Hỗ trợ Facebook">
                <img src="https://shopaccgamev2.tuanori.vn/images/facebook.webp" alt="Facebook" width="24" height="24" loading="lazy" decoding="async">
                <span class="support-text">Facebook</span>
            </a>
            <a href="tel:{{ config_get('phone', '0123456789') }}" class="support-item hotline" title="Hotline" aria-label="Hotline">
                <i class="fa-solid fa-phone"></i>
                <span class="support-text">Hotline: {{ config_get('phone', '0123456789') }}</span>
            </a>
        </div>

        <button type="button" class="floating-support-toggle" id="floatingSupportToggle" onclick="window.toggleFloatingSupport && window.toggleFloatingSupport(event)" aria-expanded="false" aria-label="Liên hệ hỗ trợ" title="Liên hệ CSKH">
            <div class="toggle-icon-wrap">
                <i class="fa-solid fa-headset icon-main"></i>
                <i class="fa-solid fa-xmark icon-close"></i>
            </div>
            <span class="support-online-dot"></span>
        </button>
    </div>

    <style>
        .floating-support {
            position: fixed;
            bottom: 75px;
            right: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 99999;
            pointer-events: none;
            user-select: none;
        }

        .support-items-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(20px) scale(0.85);
            transform-origin: bottom center;
            transition: opacity 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                        visibility 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .floating-support.is-open .support-items-list {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0) scale(1);
        }

        .support-item {
            position: relative;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            opacity: 0;
            transform: translateY(12px) scale(0.7);
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.22s ease,
                        opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1),
                        border-color 0.2s ease;
            pointer-events: none;
        }

        .floating-support.is-open .support-item {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        /* Staggered entry animation */
        .floating-support.is-open .support-item.hotline {
            transition-delay: 0.03s;
        }
        .floating-support.is-open .support-item.messenger {
            transition-delay: 0.07s;
        }
        .floating-support.is-open .support-item.zalo {
            transition-delay: 0.11s;
        }

        .support-item:hover {
            transform: translateY(-2px) scale(1.08);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .support-item:active {
            transform: scale(0.96);
        }

        .support-item img {
            display: block;
            width: 24px;
            height: 24px;
            object-fit: contain;
            pointer-events: none;
        }

        .support-item.hotline {
            background: #ef4444;
            color: #ffffff;
            border-color: #dc2626;
            font-size: 1.05rem;
        }
        .support-item.hotline:hover {
            background: #dc2626;
        }

        .support-text {
            position: absolute;
            right: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%) translateX(6px);
            background: #1e293b;
            color: #ffffff;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
            pointer-events: none;
        }

        .support-text::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            margin-top: -4px;
            border-width: 4px 0 4px 5px;
            border-style: solid;
            border-color: transparent transparent transparent #1e293b;
        }

        .support-item:hover .support-text {
            opacity: 1;
            visibility: visible;
            transform: translateY(-50%) translateX(0);
        }

        .floating-support-toggle {
            position: relative;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 16px rgba(220, 38, 38, 0.4);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            outline: none;
            pointer-events: auto;
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1),
                        background 0.25s ease,
                        box-shadow 0.25s ease;
        }

        .floating-support-toggle:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.5);
        }

        .floating-support-toggle:active {
            transform: scale(0.94);
        }

        .floating-support.is-open .floating-support-toggle {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
        }

        /* Radar Pulse Animation when closed */
        .floating-support:not(.is-open) .floating-support-toggle::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid rgba(239, 68, 68, 0.6);
            animation: supportPulse 2s infinite cubic-bezier(0.24, 0, 0.38, 1);
            pointer-events: none;
        }

        @keyframes supportPulse {
            0% {
                transform: scale(0.95);
                opacity: 0.8;
            }
            70% {
                transform: scale(1.35);
                opacity: 0;
            }
            100% {
                transform: scale(1.45);
                opacity: 0;
            }
        }

        .toggle-icon-wrap {
            position: relative;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            pointer-events: none;
        }

        .toggle-icon-wrap .icon-main,
        .toggle-icon-wrap .icon-close {
            position: absolute;
            transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                        opacity 0.24s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .toggle-icon-wrap .icon-main {
            opacity: 1;
            transform: rotate(0) scale(1);
        }

        .toggle-icon-wrap .icon-close {
            opacity: 0;
            transform: rotate(-90deg) scale(0.5);
        }

        .floating-support.is-open .toggle-icon-wrap .icon-main {
            opacity: 0;
            transform: rotate(90deg) scale(0.5);
        }

        .floating-support.is-open .toggle-icon-wrap .icon-close {
            opacity: 1;
            transform: rotate(0) scale(1);
        }

        .support-online-dot {
            position: absolute;
            top: 1px;
            right: 1px;
            width: 11px;
            height: 11px;
            background: #22c55e;
            border: 2px solid #ffffff;
            border-radius: 50%;
            pointer-events: none;
        }

        [data-theme="dark"] .support-item {
            background: #27272a;
            border-color: rgba(255, 255, 255, 0.12);
        }
        [data-theme="dark"] .support-item.hotline {
            background: #ef4444;
            color: #ffffff;
            border-color: #dc2626;
        }
        [data-theme="dark"] .support-text {
            background: #0f172a;
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        [data-theme="dark"] .support-text::after {
            border-color: transparent transparent transparent #0f172a;
        }

        @media (max-width: 768px) {
            .floating-support {
                bottom: 68px;
                right: 14px;
            }
            .floating-support-toggle {
                width: 42px;
                height: 42px;
            }
            .support-item {
                width: 38px;
                height: 38px;
            }
            .support-item img {
                width: 20px;
                height: 20px;
            }
            .support-text {
                display: none !important;
            }
        }
    </style>

    <script>
    (function() {
        window.toggleFloatingSupport = function(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            var supportWrap = document.getElementById('floatingSupport');
            var supportToggle = document.getElementById('floatingSupportToggle');
            if (supportWrap) {
                var isOpen = supportWrap.classList.toggle('is-open');
                if (supportToggle) {
                    supportToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                }
            }
        };

        function initFloatingSupport() {
            var supportWrap = document.getElementById('floatingSupport');
            var supportToggle = document.getElementById('floatingSupportToggle');
            if (!supportWrap || !supportToggle) return;

            // Handle outside click to close
            document.addEventListener('click', function(e) {
                if (supportWrap.classList.contains('is-open') && !supportWrap.contains(e.target)) {
                    supportWrap.classList.remove('is-open');
                    supportToggle.setAttribute('aria-expanded', 'false');
                }
            });

            // Handle ESC key to close
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && supportWrap.classList.contains('is-open')) {
                    supportWrap.classList.remove('is-open');
                    supportToggle.setAttribute('aria-expanded', 'false');
                }
            });

            // Close when clicking any contact link
            var items = supportWrap.querySelectorAll('.support-item');
            items.forEach(function(item) {
                item.addEventListener('click', function() {
                    setTimeout(function() {
                        supportWrap.classList.remove('is-open');
                        supportToggle.setAttribute('aria-expanded', 'false');
                    }, 150);
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFloatingSupport);
        } else {
            initFloatingSupport();
        }
    })();
    </script>
    @endif

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" title="Lên đầu trang" aria-label="Lên đầu trang">
                        <span class="iconify" data-icon="ant-design:arrow-up-outlined"></span>
    </button>
    
    <script defer src="https://cdn.jsdelivr.net/gh/lelinh014756/fui-toast-js@master/assets/js/toast@1.0.1/fuiToast.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <script defer src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
    <script defer src="{{ asset('assets/js/discount-code.js') }}?v={{ filemtime(public_path('assets/js/discount-code.js')) }}"></script>




    @unless(Auth::check() && Auth::user()->role === 'admin')
    <!-- Live Purchase Toast -->
    <div id="live-purchase-toast" class="live-purchase-toast">
        <button type="button" class="toast-close" onclick="document.getElementById('live-purchase-toast').classList.remove('show')" aria-label="Đóng">×</button>
        <div class="toast-body">
            <div class="toast-icon-bg">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div class="toast-content">
                <div class="toast-text-desc"><strong class="toast-username" id="toast-username">nguyen***</strong> vừa mua</div>
                <div class="toast-item" id="toast-item">Acc Liên Quân VIP</div>
                <div class="toast-meta">
                    <span class="toast-price" id="toast-price">50.000đ</span>
                    <span class="toast-time" id="toast-time">vừa xong</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .live-purchase-toast {
            position: fixed;
            bottom: 20px;
            left: -320px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            width: 260px;
            border-left: 4px solid #0d6efd;
            z-index: 10000;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
            transform: translateX(0);
            opacity: 0;
            pointer-events: none;
            font-family: inherit;
        }
        .live-purchase-toast.show {
            transform: translateX(340px);
            opacity: 1;
            pointer-events: auto;
        }
        .live-purchase-toast .toast-close {
            position: absolute;
            top: 4px;
            right: 6px;
            cursor: pointer;
            color: #9ca3af;
            font-size: 14px;
            line-height: 1;
            background: transparent;
            border: none;
            padding: 2px;
            transition: color 0.15s;
        }
        .live-purchase-toast .toast-close:hover {
            color: #ef4444;
        }
        .live-purchase-toast .toast-body {
            display: flex;
            padding: 9px 10px;
            align-items: center;
            gap: 9px;
        }
        .live-purchase-toast .toast-icon-bg {
            width: 32px;
            height: 32px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.95rem;
        }
        .live-purchase-toast .toast-content {
            flex: 1;
            min-width: 0;
        }
        .live-purchase-toast .toast-text-desc {
            font-size: 0.76rem;
            color: #6b7280;
            line-height: 1.2;
        }
        .live-purchase-toast .toast-username {
            color: #111827;
            font-weight: 600;
        }
        .live-purchase-toast .toast-item {
            font-size: 0.84rem;
            font-weight: 600;
            color: #2563eb;
            line-height: 1.25;
            margin: 1px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .live-purchase-toast .toast-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.74rem;
            line-height: 1;
        }
        .live-purchase-toast .toast-price {
            color: #dc2626;
            font-weight: 700;
        }
        .live-purchase-toast .toast-time {
            color: #9ca3af;
        }

        /* Dark mode */
        [data-theme="dark"] .live-purchase-toast {
            background: #1f2937;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
            border-left-color: #3b82f6;
        }
        [data-theme="dark"] .live-purchase-toast .toast-text-desc {
            color: #9ca3af;
        }
        [data-theme="dark"] .live-purchase-toast .toast-username {
            color: #f3f4f6;
        }
        [data-theme="dark"] .live-purchase-toast .toast-item {
            color: #60a5fa;
        }
        [data-theme="dark"] .live-purchase-toast .toast-icon-bg {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
        }
        
        @media (max-width: 768px) {
            .live-purchase-toast {
                left: 16px;
                right: auto;
                bottom: 12px;
                transform: translateX(-120%);
                width: calc(100% - 32px);
                max-width: 280px;
            }
            .live-purchase-toast.show {
                transform: translateX(0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const firstNames = ['nguyen', 'tran', 'le', 'pham', 'hoang', 'huynh', 'phan', 'vu', 'vo', 'dang', 'bui', 'do', 'ho', 'ngo', 'duong', 'ly', 'tuan', 'hieu', 'nam', 'duc', 'dat', 'long', 'khanh', 'huy', 'tung', 'minh', 'quan', 'son', 'linh', 'trang', 'anh', 'phong', 'thanh', 'hai', 'viet', 'hung', 'thang', 'trung', 'kien', 'quang', 'bao', 'khoa', 'tai'];
            const suffixes = ['pro', 'vip', 'boy', 'gaming', '99', '2k', '2k1', '2k2', '2k3', '2k4', '2k5', '2k6', '2k7', '2k8', 'ff', 'lq', 'yt', 'tv', 'vn'];
            const phonePrefixes = ['098', '097', '096', '086', '091', '094', '088', '090', '093', '089', '070', '079', '077', '076', '078', '032', '033', '034', '035', '036', '037', '038', '039', '056', '058'];

            function generateRealisticUsername() {
                const mode = Math.floor(Math.random() * 4);
                if (mode === 0) {
                    const p = phonePrefixes[Math.floor(Math.random() * phonePrefixes.length)];
                    const d = Math.floor(10 + Math.random() * 90);
                    return `${p}${d}***`;
                } else if (mode === 1) {
                    const name = firstNames[Math.floor(Math.random() * firstNames.length)];
                    const num = Math.floor(10 + Math.random() * 990);
                    const sep = Math.random() > 0.7 ? '_' : '';
                    return `${name}${sep}${num}***`;
                } else if (mode === 2) {
                    const name = firstNames[Math.floor(Math.random() * firstNames.length)];
                    const suf = suffixes[Math.floor(Math.random() * suffixes.length)];
                    const sep = Math.random() > 0.6 ? '_' : '';
                    return `${name}${sep}${suf}***`;
                } else {
                    const f = firstNames[Math.floor(Math.random() * firstNames.length)];
                    const s = firstNames[Math.floor(Math.random() * firstNames.length)];
                    return `${f}${s}***`;
                }
            }

            const items = [
                'Acc Liên Quân VIP', 'Acc Free Fire', 'Random Blox Fruits', 'Acc Ngọc Rồng',
                'Random 50k', 'Cày thuê Rank', 'Nạp Quân Huy', 'Nạp Kim Cương', 'Acc Roblox'
            ];
            
            const prices = [20000, 50000, 70000, 100000, 150000, 200000, 350000];
            const timeLabels = ['vừa xong', '12s trước', '25s trước', '41s trước', '1p trước'];

            function showFakePurchase() {
                const toast = document.getElementById('live-purchase-toast');
                if (!toast) return;
                
                document.getElementById('toast-username').textContent = generateRealisticUsername();
                document.getElementById('toast-item').textContent = items[Math.floor(Math.random() * items.length)];
                
                const price = prices[Math.floor(Math.random() * prices.length)];
                document.getElementById('toast-price').textContent = new Intl.NumberFormat('vi-VN').format(price) + 'đ';
                document.getElementById('toast-time').textContent = timeLabels[Math.floor(Math.random() * timeLabels.length)];
                
                toast.classList.add('show');
                
                // Giữ 3.2s
                setTimeout(() => {
                    toast.classList.remove('show');
                    scheduleNextPurchase();
                }, 3200);
            }

            function scheduleNextPurchase() {
                // Tần suất thưa hơn: cách 25s - 55s mới hiện 1 lần
                const nextDelay = Math.floor(25000 + Math.random() * 30000);
                setTimeout(showFakePurchase, nextDelay);
            }

            // Lần đầu xuất hiện sau 8s - 15s kể từ khi vào web
            setTimeout(showFakePurchase, Math.floor(8000 + Math.random() * 7000));
        });
    </script>
    @endunless
    
    @stack('scripts')
</body>
</html>
