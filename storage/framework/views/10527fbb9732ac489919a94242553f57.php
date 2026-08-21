<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-block mb-3">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo e($title); ?></h2>
                            <p class="text-muted">Lịch sử nạp tiền tự động qua cổng USDT</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <form action="<?php echo e(route('admin.history.deposits.usdt')); ?>" method="GET" class="row gx-2 gy-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Tìm theo tên đăng nhập hoặc mã yêu cầu..." value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-2"></i>Tìm kiếm</button>
                    </div>
                    <?php if(request('search')): ?>
                        <div class="col-md-2">
                            <a href="<?php echo e(route('admin.history.deposits.usdt')); ?>" class="btn btn-light w-100"><i class="ti ti-refresh me-2"></i>Làm mới</a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã Yêu Cầu</th>
                                <th>Người Dùng</th>
                                <th>Số Lượng USDT</th>
                                <th>Quy đổi VND</th>
                                <th>Mã GD (TxID)</th>
                                <th>Trạng Thái</th>
                                <th>Thời Gian Nạp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-light-primary text-primary"><?php echo e($deposit->request_code); ?></span>
                                    </td>
                                    <td>
                                        <?php if($deposit->user): ?>
                                            <a href="<?php echo e(route('admin.users.show', $deposit->user->id)); ?>" class="fw-bold"><?php echo e($deposit->user->username); ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">Không xác định</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong class="text-success"><?php echo e(number_format($deposit->usdt_amount, 2)); ?> USDT</strong>
                                        <br>
                                        <small class="text-muted">Tỷ giá: <?php echo e(number_format($deposit->exchange_rate)); ?></small>
                                    </td>
                                    <td>
                                        <strong class="text-danger"><?php echo e(number_format($deposit->vnd_amount)); ?> VND</strong>
                                    </td>
                                    <td>
                                        <?php if($deposit->transaction_id): ?>
                                            <small class="text-muted" title="<?php echo e($deposit->transaction_id); ?>">
                                                <?php echo e(Str::limit($deposit->transaction_id, 15)); ?>

                                            </small>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($deposit->status === 'completed'): ?>
                                            <span class="badge bg-success">Thành công</span>
                                        <?php elseif($deposit->status === 'pending'): ?>
                                            <span class="badge bg-warning text-dark">Đang chờ</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Thất bại/Hủy</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($deposit->created_at->format('d/m/Y H:i:s')); ?>

                                        <?php if($deposit->status === 'completed'): ?>
                                            <br>
                                            <small class="text-success"><i class="ti ti-check"></i> <?php echo e($deposit->updated_at->format('H:i:s')); ?></small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">Không tìm thấy dữ liệu lịch sử nạp USDT.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($deposits->hasPages()): ?>
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <?php echo e($deposits->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\admin\history\usdt-deposits.blade.php ENDPATH**/ ?>