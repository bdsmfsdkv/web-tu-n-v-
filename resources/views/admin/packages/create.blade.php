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
                <h2 class="mb-0">Thêm gói dịch vụ mới</h2>
                <p class="text-muted">Tạo gói dịch vụ mới</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.packages.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Dịch vụ <span class="text-danger">*</span></label>
                                    <select name="game_service_id"
                                        class="form-select @error('game_service_id') is-invalid @enderror">
                                        <option value="">Chọn dịch vụ</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ old('game_service_id') == $service->id || (isset($selectedService) && $selectedService->id == $service->id) ? 'selected' : '' }}>
                                                {{ $service->name }}
                                                ({{ $service->type == 'gold' ? 'Bán vàng' : ($service->type == 'gem' ? 'Bán ngọc' : 'Cày thuê') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('game_service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tên gói dịch vụ <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Ví dụ: Gói 1000 vàng, Gói 100 ngọc...">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giá (VND) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price') }}"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Ví dụ: 100000">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12" id="estimated_time_group">
                                <div class="mb-3">
                                    <label class="form-label">Thời gian ước tính (phút)</label>
                                    <input type="number" name="estimated_time" value="{{ old('estimated_time') }}"
                                        class="form-control @error('estimated_time') is-invalid @enderror"
                                        placeholder="Ví dụ: 60">
                                    @error('estimated_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 d-flex align-items-center mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="active">Hiển thị (Kích hoạt gói dịch vụ)</label>
                                </div>
                                @error('active')
                                    <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Mô tả gói dịch vụ</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                        placeholder="Mô tả chi tiết về gói dịch vụ">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Tạo mới</button>
                                <a href="{{ isset($selectedService) ? route('admin.packages.service', $selectedService->id) : route('admin.packages.index') }}"
                                    class="btn btn-secondary">Hủy bỏ</a>
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
        $(document).ready(function() {
            // Nếu là dịch vụ cày thuê, hiển thị trường thời gian ước tính
            $('select[name="game_service_id"]').on('change', function() {
                const serviceType = $(this).find('option:selected').text();
                if (serviceType.includes('Cày thuê')) {
                    $('input[name="estimated_time"]').parent('.form-group').show();
                } else {
                    $('input[name="estimated_time"]').parent('.form-group').hide();
                    $('input[name="estimated_time"]').val('');
                }
            }).trigger('change');
        });
    </script>
@endpush
