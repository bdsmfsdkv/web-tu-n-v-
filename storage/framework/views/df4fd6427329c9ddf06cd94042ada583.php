
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="robots" content="index, follow" />

    <title><?php echo $__env->yieldContent('title', config_get('site_name')); ?> - <?php echo e(config_get('site_name')); ?></title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Primary Meta Tags -->
    <meta name="description" content="<?php echo e(config_get('site_description')); ?>" />
    <meta name="keywords" content="<?php echo e(config_get('site_keywords')); ?>" />
    <meta name="author" content="<?php echo e(config_get('site_name')); ?>" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo e(url()->current()); ?>" />
    <meta property="og:site_name" content="<?php echo e(config_get('site_name')); ?>" />
    <meta property="og:title" content="<?php echo $__env->yieldContent('title', config_get('site_name')); ?> - <?php echo e(config_get('site_name')); ?>" />
    <meta property="og:description" content="<?php echo e(config_get('site_description')); ?>" />
    <meta property="og:image" content="<?php echo e(config_get('site_share_image', config_get('site_logo'))); ?>" />
    <meta property="og:image:alt" content="<?php echo e(config_get('site_name')); ?>" />
    <meta property="og:locale" content="vi_VN" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="<?php echo e(url()->current()); ?>" />
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', config_get('site_name')); ?> - <?php echo e(config_get('site_name')); ?>" />
    <meta name="twitter:description" content="<?php echo e(config_get('site_description')); ?>" />
    <meta name="twitter:image" content="<?php echo e(config_get('site_share_image', config_get('site_logo'))); ?>" />
    <meta name="twitter:image:alt" content="<?php echo e(config_get('site_name')); ?>" />

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(config_get('site_favicon')); ?>" type="image/png" />
    <link rel="shortcut icon" href="<?php echo e(config_get('site_favicon')); ?>" type="image/png" />
    <link rel="apple-touch-icon" href="<?php echo e(config_get('site_favicon')); ?>" />

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(url()->current()); ?>" />

    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/antd@4.24.16/dist/antd.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lelinh014756/fui-toast-js@master/assets/css/toast@1.0.1/fuiToast.min.css">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/legacy-compat.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
  <style>
        body {
            font-family: "Roboto", sans-serif;
            background-color: #fbf8f8ff;
        }

         :root {
            --primary: #dc2626;
            --primary-dark: #b91c1c;
            --primary-light: #ef4444;
            --primary-glow: rgba(220, 38, 38, 0.2);
            --accent: #f59e0b;
            --ant-primary-color: #dc2626;
        }

        .ant-btn-primary,
        .ant-btn-primary:focus {
            background: #dc2626;
            border-color: #dc2626;
        }

        .ant-btn-primary:hover {
            background: #b91c1c;
            border-color: #b91c1c;
        }

        a {
            color: #dc2626;
        }

        a:hover {
            color: #b91c1c;
        }

        .ant-pagination-item-active {
            border-color: #dc2626;
        }

        .ant-pagination-item-active a {
            color: #dc2626;
        }

        .ant-menu-item-selected,
        .ant-menu-item-selected a {
            color: #dc2626 !important;
        }

        .ant-input:focus,
        .ant-input-focused,
        .ant-select-focused .ant-select-selector {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 2px var(--primary-glow) !important;
        }

        .brand-icon {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
        }

        .category-card {
            border: 2px solid #e6e6e6;
        }

        .category-grid {
            grid-template-columns: repeat(5, 1fr);
        }

            </style>
    <script>
        window.__defaultTheme = 'light';
    </script>
    <?php if(request()->is('/')): ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "<?php echo e(config_get('site_name')); ?>",
            "url": "<?php echo e(url('/')); ?>",
            "logo": "<?php echo e(config_get('site_logo')); ?>",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "<?php echo e(config_get('phone')); ?>",
                "contactType": "customer service",
                "availableLanguage": "Vietnamese"
            },
            "sameAs": [
                "<?php echo e(config_get('facebook')); ?>",
                "<?php echo e(config_get('youtube')); ?>"
            ]
        }
    </script>
    <?php endif; ?>

    <!-- Page-specific CSS -->
    <?php echo $__env->yieldPushContent('css'); ?>
           <style>
      
        /* Ant Design Preloader */
        #global-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 999999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        #global-preloader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .ant-spin-dot-global {
            position: relative;
            display: inline-block;
            font-size: 32px;
            width: 32px;
            height: 32px;
            transform: rotate(45deg);
            animation: antGlobalRotate 1.2s infinite linear;
        }

        .ant-spin-dot-global-item {
            position: absolute;
            display: block;
            width: 14px;
            height: 14px;
            background-color: var(--ant-primary);
            border-radius: 100%;
            transform: scale(0.75);
            transform-origin: 50% 50%;
            opacity: 0.3;
            animation: antGlobalSpinMove 1s infinite linear alternate;
        }

        .ant-spin-dot-global-item:nth-child(1) {
            top: 0;
            left: 0;
        }

        .ant-spin-dot-global-item:nth-child(2) {
            top: 0;
            right: 0;
            animation-delay: 0.4s;
        }

        .ant-spin-dot-global-item:nth-child(3) {
            right: 0;
            bottom: 0;
            animation-delay: 0.8s;
        }

        .ant-spin-dot-global-item:nth-child(4) {
            bottom: 0;
            left: 0;
            animation-delay: 1.2s;
        }

        @keyframes antGlobalSpinMove {
            to {
                opacity: 1;
            }
        }

        /* Language Switcher Styling */
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
            display: block !important; /* Managed purely via opacity & visibility */
        }
        /* Show dropdown on hover or when it has active class */
        .ant-header-lang-dropdown:hover .ant-dropdown-menu,
        .ant-header-lang-dropdown.active .ant-dropdown-menu {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }
        
        /* Hide google branding & bar */
        iframe.goog-te-banner-frame {
            display: none !important;
        }
        body {
            top: 0px !important;
        }
        .goog-tooltip, .goog-tooltip:hover {
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
    </style>
    <script>
        function openAuthModal(panel) {
            var ov = document.getElementById('authOverlay');
            var md = document.getElementById('authModal');
            if (!ov || !md) { window.location.href = '/login'; return; }
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
            document.querySelectorAll('.auth-panel').forEach(function (p) { p.style.display = 'none'; });
            var id = panel === 'register' ? 'authRegisterPanel' : panel === 'forgot' ? 'authForgotPanel' : 'authLoginPanel';
            var el = document.getElementById(id);
            if (el) el.style.display = 'block';
        }

        // Preloader Logic
        window.addEventListener('load', function () {
            var pl = document.getElementById('global-preloader');
            if (pl) pl.classList.add('hidden');
        });
        document.addEventListener('click', function (e) {
            var link = e.target.closest('a');
            if (link) {
                var href = link.getAttribute('href');
                var target = link.getAttribute('target');
                if (href && !href.startsWith('#') && !href.startsWith('javascript:') && target !== '_blank' && !link.hasAttribute('download')) {
                    if (!link.classList.contains('no-loader')) {
                        var pl = document.getElementById('global-preloader');
                        if (pl) pl.classList.remove('hidden');

                        // Fallback hide after 5s in case page doesn't navigate
                        setTimeout(() => { if (pl) pl.classList.add('hidden'); }, 5000);
                    }
                }
            }
        });

        // Google Translate Integration for Premium Multi-Language Switcher
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
            
            // Format of google translate cookie is /sourceLanguage/targetLanguage
            const cookieVal = '/vi/' + lang;
            const domain = window.location.hostname.replace('www.', '');
            
            // Set the cookie on multiple levels to guarantee it works on all subdomains and paths
            document.cookie = "googtrans=" + cookieVal + "; path=/; domain=" + domain;
            document.cookie = "googtrans=" + cookieVal + "; path=/; domain=." + domain;
            document.cookie = "googtrans=" + cookieVal + "; path=/";
            
            // Reload the page to let Google Translate apply instantly and cleanly
            location.reload();
        }

        function updateLangUI(lang) {
            const flag = document.getElementById('currentLangFlag');
            const text = document.getElementById('currentLangText');
            if (lang === 'en') {
                if(flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/us.svg';
                if(text) text.textContent = 'EN';
            } else if (lang === 'zh-CN') {
                if(flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/cn.svg';
                if(text) text.textContent = 'ZH';
            } else if (lang === 'ko') {
                if(flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/kr.svg';
                if(text) text.textContent = 'KO';
            } else if (lang === 'ja') {
                if(flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/jp.svg';
                if(text) text.textContent = 'JA';
            } else {
                if(flag) flag.src = 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/vn.svg';
                if(text) text.textContent = 'VI';
            }
        }

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }

        // Auto check and sync cookie immediately to prevent load lag and eliminate infinite reload loops on production
        (function() {
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

        document.addEventListener('DOMContentLoaded', () => {
            const savedLang = localStorage.getItem('sunihost_lang') || 'vi';
            updateLangUI(savedLang);
            
            // Dropdown Toggle Logic
            const dropdown = document.querySelector('.ant-header-lang-dropdown');
            if (dropdown) {
                dropdown.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                });
                document.addEventListener('click', () => {
                    dropdown.classList.remove('active');
                });
            }
        });
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>

<?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\layouts\user\head.blade.php ENDPATH**/ ?>