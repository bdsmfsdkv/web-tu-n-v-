@php
    $navData = cache()->remember('header_nav_data_v3', 3600, function() {
        return [
            'categories' => \App\Models\GameCategory::where('active', true)->select('id', 'name', 'slug', 'thumbnail', 'updated_at')->orderBy('id', 'ASC')->get(),
            'randomCategories' => \App\Models\RandomCategory::where('active', true)->select('id', 'name', 'slug', 'thumbnail', 'updated_at')->orderBy('id', 'ASC')->get(),
            'luckyWheels' => \App\Models\LuckyWheel::where('active', true)->select('id', 'name', 'slug', 'thumbnail')->orderByDesc('updated_at')->get(),
            'services' => \App\Models\GameService::where('active', true)->select('id', 'name', 'slug', 'thumbnail')->get(),
        ];
    });
    $navCategories = $navData['categories'];
    $navRandomCategories = $navData['randomCategories'];
    $navLuckyWheels = $navData['luckyWheels'];
    $navServices = $navData['services'];
@endphp

<nav class="navbar">
    <div class="nav-container">
        <a href="/" class="nav-brand" aria-label="Trang chủ">
            @if(config_get('site_logo'))
                <img src="{{ asset(config_get('site_logo')) }}" alt="{{ config_get('site_name') }}" style="height:40px; width:auto; object-fit:contain;">
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
                            <div class="mobile-drawer-balance"><span data-user-balance>{{ number_format(Auth::user()->balance) }}</span>đ</div>
                        </div>
                    </div>
                @else
                    <a href="/" class="nav-brand">
                        @if(config_get('site_logo'))
                            <img src="{{ asset(config_get('site_logo')) }}" alt="{{ config_get('site_name') }}" style="height:40px; width:auto; object-fit:contain;">
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
                <button type="button" class="nav-link-item nav-menu-trigger {{ request()->routeIs('category.*', 'account.*', 'random.*', 'lucky.*', 'service.*') ? 'active' : '' }}" aria-expanded="false">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:appstore-outlined"></span></span>
                    <span>Danh Mục</span>
                    <span class="iconify nav-arrow" data-icon="ant-design:down-outlined"></span>
                </button>

                <div class="mega-menu">
                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="mega-menu-column">
                                <div class="mega-menu-col-header">
                                    <span class="mega-col-icon" style="background:var(--menu-accent-bg);color:var(--menu-accent);"><i class="fa-solid fa-gamepad"></i></span>
                                    <span class="mega-col-title">Tài Khoản Game</span>
                                    <span class="mega-col-count">{{ $navCategories->count() }}</span>
                                </div>
                                <div class="mega-menu-list">
                                    @forelse($navCategories as $cat)
                                        <a href="{{ route('category.index', ['slug' => $cat->slug]) }}" class="mega-menu-item">
                                            @if($cat->thumbnail)
                                                <img src="{{ asset($cat->thumbnail) }}?v={{ $cat->updated_at->timestamp }}" alt="{{ $cat->name }}" class="mega-menu-icon" loading="lazy" decoding="async" width="25" height="25">
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
                                    <span class="mega-col-count">{{ $navLuckyWheels->count() + $navRandomCategories->count() }}</span>
                                </div>
                                <div class="mega-menu-list">
                                    @foreach($navLuckyWheels as $wheel)
                                        <a href="{{ route('lucky.index', ['slug' => $wheel->slug]) }}" class="mega-menu-item">
                                            @if($wheel->thumbnail)
                                                <img src="{{ $wheel->thumbnail }}" alt="{{ $wheel->name }}" class="mega-menu-icon" loading="lazy" decoding="async" width="25" height="25">
                                            @else
                                                <span class="mega-menu-icon-fallback"><i class="fa-solid fa-gift"></i></span>
                                            @endif
                                            <span class="mega-item-info"><span class="mega-item-name">{{ $wheel->name }}</span></span>
                                        </a>
                                    @endforeach
                                    @foreach($navRandomCategories as $cat)
                                        <a href="{{ route('random.index', ['slug' => $cat->slug]) }}" class="mega-menu-item">
                                            @if($cat->thumbnail)
                                                <img src="{{ asset($cat->thumbnail) }}?v={{ $cat->updated_at->timestamp }}" alt="{{ $cat->name }}" class="mega-menu-icon" loading="lazy" decoding="async" width="25" height="25">
                                            @else
                                                <span class="mega-menu-icon-fallback"><i class="fa-solid fa-shuffle"></i></span>
                                            @endif
                                            <span class="mega-item-info"><span class="mega-item-name">{{ $cat->name }}</span></span>
                                        </a>
                                    @endforeach
                                    @if($navLuckyWheels->isEmpty() && $navRandomCategories->isEmpty())
                                        <div class="mega-empty">Đang cập nhật...</div>
                                    @endif
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
                                                <img src="{{ $cat->thumbnail }}" alt="{{ $cat->name }}" class="mega-menu-icon" loading="lazy" decoding="async" width="25" height="25">
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

            <li class="nav-mega-dropdown">
                <button type="button" class="nav-link-item nav-menu-trigger {{ request()->routeIs('profile.deposit-*') ? 'active' : '' }}" aria-expanded="false">
                    <span class="nav-item-icon"><span class="iconify" data-icon="ant-design:wallet-outlined"></span></span>
                    <span>Nạp Tiền</span>
                    <span class="iconify nav-arrow" data-icon="ant-design:down-outlined"></span>
                </button>
                <div class="mega-menu deposit-mega-menu">
                    <div class="mega-menu-container">
                        <div class="deposit-menu-grid">
                            <a href="{{ route('profile.deposit-card') }}" class="mega-menu-item"><span class="mega-menu-icon-fallback" style="background:#fef2f2;color:#dc2626;"><i class="fa-solid fa-credit-card"></i></span><span class="mega-item-info"><span class="mega-item-name">Nạp thẻ cào</span></span></a>
                            <a href="{{ route('profile.deposit-atm') }}" class="mega-menu-item"><span class="mega-menu-icon-fallback" style="background:#eff6ff;color:#2563eb;"><i class="fa-solid fa-building-columns"></i></span><span class="mega-item-info"><span class="mega-item-name">Ngân hàng / QR</span></span></a>
                            @if (config_get('payment.usdt.active', true))
                                <a href="{{ route('profile.deposit-usdt') }}" class="mega-menu-item"><span class="mega-menu-icon-fallback" style="background:#fef3c7;color:#d97706;"><i class="fa-solid fa-coins"></i></span><span class="mega-item-info"><span class="mega-item-name">Nạp USDT</span></span></a>
                            @endif
                        </div>
                    </div>
                </div>
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
                            <div class="nav-user-balance"><span data-user-balance>{{ number_format(Auth::user()->balance) }}</span>đ</div>
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
                                <div class="dropdown-balance-val"><span data-user-balance>{{ number_format(Auth::user()->balance) }}</span> <span class="dropdown-balance-cur">đ</span></div>
                                <a href="{{ route('profile.deposit-card') }}" class="dropdown-btn-deposit"><i class="fa-solid fa-plus"></i> Nạp Ngay</a>
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>
                        <div class="dropdown-menu-links">
                            <a href="/profile" class="dropdown-item"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:user-outlined"></span></span><span>Thông Tin Tài Khoản</span></a>
                            <a href="{{ route('profile.deposit-card') }}" class="dropdown-item"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:wallet-outlined"></span></span><span>Nạp Tiền Vào Ví</span></a>
                            <a href="{{ route('profile.transaction-history') }}" class="dropdown-item"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:history-outlined"></span></span><span>Lịch Sử Giao Dịch</span></a>
                            <a href="{{ route('profile.purchased-accounts') }}" class="dropdown-item"><span class="dropdown-item-icon"><span class="iconify" data-icon="ant-design:shopping-outlined"></span></span><span>Tài Khoản Đã Mua</span></a>
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
