@extends('layouts.admin.app')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="page-block mb-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ $title }}</h2>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('admin.usdt-accounts.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Thêm tài khoản
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                            @forelse($accounts as $account)
                                <tr>
                                    <td>{{ $account->id }}</td>
                                    <td>
                                        @if($account->type == 'binance')
                                            <span class="badge bg-warning text-dark"><i class="fa-brands fa-usps"></i> Binance Pay</span>
                                        @else
                                            <span class="badge bg-info"><i class="fa-brands fa-usps"></i> TRC20</span>
                                        @endif
                                    </td>
                                    <td>{{ $account->name }}</td>
                                    <td>{{ $account->wallet_address }}</td>
                                    <td>
                                        <small class="text-muted" title="{{ $account->api_token }}">{{ Str::limit($account->api_token, 15) }}</small>
                                    </td>
                                    <td>
                                        @if($account->is_active)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Bảo trì</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.usdt-accounts.edit', $account->id) }}" class="btn btn-sm btn-info text-white">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.usdt-accounts.destroy', $account->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-white">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">Chưa có tài khoản USDT nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($accounts->hasPages())
                <div class="card-footer">
                    {{ $accounts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
