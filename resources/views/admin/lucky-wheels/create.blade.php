@extends('layouts.admin.app')
@section('title', $title)
@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }

        .config-table th,
        .config-table td {
            padding: 0.5rem 0.25rem;
        }

        @media (max-width: 767.98px) {

            .config-table input,
            .config-table select {
                font-size: 0.85rem;
                width: 100%;
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
                <h2 class="mb-0">Thêm vòng quay may mắn</h2>
                <p class="text-muted">Tạo mới vòng quay may mắn</p>
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
                    <strong>Lỗi!</strong> Đã xảy ra lỗi khi tạo mới vòng quay may mắn.
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
                    <form id="luckyWheelForm" action="{{ route('admin.lucky-wheels.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Tên vòng quay <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Nhập tên vòng quay" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="price_per_spin">Giá mỗi lượt quay (VNĐ) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price_per_spin') is-invalid @enderror" id="price_per_spin" name="price_per_spin"
                                        value="{{ old('price_per_spin', 10000) }}" required min="0" step="1000">
                                </div>
                            </div>
                            
                            <div class="col-lg-12 d-flex align-items-center mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', '1') == '1' ? 'checked' : '' }}>
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
                                        <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-thumbnail')">
                                        <div class="image-uploads mt-2">
                                            <i class="ti ti-photo-plus text-primary" style="font-size: 40px;"></i>
                                            <h5 class="mt-2 mb-0 fw-semibold">Kéo thả hoặc click để tải ảnh lên</h5>
                                            <p class="text-muted small">Hỗ trợ JPG, PNG, GIF</p>
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
                                        <input type="file" name="wheel_image" class="form-control @error('wheel_image') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-wheel')">
                                        <div class="image-uploads mt-2">
                                            <i class="ti ti-loader text-success" style="font-size: 40px;"></i>
                                            <h5 class="mt-2 mb-0 fw-semibold text-success">Kéo thả hoặc click để tải ảnh vòng quay lên</h5>
                                            <p class="text-muted small">Hỗ trợ JPG, PNG, GIF</p>
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
                                            <img id="preview-thumbnail" src="https://i.imgur.com/NpL6V6y.png"
                                                alt="Thumbnail Preview" style="max-width: 150px; max-height: 150px; object-fit: contain;">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <p class="mb-2 fw-semibold text-success">Ảnh vòng quay:</p>
                                        <div class="bg-white p-2 border rounded shadow-sm d-inline-block">
                                            <img id="preview-wheel" src="https://i.imgur.com/NpL6V6y.png" alt="Wheel Preview"
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
                                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="mb-3">
                                    <label class="form-label" for="rules">Thể lệ vòng quay <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="rules" name="rules">{{ old('rules') }}</textarea>
                                </div>
                            </div>

                            <!-- Phần cấu hình phần thưởng -->
                            <div class="col-lg-12 mt-3">
                                <h5 class="fw-bold mb-3 text-warning"><i class="ti ti-gift me-2"></i>Cấu hình phần thưởng (8 ô)</h5>
                                <div class="alert alert-info py-2">
                                    Tổng tỉ lệ trúng: <strong id="probabilityTotal">0%</strong> · Tổng tỉ lệ quay thử: <strong id="trialProbabilityTotal">0%</strong>. Cả hai phải bằng 100%.
                                </div>
                                <div class="row g-3">
                                    @php
                                        $oldConfig = old('config', $defaultConfig);
                                    @endphp

                                    @for ($i = 0; $i < 8; $i++)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                            <div class="card border border-2 border-light shadow-sm h-100">
                                                <div class="card-header bg-transparent border-bottom-0 pt-3 pb-0">
                                                    <h6 class="fw-bold text-primary border-start border-3 border-warning ps-2 mb-0">Phần Thưởng #{{ $i + 1 }}</h6>
                                                </div>
                                                <div class="card-body pt-2">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Tên phần thưởng</label>
                                                        <input type="text" name="config[{{ $i }}][content]" value="{{ $oldConfig[$i]['content'] ?? '' }}" class="form-control form-control-sm" required placeholder="Text hiện khi quay trúng">
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Tỉ lệ trúng (%)</label>
                                                        <input type="number" name="config[{{ $i }}][probability]" value="{{ isset($oldConfig[$i]['probability']) ? $oldConfig[$i]['probability'] : '' }}" class="form-control form-control-sm" min="0" max="100" step="0.1" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Tỉ lệ quay thử (%)</label>
                                                        <input type="number" name="config[{{ $i }}][trial_probability]" value="{{ isset($oldConfig[$i]['trial_probability']) ? $oldConfig[$i]['trial_probability'] : '' }}" class="form-control form-control-sm" min="0" max="100" step="0.1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Loại phần thưởng</label>
                                                        <select name="config[{{ $i }}][reward_type]" class="form-select form-select-sm" required>
                                                            <option value="empty" {{ (isset($oldConfig[$i]['reward_type']) && $oldConfig[$i]['reward_type'] == 'empty') ? 'selected' : '' }}>Không trúng / Mất lượt</option>
                                                            <option value="money" {{ (isset($oldConfig[$i]['reward_type']) && $oldConfig[$i]['reward_type'] == 'money') ? 'selected' : '' }}>Cộng tiền shop (VNĐ)</option>
                                                            <option value="item" {{ (isset($oldConfig[$i]['reward_type']) && $oldConfig[$i]['reward_type'] == 'item') ? 'selected' : '' }}>Vật phẩm game</option>
                                                            <option value="random_account" {{ (isset($oldConfig[$i]['reward_type']) && $oldConfig[$i]['reward_type'] == 'random_account') ? 'selected' : '' }}>Nick ngẫu nhiên</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Vật phẩm liên kết</label>
                                                        <select name="config[{{ $i }}][reward_item_id]" class="form-select form-select-sm">
                                                            <option value="">-- Chọn vật phẩm --</option>
                                                            @foreach($rewardItems as $item)
                                                                <option value="{{ $item->id }}" {{ (isset($oldConfig[$i]['reward_item_id']) && $oldConfig[$i]['reward_item_id'] == $item->id) ? 'selected' : '' }}>
                                                                    {{ $item->name }} ({{ $item->game_name }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label small fw-semibold text-muted mb-1">Số lượng nhận</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" name="config[{{ $i }}][amount]" value="{{ isset($oldConfig[$i]['amount']) ? $oldConfig[$i]['amount'] : '' }}" class="form-control">
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
                                    <button type="submit" id="submitButton" class="btn btn-primary">Thêm mới</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const updateProbabilityTotals = function() {
                const total = Array.from(document.querySelectorAll('[name$="[probability]"]')).reduce((sum, input) => sum + (Number(input.value) || 0), 0);
                const trialTotal = Array.from(document.querySelectorAll('[name$="[trial_probability]"]')).reduce((sum, input) => sum + (Number(input.value) || 0), 0);
                document.getElementById('probabilityTotal').textContent = total.toFixed(1).replace('.0', '') + '%';
                document.getElementById('trialProbabilityTotal').textContent = trialTotal.toFixed(1).replace('.0', '') + '%';
            };
            document.querySelectorAll('[name$="[probability]"], [name$="[trial_probability]"]').forEach(input => input.addEventListener('input', updateProbabilityTotals));
            updateProbabilityTotals();

            // Khởi tạo CKEditor cho mô tả
            let descriptionEditor;
            if (document.querySelector('#description')) {
                ClassicEditor
                    .create(document.querySelector('#description'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList']
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
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList']
                    })
                    .then(editor => {
                        rulesEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Xử lý form submit
            document.getElementById('luckyWheelForm').addEventListener('submit', function() {
                // Cập nhật dữ liệu từ CKEditor vào textarea
                if (descriptionEditor) {
                    document.querySelector('#description').value = descriptionEditor.getData();
                }

                if (rulesEditor) {
                    document.querySelector('#rules').value = rulesEditor.getData();
                }
            });
        });
    </script>
@endpush
