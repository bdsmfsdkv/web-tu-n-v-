<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <script>
        /* Khởi tạo Theme ngay lập tức trước khi render để chống 100% hiện tượng chớp/giật màn hình khi tải lại trang */
        (function() {
            try {
                var theme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {}
        })();

        /* ================= 4-DOT PRELOADER ENGINE (SELF-HEALING & ZALO WEBVIEW COMPATIBLE) ================= */
        (function() {
            var loaderTimeout = null;

            window.dismissPageLoader = function() {
                if (loaderTimeout) {
                    clearTimeout(loaderTimeout);
                    loaderTimeout = null;
                }
                var p = document.getElementById('pagePreloader');
                if (p) {
                    p.classList.add('hide-loader');
                }
            };

            window.showPageLoader = function() {
                var p = document.getElementById('pagePreloader');
                if (p) {
                    p.classList.remove('hide-loader');
                    // Safety watchdog: Tự động dập tắt loader sau 3.5s nếu navigation bị hủy hoặc timeout
                    if (loaderTimeout) clearTimeout(loaderTimeout);
                    loaderTimeout = setTimeout(window.dismissPageLoader, 3500);
                }
            };

            // Tự động tắt loader ngay khi DOM sẵn sàng
            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                setTimeout(window.dismissPageLoader, 30);
            } else {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(window.dismissPageLoader, 30);
                });
                window.addEventListener('load', window.dismissPageLoader);
            }

            // Tương thích tuyệt đối bfcache (Back/Forward) & Zalo/Facebook in-app WebView
            window.addEventListener('pageshow', function() {
                window.dismissPageLoader();
            });

            // Hard Failsafe Watchdog: Cam kết tối đa 350ms sau khi trang bắt đầu load là PHẢI ẩn loader
            setTimeout(window.dismissPageLoader, 350);
        })();
    </script>
    <style id="critical-baseline-css">
        /* 4-Dot Antd Preloader */
        .kc-preloader {
            position: fixed !important;
            inset: 0 !important;
            z-index: 99999 !important;
            background: rgba(255, 255, 255, 0.96) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            padding: 0 !important;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.22s cubic-bezier(0.25, 1, 0.5, 1), visibility 0.22s cubic-bezier(0.25, 1, 0.5, 1) !important;
            pointer-events: none !important;
        }

        [data-theme="dark"] .kc-preloader {
            background: rgba(18, 18, 18, 0.96) !important;
        }

        .kc-preloader.hide-loader {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }

        .antd-spin {
            position: relative;
            display: inline-block;
            width: 38px;
            height: 38px;
            transform: rotate(45deg);
            animation: antdSpinRotate 1.2s infinite linear;
            transform-origin: 50% 50%;
            box-sizing: border-box;
            pointer-events: none;
        }

        .antd-spin i {
            position: absolute;
            display: block;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: var(--primary, #dc2626);
            transform: scale(0.75);
            transform-origin: 50% 50%;
            opacity: 0.35;
            animation: antdSpinDot 1s infinite linear alternate;
        }

        .antd-spin i:nth-child(1) { top: 0; left: 0; }
        .antd-spin i:nth-child(2) { top: 0; right: 0; animation-delay: 0.4s; }
        .antd-spin i:nth-child(3) { right: 0; bottom: 0; animation-delay: 0.8s; }
        .antd-spin i:nth-child(4) { bottom: 0; left: 0; animation-delay: 1.2s; }

        @keyframes antdSpinRotate {
            to { transform: rotate(405deg); }
        }

        @keyframes antdSpinDot {
            to { opacity: 1; transform: scale(1); }
        }

        /* Zero-FOUC & Zero-CLS Theme & Layout Baseline */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #ffffff;
            color: #1f2937;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        [data-theme="dark"],
        [data-theme="dark"] body {
            background-color: #121212 !important;
            color: #f3f4f6 !important;
        }

        /* Fixed navbar baseline to prevent jump */
        nav.navbar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 64px !important;
            min-height: 64px !important;
            z-index: 1000 !important;
            background: #ffffff !important;
            border-bottom: 1px solid #e5e7eb !important;
            box-sizing: border-box !important;
        }

        [data-theme="dark"] nav.navbar {
            background: #171717 !important;
            border-color: #2a2a2a !important;
        }

        .nav-container {
            width: 100% !important;
            max-width: 1360px !important;
            height: 64px !important;
            min-height: 64px !important;
            margin: 0 auto !important;
            padding: 0 20px !important;
            display: grid !important;
            grid-template-columns: auto minmax(0, 1fr) auto !important;
            align-items: center !important;
            box-sizing: border-box !important;
        }

        main {
            padding-top: 64px !important;
            flex: 1 0 auto !important;
            box-sizing: border-box !important;
        }

        /* Fixed icon box size to prevent button expansion */
        .iconify, svg.iconify, i.fa-solid, i.fa-regular, i.fa-brands, i.fab, i.fas, i.far {
            display: inline-block !important;
            width: 1em !important;
            height: 1em !important;
            line-height: 1 !important;
            vertical-align: -0.125em !important;
            fill: currentColor;
            flex-shrink: 0 !important;
            box-sizing: content-box !important;
        }

        .nav-item-icon {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 1.15em !important;
            height: 1.15em !important;
            flex-shrink: 0 !important;
        }

        .nav-arrow {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 0.8em !important;
            height: 0.8em !important;
            flex-shrink: 0 !important;
        }

        @media (max-width: 1199px) {
            nav.navbar, .nav-container {
                height: 56px !important;
                min-height: 56px !important;
            }
            main {
                padding-top: 56px !important;
            }
        }

        img {
            image-rendering: auto;
        }
    </style>
    <meta name="format-detection" content="telephone=no" />
    <meta name="robots" content="index, follow" />

    <title>@yield('title', config_get('site_name')) - {{ config_get('site_name') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ config_get('site_description') }}" />
    <meta name="keywords" content="{{ config_get('site_keywords') }}" />
    <meta name="author" content="{{ config_get('site_name') }}" />

    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ config_get('site_name') }}" />
    <meta property="og:title" content="@yield('title', config_get('site_name')) - {{ config_get('site_name') }}" />
    <meta property="og:description" content="{{ config_get('site_description') }}" />
    <meta property="og:image" content="{{ asset(config_get('site_share_image', config_get('site_logo'))) }}" />
    <meta property="og:image:alt" content="{{ config_get('site_name') }}" />
    <meta property="og:locale" content="vi_VN" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:title" content="@yield('title', config_get('site_name')) - {{ config_get('site_name') }}" />
    <meta name="twitter:description" content="{{ config_get('site_description') }}" />
    <meta name="twitter:image" content="{{ asset(config_get('site_share_image', config_get('site_logo'))) }}" />
    <meta name="twitter:image:alt" content="{{ config_get('site_name') }}" />

    <link rel="icon" href="{{ asset(config_get('site_favicon')) }}" type="image/png" />
    <link rel="shortcut icon" href="{{ asset(config_get('site_favicon')) }}" type="image/png" />
    <link rel="apple-touch-icon" href="{{ asset(config_get('site_favicon')) }}" />
    <link rel="canonical" href="{{ url()->current() }}" />

    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net" />
    <link rel="dns-prefetch" href="//code.jquery.com" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/antd@4.24.16/dist/antd.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lelinh014756/fui-toast-js@master/assets/css/toast@1.0.1/fuiToast.min.css">

    {{-- Local CSS uses filemtime so localhost and production never keep an old menu file after deployment. --}}
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/header-layout.css') }}?v={{ filemtime(public_path('css/header-layout.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/legacy-compat.css') }}?v={{ filemtime(public_path('css/legacy-compat.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/ui-fixes.css') }}?v={{ filemtime(public_path('css/ui-fixes.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/modern-enhancements.css') }}?v={{ filemtime(public_path('css/modern-enhancements.css')) }}" rel="stylesheet">

    {{-- Local pre-bundled offline Iconify icons: 0ms delay, zero network fetch, zero layout shift --}}
    <script src="{{ asset('js/iconify-bundle.min.js') }}?v={{ filemtime(public_path('js/iconify-bundle.min.js')) }}"></script>
    <script defer src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        window.__defaultTheme = 'light';
    </script>

    @if (request()->is('/'))
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "{{ config_get('site_name') }}",
            "url": "{{ url('/') }}",
            "logo": "{{ config_get('site_logo') }}",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "{{ config_get('phone') }}",
                "contactType": "customer service",
                "availableLanguage": "Vietnamese"
            },
            "sameAs": [
                "{{ config_get('facebook') }}",
                "{{ config_get('youtube') }}"
            ]
        }
        </script>
    @endif

    @stack('css')

    {{-- Preload banner image so it loads early and triggers window.load --}}
    @php
        $preloadBanners = json_decode(config_get('site_banner'), true);
        if (!is_array($preloadBanners) && !empty(config_get('site_banner'))) {
            $preloadBanners = [config_get('site_banner')];
        }
        $firstBanner = !empty($preloadBanners) ? $preloadBanners[0] : null;
    @endphp
    @if($firstBanner)
    <link rel="preload" as="image" href="{{ asset($firstBanner) }}" fetchpriority="high">
    @endif

    <link href="{{ asset('css/mobile-header-final.css') }}?v={{ filemtime(public_path('css/mobile-header-final.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-hover-hotfix.css') }}?v={{ filemtime(public_path('css/navbar-hover-hotfix.css')) }}" rel="stylesheet">

    <style>
        .ant-header-lang-dropdown {
            position: relative;
            cursor: pointer;
            user-select: none;
            z-index: 1000;
        }

        .ant-header-lang-trigger {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 8px;
            background: #fafafa;
            border: 1.5px solid var(--ant-border);
            transition: all 0.2s;
            height: 38px;
            box-sizing: border-box;
        }

        .ant-header-lang-trigger:hover {
            border-color: var(--ant-primary);
            background: rgba(24,144,255,0.02);
        }

        .ant-header-lang-text {
            font-size: 13px;
            font-weight: 700;
            color: var(--ant-text);
        }

        .ant-dropdown-item {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .ant-header-lang-dropdown .ant-dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.15s ease-in-out;
            display: block !important;
        }

        .ant-header-lang-dropdown:hover .ant-dropdown-menu,
        .ant-header-lang-dropdown.active .ant-dropdown-menu {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }

        iframe.goog-te-banner-frame { display: none !important; }
        #goog-gt-tt, .goog-te-balloon-frame { display: none !important; }
        body { top: 0px !important; position: static !important; }
        .goog-tooltip,
        .goog-tooltip:hover { display: none !important; }
        .goog-text-highlight {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
        .goog-te-gadget { font-size: 0px !important; }
        .skiptranslate { display: none !important; }
        font > font { font: inherit !important; color: inherit !important; line-height: inherit !important; }

        /* Guest mobile header: keep Login/Register beside theme, never inside hamburger. */
        @media (max-width: 1199px) {
            html body nav.navbar > .nav-container > .nav-brand img {
                height: 38px !important;
                width: auto !important;
                max-width: 150px !important;
                object-fit: contain !important;
            }

            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions {
                display: flex !important;
                visibility: visible !important;
                pointer-events: auto !important;
                align-items: center !important;
                gap: 5px !important;
                margin: 0 !important;
                padding: 0 !important;
                flex: 0 0 auto !important;
            }

            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions .btn-nav-login,
            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions .btn-nav-register {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 4px !important;
                height: 32px !important;
                min-height: 32px !important;
                padding: 0 8px !important;
                border-radius: 8px !important;
                font-size: .72rem !important;
                font-weight: 750 !important;
                line-height: 1 !important;
                white-space: nowrap !important;
            }

            html body nav.navbar > .nav-container > #navLinks > li.mobile-auth-banner,
            html body nav.navbar #navLinks > li.mobile-auth-banner {
                display: none !important;
                visibility: hidden !important;
                pointer-events: none !important;
                height: 0 !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }
        }

        @media (max-width: 430px) {
            html body nav.navbar > .nav-container {
                padding-left: 7px !important;
                padding-right: 7px !important;
                gap: 4px !important;
            }
            html body nav.navbar > .nav-container > .nav-brand img {
                max-width: 120px !important;
                height: 35px !important;
            }
            html body nav.navbar > .nav-container > .nav-user { gap: 4px !important; }
            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions { gap: 3px !important; }
            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions .btn-nav-login,
            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions .btn-nav-register {
                height: 30px !important;
                min-height: 30px !important;
                padding: 0 6px !important;
                font-size: .66rem !important;
                gap: 3px !important;
            }
            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions .iconify { font-size: .78rem !important; }
            html body nav.navbar .theme-toggle {
                width: 31px !important;
                height: 31px !important;
                min-width: 31px !important;
                flex-basis: 31px !important;
            }
            html body nav.navbar #navToggle {
                width: 34px !important;
                height: 34px !important;
                min-width: 34px !important;
                flex-basis: 34px !important;
            }
        }
    </style>

    <script>
        function openAuthModal(panel) {
            var ov = document.getElementById('authOverlay');
            var md = document.getElementById('authModal');
            if (!ov || !md) {
                window.location.href = '/login';
                return;
            }
            ov.style.display = 'block';
            md.style.display = 'block';
            switchAuthPanel(panel || 'login');
        }

        function closeAuthModal() {
            var ov = document.getElementById('authOverlay');
            var md = document.getElementById('authModal');
            if (ov) ov.style.display = 'none';
            if (md) md.style.display = 'none';
        }

        function switchAuthPanel(panel) {
            document.querySelectorAll('.auth-panel').forEach(function (p) {
                p.style.display = 'none';
            });
            var id = panel === 'register' ? 'authRegisterPanel' : panel === 'forgot' ? 'authForgotPanel' : 'authLoginPanel';
            var el = document.getElementById(id);
            if (el) el.style.display = 'block';
        }

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'vi',
                includedLanguages: 'vi,en,zh-CN,ko,ja',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }

        function ensureGoogleTranslateLoaded(callback) {
            if (window.google && window.google.translate) {
                if (callback) callback();
                return;
            }
            if (window.__gtScriptLoading) {
                if (callback) {
                    var checkInterval = setInterval(function () {
                        if (window.google && window.google.translate) {
                            clearInterval(checkInterval);
                            callback();
                        }
                    }, 50);
                }
                return;
            }
            window.__gtScriptLoading = true;
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
            script.async = true;
            document.head.appendChild(script);
            if (callback) {
                var checkInterval = setInterval(function () {
                    if (window.google && window.google.translate) {
                        clearInterval(checkInterval);
                        callback();
                    }
                }, 50);
            }
        }

        function setLanguage(lang) {
            localStorage.setItem('sunihost_lang', lang);
            updateLangUI(lang);

            const cookieVal = '/vi/' + lang;
            const domain = window.location.hostname.replace('www.', '');

            document.cookie = "googtrans=" + cookieVal + "; path=/; domain=" + domain;
            document.cookie = "googtrans=" + cookieVal + "; path=/; domain=." + domain;
            document.cookie = "googtrans=" + cookieVal + "; path=/";

            location.reload();
        }

        function updateLangUI(lang) {
            const flag = document.getElementById('currentLangFlag');
            const text = document.getElementById('currentLangText');

            if (lang === 'en') {
                if (flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/us.svg';
                if (text) text.textContent = 'EN';
            } else if (lang === 'zh-CN') {
                if (flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/cn.svg';
                if (text) text.textContent = 'ZH';
            } else if (lang === 'ko') {
                if (flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/kr.svg';
                if (text) text.textContent = 'KO';
            } else if (lang === 'ja') {
                if (flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/jp.svg';
                if (text) text.textContent = 'JA';
            } else {
                if (flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/vn.svg';
                if (text) text.textContent = 'VI';
            }
        }

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }

        (function () {
            const savedLang = localStorage.getItem('sunihost_lang') || 'vi';
            const cookieVal = '/vi/' + savedLang;
            const currentCookie = getCookie('googtrans');

            if (savedLang !== 'vi') {
                ensureGoogleTranslateLoaded();
            }

            if (savedLang !== 'vi' && currentCookie !== cookieVal) {
                const domain = window.location.hostname.replace('www.', '');
                document.cookie = "googtrans=" + cookieVal + "; path=/; domain=" + domain;
                document.cookie = "googtrans=" + cookieVal + "; path=/; domain=." + domain;
                document.cookie = "googtrans=" + cookieVal + "; path=/";
            } else if (savedLang === 'vi' && currentCookie && currentCookie !== '/vi/vi') {
                const domain = window.location.hostname.replace('www.', '');
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + domain;
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=." + domain;
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
            }
        })();

        document.addEventListener('DOMContentLoaded', function () {
            const savedLang = localStorage.getItem('sunihost_lang') || 'vi';
            updateLangUI(savedLang);

            const dropdown = document.querySelector('.ant-header-lang-dropdown');
            if (dropdown) {
                dropdown.addEventListener('mouseenter', function () {
                    ensureGoogleTranslateLoaded();
                });
                dropdown.addEventListener('click', function (e) {
                    e.stopPropagation();
                    ensureGoogleTranslateLoaded();
                    dropdown.classList.toggle('active');
                });

                document.addEventListener('click', function () {
                    dropdown.classList.remove('active');
                });
            }
        });
    </script>
</head>
