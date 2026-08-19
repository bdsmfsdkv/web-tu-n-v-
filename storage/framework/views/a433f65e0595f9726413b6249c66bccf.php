
<?php $__env->startSection('title', 'Trang chủ'); ?>
<?php $__env->startSection('content'); ?>

<!-- Hero Section: 3-7 Layout -->
<section class="hero-split">
    <div class="container">
        <div class="hero-grid">
            <!-- Left: Top Nạp Tiền (30%) -->
            <div class="hero-left">
                <div class="top-deposit-panel">
                    <div class="panel-tabs">
                        <button class="panel-tab active" data-tab="tab-top" onclick="switchTab(this, 'tab-top')">
                            <span class="iconify" data-icon="ant-design:trophy-filled" style="color:#faad14;"></span> Top Nạp Tiền
                        </button>
                        <button class="panel-tab" data-tab="tab-reward" onclick="switchTab(this, 'tab-reward')">
                            <span class="iconify" data-icon="ant-design:gift-filled" style="color:#dc2626;"></span> Phần Thưởng
                        </button>
                    </div>

                    <!-- Tab 1: Top Nạp Tiền -->
                    <div class="panel-body tab-content active" id="tab-top">
                        <?php $__empty_1 = true; $__currentLoopData = $topDepositors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depositor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="top-item">
                                <?php if($loop->iteration <= 5): ?>
                                    <div class="top-avatar" style="background: transparent; border: none; box-shadow: none; padding: 0;">
                                        <img src="https://shopacc68.com/assets/svg/<?php echo e($loop->iteration); ?>.svg" alt="Top <?php echo e($loop->iteration); ?>" style="width: 40px; height: 40px; object-fit: contain; border-radius: 0;">
                                    </div>
                                <?php else: ?>
                                    <div class="top-avatar"><?php echo e($loop->iteration); ?></div>
                                <?php endif; ?>
                                <div class="top-info">
                                    <div class="top-name"><?php echo e(substr($depositor->user->username, 0, 4)); ?>***</div>
                                </div>
                                <div class="top-amount"><?php echo e(number_format($depositor->total_amount)); ?>đ</div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div style="text-align:center;padding:20px;color:#999;">Chưa có dữ liệu nạp thẻ tháng này.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Tab 2: Phần Thưởng -->
                    <div class="panel-body tab-content" id="tab-reward" style="padding:16px;overflow-y:auto;display:none;">
                        <div class="reward-content-render"><?php echo config_get('top_deposit_reward', '<p>Phần thưởng nạp thẻ đang được cập nhật...</p>'); ?></div>
                    </div>
                    <div style="padding:10px 14px;margin-top:auto;">
                        <a href="javascript:void(0)" onclick="document.getElementById('depositMethodModal').style.display='flex'" style="display:block;text-align:center;padding:10px;background:var(--primary);color:#fff;border-radius:8px;font-weight:600;font-size:0.85rem;text-decoration:none;transition:all .2s;">Nạp Ngay</a>
                    </div>
                </div>
            </div>

            <!-- Right: Banner Slider (70%) -->
            <div class="hero-right">
                <div class="banner-slider" id="bannerSlider">
                    <div class="slider-track" id="sliderTrack">
                        <?php
                            $banners = json_decode(config_get('site_banner'), true);
                            if (!is_array($banners) && !empty(config_get('site_banner'))) {
                                $banners = [config_get('site_banner')];
                            } elseif (empty($banners)) {
                                $banners = [];
                            }
                        ?>
                        <?php if(count($banners) > 0): ?>
                            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="slide <?php echo e($index == 0 ? 'active' : ''); ?>" style="background:url('<?php echo e($banner); ?>') center/cover no-repeat;"></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="slide active" style="background:url('https://via.placeholder.com/800x400?text=No+Banner') center/cover no-repeat;"></div>
                        <?php endif; ?>
                    </div>

                    <?php if(count($banners) > 1): ?>
                    <button class="slider-arrow slider-prev" id="sliderPrev" aria-label="Previous slide"><span class="iconify" data-icon="ant-design:left-outlined"></span></button>
                    <button class="slider-arrow slider-next" id="sliderNext" aria-label="Next slide"><span class="iconify" data-icon="ant-design:right-outlined"></span></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    $marqueeNotifications = \App\Models\Notification::orderBy('id', 'desc')->get();
?>
<?php if($marqueeNotifications->count() > 0): ?>
<div class="container custom-marquee-container" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="marquee-badge">
        <div class="marquee-icon">
            <i class="fa-solid fa-satellite-dish" aria-hidden="true"></i>
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
                <?php $__currentLoopData = $marqueeNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="marquee-item-inner">
                    <i class="<?php echo e(str_starts_with($notif->class_favicon, 'fa-') ? 'fa-solid ' . $notif->class_favicon : $notif->class_favicon); ?> marquee-item-icon" aria-hidden="true"></i>
                    <span class="marquee-item-text"><?php echo e($notif->content); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <!-- Duplicate for seamless scroll -->
            <div class="marquee-item">
                <?php $__currentLoopData = $marqueeNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="marquee-item-inner">
                    <i class="<?php echo e(str_starts_with($notif->class_favicon, 'fa-') ? 'fa-solid ' . $notif->class_favicon : $notif->class_favicon); ?> marquee-item-icon" aria-hidden="true"></i>
                    <span class="marquee-item-text"><?php echo e($notif->content); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="marquee-fade-left" aria-hidden="true"></div>
        <div class="marquee-fade-right" aria-hidden="true"></div>
    </div>
</div>
<?php endif; ?>

<style>
    .custom-marquee-container {
        display: flex;
        min-height: 52px;
        align-items: stretch;
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.3s;
    }
    .custom-marquee-container:hover {
        border-color: rgba(59, 130, 246, 0.25);
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1), 0 2px 4px -1px rgba(59, 130, 246, 0.06);
    }
    .marquee-badge {
        position: relative;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        gap: 10px;
        border-right: 1px solid rgba(59, 130, 246, 0.15);
        background: rgba(59, 130, 246, 0.05);
        padding: 12px 20px;
    }
    .marquee-icon {
        position: relative;
        display: flex;
        height: 32px;
        width: 32px;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background-color: #3b82f6;
        color: #fff;
        font-size: 12px;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.35);
        animation: pulse-blue 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .marquee-badge-text {
        display: none;
        flex-direction: column;
        gap: 2px;
    }
    @media (min-width: 768px) {
        .marquee-badge-text { display: flex; }
    }
    .marquee-title {
        font-size: 11px;
        line-height: 1;
        font-weight: 900;
        letter-spacing: -0.025em;
        color: #3b82f6;
        text-transform: uppercase;
    }
    .marquee-subtitle {
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 0.1em;
        color: #94a3b8;
        text-transform: uppercase;
    }
    .marquee-divider {
        position: absolute;
        top: 20%;
        right: 0;
        display: none;
        height: 60%;
        width: 2px;
        border-radius: 2px;
        background-color: #3b82f6;
    }
    @media (min-width: 768px) {
        .marquee-divider { display: block; }
    }
    .marquee-content-wrapper {
        position: relative;
        display: flex;
        flex: 1 1 0%;
        align-items: center;
        overflow: hidden;
    }
    .marquee-track {
        display: flex;
        width: max-content;
        align-items: center;
        animation: marquee-scroll 45s linear infinite;
    }
    .marquee-track:hover {
        animation-play-state: paused;
    }
    .marquee-item {
        display: flex;
        align-items: center;
        white-space: nowrap;
        min-width: 1200px;
        padding-right: 50px;
    }
    .marquee-item-inner {
        display: flex;
        align-items: center;
        gap: 8px;
        padding-right: 28px;
    }
    .marquee-item-icon {
        flex-shrink: 0;
        font-size: 9px;
        color: rgba(59, 130, 246, 0.6);
    }
    .marquee-item-text {
        font-size: 12px;
        font-weight: 800;
        letter-spacing: -0.025em;
        color: var(--text-color, #334155);
        text-transform: uppercase;
        transition: color 0.15s;
    }
    .marquee-item-text:hover {
        color: #3b82f6;
    }
    .marquee-fade-left {
        pointer-events: none;
        position: absolute;
        top: 0; bottom: 0; left: 0;
        z-index: 10;
        width: 48px;
        background: linear-gradient(to right, #fff, transparent);
    }
    .marquee-fade-right {
        pointer-events: none;
        position: absolute;
        top: 0; bottom: 0; right: 0;
        z-index: 10;
        width: 48px;
        background: linear-gradient(to left, #fff, transparent);
    }
    @keyframes pulse-blue {
        0%, 100% { opacity: 1; }
        50% { opacity: .5; }
    }
    @keyframes marquee-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    [data-theme="dark"] .marquee-item-text {
        color: #cbd5e1;
    }
    [data-theme="dark"] .marquee-item-text:hover {
        color: #3b82f6;
    }
    [data-theme="dark"] .custom-marquee-container {
        background: #1a1a1a;
        border-color: #2a2a2a;
    }
    [data-theme="dark"] .marquee-fade-left {
        background: linear-gradient(to right, #1a1a1a, transparent);
    }
    [data-theme="dark"] .marquee-fade-right {
        background: linear-gradient(to left, #1a1a1a, transparent);
    }
</style>
<!-- Ticker (Recent Transactions) -->
<div class="container">
    <div class="purchase-ticker">
        <div class="ticker-track">
            <div class="ticker-content">
                <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ticker-item">
                        <span class="ticker-icon"><span class="iconify" data-icon="ant-design:check-circle-filled" style="color:#52c41a"></span></span>
                        <div class="ticker-text">
                            <div class="ticker-line1">
                                <strong><?php echo e(substr($transaction->user->username, 0, 3)); ?>***</strong> 
                                <?php if($transaction->type == 'deposit'): ?>
                                    đã nạp
                                <?php elseif($transaction->type == 'withdraw'): ?>
                                    đã rút
                                <?php elseif($transaction->type == 'purchase'): ?>
                                    đã mua tài khoản
                                <?php elseif($transaction->type == 'refund'): ?>
                                    được hoàn
                                <?php endif; ?>
                                giá <span class="ticker-price"><?php echo e(number_format($transaction->amount)); ?>đ</span>
                            </div>
                            <div class="ticker-line2"><?php echo e($transaction->created_at->diffForHumans()); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <!-- Duplicate for seamless scroll if needed -->
                <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ticker-item">
                        <span class="ticker-icon"><span class="iconify" data-icon="ant-design:check-circle-filled" style="color:#52c41a"></span></span>
                        <div class="ticker-text">
                            <div class="ticker-line1">
                                <strong><?php echo e(substr($transaction->user->username, 0, 3)); ?>***</strong> 
                                <?php if($transaction->type == 'deposit'): ?>
                                    đã nạp
                                <?php elseif($transaction->type == 'withdraw'): ?>
                                    đã rút
                                <?php elseif($transaction->type == 'purchase'): ?>
                                    đã mua tài khoản
                                <?php elseif($transaction->type == 'refund'): ?>
                                    được hoàn
                                <?php endif; ?>
                                giá <span class="ticker-price"><?php echo e(number_format($transaction->amount)); ?>đ</span>
                            </div>
                            <div class="ticker-line2"><?php echo e($transaction->created_at->diffForHumans()); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Flash Sale Section -->
<?php if((isset($timelineCampaigns) && $timelineCampaigns->count() > 0) || (isset($activeFlashSale) && $activeFlashSale)): ?>
<div class="container" style="margin-top: 20px;">
    <div class="flash-sale-wrapper">
        <div class="fs-header">
            <div class="fs-title-box" style="padding-left: 15px; padding-right: 15px;">
                <span class="fs-title-text" style="font-size: 1.2rem;">
                    <?php echo e(isset($activeFlashSale) && $activeFlashSale ? mb_strtoupper($activeFlashSale->campaign_name) : 'F⚡ASH SALE'); ?>

                </span>
            </div>
            <div class="fs-timer-box">
                <span class="iconify fs-clock-icon" data-icon="ant-design:clock-circle-outlined"></span> 
                <span class="fs-timer-label"><?php echo e($activeFlashSale ? 'KẾT THÚC TRONG' : 'BẮT ĐẦU TRONG'); ?></span>
                <div class="fs-countdown">
                    <div class="fs-time-box"><span id="fs-days">00</span><small>DAYS</small></div>
                    <div class="fs-time-box"><span id="fs-hours">00</span><small>HRS</small></div>
                    <div class="fs-time-box"><span id="fs-mins">00</span><small>MINS</small></div>
                    <div class="fs-time-box"><span id="fs-secs">00</span><small>SECS</small></div>
                </div>
            </div>
            <a href="#" class="fs-view-all">Xem tất cả <span class="iconify" data-icon="ant-design:right-outlined"></span></a>
        </div>
        
        <div class="fs-timeline">
            <?php
                $slots = ['1:00', '6:00', '8:00', '12:00', '15:00', '18:00', '20:00', '22:00'];
                $currentHour = (int)date('H');
                $activeIndex = 0;
                foreach($slots as $index => $time) {
                    $slotHour = (int)explode(':', $time)[0];
                    if ($currentHour >= $slotHour) {
                        $activeIndex = $index;
                    }
                }
            ?>
            <?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="fs-slot <?php echo e($index < $activeIndex ? 'past' : ($index == $activeIndex ? 'active' : 'future')); ?>">
                    <div class="fs-time"><?php echo e($time); ?></div>
                    <div class="fs-status">
                        <?php echo e($index < $activeIndex ? 'Đã diễn ra' : ($index == $activeIndex ? 'Đang diễn ra' : 'Sắp diễn ra')); ?>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(isset($flashSales) && count($flashSales) > 0): ?>
            <div class="fs-grid">
                <?php $__currentLoopData = $flashSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($fs->is_random ? route('random.index', ['slug' => $fs->slug]) : route('category.index', ['slug' => $fs->slug])); ?>" class="fs-card" style="text-decoration: none; display: block;">
                        <div class="fs-card-img">
                            <img src="<?php echo e($fs->thumbnail); ?>" onerror="this.src='https://via.placeholder.com/200x120?text=Flash+Sale'" alt="<?php echo e($fs->name); ?>">
                            <?php if($fs->flash_sale_old_price > 0 && $fs->flash_sale_new_price > 0 && $fs->flash_sale_old_price > $fs->flash_sale_new_price): ?>
                                <?php
                                    $discountPercent = round((($fs->flash_sale_old_price - $fs->flash_sale_new_price) / $fs->flash_sale_old_price) * 100);
                                ?>
                                <div class="fs-discount-badge">⚡ -<?php echo e($discountPercent); ?>%</div>
                            <?php else: ?>
                                <div class="fs-discount-badge">⚡ SALE</div>
                            <?php endif; ?>
                        </div>
                        <div class="fs-card-info">
                            <div class="fs-id">ID: <?php echo e($fs->id); ?></div>
                            <?php if($fs->flash_sale_old_price): ?>
                                <div class="fs-old-price"><?php echo e(number_format($fs->flash_sale_old_price)); ?>đ</div>
                            <?php else: ?>
                                <div class="fs-old-price" style="visibility: hidden;">0đ</div>
                            <?php endif; ?>
                            
                            <?php if($fs->flash_sale_new_price): ?>
                                <div class="fs-new-price"><?php echo e(number_format($fs->flash_sale_new_price)); ?>đ</div>
                            <?php else: ?>
                                <div class="fs-new-price">0đ</div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div style="padding: 40px 20px; text-align: center; color: #6b7280; font-size: 1.1rem; font-weight: 500;">
                <i class="fa fa-clock-o" style="font-size: 2rem; margin-bottom: 10px; color: #9ca3af; display: block;"></i>
                Chưa đến thời gian Flash Sale. Các sản phẩm sẽ được hiển thị khi khung giờ bắt đầu!
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php
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
?>

<?php $__currentLoopData = $groupedCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <section class="section" id="categories-<?php echo e(Str::slug($platform)); ?>">
        <div class="container">
            <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="section-title" style="margin-bottom: 0;"><?php echo e($platform); ?></h2>
                <a href="<?php echo e(route('category.group', ['slug' => Str::slug($platform)])); ?>" style="color: var(--primary); font-weight: 600; font-size: 0.95rem; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                    Xem tất cả <span>&rarr;</span>
                </a>
            </div>

            <div class="category-grid">
                <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($category->url ?? route('category.index', ['slug' => $category->slug])); ?>" class="category-card" style="position: relative;">
                        <?php if($category->tag_image): ?>
                        <img src="<?php echo e($category->tag_image); ?>" alt="Tag" style="position: absolute; top: 0; right: 0; max-width: 60px; z-index: 10;">
                        <?php endif; ?>
                        <div class="category-img" style="display: flex; align-items: center; justify-content: center; background: rgba(220, 38, 38, 0.05); color: var(--primary); border: 1px solid rgba(220, 38, 38, 0.1);">
                            <?php if($category->thumbnail): ?>
                            <img src="<?php echo e($category->thumbnail); ?>" alt="<?php echo e($category->name); ?>">
                            <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" viewBox="0 0 1024 1024" data-icon="ant-design:appstore-outlined" style="font-size:2.5rem;" class="iconify iconify--ant-design"><path fill="currentColor" d="M464 144H160c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V160c0-8.8-7.2-16-16-16m-52 268H212V212h200zm452-268H560c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V160c0-8.8-7.2-16-16-16m-52 268H612V212h200zM464 544H160c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V560c0-8.8-7.2-16-16-16m-52 268H212V612h200zm452-268H560c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V560c0-8.8-7.2-16-16-16m-52 268H612V612h200z"></path></svg>
                            <?php endif; ?>
                        </div>
                        
                        <div class="category-body" style="display: flex; flex-direction: column;">
                            <div class="category-name"><?php echo e($category->name); ?></div>
                            <div class="category-count" style="display:flex;gap:8px;font-size:0.8rem;margin-bottom:15px;">
                                <span style="color:#64748b;">Còn lại: <?php echo e(number_format($category->allAccount)); ?></span>
                                <span style="color:#64748b;">| Đã bán: <?php echo e(number_format($category->soldCount)); ?></span>
                            </div>
                            <?php if(!empty($category->price)): ?>
                                <div style="color: var(--primary); font-weight: 700; font-size: 1.1rem; margin-bottom: 12px;">
                                    <?php echo e(number_format($category->price)); ?>đ
                                </div>
                            <?php endif; ?>
                            <div style="text-align: center; margin-top: auto;">
                                <img src="/img/tag_69e1555d8bab7.gif" alt="Xem Tất Cả" style="max-width: 140px; transition: transform 0.2s; border-radius: 8px;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onerror="this.src='https://i.imgur.com/J3t1e5r.gif'">
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- Lucky Wheel -->
<?php if(isset($LuckWheel) && $LuckWheel->count() > 0): ?>
<section class="section">
    <div class="container">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="section-title" style="margin-bottom: 0;">Vòng Quay May Mắn</h2>
            <a href="<?php echo e(route('lucky.show-all')); ?>" style="color: var(--primary); font-weight: 600; font-size: 0.95rem; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                Xem tất cả <span>&rarr;</span>
            </a>
        </div>

        <div class="category-grid">
            <?php $__currentLoopData = $LuckWheel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wheel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($wheel->active): ?>
                    <a href="<?php echo e(route('lucky.index', ['slug' => $wheel->slug])); ?>" class="category-card" style="position: relative;">
                        <div class="category-img">
                            <img src="<?php echo e($wheel->thumbnail); ?>" alt="<?php echo e($wheel->name); ?>">
                        </div>
                        <div class="category-body" style="display: flex; flex-direction: column;">
                            <div class="category-name"><?php echo e($wheel->name); ?></div>
                            <div class="category-count" style="display:flex;gap:8px;font-size:0.8rem;margin-bottom:10px;">
                                <span style="color:#64748b;">Đã quay: <?php echo e(number_format($wheel->soldCount ?? 0)); ?></span>
                            </div>
                            <div style="color: var(--primary); font-weight: 700; font-size: 1.1rem; margin-bottom: 12px;">
                                <?php echo e(number_format($wheel->price_per_spin)); ?>đ / 1 lượt
                            </div>
                            <div style="text-align: center; margin-top: auto;">
                                <img src="/img/tag_69e1555d8bab7.gif" alt="Xem Tất Cả" style="max-width: 140px; transition: transform 0.2s; border-radius: 8px;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onerror="this.src='https://i.imgur.com/J3t1e5r.gif'">
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Services -->
<?php if($services->count() > 0): ?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Dịch Vụ Game</h2>
        </div>

        <div class="category-grid">
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($service->active): ?>
                    <a href="<?php echo e(route('service.show', ['slug' => $service->slug])); ?>" class="category-card">
                        <div class="category-img">
                            <img src="<?php echo e($service->thumbnail); ?>" alt="<?php echo e($service->name); ?>">
                        </div>
                        <div class="category-body" style="display: flex; flex-direction: column;">
                            <div class="category-name"><?php echo e($service->name); ?></div>
                            <div class="category-count" style="display:flex;gap:8px;font-size:0.8rem;margin-bottom:10px;">
                                <span style="color:#999;"><?php echo e(number_format($service->orderCount)); ?> giao dịch</span>
                            </div>
                            <div style="text-align: center; margin-top: auto;">
                                <img src="https://i.imgur.com/J3t1e5r.gif" alt="Xem Tất Cả" style="max-width: 130px; border-radius: 4px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Reviews Section -->
<section class="section">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom: 25px;">
            <h2 class="section-title" style="display:inline-block; font-size: 1.5rem; justify-content: center; width: 100%;">
                <span class="iconify" data-icon="ant-design:star-filled" style="color:#faad14; font-size: 1.6rem; vertical-align: middle;"></span> 
                Nhận xét của khách hàng khi sử dụng dịch vụ tại shop 
                <span class="iconify" data-icon="ant-design:star-filled" style="color:#faad14; font-size: 1.6rem; vertical-align: middle;"></span>
            </h2>
        </div>
        
        <div class="review-grid">
            <?php
                $fakeTexts = [
                    'Giao dịch nhanh gọn, uy tín',
                    'Đã ủng hộ lần t2 rất uy tín ok',
                    'Sản phẩm chất lượng.',
                    'Acc ngon, giá rẻ',
                    'Nhân viên hỗ trợ nhiệt tình',
                    'Lần tới sẽ ủng hộ tiếp'
                ];
                $displayReviews = [];
                if(isset($recentPurchases)) {
                    foreach($recentPurchases as $purchase) {
                        $username = $purchase->user ? $purchase->user->username : 'KhachHang';
                        $maskedName = substr($username, 0, 3) . '****' . substr($username, -2);
                        $displayReviews[] = [
                            'name' => $maskedName,
                            'id' => $purchase->game_account_id ?? rand(100000, 999999),
                            'text' => $fakeTexts[array_rand($fakeTexts)],
                            'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'
                        ];
                    }
                }
                
                $staticReviews = [
                    ['name' => 'Tan****ng', 'id' => '245477', 'text' => 'Giao dịch nhanh gọn, uy tín', 'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'],
                    ['name' => 'Mạn****ễn', 'id' => '241301', 'text' => 'Giao dịch nhanh gọn, uy tín', 'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'],
                    ['name' => 'Dch****15', 'id' => '166182', 'text' => 'Đã ủng hộ lần t2 rất uy tín ok', 'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'],
                    ['name' => 'xku****11', 'id' => '211127', 'text' => 'Sản phẩm chất lượng.', 'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'],
                    ['name' => 'luc****an', 'id' => '209673', 'text' => 'Acc ngon, giá rẻ', 'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'],
                    ['name' => 'LyT****39', 'id' => '165709', 'text' => 'Nhân viên hỗ trợ nhiệt tình', 'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'],
                    ['name' => 'LyT****39', 'id' => '203838', 'text' => 'Giao dịch nhanh gọn, uy tín', 'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'],
                    ['name' => 'ryo****uo', 'id' => '203701', 'text' => 'Lần tới sẽ ủng hộ tiếp', 'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg']
                ];

                $needed = 8 - count($displayReviews);
                for($i = 0; $i < $needed; $i++) {
                    $displayReviews[] = $staticReviews[$i];
                }
            ?>
            <?php $__currentLoopData = $displayReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="review-card">
                    <div class="review-header">
                        <img src="<?php echo e($review['avatar']); ?>" alt="Avatar" class="review-avatar" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($review['name'])); ?>&background=random'">
                        <div class="review-info">
                            <div class="review-name"><?php echo e($review['name']); ?></div>
                            <div class="review-meta">
                                <span class="review-stars">
                                    <span class="iconify" data-icon="ant-design:star-filled"></span>
                                    <span class="iconify" data-icon="ant-design:star-filled"></span>
                                    <span class="iconify" data-icon="ant-design:star-filled"></span>
                                    <span class="iconify" data-icon="ant-design:star-filled"></span>
                                    <span class="iconify" data-icon="ant-design:star-filled"></span>
                                </span>
                                <span class="review-id">đã mua nick <?php echo e($review['id']); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="review-text"><?php echo e($review['text']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="view-all-reviews" style="margin-top: 15px;">
            <a href="<?php echo e(route('reviews')); ?>" class="btn-view-all-reviews" style="display: inline-block; text-decoration: none;">Xem tất cả</a>
        </div>
    </div>
</section>

<!-- Announcement Modal -->
<?php if(config_get('welcome_modal', false)): ?>
<div class="announce-overlay" id="announceOverlay" onclick="if(event.target===this)closeAnnounce(false)">
    <div class="announce-modal">
        <div class="announce-header">
            <span><span class="iconify" data-icon="ant-design:notification-filled" style="color:var(--primary); margin-right:6px;"></span> Thông Báo</span>
            <button class="announce-close-x" onclick="closeAnnounce(false)" aria-label="Close modal">&times;</button>
        </div>
        <div class="announce-body">
            <?php echo config_get('home_notification'); ?>

        </div>
        <div class="announce-footer">
            <button class="btn-announce btn-close-now" onclick="closeAnnounce(false)">Đóng</button>
            <button class="btn-announce btn-close-2h" onclick="closeAnnounce(true)">Đóng trong 2 giờ</button>
        </div>
    </div>
</div>

<style>
    .view-all-container {
        text-align: center;
        margin-top: 25px;
        margin-bottom: 10px;
    }
    .btn-view-all {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(90deg, var(--primary), #fca5a5);
        color: #fff;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        transition: all 0.3s ease;
    }
    .btn-view-all:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        color: #fff;
    }
    .btn-view-all-text {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    [data-theme="dark"] .btn-view-all {
        background: linear-gradient(90deg, #dc2626, #991b1b);
    }

    .announce-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.6); z-index: 99999;
        display: flex; align-items: center; justify-content: center;
        backdrop-filter: blur(4px); opacity: 0;
        animation: announceFadeIn .3s forwards;
    }
    @keyframes announceFadeIn { to { opacity: 1; } }
    .announce-modal {
        background: #fff; border-radius: 12px; max-width: 500px; width: 92%; max-height: 85vh;
        display: flex; flex-direction: column; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        animation: announceSlideUp .3s ease;
    }
    @keyframes announceSlideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .announce-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px; font-weight: 700; font-size: 1.15rem; border-bottom: 1px solid #f0f0f0; color: #111827;
    }
    .announce-close-x {
        background: none; border: none; font-size: 1.8rem; cursor: pointer;
        color: #9ca3af; line-height: 1; padding: 0 4px; transition: 0.2s; font-weight: 300;
    }
    .announce-close-x:hover { color: #111827; }
    .announce-body {
        padding: 20px; overflow-y: auto; flex: 1; font-size: 0.95rem; line-height: 1.6; color: #374151;
    }
    .announce-body img { max-width: 100%; border-radius: 8px; height: auto; }
    .announce-footer {
        display: flex; gap: 12px; padding: 16px 20px; border-top: 1px solid #f0f0f0; justify-content: flex-end; background: #f8fafc; border-radius: 0 0 12px 12px;
    }
    .btn-announce {
        padding: 8px 18px; border: none; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: all .2s;
    }
    .btn-close-now { background: #e2e8f0; color: #475569; }
    .btn-close-now:hover { background: #cbd5e1; }
    .btn-close-2h { background: var(--primary); color: #fff; }
    .btn-close-2h:hover { opacity: 0.9; }

    /* Dark mode */
    [data-theme="dark"] .announce-modal { background: #262626; border: 1px solid #404040; }
    [data-theme="dark"] .announce-header { border-color: #404040; color: #f9fafb; }
    [data-theme="dark"] .announce-close-x { color: #6b7280; }
    [data-theme="dark"] .announce-close-x:hover { color: #f9fafb; }
    [data-theme="dark"] .announce-body { color: #d1d5db; }
    [data-theme="dark"] .announce-footer { border-color: #404040; background: #1f1f1f; }
    [data-theme="dark"] .btn-close-now { background: #404040; color: #f9fafb; }
    [data-theme="dark"] .btn-close-now:hover { background: #525252; }

    /* Reviews Section Styles */
    .review-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) {
        .review-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .review-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .review-grid { grid-template-columns: 1fr; }
    }
    .review-card {
        background: #fff;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .review-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    [data-theme="dark"] .review-card {
        background: #1f1f1f;
        border-color: #333;
    }
    .review-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    .review-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    .review-info {
        flex: 1;
    }
    .review-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1f2937;
        margin-bottom: 4px;
    }
    [data-theme="dark"] .review-name {
        color: #f3f4f6;
    }
    .review-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
    }
    .review-stars {
        color: #faad14;
        display: flex;
        gap: 2px;
    }
    .review-id {
        color: #9ca3af;
    }
    .review-text {
        font-size: 0.9rem;
        color: #4b5563;
        line-height: 1.5;
    }
    [data-theme="dark"] .review-text {
        color: #9ca3af;
    }
    .view-all-reviews {
        text-align: center;
    }
    .btn-view-all-reviews {
        background: #9ca3af;
        color: #fff;
        border: none;
        padding: 6px 16px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-view-all-reviews:hover {
        background: #6b7280;
    }

    /* Flash Sale Styles */
    .flash-sale-wrapper {
        background: #f0f2f5;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 30px;
    }
    [data-theme="dark"] .flash-sale-wrapper {
        background: #1a1a1a;
    }
    .fs-header {
        background: #3a49e9; /* Deep blue */
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        color: white;
        flex-wrap: wrap;
        gap: 15px;
    }
    .fs-title-box {
        font-size: 1.6rem;
        font-weight: 900;
        letter-spacing: 1px;
        font-style: italic;
    }
    .fs-title-text {
        text-shadow: 2px 2px 0 rgba(0,0,0,0.2);
    }
    .fs-timer-box {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        justify-content: flex-start;
        padding-left: 20px;
    }
    .fs-clock-icon {
        font-size: 1.2rem;
    }
    .fs-timer-label {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .fs-countdown {
        display: flex;
        gap: 6px;
    }
    .fs-time-box {
        background: #fc4e2a; /* Orange/Red */
        color: white;
        border-radius: 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        padding: 2px 4px;
        font-family: monospace;
        font-weight: bold;
        box-shadow: inset 0 -2px 0 rgba(0,0,0,0.1);
    }
    .fs-time-box span {
        font-size: 1rem;
        line-height: 1;
    }
    .fs-time-box small {
        font-size: 0.5rem;
        opacity: 0.9;
        margin-top: 1px;
    }
    .fs-view-all {
        color: white;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: opacity 0.2s;
    }
    .fs-view-all:hover {
        opacity: 0.8;
    }

    .fs-timeline {
        display: flex;
        background: #fff;
        padding: 10px 0;
        overflow-x: auto;
        border-bottom: 1px solid #e5e7eb;
    }
    [data-theme="dark"] .fs-timeline {
        background: #262626;
        border-color: #404040;
    }
    .fs-timeline::-webkit-scrollbar { height: 4px; }
    .fs-timeline::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .fs-slot {
        flex: 1;
        min-width: 100px;
        text-align: center;
        padding: 5px 10px;
        border-right: 1px solid #f3f4f6;
        cursor: pointer;
    }
    [data-theme="dark"] .fs-slot { border-color: #404040; }
    .fs-slot:last-child { border-right: none; }
    .fs-time {
        font-size: 1.2rem;
        font-weight: 700;
        color: #9ca3af;
    }
    .fs-status {
        font-size: 0.8rem;
        color: #9ca3af;
        margin-top: 2px;
    }
    .fs-slot.active .fs-time, .fs-slot.active .fs-status {
        color: #111827;
    }
    [data-theme="dark"] .fs-slot.active .fs-time, [data-theme="dark"] .fs-slot.active .fs-status {
        color: #f9fafb;
    }
    
    .fs-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        padding: 20px;
    }
    @media (max-width: 1024px) {
        .fs-grid { grid-template-columns: repeat(4, 1fr); }
        .fs-timer-box { padding-left: 0; }
    }
    @media (max-width: 768px) {
        .fs-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 576px) {
        .fs-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .fs-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    .fs-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }
    [data-theme="dark"] .fs-card {
        background: #262626;
    }
    .fs-card-img {
        position: relative;
        padding-top: 60%; /* 5:3 Aspect Ratio */
        background: #e2e8f0;
    }
    .fs-card-img img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .fs-discount-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #fc4e2a;
        color: #fff;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 3px 8px;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .fs-card-info {
        padding: 12px;
    }
    .fs-id {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 6px;
    }
    .fs-old-price {
        font-size: 0.85rem;
        color: #9ca3af;
        text-decoration: line-through;
        margin-bottom: 2px;
    }
    .fs-new-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ea580c; /* Orange red */
    }
</style>

<script>
    (function() {
        var KEY = 'announce_dismiss_until';
        var ts = localStorage.getItem(KEY);
        if (ts && Date.now() < parseInt(ts)) {
            var el = document.getElementById('announceOverlay');
            if (el) el.style.display = 'none';
        }
    })();

    function closeAnnounce(silent2h) {
        var el = document.getElementById('announceOverlay');
        if (el) el.style.display = 'none';
        if (silent2h) {
            localStorage.setItem('announce_dismiss_until', Date.now() + 2 * 60 * 60 * 1000);
        }
    }

        // Flash Sale Countdown Logic
        (function() {
            <?php
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
            ?>

            <?php if($targetEndTime): ?>
                var endTimeStr = "<?php echo e(\Carbon\Carbon::parse($targetEndTime)->format('Y/m/d H:i:s')); ?>";
                var endTime = new Date(endTimeStr);
            <?php else: ?>
                var now = new Date();
                var endTime = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 0, 0, 0);
            <?php endif; ?>

        function updateTimer() {
            var elDays = document.getElementById('fs-days');
            if (!elDays) return; // Elements not present

            var diff = endTime - new Date();
            if (diff <= 0) { diff = 0; }
            
            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
            var hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            var mins = Math.floor((diff / 1000 / 60) % 60);
            var secs = Math.floor((diff / 1000) % 60);

            elDays.innerText = days.toString().padStart(2, '0');
            document.getElementById('fs-hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('fs-mins').innerText = mins.toString().padStart(2, '0');
            document.getElementById('fs-secs').innerText = secs.toString().padStart(2, '0');
        }

        setInterval(updateTimer, 1000);
        updateTimer();
    })();
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function switchTab(btn, tabId) {
        document.querySelectorAll('.panel-tab').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
        btn.classList.add('active');
        document.getElementById(tabId).style.display = 'block';
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/user/home.blade.php ENDPATH**/ ?>