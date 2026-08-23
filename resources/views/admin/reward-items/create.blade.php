@extends('layouts.admin.app')
@section('title', 'Thêm Vật Phẩm Thưởng')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="page-block mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Thêm Vật Phẩm Thưởng</h2>
                                <p class="text-muted">Tạo mới vật phẩm trong kho thưởng</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header pt-4 pb-0">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="ti ti-plus text-primary me-2"></i>Thông tin vật phẩm
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reward-items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Vòng quay <span class="text-danger">*</span></label>
                                <select class="form-select" name="lucky_wheel_id" required>
                                    <option value="">-- Chọn vòng quay --</option>
                                    @foreach($luckyWheels as $wheel)
                                        <option value="{{ $wheel->id }}" {{ old('lucky_wheel_id') == $wheel->id ? 'selected' : '' }}>{{ $wheel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Game <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="game_name" value="{{ old('game_name') }}" placeholder="VD: Free Fire" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tên vật phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="VD: Kim Cương" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Đơn vị <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="unit" value="{{ old('unit') }}" placeholder="VD: Kim Cương" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mã (Code) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="VD: KC_FF" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Rút tối thiểu <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="min_withdraw" value="{{ old('min_withdraw', 10) }}" required min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Rút tối đa <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="max_withdraw" value="{{ old('max_withdraw', 5000) }}" required min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Độ ưu tiên (Priority)</label>
                                <input type="number" class="form-control" name="priority" value="{{ old('priority', 0) }}" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Trạng thái</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="active" id="activeSwitch" checked>
                                    <label class="form-check-label" for="activeSwitch">Hoạt động</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Icon (Hình ảnh)</label>
                                <input type="file" class="form-control" name="icon" accept="image/*">
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.reward-items.index') }}" class="btn btn-light me-2">Hủy</a>
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
