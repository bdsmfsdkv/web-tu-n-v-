
    <!-- Preloader -->
    <div id="pagePreloader" style="position:fixed;inset:0;z-index:99999;background:rgba(255,255,255,0.7);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;transition:opacity .3s ease;">
      <span class="antd-spin"><i></i><i></i><i></i><i></i></span>
    </div>
    <style>
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

      .antd-spin i:nth-child(1) {
        top: 0;
        left: 50%;
        margin-left: -5px;
        animation-delay: 0s;
      }

      .antd-spin i:nth-child(2) {
        right: 0;
        top: 50%;
        margin-top: -5px;
        animation-delay: .4s;
      }

      .antd-spin i:nth-child(3) {
        bottom: 0;
        left: 50%;
        margin-left: -5px;
        animation-delay: .8s;
      }

      .antd-spin i:nth-child(4) {
        left: 0;
        top: 50%;
        margin-top: -5px;
        animation-delay: 1.2s;
      }

      @keyframes antdSpinRotate {
        to {
          transform: rotate(360deg);
        }
      }

      @keyframes antdSpinDot {
        0%,
        100% {
          opacity: .3;
          transform: scale(.6);
        }
        50% {
          opacity: 1;
          transform: scale(1);
        }
      }
    </style>

    @php
        $navCategories = \App\Models\Category::where('active', 1)->get();
        $navRandomCategories = \App\Models\RandomCategory::where('active', 1)->get();
        $navServices = \App\Models\GameService::where('active', 1)->get();
        $totalNavCategories = $navCategories->count() + $navRandomCategories->count() + $navServices->count();
    @endphp

<nav class="navbar">
    <div class="nav-container">
        <a href="/" class="nav-brand">
            @if(config_get('site_logo'))
                <img src="{{ asset(config_get('site_logo')) }}" alt="{{ config_get('site_name') }}" width="120" height="32" style="height:32px; width:auto; object-fit:contain;">
            @else
                <span class="brand-text">{{ config_get('site_name', 'ShopGame') }}</span>
            @endif
        </a>

        <ul class="nav-links" id="navLinks">
            <!-- Mobile Offcanvas Header -->
            <li class="nav-offcanvas-header">
                @if(Auth::check())
                <div class="mobile-drawer-user">
                    <div class="mobile-drawer-avatar">
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    </div>
                    <div class="mobile-drawer-info">
                        <div class="mobile-drawer-name">{{ Auth::user()->username }}</div>
                        <div class="mobile-drawer-balance"><i class="fa-solid fa-coins" style="color:#eab308;font-size:0.75rem;margin-right:4px;"></i>{{ number_format(Auth::user()->balance) }}đ</div>
                    </div>
                </div>
                @else
                <a href="/" class="nav-brand">
                    @if(config_get('site_logo'))
                        <img src="{{ asset(config_get('site_logo')) }}" alt="{{ config_get('site_name') }}" width="105" height="28" style="height:28px; width:auto; object-fit:contain;">
                    @else
                        <span class="brand-text">{{ config_get('site_name', 'ShopGame') }}</span>
                    @endif
                </a>
                @endif
                <button class="nav-close" id="navClose" onclick="closeNav()" aria-label="Close mobile menu">
                    <span class="iconify" data-icon="ant-design:close-outlined"></span>
                </button>
            </li>

            <!-- Mobile Auth Banner for Guests -->
            @guest
            <li class="mobile-auth-banner">
                <div class="mobile-auth-buttons">
                    <a href="{{ route('login') }}" class="btn-mobile-login"><span class="iconify" data-icon="ant-design:login-outlined"></span> Đăng Nhập</a>
                    <a href="{{ route('register') }}" class="btn-mobile-reg"><span class="iconify" data-icon="ant-design:user-add-outlined"></span> Đăng Ký</a>
                </div>
            </li>
            @endguest

            <li>
                <a href="/" class="nav-link-item {{ request()->is('/') ? 'active' : '' }}">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:home-outlined"></span></span>
                    <span>Trang Chủ</span>
                </a>
            </li>

            <!-- Mega Menu Danh Mục -->
            <li class="nav-mega-dropdown full-width-dropdown">
                <a href="javascript:void(0)" class="nav-link-item">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:appstore-outlined"></span></span>
                    <span>Danh Mục</span>
                    @if($totalNavCategories > 0)
                        <span class="nav-badge">{{ $totalNavCategories }}</span>
                    @endif
                    <span class="iconify nav-arrow" data-icon="ant-design:down-outlined"></span>
                </a>
                <div class="mega-menu">
                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <!-- Cột 1: Tài Khoản Game -->
                            <div class="mega-menu-column">
                                <div class="mega-menu-col-header">
                                    <span class="mega-col-icon" style="background: rgba(220, 38, 38, 0.1); color: var(--primary, #dc2626);"><i class="fa-solid fa-gamepad"></i></span>
                                    <span class="mega-col-title">Tài Khoản Game</span>
                                    <span class="mega-col-count">{{ $navCategories->count() }}</span>
                                </div>
                                <div class="mega-menu-list">
                                    @forelse($navCategories as $cat)
                                    <a href="{{ route('category.index', ['slug' => $cat->slug]) }}" class="mega-menu-item">
                                        @if($cat->thumbnail)
                                        <img src="{{ $cat->thumbnail }}" alt="{{ $cat->name }}" class="mega-menu-icon" loading="lazy">
                                        @else
                                        <div class="mega-menu-icon-fallback"><i class="fa-solid fa-layer-group"></i></div>
                                        @endif
                                        <div class="mega-item-info">
                                            <span class="mega-item-name">{{ $cat->name }}</span>
                                        </div>
                                    </a>
                                    @empty
                                    <div class="mega-empty">Đang cập nhật...</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Cột 2: Random Account -->
                            <div class="mega-menu-column">
                                <div class="mega-menu-col-header">
                                    <span class="mega-col-icon" style="background: rgba(234, 179, 8, 0.1); color: #ca8a04;"><i class="fa-solid fa-dice"></i></span>
                                    <span class="mega-col-title">Thử Vận May (Random)</span>
                                    <span class="mega-col-count">{{ $navRandomCategories->count() }}</span>
                                </div>
                                <div class="mega-menu-list">
                                    @forelse($navRandomCategories as $cat)
                                    <a href="{{ route('random.index', ['slug' => $cat->slug]) }}" class="mega-menu-item">
                                        @if($cat->thumbnail)
                                        <img src="{{ $cat->thumbnail }}" alt="{{ $cat->name }}" class="mega-menu-icon" loading="lazy">
                                        @else
                                        <div class="mega-menu-icon-fallback"><i class="fa-solid fa-gift"></i></div>
                                        @endif
                                        <div class="mega-item-info">
                                            <span class="mega-item-name">{{ $cat->name }}</span>
                                        </div>
                                    </a>
                                    @empty
                                    <div class="mega-empty">Đang cập nhật...</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Cột 3: Dịch Vụ Game -->
                            <div class="mega-menu-column">
                                <div class="mega-menu-col-header">
                                    <span class="mega-col-icon" style="background: rgba(16, 185, 129, 0.1); color: #059669;"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
                                    <span class="mega-col-title">Dịch Vụ Game</span>
                                    <span class="mega-col-count">{{ $navServices->count() }}</span>
                                </div>
                                <div class="mega-menu-list">
                                    @forelse($navServices as $cat)
                                    <a href="{{ route('service.show', ['slug' => $cat->slug]) }}" class="mega-menu-item">
                                        @if($cat->thumbnail)
                                        <img src="{{ $cat->thumbnail }}" alt="{{ $cat->name }}" class="mega-menu-icon" loading="lazy">
                                        @else
                                        <div class="mega-menu-icon-fallback"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                                        @endif
                                        <div class="mega-item-info">
                                            <span class="mega-item-name">{{ $cat->name }}</span>
                                        </div>
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

            <!-- Dropdown Nạp Tiền -->
            <li class="nav-dropdown">
                <a href="javascript:void(0)" class="nav-link-item">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:wallet-outlined"></span></span>
                    <span>Nạp Tiền</span>
                    <span class="nav-badge nav-badge-pulse">Bonus</span>
                    <span class="iconify nav-arrow" data-icon="ant-design:down-outlined"></span>
                </a>
                <ul class="nav-dropdown-menu modern-dropdown-menu">
                    <li>
                        <a href="{{ route('profile.deposit-card') }}" class="dropdown-link-card">
                            <div class="dropdown-link-icon-box bg-card-icon">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <div class="dropdown-link-text">
                                <div class="dropdown-link-title">Nạp thẻ cào</div>
                                <div class="dropdown-link-desc">Tự động 24/7, chiết khấu tốt</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.deposit-atm') }}" class="dropdown-link-card">
                            <div class="dropdown-link-icon-box bg-atm-icon">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div class="dropdown-link-text">
                                <div class="dropdown-link-title">Nạp ngân hàng / QR</div>
                                <div class="dropdown-link-desc">Cộng tiền tức thì qua VietQR</div>
                            </div>
                        </a>
                    </li>
                    @if (config_get('payment.usdt.active', true))
                    <li>
                        <a href="{{ route('profile.deposit-usdt') }}" class="dropdown-link-card">
                            <div class="dropdown-link-icon-box bg-usdt-icon">
                                <i class="fa-brands fa-bitcoin"></i>
                            </div>
                            <div class="dropdown-link-text">
                                <div class="dropdown-link-title">Nạp USDT (Crypto)</div>
                                <div class="dropdown-link-desc">BEP20 / TRC20 tỷ giá ưu đãi</div>
                            </div>
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
                <a href="{{ route('profile.affiliate') }}" class="nav-link-item affiliate-highlight {{ request()->routeIs('profile.affiliate') ? 'active' : '' }}">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:share-alt-outlined"></span></span>
                    <span>Tiếp Thị</span>
                    <span class="nav-badge nav-badge-hot">Kiếm tiền</span>
                </a>
            </li>

            <!-- Mobile Drawer Footer Contact -->
            <li class="mobile-drawer-footer">
                <div class="mobile-drawer-footer-title">Hỗ trợ khách hàng</div>
                <div class="mobile-drawer-contacts">
                    @if(config_get('phone'))
                    <a href="tel:{{ config_get('phone') }}" class="mobile-contact-item"><i class="fa-solid fa-phone"></i> {{ config_get('phone') }}</a>
                    @endif
                    @if(config_get('zalo'))
                    <a href="https://zalo.me/{{ config_get('zalo') }}" target="_blank" rel="noopener noreferrer" class="mobile-contact-item"><i class="fa-solid fa-comment-dots"></i> Zalo Hỗ Trợ</a>
                    @endif
                </div>
            </li>
        </ul>

        <div class="nav-user">
            <!-- Premium Language Switcher Dropdown -->
            <div class="ant-header-lang-dropdown mr-2" style="position: relative;">
                <div class="ant-header-lang-trigger">
                    <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/vn.svg" id="currentLangFlag" alt="Flag">
                    <span class="ant-header-lang-text" id="currentLangText">VI</span>
                    <span class="iconify lang-arrow" data-icon="ant-design:down-outlined"></span>
                </div>
                <div class="ant-dropdown-menu" id="langDropdownMenu">
                    <div class="ant-dropdown-item" onclick="setLanguage('vi')">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/vn.svg" alt="VN">
                        <span>Tiếng Việt</span>
                    </div>
                    <div class="ant-dropdown-item" onclick="setLanguage('en')">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/us.svg" alt="EN">
                        <span>English</span>
                    </div>
                    <div class="ant-dropdown-item" onclick="setLanguage('zh-CN')">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/cn.svg" alt="ZH">
                        <span>简体中文</span>
                    </div>
                    <div class="ant-dropdown-item" onclick="setLanguage('ko')">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/kr.svg" alt="KO">
                        <span>한국어</span>
                    </div>
                    <div class="ant-dropdown-item" onclick="setLanguage('ja')">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/jp.svg" alt="JA">
                        <span>日本語</span>
                    </div>
                </div>
            </div>

            <!-- Dark / Light Theme Toggle -->
            <button class="theme-toggle" id="themeToggle" title="Chuyển giao diện" aria-label="Toggle dark mode">
                <span class="icon-sun"><span class="iconify" data-icon="ant-design:sun-outlined"></span></span>
                <span class="icon-moon"><span class="iconify" data-icon="ant-design:moon-outlined"></span></span>
            </button>

            @if(Auth::check())
            <!-- Logged In User Pill & Popover -->
            <div class="nav-avatar-wrapper" id="avatarWrapper">
                <div class="nav-user-profile" onclick="toggleAvatarMenu()" title="{{ Auth::user()->username }}">
                    <div class="nav-user-info">
                        <div class="nav-username">{{ Auth::user()->username }}</div>
                        <div class="nav-user-balance" title="{{ number_format(Auth::user()->balance) }}đ">
                            <i class="fa-solid fa-wallet" style="font-size:0.75rem;margin-right:2px;color:var(--primary);"></i>{{ number_format(Auth::user()->balance) }}đ
                        </div>
                    </div>
                    <button class="nav-avatar" id="avatarBtn" aria-label="User menu">
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                        <span class="avatar-status-badge"></span>
                    </button>
                </div>
                <div class="avatar-dropdown" id="avatarDropdown">
                    <div class="dropdown-user-card">
                        <div class="dropdown-user-header">
                            <div class="dropdown-user-avatar">
                                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                            </div>
                            <div class="dropdown-user-meta">
                                <div class="dropdown-name">{{ Auth::user()->username }}</div>
                                <div class="dropdown-email">{{ Auth::user()->email ?? 'Thành viên' }}</div>
                            </div>
                        </div>
                        <div class="dropdown-balance-box">
                            <div class="dropdown-balance-label">Số dư hiện tại</div>
                            <div class="dropdown-balance-val">{{ number_format(Auth::user()->balance) }} <span class="dropdown-balance-cur">đ</span></div>
                            <a href="{{ route('profile.deposit-card') }}" class="dropdown-btn-deposit">
                                <i class="fa-solid fa-plus"></i> Nạp Ngay
                            </a>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-menu-links">
                        <a href="/profile" class="dropdown-item">
                            <span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:user-outlined"></span></span>
                            <span>Thông Tin Tài Khoản</span>
                        </a>
                        <a href="{{ route('profile.deposit-card') }}" class="dropdown-item">
                            <span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:wallet-outlined"></span></span>
                            <span>Nạp Tiền Vào Ví</span>
                        </a>
                        <a href="{{ route('profile.transaction-history') }}" class="dropdown-item">
                            <span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:history-outlined"></span></span>
                            <span>Lịch Sử Giao Dịch</span>
                        </a>
                        <a href="{{ route('profile.purchased-accounts') }}" class="dropdown-item">
                            <span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:shopping-bag-outlined"></span></span>
                            <span>Tài Khoản Đã Mua</span>
                        </a>
                        <a href="{{ route('profile.affiliate') }}" class="dropdown-item">
                            <span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:share-alt-outlined"></span></span>
                            <span>Tiếp Thị Liên Kết</span>
                        </a>
                        @if (Auth::user()->role == 'admin')
                        <a href="{{ route('admin.index') }}" class="dropdown-item dropdown-admin">
                            <span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:dashboard-outlined"></span></span>
                            <span>Quản Trị Admin</span>
                        </a>
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
            <!-- Guest Login Action Button -->
            <div class="nav-guest-actions">
                <a href="{{ route('login') }}" class="btn-nav-login">
                    <span class="iconify" data-icon="ant-design:login-outlined"></span>
                    <span>Đăng Nhập</span>
                </a>
            </div>
            @endif

            <!-- Mobile Hamburger Toggle -->
            <button class="nav-toggle" id="navToggle" aria-label="Toggle Navigation">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>
<div class="nav-overlay" id="navOverlay"></div>
