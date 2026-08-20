/**
 * ShopAcc - Frontend JavaScript
 */

// UI polish loaded globally after the page markup.
(function installUiPolishStyles() {
    if (document.getElementById('shop-ui-polish-styles')) return;

    var style = document.createElement('style');
    style.id = 'shop-ui-polish-styles';
    style.textContent = `
        /* ===== User avatar dropdown ===== */
        html body .nav-avatar-wrapper {
            position: relative !important;
        }

        html body .avatar-dropdown {
            display: none;
            position: absolute !important;
            top: calc(100% + 12px) !important;
            right: 0 !important;
            left: auto !important;
            width: 310px !important;
            max-width: calc(100vw - 24px) !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .16) !important;
            z-index: 12050 !important;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
        }

        html body .avatar-dropdown.show {
            display: block !important;
            animation: avatarDropdownIn .18s ease-out both;
        }

        @keyframes avatarDropdownIn {
            from { opacity: 0; transform: translateY(-6px) scale(.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        html body .dropdown-user-card {
            padding: 16px !important;
            background: linear-gradient(145deg, #fff 0%, #fff7f7 100%) !important;
        }

        html body .dropdown-user-header {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            min-width: 0 !important;
        }

        html body .dropdown-user-avatar {
            width: 46px !important;
            height: 46px !important;
            min-width: 46px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 13px !important;
            background: linear-gradient(135deg, #ef4444, #b91c1c) !important;
            color: #ffffff !important;
            font-size: 1rem !important;
            font-weight: 900 !important;
            line-height: 1 !important;
            box-shadow: 0 7px 16px rgba(220, 38, 38, .24) !important;
        }

        html body .dropdown-user-meta {
            min-width: 0 !important;
            flex: 1 !important;
        }

        html body .dropdown-name {
            margin: 0 !important;
            overflow: hidden !important;
            color: #111827 !important;
            font-size: .92rem !important;
            font-weight: 800 !important;
            line-height: 1.35 !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        html body .dropdown-email {
            margin-top: 3px !important;
            overflow: hidden !important;
            color: #94a3b8 !important;
            font-size: .75rem !important;
            font-weight: 500 !important;
            line-height: 1.35 !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        html body .dropdown-balance-box {
            display: grid !important;
            grid-template-columns: 1fr auto !important;
            align-items: end !important;
            gap: 4px 10px !important;
            margin-top: 14px !important;
            padding: 12px !important;
            background: rgba(255, 255, 255, .9) !important;
            border: 1px solid #fee2e2 !important;
            border-radius: 12px !important;
        }

        html body .dropdown-balance-label {
            grid-column: 1 / -1 !important;
            color: #64748b !important;
            font-size: .7rem !important;
            font-weight: 700 !important;
            letter-spacing: .02em !important;
        }

        html body .dropdown-balance-val {
            color: #dc2626 !important;
            font-size: 1.25rem !important;
            font-weight: 900 !important;
            line-height: 1.2 !important;
        }

        html body .dropdown-balance-cur {
            font-size: .76rem !important;
            font-weight: 800 !important;
        }

        html body .dropdown-btn-deposit {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 5px !important;
            min-height: 32px !important;
            padding: 0 11px !important;
            color: #ffffff !important;
            font-size: .75rem !important;
            font-weight: 800 !important;
            text-decoration: none !important;
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            border-radius: 8px !important;
            box-shadow: 0 5px 12px rgba(220, 38, 38, .18) !important;
        }

        html body .avatar-dropdown .dropdown-divider {
            height: 1px !important;
            margin: 0 !important;
            background: #f1f5f9 !important;
            border: 0 !important;
        }

        html body .avatar-dropdown .dropdown-menu-links {
            padding: 7px !important;
        }

        html body .avatar-dropdown .dropdown-item {
            display: flex !important;
            width: 100% !important;
            min-height: 39px !important;
            margin: 0 !important;
            padding: 8px 10px !important;
            align-items: center !important;
            gap: 9px !important;
            color: #334155 !important;
            font-size: .8rem !important;
            font-weight: 650 !important;
            line-height: 1.2 !important;
            text-align: left !important;
            text-decoration: none !important;
            border-radius: 9px !important;
            box-sizing: border-box !important;
            transition: background .15s ease, color .15s ease !important;
        }

        html body .avatar-dropdown .dropdown-item:hover {
            color: #dc2626 !important;
            background: #fff1f2 !important;
        }

        html body .avatar-dropdown .dropdown-item-icon {
            width: 28px !important;
            height: 28px !important;
            min-width: 28px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #64748b !important;
            background: #f8fafc !important;
            border-radius: 7px !important;
            font-size: .9rem !important;
        }

        html body .avatar-dropdown .dropdown-item:hover .dropdown-item-icon {
            color: #dc2626 !important;
            background: #fee2e2 !important;
        }

        html body .avatar-dropdown .dropdown-logout {
            color: #dc2626 !important;
        }

        /* ===== Product/account attributes ===== */
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
            font-size: .9rem;
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
            line-height: 1.35 !important;
        }

        html body .ecom-attr-value {
            max-width: 62% !important;
            padding: 4px 8px !important;
            overflow: hidden !important;
            color: #0f172a !important;
            font-size: .82rem !important;
            font-weight: 800 !important;
            line-height: 1.35 !important;
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
            letter-spacing: -.01em !important;
        }

        html body .varied-attributes-title::before {
            content: "✦";
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            color: #ffffff;
            font-size: .78rem;
            background: linear-gradient(135deg, #ef4444, #f59e0b);
            border-radius: 8px;
            box-shadow: 0 5px 12px rgba(239, 68, 68, .2);
        }

        /* ===== Closable FuiToast / balance warning ===== */
        html body #fui-toast > * {
            position: relative !important;
            padding-right: 46px !important;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
        }

        html body #fui-toast > *.shop-balance-toast {
            border-left: 4px solid #ef4444 !important;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .14) !important;
        }

        .shop-toast-close {
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
            font-weight: 500 !important;
            line-height: 1 !important;
            background: rgba(148, 163, 184, .12) !important;
            border: 0 !important;
            border-radius: 50% !important;
            cursor: pointer !important;
            z-index: 5 !important;
            transition: background .15s ease, color .15s ease, transform .15s ease !important;
        }

        .shop-toast-close:hover {
            color: #dc2626 !important;
            background: #fee2e2 !important;
            transform: translateY(-50%) scale(1.06) !important;
        }

        [data-theme="dark"] body .avatar-dropdown {
            background: #181818 !important;
            border-color: #303030 !important;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .5) !important;
        }
        [data-theme="dark"] body .dropdown-user-card { background: linear-gradient(145deg, #1b1b1b, #251719) !important; }
        [data-theme="dark"] body .dropdown-name { color: #f8fafc !important; }
        [data-theme="dark"] body .dropdown-email { color: #8f98a7 !important; }
        [data-theme="dark"] body .dropdown-balance-box { background: #202020 !important; border-color: #3a2527 !important; }
        [data-theme="dark"] body .avatar-dropdown .dropdown-divider { background: #2d2d2d !important; }
        [data-theme="dark"] body .avatar-dropdown .dropdown-item { color: #d7dce3 !important; }
        [data-theme="dark"] body .avatar-dropdown .dropdown-item:hover { background: #2b2021 !important; color: #fb7185 !important; }
        [data-theme="dark"] body .avatar-dropdown .dropdown-item-icon { background: #252525 !important; color: #a3a3a3 !important; }
        [data-theme="dark"] body .ecom-attr-header { background: #2b2021 !important; border-color: #4a292d !important; color: #fda4af !important; }
        [data-theme="dark"] body .ecom-attr-row { background: #1f1f1f !important; border-color: #303030 !important; }
        [data-theme="dark"] body .ecom-attr-label { color: #9ca3af !important; }
        [data-theme="dark"] body .ecom-attr-value { color: #f3f4f6 !important; background: #282828 !important; border-color: #333 !important; }

        @media (max-width: 520px) {
            html body .avatar-dropdown {
                right: -48px !important;
                width: min(310px, calc(100vw - 20px)) !important;
            }
            html body .dropdown-user-card { padding: 14px !important; }
        }
    `;
    document.head.appendChild(style);
})();

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
                if (node.nodeType !== 1) return;
                if (node.parentElement === root) {
                    enhanceFuiToast(node);
                } else if (node.querySelectorAll) {
                    node.querySelectorAll(':scope > *').forEach(enhanceFuiToast);
                }
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

// Close dropdown when clicking outside
document.addEventListener('click', function (e) {
    var wrapper = document.getElementById('avatarWrapper');
    var dd = document.getElementById('avatarDropdown');
    if (wrapper && dd && !wrapper.contains(e.target)) {
        dd.classList.remove('show');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    setupClosableToasts();
    markVariedAttributesTitle();

    // ---- Theme Toggle ----
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;

    // Load saved theme (fallback to server-set default)
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

    // ---- Mobile Nav Toggle (Offcanvas) ----
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    const navOverlay = document.getElementById('navOverlay');

    function toggleNav() {
        if (navLinks) navLinks.classList.toggle('show');
        if (navOverlay) navOverlay.classList.toggle('show');
        document.body.style.overflow = navLinks && navLinks.classList.contains('show') ? 'hidden' : '';
    }

    // Global so onclick="closeNav()" works
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
            if (window.innerWidth <= 1199) {
                e.preventDefault();
                this.parentElement.classList.toggle('open');
            }
        });
    });

    // ---- Auto-dismiss toasts ----
    document.querySelectorAll('.toast').forEach(function (toast) {
        setTimeout(function () {
            toast.remove();
        }, 3500);
    });

    // ---- Copy to clipboard ----
    document.querySelectorAll('.copy-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const target = this.getAttribute('data-target');
            const text = document.getElementById(target)?.innerText || '';
            navigator.clipboard.writeText(text).then(function () {
                btn.textContent = 'Đã copy!';
                setTimeout(function () {
                    btn.textContent = 'Copy';
                }, 2000);
            });
        });
    });

    // ---- Admin Sidebar Toggle (Mobile) ----
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }

    // ---- Animate cards on scroll ----
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.card, .category-card, .stat-card').forEach(function (el) {
        observer.observe(el);
    });

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
            sliderInterval = setInterval(function () {
                goToSlide(currentSlide + 1);
            }, 5000);
        }

        function stopAutoPlay() {
            clearInterval(sliderInterval);
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { stopAutoPlay(); goToSlide(currentSlide - 1); startAutoPlay(); });
        if (nextBtn) nextBtn.addEventListener('click', function () { stopAutoPlay(); goToSlide(currentSlide + 1); startAutoPlay(); });

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                stopAutoPlay();
                goToSlide(parseInt(this.getAttribute('data-index')));
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
(function() {
    var btn = document.getElementById('backToTop');
    if (!btn) return;
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    });
    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();
