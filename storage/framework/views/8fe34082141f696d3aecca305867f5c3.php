<?php $__env->startSection('title', 'Trang quản trị'); ?>
<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Admin Dashboard</h2>
                                <p class="text-muted">Thống kê tổng quan hệ thống</p>
                            
                
            </div>
        </div></div>
                </div>
            </div>

            <?php if(isset($error)): ?>
                <div class="alert alert-danger">
                    <strong>Lỗi!</strong> Đã xảy ra lỗi khi tải dữ liệu dashboard. Vui lòng thông báo cho quản trị viên.
                    <?php if(config('app.debug')): ?>
                        <p><?php echo e($error); ?></p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                            <!-- Comparison Block -->
            <div class="card border border-dashed shadow-sm mb-4">
                <div class="card-header border-bottom-0 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-scale text-primary me-2"></i>So sánh 2 kỳ</h5>
                    <a href="?period_a=today&period_b=yesterday" class="btn btn-sm btn-info text-white">Hôm nay vs Hôm qua</a>
                </div>
                <div class="card-body">
                    <form method="GET" class="row align-items-end mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Kỳ A</label>
                            <select name="period_a" class="form-select form-select-sm">
                                <option value="today" <?php echo e($comparison['period_a'] == 'today' ? 'selected' : ''); ?>>Hôm nay</option>
                                <option value="yesterday" <?php echo e($comparison['period_a'] == 'yesterday' ? 'selected' : ''); ?>>Hôm qua</option>
                                <option value="this_week" <?php echo e($comparison['period_a'] == 'this_week' ? 'selected' : ''); ?>>Tuần này</option>
                                <option value="last_week" <?php echo e($comparison['period_a'] == 'last_week' ? 'selected' : ''); ?>>Tuần trước</option>
                                <option value="this_month" <?php echo e($comparison['period_a'] == 'this_month' ? 'selected' : ''); ?>>Tháng này</option>
                                <option value="last_month" <?php echo e($comparison['period_a'] == 'last_month' ? 'selected' : ''); ?>>Tháng trước</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Kỳ B (so với)</label>
                            <select name="period_b" class="form-select form-select-sm">
                                <option value="yesterday" <?php echo e($comparison['period_b'] == 'yesterday' ? 'selected' : ''); ?>>Hôm qua</option>
                                <option value="today" <?php echo e($comparison['period_b'] == 'today' ? 'selected' : ''); ?>>Hôm nay</option>
                                <option value="last_week" <?php echo e($comparison['period_b'] == 'last_week' ? 'selected' : ''); ?>>Tuần trước</option>
                                <option value="this_week" <?php echo e($comparison['period_b'] == 'this_week' ? 'selected' : ''); ?>>Tuần này</option>
                                <option value="last_month" <?php echo e($comparison['period_b'] == 'last_month' ? 'selected' : ''); ?>>Tháng trước</option>
                                <option value="this_month" <?php echo e($comparison['period_b'] == 'this_month' ? 'selected' : ''); ?>>Tháng này</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-sm btn-warning w-100 text-white fw-bold"><i class="ti ti-scale me-1"></i> So sánh</button>
                        </div>
                    </form>

                    <div class="d-flex gap-2 mb-3 flex-wrap">
                        <a href="?period_a=today&period_b=yesterday" class="btn btn-xs <?php echo e($comparison['period_a'] == 'today' && $comparison['period_b'] == 'yesterday' ? 'btn-warning text-white' : 'btn-outline-secondary'); ?>">Hôm nay / Hôm qua</a>
                        <a href="?period_a=this_week&period_b=last_week" class="btn btn-xs <?php echo e($comparison['period_a'] == 'this_week' && $comparison['period_b'] == 'last_week' ? 'btn-warning text-white' : 'btn-outline-secondary'); ?>">Tuần này / Tuần trước</a>
                        <a href="?period_a=this_month&period_b=last_month" class="btn btn-xs <?php echo e($comparison['period_a'] == 'this_month' && $comparison['period_b'] == 'last_month' ? 'btn-warning text-white' : 'btn-outline-secondary'); ?>">Tháng này / Tháng trước</a>
                    </div>

                    <?php if($comparison['a']['revenue'] >= $comparison['b']['revenue']): ?>
                    <div class="alert alert-success border-start border-success border-4 py-2 px-3 mb-3" style="background-color: rgba(40, 167, 69, 0.1);">
                        <span class="fw-semibold text-success">Doanh thu Kỳ A đang cao hơn hoặc bằng Kỳ B. Giữ phong độ nhé!</span>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-danger border-start border-danger border-4 py-2 px-3 mb-3" style="background-color: rgba(220, 53, 69, 0.1);">
                        <span class="fw-semibold text-danger">Doanh thu Kỳ A đang thấp hơn Kỳ B. Cố lên nhé!</span>
                    </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless align-middle text-nowrap w-100">
                            <thead>
                                <tr class="border-bottom">
                                    <th class="fw-bold">Chỉ số</th>
                                    <th class="fw-bold text-center">Kỳ A</th>
                                    <th class="fw-bold text-center">Kỳ B</th>
                                    <th class="fw-bold text-end">Chênh lệch</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $metrics = [
                                        ['key' => 'revenue', 'name' => 'Doanh thu', 'format' => 'money'],
                                        ['key' => 'profit', 'name' => 'Lợi nhuận', 'format' => 'money'],
                                        ['key' => 'orders_count', 'name' => 'Số đơn', 'format' => 'number'],
                                        ['key' => 'avg_order_value', 'name' => 'Giá trị đơn TB', 'format' => 'money'],
                                        ['key' => 'deposits', 'name' => 'Nạp tiền', 'format' => 'money'],
                                        ['key' => 'new_members', 'name' => 'Thành viên mới', 'format' => 'number'],
                                    ];
                                ?>

                                <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $valA = $comparison['a'][$m['key']];
                                    $valB = $comparison['b'][$m['key']];
                                    $diff = $comparison['diff'][$m['key']];
                                    $isPos = $valA >= $valB;
                                    $color = $isPos ? 'text-success' : 'text-danger';
                                    $icon = $isPos ? 'ti-caret-up' : 'ti-caret-down';
                                    $sign = $isPos ? '+' : '';
                                    
                                    $strA = $m['format'] == 'money' ? number_format($valA, 0, ',', '.') . 'đ' : number_format($valA);
                                    $strB = $m['format'] == 'money' ? number_format($valB, 0, ',', '.') . 'đ' : number_format($valB);
                                    $strDiff = $m['format'] == 'money' ? $sign . number_format($valA - $valB, 0, ',', '.') . 'đ' : $sign . number_format($valA - $valB);
                                ?>
                                <tr class="border-bottom border-light">
                                    <td class="text-muted"><?php echo e($m['name']); ?></td>
                                    <td class="text-center"><?php echo e($strA); ?></td>
                                    <td class="text-center"><?php echo e($strB); ?></td>
                                    <td class="text-end fw-bold <?php echo e($color); ?>">
                                        <i class="ti <?php echo e($icon); ?> me-1"></i><?php echo e($strDiff); ?> (<?php echo e($sign); ?><?php echo e($diff); ?>%)
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                </div>
            </div>

            <!-- Summary Cards Row -->
            <div class="row g-3 mb-4">
                <!-- Tài khoản game -->
                <div class="col-md-3">
                    <div class="card border border-dashed shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold"><i class="ti ti-device-gamepad text-primary me-2"></i>Tài khoản game</h6>
                                <span class="badge bg-info">Tổng</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Đã bán trong kỳ</span>
                                <span class="fw-bold"><?php echo e(number_format($comparison['a']['acc_sold'])); ?> tài khoản</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Doanh thu</span>
                                <span class="fw-bold text-success"><?php echo e(number_format($comparison['a']['acc_revenue'], 0, ',', '.')); ?>đ</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Kho còn lại</span>
                                <span class="fw-bold text-primary"><?php echo e(number_format($comparison['a']['acc_stock'])); ?> tài khoản</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Vật phẩm & Vòng quay -->
                <div class="col-md-3">
                    <div class="card border border-dashed shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold"><i class="ti ti-layout-grid-add text-warning me-2"></i>Vật phẩm & Vòng quay</h6>
                                <span class="badge bg-warning">~<?php echo e($comparison['diff']['wheel_revenue'] > 0 ? '+' : ''); ?><?php echo e($comparison['diff']['wheel_revenue']); ?>%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Lượt trong kỳ</span>
                                <span class="fw-bold"><?php echo e(number_format($comparison['a']['wheel_spins'])); ?> lượt</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Doanh thu</span>
                                <span class="fw-bold text-success"><?php echo e(number_format($comparison['a']['wheel_revenue'], 0, ',', '.')); ?>đ</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Vòng quay hiện có</span>
                                <span class="fw-bold text-warning"><?php echo e(number_format($comparison['a']['wheels_count'])); ?> vòng</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dịch vụ cày thuê -->
                <div class="col-md-3">
                    <div class="card border border-dashed shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold"><i class="ti ti-hammer text-success me-2"></i>Dịch vụ cày thuê</h6>
                                <span class="badge bg-success">~<?php echo e($comparison['diff']['service_revenue'] > 0 ? '+' : ''); ?><?php echo e($comparison['diff']['service_revenue']); ?>%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Hoàn thành kỳ này</span>
                                <span class="fw-bold"><?php echo e(number_format($comparison['a']['service_completed'])); ?> đơn</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Doanh thu</span>
                                <span class="fw-bold text-success"><?php echo e(number_format($comparison['a']['service_revenue'], 0, ',', '.')); ?>đ</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Đang xử lý</span>
                                <span class="fw-bold text-warning"><?php echo e(number_format($comparison['a']['service_processing'])); ?> đơn</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nạp tiền chi tiết -->
                <div class="col-md-3">
                    <div class="card border border-dashed shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold"><i class="ti ti-credit-card text-info me-2"></i>Nạp tiền chi tiết</h6>
                                <span class="badge bg-info">Kỳ A</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Thẻ cào (Kỳ A)</span>
                                <span class="fw-bold"><?php echo e(number_format($comparison['a']['card_deposits'], 0, ',', '.')); ?>đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Thẻ cào (Kỳ B)</span>
                                <span class="fw-bold"><?php echo e(number_format($comparison['b']['card_deposits'], 0, ',', '.')); ?>đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Bank (Kỳ A)</span>
                                <span class="fw-bold"><?php echo e(number_format($comparison['a']['bank_deposits'], 0, ',', '.')); ?>đ</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Bank (Kỳ B)</span>
                                <span class="fw-bold"><?php echo e(number_format($comparison['b']['bank_deposits'], 0, ',', '.')); ?>đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Thống kê tài khoản -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-primary">
                                            <i class="ti ti-device-gamepad-2 f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Tài khoản game</p>
                                        <h5 class="mb-0 fw-bold"><?php echo e(number_format($statistics['accounts']['total'])); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-success">
                                            <i class="ti ti-box f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Chưa bán</p>
                                        <h5 class="mb-0 fw-bold"><?php echo e(number_format($statistics['accounts']['available'])); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-info">
                                            <i class="ti ti-shopping-cart f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Đã bán</p>
                                        <h5 class="mb-0 fw-bold"><?php echo e(number_format($statistics['accounts']['sold'])); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-warning">
                                            <i class="ti ti-users f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Người dùng</p>
                                        <h5 class="mb-0 fw-bold"><?php echo e(number_format($statistics['users']['total'])); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thống kê dịch vụ và danh mục -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-danger">
                                            <i class="ti ti-briefcase f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Dịch vụ</p>
                                        <h5 class="mb-0 fw-bold"><?php echo e(number_format($statistics['services']['total'])); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-secondary">
                                            <i class="ti ti-package f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Acc Random</p>
                                        <h5 class="mb-0 fw-bold"><?php echo e(number_format($statistics['random_accounts']['total'])); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-dark">
                                            <i class="ti ti-refresh f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Vòng quay</p>
                                        <h5 class="mb-0 fw-bold"><?php echo e(number_format($statistics['lucky_wheels']['total'])); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-primary">
                                            <i class="ti ti-user-plus f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Thành viên mới (Hôm nay)</p>
                                        <h5 class="mb-0 fw-bold"><?php echo e(number_format($statistics['users']['new_today'])); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng hợp giao dịch -->
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-success">
                                            <i class="ti ti-arrow-down f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Tổng nạp tiền</p>
                                        <h5 class="mb-0 fw-bold text-success"><span class="counters"><?php echo e(number_format($transactionSummary['total_deposit'])); ?></span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-danger">
                                            <i class="ti ti-arrow-up f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Tổng rút tiền</p>
                                        <h5 class="mb-0 fw-bold text-danger"><span class="counters"><?php echo e(number_format($transactionSummary['total_withdraw'])); ?></span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-info">
                                            <i class="ti ti-shopping-cart f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Tổng mua hàng</p>
                                        <h5 class="mb-0 fw-bold text-info"><span class="counters"><?php echo e(number_format($transactionSummary['total_purchase'])); ?></span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-warning">
                                            <i class="ti ti-arrow-back f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Tổng hoàn tiền</p>
                                        <h5 class="mb-0 fw-bold text-warning"><span class="counters"><?php echo e(number_format($transactionSummary['total_refund'])); ?></span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-primary">
                                            <i class="ti ti-wallet f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Tổng doanh thu</p>
                                        <h5 class="mb-0 fw-bold text-primary"><span class="counters"><?php echo e(number_format(abs($transactionSummary['total_purchase']))); ?></span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card border border-dashed shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s btn-light-secondary">
                                            <i class="ti ti-basket f-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Tổng acc đã bán</p>
                                        <h5 class="mb-0 fw-bold"><span class="counters"><?php echo e(number_format($statistics['accounts']['sold'] + ($statistics['random_accounts']['sold'] ?? 0))); ?></span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phân bố loại dịch vụ và Các tài khoản mua gần đây -->
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3 d-flex">
                        <div class="card flex-fill border border-dashed shadow-sm">
                            <div class="card-header border-bottom bg-transparent">
                                <h5 class="card-title mb-0 border-start border-primary border-3 ps-2">
                                    Loại dịch vụ
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderless mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th class="text-muted small text-uppercase">Loại</th>
                                                <th class="text-muted small text-uppercase text-end">Số lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $servicesByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td>
                                                        <?php if($serviceType->type == 'gold'): ?>
                                                            <div class="d-flex align-items-center">
                                                                <span class="p-2 bg-light-warning rounded me-2"><i class="ti ti-coin text-warning"></i></span>
                                                                <span class="fw-medium">Bán vàng</span>
                                                            </div>
                                                        <?php elseif($serviceType->type == 'gem'): ?>
                                                            <div class="d-flex align-items-center">
                                                                <span class="p-2 bg-light-info rounded me-2"><i class="ti ti-diamond text-info"></i></span>
                                                                <span class="fw-medium">Bán ngọc</span>
                                                            </div>
                                                        <?php elseif($serviceType->type == 'leveling'): ?>
                                                            <div class="d-flex align-items-center">
                                                                <span class="p-2 bg-light-success rounded me-2"><i class="ti ti-trending-up text-success"></i></span>
                                                                <span class="fw-medium">Cày thuê</span>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="d-flex align-items-center">
                                                                <span class="p-2 bg-light-secondary rounded me-2"><i class="ti ti-category text-secondary"></i></span>
                                                                <span class="fw-medium text-capitalize"><?php echo e($serviceType->type); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-end align-middle">
                                                        <span class="badge bg-light-primary text-primary px-3 py-2 fs-6 rounded-pill"><?php echo e(number_format($serviceType->total)); ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-4">Chưa có dữ liệu dịch vụ</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-3 d-flex">
                        <div class="card flex-fill border border-dashed shadow-sm">
                            <div class="card-header border-bottom bg-transparent">
                                <h5 class="card-title mb-0 border-start border-success border-3 ps-2">
                                    Mã giảm giá đang hoạt động
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderless mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th class="text-muted small text-uppercase">Mã</th>
                                                <th class="text-muted small text-uppercase text-end">Giá trị</th>
                                                <th class="text-muted small text-uppercase text-end">Hạn dùng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $activeDiscountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="p-1 bg-light-success rounded me-2"><i class="ti ti-ticket text-success"></i></span>
                                                            <span class="fw-bold text-success"><?php echo e($code->code); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="text-end align-middle fw-medium">
                                                        <?php if($code->discount_type == 'percentage'): ?>
                                                            <?php echo e($code->discount_value); ?>%
                                                        <?php else: ?>
                                                            <?php echo e(number_format($code->discount_value)); ?> đ
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-end align-middle text-muted small">
                                                        <?php echo e($code->expire_date ? $code->expire_date->format('d/m/Y') : 'Không hạn'); ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted py-4">Không có mã giảm giá nào đang hoạt động</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 mb-3 d-flex">
                        <div class="card flex-fill border border-dashed shadow-sm">
                            <div class="card-header border-bottom bg-transparent">
                                <h5 class="card-title mb-0 border-start border-info border-3 ps-2">
                                    Thống kê người dùng
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="stats-list">
                                    <div class="stats-info mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="mb-0 fw-medium">Admin</p>
                                            <span class="badge bg-light-info text-info rounded-pill px-3"><?php echo e(number_format($statistics['users']['admin'])); ?></span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-info rounded-pill" role="progressbar"
                                                style="width: <?php echo e($statistics['users']['total'] > 0 ? ($statistics['users']['admin'] / $statistics['users']['total']) * 100 : 0); ?>%"
                                                aria-valuenow="<?php echo e($statistics['users']['admin']); ?>" aria-valuemin="0"
                                                aria-valuemax="<?php echo e($statistics['users']['total']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats-info mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="mb-0 fw-medium">Khách hàng</p>
                                            <span class="badge bg-light-success text-success rounded-pill px-3"><?php echo e(number_format($statistics['users']['user'])); ?></span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success rounded-pill" role="progressbar"
                                                style="width: <?php echo e($statistics['users']['total'] > 0 ? ($statistics['users']['user'] / $statistics['users']['total']) * 100 : 0); ?>%"
                                                aria-valuenow="<?php echo e($statistics['users']['user']); ?>" aria-valuemin="0"
                                                aria-valuemax="<?php echo e($statistics['users']['total']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats-info border-top pt-3 mt-2">
                                        <p class="text-muted small mb-2 text-uppercase fw-semibold">Người dùng mới</p>
                                        <div class="row g-2 text-center">
                                            <div class="col-4">
                                                <div class="p-2 border rounded bg-light-subtle">
                                                    <small class="text-muted d-block mb-1">Hôm nay</small>
                                                    <span class="badge bg-primary px-2"><?php echo e(number_format($statistics['users']['new_today'])); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-2 border rounded bg-light-subtle">
                                                    <small class="text-muted d-block mb-1">Tuần này</small>
                                                    <span class="badge bg-info px-2"><?php echo e(number_format($statistics['users']['new_this_week'])); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-2 border rounded bg-light-subtle">
                                                    <small class="text-muted d-block mb-1">Tháng này</small>
                                                    <span class="badge bg-success px-2"><?php echo e(number_format($statistics['users']['new_this_month'])); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Giao dịch gần đây -->
                <div class="card mb-4 border border-dashed shadow-sm">
                    <div class="card-header border-bottom bg-transparent">
                        <h5 class="card-title mb-0 border-start border-primary border-3 ps-2">
                            Lịch sử giao dịch gần đây
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless align-middle mb-0">
                                <thead class="bg-light-subtle text-muted">
                                    <tr>
                                        <th class="text-uppercase small ps-3">ID</th>
                                        <th class="text-uppercase small">Người dùng</th>
                                        <th class="text-uppercase small">Loại giao dịch</th>
                                        <th class="text-uppercase small">Số tiền</th>
                                        <th class="text-uppercase small">Số dư trước</th>
                                        <th class="text-uppercase small">Số dư sau</th>
                                        <th class="text-uppercase small">Mô tả</th>
                                        <th class="text-uppercase small pe-3 text-end">Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="ps-3"><span class="text-muted">#<?php echo e($transaction->order_code); ?></span></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar avtar-xs bg-light-primary text-primary me-2 rounded-circle">
                                                        <?php echo e(strtoupper(substr($transaction->user->username ?? 'U', 0, 1))); ?>

                                                    </div>
                                                    <a href="<?php echo e(route('admin.users.show', ['id' => $transaction->user->id])); ?>" class="text-primary fw-medium text-decoration-none">
                                                        <?php echo e($transaction->user->username ?? 'N/A'); ?>

                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($transaction->type == 'deposit'): ?>
                                                    <span class="badge bg-light-success text-success border border-success border-opacity-25 px-2 py-1"><i class="ti ti-arrow-down me-1"></i> Nạp tiền</span>
                                                <?php elseif($transaction->type == 'withdraw'): ?>
                                                    <span class="badge bg-light-danger text-danger border border-danger border-opacity-25 px-2 py-1"><i class="ti ti-arrow-up me-1"></i> Rút tiền</span>
                                                <?php elseif($transaction->type == 'purchase'): ?>
                                                    <span class="badge bg-light-warning text-warning border border-warning border-opacity-25 px-2 py-1"><i class="ti ti-shopping-cart me-1"></i> Mua hàng</span>
                                                <?php elseif($transaction->type == 'refund'): ?>
                                                    <span class="badge bg-light-info text-info border border-info border-opacity-25 px-2 py-1"><i class="ti ti-arrow-back me-1"></i> Hoàn tiền</span>
                                                <?php else: ?>
                                                    <span class="badge bg-light-secondary text-secondary border px-2 py-1"><?php echo e($transaction->type); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="fw-semibold <?php echo e(in_array($transaction->type, ['deposit', 'refund']) ? 'text-success' : 'text-danger'); ?>">
                                                    <?php echo e(in_array($transaction->type, ['deposit', 'refund']) ? '+' : '-'); ?><?php echo e(number_format($transaction->amount)); ?> đ
                                                </span>
                                            </td>
                                            <td><span class="text-muted"><?php echo e(number_format($transaction->balance_before)); ?> đ</span></td>
                                            <td><span class="text-muted"><?php echo e(number_format($transaction->balance_after)); ?> đ</span></td>
                                            <td><span class="text-truncate d-inline-block" style="max-width: 250px;" title="<?php echo e($transaction->description); ?>"><?php echo e($transaction->description ?? 'N/A'); ?></span></td>
                                            <td class="pe-3 text-end"><span class="text-muted small"><?php echo e($transaction->created_at->format('d/m/Y H:i')); ?></span></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">Chưa có giao dịch nào</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ tổng quan & Dịch vụ cần xử lý-->
                <div class="row">
                    <div class="col-lg-7 col-md-12 mb-4 d-flex">
                        <div class="card flex-fill border border-dashed shadow-sm">
                            <div class="card-header border-bottom bg-transparent">
                                <h5 class="card-title mb-0 border-start border-primary border-3 ps-2">
                                    Thống kê nạp tiền & mua hàng (7 ngày gần đây)
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="sales_charts" style="min-height: 300px;"></div>
                                <div class="table-responsive mt-4">
                                    <table class="table table-sm table-bordered table-hover text-center mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th class="text-muted small text-start text-uppercase">Ngày</th>
                                                <?php $__currentLoopData = $last7Days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-muted small"><?php echo e($day['date']); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-start fw-medium"><span class="badge bg-light-success text-success me-2">●</span> Nạp tiền</td>
                                                <?php $__currentLoopData = $last7Days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td class="<?php echo e($day['deposits'] > 0 ? 'fw-semibold text-success' : 'text-muted'); ?>"><?php echo e(number_format($day['deposits'])); ?></td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                            <tr>
                                                <td class="text-start fw-medium"><span class="badge bg-light-primary text-primary me-2">●</span> Mua hàng</td>
                                                <?php $__currentLoopData = $last7Days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td class="<?php echo e($day['purchases'] > 0 ? 'fw-semibold text-primary' : 'text-muted'); ?>"><?php echo e(number_format($day['purchases'])); ?></td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 mb-4 d-flex flex-column gap-3">
                        <div class="card flex-fill border border-dashed shadow-sm mb-0">
                            <div class="card-header border-bottom bg-transparent d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0 border-start border-warning border-3 ps-2">
                                    Dịch vụ đang chờ xử lý
                                </h5>
                                <a href="<?php echo e(route('admin.history.services')); ?>" class="btn btn-sm btn-light-primary rounded-pill px-3">
                                    Xem tất cả
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderless align-middle mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th class="text-uppercase small ps-3">ID</th>
                                                <th class="text-uppercase small">Dịch vụ</th>
                                                <th class="text-uppercase small">Người dùng</th>
                                                <th class="text-uppercase small text-end pe-3">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $pendingServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td class="ps-3"><span class="text-muted">#<?php echo e($service->order_code); ?></span></td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="badge bg-light-danger text-danger border border-danger border-opacity-25 w-max-content mb-1 px-2 py-1"><?php echo e($service->gameService->name ?? 'N/A'); ?></span>
                                                            <span class="small text-muted text-truncate" style="max-width: 150px;" title="<?php echo e($service->servicePackage->name ?? 'N/A'); ?>"><?php echo e($service->servicePackage->name ?? 'N/A'); ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(route('admin.users.show', ['id' => $service->user->id])); ?>" class="text-primary fw-medium text-decoration-none">
                                                            <?php echo e($service->user->username ?? 'N/A'); ?>

                                                        </a>
                                                    </td>
                                                    <td class="text-end pe-3">
                                                        <span class="badge bg-warning"><i class="ti ti-clock me-1"></i>Chờ xử lý</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">Không có dịch vụ nào đang chờ xử lý</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rút tiền đang chờ & Rút tài nguyên đang chờ -->
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4 d-flex">
                        <div class="card flex-fill border border-dashed shadow-sm">
                            <div class="card-header border-bottom bg-transparent d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0 border-start border-danger border-3 ps-2">
                                    Yêu cầu rút tiền đang chờ
                                </h5>
                                <a href="<?php echo e(route('admin.withdrawals.index')); ?>" class="btn btn-sm btn-light-primary rounded-pill px-3">
                                    Xem tất cả
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderless align-middle mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th class="text-uppercase small ps-3">ID</th>
                                                <th class="text-uppercase small">Người dùng</th>
                                                <th class="text-uppercase small">Số tiền</th>
                                                <th class="text-uppercase small">Ngân hàng</th>
                                                <th class="text-uppercase small text-end pe-3">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $pendingWithdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td class="ps-3"><span class="text-muted">#<?php echo e($withdrawal->order_code); ?></span></td>
                                                    <td>
                                                        <a href="<?php echo e(route('admin.users.show', ['id' => $withdrawal->user->id])); ?>" class="text-primary fw-medium text-decoration-none">
                                                            <?php echo e($withdrawal->user->username ?? 'N/A'); ?>

                                                        </a>
                                                    </td>
                                                    <td><span class="fw-semibold text-danger"><?php echo e(number_format($withdrawal->amount)); ?> đ</span></td>
                                                    <td><span class="badge bg-light-secondary text-secondary"><?php echo e($withdrawal->bank_name); ?></span></td>
                                                    <td class="text-end pe-3">
                                                        <a href="<?php echo e(route('admin.withdrawals.index')); ?>" class="btn btn-sm btn-primary py-1 px-2">Xử lý <i class="ti ti-arrow-right"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">Không có yêu cầu rút tiền nào đang chờ</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 mb-4 d-flex">
                        <div class="card flex-fill border border-dashed shadow-sm">
                            <div class="card-header border-bottom bg-transparent d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0 border-start border-info border-3 ps-2">
                                    Yêu cầu rút tài nguyên đang chờ
                                </h5>
                                <a href="<?php echo e(route('admin.withdrawals.resources.index')); ?>" class="btn btn-sm btn-light-primary rounded-pill px-3">
                                    Xem tất cả
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderless align-middle mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th class="text-uppercase small ps-3">ID</th>
                                                <th class="text-uppercase small">Người dùng</th>
                                                <th class="text-uppercase small">Loại</th>
                                                <th class="text-uppercase small">Số lượng</th>
                                                <th class="text-uppercase small text-end pe-3">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $pendingResourceWithdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td class="ps-3"><span class="text-muted">#<?php echo e($withdrawal->order_code); ?></span></td>
                                                    <td>
                                                        <a href="<?php echo e(route('admin.users.show', ['id' => $withdrawal->user->id])); ?>" class="text-primary fw-medium text-decoration-none">
                                                            <?php echo e($withdrawal->user->username ?? 'N/A'); ?>

                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php if($withdrawal->type == 'gold'): ?>
                                                            <span class="badge bg-light-warning text-warning border border-warning border-opacity-25 px-2 py-1"><i class="ti ti-coin me-1"></i>Vàng</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-light-info text-info border border-info border-opacity-25 px-2 py-1"><i class="ti ti-diamond me-1"></i>Ngọc</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><span class="fw-semibold"><?php echo e(number_format($withdrawal->amount)); ?></span></td>
                                                    <td class="text-end pe-3">
                                                        <a href="<?php echo e(route('admin.withdrawals.resources.index')); ?>" class="btn btn-sm btn-primary py-1 px-2">Xử lý <i class="ti ti-arrow-right"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">Không có yêu cầu rút tài nguyên nào đang chờ</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            var salesData = <?php echo json_encode($last7Days ?? []); ?>;
            if(salesData.length === 0) return;

            var categories = salesData.map(function(item) {
                return item.date;
            });

            var depositData = salesData.map(function(item) {
                return item.deposits;
            });

            var purchaseData = salesData.map(function(item) {
                return item.purchases;
            });

            var options = {
                series: [{
                    name: 'Nạp tiền',
                    data: depositData
                }, {
                    name: 'Mua hàng',
                    data: purchaseData
                }],
                chart: {
                    height: 320,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'inherit',
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    type: 'category',
                    categories: categories,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val >= 1000 ? (val / 1000) + 'k' : val;
                        }
                    }
                },
                grid: {
                    borderColor: 'rgba(0,0,0,0.05)',
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                tooltip: {
                    theme: 'dark',
                    x: {
                        format: 'dd/MM'
                    },
                    y: {
                        formatter: function(val) {
                            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",") + ' đ';
                        }
                    }
                },
                colors: ['#28c76f', '#7367f0'],
                legend: {
                    show: false
                }
            };

            var chart = new ApexCharts(document.querySelector("#sales_charts"), options);
            chart.render();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>