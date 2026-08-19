@extends('layouts.admin.app')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-block mb-3">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ $title }}</h2>
                            <p class="text-muted">Lịch sử nạp tiền tự động qua cổng USDT</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <form action="{{ route('admin.history.deposits.usdt') }}" method="GET" class="row gx-2 gy-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Tìm theo tên đăng nhập hoặc mã yêu cầu..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-2"></i>Tìm kiếm</button>
                    </div>
                    @if(request('search'))
                        <div class="col-md-2">
                            <a href="{{ route('admin.history.deposits.usdt') }}" class="btn btn-light w-100"><i class="ti ti-refresh me-2"></i>Làm mới</a>
                        </div>
                    @endif
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
                            @forelse($deposits as $deposit)
                                <tr>
                                    <td>
                                        <span class="badge bg-light-primary text-primary">{{ $deposit->request_code }}</span>
                                    </td>
                                    <td>
                                        @if($deposit->user)
                                            <a href="{{ route('admin.users.show', $deposit->user->id) }}" class="fw-bold">{{ $deposit->user->username }}</a>
                                        @else
                                            <span class="text-muted">Không xác định</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="text-success">{{ number_format($deposit->usdt_amount, 2) }} USDT</strong>
                                        <br>
                                        <small class="text-muted">Tỷ giá: {{ number_format($deposit->exchange_rate) }}</small>
                                    </td>
                                    <td>
                                        <strong class="text-danger">{{ number_format($deposit->vnd_amount) }} VND</strong>
                                    </td>
                                    <td>
                                        @if($deposit->transaction_id)
                                            <small class="text-muted" title="{{ $deposit->transaction_id }}">
                                                {{ Str::limit($deposit->transaction_id, 15) }}
                                            </small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($deposit->status === 'completed')
                                            <span class="badge bg-success">Thành công</span>
                                        @elseif($deposit->status === 'pending')
                                            <span class="badge bg-warning text-dark">Đang chờ</span>
                                        @else
                                            <span class="badge bg-danger">Thất bại/Hủy</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $deposit->created_at->format('d/m/Y H:i:s') }}
                                        @if($deposit->status === 'completed')
                                            <br>
                                            <small class="text-success"><i class="ti ti-check"></i> {{ $deposit->updated_at->format('H:i:s') }}</small>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">Không tìm thấy dữ liệu lịch sử nạp USDT.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($deposits->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $deposits->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
