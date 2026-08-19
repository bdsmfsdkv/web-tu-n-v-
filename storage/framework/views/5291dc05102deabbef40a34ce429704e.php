<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-1">Tiếp thị liên kết (Hoa hồng)</h5>
                    <p class="text-muted mb-0">Lịch sử trả thưởng hoa hồng cho người giới thiệu.</p>
                </div>
                <div class="text-end">
                    <h4 class="text-success mb-0">+<?php echo e(number_format($totalCommissionPaid)); ?> đ</h4>
                    <p class="text-muted mb-0">Tổng tiền đã chi</p>
                
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
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0 text-nowrap w-100">
                        <thead class="bg-light-subtle text-muted">
                            <tr>
                                <th>#</th>
                                <th>Thời gian</th>
                                <th>Người nhận (Referrer)</th>
                                <th>Người nạp (Referred)</th>
                                <th>Loại</th>
                                <th>Số tiền</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($history->id); ?></td>
                                    <td><?php echo e($history->created_at->format('d/m/Y H:i:s')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.users.show', $history->referrer_id)); ?>">
                                            <span class="badge bg-primary"><?php echo e($history->referrer->username ?? 'Unknown'); ?></span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.users.show', $history->referred_id)); ?>">
                                            <span class="badge bg-info"><?php echo e($history->referred->username ?? 'Unknown'); ?></span>
                                        </a>
                                    </td>
                                    <td><span class="badge bg-secondary"><?php echo e(ucfirst($history->type)); ?></span></td>
                                    <td><strong class="text-success">+<?php echo e(number_format($history->commission_amount)); ?>đ</strong></td>
                                    <td><?php echo e($history->description); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Chưa có lịch sử nhận hoa hồng nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <?php echo e($histories->links('pagination::bootstrap-5')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\admin\affiliates\index.blade.php ENDPATH**/ ?>