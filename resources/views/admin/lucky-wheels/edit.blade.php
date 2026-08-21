@extends('layouts.admin.app')
@section('title', $title)
@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }

        .editor-container {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .ck.ck-editor .ck-editor__top .ck-sticky-panel .ck-toolbar {
            border-top-right-radius: 4px;
            border-top-left-radius: 4px;
        }

        .ck.ck-editor .ck-editor__main {
            border-bottom-right-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        /* Responsive styles for mobile */
        @media (max-width: 767.98px) {

            .config-table th,
            .config-table td {
                padding: 0.5rem 0.25rem;
                font-size: 0.85rem;
            }

            .config-table input,
            .config-table select {
                font-size: 0.85rem;
                padding: 0.25rem 0.5rem;
                width: 100%;
            }

            .config-table .input-group-text {
                padding: 0.25rem 0.5rem;
                font-size: 0.85rem;
            }
        }
    </style>
@endpush

@section('content')
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Chỉnh sửa vòng quay may mắn</h2>
                <p class="text-muted">Cập nhật thông tin vòng quay may mắn</p>
            </div>
        </div>
    </div>
</div>
                <div class="page-btn">
                    <a href="{{ route('admin.lucky-wheels.index') }}" class="btn btn-success">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi!</strong> Đã xảy ra lỗi khi cập nhật vòng quay may mắn. Vui lòng kiểm tra lại thông tin.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form id="luckyWheelEditForm" action="{{ route('admin.lucky-wheels.update', $luckyWheel->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-8 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Tên vòng quay <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $luckyWheel->name) }}" required
                                        placeholder="Nhập tên vòng quay" autocomplete="off">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="price_per_spin">Giá mỗi lượt quay (VNĐ) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price_per_spin') is-invalid @enderror"
                                        id="price_per_spin" name="price_per_spin"
                                        value="{{ old('price_per_spin', $luckyWheel->price_per_spin) }}" required
                                        placeholder="Nhập giá mỗi lượt quay" min="0" step="1000">
                                    @error('price_per_spin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12 d-flex align-items-center mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', $luckyWheel->active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="active">Hoạt động (Kích hoạt vòng quay)</label>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Hình ảnh</h6>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" id="thumbnail" onchange="previewImage(this, 'preview-thumbnail')">
                                        <div class="image-uploads mt-2">
                                            @if($luckyWheel->thumbnail)
                                                <div class="existing-thumb-wrapper d-inline-block" style="position: relative; display: inline-block;">
                                                    <img src="{{ asset($luckyWheel->thumbnail) }}" alt="img" style="max-height: 80px; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                    <button type="button"
                                                        class="btn btn-danger remove-existing-thumb"
                                                        title="Xoá ảnh này"
                                                        aria-label="Xoá ảnh này"
                                                        onclick="removeExistingWheelThumb(this)"
                                                        style="position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; min-width: 24px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 18px; font-weight: 800; line-height: 1; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,.25);">×</button>
                                                </div>
                                                <h5 class="mb-0 fw-semibold text-primary">Đổi ảnh đại diện (Kéo thả hoặc click)</h5>
                                            @else
                                                <i class="ti ti-photo-plus text-primary" style="font-size: 40px;"></i>
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

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh vòng quay <span class="text-danger">*</span></label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #20c997; background: rgba(32, 201, 151, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="wheel_image" class="form-control @error('wheel_image') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" id="wheel_image" onchange="previewImage(this, 'preview-wheel')">
                                        <div class="image-uploads mt-2">
                                            @if($luckyWheel->wheel_image)
                                                <div class="existing-wheel-wrapper d-inline-block" style="position: relative; display: inline-block;">
                                                    <img src="{{ asset($luckyWheel->wheel_image) }}" alt="img" style="max-height: 80px; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                    <button type="button"
                                                        class="btn btn-danger remove-existing-wheel"
                                                        title="Xoá ảnh này"
                                                        aria-label="Xoá ảnh này"
                                                        onclick="removeExistingWheelImage(this)"
                                                        style="position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; min-width: 24px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 18px; font-weight: 800; line-height: 1; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,.25);">×</button>
                                                </div>
                                                <h5 class="mb-0 fw-semibold text-success">Đổi ảnh vòng quay (Kéo thả hoặc click)</h5>
                                            @else
                                                <i class="ti ti-loader text-success" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold text-success">Kéo thả hoặc click để tải ảnh vòng quay lên</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Hỗ trợ JPG, PNG, GIF</p>
                                        </div>
                                    </div>
                                    @error('wheel_image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 text-center mt-3 mb-4 bg-light p-3 rounded border">
                                <h6 class="mb-3 fw-bold text-muted">Xem trước ảnh</h6>
                                <div class="d-flex flex-wrap justify-content-around gap-3">
                                    <div class="text-center">
                                        <p class="mb-2 fw-semibold text-primary">Ảnh đại diện:</p>
                                        <div class="bg-white p-2 border rounded shadow-sm d-inline-block">
                                            <img id="preview-thumbnail" src="{{ asset($luckyWheel->thumbnail) }}"
                                                alt="Thumbnail Preview" style="max-width: 150px; max-height: 150px; object-fit: contain;">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <p class="mb-2 fw-semibold text-success">Ảnh vòng quay:</p>
                                        <div class="bg-white p-2 border rounded shadow-sm d-inline-block">
                                            <img id="preview-wheel" src="{{ asset($luckyWheel->wheel_image) }}" alt="Wheel Preview"
                                                style="max-width: 150px; max-height: 150px; object-fit: contain;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Thông tin & Thể lệ</h6>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="description">Mô tả vòng quay</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $luckyWheel->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="mb-3">
                                    <label class="form-label" for="rules">Thể lệ vòng quay <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('rules') is-invalid @enderror" id="rules" name="rules">{{ old('rules', $luckyWheel->rules) }}</textarea>
                                    @error('rules')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phần cấu hình phần thưởng -->
                            <div class="col-lg-12 mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Cấu hình phần thưởng (8 ô)</h5>
                                <h5 class="fw-bold mb-3 text-warning"><i class="ti ti-gift me-2"></i>Cấu hình phần thưởng (8 ô)</h5>
                                <div class="row g-3">
                                    @for ($i = 0; $i < 8; $i++)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                            <div class="card border border-2 border-light shadow-sm h-100">
                                                <div class="card-header bg-transparent border-bottom-0 pt-3 pb-0">
                                                    <h6 class="fw-bold text-primary border-start border-3 border-warning ps-2 mb-0">Phần Thưởng #{{ $i + 1 }}</h6>
                                                </div>
                                                <div class="card-body pt-2">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Tên phần thưởng</label>
                                                        <input type="text" name="config[{{ $i }}][content]" value="{{ isset($config[$i]['content']) ? $config[$i]['content'] : '' }}" class="form-control form-control-sm" required placeholder="VD: 19999 Kim Cương">
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Tỉ lệ trúng (%)</label>
                                                        <input type="number" name="config[{{ $i }}][probability]" value="{{ isset($config[$i]['probability']) ? $config[$i]['probability'] : '' }}" class="form-control form-control-sm" min="0" max="100" step="0.1" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Tỉ lệ quay thử (%)</label>
                                                        <input type="number" name="config[{{ $i }}][trial_probability]" value="{{ isset($config[$i]['trial_probability']) ? $config[$i]['trial_probability'] : '' }}" class="form-control form-control-sm" min="0" max="100" step="0.1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Loại phần thưởng</label>
                                                        <select name="config[{{ $i }}][reward_type]" class="form-select form-select-sm" required>
                                                            <option value="empty" {{ (isset($config[$i]['reward_type']) && $config[$i]['reward_type'] == 'empty') ? 'selected' : '' }}>Không trúng / Mất lượt</option>
                                                            <option value="money" {{ (isset($config[$i]['reward_type']) && $config[$i]['reward_type'] == 'money') ? 'selected' : '' }}>Cộng tiền shop (VNĐ)</option>
                                                            <option value="item" {{ (isset($config[$i]['reward_type']) && $config[$i]['reward_type'] == 'item') ? 'selected' : '' }}>Vật phẩm game</option>
                                                            <option value="random_account" {{ (isset($config[$i]['reward_type']) && $config[$i]['reward_type'] == 'random_account') ? 'selected' : '' }}>Nick ngẫu nhiên</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Vật phẩm liên kết</label>
                                                        <select name="config[{{ $i }}][reward_item_id]" class="form-select form-select-sm">
                                                            <option value="">-- Chọn vật phẩm --</option>
                                                            @foreach($rewardItems as $item)
                                                                <option value="{{ $item->id }}" {{ (isset($config[$i]['reward_item_id']) && $config[$i]['reward_item_id'] == $item->id) ? 'selected' : '' }}>
                                                                    {{ $item->name }} ({{ $item->game_name }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Số lượng nhận</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" name="config[{{ $i }}][amount]" value="{{ isset($config[$i]['amount']) ? $config[$i]['amount'] : '' }}" class="form-control">
                                                            <span class="input-group-text bg-light text-muted" style="font-size: 0.75rem;">Phần thưởng</span>
                                                        </div>
                                                        <small class="text-muted" style="font-size: 0.7rem;">Số cố định (100) hoặc khoảng (40:80)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="mb-3 mb-0 text-end">
                                    <a href="{{ route('admin.lucky-wheels.index') }}" class="btn btn-secondary">Hủy</a>
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        function removeExistingWheelThumb(button) {
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
            const previewThumb = document.getElementById('preview-thumbnail');
            if (previewThumb) previewThumb.src = 'https://i.imgur.com/NpL6V6y.png';
        }

        function removeExistingWheelImage(button) {
            const item = button.closest('.existing-wheel-wrapper');
            const form = button.closest('form');
            if (!form) return;

            const removedInput = document.createElement('input');
            removedInput.type = 'hidden';
            removedInput.name = 'remove_wheel_image';
            removedInput.value = '1';
            form.appendChild(removedInput);

            if (item) {
                item.remove();
            }
            const previewWheel = document.getElementById('preview-wheel');
            if (previewWheel) previewWheel.src = 'https://i.imgur.com/NpL6V6y.png';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo CKEditor cho mô tả
            let descriptionEditor;
            if (document.querySelector('#description')) {
                ClassicEditor
                    .create(document.querySelector('#description'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        descriptionEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Khởi tạo CKEditor cho thể lệ
            let rulesEditor;
            if (document.querySelector('#rules')) {
                ClassicEditor
                    .create(document.querySelector('#rules'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        rulesEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Xử lý xem trước hình ảnh
            function previewImage(input, previewId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(previewId).src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Bắt sự kiện thay đổi ảnh đại diện
            document.getElementById('thumbnail').addEventListener('change', function() {
                previewImage(this, 'preview-thumbnail');
            });

            // Bắt sự kiện thay đổi ảnh vòng quay
            document.getElementById('wheel_image').addEventListener('change', function() {
                previewImage(this, 'preview-wheel');
            });

            // Xử lý loại phần thưởng
            const rewardTypes = document.querySelectorAll('.reward-type');
            rewardTypes.forEach(input => {
                input.addEventListener('input', function() {
                    const index = this.getAttribute('data-index');
                    const value = this.value;
                    const symbolElement = document.querySelector(`.reward-symbol-${index}`);
                    symbolElement.textContent = value || '...';
                });
            });

            // Xử lý form submit
            const editForm = document.getElementById('luckyWheelEditForm');
            if (editForm) {
                editForm.addEventListener('submit', function() {
                    // Cập nhật dữ liệu từ CKEditor vào textarea
                    if (descriptionEditor) {
                        document.querySelector('#description').value = descriptionEditor.getData();
                    }

                    if (rulesEditor) {
                        document.querySelector('#rules').value = rulesEditor.getData();
                    }
                });
            }
        });
    </script>
@endpush
