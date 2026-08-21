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
                <h2 class="mb-0">Chỉnh sửa danh mục game</h2>
                <p class="text-muted">Cập nhật thông tin danh mục game</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên danh mục sản phẩm">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                                        class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Danh mục mẹ (Game Group)</label>
                                    <select name="game_group_id" class="form-select @error('game_group_id') is-invalid @enderror">
                                        <option value="">-- Không có --</option>
                                        @foreach($gameGroups as $group)
                                            <option value="{{ $group->id }}" {{ old('game_group_id', $category->game_group_id) == $group->id ? 'selected' : '' }}>
                                                {{ $group->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('game_group_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Nền tảng</label>
                                    <input list="platforms" type="text" name="platform" value="{{ old('platform', $category->platform) }}"
                                        class="form-control @error('platform') is-invalid @enderror"
                                        placeholder="VD: LOL">
                                    <datalist id="platforms">
                                        <option value="LOL">
                                        <option value="PUBG">
                                        <option value="LMHT">
                                        <option value="Free Fire">
                                        <option value="Valorant">
                                    </datalist>
                                    @error('platform')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 d-flex align-items-center mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', $category->active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="active">Kích hoạt hiển thị</label>
                                </div>
                                @error('active')
                                    <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Cài đặt Flash Sale (Tùy chọn)</h6>
                            </div>
                            
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label d-block">Có phải Flash Sale?</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="is_flash_sale" id="is_flash_sale" value="1" {{ old('is_flash_sale', $category->is_flash_sale) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="is_flash_sale">Bật Flash Sale</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giá cũ (Sale)</label>
                                    <input type="number" name="flash_sale_old_price" class="form-control" value="{{ old('flash_sale_old_price', $category->flash_sale_old_price) }}" placeholder="VD: 500000">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giá mới (Sale)</label>
                                    <input type="number" name="flash_sale_new_price" class="form-control" value="{{ old('flash_sale_new_price', $category->flash_sale_new_price) }}" placeholder="VD: 250000">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Thời gian kết thúc Sale</label>
                                    <input type="datetime-local" name="flash_sale_end_time" class="form-control" value="{{ old('flash_sale_end_time', $category->flash_sale_end_time ? \Carbon\Carbon::parse($category->flash_sale_end_time)->format('Y-m-d\TH:i') : '') }}">
                                </div>
                            </div>

                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Hình ảnh</h6>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-cat-edit-thumb')">
                                        <div class="image-uploads mt-2">
                                            @if($category->thumbnail)
                                                <div class="existing-thumb-wrapper d-inline-block" style="position: relative; display: inline-block;">
                                                    <img id="preview-cat-edit-thumb" src="{{ asset($category->thumbnail) }}" alt="img" style="max-height: 80px; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                    <button type="button"
                                                        class="btn btn-danger remove-existing-thumb"
                                                        title="Xoá ảnh này"
                                                        aria-label="Xoá ảnh này"
                                                        onclick="removeExistingCategoryThumb(this)"
                                                        style="position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; min-width: 24px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 18px; font-weight: 800; line-height: 1; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,.25);">×</button>
                                                </div>
                                                <h5 class="mb-0 fw-semibold">Đổi ảnh đại diện (Kéo thả hoặc click)</h5>
                                            @else
                                                <img id="preview-cat-edit-thumb" src="" alt="Preview" style="max-height: 80px; display:none; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                <i class="ti ti-photo-plus text-primary" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Kéo thả hoặc click để tải ảnh lên</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Hỗ trợ JPG, PNG, GIF, WEBP</p>
                                        </div>
                                    </div>
                                    @error('thumbnail')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh Tag (Mua Nhiều, Hot...)</label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #ffb822; background: rgba(255, 184, 34, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="tag_image" class="form-control @error('tag_image') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-cat-edit-tag')">
                                        <div class="image-uploads mt-2">
                                            @if($category->tag_image)
                                                <div class="existing-tag-wrapper d-inline-block" style="position: relative; display: inline-block;">
                                                    <img id="preview-cat-edit-tag" src="{{ asset($category->tag_image) }}" alt="img" style="max-height: 50px; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                    <button type="button"
                                                        class="btn btn-danger remove-existing-tag"
                                                        title="Xoá ảnh này"
                                                        aria-label="Xoá ảnh này"
                                                        onclick="removeExistingCategoryTag(this)"
                                                        style="position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; min-width: 24px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 18px; font-weight: 800; line-height: 1; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,.25);">×</button>
                                                </div>
                                                <h5 class="mb-0 fw-semibold text-warning">Đổi ảnh Tag (Kéo thả hoặc click)</h5>
                                            @else
                                                <img id="preview-cat-edit-tag" src="" alt="Preview" style="max-height: 50px; display:none; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                <i class="ti ti-star text-warning" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold text-warning">Kéo thả ảnh Tag vào đây</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Hỗ trợ ảnh PNG trong suốt, GIF, WEBP</p>
                                        </div>
                                    </div>
                                    @error('tag_image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Mô tả <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Nhập mô tả chi tiết danh mục">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy bỏ</a>
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
        function removeExistingCategoryThumb(button) {
            const item = button.closest('.existing-thumb-wrapper');
            const form = button.closest('form');
            if (!form) return;

            const removedInput = document.createElement('input');
            removedInput.type = 'hidden';
            removedInput.name = 'remove_thumbnail';
            removedInput.value = '1';
            form.appendChild(removedInput);

            if (item) {
                item.remove();
            }
        }

        function removeExistingCategoryTag(button) {
            const item = button.closest('.existing-tag-wrapper');
            const form = button.closest('form');
            if (!form) return;

            const removedInput = document.createElement('input');
            removedInput.type = 'hidden';
            removedInput.name = 'remove_tag_image';
            removedInput.value = '1';
            form.appendChild(removedInput);

            if (item) {
                item.remove();
            }
        }
    </script>
@endpush
