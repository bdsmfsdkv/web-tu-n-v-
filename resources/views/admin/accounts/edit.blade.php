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
                <h2 class="mb-0">Chỉnh sửa tài khoản game</h2>
                <p class="text-muted">Cập nhật thông tin tài khoản game</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if ($account->status == 'sold' && $account->buyer_id)
                            <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                                <i class="ti ti-alert-circle me-2 fs-4"></i>
                                <div>
                                    Tài khoản này đã được bán cho khách hàng: 
                                    <a href="{{ route('admin.users.show', $account->buyer_id) }}" target="_blank" class="fw-bold text-dark text-decoration-underline">{{ optional($account->buyer)->username ?? 'Không rõ' }}</a>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Danh mục game <span class="text-danger">*</span></label>
                                    <select name="game_category_id" id="game_category_id"
                                        class="form-select @error('game_category_id') is-invalid @enderror">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                data-slug="{{ $category->slug }}"
                                                data-platform="{{ $category->platform }}"
                                                data-group="{{ optional($category->gameGroup)->slug }}"
                                                {{ old('game_category_id', $account->game_category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }} {{ $category->gameGroup ? '(' . $category->gameGroup->name . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('game_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tên tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_name"
                                        value="{{ old('account_name', $account->account_name) }}"
                                        class="form-control @error('account_name') is-invalid @enderror" placeholder="Nhập tên đăng nhập">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="text" name="password" value="{{ old('password', $account->password) }}"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giá tiền <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price', $account->price) }}"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="VD: 50000">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 d-flex align-items-center mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="status" value="available" {{ old('status', $account->status) == 'available' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="status">Đang mở bán (Bỏ chọn để đánh dấu Đã bán)</label>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback d-block ms-3">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-lg-12">
                                <hr class="my-4">
                                <div class="mb-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                        <div>
                                            <h6 class="mb-1 fw-bold">Thuộc tính đa dạng (Liên Quân, FF, Blox Fruits, NRO...)</h6>
                                            <p class="text-muted mb-0 small">Thêm các thuộc tính hoặc chọn mẫu game để nạp nhanh</p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-wand me-1"></i> Nạp mẫu thuộc tính nhanh
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                    @foreach($gamePresets as $presetKey => $presetData)
                                                        <li>
                                                            <a class="dropdown-item btn-load-preset" href="javascript:void(0)" data-preset="{{ $presetKey }}">
                                                                {{ $presetData['name'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-attribute">
                                                <i class="ti ti-plus me-1"></i> Thêm thuộc tính
                                            </button>
                                        </div>
                                    </div>
                                    <div id="dynamic-attributes" class="bg-light p-3 rounded border">
                                        @php
                                            $details = old('details', is_array($account->details) ? $account->details : json_decode($account->details, true) ?? []);
                                        @endphp
                                        @if(is_array($details) && count($details) > 0)
                                            @foreach($details as $index => $detail)
                                                <div class="row align-items-center mb-2 attribute-row bg-white p-2 rounded border mx-0 shadow-sm">
                                                    <div class="col-md-4 col-12 mb-1 mb-md-0">
                                                        <input type="text" name="details[{{ $index }}][key]" class="form-control form-control-sm fw-semibold" value="{{ $detail['key'] ?? '' }}" placeholder="Tên thuộc tính (VD: Rank)" required>
                                                    </div>
                                                    <div class="col-md-6 col-10">
                                                        <input type="text" name="details[{{ $index }}][value]" class="form-control form-control-sm" value="{{ $detail['value'] ?? '' }}" placeholder="Giá trị (VD: Kim Cương)" required>
                                                    </div>
                                                    <div class="col-md-2 col-2 text-end">
                                                        <button type="button" class="btn btn-outline-danger btn-sm remove-attribute"><i class="ti ti-trash"></i></button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Hình ảnh</h6>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="thumb" class="form-control @error('thumb') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-acc-edit-thumb')">
                                        <div class="image-uploads mt-2">
                                            @if ($account->thumb)
                                                <img id="preview-acc-edit-thumb" src="{{ asset($account->thumb) }}" alt="img" style="max-height: 80px; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                <h5 class="mb-0 fw-semibold">Đổi ảnh đại diện (Kéo thả hoặc click)</h5>
                                            @else
                                                <img id="preview-acc-edit-thumb" src="" alt="Preview" style="max-height: 80px; display:none; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                <i class="ti ti-photo-plus text-primary" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Kéo thả hoặc click để tải ảnh lên</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Hỗ trợ JPG, PNG, GIF, WEBP</p>
                                        </div>
                                    </div>
                                    @error('thumb')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh chi tiết (Nhiều ảnh)</label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #20c997; background: rgba(32, 201, 151, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="images[]" multiple class="form-control @error('images') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewMultipleImages(this, 'preview-acc-edit-images')">
                                        <div class="image-uploads mt-2">
                                            <i class="ti ti-photos text-success" style="font-size: 40px;"></i>
                                            <h5 class="mt-2 mb-0 fw-semibold text-success">Kéo thả hoặc click để tải lên nhiều ảnh</h5>
                                            <p class="text-muted small">Hỗ trợ tải lên nhiều file cùng lúc. Sẽ thay thế các ảnh cũ (nếu có).</p>
                                        </div>
                                    </div>
                                    <div id="preview-acc-edit-images" class="d-flex flex-wrap gap-2 mt-2"></div>
                                    @error('images')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    
                                    @if ($account->images)
                                        <div class="mt-3 bg-light p-3 rounded">
                                            <label class="form-label fw-semibold text-muted d-block mb-2">Các ảnh chi tiết hiện tại:</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach (json_decode($account->images) as $image)
                                                    <div class="border rounded p-1 bg-white">
                                                        <img src="{{ asset($image) }}" alt="preview" style="height: 80px; width: auto; object-fit: contain;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú (Tùy chọn)</label>
                                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="4" placeholder="Ghi chú chi tiết về tài khoản này...">{{ old('note', $account->note) }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                                <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">Hủy bỏ</a>
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
        const gamePresets = @json($gamePresets);

        function getPresetForCategory(slug, platform, groupSlug) {
            const searchKeys = [slug, platform, groupSlug].filter(Boolean);
            for (const key of searchKeys) {
                const normKey = key.toLowerCase();
                for (const [presetKey, preset] of Object.entries(gamePresets)) {
                    if (presetKey === normKey) return preset;
                    if (preset.aliases && preset.aliases.some(alias => normKey.includes(alias) || alias.includes(normKey))) {
                        return preset;
                    }
                }
            }
            return null;
        }

        $(document).ready(function() {
            let attrIndex = {{ isset($details) && is_array($details) ? count($details) : 0 }};

            function addAttributeRow(key = '', value = '', options = null, suggestions = null) {
                let valueInputHtml = '';
                const datalistId = `dl-${attrIndex}-${Math.random().toString(36).substring(2, 7)}`;

                if (options && Array.isArray(options) && options.length > 0) {
                    let optionsHtml = `<option value="">-- Chọn ${key} --</option>`;
                    options.forEach(opt => {
                        const selected = opt === value ? 'selected' : '';
                        optionsHtml += `<option value="${opt}" ${selected}>${opt}</option>`;
                    });
                    valueInputHtml = `
                        <select name="details[${attrIndex}][value]" class="form-select form-select-sm" required>
                            ${optionsHtml}
                        </select>
                    `;
                } else if (suggestions && Array.isArray(suggestions) && suggestions.length > 0) {
                    let dlHtml = `<datalist id="${datalistId}">`;
                    suggestions.forEach(sug => {
                        dlHtml += `<option value="${sug}">`;
                    });
                    dlHtml += `</datalist>`;
                    valueInputHtml = `
                        <input type="text" list="${datalistId}" name="details[${attrIndex}][value]" value="${value}" class="form-control form-control-sm" placeholder="Nhập hoặc chọn gợi ý..." required>
                        ${dlHtml}
                    `;
                } else {
                    valueInputHtml = `
                        <input type="text" name="details[${attrIndex}][value]" value="${value}" class="form-control form-control-sm" placeholder="Giá trị..." required>
                    `;
                }

                $('#dynamic-attributes').append(`
                    <div class="row align-items-center mb-2 attribute-row bg-white p-2 rounded border mx-0 shadow-sm">
                        <div class="col-md-4 col-12 mb-1 mb-md-0">
                            <input type="text" name="details[${attrIndex}][key]" value="${key}" class="form-control form-control-sm fw-semibold" placeholder="Tên thuộc tính (VD: Rank)" required>
                        </div>
                        <div class="col-md-6 col-10">
                            ${valueInputHtml}
                        </div>
                        <div class="col-md-2 col-2 text-end">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-attribute"><i class="ti ti-trash"></i></button>
                        </div>
                    </div>
                `);
                attrIndex++;
            }

            function loadPreset(presetKey) {
                if (!gamePresets[presetKey]) return;
                const preset = gamePresets[presetKey];
                $('#dynamic-attributes').empty();
                attrIndex = 0;
                
                preset.attributes.forEach(attr => {
                    addAttributeRow(attr.key, '', attr.options || null, attr.suggestions || null);
                });
            }

            // Manual preset click
            $(document).on('click', '.btn-load-preset', function() {
                const presetKey = $(this).data('preset');
                loadPreset(presetKey);
            });

            $('#add-attribute').click(function() {
                addAttributeRow();
            });

            $(document).on('click', '.remove-attribute', function() {
                $(this).closest('.attribute-row').remove();
            });
        });

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMultipleImages(input, previewId) {
            var preview = document.getElementById(previewId);
            preview.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '200px';
                        img.style.maxHeight = '200px';
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
@endpush
