@extends('layouts.admin.app')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
<div >
<div >
    <div class="page-header">
        <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">{{ $title }}</h2>
                <p class="text-muted">Cập nhật tin tức hệ thống</p>
            </div>
        </div>
    </div>
</div>
    </div>

    <div class="card">
        <div class="card-body">
            <x-alert-error />
            <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-8 col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề tin tức <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $news->title) }}" placeholder="Nhập tiêu đề tin tức" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Mô tả ngắn <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Nhập mô tả ngắn gọn" required>{{ old('description', $news->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nội dung chi tiết <span class="text-danger">*</span></label>
                            <textarea name="content" id="summernote" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $news->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Ảnh đại diện <span class="text-muted">(Bỏ trống nếu không đổi)</span></label>
                            <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-thumb')">
                                <div class="image-uploads mt-2">
                                    <i class="ti ti-photo-plus text-primary" style="font-size: 40px; display: {{ $news->thumbnail ? 'none' : 'block' }};"></i>
                                    <h5 class="mt-2 mb-0 fw-semibold text-primary">{{ $news->thumbnail ? 'Đổi ảnh đại diện' : 'Kéo thả hoặc click để tải ảnh lên' }}</h5>
                                    <p class="text-muted small">Hỗ trợ JPG, PNG, GIF</p>
                                </div>
                            </div>
                            @error('thumbnail')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="mt-3 text-center bg-light p-2 rounded border" style="min-height: 150px; display: flex; align-items: center; justify-content: center; position: relative;">
                                @if($news->thumbnail)
                                    <div class="existing-news-thumb-wrapper d-inline-block" style="position: relative; display: inline-block;">
                                        <img id="preview-thumb" src="{{ asset($news->thumbnail) }}" alt="Preview Thumbnail" style="max-width: 100%; border-radius: 8px; object-fit: contain; max-height: 200px; display: block;">
                                        <button type="button"
                                            class="btn btn-danger remove-existing-thumb"
                                            title="Xoá ảnh này"
                                            aria-label="Xoá ảnh này"
                                            onclick="removeExistingNewsThumb(this)"
                                            style="position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; min-width: 24px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 18px; font-weight: 800; line-height: 1; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,.25);">×</button>
                                    </div>
                                @else
                                    <img id="preview-thumb" src="" alt="Preview Thumbnail" style="max-width: 100%; border-radius: 8px; object-fit: contain; max-height: 200px; display: none;">
                                @endif
                                <span id="preview-placeholder" class="text-muted" style="display: {{ $news->thumbnail ? 'none' : 'block' }};">Chưa có ảnh được chọn</span>
                            </div>
                        </div>
                        
                        <div class="card border border-light-subtle shadow-none mb-3">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Trạng thái xuất bản</h6>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', $news->active) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="active">Hiển thị công khai</label>
                                </div>
                                @error('active')
                                    <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-light border">Hủy</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Nhập nội dung tin tức...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    function removeExistingNewsThumb(button) {
        const item = button.closest('.existing-news-thumb-wrapper');
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
        $('#preview-placeholder').show();
    }

    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
