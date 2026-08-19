@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Thêm Mã Giảm Giá</h2>
                <p class="text-muted">Tạo mã giảm giá mới</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.discount-codes.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
                                    <input type="text" name="code" value="{{ old('code') }}"
                                        class="form-control @error('code') is-invalid @enderror"
                                        placeholder="Để trống để tạo mã tự động">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Kiểu giảm giá <span class="text-danger">*</span></label>
                                    <select name="type" class="form-select @error('type') is-invalid @enderror"
                                        id="discountType">
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Phần
                                            trăm (%)</option>
                                        <option value="fixed_amount" {{ old('type') == 'fixed_amount' ? 'selected' : '' }}>
                                            Số tiền cố
                                            định (VNĐ)</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giá trị <span class="text-danger">*</span></label>
                                    <input type="number" name="value" value="{{ old('value') }}"
                                        class="form-control @error('value') is-invalid @enderror" placeholder="Nhập giá trị giảm">
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12" id="maxDiscountGroup">
                                <div class="mb-3">
                                    <label class="form-label">Giảm tối đa (VNĐ) <span class="text-muted">(0 = Không giới hạn)</span></label>
                                    <input type="number" name="max_discount" value="{{ old('max_discount', 0) }}"
                                        class="form-control @error('max_discount') is-invalid @enderror" placeholder="Nhập số tiền tối đa">
                                    @error('max_discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Điều kiện áp dụng</h6>
                            </div>
                            
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Số tiền mua tối thiểu (VNĐ)</label>
                                    <input type="number" name="min_purchase_amount"
                                        value="{{ old('min_purchase_amount', 0) }}"
                                        class="form-control @error('min_purchase_amount') is-invalid @enderror" placeholder="VD: 50000">
                                    @error('min_purchase_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Áp dụng cho <span class="text-danger">*</span></label>
                                    <select name="applicable_to"
                                        class="form-select @error('applicable_to') is-invalid @enderror">
                                        <option value="">Tất cả danh mục</option>
                                        <option value="account" {{ old('applicable_to') == 'account' ? 'selected' : '' }}>
                                            Chỉ Tài khoản</option>
                                        <option value="random_account"
                                            {{ old('applicable_to') == 'random_account' ? 'selected' : '' }}>Chỉ Random tài
                                            khoản</option>
                                        <option value="service" {{ old('applicable_to') == 'service' ? 'selected' : '' }}>
                                            Chỉ Dịch vụ</option>
                                    </select>
                                    @error('applicable_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Lượt sử dụng tối đa <span class="text-muted">(Để trống = Không giới hạn)</span></label>
                                    <input type="number" name="usage_limit" value="{{ old('usage_limit') }}"
                                        class="form-control @error('usage_limit') is-invalid @enderror" placeholder="Nhập tổng số lần dùng">
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giới hạn mỗi người <span class="text-muted">(Để trống = Không giới hạn)</span></label>
                                    <input type="number" name="per_user_limit" value="{{ old('per_user_limit') }}"
                                        class="form-control @error('per_user_limit') is-invalid @enderror" placeholder="Số lần một user được dùng">
                                    @error('per_user_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Ngày hết hạn <span class="text-muted">(Để trống = Không hết hạn)</span></label>
                                    <input type="date" name="expires_at" value="{{ old('expires_at') }}"
                                        class="form-control @error('expires_at') is-invalid @enderror">
                                    @error('expires_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 d-flex align-items-center mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active">Hoạt động (Kích hoạt mã)</label>
                                </div>
                                @error('is_active')
                                    <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Tạo mã giảm giá</button>
                                <a href="{{ route('admin.discount-codes.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const discountType = document.getElementById('discountType');
            const valueInput = document.querySelector('input[name="value"]');
            const maxDiscountGroup = document.getElementById('maxDiscountGroup');

            // Initial state
            updateValueLabel();
            updateMaxDiscountVisibility();

            // Event listener
            discountType.addEventListener('change', function() {
                updateValueLabel();
                updateMaxDiscountVisibility();
            });

            function updateValueLabel() {
                const label = valueInput.closest('.form-group').querySelector('label');
                if (discountType.value === 'percentage') {
                    label.innerHTML = 'Giá trị (%) <span class="text-danger">*</span>';
                } else {
                    label.innerHTML = 'Giá trị (VNĐ) <span class="text-danger">*</span>';
                }
            }

            function updateMaxDiscountVisibility() {
                if (discountType.value === 'percentage') {
                    maxDiscountGroup.style.display = 'block';
                } else {
                    maxDiscountGroup.style.display = 'none';
                }
            }
        });
    </script>
@endpush
