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
                <h2 class="mb-0">Cài đặt chung</h2>
                <p class="text-muted">Quản lý thông tin chung của website</p>
            </div>
        </div>
    </div>
</div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.general.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tên trang web <span class="text-danger">*</span></label>
                                    <input type="text" name="site_name"
                                        class="form-control @error('site_name') is-invalid @enderror"
                                        value="{{ old('site_name', $configs['site_name']) }}"
                                        placeholder="Nhập tên trang web">
                                    @error('site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Từ khóa website</label>
                                    <input type="text" name="site_keywords"
                                        class="form-control @error('site_keywords') is-invalid @enderror"
                                        value="{{ old('site_keywords', $configs['site_keywords']) }}"
                                        placeholder="Nhập từ khóa website: shopacc, lienquan, accgame, ...">
                                    @error('site_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Mô tả trang web</label>
                                    <textarea name="site_description" class="form-control @error('site_description') is-invalid @enderror" rows="3"
                                        placeholder="Nhập mô tả trang web">{{ old('site_description', $configs['site_description']) }}</textarea>
                                    @error('site_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Phần thưởng Top Nạp Thẻ</label>
                                    <textarea id="top_deposit_reward" name="top_deposit_reward" class="form-control editor @error('top_deposit_reward') is-invalid @enderror" rows="5"
                                        placeholder="Nhập chi tiết phần thưởng top nạp thẻ...">{{ old('top_deposit_reward', $configs['top_deposit_reward']) }}</textarea>
                                    @error('top_deposit_reward')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Email liên hệ <span class="text-danger">*</span></label>
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $configs['email']) }}" placeholder="Nhập email liên hệ">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $configs['phone']) }}" placeholder="Nhập số điện thoại">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address', $configs['address']) }}" placeholder="Nhập địa chỉ">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Rút vàng tối thiểu</label>
                                    <input type="number" name="min_withdraw_gold"
                                        class="form-control @error('min_withdraw_gold') is-invalid @enderror"
                                        value="{{ old('min_withdraw_gold', $configs['min_withdraw_gold']) }}">
                                    @error('min_withdraw_gold')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Rút vàng tối đa</label>
                                    <input type="number" name="max_withdraw_gold"
                                        class="form-control @error('max_withdraw_gold') is-invalid @enderror"
                                        value="{{ old('max_withdraw_gold', $configs['max_withdraw_gold']) }}">
                                    @error('max_withdraw_gold')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Logo chính trang web</label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="site_logo" class="form-control @error('site_logo') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-logo')">
                                        <div class="image-uploads mt-2">
                                            @if(!empty($configs['site_logo']))
                                                <i class="ti ti-photo-plus text-primary" style="font-size: 40px; display:none;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold text-primary">Đổi Logo</h5>
                                            @else
                                                <i class="ti ti-photo-plus text-primary" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Tải lên</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Kéo thả hoặc click</p>
                                        </div>
                                    </div>
                                    @error('site_logo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 mt-3 text-center bg-light p-2 rounded border" style="min-height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <label class="form-label text-muted small w-100 text-start">Xem trước Logo:</label>
                                    @if (!empty($configs['site_logo']))
                                        <img id="preview-logo" src="{{ asset($configs['site_logo']) }}" alt="Logo" class="img-fluid" style="max-height: 80px; object-fit: contain;">
                                    @else
                                        <img id="preview-logo" src="" alt="Logo Preview" class="img-fluid" style="max-height: 80px; display: none; object-fit: contain;">
                                        <span id="preview-logo-placeholder" class="text-muted small">Chưa có logo</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Logo chân trang</label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #20c997; background: rgba(32, 201, 151, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="site_logo_footer" class="form-control @error('site_logo_footer') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/gif" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-logo-footer')">
                                        <div class="image-uploads mt-2">
                                            @if(!empty($configs['site_logo_footer']))
                                                <i class="ti ti-photo-plus text-success" style="font-size: 40px; display:none;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold text-success">Đổi Logo Footer</h5>
                                            @else
                                                <i class="ti ti-photo-plus text-success" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Tải lên</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Kéo thả hoặc click</p>
                                        </div>
                                    </div>
                                    @error('site_logo_footer')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 mt-3 text-center bg-light p-2 rounded border" style="min-height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <label class="form-label text-muted small w-100 text-start">Xem trước Logo Footer:</label>
                                    @if (!empty($configs['site_logo_footer']))
                                        <img id="preview-logo-footer" src="{{ asset($configs['site_logo_footer']) }}" alt="Logo Footer" class="img-fluid" style="max-height: 50px; object-fit: contain;">
                                    @else
                                        <img id="preview-logo-footer" src="" alt="Logo Footer Preview" class="img-fluid" style="max-height: 50px; display: none; object-fit: contain;">
                                        <span id="preview-logo-footer-placeholder" class="text-muted small">Chưa có logo</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Favicon trang web</label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #ff9f43; background: rgba(255, 159, 67, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="site_favicon" class="form-control @error('site_favicon') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/gif" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-favicon')">
                                        <div class="image-uploads mt-2">
                                            @if(!empty($configs['site_favicon']))
                                                <i class="ti ti-star text-warning" style="font-size: 40px; display:none;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold text-warning">Đổi Favicon</h5>
                                            @else
                                                <i class="ti ti-star text-warning" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Tải lên</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Kéo thả hoặc click</p>
                                        </div>
                                    </div>
                                    @error('site_favicon')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 mt-3 text-center bg-light p-2 rounded border" style="min-height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <label class="form-label text-muted small w-100 text-start">Xem trước Favicon:</label>
                                    @if (!empty($configs['site_favicon']))
                                        <img id="preview-favicon" src="{{ asset($configs['site_favicon']) }}" alt="Favicon" class="img-fluid" style="max-height: 50px; object-fit: contain;">
                                    @else
                                        <img id="preview-favicon" src="" alt="Favicon Preview" class="img-fluid" style="max-height: 50px; display: none; object-fit: contain;">
                                        <span id="preview-favicon-placeholder" class="text-muted small">Chưa có favicon</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh/GIF nút 'Xem ngay' <span class="text-muted small">(để trống sẽ dùng nút mặc định)</span></label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #e11d48; background: rgba(225, 29, 72, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="site_view_all_image" class="form-control @error('site_view_all_image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,image/svg+xml" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-view-all')">
                                        <div class="image-uploads mt-2">
                                            @if(!empty($configs['site_view_all_image']))
                                                <i class="ti ti-click text-danger" style="font-size: 40px; display:none;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold text-danger">Đổi Ảnh/GIF</h5>
                                            @else
                                                <i class="ti ti-click text-danger" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Tải lên</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Kéo thả hoặc click (hỗ trợ GIF)</p>
                                        </div>
                                    </div>
                                    @error('site_view_all_image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 mt-3 text-center bg-light p-2 rounded border" style="min-height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
                                    <label class="form-label text-muted small w-100 text-start">Xem trước:</label>
                                    @if (!empty($configs['site_view_all_image']))
                                        <img id="preview-view-all" src="{{ asset($configs['site_view_all_image']) }}" alt="Xem ngay" class="img-fluid" style="max-height: 50px; object-fit: contain;">
                                        <label class="form-check-label mt-2 text-danger small" style="cursor: pointer;">
                                            <input type="checkbox" name="remove_site_view_all_image" value="1"> Xóa ảnh (dùng nút CSS)
                                        </label>
                                    @else
                                        <img id="preview-view-all" src="" alt="Preview" class="img-fluid" style="max-height: 50px; display: none; object-fit: contain;">
                                        <span id="preview-view-all-placeholder" class="text-muted small">Đang dùng nút CSS mặc định</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="mb-3">
                                    <label class="form-label">Banner trang web <span class="text-muted">(Tải lên 1 hoặc nhiều ảnh để làm Slider)</span></label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 30px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="site_banner[]" multiple class="form-control @error('site_banner') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/gif" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewMultipleImages(this, 'preview-banners-container')">
                                        <div class="image-uploads mt-2">
                                            <i class="ti ti-photo-plus text-primary" style="font-size: 48px;"></i>
                                            <h5 class="mt-2 mb-0 fw-semibold text-primary">Kéo thả hoặc click để tải ảnh banner lên</h5>
                                            <p class="text-muted small mt-1">Hỗ trợ JPG, PNG, GIF</p>
                                        </div>
                                    </div>
                                    @error('site_banner')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 mt-3 bg-light p-3 rounded border">
                                    <label class="form-label text-muted small w-100">Ảnh banner hiện tại (Chọn Xóa nếu muốn bỏ ảnh cũ):</label>
                                    <div id="preview-banners-container" style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px;">
                                        @php
                                            $banners = json_decode($configs['site_banner'], true);
                                            if (!is_array($banners) && !empty($configs['site_banner'])) {
                                                $banners = [$configs['site_banner']];
                                            } elseif (empty($banners)) {
                                                $banners = [];
                                            }
                                        @endphp
                                        @if(count($banners) == 0)
                                            <span class="text-muted small w-100 text-center py-3">Chưa có banner nào</span>
                                        @endif
                                        @foreach($banners as $banner)
                                            <div class="banner-item" style="position: relative; display: inline-block; transition: 0.3s;">
                                                <img src="{{ asset($banner) }}" class="img-fluid" style="height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                                                <label class="form-label" style="position: absolute; top: 5px; right: 5px; background: rgba(220,38,38,0.9); color: white; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                                    <input type="checkbox" name="remove_banners[]" value="{{ $banner }}" style="display: none;" onchange="this.parentElement.parentElement.style.opacity = this.checked ? '0.4' : '1';">
                                                    <i class="ti ti-trash"></i> Xóa
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh bìa trang web</label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #6f42c1; background: rgba(111, 66, 193, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="site_share_image" class="form-control @error('site_share_image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/gif" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-share-image')">
                                        <div class="image-uploads mt-2">
                                            @if(!empty($configs['site_share_image']))
                                                <i class="ti ti-share text-purple" style="font-size: 40px; display:none;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold text-purple">Đổi ảnh bìa</h5>
                                            @else
                                                <i class="ti ti-share text-purple" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Tải lên</h5>
                                            @endif
                                            <p class="text-muted small mt-1">Kéo thả hoặc click</p>
                                        </div>
                                    </div>
                                    @error('site_share_image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 mt-3 text-center bg-light p-2 rounded border" style="min-height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <label class="form-label text-muted small w-100 text-start">Xem trước Ảnh bìa:</label>
                                    @if (!empty($configs['site_share_image']))
                                        <img id="preview-share-image" src="{{ asset($configs['site_share_image']) }}" alt="Image Share" class="img-fluid" style="max-height: 120px; object-fit: contain;">
                                    @else
                                        <img id="preview-share-image" src="" alt="Image Share Preview" class="img-fluid" style="max-height: 120px; display: none; object-fit: contain;">
                                        <span id="preview-share-image-placeholder" class="text-muted small">Chưa có ảnh bìa</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Lưu thay đổi</button>
                                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Hủy bỏ</a>
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
            let topDepositRewardEditor;
            if (document.querySelector('#top_deposit_reward')) {
                ClassicEditor
                    .create(document.querySelector('#top_deposit_reward'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', 'blockQuote', 'undo', 'redo']
                    })
                    .then(editor => {
                        topDepositRewardEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            document.querySelector('form').addEventListener('submit', function(e) {
                if (topDepositRewardEditor) {
                    document.querySelector('#top_deposit_reward').value = topDepositRewardEditor.getData();
                }
            });
        });

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result).show();
                    $('#' + previewId + '-placeholder').hide();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMultipleImages(input, containerId) {
            if (input.files) {
                var $container = $('#' + containerId);
                // Xóa các ảnh preview cũ (nhưng giữ lại các ảnh hiện có trong database nếu muốn, 
                // ở đây chúng ta có thể append vào cuối hoặc đánh dấu các ảnh preview mới)
                $container.find('.new-preview').remove();
                
                Array.from(input.files).forEach(file => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var html = `
                            <div class="banner-item new-preview" style="position: relative; display: inline-block;">
                                <img src="${e.target.result}" class="img-fluid" style="height: 120px; object-fit: cover; border-radius: 8px; border: 2px dashed #28c76f;">
                                <span class="badge bg-success" style="position: absolute; top: -5px; right: -5px;">Mới</span>
                            </div>
                        `;
                        $container.append(html);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
@endpush
