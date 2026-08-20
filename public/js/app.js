/**
 * ShopAcc - Frontend JavaScript
 */

(function installUiPolishStyles() {
    if (document.getElementById('shop-ui-polish-styles-v2')) return;

    var style = document.createElement('style');
    style.id = 'shop-ui-polish-styles-v2';
    style.textContent = `
        /* ================= PROFILE DROPDOWN ================= */
        html body #avatarWrapper {
            position: relative !important;
        }

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
            background: #ffffff !important;
            border: 1px solid #e8edf3 !important;
            border-radius: 18px !important;
            box-shadow: 0 22px 55px rgba(15, 23, 42, .18) !important;
            z-index: 12050 !important;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
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
            background:
                radial-gradient(circle at 92% 8%, rgba(239,68,68,.13), transparent 35%),
                linear-gradient(145deg, #ffffff 0%, #fff8f8 100%) !important;
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
            color: #ffffff !important;
            font-size: 1.05rem !important;
            font-weight: 900 !important;
            line-height: 1 !important;
            text-transform: uppercase !important;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 55%, #b91c1c 100%) !important;
            border: 3px solid #ffffff !important;
            border-radius: 15px !important;
            box-shadow: 0 8px 20px rgba(220, 38, 38, .26) !important;
        }

        html body #avatarDropdown .dropdown-user-meta {
            min-width: 0 !important;
            flex: 1 1 auto !important;
        }

        html body #avatarDropdown .dropdown-name {
            margin: 0 !important;
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
            font-weight: 500 !important;
            line-height: 1.35 !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        html body #avatarDropdown .dropdown-balance-box {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) auto !important;
            align-items: center !important;
            gap: 5px 12px !important;
            margin-top: 14px !important;
            padding: 12px 13px !important;
            background: rgba(255,255,255,.94) !important;
            border: 1px solid #fee2e2 !important;
            border-radius: 13px !important;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.8) !important;
        }

        html body #avatarDropdown .dropdown-balance-label {
            grid-column: 1 / -1 !important;
            color: #64748b !important;
            font-size: .69rem !important;
            font-weight: 750 !important;
            letter-spacing: .025em !important;
            text-transform: uppercase !important;
        }

        html body #avatarDropdown .dropdown-balance-val {
            min-width: 0 !important;
            color: #dc2626 !important;
            font-size: 1.22rem !important;
            font-weight: 900 !important;
            line-height: 1.15 !important;
            white-space: nowrap !important;
        }

        html body #avatarDropdown .dropdown-balance-cur {
            font-size: .78rem !important;
            font-weight: 850 !important;
        }

        html body #avatarDropdown .dropdown-btn-deposit {
            display: inline-flex !important;
            min-height: 36px !important;
            padding: 0 13px !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            color: #ffffff !important;
            font-size: .77rem !important;
            font-weight: 850 !important;
            text-decoration: none !important;
            white-space: nowrap !important;
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            border: 1px solid #dc2626 !important;
            border-radius: 9px !important;
            box-shadow: 0 7px 16px rgba(220, 38, 38, .22) !important;
            transition: transform .16s ease, box-shadow .16s ease, filter .16s ease !important;
        }

        html body #avatarDropdown .dropdown-btn-deposit:hover {
            color: #ffffff !important;
            filter: brightness(.96) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 9px 20px rgba(220, 38, 38, .28) !important;
        }

        html body #avatarDropdown .dropdown-divider {
            height: 1px !important;
            margin: 0 !important;
            background: #eef2f6 !important;
            border: 0 !important;
        }

        html body #avatarDropdown .dropdown-menu-links {
            padding: 7px !important;
        }

        html body #avatarDropdown .dropdown-item {
            display: flex !important;
            width: 100% !important;
            min-height: 41px !important;
            margin: 0 !important;
            padding: 8px 10px !important;
            align-items: center !important;
            gap: 10px !important;
            color: #334155 !important;
            font-size: .81rem !important;
            font-weight: 680 !important;
            line-height: 1.2 !important;
            text-align: left !important;
            text-decoration: none !important;
            border-radius: 10px !important;
            box-sizing: border-box !important;
            transition: background .15s ease, color .15s ease, transform .15s ease !important;
        }

        html body #avatarDropdown .dropdown-item:hover {
            color: #dc2626 !important;
            background: #fff1f2 !important;
            transform: translateX(2px) !important;
        }

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
            font-size: .91rem !important;
        }

        html body #avatarDropdown .dropdown-item:hover .dropdown-item-icon {
            color: #dc2626 !important;
            background: #fee2e2 !important;
            border-color: #fecaca !important;
        }

        html body #avatarDropdown .dropdown-logout {
            color: #dc2626 !important;
        }

        /* Language is moved into profile when logged in */
        html body #avatarDropdown .profile-language-section {
            padding: 10px 12px 12px !important;
            background: #ffffff !important;
        }

        html body #avatarDropdown .profile-language-label {
            display: flex !important;
            align-items: center !important;
            gap: 7px !important;
            margin-bottom: 7px !important;
            color: #64748b !important;
            font-size: .69rem !important;
            font-weight: 800 !important;
            letter-spacing: .025em !important;
            text-transform: uppercase !important;
        }

        html body #avatarDropdown .profile-language-label .iconify {
            color: #dc2626 !important;
            font-size: .9rem !important;
        }

        html body #avatarDropdown .profile-language-section .ant-header-lang-dropdown {
            position: relative !important;
            width: 100% !important;
            z-index: 20 !important;
        }

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
            box-sizing: border-box !important;
        }

        html body #avatarDropdown .profile-language-section .ant-header-lang-text {
            color: #1f2937 !important;
            font-size: .79rem !important;
            font-weight: 800 !important;
        }

        html body #avatarDropdown .profile-language-section .lang-arrow {
            margin-left: auto !important;
        }

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
            background: #ffffff !important;
            border: 0 !important;
            border-radius: 10px !important;
            box-shadow: none !important;
            transition: max-height .2s ease, opacity .18s ease, margin .2s ease, padding .2s ease !important;
        }

        html body #avatarDropdown .profile-language-section .ant-header-lang-dropdown.active .ant-dropdown-menu,
        html body #avatarDropdown .profile-language-section .ant-header-lang-dropdown:hover .ant-dropdown-menu {
            max-height: 260px !important;
            margin-top: 7px !important;
            padding: 5px !important;
            opacity: 1 !important;
            visibility: visible !important;
            border: 1px solid #e5e7eb !important;
        }

        html body #avatarDropdown .profile-language-section .ant-dropdown-item {
            min-height: 35px !important;
            padding: 7px 9px !important;
            border-radius: 8px !important;
            color: #334155 !important;
            font-size: .78rem !important;
            cursor: pointer !important;
        }

        html body #avatarDropdown .profile-language-section .ant-dropdown-item:hover {
            color: #dc2626 !important;
            background: #fff1f2 !important;
        }

        html body #avatarDropdown .profile-language-section .ant-dropdown-item img {
            width: 19px !important;
            height: 14px !important;
            object-fit: cover !important;
            border-radius: 2px !important;
        }

        /* ================= DEPOSIT NAV HOVER ================= */
        html body .nav-links .nav-dropdown {
            position: relative !important;
        }

        html body .nav-links .nav-dropdown::after {
            content: "";
            position: absolute;
            top: 100%;
            left: -6px;
            width: calc(100% + 12px);
            height: 14px;
            z-index: 1090;
        }

        html body .nav-links .nav-dropdown > .modern-dropdown-menu {
            top: calc(100% + 2px) !important;
            width: 306px !important;
            min-width: 306px !important;
            padding: 8px !important;
            border-radius: 13px !important;
            z-index: 1100 !important;
        }

        html body .nav-links .nav-dropdown:hover > .modern-dropdown-menu,
        html body .nav-links .nav-dropdown.deposit-hover-open > .modern-dropdown-menu,
        html body .nav-links .nav-dropdown > .modern-dropdown-menu:hover {
            display: block !important;
        }

        html body .nav-links .nav-dropdown .dropdown-link-card {
            min-height: 56px !important;
            padding: 10px 11px !important;
            border-radius: 10px !important;
            transition: background .15s ease, transform .15s ease !important;
        }

        html body .nav-links .nav-dropdown .dropdown-link-card:hover {
            background: #f8fafc !important;
            transform: translateX(2px) !important;
        }

        /* ================= ACCOUNT ATTRIBUTES ================= */
        html body .ecom-attr-header {
            display: inline-flex !important;
            align-items: center !important;
            gap: 7px !important;
            margin: 2px 0 12px !important;
            padding: 7px 12px !important;
            color: #b91c1c !important;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
            font-size: .79rem !important;
            font-weight: 900 !important;
            letter-spacing: .035em !important;
            text-transform: uppercase !important;
            background: linear-gradient(135deg, #fff1f2, #fff7ed) !important;
            border: 1px solid #fecdd3 !important;
            border-radius: 999px !important;
        }

        html body .ecom-attr-header::before {
            content: "✦";
            color: #f59e0b;
        }

        html body .ecom-attr-list {
            display: grid !important;
            gap: 8px !important;
            margin-bottom: 16px !important;
        }

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
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
        }

        html body .ecom-attr-row:nth-child(3n+2) { border-left-color: #3b82f6 !important; }
        html body .ecom-attr-row:nth-child(3n) { border-left-color: #10b981 !important; }

        html body .ecom-attr-label {
            color: #64748b !important;
            font-size: .69rem !important;
            font-weight: 800 !important;
            letter-spacing: .04em !important;
        }

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
            background: #ffffff !important;
            border: 1px solid #edf2f7 !important;
            border-radius: 7px !important;
        }

        html body .varied-attributes-title {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            color: #dc2626 !important;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
            font-weight: 900 !important;
        }

        html body .varied-attributes-title::before {
            content: "✦";
            display: inline-flex;
            width: 26px;
            height: 26px;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: .78rem;
            background: linear-gradient(135deg, #ef4444, #f59e0b);
            border-radius: 8px;
        }

        /* ================= CLOSABLE TOAST ================= */
        html body #fui-toast > * {
            position: relative !important;
            padding-right: 46px !important;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
        }

        html body #fui-toast > *.shop-balance-toast {
            border-left: 4px solid #ef4444 !important;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .14) !important;
        }

        html body .shop-toast-close {
            position: absolute !important;
            top: 50% !important;
            right: 10px !important;
            width: 28px !important;
            height: 28px !important;
            padding: 0 !important;
            transform: translateY(-50%) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #64748b !important;
            font-size: 18px !important;
            background: rgba(148, 163, 184, .12) !important;
            border: 0 !important;
            border-radius: 50% !important;
            cursor: pointer !important;
            z-index: 5 !important;
        }

        html body .shop-toast-close:hover {
            color: #dc2626 !important;
            background: #fee2e2 !important;
        }

        /* ================= DARK MODE ================= */
        [data-theme="dark"] body #avatarDropdown {
            background: #181818 !important;
            border-color: #303030 !important;
            box-shadow: 0 22px 55px rgba(0, 0, 0, .55) !important;
        }
        [data-theme="dark"] body #avatarDropdown .dropdown-user-card {
            background: radial-gradient(circle at 92% 8%, rgba(239,68,68,.12), transparent 35%), linear-gradient(145deg, #1b1b1b, #24191a) !important;
        }
        [data-theme="dark"] body #avatarDropdown .dropdown-user-avatar { border-color: #292929 !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-name { color: #f8fafc !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-email { color: #929baa !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-balance-box { background: #202020 !important; border-color: #3c292b !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-divider { background: #2d2d2d !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-item { color: #d7dce3 !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-item:hover { color: #fb7185 !important; background: #2b2021 !important; }
        [data-theme="dark"] body #avatarDropdown .dropdown-item-icon { color: #a3a3a3 !important; background: #252525 !important; border-color: #303030 !important; }
        [data-theme="dark"] body #avatarDropdown .profile-language-section { background: #181818 !important; }
        [data-theme="dark"] body #avatarDropdown .profile-language-section .ant-header-lang-trigger { color: #f3f4f6 !important; background: #222 !important; border-color: #333 !important; }
        [data-theme="dark"] body #avatarDropdown .profile-language-section .ant-header-lang-text { color: #f3f4f6 !important; }
        [data-theme="dark"] body #avatarDropdown .profile-language-section .ant-dropdown-menu { background: #202020 !important; border-color: #333 !important; }
        [data-theme="dark"] body #avatarDropdown .profile-language-section .ant-dropdown-item { color: #d1d5db !important; }
        [data-theme="dark"] body #avatarDropdown .profile-language-section .ant-dropdown-item:hover { background: #2b2021 !important; color: #fb7185 !important; }
        [data-theme="dark"] body .ecom-attr-header { background: #2b2021 !important; border-color: #4a292d !important; color: #fda4af !important; }
        [data-theme="dark"] body .ecom-attr-row { background: #1f1f1f !important; border-color: #303030 !important; }
        [data-theme="dark"] body .ecom-attr-label { color: #9ca3af !important; }
        [data-theme="dark"] body .ecom-attr-value { color: #f3f4f6 !important; background: #282828 !important; border-color: #333 !important; }

        @media (max-width: 1024px) {
            html body .nav-links .nav-dropdown::after { display: none !important; }
            html body .nav-links .nav-dropdown > .modern-dropdown-menu {
                width: 100% !important;
                min-width: 100% !important;
                top: auto !important;
            }
        }

        @media (max-width: 520px) {
            html body #avatarDropdown {
                right: -47px !important;
                width: min(340px, calc(100vw - 18px)) !important;
            }
            html body #avatarDropdown .dropdown-user-card { padding: 14px !important; }
            html body #avatarDropdown .dropdown-user-avatar { width: 47px !important; height: 47px !important; min-width: 47px !important; }
        }
    `;

    document.head.appendChild(style);
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
    if (firstDivider) {
        avatarDropdown.insertBefore(section, firstDivider);
    } else {
        avatarDropdown.appendChild(section);
    }
}

function enhanceFuiToast(toast) {
    if (!toast || toast.nodeType !== 1 || toast.dataset.shopClosable === '1') return;

    toast.dataset.shopClosable = '1';
    var message = (toast.textContent || '').trim().toLowerCase();
    if (message.indexOf('số dư không đủ') !== -1 || message.indexOf('vui lòng nạp thêm tiền') !== -1) {
        toast.classList.add('shop-balance-toast');
    }

    var closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'shop-toast-close';
    closeBtn.setAttribute('aria-label', 'Đóng thông báo');
    closeBtn.setAttribute('title', 'Đóng');
    closeBtn.textContent = '×';
    closeBtn.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
        toast.remove();
    });
    toast.appendChild(closeBtn);
}

function setupClosableToasts() {
    var root = document.getElementById('fui-toast');
    if (!root) return;

    Array.from(root.children).forEach(enhanceFuiToast);

    var toastObserver = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            mutation.addedNodes.forEach(function (node) {
                if (node.nodeType === 1 && node.parentElement === root) enhanceFuiToast(node);
            });
        });
    });

    toastObserver.observe(root, { childList: true, subtree: false });
}

function markVariedAttributesTitle() {
    var candidates = document.querySelectorAll('h1, h2, h3, h4, .section-title, .card-title, .feature-title, .ecom-attr-header');
    candidates.forEach(function (element) {
        var text = (element.textContent || '').trim().toLocaleLowerCase('vi-VN');
        if (text.indexOf('thuộc tính đa dạng') !== -1) {
            element.classList.add('varied-attributes-title');
        }
    });
}

function setupDepositHoverAssist() {
    document.querySelectorAll('.nav-links .nav-dropdown').forEach(function (dropdown) {
        var closeTimer = null;
        var menu = dropdown.querySelector('.modern-dropdown-menu');
        if (!menu) return;

        function openMenu() {
            if (window.innerWidth <= 1024) return;
            clearTimeout(closeTimer);
            dropdown.classList.add('deposit-hover-open');
        }

        function scheduleClose() {
            if (window.innerWidth <= 1024) return;
            clearTimeout(closeTimer);
            closeTimer = setTimeout(function () {
                dropdown.classList.remove('deposit-hover-open');
            }, 320);
        }

        dropdown.addEventListener('mouseenter', openMenu);
        dropdown.addEventListener('mouseleave', scheduleClose);
        menu.addEventListener('mouseenter', openMenu);
        menu.addEventListener('mouseleave', scheduleClose);
    });
}

// Tab switching for hero panel
function switchTab(btn, tabId) {
    document.querySelectorAll('.panel-tab').forEach(function (t) { t.classList.remove('active'); });
    document.querySelectorAll('.tab-content').forEach(function (c) { c.classList.remove('active'); });
    btn.classList.add('active');
    var el = document.getElementById(tabId);
    if (el) el.classList.add('active');
}

// Avatar dropdown toggle
function toggleAvatarMenu() {
    var dd = document.getElementById('avatarDropdown');
    if (dd) dd.classList.toggle('show');
}

// Close avatar dropdown when clicking outside
document.addEventListener('click', function (e) {
    var wrapper = document.getElementById('avatarWrapper');
    var dd = document.getElementById('avatarDropdown');
    if (wrapper && dd && !wrapper.contains(e.target)) {
        dd.classList.remove('show');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    moveLanguageIntoProfile();
    setupClosableToasts();
    markVariedAttributesTitle();
    setupDepositHoverAssist();

    // ---- Theme Toggle ----
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    const defaultTheme = window.__defaultTheme || 'light';
    const savedTheme = localStorage.getItem('theme') || defaultTheme;
    html.setAttribute('data-theme', savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });
    }

    // ---- Mobile Nav Toggle ----
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    const navOverlay = document.getElementById('navOverlay');

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

    // ---- Mobile Nav Dropdown Toggle ----
    document.querySelectorAll('.nav-dropdown > .nav-link-item, .nav-mega-dropdown > .nav-link-item').forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (window.innerWidth <= 1024) {
                e.preventDefault();
                this.parentElement.classList.toggle('open');
            }
        });
    });

    // ---- Auto-dismiss legacy toasts ----
    document.querySelectorAll('.toast').forEach(function (toast) {
        setTimeout(function () { toast.remove(); }, 3500);
    });

    // ---- Copy to clipboard ----
    document.querySelectorAll('.copy-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const target = this.getAttribute('data-target');
            const text = document.getElementById(target)?.innerText || '';
            navigator.clipboard.writeText(text).then(function () {
                btn.textContent = 'Đã copy!';
                setTimeout(function () { btn.textContent = 'Copy'; }, 2000);
            });
        });
    });

    // ---- Admin Sidebar Toggle ----
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }

    // ---- Animate cards on scroll ----
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.card, .category-card, .stat-card').forEach(function (el) {
            observer.observe(el);
        });
    }

    // ---- Banner Slider ----
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dots .dot');
    const prevBtn = document.getElementById('sliderPrev');
    const nextBtn = document.getElementById('sliderNext');

    if (slides.length > 0) {
        let currentSlide = 0;
        let sliderInterval;

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

        function stopAutoPlay() {
            clearInterval(sliderInterval);
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { stopAutoPlay(); goToSlide(currentSlide - 1); startAutoPlay(); });
        if (nextBtn) nextBtn.addEventListener('click', function () { stopAutoPlay(); goToSlide(currentSlide + 1); startAutoPlay(); });

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                stopAutoPlay();
                goToSlide(parseInt(this.getAttribute('data-index')) || 0);
                startAutoPlay();
            });
        });

        var slider = document.getElementById('bannerSlider');
        if (slider) {
            slider.addEventListener('mouseenter', stopAutoPlay);
            slider.addEventListener('mouseleave', startAutoPlay);
        }

        startAutoPlay();
    }
});

// Back to Top
(function () {
    var btn = document.getElementById('backToTop');
    if (!btn) return;

    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) btn.classList.add('visible');
        else btn.classList.remove('visible');
    });

    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();
