/**
 * ShopAcc - Frontend JavaScript
 * UI helpers, profile/language dropdown, deposit menu assist and 419 recovery.
 */

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

/* Refresh purchase source only when browser restores stale page from bfcache. */
window.addEventListener('pageshow', function (event) {
    if (sessionStorage.getItem('refreshPurchaseSource') !== '1' || window.location.pathname.indexOf('/profile/purchased-') === 0) return;

    sessionStorage.removeItem('refreshPurchaseSource');
    var scrollY = parseInt(sessionStorage.getItem('purchaseReturnScrollY') || '0', 10);
    sessionStorage.removeItem('purchaseReturnScrollY');

    if (event.persisted) {
        window.location.reload();
        return;
    }

    if (scrollY > 0) requestAnimationFrame(function () { window.scrollTo(0, scrollY); });
});

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

    function toggleNav(e) {
        if (e) e.stopPropagation();
        var isOpen = navLinks && navLinks.classList.contains('show');
        if (navLinks) navLinks.classList.toggle('show', !isOpen);
        if (navOverlay) navOverlay.classList.toggle('show', !isOpen);
        if (navToggle) navToggle.classList.toggle('active', !isOpen);
    }

    window.closeNav = function () {
        if (navLinks) navLinks.classList.remove('show');
        if (navOverlay) navOverlay.classList.remove('show');
        if (navToggle) navToggle.classList.remove('active');
    };

    if (navToggle) navToggle.addEventListener('click', toggleNav);
    if (navOverlay) navOverlay.addEventListener('click', window.closeNav);

    // Tự động đóng menu khi bấm vào bất kỳ link điều hướng nào
    if (navLinks) {
        navLinks.querySelectorAll('a[href]').forEach(function(link) {
            var href = link.getAttribute('href');
            if (href && href !== '#' && !href.startsWith('javascript:')) {
                link.addEventListener('click', function() {
                    window.closeNav();
                });
            }
        });
    }

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

    navDropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('mouseleave', function() {
            if (window.innerWidth >= 1025) {
                closeNavDropdowns();
            }
        });
    });

    document.querySelectorAll('.nav-menu-trigger').forEach(function (link) {
        var initialPanel = link.parentElement.querySelector(':scope > .mega-menu, :scope > .modern-dropdown-menu');
        if (initialPanel && !isDesktopDeposit(link.parentElement)) initialPanel.hidden = true;

        link.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var dropdown = this.parentElement;
            var panel = dropdown.querySelector(':scope > .mega-menu, :scope > .modern-dropdown-menu');
            var desktopDeposit = isDesktopDeposit(dropdown);
            var isCurrentlyOpen = dropdown.classList.contains('open') || dropdown.classList.contains('menu-open') || (panel && !panel.hidden);
            var willOpen = !isCurrentlyOpen;
            
            closeNavDropdowns(dropdown);
            dropdown.classList.toggle('open', willOpen);
            dropdown.classList.toggle('menu-open', willOpen);
            dropdown.classList.toggle('menu-closed', !willOpen);
            if (panel) panel.hidden = !willOpen;
            this.setAttribute('aria-expanded', String(willOpen));
        });
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.nav-dropdown,.nav-mega-dropdown')) closeNavDropdowns();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeNavDropdowns();
    });

    window.addEventListener('scroll', function () {
        if (window.innerWidth >= 1025) {
            closeNavDropdowns();
        }
    }, { passive: true });

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

/* ================= NATIVE NAVIGATION LOADER ASSIST ================= */
(function setupNavigationLoader() {
    document.addEventListener('click', function (event) {
        var link = event.target.closest('a');
        if (!link) return;

        // Bỏ qua nếu có modifier keys hoặc chuột không phải click trái
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
        }

        // Bỏ qua nếu link mở tab mới
        var target = link.getAttribute('target');
        if (target && target !== '_self') return;

        // Bỏ qua nếu là file download
        if (link.hasAttribute('download')) return;

        var href = link.getAttribute('href');
        if (!href) return;

        // Bỏ qua hash links (#), javascript, tel, mailto, zalo
        if (href === '#' || href.indexOf('#') === 0 || href.indexOf('javascript:') === 0 || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0 || href.indexOf('zalo:') === 0) {
            return;
        }

        // Bỏ qua các trigger mở modal / dropdown / offcanvas
        if (link.hasAttribute('data-no-loader') || link.classList.contains('nav-menu-trigger') || link.getAttribute('data-bs-toggle') || link.getAttribute('data-toggle')) {
            return;
        }

        try {
            var url = new URL(link.href, window.location.origin);

            // Bỏ qua nếu là hash link trên chính trang hiện tại
            if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) {
                return;
            }

            // Tự động đóng Menu Mobile nếu đang mở
            if (typeof window.closeNav === 'function') {
                window.closeNav();
            }

            // Kích hoạt loader 4 chấm mượt mà khi bắt đầu chuyển trang
            if (typeof window.showPageLoader === 'function') {
                window.showPageLoader();
            }
        } catch (e) {
            // Không can thiệp nếu URL parse lỗi
        }
    }, true);
})();

