<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Lịch sử vòng quay may mắn</h2>
                <p class="text-muted">Xem lịch sử quay vòng quay của người dùng</p>
            
                
            </div>
        </div></div>
</div>
                <div class="page-btn">
                    <a href="<?php echo e(route('admin.lucky-wheels.index')); ?>" class="btn btn-success">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-border-style">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="text-muted small">ID</th>
                                    <th class="text-muted small">Người dùng</th>
                                    <th class="text-muted small">Vòng quay</th>
                                    <th class="text-muted small">Số lượt</th>
                                    <th class="text-muted small">Tổng chi phí</th>
                                    <th class="text-muted small">Loại giải thưởng</th>
                                    <th class="text-muted small">Số lượng trúng</th>
                                    <th class="text-muted small">Mô tả</th>
                                    <th class="text-muted small">Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($item->id); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.users.show', $item->user_id)); ?>">
                                                <?php echo e($item->user->username ?? 'N/A'); ?>

                                            </a>
                                        </td>
                                        <td><?php echo e($item->luckyWheel->name ?? 'N/A'); ?></td>
                                        <td><?php echo e($item->spin_count); ?></td>
                                        <td><?php echo e(number_format($item->total_cost)); ?> VNĐ</td>
                                        <td>
                                            <?php if($item->reward_type == 'gold'): ?>
                                                <span class="badge bg-warning">Vàng</span>
                                            <?php else: ?>
                                                <span class="badge bg-info">Ngọc</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(number_format($item->reward_amount)); ?></td>
                                        <td><?php echo e($item->description); ?></td>
                                        <td><?php echo e($item->created_at->format('d/m/Y H:i')); ?></td>
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
                        <?php echo e($paginator->withQueryString()->links('pagination::bootstrap-5')); ?>

                    </div>
                <?php endif; ?>

                    <div class="pagination-section">
                        <?php echo e($history->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\admin\lucky-wheels\history.blade.php ENDPATH**/ ?>