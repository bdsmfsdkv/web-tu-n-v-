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
                <h2 class="mb-0">Cài đặt thanh toán</h2>
                <p class="text-muted">Cấu hình các phương thức thanh toán</p>
            </div>
        </div>
    </div>
</div>
            </div>
            <!-- Notication -->
            <div class="card-body">
                <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                    <strong>Chúng tôi hiện đang hỗ trợ 3 đối tác thanh toán:</strong>
                    <a href="https://thesieure.com" target="_blank">THESIEURE.COM</a>,
                    <a href="https://doithe1s.vn" target="_blank">DOITHE1S.VN</a>,
                    <a href="https://cardvip.vn" target="_blank">CARDVIP.VN</a>.
                    Nếu bạn có nhu cầu chọn đối tác khác, xin vui lòng liên hệ với chúng tôi (phí dịch vụ là
                    100K).
                    <br>
                    Địa chỉ nhận Callback theo phương thức GET hoặc POST đều được:
                    <b><strong>{{ url(route('callback.card', [], '')) }}</strong></b>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    <form action="{{ route('admin.settings.payment.update') }}" method="POST">
                        @csrf

                        <!-- CÀI ĐẶT THẺ CÀO -->
                        <div class="card border border-light-subtle shadow-sm mb-4">
                            <div class="card-header bg-light-subtle">
                                <h5 class="card-title mb-0">
                                    <i class="ti ti-credit-card text-primary me-2"></i>Cài đặt nạp thẻ <span class="text-muted fw-normal fs-6">(Thanh toán qua thẻ cào)</span>
                                </h5>
                            </div>
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-4 pb-2 border-bottom">
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" id="card_active" name="card_active" value="1" {{ old('card_active', $configs['card_active']) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="card_active">Kích hoạt phương thức thanh toán thẻ cào</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <div class="row">

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Website đối tác <span class="text-danger">*</span></label>
                                    <select name="partner_website_card"
                                        class="form-select @error('partner_website_card') is-invalid @enderror">
                                        <option value="">Chọn đối tác</option>
                                        <option value="thesieure.com"
                                            {{ $configs['partner_website_card'] === 'thesieure.com' ? 'selected' : '' }}>
                                            THESIEURE.COM</option>
                                        <option value="cardvip.vn"
                                            {{ $configs['partner_website_card'] === 'cardvip.vn' ? 'selected' : '' }}>
                                            CARDVIP.VN</option>
                                        <option value="doithe1s.vn"
                                            {{ $configs['partner_website_card'] === 'doithe1s.vn' ? 'selected' : '' }}>
                                            DOITHE1S.VN</option>
                                    </select>
                                    @error('partner_website_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Chiết khấu nạp thẻ <span class="text-danger">*</span></label>
                                    <input type="text" name="discount_percent_card"
                                        value="{{ old('discount_percent_card', $configs['discount_percent_card']) }}"
                                        class="form-control @error('discount_percent_card') is-invalid @enderror"
                                        placeholder="Nhập chiết khấu nạp thẻ">
                                    @error('discount_percent_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Partner ID <span class="text-danger">*</span></label>
                                    <input type="text" name="partner_id_card"
                                        value="{{ old('partner_id_card', $configs['partner_id_card']) }}"
                                        class="form-control @error('partner_id_card') is-invalid @enderror"
                                        placeholder="Nhập Partner ID">
                                    @error('partner_id_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Partner Key <span class="text-danger">*</span></label>
                                    <input type="text" name="partner_key_card"
                                        value="{{ old('partner_key_card', $configs['partner_key_card']) }}"
                                        class="form-control @error('partner_key_card') is-invalid @enderror"
                                        placeholder="Nhập Partner Key">
                                    @error('partner_key_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        </div> <!-- end card-body -->
                        </div> <!-- end card -->

                        <!-- CÀI ĐẶT USDT -->
                        <div class="card border border-light-subtle shadow-sm mb-4">
                            <div class="card-header bg-light-subtle">
                                <h5 class="card-title mb-0">
                                    <i class="fa-brands fa-usps text-success me-2"></i>Cài đặt nạp USDT <span class="text-muted fw-normal fs-6">(Tự động qua Spay5s)</span>
                                </h5>
                            </div>
                            <div class="card-body pb-0 payment-method-container" data-checkbox="usdt_active" data-container="usdt-container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-4 pb-2 border-bottom">
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" id="usdt_active" name="usdt_active" value="1" {{ old('usdt_active', $configs['usdt_active']) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="usdt_active">Kích hoạt phương thức nạp USDT</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row usdt-container">
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">API Token (Spay5s) <span class="text-danger">*</span></label>
                                            <input type="text" name="spay5s_token"
                                                value="{{ old('spay5s_token', $configs['spay5s_token']) }}"
                                                class="form-control @error('spay5s_token') is-invalid @enderror"
                                                placeholder="Ví dụ: 39D6670A-1B9A...">
                                            @error('spay5s_token')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Token lấy từ https://api.spay5s.com</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Tỷ giá quy đổi (1 USDT = ? VND) <span class="text-danger">*</span></label>
                                            <input type="number" name="usdt_rate"
                                                value="{{ old('usdt_rate', $configs['usdt_rate']) }}"
                                                class="form-control @error('usdt_rate') is-invalid @enderror"
                                                placeholder="Ví dụ: 25000">
                                            @error('usdt_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Địa chỉ ví USDT (TRC20/BEP20) <span class="text-danger">*</span></label>
                                            <input type="text" name="usdt_wallet_address"
                                                value="{{ old('usdt_wallet_address', $configs['usdt_wallet_address']) }}"
                                                class="form-control @error('usdt_wallet_address') is-invalid @enderror"
                                                placeholder="Nhập địa chỉ ví của bạn để nhận tiền...">
                                            @error('usdt_wallet_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card-body -->
                        </div> <!-- end card -->

                        <div class="row mt-4">
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
    <script>
        $(document).ready(function() {
            // Toggle input fields based on payment method status
            function toggleInputFields(checkboxId, containerClass) {
                const isChecked = $('#' + checkboxId).is(':checked');
                $('.' + containerClass + ' input, .' + containerClass + ' select').prop('disabled', !isChecked);
            }

            // Initial state and event handlers
            $('.payment-method-container').each(function() {
                const checkboxId = $(this).data('checkbox');
                const containerClass = $(this).data('container');
                toggleInputFields(checkboxId, containerClass);

                $('#' + checkboxId).on('change', function() {
                    toggleInputFields(checkboxId, containerClass);
                });
            });
        });
    </script>
@endpush
