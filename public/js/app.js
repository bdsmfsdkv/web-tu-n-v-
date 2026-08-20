/**
 * ShopAcc - Frontend JavaScript
 */

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
            if (window.innerWidth <= 1024) {
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
                btn.textContent = 'ÄĂ£ copy!';
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
