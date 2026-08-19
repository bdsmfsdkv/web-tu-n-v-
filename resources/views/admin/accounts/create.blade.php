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
                <h2 class="mb-0">Thêm tài khoản game mới</h2>
                <p class="text-muted">Nhập thông tin tài khoản game</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.accounts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Danh mục game <span class="text-danger">*</span></label>
                                    <select name="game_category_id"
                                        class="form-select @error('game_category_id') is-invalid @enderror">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('game_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
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
                                    <input type="text" name="account_name" value="{{ old('account_name') }}"
                                        class="form-control @error('account_name') is-invalid @enderror" placeholder="Nhập tên đăng nhập">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="text" name="password" value="{{ old('password') }}"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giá tiền <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price') ?? 0 }}"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="VD: 50000">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Còn
                                            hàng</option>
                                        <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Đã bán
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr class="my-4">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h6 class="mb-1 fw-bold">Thuộc tính đa dạng (Liên Quân, FF, Valorant...)</h6>
                                            <p class="text-muted mb-0 small">Thêm các thuộc tính như Rank, Tướng, Trang phục,...</p>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-attribute">
                                            <i class="ti ti-plus me-1"></i> Thêm thuộc tính
                                        </button>
                                    </div>
                                    <div id="dynamic-attributes" class="bg-light p-3 rounded border">
                                        <!-- Javascript sẽ render vào đây -->
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
                                        <input type="file" name="thumb" class="form-control @error('thumb') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                        <div class="image-uploads mt-2">
                                            <i class="ti ti-photo-plus text-primary" style="font-size: 40px;"></i>
                                            <h5 class="mt-2 mb-0 fw-semibold">Kéo thả hoặc click để tải ảnh lên</h5>
                                            <p class="text-muted small">Hỗ trợ JPG, PNG, GIF</p>
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
                                        <input type="file" name="images[]" multiple class="form-control @error('images') is-invalid @enderror" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                        <div class="image-uploads mt-2">
                                            <i class="ti ti-photos text-success" style="font-size: 40px;"></i>
                                            <h5 class="mt-2 mb-0 fw-semibold text-success">Kéo thả hoặc click để tải lên nhiều ảnh</h5>
                                            <p class="text-muted small">Hỗ trợ tải lên nhiều file cùng lúc</p>
                                        </div>
                                    </div>
                                    @error('images')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú (Tùy chọn)</label>
                                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="4" placeholder="Ghi chú chi tiết về tài khoản này...">{{ old('note') }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-primary me-2">Thêm mới</button>
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
$(document).ready(function() {
    let attrIndex = 0;
    $('#add-attribute').click(function() {
        $('#dynamic-attributes').append(`
            <div class="row align-items-center mb-2 attribute-row">
                <div class="col-5">
                    <input type="text" name="details[${attrIndex}][key]" class="form-control" placeholder="Tên thuộc tính (VD: Rank)" required>
                </div>
                <div class="col-5">
                    <input type="text" name="details[${attrIndex}][value]" class="form-control" placeholder="Giá trị (VD: Kim Cương)" required>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger btn-sm remove-attribute">Xóa</button>
                </div>
            </div>
        `);
        attrIndex++;
    });

    $(document).on('click', '.remove-attribute', function() {
        $(this).closest('.attribute-row').remove();
    });
});
</script>
@endpush
