<?php $__env->startSection('title', 'Quản lý mua trả góp'); ?>
<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">DANH SÁCH MUA TRẢ GÓP</h2>
                <p class="text-muted">Quản lý các hợp đồng mua trả góp tài khoản game</p>
            
                <?php
                    // Find the paginator variable
                    $paginator = null;
                    foreach(get_defined_vars() as $var) {
                        if (is_object($var) && method_exists($var, 'hasPages')) {
                            $paginator = $var;
                            break;
                        }
                    }
                ?>
                <?php if($paginator && $paginator->hasPages()): ?>
                    <div class="d-flex justify-content-end p-3 border-top">
                        <?php echo e($paginator->withQueryString()->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div></div>
</div>
            </div>
            <?php if(session('success')): ?>
                <?php if (isset($component)) { $__componentOriginaldb3b56596ae08e65d7cddff31f5007cb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb = $attributes; } ?>
<?php $component = App\View\Components\AlertAdmin::resolve(['type' => 'success','message' => session('success')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('alert-admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AlertAdmin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb)): ?>
<?php $attributes = $__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb; ?>
<?php unset($__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldb3b56596ae08e65d7cddff31f5007cb)): ?>
<?php $component = $__componentOriginaldb3b56596ae08e65d7cddff31f5007cb; ?>
<?php unset($__componentOriginaldb3b56596ae08e65d7cddff31f5007cb); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <?php if (isset($component)) { $__componentOriginaldb3b56596ae08e65d7cddff31f5007cb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb = $attributes; } ?>
<?php $component = App\View\Components\AlertAdmin::resolve(['type' => 'danger','message' => session('error')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('alert-admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AlertAdmin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb)): ?>
<?php $attributes = $__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb; ?>
<?php unset($__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldb3b56596ae08e65d7cddff31f5007cb)): ?>
<?php $component = $__componentOriginaldb3b56596ae08e65d7cddff31f5007cb; ?>
<?php unset($__componentOriginaldb3b56596ae08e65d7cddff31f5007cb); ?>
<?php endif; ?>
            <?php endif; ?>
            <div class="card overflow-hidden shadow-sm border border-dashed">
                <div class="card-body px-0 py-0">
                <form class="p-3 bg-auto-subtle border-bottom filter-form" method="GET">
                    <div class="row align-items-center g-2">
                        <div class="col-md-2">
                            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">--Hiển thị--</option>
                                <option value="10" <?php echo e(request('per_page') == 10 ? 'selected' : ''); ?>>10</option>
                                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-3 d-flex gap-2 ms-auto">
                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                <i class="ti ti-search me-1"></i> Tìm kiếm
                            </button>
                            <a href="?" class="btn btn-sm btn-light-danger w-100">
                                <i class="ti ti-trash me-1"></i> Bỏ lọc
                            </a>
                        </div>
                    </div>
                </form>
                    <div class="table-responsive table-border-style">
                        <table class="table table-hover table-borderless align-middle mb-0 text-nowrap w-100">
                            <thead class="bg-light-subtle text-muted">
                                <tr>
                                    <th class="text-uppercase small">ID HĐ</th>
                                    <th class="text-uppercase small">Khách hàng</th>
                                    <th class="text-uppercase small">Tài khoản</th>
                                    <th class="text-uppercase small">Tổng giá</th>
                                    <th class="text-uppercase small">Đã trả</th>
                                    <th class="text-uppercase small">Còn nợ</th>
                                    <th class="text-uppercase small">Hạn chót</th>
                                    <th class="text-uppercase small">Trạng thái</th>
                                    <th class="text-uppercase small">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $installment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $remaining = $installment->total_price - $installment->paid_amount;
                                        $isOverdue = $installment->expire_date < now() && $installment->status == 'active';
                                        
                                        $statusClass = 'bg-info';
                                        $statusText = 'Đang trả góp';
                                        if($installment->status == 'completed') {
                                            $statusClass = 'bg-success';
                                            $statusText = 'Hoàn thành';
                                        } elseif($installment->status == 'cancelled') {
                                            $statusClass = 'bg-danger';
                                            $statusText = 'Đã hủy';
                                        } elseif($isOverdue) {
                                            $statusClass = 'bg-warning';
                                            $statusText = 'Quá hạn';
                                        }
                                    ?>
                                    <tr>
                                        <td>#<?php echo e($installment->id); ?></td>
                                        <td>
                                            <strong><?php echo e($installment->user->username ?? 'Unknown'); ?></strong><br>
                                            <small><?php echo e($installment->user->email ?? ''); ?></small>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('account.show', $installment->game_account_id)); ?>" target="_blank">Nick #<?php echo e($installment->game_account_id); ?></a><br>
                                            <small><?php echo e($installment->gameAccount->category->name ?? ''); ?></small>
                                        </td>
                                        <td class="text-bolds"><?php echo e(number_format($installment->total_price)); ?>đ</td>
                                        <td style="color: #10b981; font-weight: bold;"><?php echo e(number_format($installment->paid_amount)); ?>đ</td>
                                        <td style="color: #ef4444; font-weight: bold;"><?php echo e(number_format($remaining)); ?>đ</td>
                                        <td>
                                            <?php echo e($installment->expire_date->format('d/m/Y H:i')); ?>

                                        </td>
                                        <td>
                                            <span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusText); ?></span>
                                        </td>
                                        <td>
                                            <?php if($installment->status === 'active'): ?>
                                                <form action="<?php echo e(route('admin.installments.cancel', $installment->id)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn hủy hợp đồng này và mở bán lại nick không?');">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hủy hợp đồng">
                                                        <i class="ti ti-trash fs-5 text-danger"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="100%">
                                            <div class="text-center py-5">
                                                <svg style="width: 184px; height: 152px;" viewBox="0 0 184 152" xmlns="http://www.w3.org/2000/svg">
                                                    <g fill="none" fill-rule="evenodd">
                                                        <g transform="translate(24 31.67)">
                                                            <ellipse fill-opacity=".8" fill="#F5F5F7" cx="67.797" cy="106.89" rx="67.797" ry="12.668"></ellipse>
                                                            <path d="M122.034 69.674L98.109 40.229c-1.148-1.386-2.826-2.225-4.593-2.225h-51.44c-1.766 0-3.444.839-4.592 2.225L13.56 69.674v15.383h108.475V69.674z" fill="#AEB8C2"></path>
                                                            <path d="M33.83 0h67.933a4 4 0 0 1 4 4v93.344a4 4 0 0 1-4 4H33.83a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4z" fill="#F5F5F7"></path>
                                                            <path d="M42.678 9.953h50.237a2 2 0 0 1 2 2V36.91a2 2 0 0 1-2 2H42.678a2 2 0 0 1-2-2V11.953a2 2 0 0 1 2-2zM42.94 49.767h49.713a2.262 2.262 0 1 1 0 4.524H42.94a2.262 2.262 0 0 1 0-4.524zM42.94 61.53h49.713a2.262 2.262 0 1 1 0 4.525H42.94a2.262 2.262 0 0 1 0-4.525zM121.813 105.032c-.775 3.071-3.497 5.36-6.735 5.36H20.515c-3.238 0-5.96-2.29-6.734-5.36a7.309 7.309 0 0 1-.222-1.79V69.675h26.318c2.907 0 5.25 2.448 5.25 5.42v.04c0 2.971 2.37 5.37 5.277 5.37h34.785c2.907 0 5.277-2.421 5.277-5.393V75.1c0-2.972 2.343-5.426 5.25-5.426h26.318v33.569c0 .617-.077 1.216-.221 1.789z" fill="#DCE0E6"></path>
                                                        </g>
                                                        <path d="M149.121 33.292l-6.83 2.65a1 1 0 0 1-1.317-1.23l1.937-6.207c-2.589-2.944-4.109-6.534-4.109-10.408C138.802 8.102 148.92 0 161.402 0 173.881 0 184 8.102 184 18.097c0 9.995-10.118 18.097-22.599 18.097-4.528 0-8.744-1.066-12.28-2.902z" fill="#DCE0E6"></path>
                                                    </g>
                                                </svg>
                                                <p class="mt-3 text-muted">Không tìm thấy dữ liệu</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 20px;">
                        <?php echo e($installments->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\admin\installments\index.blade.php ENDPATH**/ ?>