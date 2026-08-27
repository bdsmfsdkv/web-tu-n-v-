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
                                        <option value="gachthefast.com"
                                            {{ $configs['partner_website_card'] === 'gachthefast.com' ? 'selected' : '' }}>
                                            GACHTHEFAST.COM</option>
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

                        <!-- CÀI ĐẶT SEPAY WEBHOOK & HỆ THỐNG -->
                        <div class="card border border-light-subtle shadow-sm mb-4">
                            <div class="card-header bg-light-subtle d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                                <h5 class="card-title mb-0">
                                    <i class="ti ti-building-bank text-primary me-2"></i>Cài đặt SePay Webhook & Môi trường chung
                                </h5>
                                <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-sm btn-outline-primary align-self-start align-self-sm-auto">
                                    <i class="ti ti-settings me-1"></i> Quản lý tài khoản ngân hàng & Token
                                </a>
                            </div>
                            <div class="card-body pb-0 payment-method-container" data-checkbox="sepay_enabled" data-container="sepay-container">
                                <div class="alert alert-info">
                                    <i class="ti ti-info-circle me-1"></i> <strong>Lưu ý:</strong> Cấu hình Token API và Nguồn giao dịch của từng ngân hàng đã được quản lý trực tiếp trong trang <a href="{{ route('admin.bank-accounts.index') }}" class="fw-bold text-decoration-underline">Chỉnh sửa tài khoản ngân hàng</a>.
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-4 pb-2 border-bottom">
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" id="sepay_enabled" name="sepay_enabled" value="1" {{ old('sepay_enabled', $configs['sepay_enabled']) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="sepay_enabled">Kích hoạt tích hợp SePay (Webhook & Cron)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row sepay-container">
                                    <div class="col-lg-8 col-sm-8 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">SePay Webhook API Key / Token xác thực <span class="text-danger">*</span></label>
                                            <input type="password" name="sepay_token"
                                                value="{{ old('sepay_token', $configs['sepay_token']) }}"
                                                class="form-control @error('sepay_token') is-invalid @enderror"
                                                placeholder="Nhập API Key để xác thực Webhook POST /api/webhook/sepay"
                                                autocomplete="new-password">
                                            @error('sepay_token')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Dùng để xác thực an toàn khi SePay bắn Webhook về URL <code>/api/webhook/sepay</code> (Header <code>Authorization: Apikey &lt;TOKEN&gt;</code>).</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Môi trường SePay</label>
                                            <select name="sepay_env" class="form-select @error('sepay_env') is-invalid @enderror">
                                                <option value="production" {{ old('sepay_env', $configs['sepay_env']) === 'production' ? 'selected' : '' }}>Production (Thực tế)</option>
                                                <option value="sandbox" {{ old('sepay_env', $configs['sepay_env']) === 'sandbox' ? 'selected' : '' }}>Sandbox (Thử nghiệm)</option>
                                            </select>
                                            @error('sepay_env')
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