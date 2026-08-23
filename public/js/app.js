/**
 * ShopAcc - Frontend JavaScript
 * UI helpers, profile/language dropdown, deposit menu assist and 419 recovery.
 */

(function installShopUiStyles() {
    if (document.getElementById('shop-ui-polish-styles-v3')) return;

    var style = document.createElement('style');
    style.id = 'shop-ui-polish-styles-v3';
    style.textContent = `
        /* ================= PROFILE DROPDOWN ================= */
        html body #avatarWrapper { position: relative !important; }

        html body #avatarDropdown {
            display: none !important;
            position: absolute !important;
            top: calc(100% + 10px) !important;
            right: 0 !important;
            left: auto !important;
            width: 340px !important;
            max-width: calc(100vw - 24px) !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
            background: #fff !important;
            border: 1px solid #e8edf3 !important;
            border-radius: 18px !important;
            box-shadow: 0 22px 55px rgba(15,23,42,.18) !important;
            z-index: 12050 !important;
            font-family: Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif !important;
        }

        html body #avatarDropdown.show {
            display: block !important;
            animation: shopProfileDrop .18s ease-out both;
        }

        @keyframes shopProfileDrop {
            from { opacity: 0; transform: translateY(-7px) scale(.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        html body #avatarDropdown .dropdown-user-card {
            padding: 17px !important;
            background: radial-gradient(circle at 92% 8%,rgba(239,68,68,.13),transparent 35%),linear-gradient(145deg,#fff 0%,#fff8f8 100%) !important;
            border-radius: 18px 18px 0 0 !important;
        }

        html body #avatarDropdown .dropdown-user-header {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            min-width: 0 !important;
        }

        html body #avatarDropdown .dropdown-user-avatar {
            width: 52px !important;
            height: 52px !important;
            min-width: 52px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #fff !important;
            font-size: 1.05rem !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            background: linear-gradient(135deg,#ef4444,#dc2626 55%,#b91c1c) !important;
            border: 3px solid #fff !important;
            border-radius: 15px !important;
            box-shadow: 0 8px 20px rgba(220,38,38,.26) !important;
        }

        html body #avatarDropdown .dropdown-user-meta { min-width: 0 !important; flex: 1 !important; }

        html body #avatarDropdown .dropdown-name {
            overflow: hidden !important;
            color: #111827 !important;
            font-size: .96rem !important;
            font-weight: 850 !important;
            line-height: 1.35 !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        html body #avatarDropdown .dropdown-email {
            margin-top: 4px !important;
            overflow: hidden !important;
            color: #8b96a7 !important;
            font-size: .76rem !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        html body #avatarDropdown .dropdown-balance-box {
            display: grid !important;
            grid-template-columns: minmax(0,1fr) auto !important;
            align-items: center !important;
            gap: 5px 12px !important;
            margin-top: 14px !important;
            padding: 12px 13px !important;
            background: rgba(255,255,255,.95) !important;
            border: 1px solid #fee2e2 !important;
            border-radius: 13px !important;
        }

        html body #avatarDropdown .dropdown-balance-label {
            grid-column: 1/-1 !important;
            color: #64748b !important;
            font-size: .69rem !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
        }

        html body #avatarDropdown .dropdown-balance-val {
            color: #dc2626 !important;
            font-size: 1.22rem !important;
            font-weight: 900 !important;
            white-space: nowrap !important;
        }

        html body #avatarDropdown .dropdown-balance-cur { font-size: .78rem !important; font-weight: 850 !important; }

        html body #avatarDropdown .dropdown-btn-deposit {
            display: inline-flex !important;
            min-height: 36px !important;
            padding: 0 13px !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            color: #fff !important;
            font-size: .77rem !important;
            font-weight: 850 !important;
            text-decoration: none !important;
            white-space: nowrap !important;
            background: linear-gradient(135deg,#ef4444,#dc2626) !important;
            border: 1px solid #dc2626 !important;
            border-radius: 9px !important;
            box-shadow: 0 7px 16px rgba(220,38,38,.22) !important;
        }

        html body #avatarDropdown .dropdown-divider { height: 1px !important; margin: 0 !important; background: #eef2f6 !important; border: 0 !important; }
        html body #avatarDropdown .dropdown-menu-links { padding: 7px !important; }

        html body #avatarDropdown .dropdown-item {
            display: flex !important;
            width: 100% !important;
            min-height: 41px !important;
            padding: 8px 10px !important;
            align-items: center !important;
            gap: 10px !important;
            color: #334155 !important;
            font-size: .81rem !important;
            font-weight: 680 !important;
            text-decoration: none !important;
            border-radius: 10px !important;
            box-sizing: border-box !important;
        }

        html body #avatarDropdown .dropdown-item:hover { color: #dc2626 !important; background: #fff1f2 !important; }

        html body #avatarDropdown .dropdown-item-icon {
            width: 29px !important;
            height: 29px !important;
            min-width: 29px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #64748b !important;
            background: #f8fafc !important;
            border: 1px solid #eef2f7 !important;
            border-radius: 8px !important;
        }

        html body #avatarDropdown .dropdown-logout { color: #dc2626 !important; }

        /* Language lives inside profile when logged in. */
        html body #avatarDropdown .profile-language-section { padding: 10px 12px 12px !important; background: #fff !important; }
        html body #avatarDropdown .profile-language-label {
            display: flex !important;
            align-items: center !important;
            gap: 7px !important;
            margin-bottom: 7px !important;
            color: #64748b !important;
            font-size: .69rem !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
        }
        html body #avatarDropdown .profile-language-label .iconify { color: #dc2626 !important; }
        html body #avatarDropdown .profile-language-section .ant-header-lang-dropdown { position: relative !important; width: 100% !important; z-index: 20 !important; }
        html body #avatarDropdown .profile-language-section .ant-header-lang-trigger {
            display: flex !important;
            width: 100% !important;
            height: 40px !important;
            padding: 0 11px !important;
            align-items: center !important;
            gap: 8px !important;
            color: #1f2937 !important;
            background: #f8fafc !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 10px !important;
        }
        html body #avatarDropdown .profile-language-section .lang-arrow { margin-left: auto !important; }
        html body #avatarDropdown .profile-language-section .ant-dropdown-menu {
            position: static !important;
            width: 100% !important;
            min-width: 100% !important;
            max-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transform: none !important;
            background: #fff !important;
            border: 0 !important;
            box-shadow: none !important;
            transition: max-height .2s ease,opacity .18s ease,margin .2s ease !important;
        }
        html body #avatarDropdown .profile-language-section .ant-header-lang-dropdown.active .ant-dropdown-menu,
        html body #avatarDropdown .profile-language-section .ant-header-lang-dropdown:hover .ant-dropdown-menu {
            max-height: 260px !important;
            margin-top: 7px !important;
            padding: 5px !important;
            opacity: 1 !important;
            visibility: visible !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 10px !important;
        }
        html body #avatarDropdown .profile-language-section .ant-dropdown-item {
            min-height: 35px !important;
            padding: 7px 9px !important;
            color: #334155 !important;
            font-size: .78rem !important;
            border-radius: 8px !important;
            cursor: pointer !important;
        }
        html body #avatarDropdown .profile-language-section .ant-dropdown-item:hover { color: #dc2626 !important; background: #fff1f2 !important; }

        /* ================= NAP TIEN: BIGGER HIT AREA + NO HOVER GAP ================= */
        @media (min-width: 1200px) {
            html body .nav-links .nav-dropdown { position: relative !important; padding-bottom: 6px !important; margin-bottom: -6px !important; }

            html body .nav-links .nav-dropdown::after {
                content: "";
                position: absolute !important;
                top: calc(100% - 8px) !important;
                left: -18px !important;
                width: calc(100% + 36px) !important;
                height: 24px !important;
                z-index: 1095 !important;
                pointer-events: auto !important;
            }

            html body .nav-links .nav-dropdown > .modern-dropdown-menu {
                display: none !important;
                top: calc(100% - 1px) !important;
                left: -10px !important;
                width: 330px !important;
                min-width: 330px !important;
                margin: 0 !important;
                padding: 10px !important;
                background: #fff !important;
                border: 1px solid #e5e7eb !important;
                border-radius: 14px !important;
                box-shadow: 0 16px 40px rgba(15,23,42,.16) !important;
                z-index: 1110 !important;
            }

            html body .nav-links .nav-dropdown:hover > .modern-dropdown-menu,
            html body .nav-links .nav-dropdown.deposit-hover-open > .modern-dropdown-menu,
            html body .nav-links .nav-dropdown.deposit-click-open > .modern-dropdown-menu,
            html body .nav-links .nav-dropdown > .modern-dropdown-menu:hover {
                display: block !important;
            }

            html body .nav-links .nav-dropdown .dropdown-link-card {
                min-height: 66px !important;
                padding: 12px 14px !important;
                gap: 13px !important;
                border-radius: 11px !important;
                cursor: pointer !important;
            }

            html body .nav-links .nav-dropdown .dropdown-link-card:hover {
                background: #f8fafc !important;
                box-shadow: inset 0 0 0 1px #eef2f7 !important;
            }

            html body .nav-links .nav-dropdown .dropdown-link-icon-box {
                width: 40px !important;
                height: 40px !important;
                flex: 0 0 40px !important;
            }

            html body .nav-links .nav-dropdown .dropdown-link-title { font-size: .88rem !important; }
            html body .nav-links .nav-dropdown .dropdown-link-desc { margin-top: 3px !important; font-size: .73rem !important; }
        }

        /* ================= ACCOUNT ATTRIBUTES ================= */
        html body .ecom-attr-header {
            display: inline-flex !important;
            align-items: center !important;
            gap: 7px !important;
            margin: 2px 0 12px !important;
            padding: 7px 12px !important;
            color: #b91c1c !important;
            font-family: Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif !important;
            font-size: .79rem !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            background: linear-gradient(135deg,#fff1f2,#fff7ed) !important;
            border: 1px solid #fecdd3 !important;
            border-radius: 999px !important;
        }
        html body .ecom-attr-header::before { content: "✦"; color: #f59e0b; }
        html body .ecom-attr-list { display: grid !important; gap: 8px !important; margin-bottom: 16px !important; }
        html body .ecom-attr-row {
            display: flex !important;
            min-height: 42px !important;
            padding: 9px 11px !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 12px !important;
            background: #f8fafc !important;
            border: 1px solid #e8edf3 !important;
            border-left: 3px solid #ef4444 !important;
            border-radius: 9px !important;
            font-family: Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif !important;
        }
        html body .ecom-attr-row:nth-child(3n+2) { border-left-color: #3b82f6 !important; }
        html body .ecom-attr-row:nth-child(3n) { border-left-color: #10b981 !important; }
        html body .ecom-attr-label { color: #64748b !important; font-size: .69rem !important; font-weight: 800 !important; }
        html body .ecom-attr-value {
            max-width: 62% !important;
            padding: 4px 8px !important;
            overflow: hidden !important;
            color: #0f172a !important;
            font-size: .82rem !important;
            font-weight: 800 !important;
            text-align: right !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
            background: #fff !important;
            border: 1px solid #edf2f7 !important;
            border-radius: 7px !important;
        }
        html body .varied-attributes-title { color: #dc2626 !important; font-family: Inter,system-ui,sans-serif !important; font-weight: 900 !important; }

        [data-theme="dark"] body #avatarDropdown { background: #181818 !important; border-color: #303030 !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-user-card { background: linear-gradient(145deg,#1b1b1b,#24191a) !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-name { color: #f8fafc !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-email { color: #929baa !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-balance-box { background: #202020 !important; border-color: #3c292b !important; }
        [data-theme="dark"] body #avatarDropdown .profile-language-section { background: #181818 !important; }
        [data-theme="dark"] body #avatarDropdown .profile-language-section .ant-header-lang-trigger { background: #222 !important; border-color: #333 !important; }
        [data-theme="dark"] body #avatarDropdown .profile-language-section .ant-header-lang-text { color: #f3f4f6 !important; }

        @media (max-width: 1199px) {
            html body .nav-links .nav-dropdown::after { display: none !important; }
            html body .nav-links .nav-dropdown > .modern-dropdown-menu { width: 100% !important; min-width: 100% !important; top: auto !important; }
        }

        @media (max-width: 520px) {
            html body #avatarDropdown { right: -47px !important; width: min(340px,calc(100vw - 18px)) !important; }
            html body #avatarDropdown .dropdown-user-card { padding: 14px !important; }
        }
    `;

    document.head.appendChild(style);
})();

/* ================= 419 PAGE EXPIRED RECOVERY ================= */
(function install419Recovery() {
    function reloadAfter419() {
        var now = Date.now();
        var previous = parseInt(sessionStorage.getItem('shop_419_reload_at') || '0', 10);

        // Avoid an accidental reload loop if the backend is unavailable.
        if (now - previous < 2500) return;

        sessionStorage.setItem('shop_419_reload_at', String(now));

        if (typeof FuiToast !== 'undefined') {
            try { FuiToast.error('Phiên đăng nhập đã hết hạn. Đang tải lại trang...'); } catch (e) {}
        }

        setTimeout(function () { window.location.reload(); }, 180);
    }

    window.shopReloadAfter419 = reloadAfter419;

    if (window.fetch && !window.fetch.__shop419Wrapped) {
        var nativeFetch = window.fetch.bind(window);
        var wrappedFetch = function () {
            return nativeFetch.apply(window, arguments).then(function (response) {
                if (response && response.status === 419) {
                    reloadAfter419();
                    var error = new Error('SESSION_EXPIRED_419');
                    error.response = response;
                    throw error;
                }
                return response;
            });
        };
        wrappedFetch.__shop419Wrapped = true;
        window.fetch = wrappedFetch;
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (window.jQuery) {
            window.jQuery(document).ajaxError(function (_event, xhr) {
                if (xhr && xhr.status === 419) reloadAfter419();
            });
        }
    });
})();

function moveLanguageIntoProfile() {
    var avatarDropdown = document.getElementById('avatarDropdown');
    var langDropdown = document.querySelector('.nav-user > .ant-header-lang-dropdown');
    if (!avatarDropdown || !langDropdown || avatarDropdown.querySelector('.profile-language-section')) return;

    var section = document.createElement('div');
    section.className = 'profile-language-section';
    section.innerHTML = '<div class="profile-language-label"><span class="iconify" data-icon="ant-design:global-outlined"></span><span>Ngôn ngữ</span></div>';
    section.appendChild(langDropdown);

    var firstDivider = avatarDropdown.querySelector('.dropdown-divider');
    if (firstDivider) avatarDropdown.insertBefore(section, firstDivider);
    else avatarDropdown.appendChild(section);
}

function markVariedAttributesTitle() {
    document.querySelectorAll('h1,h2,h3,h4,.section-title,.card-title,.feature-title,.ecom-attr-header').forEach(function (element) {
        var text = (element.textContent || '').trim().toLocaleLowerCase('vi-VN');
        if (text.indexOf('thuộc tính đa dạng') !== -1) element.classList.add('varied-attributes-title');
    });
}

/* Desktop: hover OR click opens deposit menu. Mouse can leave briefly without closing. */
function setupDepositMenuAssist() {
    document.querySelectorAll('.nav-links .nav-dropdown').forEach(function (dropdown) {
        var menu = dropdown.querySelector('.modern-dropdown-menu');
        var trigger = dropdown.querySelector(':scope > .nav-link-item');
        if (!menu || !trigger) return;

        var closeTimer = null;

        function desktop() { return window.innerWidth >= 1200; }
        function openHover() {
            if (!desktop()) return;
            clearTimeout(closeTimer);
            dropdown.classList.add('deposit-hover-open');
        }
        function closeHoverLater() {
            if (!desktop()) return;
            clearTimeout(closeTimer);
            closeTimer = setTimeout(function () {
                dropdown.classList.remove('deposit-hover-open');
                if (!dropdown.classList.contains('deposit-click-open')) {
                    dropdown.classList.remove('deposit-hover-open');
                }
            }, 700);
        }

        dropdown.addEventListener('mouseenter', openHover);
        menu.addEventListener('mouseenter', openHover);
        dropdown.addEventListener('mouseleave', closeHoverLater);
        menu.addEventListener('mouseleave', closeHoverLater);

        trigger.addEventListener('click', function (event) {
            if (!desktop()) return;
            event.preventDefault();
            event.stopPropagation();
            clearTimeout(closeTimer);
            dropdown.classList.toggle('deposit-click-open');
            dropdown.classList.toggle('deposit-hover-open', dropdown.classList.contains('deposit-click-open'));
        });
    });

    document.addEventListener('click', function (event) {
        document.querySelectorAll('.nav-links .nav-dropdown.deposit-click-open').forEach(function (dropdown) {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('deposit-click-open', 'deposit-hover-open');
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.nav-links .nav-dropdown').forEach(function (dropdown) {
                dropdown.classList.remove('deposit-click-open', 'deposit-hover-open');
            });
        }
    });
}

function switchTab(btn, tabId) {
    document.querySelectorAll('.panel-tab').forEach(function (t) { t.classList.remove('active'); });
    document.querySelectorAll('.tab-content').forEach(function (c) { c.classList.remove('active'); });
    if (btn) btn.classList.add('active');
    var el = document.getElementById(tabId);
    if (el) el.classList.add('active');
}

function toggleAvatarMenu() {
    var dd = document.getElementById('avatarDropdown');
    if (dd) dd.classList.toggle('show');
}

window.toggleAvatarMenu = toggleAvatarMenu;

document.addEventListener('click', function (event) {
    var wrapper = document.getElementById('avatarWrapper');
    var dd = document.getElementById('avatarDropdown');
    if (wrapper && dd && !wrapper.contains(event.target)) dd.classList.remove('show');
});

document.addEventListener('DOMContentLoaded', function () {
    moveLanguageIntoProfile();
    markVariedAttributesTitle();

    /* Theme */
    var themeToggle = document.getElementById('themeToggle');
    var html = document.documentElement;
    var savedTheme = localStorage.getItem('theme') || window.__defaultTheme || 'light';
    html.setAttribute('data-theme', savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            var next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });
    }

    /* Mobile navigation */
    var navToggle = document.getElementById('navToggle');
    var navLinks = document.getElementById('navLinks');
    var navOverlay = document.getElementById('navOverlay');

    function toggleNav() {
        if (navLinks) navLinks.classList.toggle('show');
        if (navOverlay) navOverlay.classList.toggle('show');
        document.body.style.overflow = navLinks && navLinks.classList.contains('show') ? 'hidden' : '';
    }

    window.closeNav = function () {
        if (navLinks) navLinks.classList.remove('show');
        if (navOverlay) navOverlay.classList.remove('show');
        document.body.style.overflow = '';
    };

    if (navToggle) navToggle.addEventListener('click', toggleNav);
    if (navOverlay) navOverlay.addEventListener('click', window.closeNav);

    var navDropdowns = document.querySelectorAll('.nav-dropdown,.nav-mega-dropdown');
    function isDesktopDeposit(dropdown) {
        return window.matchMedia('(min-width: 1200px) and (hover: hover) and (pointer: fine)').matches &&
            dropdown.querySelector(':scope > .deposit-mega-menu');
    }

    function closeNavDropdowns(except) {
        navDropdowns.forEach(function (dropdown) {
            if (dropdown !== except) {
                dropdown.classList.remove('open', 'menu-open', 'menu-closed');
                var trigger = dropdown.querySelector(':scope > .nav-menu-trigger');
                var panel = dropdown.querySelector(':scope > .mega-menu, :scope > .modern-dropdown-menu');
                if (trigger) trigger.setAttribute('aria-expanded', 'false');
                if (panel && !isDesktopDeposit(dropdown)) panel.hidden = true;
            }
        });
    }

    document.querySelectorAll('.nav-menu-trigger').forEach(function (link) {
        var initialPanel = link.parentElement.querySelector(':scope > .mega-menu, :scope > .modern-dropdown-menu');
        if (initialPanel && !isDesktopDeposit(link.parentElement)) initialPanel.hidden = true;

        link.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var dropdown = this.parentElement;
            var panel = dropdown.querySelector(':scope > .mega-menu, :scope > .modern-dropdown-menu');
            var desktopDeposit = isDesktopDeposit(dropdown);
            var willOpen = desktopDeposit || (panel && (panel.hidden || !dropdown.classList.contains('menu-open')));
            closeNavDropdowns(dropdown);
            dropdown.classList.toggle('open', willOpen && !desktopDeposit);
            dropdown.classList.toggle('menu-open', willOpen && !desktopDeposit);
            dropdown.classList.toggle('menu-closed', !willOpen && !desktopDeposit);
            if (panel && !desktopDeposit) panel.hidden = !willOpen;
            this.setAttribute('aria-expanded', String(willOpen));
            console.info('[nav-menu]', this.textContent.trim(), willOpen ? 'open' : 'closed');
        });
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.nav-dropdown,.nav-mega-dropdown')) closeNavDropdowns();
    });

    /* Legacy toasts */
    document.querySelectorAll('.toast').forEach(function (toast) {
        setTimeout(function () { if (toast.parentNode) toast.remove(); }, 3500);
    });

    /* Copy buttons */
    document.querySelectorAll('.copy-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = this.getAttribute('data-target');
            var targetEl = document.getElementById(target);
            var text = targetEl ? targetEl.innerText : '';
            if (!navigator.clipboard) return;
            navigator.clipboard.writeText(text).then(function () {
                btn.textContent = 'Đã copy!';
                setTimeout(function () { btn.textContent = 'Copy'; }, 2000);
            });
        });
    });

    /* Admin sidebar */
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('adminSidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () { sidebar.classList.toggle('active'); });
    }

    /* Card animation */
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: .1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.card,.category-card,.stat-card').forEach(function (el) { observer.observe(el); });
    }

    /* Banner slider */
    var slides = document.querySelectorAll('.slide');
    var dots = document.querySelectorAll('.slider-dots .dot');
    var prevBtn = document.getElementById('sliderPrev');
    var nextBtn = document.getElementById('sliderNext');

    if (slides.length) {
        var currentSlide = 0;
        var sliderInterval = null;

        function goToSlide(index) {
            slides.forEach(function (s) { s.classList.remove('active'); });
            dots.forEach(function (d) { d.classList.remove('active'); });
            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            if (dots[currentSlide]) dots[currentSlide].classList.add('active');
        }

        function startAutoPlay() {
            clearInterval(sliderInterval);
            sliderInterval = setInterval(function () { goToSlide(currentSlide + 1); }, 5000);
        }
        function stopAutoPlay() { clearInterval(sliderInterval); }

        if (prevBtn) prevBtn.addEventListener('click', function () { stopAutoPlay(); goToSlide(currentSlide - 1); startAutoPlay(); });
        if (nextBtn) nextBtn.addEventListener('click', function () { stopAutoPlay(); goToSlide(currentSlide + 1); startAutoPlay(); });
        dots.forEach(function (dot) {
            dot.addEventListener('click', function () { stopAutoPlay(); goToSlide(parseInt(this.getAttribute('data-index'), 10) || 0); startAutoPlay(); });
        });

        var slider = document.getElementById('bannerSlider');
        if (slider) {
            slider.addEventListener('mouseenter', stopAutoPlay);
            slider.addEventListener('mouseleave', startAutoPlay);
        }
        startAutoPlay();
    }
});

/* Back to top */
(function () {
    function setup() {
        var btn = document.getElementById('backToTop');
        if (!btn) return;
        window.addEventListener('scroll', function () {
            btn.classList.toggle('visible', window.scrollY > 300);
        });
        btn.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', setup);
    else setup();
})();
