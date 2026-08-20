<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/antd@4.24.16/dist/antd.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lelinh014756/fui-toast-js@master/assets/css/toast@1.0.1/fuiToast.min.css">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/legacy-compat.css" rel="stylesheet">
    <link href="/css/ui-fixes.css?v=20260820-6" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

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
    <link href="/css/mobile-header-final.css?v=20260820-5" rel="stylesheet">
    <link href="/css/navbar-hover-hotfix.css?v=20260820-1" rel="stylesheet">

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

        iframe.goog-te-banner-frame {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        .goog-tooltip,
        .goog-tooltip:hover {
            display: none !important;
        }

        .goog-text-highlight {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .goog-te-gadget {
            font-size: 0px !important;
        }

        .skiptranslate {
            display: none !important;
        }

        /* Guest mobile header: keep Login/Register beside theme, never inside hamburger. */
        @media (max-width: 1199px) {
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
                max-width: 72px !important;
                height: 28px !important;
            }

            html body nav.navbar > .nav-container > .nav-user {
                gap: 4px !important;
            }

            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions {
                gap: 3px !important;
            }

            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions .btn-nav-login,
            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions .btn-nav-register {
                height: 30px !important;
                min-height: 30px !important;
                padding: 0 6px !important;
                font-size: .66rem !important;
                gap: 3px !important;
            }

            html body nav.navbar > .nav-container > .nav-user > .nav-guest-actions .iconify {
                font-size: .78rem !important;
            }

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

        /* Desktop dropdowns: only the visible button/menu can receive the mouse.
           The old li::after bridge made empty space around Nạp Tiền trigger hover. */
        @media (min-width: 1200px) and (hover: hover) and (pointer: fine) {
            html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown,
            html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown {
                pointer-events: none !important;
                padding-bottom: 0 !important;
                margin-bottom: 0 !important;
            }

            html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown::after,
            html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown::after {
                content: none !important;
                display: none !important;
                width: 0 !important;
                height: 0 !important;
                pointer-events: none !important;
            }

            html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown > .nav-link-item,
            html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown > .nav-link-item,
            html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown > .modern-dropdown-menu,
            html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown > .mega-menu {
                pointer-events: auto !important;
            }

            /* Narrow vertical bridge: same width as the real button only.
               It lets the cursor travel down to the menu without making side gaps hoverable. */
            html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown > .nav-link-item,
            html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown > .nav-link-item {
                position: relative !important;
            }

            html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown > .nav-link-item::after,
            html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown > .nav-link-item::after {
                content: "" !important;
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                right: 0 !important;
                height: 14px !important;
                background: transparent !important;
                pointer-events: auto !important;
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
            document.body.style.overflow = 'hidden';
        }

        function closeAuthModal() {
            var ov = document.getElementById('authOverlay');
            var md = document.getElementById('authModal');
            if (ov) ov.style.display = 'none';
            if (md) md.style.display = 'none';
            document.body.style.overflow = '';
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
                dropdown.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                });

                document.addEventListener('click', function () {
                    dropdown.classList.remove('active');
                });
            }
        });
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>