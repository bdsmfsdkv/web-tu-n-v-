@extends('layouts.admin.app')
@section('title', $title)

@section('content')
    <div>
        <div>
            <div class="page-header d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-3">
                <div class="page-header-title">
                    <h2 class="mb-0">Thêm tài khoản ngân hàng</h2>
                    <p class="text-muted mb-0">Tạo tài khoản ngân hàng mới</p>
                </div>
                <div class="page-btn flex-shrink-0">
                    <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-outline-secondary w-100 w-sm-auto">
                        <i class="ti ti-arrow-left me-1"></i> Danh sách tài khoản
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                    <strong>Hỗ trợ API tự động qua Spay5s.com hoặc SePay.vn.</strong>
                    <br>- <strong>SPAY5S:</strong> Lấy Token tại <a href="https://spay5s.com/" target="_blank" class="a_link">spay5s.com</a> (Hỗ trợ Vietcombank, Vietinbank, MBBank, ACB, OCB).
                    <br>- <strong>SePay:</strong> Lấy Token tại <a href="https://my.sepay.vn/" target="_blank" class="a_link">my.sepay.vn</a>. Có thể nhập token riêng tại đây hoặc dùng Token chung đã cài trong Cài đặt thanh toán.
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
                            <!-- KHỐI CẤU HÌNH NGUỒN GIAO DỊCH & SEPAY -->
                            <div class="col-lg-12">
                                <div class="card border border-dashed shadow-sm mb-3">
                                    <div class="card-header border-bottom bg-transparent py-2">
                                        <h6 class="card-title mb-0 border-start border-primary border-3 ps-2">
                                            <i class="ti ti-plug me-1"></i> Cấu hình kết nối API Giao dịch tự động
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-12 mb-3">
                                                <label class="form-label fw-bold">Nguồn giao dịch (Provider) <span class="text-danger">*</span></label>
                                                <select name="provider" id="provider_select" class="form-select @error('provider') is-invalid @enderror">
                                                    <option value="sepay" {{ old('provider', 'sepay') == 'sepay' ? 'selected' : '' }}>SePay API v2</option>
                                                    <option value="spay5s" {{ old('provider', 'sepay') == 'spay5s' ? 'selected' : '' }}>SPAY5S</option>
                                                </select>
                                                @error('provider')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Chọn SePay để đồng bộ giao dịch ngân hàng qua SePay API v2.</small>
                                            </div>

                                            <div class="col-lg-6 col-12 mb-3" id="env_field_wrapper">
                                                <label class="form-label fw-bold">Môi trường SePay</label>
                                                <select name="sepay_env" id="sepay_env_select" class="form-select @error('sepay_env') is-invalid @enderror">
                                                    <option value="production" {{ old('sepay_env', config_get('sepay_env', config('sepay.env', 'production'))) === 'production' ? 'selected' : '' }}>Production (Thực tế - userapi.sepay.vn)</option>
                                                    <option value="sandbox" {{ old('sepay_env', config_get('sepay_env', config('sepay.env', 'production'))) === 'sandbox' ? 'selected' : '' }}>Sandbox (Thử nghiệm - userapi-sandbox.sepay.vn)</option>
                                                </select>
                                                @error('sepay_env')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Chọn môi trường tương ứng với token của tài khoản này.</small>
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label fw-bold" id="token_label">
                                                    SePay API Token / Access Token
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('access_token') is-invalid @enderror"
                                                        id="access_token_input"
                                                        name="access_token"
                                                        placeholder="Nhập API Token / Access Token từ my.sepay.vn"
                                                        value="{{ old('access_token') }}"
                                                        autocomplete="new-password">
                                                    <button class="btn btn-outline-secondary" type="button" id="toggle_token_btn" title="Ẩn/Hiện token">
                                                        <i class="ti ti-eye" id="toggle_token_icon"></i>
                                                    </button>
                                                </div>
                                                @error('access_token')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted" id="token_help_text">
                                                    API Access Token cấp cho tài khoản này trên <a href="https://my.sepay.vn" target="_blank" class="text-primary fw-semibold">my.sepay.vn</a>.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            function updateProviderUI() {
                const provider = $('#provider_select').val();
                if (provider === 'sepay') {
                    $('#token_label').text('SePay API Token / Access Token');
                    $('#access_token_input').attr('placeholder', 'Nhập API Token / Access Token từ my.sepay.vn');
                    $('#token_help_text').html('API Access Token cấp cho tài khoản này trên <a href="https://my.sepay.vn" target="_blank" class="text-primary fw-semibold">my.sepay.vn</a>.');
                    $('#env_field_wrapper').show();
                } else {
                    $('#token_label').text('SPAY5S API Token');
                    $('#access_token_input').attr('placeholder', 'Nhập API Token từ spay5s.com');
                    $('#token_help_text').html('API Token cấp từ dịch vụ <a href="https://spay5s.com" target="_blank" class="text-primary fw-semibold">spay5s.com</a>.');
                    $('#env_field_wrapper').hide();
                }
            }

            $('#provider_select').on('change', updateProviderUI);
            updateProviderUI();

            $('#toggle_token_btn').on('click', function() {
                const input = $('#access_token_input');
                const icon = $('#toggle_token_icon');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('ti-eye').addClass('ti-eye-off');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('ti-eye-off').addClass('ti-eye-off');
                }
            });
        });
    </script>
@endpush
