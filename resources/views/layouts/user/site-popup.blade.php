@php
    $sitePopupEnabled = (bool) config_get('welcome_modal', false);
    $sitePopupContent = trim((string) config_get('home_notification', ''));
    $sitePopupVersion = substr(sha1($sitePopupContent), 0, 12);
@endphp

@if($sitePopupEnabled && $sitePopupContent !== '')
<div id="siteAnnouncementOverlay"
     class="kc-site-popup-overlay"
     data-popup-version="{{ $sitePopupVersion }}"
     role="dialog"
     aria-modal="true"
     aria-labelledby="siteAnnouncementTitle"
     aria-hidden="true">
    <div class="kc-site-popup" role="document">
        <button type="button" class="kc-site-popup-close" id="siteAnnouncementClose" aria-label="Đóng thông báo">×</button>

        <div class="kc-site-popup-icon" aria-hidden="true">
            <span class="iconify" data-icon="ant-design:notification-filled"></span>
        </div>

        <div class="kc-site-popup-copy">
            <div class="kc-site-popup-kicker">KUNCHEAP</div>
            <h2 id="siteAnnouncementTitle">Thông báo mới</h2>
            <div class="kc-site-popup-message">{!! nl2br(e($sitePopupContent)) !!}</div>
        </div>

        <div class="kc-site-popup-actions">
            <button type="button" class="kc-site-popup-primary" id="siteAnnouncementOk">Đã hiểu</button>
        </div>
    </div>
</div>

<style>
    .kc-site-popup-overlay {
        position: fixed;
        inset: 0;
        z-index: 30050;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, .52);
        opacity: 0;
        transition: opacity .18s ease;
    }
    .kc-site-popup-overlay.is-open {
        display: flex;
        opacity: 1;
    }
    .kc-site-popup {
        position: relative;
        width: min(100%, 520px);
        padding: 28px;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        background: #fff;
        color: #111827;
        box-shadow: 0 24px 70px rgba(15,23,42,.22);
        transform: translateY(8px) scale(.985);
        transition: transform .2s cubic-bezier(.2,.8,.2,1);
    }
    .kc-site-popup-overlay.is-open .kc-site-popup { transform: translateY(0) scale(1); }
    .kc-site-popup-close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 34px;
        height: 34px;
        border: 1px solid #e5e7eb;
        border-radius: 50%;
        background: #fff;
        color: #64748b;
        font-size: 21px;
        line-height: 1;
        cursor: pointer;
    }
    .kc-site-popup-icon {
        display: inline-flex;
        width: 48px;
        height: 48px;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        border-radius: 14px;
        background: #fff1f2;
        color: #dc2626;
        font-size: 24px;
    }
    .kc-site-popup-kicker {
        margin-bottom: 4px;
        color: #dc2626;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .12em;
    }
    .kc-site-popup h2 {
        margin: 0 40px 10px 0;
        color: #111827;
        font-size: 1.35rem;
        line-height: 1.3;
    }
    .kc-site-popup-message {
        max-height: 42vh;
        overflow-y: auto;
        color: #475569;
        font-size: .94rem;
        line-height: 1.7;
        white-space: normal;
    }
    .kc-site-popup-actions {
        margin-top: 22px;
    }
    .kc-site-popup-primary {
        width: 100%;
        min-height: 44px;
        border: 1px solid #dc2626;
        border-radius: 10px;
        background: #dc2626;
        color: #fff;
        font: inherit;
        font-size: .88rem;
        font-weight: 750;
        cursor: pointer;
    }
    [data-theme="dark"] .kc-site-popup,
    [data-theme="dark"] .kc-site-popup-close {
        background: #1f1f1f;
        border-color: #353535;
    }
    [data-theme="dark"] .kc-site-popup h2 { color: #f8fafc; }
    [data-theme="dark"] .kc-site-popup-message { color: #cbd5e1; }
    [data-theme="dark"] .kc-site-popup-close { color: #a3a3a3; }
    @media (max-width: 560px) {
        .kc-site-popup-overlay { align-items: flex-end; padding: 10px; }
        .kc-site-popup { padding: 24px 18px 20px; border-radius: 16px; }
        .kc-site-popup-message { max-height: 36vh; }
    }
    @media (prefers-reduced-motion: reduce) {
        .kc-site-popup-overlay, .kc-site-popup { transition-duration: .01ms; }
    }
</style>

<script>
(function () {
    var overlay = document.getElementById('siteAnnouncementOverlay');
    if (!overlay) return;

    var version = overlay.getAttribute('data-popup-version') || 'default';
    var sessionKey = 'kuncheap_site_popup_dismissed_' + version;

    function openPopup() {
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        var close = document.getElementById('siteAnnouncementClose');
        if (close) setTimeout(function () { close.focus(); }, 20);
    }

    function closePopup() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        sessionStorage.setItem(sessionKey, '1');
    }

    var close = document.getElementById('siteAnnouncementClose');
    var ok = document.getElementById('siteAnnouncementOk');

    if (close) close.addEventListener('click', closePopup);
    if (ok) ok.addEventListener('click', closePopup);

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) closePopup();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && overlay.classList.contains('is-open')) closePopup();
    });

    if (sessionStorage.getItem(sessionKey) !== '1') {
        setTimeout(openPopup, 350);
    }
})();
</script>
@endif
