

<?php $__env->startSection('title', $category->name); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <?php if (isset($component)) { $__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0 = $attributes; } ?>
<?php $component = App\View\Components\HeroHeader::resolve(['title' => ''.e($category->name).'','description' => ''.e($category->description).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\HeroHeader::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0)): ?>
<?php $attributes = $__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0; ?>
<?php unset($__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0)): ?>
<?php $component = $__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0; ?>
<?php unset($__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0); ?>
<?php endif; ?>

    <!-- Account List Section -->
    <section class="account-section">
        <div class="container">
            <!-- Filter Bar -->
            <form action="" method="GET" class="filter-inline-bar">
                <input type="text" name="code" class="filter-input" placeholder="Mã số..." value="<?php echo e(request('code')); ?>">
                
                <input type="number" name="price_from" class="filter-input" placeholder="Giá từ..." value="<?php echo e(request('price_from')); ?>">
                <input type="number" name="price_to" class="filter-input" placeholder="Giá đến..." value="<?php echo e(request('price_to')); ?>">

                <?php $__currentLoopData = $dynamicKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" name="details[<?php echo e($key); ?>]" class="filter-input" placeholder="Tìm <?php echo e($key); ?>..." value="<?php echo e(request("details.{$key}")); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <select name="status" class="filter-select">
                    <option value="">Trạng Thái</option>
                    <option value="available" <?php echo e(request('status') == 'available' ? 'selected' : ''); ?>>Chưa bán</option>
                    <option value="sold" <?php echo e(request('status') == 'sold' ? 'selected' : ''); ?>>Đã bán</option>
                </select>

                <button type="submit" class="filter-btn filter-btn-search">
                    <i class="fa-solid fa-search"></i> Tìm kiếm
                </button>
                <a href="<?php echo e(request()->url()); ?>" class="filter-btn filter-btn-reset">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            </form>

            <!-- Account Grid -->
            <div class="account-grid">
                <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="account-card">
                        <div class="account-media">
                            <a href="<?php echo e(route('account.show', ['id' => $account->id])); ?>">
                                <img src="<?php echo e($account->thumb); ?>" alt="Account Preview" class="account-img">
                            </a>
                            <div class="account-code">Mã số: <?php echo e($account->id); ?></div>
                            <div class="account-price-top">ATM/VÍ ĐIỆN TỬ: <?php echo e(number_format($account->price)); ?> VND</div>
                        </div>

                        <div class="account-info">
                            <?php
                                $details = is_array($account->details) ? $account->details : json_decode($account->details, true) ?? [];
                            ?>
                            
                            <?php if(count($details) > 0): ?>
                                <div class="account-row" style="flex-wrap: wrap; gap: 16px 8px; margin-bottom: 8px; border: none;">
                                    <?php $__currentLoopData = array_slice($details, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="info-item" style="width: 45%;">
                                        <span class="info-item__title"><?php echo e($detail['key'] ?? ''); ?>:</span>
                                        <span class="info-value"><?php echo e($detail['value'] ?? ''); ?></span>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="account-actions">
                            <div class="card-price">CARD:
                                <?php echo e(number_format($account->price / ((100 - config_get('payment.card.discount_percent')) / 100))); ?>

                                Đ</div>
                            <a href="<?php echo e(route('account.show', ['id' => $account->id])); ?>"
                                class="action-btn action-btn--detail">XEM CHI TIẾT</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="no-data-empty" style="text-align: center; padding: 60px 0; grid-column: 1 / -1; width: 100%;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px; color: #a0aec0; margin-bottom: 16px;">
                            <path d="M21 8v13H3V8"></path>
                            <path d="M1 3h22v5H1z"></path>
                            <path d="M10 12h4v4h-4z"></path>
                        </svg>
                        <p style="color: #a0aec0; font-size: 1rem; margin: 0;">Chưa có tài khoản nào</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center; width: 100%;">
                <?php echo e($accounts->links('user.pagination.custom')); ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/user/category/show.blade.php ENDPATH**/ ?>