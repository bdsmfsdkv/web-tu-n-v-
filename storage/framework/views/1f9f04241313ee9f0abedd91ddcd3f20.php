<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-block mb-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo e($title); ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="<?php echo e(route('admin.usdt-accounts.create')); ?>" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Thêm tài khoản
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mạng lưới</th>
                                <th>Tên hiển thị</th>
                                <th>Địa chỉ ví</th>
                                <th>API Token (Spay5s)</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($account->id); ?></td>
                                    <td>
                                        <?php if($account->type == 'binance'): ?>
                                            <span class="badge bg-warning text-dark"><i class="fa-brands fa-usps"></i> Binance Pay</span>
                                        <?php else: ?>
                                            <span class="badge bg-info"><i class="fa-brands fa-usps"></i> TRC20</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($account->name); ?></td>
                                    <td><?php echo e($account->wallet_address); ?></td>
                                    <td>
                                        <small class="text-muted" title="<?php echo e($account->api_token); ?>"><?php echo e(Str::limit($account->api_token, 15)); ?></small>
                                    </td>
                                    <td>
                                        <?php if($account->is_active): ?>
                                            <span class="badge bg-success">Hoạt động</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Bảo trì</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.usdt-accounts.edit', $account->id)); ?>" class="btn btn-sm btn-info text-white">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.usdt-accounts.destroy', $account->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger text-white">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">Chưa có tài khoản USDT nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($accounts->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($accounts->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/admin/usdt-accounts/index.blade.php ENDPATH**/ ?>