<!-- Preloader -->
<div id="pagePreloader" class="kc-preloader">
    <span class="antd-spin"><i></i><i></i><i></i><i></i></span>
</div>

@php
    $navCategories = \App\Models\Category::where('active', 1)->get();
    $navRandomCategories = \App\Models\RandomCategory::where('active', 1)->get();
    $navServices = \App\Models\GameService::where('active', 1)->get();
@endphp

<style>
    /* ===== Header rebuild ===== */
    .kc-preloader {
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(255, 255, 255, .72);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity .3s ease;
    }

    .antd-spin {
        display: inline-block;
        width: 32px;
        height: 32px;
        position: relative;
        animation: antdSpinRotate 1.2s linear infinite;
    }

    .antd-spin i {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--primary, #dc2626);
        opacity: .3;
        animation: antdSpinDot 1s ease-in-out infinite;
    }

    .antd-spin i:nth-child(1) { top: 0; left: 50%; margin-left: -5px; animation-delay: 0s; }
    .antd-spin i:nth-child(2) { right: 0; top: 50%; margin-top: -5px; animation-delay: .4s; }
    .antd-spin i:nth-child(3) { bottom: 0; left: 50%; margin-left: -5px; animation-delay: .8s; }
    .antd-spin i:nth-child(4) { left: 0; top: 50%; margin-top: -5px; animation-delay: 1.2s; }

    @keyframes antdSpinRotate { to { transform: rotate(360deg); } }
    @keyframes antdSpinDot {
        0%, 100% { opacity: .3; transform: scale(.6); }
        50% { opacity: 1; transform: scale(1); }
    }

    .navbar {
        position: fixed !important;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 1000;
        background: rgba(255, 255, 255, .96) !important;
        border-bottom: 1px solid #e5e7eb !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 1px 8px rgba(15, 23, 42, .04);
    }

    [data-theme="dark"] .navbar {
        background: rgba(23, 23, 23, .96) !important;
        border-color: #2a2a2a !important;
    }

    .nav-container {
        width: 100%;
        max-width: 1360px !important;
        height: 64px !important;
        margin: 0 auto;
        padding: 0 20px !important;
        display: grid !important;
        grid-template-columns: auto minmax(0, 1fr) auto;
        align-items: center;
        gap: 18px;
    }

    .nav-brand {
        display: flex !important;
        align-items: center;
        flex-shrink: 0;
        min-width: 58px;
        color: #111827;
        text-decoration: none;
    }

    .nav-brand img {
        display: block;
        height: 34px !important;
        width: auto !important;
        max-width: 135px;
        object-fit: contain;
    }

    .brand-text {
        font-size: 1.2rem;
        font-weight: 800;
        white-space: nowrap;
        color: var(--primary, #dc2626);
    }

    .nav-links {
        display: flex !important;
        align-items: center;
        justify-content: center;
        flex-wrap: nowrap;
        gap: 2px !important;
        min-width: 0;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none;
    }

    .nav-links > li {
        list-style: none;
        flex: 0 0 auto;
    }

    .nav-links .nav-link-item {
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 38px;
        padding: 7px 9px !important;
        border-radius: 8px;
        color: #242424 !important;
        font-size: .84rem !important;
        font-weight: 600 !important;
        line-height: 1;
        white-space: nowrap;
        text-decoration: none !important;
        transition: background .18s ease, color .18s ease;
    }

    .nav-links .nav-link-item:hover,
    .nav-links .nav-link-item.active {
        color: var(--primary, #dc2626) !important;
        background: rgba(220, 38, 38, .07) !important;
    }

    .nav-item-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .95rem;
        color: #555;
    }

    .nav-links .nav-link-item:hover .nav-item-icon,
    .nav-links .nav-link-item.active .nav-item-icon {
        color: var(--primary, #dc2626);
    }

    .nav-arrow {
        margin-left: 1px;
        font-size: .62rem;
        color: #888;
        transition: transform .18s ease;
    }

    .nav-dropdown:hover > .nav-link-item .nav-arrow,
    .nav-mega-dropdown:hover > .nav-link-item .nav-arrow {
        transform: rotate(180deg);
    }

    .nav-badge-hot {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 2px 5px;
        border-radius: 999px;
        background: #ecfdf5;
        color: #059669;
        font-size: .6rem;
        font-weight: 800;
        line-height: 1;
    }

    [data-theme="dark"] .nav-links .nav-link-item { color: #e5e7eb !important; }
    [data-theme="dark"] .nav-item-icon { color: #a3a3a3; }
    [data-theme="dark"] .nav-links .nav-link-item:hover,
    [data-theme="dark"] .nav-links .nav-link-item.active { background: rgba(248, 113, 113, .1) !important; }

    /* Mobile-only elements MUST stay hidden on desktop */
    .nav-offcanvas-header,
    .mobile-auth-banner {
        display: none !important;
    }

    /* Deposit dropdown */
    .nav-dropdown { position: relative; }

    .modern-dropdown-menu {
        display: none !important;
        position: absolute !important;
        top: calc(100% + 8px) !important;
        left: 0 !important;
        width: 292px;
        min-width: 292px !important;
        margin: 0 !important;
        padding: 8px !important;
        list-style: none;
        background: #fff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        box-shadow: 0 14px 36px rgba(15, 23, 42, .14) !important;
        z-index: 1100;
    }

    .nav-dropdown:hover > .modern-dropdown-menu { display: block !important; }

    .dropdown-link-card {
        display: flex !important;
        align-items: center;
        gap: 11px;
        padding: 10px !important;
        border-radius: 9px !important;
        color: #1f2937 !important;
        text-decoration: none !important;
    }

    .dropdown-link-card:hover { background: #f8fafc !important; }

    .dropdown-link-icon-box {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .bg-card-icon { background: #fef2f2; color: #dc2626; }
    .bg-atm-icon { background: #eff6ff; color: #2563eb; }
    .bg-usdt-icon { background: #ecfdf5; color: #059669; }
    .dropdown-link-title { font-size: .84rem; font-weight: 700; color: #111827; }
    .dropdown-link-desc { margin-top: 2px; font-size: .7rem; color: #6b7280; }

    [data-theme="dark"] .modern-dropdown-menu {
        background: #1b1b1b !important;
        border-color: #303030 !important;
    }
    [data-theme="dark"] .dropdown-link-card:hover { background: #252525 !important; }
    [data-theme="dark"] .dropdown-link-title { color: #f3f4f6; }
    [data-theme="dark"] .dropdown-link-desc { color: #9ca3af; }

    /* Categories mega menu */
    .nav-mega-dropdown { position: static !important; }

    .mega-menu {
        display: none !important;
        position: absolute !important;
        top: 64px !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        padding: 18px 0 22px !important;
        background: rgba(255, 255, 255, .99) !important;
        border-top: 1px solid #f1f5f9 !important;
        border-bottom: 1px solid #e5e7eb !important;
        box-shadow: 0 18px 35px rgba(15, 23, 42, .10) !important;
        z-index: 1050;
    }

    .nav-mega-dropdown:hover > .mega-menu { display: block !important; }

    .mega-menu-container {
        width: 100%;
        max-width: 1260px !important;
        margin: 0 auto;
        padding: 0 20px !important;
    }

    .mega-menu-grid {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 16px !important;
    }

    .mega-menu-column {
        min-width: 0;
        padding: 14px !important;
        background: #f8fafc !important;
        border: 1px solid #eef2f7 !important;
        border-radius: 12px !important;
    }

    .mega-menu-col-header {
        display: flex !important;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px !important;
        padding-bottom: 9px !important;
        border-bottom: 1px solid #e5e7eb !important;
    }

    .mega-col-icon {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
    }

    .mega-col-title { font-size: .84rem; font-weight: 800; color: #111827; }
    .mega-col-count {
        margin-left: auto;
        padding: 2px 7px;
        border-radius: 999px;
        background: #e5e7eb;
        color: #4b5563;
        font-size: .68rem;
        font-weight: 700;
    }

    .mega-menu-list {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 6px !important;
        max-height: 280px !important;
        overflow-y: auto;
    }

    .mega-menu-item {
        display: flex !important;
        align-items: center;
        gap: 8px;
        min-width: 0;
        padding: 7px 8px !important;
        border: 1px solid #edf0f4 !important;
        border-radius: 8px !important;
        background: #fff !important;
        color: #374151 !important;
        text-decoration: none !important;
        font-size: .78rem !important;
        font-weight: 600;
    }

    .mega-menu-item:hover {
        color: var(--primary, #dc2626) !important;
        border-color: rgba(220, 38, 38, .28) !important;
        background: #fff !important;
    }

    .mega-menu-icon,
    .mega-menu-icon-fallback {
        width: 25px !important;
        height: 25px !important;
        flex: 0 0 25px;
        border-radius: 6px;
        object-fit: cover;
    }

    .mega-menu-icon-fallback {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2f7;
        color: #94a3b8;
    }

    .mega-item-info { min-width: 0; }
    .mega-item-name {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .mega-empty {
        grid-column: 1 / -1;
        padding: 12px;
        text-align: center;
        color: #94a3b8;
        font-size: .78rem;
    }

    [data-theme="dark"] .mega-menu {
        background: rgba(23, 23, 23, .99) !important;
        border-color: #2a2a2a !important;
    }
    [data-theme="dark"] .mega-menu-column { background: #1d1d1d !important; border-color: #2d2d2d !important; }
    [data-theme="dark"] .mega-menu-col-header { border-color: #303030 !important; }
    [data-theme="dark"] .mega-col-title { color: #f3f4f6; }
    [data-theme="dark"] .mega-col-count { background: #303030; color: #a3a3a3; }
    [data-theme="dark"] .mega-menu-item { background: #222 !important; border-color: #303030 !important; color: #d1d5db !important; }

    /* Right side */
    .nav-user {
        display: flex !important;
        align-items: center;
        justify-content: flex-end;
        gap: 8px !important;
        flex-shrink: 0;
        min-width: 0;
    }

    .ant-header-lang-dropdown { flex-shrink: 0; }
    .ant-header-lang-trigger {
        height: 34px !important;
        padding: 5px 8px !important;
        border-radius: 9px !important;
    }

    .theme-toggle {
        width: 34px !important;
        height: 34px !important;
        flex: 0 0 34px;
    }

    .nav-guest-actions {
        display: flex !important;
        align-items: center;
        gap: 7px;
        flex-shrink: 0;
    }

    .btn-nav-login,
    .btn-nav-register {
        height: 34px;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 0 11px;
        border-radius: 8px;
        font-size: .8rem;
        font-weight: 700;
        white-space: nowrap;
        text-decoration: none !important;
        transition: all .18s ease;
    }

    .btn-nav-login {
        color: var(--primary, #dc2626) !important;
        background: transparent;
        border: 1px solid rgba(220, 38, 38, .28);
    }

    .btn-nav-login:hover { background: rgba(220, 38, 38, .06); }

    .btn-nav-register {
        color: #fff !important;
        background: var(--primary, #dc2626);
        border: 1px solid var(--primary, #dc2626);
    }

    .btn-nav-register:hover { filter: brightness(.94); color: #fff !important; }

    .nav-avatar-wrapper { position: relative; flex-shrink: 0; }
    .nav-user-profile { display: flex !important; align-items: center; gap: 7px; }
    .nav-user-info { max-width: 115px; }
    .nav-username { font-size: .78rem; }
    .nav-user-balance { font-size: .72rem; }

    /* Keep avatar dropdown above the header */
    .avatar-dropdown {
        right: 0 !important;
        z-index: 1200 !important;
    }

    .nav-toggle {
        display: none !important;
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
    }

    .nav-overlay { z-index: 9998 !important; }

    /* Compact desktop so 1025-1250px never breaks into two rows */
    @media (min-width: 1025px) and (max-width: 1250px) {
        .nav-container { gap: 10px !important; padding: 0 12px !important; }
        .nav-links { gap: 0 !important; }
        .nav-links .nav-link-item { padding: 7px 6px !important; font-size: .77rem !important; gap: 4px; }
        .nav-badge-hot { display: none; }
        .ant-header-lang-text,
        .lang-arrow { display: none !important; }
        .ant-header-lang-trigger { width: 34px !important; justify-content: center; padding: 4px !important; }
        .btn-nav-login,
        .btn-nav-register { padding: 0 8px; font-size: .75rem; }
    }

    /* ===== Tablet / mobile drawer ===== */
    @media (max-width: 1024px) {
        .nav-container {
            display: flex !important;
            height: 56px !important;
            padding: 0 14px !important;
            gap: 8px;
        }

        .nav-brand { margin-right: auto; }
        .nav-brand img { height: 30px !important; max-width: 118px; }

        .nav-links {
            display: none !important;
            position: fixed !important;
            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 330px !important;
            max-width: 88vw !important;
            height: 100vh !important;
            z-index: 9999 !important;
            flex-direction: column !important;
            align-items: stretch !important;
            justify-content: flex-start !important;
            gap: 0 !important;
            overflow-y: auto !important;
            background: #fff !important;
            box-shadow: -12px 0 35px rgba(15, 23, 42, .2) !important;
        }

        .nav-links.show { display: flex !important; }

        .nav-links > li {
            width: 100%;
            border-bottom: 1px solid #f1f5f9;
        }

        .nav-links .nav-link-item {
            width: 100%;
            min-height: 46px;
            justify-content: flex-start;
            padding: 12px 16px !important;
            border-radius: 0;
            font-size: .86rem !important;
        }

        .nav-links .nav-link-item .nav-arrow { margin-left: auto; }

        .nav-offcanvas-header {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 13px 14px !important;
            background: #fafafa;
            border-bottom: 1px solid #e5e7eb !important;
        }

        .mobile-drawer-user { display: flex; align-items: center; gap: 9px; min-width: 0; }
        .mobile-drawer-avatar {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--primary, #dc2626);
            color: #fff;
            font-size: .85rem;
            font-weight: 800;
        }
        .mobile-drawer-info { min-width: 0; }
        .mobile-drawer-name { font-size: .84rem; font-weight: 800; color: #111827; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .mobile-drawer-balance { margin-top: 2px; font-size: .72rem; color: var(--primary, #dc2626); font-weight: 700; }

        .nav-close {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #4b5563;
            cursor: pointer;
        }

        .mobile-auth-banner {
            display: block !important;
            padding: 12px 14px !important;
            background: #fff;
        }

        .mobile-auth-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .btn-mobile-login,
        .btn-mobile-reg {
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 38px;
            border-radius: 8px;
            font-size: .8rem;
            font-weight: 800;
            text-decoration: none !important;
        }

        .btn-mobile-login { color: #fff !important; background: var(--primary, #dc2626); }
        .btn-mobile-reg { color: #374151 !important; background: #f3f4f6; border: 1px solid #e5e7eb; }

        .modern-dropdown-menu,
        .mega-menu {
            display: none !important;
            position: static !important;
            width: 100% !important;
            min-width: 100% !important;
            padding: 5px 0 !important;
            margin: 0 !important;
            transform: none !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: #f8fafc !important;
        }

        .nav-dropdown.open > .modern-dropdown-menu,
        .nav-mega-dropdown.open > .mega-menu {
            display: block !important;
        }

        .mega-menu-container { padding: 0 !important; }
        .mega-menu-grid { display: flex !important; flex-direction: column !important; gap: 0 !important; }
        .mega-menu-column {
            padding: 10px 14px !important;
            border: 0 !important;
            border-bottom: 1px dashed #e5e7eb !important;
            border-radius: 0 !important;
            background: transparent !important;
        }
        .mega-menu-list { display: flex !important; flex-direction: column !important; max-height: 220px !important; }
        .mega-menu-item { background: #fff !important; }
        .dropdown-link-card { padding: 9px 16px 9px 22px !important; border-radius: 0 !important; }

        .nav-guest-actions { display: none !important; }

        .nav-user {
            margin-left: auto;
            gap: 6px !important;
        }

        .nav-user-profile .nav-user-info { display: none; }
        .nav-avatar { width: 30px; height: 30px; }

        .nav-toggle {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 7px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: transparent;
        }
        .nav-toggle span { width: 18px; height: 2px; border-radius: 999px; background: #374151; }

        [data-theme="dark"] .nav-links { background: #171717 !important; }
        [data-theme="dark"] .nav-links > li { border-color: #2a2a2a; }
        [data-theme="dark"] .nav-offcanvas-header { background: #141414; border-color: #2a2a2a !important; }
        [data-theme="dark"] .mobile-auth-banner { background: #171717; }
        [data-theme="dark"] .mobile-drawer-name { color: #f3f4f6; }
        [data-theme="dark"] .nav-close { background: #222; border-color: #333; color: #d1d5db; }
        [data-theme="dark"] .btn-mobile-reg { background: #262626; border-color: #333; color: #e5e7eb !important; }
        [data-theme="dark"] .modern-dropdown-menu,
        [data-theme="dark"] .mega-menu { background: #111 !important; }
        [data-theme="dark"] .nav-toggle { border-color: #333; }
        [data-theme="dark"] .nav-toggle span { background: #e5e7eb; }
    }

    @media (max-width: 520px) {
        .ant-header-lang-dropdown { display: none !important; }
        .nav-user { gap: 5px !important; }
        .theme-toggle { width: 31px !important; height: 31px !important; flex-basis: 31px; }
    }
</style>

<nav class="navbar">
    <div class="nav-container">
        <a href="/" class="nav-brand" aria-label="Trang chủ">
            @if(config_get('site_logo'))
                <img src="{{ asset(config_get('site_logo')) }}" alt="{{ config_get('site_name') }}">
            @else
                <span class="brand-text">{{ config_get('site_name', 'ShopGame') }}</span>
            @endif
        </a>

        <ul class="nav-links" id="navLinks">
            <li class="nav-offcanvas-header">
                @if(Auth::check())
                    <div class="mobile-drawer-user">
                        <div class="mobile-drawer-avatar">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</div>
                        <div class="mobile-drawer-info">
                            <div class="mobile-drawer-name">{{ Auth::user()->username }}</div>
                            <div class="mobile-drawer-balance">{{ number_format(Auth::user()->balance) }}đ</div>
                        </div>
                    </div>
                @else
                    <a href="/" class="nav-brand">
                        @if(config_get('site_logo'))
                            <img src="{{ asset(config_get('site_logo')) }}" alt="{{ config_get('site_name') }}">
                        @else
                            <span class="brand-text">{{ config_get('site_name', 'ShopGame') }}</span>
                        @endif
                    </a>
                @endif
                <button class="nav-close" id="navClose" onclick="closeNav()" aria-label="Đóng menu">
                    <span class="iconify" data-icon="ant-design:close-outlined"></span>
                </button>
            </li>

            @guest
                <li class="mobile-auth-banner">
                    <div class="mobile-auth-buttons">
                        <a href="{{ route('login') }}" class="btn-mobile-login">
                            <span class="iconify" data-icon="ant-design:login-outlined"></span> Đăng Nhập
                        </a>
                        <a href="{{ route('register') }}" class="btn-mobile-reg">
                            <span class="iconify" data-icon="ant-design:user-add-outlined"></span> Đăng Ký
                        </a>
                    </div>
                </li>
            @endguest

            <li>
                <a href="/" class="nav-link-item {{ request()->is('/') ? 'active' : '' }}">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:home-outlined"></span></span>
                    <span>Trang Chủ</span>
                </a>
            </li>

            <li class="nav-mega-dropdown">
                <a href="javascript:void(0)" class="nav-link-item">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:appstore-outlined"></span></span>
                    <span>Danh Mục</span>
                    <span class="iconify nav-arrow" data-icon="ant-design:down-outlined"></span>
                </a>

                <div class="mega-menu">
                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="mega-menu-column">
                                <div class="mega-menu-col-header">
                                    <span class="mega-col-icon" style="background:rgba(220,38,38,.1);color:#dc2626;"><i class="fa-solid fa-gamepad"></i></span>
                                    <span class="mega-col-title">Tài Khoản Game</span>
                                    <span class="mega-col-count">{{ $navCategories->count() }}</span>
                                </div>
                                <div class="mega-menu-list">
                                    @forelse($navCategories as $cat)
                                        <a href="{{ route('category.index', ['slug' => $cat->slug]) }}" class="mega-menu-item">
                                            @if($cat->thumbnail)
                                                <img src="{{ $cat->thumbnail }}" alt="{{ $cat->name }}" class="mega-menu-icon" loading="lazy">
                                            @else
                                                <span class="mega-menu-icon-fallback"><i class="fa-solid fa-layer-group"></i></span>
                                            @endif
                                            <span class="mega-item-info"><span class="mega-item-name">{{ $cat->name }}</span></span>
                                        </a>
                                    @empty
                                        <div class="mega-empty">Đang cập nhật...</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mega-menu-column">
                                <div class="mega-menu-col-header">
                                    <span class="mega-col-icon" style="background:rgba(245,158,11,.12);color:#d97706;"><i class="fa-solid fa-dice"></i></span>
                                    <span class="mega-col-title">Thử Vận May</span>
                                    <span class="mega-col-count">{{ $navRandomCategories->count() }}</span>
                                </div>
                                <div class="mega-menu-list">
                                    @forelse($navRandomCategories as $cat)
                                        <a href="{{ route('random.index', ['slug' => $cat->slug]) }}" class="mega-menu-item">
                                            @if($cat->thumbnail)
                                                <img src="{{ $cat->thumbnail }}" alt="{{ $cat->name }}" class="mega-menu-icon" loading="lazy">
                                            @else
                                                <span class="mega-menu-icon-fallback"><i class="fa-solid fa-gift"></i></span>
                                            @endif
                                            <span class="mega-item-info"><span class="mega-item-name">{{ $cat->name }}</span></span>
                                        </a>
                                    @empty
                                        <div class="mega-empty">Đang cập nhật...</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mega-menu-column">
                                <div class="mega-menu-col-header">
                                    <span class="mega-col-icon" style="background:rgba(16,185,129,.12);color:#059669;"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
                                    <span class="mega-col-title">Dịch Vụ Game</span>
                                    <span class="mega-col-count">{{ $navServices->count() }}</span>
                                </div>
                                <div class="mega-menu-list">
                                    @forelse($navServices as $cat)
                                        <a href="{{ route('service.show', ['slug' => $cat->slug]) }}" class="mega-menu-item">
                                            @if($cat->thumbnail)
                                                <img src="{{ $cat->thumbnail }}" alt="{{ $cat->name }}" class="mega-menu-icon" loading="lazy">
                                            @else
                                                <span class="mega-menu-icon-fallback"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                                            @endif
                                            <span class="mega-item-info"><span class="mega-item-name">{{ $cat->name }}</span></span>
                                        </a>
                                    @empty
                                        <div class="mega-empty">Đang cập nhật...</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li class="nav-dropdown">
                <a href="javascript:void(0)" class="nav-link-item">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:wallet-outlined"></span></span>
                    <span>Nạp Tiền</span>
                    <span class="iconify nav-arrow" data-icon="ant-design:down-outlined"></span>
                </a>
                <ul class="modern-dropdown-menu">
                    <li>
                        <a href="{{ route('profile.deposit-card') }}" class="dropdown-link-card">
                            <span class="dropdown-link-icon-box bg-card-icon"><i class="fa-solid fa-credit-card"></i></span>
                            <span>
                                <span class="dropdown-link-title">Nạp thẻ cào</span>
                                <span class="dropdown-link-desc">Tự động 24/7</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.deposit-atm') }}" class="dropdown-link-card">
                            <span class="dropdown-link-icon-box bg-atm-icon"><i class="fa-solid fa-building-columns"></i></span>
                            <span>
                                <span class="dropdown-link-title">Ngân hàng / QR</span>
                                <span class="dropdown-link-desc">Chuyển khoản nhanh</span>
                            </span>
                        </a>
                    </li>
                    @if(config_get('payment.usdt.active', true))
                        <li>
                            <a href="{{ route('profile.deposit-usdt') }}" class="dropdown-link-card">
                                <span class="dropdown-link-icon-box bg-usdt-icon"><i class="fa-brands fa-bitcoin"></i></span>
                                <span>
                                    <span class="dropdown-link-title">Nạp USDT</span>
                                    <span class="dropdown-link-desc">BEP20 / TRC20</span>
                                </span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            <li>
                <a href="{{ route('profile.transaction-history') }}" class="nav-link-item {{ request()->routeIs('profile.transaction-history') ? 'active' : '' }}">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:history-outlined"></span></span>
                    <span>Lịch Sử</span>
                </a>
            </li>

            <li>
                <a href="{{ route('news.index') }}" class="nav-link-item {{ request()->is('tin-tuc*') ? 'active' : '' }}">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:read-outlined"></span></span>
                    <span>Tin Tức</span>
                </a>
            </li>

            <li>
                <a href="{{ route('profile.affiliate') }}" class="nav-link-item {{ request()->routeIs('profile.affiliate') ? 'active' : '' }}">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:share-alt-outlined"></span></span>
                    <span>Tiếp Thị</span>
                    <span class="nav-badge-hot">Kiếm tiền</span>
                </a>
            </li>
        </ul>

        <div class="nav-user">
            <div class="ant-header-lang-dropdown" style="position:relative;">
                <div class="ant-header-lang-trigger">
                    <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/vn.svg" id="currentLangFlag" alt="VI" style="width:18px;height:14px;object-fit:cover;">
                    <span class="ant-header-lang-text" id="currentLangText">VI</span>
                    <span class="iconify lang-arrow" data-icon="ant-design:down-outlined"></span>
                </div>
                <div class="ant-dropdown-menu" id="langDropdownMenu">
                    <div class="ant-dropdown-item" onclick="setLanguage('vi')"><img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/vn.svg" alt="VN"><span>Tiếng Việt</span></div>
                    <div class="ant-dropdown-item" onclick="setLanguage('en')"><img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/us.svg" alt="EN"><span>English</span></div>
                    <div class="ant-dropdown-item" onclick="setLanguage('zh-CN')"><img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/cn.svg" alt="ZH"><span>简体中文</span></div>
                    <div class="ant-dropdown-item" onclick="setLanguage('ko')"><img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/kr.svg" alt="KO"><span>한국어</span></div>
                    <div class="ant-dropdown-item" onclick="setLanguage('ja')"><img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/jp.svg" alt="JA"><span>日本語</span></div>
                </div>
            </div>

            <button class="theme-toggle" id="themeToggle" title="Chuyển giao diện" aria-label="Chuyển giao diện">
                <span class="icon-sun"><span class="iconify" data-icon="ant-design:sun-outlined"></span></span>
                <span class="icon-moon"><span class="iconify" data-icon="ant-design:moon-outlined"></span></span>
            </button>

            @if(Auth::check())
                <div class="nav-avatar-wrapper" id="avatarWrapper">
                    <div class="nav-user-profile" onclick="toggleAvatarMenu()" title="{{ Auth::user()->username }}">
                        <div class="nav-user-info">
                            <div class="nav-username">{{ Auth::user()->username }}</div>
                            <div class="nav-user-balance">{{ number_format(Auth::user()->balance) }}đ</div>
                        </div>
                        <button type="button" class="nav-avatar" id="avatarBtn" aria-label="Tài khoản">
                            {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                        </button>
                    </div>

                    <div class="avatar-dropdown" id="avatarDropdown">
                        <div class="dropdown-user-card">
                            <div class="dropdown-user-header">
                                <div class="dropdown-user-avatar">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</div>
                                <div class="dropdown-user-meta">
                                    <div class="dropdown-name">{{ Auth::user()->username }}</div>
                                    <div class="dropdown-email">{{ Auth::user()->email ?? 'Thành viên' }}</div>
                                </div>
                            </div>
                            <div class="dropdown-balance-box">
                                <div class="dropdown-balance-label">Số dư hiện tại</div>
                                <div class="dropdown-balance-val">{{ number_format(Auth::user()->balance) }} <span class="dropdown-balance-cur">đ</span></div>
                                <a href="{{ route('profile.deposit-card') }}" class="dropdown-btn-deposit"><i class="fa-solid fa-plus"></i> Nạp Ngay</a>
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>
                        <div class="dropdown-menu-links">
                            <a href="/profile" class="dropdown-item"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:user-outlined"></span></span><span>Thông Tin Tài Khoản</span></a>
                            <a href="{{ route('profile.deposit-card') }}" class="dropdown-item"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:wallet-outlined"></span></span><span>Nạp Tiền Vào Ví</span></a>
                            <a href="{{ route('profile.transaction-history') }}" class="dropdown-item"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:history-outlined"></span></span><span>Lịch Sử Giao Dịch</span></a>
                            <a href="{{ route('profile.purchased-accounts') }}" class="dropdown-item"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:shopping-bag-outlined"></span></span><span>Tài Khoản Đã Mua</span></a>
                            <a href="{{ route('profile.affiliate') }}" class="dropdown-item"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:share-alt-outlined"></span></span><span>Tiếp Thị Liên Kết</span></a>
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.index') }}" class="dropdown-item dropdown-admin"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:dashboard-outlined"></span></span><span>Quản Trị Admin</span></a>
                            @endif
                        </div>

                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="display:block;margin:0;padding:4px 8px;">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-logout" style="width:100%;border:none;background:transparent;cursor:pointer;">
                                <span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:logout-outlined"></span></span>
                                <span>Đăng Xuất</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="nav-guest-actions">
                    <a href="{{ route('login') }}" class="btn-nav-login">
                        <span class="iconify" data-icon="ant-design:login-outlined"></span>
                        <span>Đăng Nhập</span>
                    </a>
                    <a href="{{ route('register') }}" class="btn-nav-register">
                        <span class="iconify" data-icon="ant-design:user-add-outlined"></span>
                        <span>Đăng Ký</span>
                    </a>
                </div>
            @endif

            <button class="nav-toggle" id="navToggle" aria-label="Mở menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<div class="nav-overlay" id="navOverlay"></div>
