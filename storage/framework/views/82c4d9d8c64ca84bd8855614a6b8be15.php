
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>


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

    <?php if($categories->count() > 0): ?>
        <?php $__currentLoopData = $groupedCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($group->count() > 0): ?>
                <section class="section" id="categories-<?php echo e(Str::slug($platform)); ?>" style="padding-top: <?php echo e($loop->first ? '0' : '40px'); ?>;">
                    <?php if (isset($component)) { $__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0 = $attributes; } ?>
<?php $component = App\View\Components\HeroHeader::resolve(['title' => ''.e(mb_strtoupper($platform)).'','description' => 'Danh sách các danh mục tài khoản game'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\HeroHeader::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['hideBreadcrumb' => true]); ?>
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
                    <div class="container">
                        <div class="category-grid">
                            <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($category->active): ?>
                                    <a href="<?php echo e($category->url ?? route('category.index', ['slug' => $category->slug])); ?>" class="category-card" style="position: relative;">
                                        <?php if(isset($category->tag_image) && $category->tag_image): ?>
                                        <img src="<?php echo e($category->tag_image); ?>" alt="Tag" style="position: absolute; top: 0; right: 0; max-width: 60px; z-index: 10;">
                                        <?php endif; ?>
                                        <div class="category-img">
                                             <img src="<?php echo e(asset($category->thumbnail)); ?>" alt="<?php echo e($category->name); ?>">
                                        </div>
                                        <div class="category-body" style="display: flex; flex-direction: column;">
                                            <div class="category-name"><?php echo e($category->name); ?></div>
                                            <div class="category-count" style="display:flex;gap:8px;font-size:0.8rem;margin-bottom:15px;">
                                                <span style="color:#64748b;">Còn lại: <?php echo e(number_format($category->allAccount)); ?></span>
                                                <span style="color:#64748b;">| Đã bán: <?php echo e(number_format($category->soldCount)); ?></span>
                                            </div>
                                            <div class="category-cta-wrapper">
                                                <?php if(config_get('site_view_all_image')): ?>
                                                    <img src="<?php echo e(asset(config_get('site_view_all_image'))); ?>" alt="Xem ngay" class="category-cta-img">
                                                <?php else: ?>
                                                    <span class="category-btn-cta">
                                                        <span>Xem ngay</span>
                                                        <i class="fa-solid fa-arrow-right cta-icon"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <section class="section" style="padding-top: 40px;">
            <div class="container">
                <div class="empty-state" style="text-align: center; padding: 80px 20px; width: 100%;">
                    <span class="iconify" data-icon="bx:box" style="font-size: 48px; color: #94a3b8; margin-bottom: 12px; display: inline-block;"></span>
                    <div style="color: #94a3b8; font-size: 0.95rem;">Chưa có tài khoản nào</div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\user\category\show-all.blade.php ENDPATH**/ ?>