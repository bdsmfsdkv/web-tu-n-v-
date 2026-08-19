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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.usdt-accounts.update', $usdtAccount->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mạng lưới <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="binance" {{ (old('type', $usdtAccount->type) == 'binance') ? 'selected' : '' }}>Binance Pay</option>
                                <option value="trc20" {{ (old('type', $usdtAccount->type) == 'trc20') ? 'selected' : '' }}>Ví TRC20 / BEP20</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên hiển thị <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $usdtAccount->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Địa chỉ ví <span class="text-danger">*</span></label>
                            <input type="text" name="wallet_address" class="form-control @error('wallet_address') is-invalid @enderror" value="{{ old('wallet_address', $usdtAccount->wallet_address) }}" required>
                            @error('wallet_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Link ảnh QR Code (Tùy chọn)</label>
                            <input type="url" name="qr_image" class="form-control @error('qr_image') is-invalid @enderror" value="{{ old('qr_image', $usdtAccount->qr_image) }}">
                            @error('qr_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nếu để trống, hệ thống sẽ tự động tạo QR từ Địa chỉ ví.</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">API Token (Spay5s) <span class="text-danger">*</span></label>
                            <input type="text" name="api_token" class="form-control @error('api_token') is-invalid @enderror" value="{{ old('api_token', $usdtAccount->api_token) }}" required>
                            @error('api_token')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $usdtAccount->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Hoạt động (Hiển thị cho khách hàng)</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.usdt-accounts.index') }}" class="btn btn-secondary me-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
