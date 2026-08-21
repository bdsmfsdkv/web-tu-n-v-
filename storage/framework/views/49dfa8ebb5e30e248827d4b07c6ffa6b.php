<?php $__env->startSection('title', 'Lịch sử rút vàng/ngọc'); ?>

<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Lịch sử rút vàng/ngọc</h2>
                <p class="text-muted">Xem và quản lý yêu cầu rút vàng/ngọc của người dùng</p>
            
                
            </div>
        </div></div>
</div>
            </div>

            <div class="card overflow-hidden shadow-sm border border-dashed">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="ti ti-gift text-primary me-2"></i>Danh sách yêu cầu
                    </h5>
                </div>
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
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless align-middle mb-0 text-nowrap w-100">
                            <thead class="bg-light-subtle text-muted">
                                <tr>
                                    <th class="text-uppercase small">ID</th>
                                    <th class="text-uppercase small">Người dùng</th>
                                    <th class="text-uppercase small">Loại</th>
                                    <th class="text-uppercase small text-end">Số lượng</th>
                                    <th class="text-uppercase small">Game</th>
                                    <th class="text-uppercase small">Tên nhân vật</th>
                                    <th class="text-uppercase small">Máy chủ</th>
                                    <th class="text-uppercase small">Trạng thái</th>
                                    <th class="text-uppercase small">Thời gian</th>
                                    <th class="text-uppercase small text-end">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><span class="fw-medium">#<?php echo e($withdrawal->order_code); ?></span></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.users.show', $withdrawal->user_id)); ?>" class="fw-bold text-dark text-decoration-none">
                                                <?php echo e($withdrawal->user->username ?? 'N/A'); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <?php if($withdrawal->type === 'gold'): ?>
                                                <span class="badge bg-light-warning text-warning fw-bold px-3 py-2 rounded-pill">Vàng</span>
                                            <?php else: ?>
                                                <span class="badge bg-light-info text-info fw-bold px-3 py-2 rounded-pill">Ngọc</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end fw-bold text-primary"><?php echo e(number_format($withdrawal->amount)); ?></td>
                                        <td><?php echo e($withdrawal->game ?? 'N/A'); ?></td>
                                        <td><span class="text-muted"><?php echo e($withdrawal->character_name); ?></span></td>
                                        <td><span class="text-muted"><?php echo e($withdrawal->server); ?></span></td>
                                        <td>
                                            <?php echo display_status_admin($withdrawal->status); ?>

                                        </td>
                                        <td><span class="text-muted small"><?php echo e($withdrawal->created_at->format('d/m/Y H:i')); ?></span></td>
                                        <td class="text-end">
                                            <?php if($withdrawal->status === 'processing'): ?>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-light-success text-success" data-bs-toggle="modal"
                                                        data-bs-target="#successModal<?php echo e($withdrawal->id); ?>" title="Duyệt">
                                                        <i class="ti ti-check"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-light-danger text-danger" data-bs-toggle="modal"
                                                        data-bs-target="#errorModal<?php echo e($withdrawal->id); ?>" title="Từ chối">
                                                        <i class="ti ti-x"></i>
                                                    </button>
                                                </div>

                                                <!-- Success Modal -->
                                                <div class="modal fade" id="successModal<?php echo e($withdrawal->id); ?>"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content shadow">
                                                            <div class="modal-header border-bottom-0">
                                                                <h5 class="modal-title fw-bold">Xác nhận duyệt rút
                                                                    <?php echo e($withdrawal->type === 'gold' ? 'vàng' : 'ngọc'); ?>

                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="<?php echo e(route('admin.withdrawals.resources.approve', $withdrawal->id)); ?>"
                                                                method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <div class="modal-body">
                                                                    <div class="alert alert-warning mb-3">Bạn có chắc chắn muốn duyệt yêu cầu rút
                                                                        <strong><?php echo e(number_format($withdrawal->amount)); ?></strong>
                                                                        <?php echo e($withdrawal->type === 'gold' ? 'vàng' : 'ngọc'); ?>

                                                                        này?</div>
                                                                    <div class="mb-3 text-start">
                                                                        <label class="form-label fw-bold text-muted small uppercase" for="admin_note">Ghi chú (Tùy chọn):</label>
                                                                        <textarea class="form-control" id="admin_note" name="admin_note" rows="3" placeholder="Nhập ghi chú (nếu có)"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer border-top-0">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Hủy</button>
                                                                    <button type="submit"
                                                                        class="btn btn-success">Duyệt</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Error Modal -->
                                                <div class="modal fade" id="errorModal<?php echo e($withdrawal->id); ?>" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content shadow">
                                                            <div class="modal-header border-bottom-0">
                                                                <h5 class="modal-title fw-bold">Xác nhận từ chối rút
                                                                    <?php echo e($withdrawal->type === 'gold' ? 'vàng' : 'ngọc'); ?>

                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="<?php echo e(route('admin.withdrawals.resources.reject', $withdrawal->id)); ?>"
                                                                method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <div class="modal-body">
                                                                    <div class="alert alert-danger mb-3">Bạn có chắc chắn muốn từ chối yêu cầu rút
                                                                        <strong><?php echo e(number_format($withdrawal->amount)); ?></strong>
                                                                        <?php echo e($withdrawal->type === 'gold' ? 'vàng' : 'ngọc'); ?>

                                                                        này?</div>
                                                                    <p class="text-danger small mb-3"><i class="ti ti-info-circle"></i> <strong>Lưu ý:</strong>
                                                                        <?php echo e($withdrawal->type === 'gold' ? 'Vàng' : 'Ngọc'); ?>

                                                                        sẽ được hoàn trả lại cho người dùng.</p>
                                                                    <div class="mb-3 text-start">
                                                                        <label class="form-label fw-bold text-muted small uppercase" for="admin_note">Lý do từ chối:</label>
                                                                        <textarea class="form-control" id="admin_note" name="admin_note" rows="3" placeholder="Nhập lý do từ chối bắt buộc"
                                                                            required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer border-top-0">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Hủy</button>
                                                                    <button type="submit" class="btn btn-danger">Từ
                                                                        chối</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                 <span class="text-muted small">Không có</span>
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

                    <?php if($withdrawals->hasPages()): ?>
                    <div class="pagination-area mt-4 d-flex justify-content-center">
                        <?php echo e($withdrawals->links('pagination::bootstrap-5')); ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\admin\history\resource-withdrawal-history.blade.php ENDPATH**/ ?>