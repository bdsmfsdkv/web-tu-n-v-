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
                <h2 class="mb-0">Thêm Tài Khoản Random</h2>
                <p class="text-muted">Tạo tài khoản random mới</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.random-accounts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select name="random_category_id"
                                        class="form-select @error('random_category_id') is-invalid @enderror">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('random_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('random_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giá (tùy chọn)</label>
                                    <input type="number" name="price" value="{{ old('price') }}"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="Nếu để trống sẽ lấy theo giá danh mục">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Danh sách tài khoản</h6>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="mb-3">
                                    <div class="alert alert-info py-2 mb-2 d-flex align-items-center justify-content-between" role="alert">
                                        <div>
                                            <i class="ti ti-info-circle me-2 fs-5"></i>
                                            <small>Mỗi tài khoản một dòng, định dạng: <strong>username|password</strong>. Hoặc <strong>Chúc bạn may mắn lần sau</strong></small>
                                        </div>
                                        <label for="txtFile" class="btn btn-sm btn-outline-primary mb-0 cursor-pointer">
                                            <i class="ti ti-upload me-1"></i> Tải lên file .txt
                                        </label>
                                        <input type="file" id="txtFile" accept=".txt" style="display: none;" onchange="readTxtFile(this)">
                                    </div>
                                    <textarea name="accounts" id="accountsTextarea" rows="8" class="form-control font-monospace bg-light @error('accounts') is-invalid @enderror"
                                        placeholder="user1|pass123&#10;user2|pass456&#10;Chúc bạn may mắn lần sau">{{ old('accounts') }}</textarea>
                                    @error('accounts')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Hình ảnh & Ghi chú</h6>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện <span class="text-muted">(Không bắt buộc)</span></label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-ra-thumb')">
                                        <div class="image-uploads mt-2">
                                            <i class="ti ti-photo-plus text-primary" style="font-size: 40px;"></i>
                                            <h5 class="mt-2 mb-0 fw-semibold">Kéo thả hoặc click để tải ảnh lên</h5>
                                            <p class="text-muted small">Hỗ trợ JPG, PNG, GIF, WEBP</p>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-center">
                                        <img id="preview-ra-thumb" src="" alt="Thumbnail Preview" style="max-height: 80px; display: none; object-fit: contain; margin: 0 auto; border-radius: 4px;">
                                    </div>
                                    @error('thumbnail')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú công khai (Ai cũng có thể thấy)</label>
                                    <textarea name="note" rows="4" class="form-control @error('note') is-invalid @enderror" placeholder="Ghi chú hiển thị ở ngoài cho khách xem">{{ old('note') }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú ẩn (Chỉ người mua thấy)</label>
                                    <textarea name="note_buyer" rows="4" class="form-control @error('note_buyer') is-invalid @enderror" placeholder="Ghi chú chỉ hiện trong lịch sử sau khi khách đã mua">{{ old('note_buyer') }}</textarea>
                                    @error('note_buyer')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-primary me-2">Tạo tài khoản</button>
                                <a href="{{ route('admin.random-accounts.index') }}" class="btn btn-secondary">Hủy</a>
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
    function readTxtFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var content = e.target.result;
                var textarea = document.getElementById('accountsTextarea');
                if (textarea.value.trim() !== '') {
                    textarea.value += '\n' + content;
                } else {
                    textarea.value = content;
                }
                // Clear input so same file can be uploaded again
                input.value = '';
            };
            reader.readAsText(input.files[0]);
        }
    }
</script>
@endpush
