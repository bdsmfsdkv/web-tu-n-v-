

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-history me-2"></i> LỊCH SỬ RÚT TIỀN</h1>
                </div>

                <div class="profile-content">
                    <?php echo $__env->make('layouts.user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> SỐ DƯ HIỆN TẠI:
                                        <?php echo e(number_format(auth()->user()->balance)); ?> VND</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <?php if(session('error')): ?>
                                    <div class="alert alert-danger">
                                        <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo e(session('error')); ?>

                                    </div>
                                <?php endif; ?>

                                <?php if(session('success')): ?>
                                    <div class="alert alert-success">
                                        <i class="fa-solid fa-circle-check me-2"></i> <?php echo e(session('success')); ?>

                                    </div>
                                <?php endif; ?>

                                <div class="transaction-history">
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Số tiền</th>
                                                    <th>Ghi chú</th>
                                                    <th>Phản hồi admin</th>
                                                    <th>Trạng thái</th>
                                                    <th>Thời gian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(count($withdrawals) > 0): ?>
                                                    <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($withdrawal->id); ?></td>
                                                            <td class="text-danger"><?php echo e(number_format($withdrawal->amount)); ?>

                                                                VND</td>
                                                            <td><?php echo e($withdrawal->user_note ?? 'Không có'); ?></td>
                                                            <td><?php echo e($withdrawal->admin_note ?? 'Chưa có phản hồi'); ?></td>
                                                            <td>
                                                                <?php if($withdrawal->status === 'processing'): ?>
                                                                    <span class="badge bg-warning">Đang xử lý</span>
                                                                <?php elseif($withdrawal->status === 'success'): ?>
                                                                    <span class="badge bg-success">Thành công</span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-danger">Thất bại</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?php echo e($withdrawal->created_at->format('d/m/Y H:i:s')); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="no-data">Không có dữ liệu</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="pagination">
                                        <?php echo e($withdrawals->links('user.pagination.custom')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\user\profile\withdrawal-history.blade.php ENDPATH**/ ?>