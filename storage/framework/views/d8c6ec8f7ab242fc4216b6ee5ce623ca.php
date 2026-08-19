<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0 = $attributes; } ?>
<?php $component = App\View\Components\HeroHeader::resolve(['title' => 'VÒNG QUAY MAY MẮN','description' => 'Danh sách các vòng quay may mắn'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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

    <section class="section" style="padding-top: 40px;">
        <div class="container">
            <div class="category-grid">
                <?php if($categories->count() > 0): ?>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($category->active): ?>
                            <a href="<?php echo e(route('lucky.index', ['slug' => $category->slug])); ?>" class="category-card" style="position: relative;">
                                <div class="category-img">
                                    <img src="<?php echo e($category->thumbnail); ?>" alt="<?php echo e($category->name); ?>">
                                </div>
                                <div class="category-body" style="display: flex; flex-direction: column;">
                                    <div class="category-name"><?php echo e($category->name); ?></div>
                                    <div class="category-count" style="display:flex;gap:8px;font-size:0.8rem;margin-bottom:10px;">
                                        <span style="color:#64748b;">Đã quay: <?php echo e(number_format($category->soldCount)); ?></span>
                                    </div>
                                    <div style="color: var(--primary); font-weight: 700; font-size: 1.1rem; margin-bottom: 12px;">
                                        <?php echo e(number_format($category->price_per_spin)); ?>đ / 1 lượt
                                    </div>
                                    <div style="text-align: center; margin-top: auto;">
                                        <img src="/img/tag_69e1555d8bab7.gif" alt="Xem Tất Cả" style="max-width: 140px; transition: transform 0.2s; border-radius: 8px;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onerror="this.src='https://i.imgur.com/J3t1e5r.gif'">
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="empty-state" style="text-align: center; padding: 60px 20px; width: 100%; grid-column: 1/-1;">
                        <span class="iconify" data-icon="bx:box" style="font-size: 48px; color: #94a3b8; margin-bottom: 12px; display: inline-block;"></span>
                        <div style="color: #94a3b8; font-size: 0.95rem;">Chưa có vòng quay nào</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\user\wheel\show-all.blade.php ENDPATH**/ ?>