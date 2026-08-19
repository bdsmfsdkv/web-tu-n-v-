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
                <h2 class="mb-0">Thêm tài khoản ngân hàng</h2>
                <p class="text-muted">Tạo tài khoản ngân hàng mới</p>
            </div>
        </div>
    </div>
</div>
            </div>
            <div class="card-body">
                <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                    <strong>Hệ thống hiện tại đang sử dụng API qua Spay5s.com.</strong>
                    <br>Vui lòng đăng ký tài khoản tại <a href="https://spay5s.com/" target="_blank" class="a_link">spay5s.com</a> để lấy Token tích hợp nạp tiền tự động cho các ngân hàng: Vietcombank, Vietinbank, MBBank, ACB, OCB.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.bank-accounts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tên ngân hàng <span class="text-danger">*</span></label>
                                    <select name="bank_name" class="form-control @error('bank_name') is-invalid @enderror">
                                        <option value="">-- Chọn ngân hàng --</option>
                                        <option value="Vietcombank"
                                            {{ old('bank_name') == 'Vietcombank' ? 'selected' : '' }}>Vietcombank</option>
                                        <option value="VietinBank" {{ old('bank_name') == 'VietinBank' ? 'selected' : '' }}>
                                            VietinBank</option>
                                        <option value="BIDV" {{ old('bank_name') == 'BIDV' ? 'selected' : '' }}>BIDV
                                        </option>
                                        <option value="Techcombank"
                                            {{ old('bank_name') == 'Techcombank' ? 'selected' : '' }}>Techcombank</option>
                                        <option value="Sacombank" {{ old('bank_name') == 'Sacombank' ? 'selected' : '' }}>
                                            Sacombank</option>
                                        <option value="MBBank" {{ old('bank_name') == 'MBBank' ? 'selected' : '' }}>MBBank
                                        </option>
                                        <option value="ACB" {{ old('bank_name') == 'ACB' ? 'selected' : '' }}>ACB
                                        </option>
                                        <option value="VPBank" {{ old('bank_name') == 'VPBank' ? 'selected' : '' }}>VPBank
                                        </option>
                                        <option value="Agribank" {{ old('bank_name') == 'Agribank' ? 'selected' : '' }}>
                                            Agribank</option>
                                        <option value="TPBank" {{ old('bank_name') == 'TPBank' ? 'selected' : '' }}>TPBank
                                        </option>
                                        <option value="HDBank" {{ old('bank_name') == 'HDBank' ? 'selected' : '' }}>HDBank
                                        </option>
                                        <option value="VIB" {{ old('bank_name') == 'VIB' ? 'selected' : '' }}>VIB
                                        </option>
                                        <option value="MSB" {{ old('bank_name') == 'MSB' ? 'selected' : '' }}>MSB
                                        </option>
                                        <option value="OCB" {{ old('bank_name') == 'OCB' ? 'selected' : '' }}>OCB
                                        </option>
                                        <option value="Eximbank" {{ old('bank_name') == 'Eximbank' ? 'selected' : '' }}>
                                            Eximbank</option>
                                        <option value="SHB" {{ old('bank_name') == 'SHB' ? 'selected' : '' }}>SHB
                                        </option>
                                        <option value="SeABank" {{ old('bank_name') == 'SeABank' ? 'selected' : '' }}>
                                            SeABank</option>
                                        <option value="NamABank" {{ old('bank_name') == 'NamABank' ? 'selected' : '' }}>
                                            NamABank</option>
                                        <option value="KienLongBank"
                                            {{ old('bank_name') == 'KienLongBank' ? 'selected' : '' }}>KienLongBank
                                        </option>
                                        <option value="PGBank" {{ old('bank_name') == 'PGBank' ? 'selected' : '' }}>PGBank
                                        </option>
                                        <option value="ABBank" {{ old('bank_name') == 'ABBank' ? 'selected' : '' }}>ABBank
                                        </option>
                                        <option value="LPBank" {{ old('bank_name') == 'LPBank' ? 'selected' : '' }}>LPBank
                                        </option>
                                        <option value="VietABank" {{ old('bank_name') == 'VietABank' ? 'selected' : '' }}>
                                            VietABank</option>
                                        <option value="VIETBANK" {{ old('bank_name') == 'VIETBANK' ? 'selected' : '' }}>
                                            VIETBANK</option>
                                        <option value="BACABANK" {{ old('bank_name') == 'BACABANK' ? 'selected' : '' }}>
                                            BACABANK</option>
                                        <option value="BVBank" {{ old('bank_name') == 'BVBank' ? 'selected' : '' }}>BVBank
                                        </option>
                                        <option value="NHQUOCDAN" {{ old('bank_name') == 'NHQUOCDAN' ? 'selected' : '' }}>
                                            Ngân hàng Quốc Dân</option>
                                        <option value="PBVN" {{ old('bank_name') == 'PBVN' ? 'selected' : '' }}>Public
                                            Bank Vietnam</option>
                                        <option value="ShinhanBank"
                                            {{ old('bank_name') == 'ShinhanBank' ? 'selected' : '' }}>Shinhan Bank</option>
                                        <option value="WOORIVN" {{ old('bank_name') == 'WOORIVN' ? 'selected' : '' }}>Woori
                                            Bank Vietnam</option>
                                    </select>

                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Số tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_number" value="{{ old('account_number') }}"
                                        class="form-control @error('account_number') is-invalid @enderror"
                                        placeholder="Nhập số tài khoản">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tên tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_name" value="{{ old('account_name') }}"
                                        class="form-control @error('account_name') is-invalid @enderror"
                                        placeholder="Nhập tên tài khoản">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Chi nhánh</label>
                                    <input type="text" name="branch" value="{{ old('branch') }}"
                                        class="form-control" placeholder="Nhập chi nhánh ngân hàng">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Cú pháp nạp tiền <span class="text-danger">*</span></label>
                                    <input type="text" name="prefix" value="{{ old('prefix', 'naptien') }}"
                                        class="form-control @error('prefix') is-invalid @enderror"
                                        placeholder="Nhập cú pháp nạp tiền (ví dụ: naptien)">
                                    @error('prefix')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Cú pháp nạp tiền sẽ được dùng để tự động xác định
                                        người dùng trong nội dung chuyển khoản. Ví dụ: naptien123 với 123 là ID người
                                        dùng.</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú</label>
                                    <textarea class="form-control" name="note" placeholder="Nhập ghi chú (nếu có)">{{ old('note') }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Access Token (từ <a
                                            href="https://spay5s.com/" target="_blank">spay5s.com</a>)</label>
                                    <input type="text" class="form-control @error('access_token') is-invalid @enderror"
                                        name="access_token" placeholder="Nhập Access Token từ SePay.vn"
                                        value="{{ old('access_token') }}">
                                    @error('access_token')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Token này được cung cấp bởi spay5s.com để kết nối API tự động cộng tiền.</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện (Logo hoặc QR Code)</label>
                                    <div class="image-upload">
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                        <div class="image-uploads mt-2">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img">
                                            <h4>Kéo thả hoặc click để tải ảnh lên</h4>
                                        </div>
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                            checked>
                                        <label class="form-check-label" for="is_active">Kích hoạt tài khoản</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="auto_confirm"
                                            id="auto_confirm" checked>
                                        <label class="form-check-label" for="auto_confirm">Tự động xác nhận và cộng
                                            tiền</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Tạo tài khoản</button>
                                <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
