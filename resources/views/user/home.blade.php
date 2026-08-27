@extends('layouts.user.app')
@section('title', 'Trang chủ')
@section('content')

<!-- Hero Section: 3-7 Split Layout -->
<section class="hero-split">
    <div class="container">
        <div class="hero-grid">
            <!-- Left: Top Nạp Tiền (30%) -->
            <div class="hero-left">
                <div class="top-deposit-panel">
                    <div class="panel-tabs">
                        <button type="button" class="panel-tab active" data-tab="tab-top" onclick="switchTab(this, 'tab-top')">
                            <span class="iconify panel-tab-icon icon-trophy" data-icon="ant-design:trophy-filled"></span> Top Nạp Tiền
                        </button>
                        <button type="button" class="panel-tab" data-tab="tab-reward" onclick="switchTab(this, 'tab-reward')">
                            <span class="iconify panel-tab-icon icon-gift" data-icon="ant-design:gift-filled"></span> Phần Thưởng
                        </button>
                    </div>

                    <!-- Tab 1: Top Nạp Tiền -->
                    <div class="panel-body tab-content active" id="tab-top">
                        @forelse($topDepositors as $depositor)
                            <div class="top-item top-item-rank-{{ $loop->iteration }}">
                                @if($loop->iteration <= 5)
                                    <div class="top-avatar top-avatar-svg">
                                        <img src="https://shopacc68.com/assets/svg/{{ $loop->iteration }}.svg" alt="Top {{ $loop->iteration }}" width="36" height="36" loading="lazy">
                                    </div>
                                @else
                                    <div class="top-avatar top-avatar-num">{{ $loop->iteration }}</div>
                                @endif
                                <div class="top-info">
                                    <div class="top-name">{{ substr($depositor->user->username, 0, 4) }}***</div>
                                </div>
                                <div class="top-amount">{{ number_format($depositor->total_amount) }}đ</div>
                            </div>
                        @empty
                            <div class="top-empty">
                                <i class="fa-solid fa-inbox me-1"></i> Chưa có dữ liệu nạp thẻ tháng này.
                            </div>
                        @endforelse
                    </div>

                    <!-- Tab 2: Phần Thưởng -->
                    <div class="panel-body tab-content" id="tab-reward">
                        <div class="reward-content-render">{!! config_get('top_deposit_reward', '<p>Phần thưởng nạp thẻ đang được cập nhật...</p>') !!}</div>
                    </div>
                    
                    <div class="panel-footer-action">
                        <a href="javascript:void(0)" onclick="document.getElementById('depositMethodModal').style.display='flex'" class="btn-hero-deposit">
                            <i class="fa-solid fa-bolt-lightning"></i> NẠP TIỀN NGAY
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Banner Slider (70%) -->
            <div class="hero-right">
                <div class="banner-slider" id="bannerSlider">
                    <div class="slider-track" id="sliderTrack">
                        @php
                            $banners = json_decode(config_get('site_banner'), true);
                            if (!is_array($banners) && !empty(config_get('site_banner'))) {
                                $banners = [config_get('site_banner')];
                            } elseif (empty($banners)) {
                                $banners = [];
                            }
                        @endphp
                        @if(count($banners) > 0)
                            @foreach($banners as $index => $banner)
                                <div class="slide {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($banner) }}" alt="Banner {{ $index + 1 }}" style="width:100%;height:100%;object-fit:cover;" {{ $index === 0 ? 'fetchpriority=high decoding=async' : 'loading=lazy decoding=async' }}>
                                </div>
                            @endforeach
                        @else
                            <div class="slide active">
                                <img src="https://via.placeholder.com/800x400?text=Shop+Game+Uy+Tin" alt="Shop Game" style="width:100%;height:100%;object-fit:cover;">
                            </div>
                        @endif
                    </div>

                    @if(count($banners) > 1)
                    <button class="slider-arrow slider-prev" id="sliderPrev" aria-label="Previous slide"><span class="iconify" data-icon="ant-design:left-outlined"></span></button>
                    <button class="slider-arrow slider-next" id="sliderNext" aria-label="Next slide"><span class="iconify" data-icon="ant-design:right-outlined"></span></button>
                    <div class="slider-dots">
                        @foreach($banners as $index => $banner)
                            <button class="dot {{ $index == 0 ? 'active' : '' }}" data-index="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Marquee Notifications -->
@php
    $marqueeNotifications = $notifications;
@endphp
@if($marqueeNotifications->count() > 0)
<div class="container">
    <div class="custom-marquee-container">
        <div class="marquee-badge">
            <div class="marquee-icon">
                <i class="fa-solid fa-bullhorn" aria-hidden="true"></i>
            </div>
            <div class="marquee-badge-text">
                <span class="marquee-title">THÔNG BÁO</span>
                <span class="marquee-subtitle">Updates</span>
            </div>
            <span class="marquee-divider" aria-hidden="true"></span>
        </div>

        <div class="marquee-content-wrapper">
            <div class="marquee-track">
                <div class="marquee-item">
                    @foreach($marqueeNotifications as $notif)
                    <div class="marquee-item-inner">
                        <i class="{{ str_starts_with($notif->class_favicon, 'fa-') ? 'fa-solid ' . $notif->class_favicon : $notif->class_favicon }} marquee-item-icon" aria-hidden="true"></i>
                        <span class="marquee-item-text">{{ $notif->content }}</span>
                    </div>
                    @endforeach
                </div>
                <!-- Duplicate for seamless scroll -->
                <div class="marquee-item">
                    @foreach($marqueeNotifications as $notif)
                    <div class="marquee-item-inner">
                        <i class="{{ str_starts_with($notif->class_favicon, 'fa-') ? 'fa-solid ' . $notif->class_favicon : $notif->class_favicon }} marquee-item-icon" aria-hidden="true"></i>
                        <span class="marquee-item-text">{{ $notif->content }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="marquee-fade-left" aria-hidden="true"></div>
            <div class="marquee-fade-right" aria-hidden="true"></div>
        </div>
    </div>
</div>
@endif

<!-- Ticker (Recent Transactions) -->
<div class="container">
    <div class="purchase-ticker">
        <div class="ticker-live-badge">
            <span class="ticker-live-dot"></span>
            <span class="ticker-badge-text-full">GIAO DỊCH GẦN ĐÂY</span>
            <span class="ticker-badge-text-short">Giao dịch</span>
        </div>
        <div class="ticker-track">
            <div class="ticker-content">
                @foreach($recentTransactions as $transaction)
                    <div class="ticker-item">
                        <span class="ticker-icon"><i class="fa-solid fa-circle-check" style="color: #16a34a; font-size: 0.72rem;"></i></span>
                        <span class="ticker-user">{{ substr($transaction->user->username, 0, 3) }}***</span>
                        <span class="ticker-action">
                            @if ($transaction->type == 'deposit')
                                nạp
                            @elseif($transaction->type == 'withdraw')
                                rút
                            @elseif($transaction->type == 'purchase')
                                mua nick
                            @elseif($transaction->type == 'refund')
                                nhận
                            @endif
                        </span>
                        <span class="ticker-price">{{ number_format($transaction->amount) }}đ</span>
                        <span class="ticker-time">({{ $transaction->created_at->diffForHumans(null, true) }})</span>
                    </div>
                @endforeach
                <!-- Duplicate for seamless scroll -->
                @foreach($recentTransactions as $transaction)
                    <div class="ticker-item">
                        <span class="ticker-icon"><i class="fa-solid fa-circle-check" style="color: #16a34a; font-size: 0.72rem;"></i></span>
                        <span class="ticker-user">{{ substr($transaction->user->username, 0, 3) }}***</span>
                        <span class="ticker-action">
                            @if ($transaction->type == 'deposit')
                                nạp
                            @elseif($transaction->type == 'withdraw')
                                rút
                            @elseif($transaction->type == 'purchase')
                                mua nick
                            @elseif($transaction->type == 'refund')
                                nhận
                            @endif
                        </span>
                        <span class="ticker-price">{{ number_format($transaction->amount) }}đ</span>
                        <span class="ticker-time">({{ $transaction->created_at->diffForHumans(null, true) }})</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Flash Sale Section -->
@if((isset($timelineCampaigns) && $timelineCampaigns->count() > 0) || (isset($activeFlashSale) && $activeFlashSale))
<div class="container">
    <div class="flash-sale-wrapper">
        <div class="fs-header">
            <div class="fs-title-box">
                <span class="fs-title-icon"><i class="fa-solid fa-bolt"></i></span>
                <span class="fs-title-text">
                    {{ isset($activeFlashSale) && $activeFlashSale ? mb_strtoupper($activeFlashSale->campaign_name) : 'FLASH SALE GIÁ RẺ' }}
                </span>
            </div>
            <div class="fs-timer-box">
                <span class="iconify fs-clock-icon" data-icon="ant-design:clock-circle-outlined"></span> 
                <span class="fs-timer-label">{{ $activeFlashSale ? 'KẾT THÚC TRONG' : 'BẮT ĐẦU TRONG' }}</span>
                <div class="fs-countdown">
                    <div class="fs-time-box"><span id="fs-days">00</span><small>DAYS</small></div>
                    <div class="fs-time-box"><span id="fs-hours">00</span><small>HRS</small></div>
                    <div class="fs-time-box"><span id="fs-mins">00</span><small>MINS</small></div>
                    <div class="fs-time-box"><span id="fs-secs">00</span><small>SECS</small></div>
                </div>
            </div>
            <a href="{{ route('home') }}" class="fs-view-all">Xem tất cả <i class="fa-solid fa-angle-right ms-1"></i></a>
        </div>
        
        <div class="fs-timeline">
            @php
                $slots = ['1:00', '6:00', '8:00', '12:00', '15:00', '18:00', '20:00', '22:00'];
                $currentHour = (int)date('H');
                $activeIndex = 0;
                foreach($slots as $index => $time) {
                    $slotHour = (int)explode(':', $time)[0];
                    if ($currentHour >= $slotHour) {
                        $activeIndex = $index;
                    }
                }
            @endphp
            @foreach($slots as $index => $time)
                <div class="fs-slot {{ $index < $activeIndex ? 'past' : ($index == $activeIndex ? 'active' : 'future') }}">
                    <div class="fs-time">{{ $time }}</div>
                    <div class="fs-status">
                        {{ $index < $activeIndex ? 'Đã diễn ra' : ($index == $activeIndex ? 'Đang diễn ra 🔥' : 'Sắp diễn ra') }}
                    </div>
                </div>
            @endforeach
        </div>

        @if(isset($flashSales) && count($flashSales) > 0)
            <div class="fs-grid">
                @foreach($flashSales as $fs)
                    <a href="{{ $fs->is_random ? route('random.index', ['slug' => $fs->slug]) : route('category.index', ['slug' => $fs->slug]) }}" class="fs-card">
                        <div class="fs-card-img">
                            <img loading="{{ $loop->iteration <= 5 ? 'eager' : 'lazy' }}" decoding="async" src="{{ asset($fs->thumbnail) }}" onerror="this.src='https://via.placeholder.com/200x120?text=Flash+Sale'" alt="{{ $fs->name }}">
                            @if($fs->flash_sale_old_price > 0 && $fs->flash_sale_new_price > 0 && $fs->flash_sale_old_price > $fs->flash_sale_new_price)
                                @php
                                    $discountPercent = round((($fs->flash_sale_old_price - $fs->flash_sale_new_price) / $fs->flash_sale_old_price) * 100);
                                @endphp
                                <div class="fs-discount-badge">⚡ -{{ $discountPercent }}%</div>
                            @else
                                <div class="fs-discount-badge">⚡ SALE</div>
                            @endif
                        </div>
                        <div class="fs-card-info">
                            <div class="fs-id">MÃ SỐ #{{ $fs->id }}</div>
                            <div class="fs-name-clamp">{{ $fs->name }}</div>
                            <div class="fs-prices">
                                @if($fs->flash_sale_old_price)
                                    <div class="fs-old-price">{{ number_format($fs->flash_sale_old_price) }}đ</div>
                                @endif
                                <div class="fs-new-price">{{ number_format($fs->flash_sale_new_price ?? 0) }}đ</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="fs-empty-box">
                <i class="fa-solid fa-clock-rotate-left fs-empty-icon"></i>
                <p>Chưa đến thời gian Flash Sale. Các sản phẩm giảm giá cực sốc sẽ được hiển thị khi khung giờ bắt đầu!</p>
            </div>
        @endif
    </div>
</div>
@endif

<!-- Game Category Groups -->
@php
    $groupedCategories = [];
    if (isset($gameGroups)) {
        foreach($gameGroups as $gg) {
            $groupedCategories[trim($gg->name)] = collect([]);
        }
    }
    
    foreach($categories as $category) {
        if ($category->gameGroup) {
            $groupName = trim($category->gameGroup->name);
            if (!isset($groupedCategories[$groupName])) {
                $groupedCategories[$groupName] = collect([]);
            }
            $groupedCategories[$groupName]->push($category);
        } else {
            $groupName = $category->platform ? trim($category->platform) : 'Danh Mục Game';
            if (!isset($groupedCategories[$groupName])) {
                $groupedCategories[$groupName] = collect([]);
            }
            $groupedCategories[$groupName]->push($category);
        }
    }
@endphp

@foreach ($groupedCategories as $platform => $group)
    @php 
        $isFirstGroup = $loop->first;
        $matchedGroup = isset($gameGroups) ? $gameGroups->first(fn($g) => trim($g->name) === trim($platform)) : null;
        $groupSlug = $matchedGroup && $matchedGroup->slug ? $matchedGroup->slug : Str::slug($platform);
        $targetGroupUrl = route('category.group', ['slug' => $groupSlug]);
    @endphp
    <section class="section category-section" id="categories-{{ Str::slug($platform) }}">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrap">
                    <span class="section-icon-dot"></span>
                    <h2 class="section-title">{{ $platform }}</h2>
                </div>
                <a href="{{ $targetGroupUrl }}" class="section-view-all-btn">
                    <span>Xem tất cả</span>
                    <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>

            <div class="category-grid">
                @foreach ($group as $category)
                    @php
                        $categoryUrl = ($category instanceof \App\Models\RandomCategory) || (!empty($category->is_random))
                            ? route('random.index', ['slug' => $category->slug])
                            : route('category.index', ['slug' => $category->slug]);
                    @endphp
                    <a href="{{ $categoryUrl }}" class="category-card">
                        @if($category->tag_image)
                        <img loading="{{ $isFirstGroup ? 'eager' : 'lazy' }}" decoding="async" src="{{ asset($category->tag_image) }}?v={{ $category->updated_at->timestamp }}" alt="Tag" class="category-tag-badge">
                        @endif
                        <div class="category-img">
                            @if($category->thumbnail)
                            <img loading="{{ $isFirstGroup ? 'eager' : 'lazy' }}" decoding="async" src="{{ asset($category->thumbnail) }}?v={{ $category->updated_at->timestamp }}" alt="{{ $category->name }}">
                            @else
                            <div class="category-placeholder-icon">
                                <span class="iconify" data-icon="ant-design:appstore-outlined"></span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="category-body">
                            <div class="category-name" title="{{ $category->name }}">{{ $category->name }}</div>
                            <div class="category-count">
                                <span class="badge-stock"><i class="fa-solid fa-box-open me-1"></i> Còn: <strong>{{ number_format($category->allAccount) }}</strong></span>
                                <span class="badge-sold"><i class="fa-solid fa-cart-shopping me-1"></i> Đã bán: <strong>{{ number_format($category->soldCount) }}</strong></span>
                            </div>
                            <div class="category-cta-wrapper">
                                @if(config_get('site_view_all_image'))
                                    <img loading="lazy" decoding="async" src="{{ asset(config_get('site_view_all_image')) }}" alt="Xem ngay" class="category-cta-img">
                                @else
                                    <span class="category-btn-cta">
                                        <span>XEM NGAY</span>
                                        <i class="fa-solid fa-arrow-right cta-icon"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endforeach

<!-- Lucky Wheel -->
@if(isset($LuckWheel) && $LuckWheel->count() > 0)
<section class="section lucky-wheel-section">
    <div class="container">
        <div class="section-header">
            <div class="section-title-wrap">
                <span class="section-icon-dot wheel-dot"></span>
                <h2 class="section-title">Vòng Quay May Mắn</h2>
            </div>
            <a href="{{ route('lucky.show-all') }}" class="section-view-all-btn">
                <span>Xem tất cả</span>
                <i class="fa-solid fa-arrow-right-long"></i>
            </a>
        </div>

        <div class="category-grid">
            @foreach ($LuckWheel as $wheel)
                @if ($wheel->active)
                    <a href="{{ route('lucky.index', ['slug' => $wheel->slug]) }}" class="category-card wheel-card">
                        <div class="category-img">
                            <img loading="lazy" decoding="async" src="{{ asset($wheel->thumbnail) }}?v={{ $wheel->updated_at?->timestamp ?? 1 }}" alt="{{ $wheel->name }}">
                            <div class="wheel-spin-badge"><i class="fa-solid fa-dharmachakra fa-spin-pulse me-1"></i> VÒNG QUAY</div>
                        </div>
                        <div class="category-body">
                            <div class="category-name">{{ $wheel->name }}</div>
                            <div class="category-count">
                                <span class="badge-sold"><i class="fa-solid fa-rotate me-1"></i> Đã quay: <strong>{{ number_format($wheel->soldCount ?? 0) }}</strong></span>
                            </div>
                            <div class="wheel-price-tag">
                                <i class="fa-solid fa-coins me-1"></i> {{ number_format($wheel->price_per_spin) }}đ <small>/ 1 lượt</small>
                            </div>
                            <div class="category-cta-wrapper">
                                @if(config_get('site_view_all_image'))
                                    <img loading="lazy" decoding="async" src="{{ asset(config_get('site_view_all_image')) }}" alt="Quay ngay" class="category-cta-img">
                                @else
                                    <span class="category-btn-cta btn-cta-gold">
                                        <span>QUAY NGAY</span>
                                        <i class="fa-solid fa-arrow-right cta-icon"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Game Services -->
@if(isset($services) && $services->count() > 0)
<section class="section service-section">
    <div class="container">
        <div class="section-header">
            <div class="section-title-wrap">
                <span class="section-icon-dot service-dot"></span>
                <h2 class="section-title">Dịch Vụ Game Tự Động</h2>
            </div>
        </div>

        <div class="category-grid">
            @foreach ($services as $service)
                @if ($service->active)
                    <a href="{{ route('service.show', ['slug' => $service->slug]) }}" class="category-card service-card">
                        <div class="category-img">
                            <img loading="lazy" decoding="async" src="{{ asset($service->thumbnail) }}?v={{ $service->updated_at?->timestamp ?? 1 }}" alt="{{ $service->name }}">
                        </div>
                        <div class="category-body">
                            <div class="category-name">{{ $service->name }}</div>
                            <div class="category-count">
                                <span class="badge-stock"><i class="fa-solid fa-handshake me-1"></i> <strong>{{ number_format($service->orderCount) }}</strong> giao dịch</span>
                            </div>
                            <div class="category-cta-wrapper">
                                @if(config_get('site_view_all_image'))
                                    <img loading="lazy" decoding="async" src="{{ asset(config_get('site_view_all_image')) }}" alt="Xem ngay" class="category-cta-img">
                                @else
                                    <span class="category-btn-cta btn-cta-cyan">
                                        <span>THUÊ NGAY</span>
                                        <i class="fa-solid fa-arrow-right cta-icon"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- About Shop & Trust Features -->
<section class="section shop-intro-section">
    <div class="container">
        <div class="shop-intro-card">
            <div class="shop-intro-header">
                <div class="shop-badge-capsule">
                    <span class="iconify" data-icon="ant-design:safety-certificate-filled"></span>
                    <span>UY TÍN & CHẤT LƯỢNG HÀNG ĐẦU</span>
                </div>
                <h2 class="shop-intro-title">
                    GIỚI THIỆU VỀ SHOP {{ mb_strtoupper(config_get('site_name', 'SHOP GAME')) }}
                </h2>
                <p class="shop-intro-desc">
                    {{ config_get('site_description', 'Hệ thống cung cấp tài khoản game tự động uy tín hàng đầu, giao dịch nhanh chóng và bảo mật 100%.') }}
                </p>
            </div>

            <div class="shop-features-grid">
                <div class="shop-feature-box">
                    <div class="shop-feature-icon-wrap icon-shield">
                        <span class="iconify" data-icon="ant-design:safety-certificate-filled"></span>
                    </div>
                    <div class="shop-feature-title">Uy Tín & Bảo Mật</div>
                    <div class="shop-feature-desc">Thông tin tài khoản an toàn tuyệt đối, chính sách bảo hành rõ ràng, minh bạch 100%.</div>
                </div>

                <div class="shop-feature-box">
                    <div class="shop-feature-icon-wrap icon-thunder">
                        <span class="iconify" data-icon="ant-design:thunderbolt-filled"></span>
                    </div>
                    <div class="shop-feature-title">Giao Dịch Tự Động</div>
                    <div class="shop-feature-desc">Nhận thông tin tài khoản ngay lập tức 24/7 hoàn toàn tự động sau khi thanh toán.</div>
                </div>

                <div class="shop-feature-box">
                    <div class="shop-feature-icon-wrap icon-price">
                        <span class="iconify" data-icon="ant-design:dollar-circle-filled"></span>
                    </div>
                    <div class="shop-feature-title">Giá Tốt Hàng Đầu</div>
                    <div class="shop-feature-desc">Cam kết mức giá cạnh tranh nhất thị trường kèm vô số chương trình ưu đãi tri ân.</div>
                </div>

                <div class="shop-feature-box">
                    <div class="shop-feature-icon-wrap icon-support">
                        <span class="iconify" data-icon="ant-design:customer-service-filled"></span>
                    </div>
                    <div class="shop-feature-title">Hỗ Trợ Tận Tâm 24/7</div>
                    <div class="shop-feature-desc">Đội ngũ CSKH chuyên nghiệp luôn sẵn sàng giải đáp và hỗ trợ mọi lúc mọi nơi.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Announcement Modal -->
@if (config_get('welcome_modal', false))
@php
    $announceSnoozeEnabled = (bool) config_get('welcome_modal_snooze', true);
    $announceSnoozeHours = max(0.1, min(720, (float) config_get('welcome_modal_snooze_hours', 2)));
    $announceHoursLabel = rtrim(rtrim(number_format($announceSnoozeHours, 1, '.', ''), '0'), '.');
    $announceCloseText = trim((string) config_get('welcome_modal_close_text', 'Đóng')) ?: 'Đóng';
    $announceSnoozeText = str_replace(':hours', $announceHoursLabel, trim((string) config_get('welcome_modal_snooze_text', 'Đóng trong :hours giờ')));
@endphp
<div class="announce-overlay" id="announceOverlay" style="display:none;" aria-hidden="true">
    <div class="announce-modal">
        <div class="announce-header">
            <span class="announce-title"><span class="iconify" data-icon="ant-design:notification-filled"></span> Thông Báo</span>
            <button type="button" class="announce-close-x" id="announceClose" aria-label="Đóng thông báo">&times;</button>
        </div>
        <div class="announce-body">
            {!! config_get('home_notification') !!}
        </div>
        <div class="announce-footer">
            <button type="button" class="btn-announce btn-close-now" id="announceCloseNow">{{ $announceCloseText }}</button>
            @if($announceSnoozeEnabled)
                <button type="button" class="btn-announce btn-close-2h" id="announceClose2h">{{ $announceSnoozeText }}</button>
            @endif
        </div>
    </div>
</div>

<style>
.announce-overlay {
    position: fixed !important;
    inset: 0 !important;
    z-index: 999999 !important;
    background: rgba(15, 23, 42, 0.65) !important;
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: announceFadeIn .25s ease-out;
}
@keyframes announceFadeIn { from { opacity: 0; } to { opacity: 1; } }
.announce-modal {
    position: relative;
    width: 100%;
    max-width: 480px;
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 20px 50px rgba(15, 23, 42, 0.25);
    overflow: hidden;
    animation: announcePopIn .3s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes announcePopIn { from { transform: scale(0.94) translateY(10px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }
[data-theme="dark"] .announce-modal {
    background: #1e1e22;
    border-color: rgba(255, 255, 255, 0.1);
    color: #f1f5f9;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
}
.announce-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
}
.announce-title {
    font-weight: 800;
    font-size: 1.05rem;
    display: flex;
    align-items: center;
    gap: 8px;
    letter-spacing: .3px;
}
.announce-close-x {
    background: rgba(255, 255, 255, 0.2) !important;
    border: none !important;
    color: #ffffff !important;
    width: 30px !important;
    height: 30px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 20px !important;
    line-height: 1 !important;
    cursor: pointer !important;
    transition: all .2s ease !important;
}
.announce-close-x:hover {
    background: rgba(255, 255, 255, 0.35) !important;
    transform: rotate(90deg);
}
.announce-body {
    padding: 22px 20px;
    font-size: 0.95rem;
    line-height: 1.6;
    color: #334155;
    max-height: 60vh;
    overflow-y: auto;
}
[data-theme="dark"] .announce-body { color: #cbd5e1; }
.announce-footer {
    display: flex;
    gap: 10px;
    padding: 12px 20px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    justify-content: flex-end;
}
[data-theme="dark"] .announce-footer {
    background: #18181b;
    border-color: rgba(255, 255, 255, 0.06);
}
.btn-announce {
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all .2s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}
.btn-close-now {
    background: #e2e8f0;
    color: #475569;
}
.btn-close-now:hover {
    background: #cbd5e1;
    color: #1e293b;
}
[data-theme="dark"] .btn-close-now {
    background: #27272a;
    color: #cbd5e1;
}
[data-theme="dark"] .btn-close-now:hover {
    background: #3f3f46;
    color: #ffffff;
}
.btn-close-2h {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
}
.btn-close-2h:hover {
    background: linear-gradient(135deg, #f87171 0%, #b91c1c 100%);
    box-shadow: 0 4px 14px rgba(220, 38, 38, 0.45);
}
</style>
@endif

@endsection

@push('scripts')
<script>
    function switchTab(btn, tabId) {
        document.querySelectorAll('.panel-tab').forEach(function(b) {
            b.classList.remove('active');
        });
        document.querySelectorAll('.tab-content').forEach(function(t) {
            t.classList.remove('active');
        });
        if (btn) btn.classList.add('active');
        var target = document.getElementById(tabId);
        if (target) target.classList.add('active');
    }

    // Flash Sale Countdown Logic
    (function() {
        @php
            $targetEndTime = null;
            if(isset($activeFlashSale)) {
                $targetEndTime = $activeFlashSale->end_time;
            } else if(isset($timelineCampaigns) && count($timelineCampaigns) > 0) {
                $upcoming = $timelineCampaigns->filter(function($c) {
                    return \Carbon\Carbon::parse($c->start_time)->isFuture();
                })->first();
                if($upcoming) {
                    $targetEndTime = $upcoming->start_time;
                }
            }
        @endphp

        @if($targetEndTime)
            var endTimeStr = "{{ \Carbon\Carbon::parse($targetEndTime)->format('Y/m/d H:i:s') }}";
            var endTime = new Date(endTimeStr);
        @else
            var now = new Date();
            var endTime = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 0, 0, 0);
        @endif

        function updateTimer() {
            var elDays = document.getElementById('fs-days');
            if (!elDays) return;

            var diff = endTime - new Date();
            if (diff <= 0) { diff = 0; }
            
            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
            var hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            var mins = Math.floor((diff / 1000 / 60) % 60);
            var secs = Math.floor((diff / 1000) % 60);

            elDays.innerText = days.toString().padStart(2, '0');
            var elH = document.getElementById('fs-hours');
            var elM = document.getElementById('fs-mins');
            var elS = document.getElementById('fs-secs');
            if (elH) elH.innerText = hours.toString().padStart(2, '0');
            if (elM) elM.innerText = mins.toString().padStart(2, '0');
            if (elS) elS.innerText = secs.toString().padStart(2, '0');
        }

        setInterval(updateTimer, 1000);
        updateTimer();
    })();

    // Announcement Modal Logic
    @if (config_get('welcome_modal', false))
    (function() {
        var KEY = 'announce_dismiss_until';
        var SESSION_KEY = 'announce_dismissed_session';
        var snoozeDuration = {{ (int) round($announceSnoozeHours * 60 * 60 * 1000) }};
        var overlay = document.getElementById('announceOverlay');
        if (!overlay) return;

        function readStore(store, key) {
            try { return window[store].getItem(key); } catch (e) { return null; }
        }
        function writeStore(store, key, value) {
            try { window[store].setItem(key, value); } catch (e) {}
        }

        function isSnoozed() {
            var raw = readStore('localStorage', KEY);
            if (!raw) return false;
            var until = parseInt(raw, 10);
            if (!isFinite(until) || until <= Date.now()) {
                try { localStorage.removeItem(KEY); } catch (e) {}
                return false;
            }
            return true;
        }

        function openAnnounce() {
            overlay.style.display = 'flex';
            overlay.setAttribute('aria-hidden', 'false');
        }

        function closeAnnounce(silent2h) {
            overlay.style.display = 'none';
            overlay.setAttribute('aria-hidden', 'true');
            if (silent2h) {
                writeStore('localStorage', KEY, String(Date.now() + snoozeDuration));
            } else {
                writeStore('sessionStorage', SESSION_KEY, '1');
            }
        }

        document.getElementById('announceClose')?.addEventListener('click', function() { closeAnnounce(@json($announceSnoozeEnabled)); });
        document.getElementById('announceCloseNow')?.addEventListener('click', function() { closeAnnounce(false); });
        document.getElementById('announceClose2h')?.addEventListener('click', function() { closeAnnounce(true); });
        overlay.addEventListener('click', function(event) {
            if (event.target === overlay) closeAnnounce(false);
        });

        if (isSnoozed()) return;
        if (readStore('sessionStorage', SESSION_KEY) === '1') return;
        openAnnounce();
    })();
    @endif
</script>
@endpush
