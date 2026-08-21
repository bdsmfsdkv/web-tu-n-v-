@php
    $flashType = null;
    $flashMessage = null;
    foreach (['success', 'error', 'warning', 'info'] as $type) {
        if (session()->has($type)) {
            $flashType = $type;
            $flashMessage = session($type);
            break;
        }
    }
@endphp

@if($flashMessage)
<div id="kcGlobalFlash" class="kc-global-flash kc-global-flash-{{ $flashType }}" role="status" aria-live="polite">
    <div class="kc-global-flash-icon" aria-hidden="true">
        @if($flashType === 'success')
            <span class="iconify" data-icon="ant-design:check-circle-filled"></span>
        @elseif($flashType === 'error')
            <span class="iconify" data-icon="ant-design:close-circle-filled"></span>
        @elseif($flashType === 'warning')
            <span class="iconify" data-icon="ant-design:warning-filled"></span>
        @else
            <span class="iconify" data-icon="ant-design:info-circle-filled"></span>
        @endif
    </div>
    <div class="kc-global-flash-text">{{ $flashMessage }}</div>
    <button type="button" class="kc-global-flash-close" aria-label="Đóng thông báo">×</button>
</div>

<style>
    .kc-global-flash {
        position: fixed;
        top: 78px;
        right: 18px;
        z-index: 30100;
        display: flex;
        width: min(390px, calc(100vw - 28px));
        align-items: flex-start;
        gap: 10px;
        padding: 13px 14px;
        border: 1px solid #dbe3ec;
        border-left-width: 4px;
        border-radius: 12px;
        background: #fff;
        color: #334155;
        box-shadow: 0 14px 34px rgba(15,23,42,.14);
        animation: kcFlashIn .22s cubic-bezier(.2,.8,.2,1);
    }
    .kc-global-flash-success { border-left-color: #16a34a; }
    .kc-global-flash-error { border-left-color: #dc2626; }
    .kc-global-flash-warning { border-left-color: #d97706; }
    .kc-global-flash-info { border-left-color: #2563eb; }
    .kc-global-flash-success .kc-global-flash-icon { color: #16a34a; }
    .kc-global-flash-error .kc-global-flash-icon { color: #dc2626; }
    .kc-global-flash-warning .kc-global-flash-icon { color: #d97706; }
    .kc-global-flash-info .kc-global-flash-icon { color: #2563eb; }
    .kc-global-flash-icon { display:flex; padding-top: 1px; font-size: 20px; }
    .kc-global-flash-text { flex: 1; font-size: .86rem; font-weight: 650; line-height: 1.5; }
    .kc-global-flash-close {
        border: 0;
        background: transparent;
        color: #94a3b8;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
    }
    .kc-global-flash.is-hiding { opacity: 0; transform: translateY(-8px); transition: opacity .18s ease, transform .18s ease; }
    @keyframes kcFlashIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
    [data-theme="dark"] .kc-global-flash { background:#1f1f1f; border-color:#353535; color:#e5e7eb; }
    @media (max-width: 1199px) { .kc-global-flash { top: 66px; right: 12px; } }
</style>

<script>
(function () {
    var flash = document.getElementById('kcGlobalFlash');
    if (!flash) return;
    var close = flash.querySelector('.kc-global-flash-close');
    function hide() {
        if (!flash || !flash.parentNode) return;
        flash.classList.add('is-hiding');
        setTimeout(function () { if (flash.parentNode) flash.remove(); }, 200);
    }
    if (close) close.addEventListener('click', hide);
    setTimeout(hide, 5000);
})();
</script>
@endif
