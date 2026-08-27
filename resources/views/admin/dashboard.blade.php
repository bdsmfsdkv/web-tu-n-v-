@extends('layouts.admin.app')
@section('title', 'Trang quản trị')
@section('content')
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

            @if (isset($error))
                <div class="alert alert-danger">
                    <strong>Lỗi!</strong> Đã xảy ra lỗi khi tải dữ liệu dashboard. Vui lòng thông báo cho quản trị viên.
                    @if (config('app.debug'))
                        <p>{{ $error }}</p>
                    @endif
                </div>
            @else
            <!-- Comparison Block -->
            <div id="comparison-card" class="card border border-dashed shadow-sm mb-4">
                <div class="card-header border-bottom-0 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-scale text-primary me-2"></i>So sánh 2 kỳ</h5>
                    <a href="?period_a=today&period_b=yesterday" data-comparison-link class="btn btn-sm btn-info text-white">Hôm nay vs Hôm qua</a>
                </div>
                <div class="card-body">
                    <form id="comparison-form" method="GET" class="row align-items-end mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Kỳ A</label>
                            <select name="period_a" class="form-select form-select-sm">
                                <option value="today" {{ $comparison['period_a'] == 'today' ? 'selected' : '' }}>Hôm nay</option>
                                <option value="yesterday" {{ $comparison['period_a'] == 'yesterday' ? 'selected' : '' }}>Hôm qua</option>
                                <option value="this_week" {{ $comparison['period_a'] == 'this_week' ? 'selected' : '' }}>Tuần này</option>
                                <option value="last_week" {{ $comparison['period_a'] == 'last_week' ? 'selected' : '' }}>Tuần trước</option>
                                <option value="this_month" {{ $comparison['period_a'] == 'this_month' ? 'selected' : '' }}>Tháng này</option>
                                <option value="last_month" {{ $comparison['period_a'] == 'last_month' ? 'selected' : '' }}>Tháng trước</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Kỳ B (so với)</label>
                            <select name="period_b" class="form-select form-select-sm">
                                <option value="yesterday" {{ $comparison['period_b'] == 'yesterday' ? 'selected' : '' }}>Hôm qua</option>
                                <option value="today" {{ $comparison['period_b'] == 'today' ? 'selected' : '' }}>Hôm nay</option>
                                <option value="last_week" {{ $comparison['period_b'] == 'last_week' ? 'selected' : '' }}>Tuần trước</option>
                                <option value="this_week" {{ $comparison['period_b'] == 'this_week' ? 'selected' : '' }}>Tuần này</option>
                                <option value="last_month" {{ $comparison['period_b'] == 'last_month' ? 'selected' : '' }}>Tháng trước</option>
                                <option value="this_month" {{ $comparison['period_b'] == 'this_month' ? 'selected' : '' }}>Tháng này</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-sm btn-warning w-100 text-white fw-bold"><i class="ti ti-scale me-1"></i> So sánh</button>
                        </div>
                    </form>

                    <div class="d-flex gap-2 mb-3 flex-wrap">
                        <a href="?period_a=today&period_b=yesterday" data-comparison-link class="btn btn-xs {{ $comparison['period_a'] == 'today' && $comparison['period_b'] == 'yesterday' ? 'btn-warning text-white' : 'btn-outline-secondary' }}">Hôm nay / Hôm qua</a>
                        <a href="?period_a=this_week&period_b=last_week" data-comparison-link class="btn btn-xs {{ $comparison['period_a'] == 'this_week' && $comparison['period_b'] == 'last_week' ? 'btn-warning text-white' : 'btn-outline-secondary' }}">Tuần này / Tuần trước</a>
                        <a href="?period_a=this_month&period_b=last_month" data-comparison-link class="btn btn-xs {{ $comparison['period_a'] == 'this_month' && $comparison['period_b'] == 'last_month' ? 'btn-warning text-white' : 'btn-outline-secondary' }}">Tháng này / Tháng trước</a>
                    </div>

                    @if(request()->has('period_a') || request()->has('period_b'))
                        @if($comparison['a']['revenue'] >= $comparison['b']['revenue'])
                        <div class="alert alert-success border-start border-success border-4 py-2 px-3 mb-3" style="background-color: rgba(40, 167, 69, 0.1);">
                            <span class="fw-semibold text-success">Doanh thu Kỳ A đang cao hơn hoặc bằng Kỳ B. Giữ phong độ nhé!</span>
                        </div>
                        @else
                        <div class="alert alert-danger border-start border-danger border-4 py-2 px-3 mb-3" style="background-color: rgba(220, 53, 69, 0.1);">
                            <span class="fw-semibold text-danger">Doanh thu Kỳ A đang thấp hơn Kỳ B. Cố lên nhé!</span>
                        </div>
                        @endif
                    @endif

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
                                @php
                                    $metrics = [
                                        ['key' => 'revenue', 'name' => 'Doanh thu', 'format' => 'money'],
                                        ['key' => 'profit', 'name' => 'Lợi nhuận', 'format' => 'money'],
                                        ['key' => 'orders_count', 'name' => 'Số đơn', 'format' => 'number'],
                                        ['key' => 'avg_order_value', 'name' => 'Giá trị đơn TB', 'format' => 'money'],
                                        ['key' => 'deposits', 'name' => 'Nạp tiền', 'format' => 'money'],
                                        ['key' => 'new_members', 'name' => 'Thành viên mới', 'format' => 'number'],
                                    ];
                                @endphp

                                @foreach($metrics as $m)
                                @php
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
                                @endphp
                                <tr class="border-bottom border-light">
                                    <td class="text-muted">{{ $m['name'] }}</td>
                                    <td class="text-center">{{ $strA }}</td>
                                    <td class="text-center">{{ $strB }}</td>
                                    <td class="text-end fw-bold {{ $color }}">
                                        <i class="ti {{ $icon }} me-1"></i>{{ $strDiff }} ({{ $sign }}{{ $diff }}%)
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Summary Cards Row -->
            <div class="row g-3 mb-4">
                <!-- Tài khoản game -->
                <div class="col-6 col-md-3">
                    <div class="card border border-dashed shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold"><i class="ti ti-device-gamepad text-primary me-2"></i>Tài khoản game</h6>
                                <span class="badge bg-info">Tổng</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Đã bán trong kỳ</span>
                                <span class="fw-bold">{{ number_format($comparison['a']['acc_sold']) }} tài khoản</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Doanh thu</span>
                                <span class="fw-bold text-success">{{ number_format($comparison['a']['acc_revenue'], 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Kho còn lại</span>
                                <span class="fw-bold text-primary">{{ number_format($comparison['a']['acc_stock']) }} tài khoản</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Vật phẩm & Vòng quay -->
                <div class="col-6 col-md-3">
                    <div class="card border border-dashed shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold"><i class="ti ti-layout-grid-add text-warning me-2"></i>Vật phẩm & Vòng quay</h6>
                                <span class="badge bg-warning">~{{ $comparison['diff']['wheel_revenue'] > 0 ? '+' : '' }}{{ $comparison['diff']['wheel_revenue'] }}%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Lượt trong kỳ</span>
                                <span class="fw-bold">{{ number_format($comparison['a']['wheel_spins']) }} lượt</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Doanh thu</span>
                                <span class="fw-bold text-success">{{ number_format($comparison['a']['wheel_revenue'], 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Vòng quay hiện có</span>
                                <span class="fw-bold text-warning">{{ number_format($comparison['a']['wheels_count']) }} vòng</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dịch vụ cày thuê -->
                <div class="col-6 col-md-3">
                    <div class="card border border-dashed shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold"><i class="ti ti-hammer text-success me-2"></i>Dịch vụ cày thuê</h6>
                                <span class="badge bg-success">~{{ $comparison['diff']['service_revenue'] > 0 ? '+' : '' }}{{ $comparison['diff']['service_revenue'] }}%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Hoàn thành kỳ này</span>
                                <span class="fw-bold">{{ number_format($comparison['a']['service_completed']) }} đơn</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Doanh thu</span>
                                <span class="fw-bold text-success">{{ number_format($comparison['a']['service_revenue'], 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Đang xử lý</span>
                                <span class="fw-bold text-warning">{{ number_format($comparison['a']['service_processing']) }} đơn</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nạp tiền chi tiết -->
                <div class="col-6 col-md-3">
                    <div class="card border border-dashed shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold"><i class="ti ti-credit-card text-info me-2"></i>Nạp tiền chi tiết</h6>
                                <span class="badge bg-info">Kỳ A</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Thẻ cào (Kỳ A)</span>
                                <span class="fw-bold">{{ number_format($comparison['a']['card_deposits'], 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Thẻ cào (Kỳ B)</span>
                                <span class="fw-bold">{{ number_format($comparison['b']['card_deposits'], 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Bank (Kỳ A)</span>
                                <span class="fw-bold">{{ number_format($comparison['a']['bank_deposits'], 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Bank (Kỳ B)</span>
                                <span class="fw-bold">{{ number_format($comparison['b']['bank_deposits'], 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Thống kê tài khoản -->
                <div class="row g-2">
                    <div class="col-6 col-xl-3 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold">{{ number_format($statistics['accounts']['total']) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold">{{ number_format($statistics['accounts']['available']) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold">{{ number_format($statistics['accounts']['sold']) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold">{{ number_format($statistics['users']['total']) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thống kê dịch vụ và danh mục -->
                <div class="row g-2">
                    <div class="col-6 col-xl-3 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold">{{ number_format($statistics['services']['total']) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold">{{ number_format($statistics['random_accounts']['total']) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold">{{ number_format($statistics['lucky_wheels']['total']) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold">{{ number_format($statistics['users']['new_today']) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng hợp giao dịch -->
                <div class="row g-2">
                    <div class="col-6 col-xl-4 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold text-success"><span class="counters">{{ number_format($transactionSummary['total_deposit']) }}</span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-4 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold text-danger"><span class="counters">{{ number_format($transactionSummary['total_withdraw']) }}</span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-4 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold text-info"><span class="counters">{{ number_format($transactionSummary['total_purchase']) }}</span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-4 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold text-warning"><span class="counters">{{ number_format($transactionSummary['total_refund']) }}</span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-4 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold text-primary"><span class="counters">{{ number_format(abs($transactionSummary['total_purchase'])) }}</span> đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-4 col-md-6 mb-3">
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
                                        <h5 class="mb-0 fw-bold"><span class="counters">{{ number_format($statistics['accounts']['sold'] + ($statistics['random_accounts']['sold'] ?? 0)) }}</span></h5>
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
                                            @forelse ($servicesByType as $serviceType)
                                                <tr>
                                                    <td>
                                                        @if ($serviceType->type == 'gold')
                                                            <div class="d-flex align-items-center">
                                                                <span class="p-2 bg-light-warning rounded me-2"><i class="ti ti-coin text-warning"></i></span>
                                                                <span class="fw-medium">Bán vàng</span>
                                                            </div>
                                                        @elseif($serviceType->type == 'gem')
                                                            <div class="d-flex align-items-center">
                                                                <span class="p-2 bg-light-info rounded me-2"><i class="ti ti-diamond text-info"></i></span>
                                                                <span class="fw-medium">Bán ngọc</span>
                                                            </div>
                                                        @elseif($serviceType->type == 'leveling')
                                                            <div class="d-flex align-items-center">
                                                                <span class="p-2 bg-light-success rounded me-2"><i class="ti ti-trending-up text-success"></i></span>
                                                                <span class="fw-medium">Cày thuê</span>
                                                            </div>
                                                        @else
                                                            <div class="d-flex align-items-center">
                                                                <span class="p-2 bg-light-secondary rounded me-2"><i class="ti ti-category text-secondary"></i></span>
                                                                <span class="fw-medium text-capitalize">{{ $serviceType->type }}</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="text-end align-middle">
                                                        <span class="badge bg-light-primary text-primary px-3 py-2 fs-6 rounded-pill">{{ number_format($serviceType->total) }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-4">Chưa có dữ liệu dịch vụ</td>
                                                </tr>
                                            @endforelse
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
                                            @forelse($activeDiscountCodes as $code)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="p-1 bg-light-success rounded me-2"><i class="ti ti-ticket text-success"></i></span>
                                                            <span class="fw-bold text-success">{{ $code->code }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-end align-middle fw-medium">
                                                        @if ($code->discount_type == 'percentage')
                                                            {{ $code->discount_value }}%
                                                        @else
                                                            {{ number_format($code->discount_value) }} đ
                                                        @endif
                                                    </td>
                                                    <td class="text-end align-middle text-muted small">
                                                        {{ $code->expire_date ? $code->expire_date->format('d/m/Y') : 'Không hạn' }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted py-4">Không có mã giảm giá nào đang hoạt động</td>
                                                </tr>
                                            @endforelse
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
                                            <span class="badge bg-light-info text-info rounded-pill px-3">{{ number_format($statistics['users']['admin']) }}</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-info rounded-pill" role="progressbar"
                                                style="width: {{ $statistics['users']['total'] > 0 ? ($statistics['users']['admin'] / $statistics['users']['total']) * 100 : 0 }}%"
                                                aria-valuenow="{{ $statistics['users']['admin'] }}" aria-valuemin="0"
                                                aria-valuemax="{{ $statistics['users']['total'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats-info mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="mb-0 fw-medium">Khách hàng</p>
                                            <span class="badge bg-light-success text-success rounded-pill px-3">{{ number_format($statistics['users']['user']) }}</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success rounded-pill" role="progressbar"
                                                style="width: {{ $statistics['users']['total'] > 0 ? ($statistics['users']['user'] / $statistics['users']['total']) * 100 : 0 }}%"
                                                aria-valuenow="{{ $statistics['users']['user'] }}" aria-valuemin="0"
                                                aria-valuemax="{{ $statistics['users']['total'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats-info border-top pt-3 mt-2">
                                        <p class="text-muted small mb-2 text-uppercase fw-semibold">Người dùng mới</p>
                                        <div class="row g-2 text-center">
                                            <div class="col-4">
                                                <div class="p-2 border rounded bg-light-subtle">
                                                    <small class="text-muted d-block mb-1">Hôm nay</small>
                                                    <span class="badge bg-primary px-2">{{ number_format($statistics['users']['new_today']) }}</span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-2 border rounded bg-light-subtle">
                                                    <small class="text-muted d-block mb-1">Tuần này</small>
                                                    <span class="badge bg-info px-2">{{ number_format($statistics['users']['new_this_week']) }}</span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-2 border rounded bg-light-subtle">
                                                    <small class="text-muted d-block mb-1">Tháng này</small>
                                                    <span class="badge bg-success px-2">{{ number_format($statistics['users']['new_this_month']) }}</span>
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
                                    @forelse ($recentTransactions as $transaction)
                                        <tr>
                                            <td class="ps-3"><span class="text-muted">#{{ $transaction->order_code }}</span></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar avtar-xs bg-light-primary text-primary me-2 rounded-circle">
                                                        {{ strtoupper(substr($transaction->user->username ?? 'U', 0, 1)) }}
                                                    </div>
                                                    <a href="{{ route('admin.users.show', ['id' => $transaction->user->id]) }}" class="text-primary fw-medium text-decoration-none">
                                                        {{ $transaction->user->username ?? 'N/A' }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($transaction->type == 'deposit')
                                                    <span class="badge bg-light-success text-success border border-success border-opacity-25 px-2 py-1"><i class="ti ti-arrow-down me-1"></i> Nạp tiền</span>
                                                @elseif($transaction->type == 'withdraw')
                                                    <span class="badge bg-light-danger text-danger border border-danger border-opacity-25 px-2 py-1"><i class="ti ti-arrow-up me-1"></i> Rút tiền</span>
                                                @elseif($transaction->type == 'purchase')
                                                    <span class="badge bg-light-warning text-warning border border-warning border-opacity-25 px-2 py-1"><i class="ti ti-shopping-cart me-1"></i> Mua hàng</span>
                                                @elseif($transaction->type == 'refund')
                                                    <span class="badge bg-light-info text-info border border-info border-opacity-25 px-2 py-1"><i class="ti ti-arrow-back me-1"></i> Hoàn tiền</span>
                                                @else
                                                    <span class="badge bg-light-secondary text-secondary border px-2 py-1">{{ $transaction->type }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-semibold {{ in_array($transaction->type, ['deposit', 'refund']) ? 'text-success' : 'text-danger' }}">
                                                    {{ in_array($transaction->type, ['deposit', 'refund']) ? '+' : '-' }}{{ number_format($transaction->amount) }} đ
                                                </span>
                                            </td>
                                            <td><span class="text-muted">{{ number_format($transaction->balance_before) }} đ</span></td>
                                            <td><span class="text-muted">{{ number_format($transaction->balance_after) }} đ</span></td>
                                            <td><span class="text-truncate d-inline-block" style="max-width: 250px;" title="{{ $transaction->description }}">{{ $transaction->description ?? 'N/A' }}</span></td>
                                            <td class="pe-3 text-end"><span class="text-muted small">{{ $transaction->created_at->format('d/m/Y H:i') }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">Chưa có giao dịch nào</td>
                                        </tr>
                                    @endforelse
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
                                <div id="sales_charts" style="min-height: 250px;"></div>
                                <div class="table-responsive mt-4">
                                    <table class="table table-sm table-bordered table-hover text-center mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th class="text-muted small text-start text-uppercase">Ngày</th>
                                                @foreach ($last7Days as $day)
                                                    <th class="text-muted small">{{ $day['date'] }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-start fw-medium"><span class="badge bg-light-success text-success me-2">●</span> Nạp tiền</td>
                                                @foreach ($last7Days as $day)
                                                    <td class="{{ $day['deposits'] > 0 ? 'fw-semibold text-success' : 'text-muted' }}">{{ number_format($day['deposits']) }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td class="text-start fw-medium"><span class="badge bg-light-primary text-primary me-2">●</span> Mua hàng</td>
                                                @foreach ($last7Days as $day)
                                                    <td class="{{ $day['purchases'] > 0 ? 'fw-semibold text-primary' : 'text-muted' }}">{{ number_format($day['purchases']) }}</td>
                                                @endforeach
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
                                <a href="{{ route('admin.history.services') }}" class="btn btn-sm btn-light-primary rounded-pill px-3">
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
                                            @forelse($pendingServices as $service)
                                                <tr>
                                                    <td class="ps-3"><span class="text-muted">#{{ $service->order_code }}</span></td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="badge bg-light-danger text-danger border border-danger border-opacity-25 w-max-content mb-1 px-2 py-1">{{ $service->gameService->name ?? 'N/A' }}</span>
                                                            <span class="small text-muted text-truncate" style="max-width: 150px;" title="{{ $service->servicePackage->name ?? 'N/A' }}">{{ $service->servicePackage->name ?? 'N/A' }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.users.show', ['id' => $service->user->id]) }}" class="text-primary fw-medium text-decoration-none">
                                                            {{ $service->user->username ?? 'N/A' }}
                                                        </a>
                                                    </td>
                                                    <td class="text-end pe-3">
                                                        <span class="badge bg-warning"><i class="ti ti-clock me-1"></i>Chờ xử lý</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">Không có dịch vụ nào đang chờ xử lý</td>
                                                </tr>
                                            @endforelse
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
                                <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-sm btn-light-primary rounded-pill px-3">
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
                                            @forelse($pendingWithdrawals as $withdrawal)
                                                <tr>
                                                    <td class="ps-3"><span class="text-muted">#{{ $withdrawal->order_code }}</span></td>
                                                    <td>
                                                        <a href="{{ route('admin.users.show', ['id' => $withdrawal->user->id]) }}" class="text-primary fw-medium text-decoration-none">
                                                            {{ $withdrawal->user->username ?? 'N/A' }}
                                                        </a>
                                                    </td>
                                                    <td><span class="fw-semibold text-danger">{{ number_format($withdrawal->amount) }} đ</span></td>
                                                    <td><span class="badge bg-light-secondary text-secondary">{{ $withdrawal->bank_name }}</span></td>
                                                    <td class="text-end pe-3">
                                                        <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-sm btn-primary py-1 px-2">Xử lý <i class="ti ti-arrow-right"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">Không có yêu cầu rút tiền nào đang chờ</td>
                                                </tr>
                                            @endforelse
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
                                <a href="{{ route('admin.withdrawals.resources.index') }}" class="btn btn-sm btn-light-primary rounded-pill px-3">
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
                                            @forelse($pendingResourceWithdrawals as $withdrawal)
                                                <tr>
                                                    <td class="ps-3"><span class="text-muted">#{{ $withdrawal->order_code }}</span></td>
                                                    <td>
                                                        <a href="{{ route('admin.users.show', ['id' => $withdrawal->user->id]) }}" class="text-primary fw-medium text-decoration-none">
                                                            {{ $withdrawal->user->username ?? 'N/A' }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if ($withdrawal->type == 'gold')
                                                            <span class="badge bg-light-warning text-warning border border-warning border-opacity-25 px-2 py-1"><i class="ti ti-coin me-1"></i>Vàng</span>
                                                        @else
                                                            <span class="badge bg-light-info text-info border border-info border-opacity-25 px-2 py-1"><i class="ti ti-diamond me-1"></i>Ngọc</span>
                                                        @endif
                                                    </td>
                                                    <td><span class="fw-semibold">{{ number_format($withdrawal->amount) }}</span></td>
                                                    <td class="text-end pe-3">
                                                        <a href="{{ route('admin.withdrawals.resources.index') }}" class="btn btn-sm btn-primary py-1 px-2">Xử lý <i class="ti ti-arrow-right"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">Không có yêu cầu rút tài nguyên nào đang chờ</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        (() => {
            const loadComparison = async (url) => {
                const card = document.getElementById('comparison-card');
                if (!card || card.dataset.loading === 'true') return;

                card.dataset.loading = 'true';
                card.style.opacity = '0.6';
                console.debug('[comparison] loading', url.toString());

                try {
                    const response = await fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin',
                    });
                    if (!response.ok) throw new Error(`HTTP ${response.status}`);

                    const documentResponse = new DOMParser().parseFromString(await response.text(), 'text/html');
                    const nextCard = documentResponse.getElementById('comparison-card');
                    if (!nextCard) throw new Error('Không tìm thấy khối so sánh trong phản hồi.');

                    card.replaceWith(nextCard);
                    history.pushState({}, '', url);
                    console.debug('[comparison] loaded', url.toString());
                } catch (error) {
                    card.dataset.loading = 'false';
                    card.style.opacity = '';
                    console.error('[comparison] load failed', error);
                    alert('Không thể tải dữ liệu so sánh. Vui lòng thử lại.');
                }
            };

            document.addEventListener('click', (event) => {
                const link = event.target.closest('[data-comparison-link]');
                if (!link) return;

                event.preventDefault();
                loadComparison(new URL(link.href, window.location.href));
            });

            document.addEventListener('submit', (event) => {
                const form = event.target.closest('#comparison-form');
                if (!form) return;

                event.preventDefault();
                const url = new URL(form.action || window.location.href, window.location.href);
                url.search = new URLSearchParams(new FormData(form)).toString();
                loadComparison(url);
            });
        })();

        $(document).ready(function() {
            var salesData = {!! json_encode($last7Days ?? []) !!};
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
                    height: window.innerWidth < 576 ? 220 : 320,
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
@endpush
