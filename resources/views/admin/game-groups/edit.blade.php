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
                <h2 class="mb-0">Chỉnh sửa danh mục mẹ</h2>
                <p class="text-muted">Cập nhật thông tin danh mục mẹ (Game Group)</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.game-groups.update', $gameGroup->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục mẹ <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $gameGroup->name) }}"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên danh mục mẹ">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Đường dẫn liên kết (Link)</label>
                                    <input type="text" name="link" value="{{ old('link', $gameGroup->link) }}"
                                        class="form-control @error('link') is-invalid @enderror" placeholder="VD: /danh-muc-lien-quan">
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" value="{{ old('slug', $gameGroup->slug) }}"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Thứ tự hiển thị (Order)</label>
                                    <input type="number" name="order" value="{{ old('order', $gameGroup->order) }}"
                                        class="form-control @error('order') is-invalid @enderror" placeholder="VD: 1">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện (Thumbnail)</label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                        <div class="image-uploads mt-2">
                                            @if($gameGroup->thumbnail)
                                                <img src="{{ asset($gameGroup->thumbnail) }}" alt="img" style="max-height: 80px; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                <h5 class="mb-0 fw-semibold">Đổi ảnh đại diện (Kéo thả hoặc click)</h5>
                                            @else
                                                <i class="ti ti-cloud-upload text-primary" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Kéo thả hoặc click để tải ảnh lên</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Hỗ trợ JPG, PNG, GIF</p>
                                        </div>
                                    </div>
                                    @error('thumbnail')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 d-flex align-items-center">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', $gameGroup->active) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="active">Kích hoạt hiển thị</label>
                                    </div>
                                    @error('active')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                                <a href="{{ route('admin.game-groups.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
