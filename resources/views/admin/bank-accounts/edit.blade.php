@extends('layouts.admin.app')
@section('title', $title)

@push('css')
<style>
    .sepay-card {
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.08);
        box-shadow: 0 4px 18px rgba(0,0,0,0.04);
        margin-bottom: 24px;
        background: #fff;
    }
    [data-pc-theme="dark"] .sepay-card {
        background: #1a2234;
        border-color: rgba(255,255,255,0.08);
        color: #e2e8f0;
    }
    .sepay-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    [data-pc-theme="dark"] .sepay-card-header {
        border-color: rgba(255,255,255,0.08);
        background: rgba(255,255,255,0.02) !important;
    }
    [data-pc-theme="dark"] .bg-light-subtle {
        background: rgba(255, 255, 255, 0.04) !important;
    }
    [data-pc-theme="dark"] .bg-light {
        background: rgba(255, 255, 255, 0.06) !important;
        color: #e2e8f0 !important;
    }
    [data-pc-theme="dark"] .text-muted {
        color: #94a3b8 !important;
    }
    [data-pc-theme="dark"] .table {
        color: #e2e8f0;
    }
    [data-pc-theme="dark"] .table > :not(caption) > * > * {
        background-color: transparent;
        color: inherit;
    }
    [data-pc-theme="dark"] .table-bordered,
    [data-pc-theme="dark"] .table-bordered th,
    [data-pc-theme="dark"] .table-bordered td {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    [data-pc-theme="dark"] .input-group-text.bg-light {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    [data-pc-theme="dark"] .webhook-details-box {
        color: #e2e8f0 !important;
    }
    [data-pc-theme="dark"] .webhook-details-box strong {
        color: #f8fafc !important;
    }
    [data-pc-theme="dark"] .webhook-val {
        color: #cbd5e1 !important;
    }
    [data-pc-theme="dark"] .bg-success-subtle {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border-color: rgba(16, 185, 129, 0.3) !important;
        color: #e2e8f0 !important;
    }
    [data-pc-theme="dark"] .badge.bg-light {
        background: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #334155 !important;
    }
    .wizard-step {
        display: flex;
        margin-bottom: 20px;
        position: relative;
    }
    .wizard-step:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 20px;
        top: 44px;
        bottom: -15px;
        width: 2px;
        background: #e2e8f0;
        z-index: 1;
    }
    [data-pc-theme="dark"] .wizard-step:not(:last-child)::after {
        background: #334155;
    }
    .wizard-step-number {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 50%;
        background: #3b82f6;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        margin-right: 16px;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(59,130,246,0.3);
    }
    .wizard-step-content {
        flex: 1;
        background: #f8fafc;
        border-radius: 10px;
        padding: 16px 18px;
        border: 1px solid #e2e8f0;
    }
    [data-pc-theme="dark"] .wizard-step-content {
        background: #0f172a;
        border-color: #1e293b;
    }
    .code-box {
        background: #0f172a;
        color: #38bdf8;
        padding: 10px 14px;
        border-radius: 8px;
        font-family: monospace;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 6px;
        margin-bottom: 6px;
        word-break: break-all;
    }
    .status-badge-lg {
        font-size: 18px;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .status-badge-success {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid #10b981;
    }
    .status-badge-warning {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid #f59e0b;
    }
    .status-badge-danger {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 1px solid #ef4444;
    }
    .check-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 12px;
        border-radius: 6px;
        margin-bottom: 6px;
        background: #f8fafc;
    }
    [data-pc-theme="dark"] .check-item {
        background: #1e293b;
    }
    .check-icon {
        font-size: 16px;
        font-weight: 800;
        margin-top: 2px;
    }
    .check-icon-pass { color: #10b981; }
    .check-icon-fail { color: #ef4444; }
    .pulse-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        animation: pulseAnimation 1.5s infinite;
    }
    @keyframes pulseAnimation {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>
@endpush

@section('content')
<div>
    <!-- PAGE HEADER -->
    <div class="page-header">
        <div class="page-block mb-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h2 class="mb-0">Thiết lập & Kiểm tra SePay</h2>
                        <p class="text-muted mb-0">Quản lý kết nối tự động, tài khoản ngân hàng & kiểm tra Webhook an toàn</p>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Danh sách tài khoản
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

    @php
        $sepayTokenConfigured = !empty(config_get('sepay_token', config('sepay.token', ''))) || !empty($bankAccount->access_token);
        $hasWebhookReceived = $recentWebhookLogs->isNotEmpty();
        $isFullyConfigured = $sepayTokenConfigured && !empty($bankAccount->account_number) && $bankAccount->is_active;
    @endphp

    <!-- 2. CARD TRẠNG THÁI -->
    <div class="card sepay-card border-0">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <div class="d-flex align-items-center gap-3">
                        @if ($isFullyConfigured && $hasWebhookReceived)
                            <div class="status-badge-lg status-badge-success">
                                <span class="pulse-dot bg-success"></span>
                                🟢 SEPAY ĐÃ KẾT NỐI
                            </div>
                        @elseif ($isFullyConfigured)
                            <div class="status-badge-lg status-badge-warning">
                                🟡 ĐÃ CẤU HÌNH — CHƯA NHẬN WEBHOOK
                            </div>
                        @else
                            <div class="status-badge-lg status-badge-danger">
                                🔴 SEPAY CHƯA CẤU HÌNH ĐÚNG
                            </div>
                        @endif
                    </div>
                    <p class="text-muted mt-2 mb-0 small">
                        Hệ thống tự động xác minh trạng thái kết nối giữa Website và Cổng nạp SePay.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light-subtle">
                                <span class="text-muted small d-block">Token Xác Thực:</span>
                                <strong>
                                    @if ($sepayTokenConfigured)
                                        <span class="text-success"><i class="ti ti-check"></i> Đã cấu hình (Mã hóa)</span>
                                    @else
                                        <span class="text-danger"><i class="ti ti-x"></i> Chưa cấu hình</span>
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light-subtle">
                                <span class="text-muted small d-block">Trạng thái Webhook:</span>
                                <strong>
                                    @if ($hasWebhookReceived)
                                        <span class="text-success"><i class="ti ti-circle-check"></i> Đang hoạt động</span>
                                    @else
                                        <span class="text-warning"><i class="ti ti-clock"></i> Chưa nhận</span>
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light-subtle">
                                <span class="text-muted small d-block">Webhook gần nhất:</span>
                                <strong>{{ $latestWebhook ? $latestWebhook->created_at->format('H:i d/m/Y') : 'Chưa có' }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light-subtle">
                                <span class="text-muted small d-block">Giao dịch nạp gần nhất:</span>
                                <strong>{{ $latestDeposit ? number_format($latestDeposit->amount) . ' đ (' . ($latestDeposit->user->username ?? '#' . $latestDeposit->user_id) . ')' : 'Chưa có' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($latestDeposit)
            <hr class="my-3 opacity-25">
            <div class="row text-muted small g-2">
                <div class="col-md-3"><strong>RefCode:</strong> <code>{{ $latestDeposit->transaction_id }}</code></div>
                <div class="col-md-3"><strong>Số tiền:</strong> <span class="text-success fw-bold">{{ number_format($latestDeposit->amount) }} đ</span></div>
                <div class="col-md-3"><strong>Người nạp:</strong> {{ $latestDeposit->user->username ?? '#' . $latestDeposit->user_id }}</div>
                <div class="col-md-3"><strong>Thời gian:</strong> {{ $latestDeposit->created_at->format('H:i:s d/m/Y') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="row">
        <!-- CỘT TRÁI: FORM CHỈNH SỬA & WIZARD HƯỚNG DẪN -->
        <div class="col-xl-7 col-lg-12">
            <!-- 1. FORM CHỈNH SỬA TÀI KHOẢN NGÂN HÀNG -->
            <div class="card sepay-card">
                <div class="sepay-card-header">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="ti ti-building-bank text-primary me-2"></i> Thông tin tài khoản ngân hàng
                    </h5>
                    <span class="badge {{ $bankAccount->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $bankAccount->is_active ? 'Đang hoạt động' : 'Tạm dừng' }}
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bank-accounts.update', $bankAccount->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label fw-semibold">Tên ngân hàng <span class="text-danger">*</span></label>
                                <select name="bank_name" class="form-select @error('bank_name') is-invalid @enderror">
                                    <option value="MBBank" {{ old('bank_name', $bankAccount->bank_name) == 'MBBank' ? 'selected' : '' }}>MBBank (Khuyên dùng)</option>
                                    <option value="Vietcombank" {{ old('bank_name', $bankAccount->bank_name) == 'Vietcombank' ? 'selected' : '' }}>Vietcombank</option>
                                    <option value="VietinBank" {{ old('bank_name', $bankAccount->bank_name) == 'VietinBank' ? 'selected' : '' }}>VietinBank</option>
                                    <option value="Techcombank" {{ old('bank_name', $bankAccount->bank_name) == 'Techcombank' ? 'selected' : '' }}>Techcombank</option>
                                    <option value="ACB" {{ old('bank_name', $bankAccount->bank_name) == 'ACB' ? 'selected' : '' }}>ACB</option>
                                    <option value="VPBank" {{ old('bank_name', $bankAccount->bank_name) == 'VPBank' ? 'selected' : '' }}>VPBank</option>
                                    <option value="TPBank" {{ old('bank_name', $bankAccount->bank_name) == 'TPBank' ? 'selected' : '' }}>TPBank</option>
                                    <option value="BIDV" {{ old('bank_name', $bankAccount->bank_name) == 'BIDV' ? 'selected' : '' }}>BIDV</option>
                                    <option value="Sacombank" {{ old('bank_name', $bankAccount->bank_name) == 'Sacombank' ? 'selected' : '' }}>Sacombank</option>
                                    <option value="Agribank" {{ old('bank_name', $bankAccount->bank_name) == 'Agribank' ? 'selected' : '' }}>Agribank</option>
                                    <option value="VIB" {{ old('bank_name', $bankAccount->bank_name) == 'VIB' ? 'selected' : '' }}>VIB</option>
                                    <option value="MSB" {{ old('bank_name', $bankAccount->bank_name) == 'MSB' ? 'selected' : '' }}>MSB</option>
                                    <option value="OCB" {{ old('bank_name', $bankAccount->bank_name) == 'OCB' ? 'selected' : '' }}>OCB</option>
                                    <option value="KienLongBank" {{ old('bank_name', $bankAccount->bank_name) == 'KienLongBank' ? 'selected' : '' }}>KienLongBank</option>
                                </select>
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label fw-semibold">Số tài khoản <span class="text-danger">*</span></label>
                                <input type="text" name="account_number"
                                    value="{{ old('account_number', $bankAccount->account_number) }}"
                                    class="form-control @error('account_number') is-invalid @enderror"
                                    placeholder="Nhập số tài khoản MBBank hoặc ngân hàng khác">
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label fw-semibold">Chi nhánh ngân hàng</label>
                                <input type="text" name="branch" value="{{ old('branch', $bankAccount->branch) }}"
                                    class="form-control" placeholder="Hội sở / Chi nhánh">
                            </div>

                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label fw-semibold">Cú pháp nạp tiền <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="prefix" value="{{ old('prefix', $bankAccount->prefix ?: 'naptien') }}"
                                        class="form-control @error('prefix') is-invalid @enderror"
                                        placeholder="naptien">
                                    <span class="input-group-text bg-light">&lt;ID&gt;</span>
                                </div>
                                @error('prefix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Ví dụ User ID = 1 thì nội dung chuyển khoản là <code>{{ old('prefix', $bankAccount->prefix ?: 'naptien') }}1</code></small>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="p-3 border rounded bg-light-subtle">
                                    <div class="row">
                                        <div class="col-md-6 mb-2 mb-md-0">
                                            <label class="form-label fw-bold">Nguồn API (Provider)</label>
                                            <select name="provider" class="form-select @error('provider') is-invalid @enderror">
                                                <option value="sepay" {{ old('provider', $bankAccount->providerName()) == 'sepay' ? 'selected' : '' }}>SePay API v2 / Webhook (Khuyên dùng)</option>
                                                <option value="spay5s" {{ old('provider', $bankAccount->providerName()) == 'spay5s' ? 'selected' : '' }}>SPAY5S</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">SePay Access Token riêng</label>
                                            <input type="password" name="access_token"
                                                class="form-control @error('access_token') is-invalid @enderror"
                                                value="{{ old('access_token', $bankAccount->access_token) }}"
                                                placeholder="Để trống nếu dùng Token chung">
                                            <small class="text-muted">Không bắt buộc nếu đã cài Token tại Cài đặt thanh toán.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Ghi chú</label>
                                <textarea class="form-control" name="note" rows="2" placeholder="Ghi chú nội bộ cho tài khoản">{{ old('note', $bankAccount->note) }}</textarea>
                            </div>

                            <div class="col-md-6 col-12 mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                        {{ old('is_active', $bankAccount->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="is_active">Kích hoạt tài khoản</label>
                                </div>
                            </div>

                            <div class="col-md-6 col-12 mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="auto_confirm" id="auto_confirm"
                                        {{ old('auto_confirm', $bankAccount->auto_confirm) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-success" for="auto_confirm">Tự động xác nhận & cộng tiền</label>
                                </div>
                            </div>

                            <div class="col-12 text-end pt-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ti ti-device-floppy me-1"></i> Lưu thông tin tài khoản
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 1. WIZARD "HƯỚNG DẪN SETUP SEPAY" -->
            <div class="card sepay-card">
                <div class="sepay-card-header bg-light-subtle">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="ti ti-help-hexagon text-warning me-2"></i> Wizard: Hướng dẫn Setup SePay từ đầu
                    </h5>
                    <span class="badge bg-primary">5 Bước Hoàn Chỉnh</span>
                </div>
                <div class="card-body p-4">
                    <!-- BƯỚC 1 -->
                    <div class="wizard-step">
                        <div class="wizard-step-number">1</div>
                        <div class="wizard-step-content">
                            <h6 class="fw-bold mb-1">Cấu hình tài khoản ngân hàng</h6>
                            <ul class="mb-2 ps-3 small text-muted">
                                <li>Chọn ngân hàng <strong>MBBank</strong> (hoặc ngân hàng SePay hỗ trợ).</li>
                                <li>Nhập chính xác <strong>Số tài khoản</strong> đang liên kết trên SePay.</li>
                                <li>Cấu hình cú pháp nạp tiền: <code>naptien</code></li>
                                <li>Bật công tắc <strong>"Tự động xác nhận và cộng tiền"</strong>.</li>
                                <li>Kiểm tra tài khoản đang ở trạng thái <strong>Hoạt động</strong>.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- BƯỚC 2 -->
                    <div class="wizard-step">
                        <div class="wizard-step-number">2</div>
                        <div class="wizard-step-content">
                            <h6 class="fw-bold mb-1">Tạo SePay API Token</h6>
                            <p class="small text-muted mb-2">
                                Vào <strong>Admin → Cài đặt thanh toán</strong> → Tìm <strong>"Cài đặt SePay API"</strong> → Bật <strong>"Kích hoạt tích hợp SePay API v2"</strong> → Tạo một token/secret ngẫu nhiên mạnh và lưu lại.
                            </p>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="badge {{ $sepayTokenConfigured ? 'bg-success' : 'bg-danger' }}">
                                    {{ $sepayTokenConfigured ? '✓ Token đã được cấu hình' : '✗ Chưa cấu hình Token' }}
                                </span>
                                <a href="{{ route('admin.settings.payment') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-settings me-1"></i> [ Đã cấu hình Token ]
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- BƯỚC 3 -->
                    <div class="wizard-step">
                        <div class="wizard-step-number">3</div>
                        <div class="wizard-step-content">
                            <h6 class="fw-bold mb-1">Cấu hình môi trường Webhook URL</h6>
                            <div class="mb-2">
                                <span class="badge bg-secondary mb-1">LOCAL TEST (Ngrok)</span>
                                <div class="code-box">
                                    <span>https://&lt;NGROK-DOMAIN&gt;/api/webhook/sepay</span>
                                    <button class="btn btn-sm btn-dark p-0 px-2" onclick="navigator.clipboard.writeText('https://<NGROK-DOMAIN>/api/webhook/sepay')">Copy</button>
                                </div>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success mb-1">PRODUCTION (Domain thật)</span>
                                <div class="code-box">
                                    <span>{{ url('/api/webhook/sepay') }}</span>
                                    <button class="btn btn-sm btn-dark p-0 px-2" onclick="navigator.clipboard.writeText('{{ url('/api/webhook/sepay') }}')">Copy</button>
                                </div>
                            </div>
                            <small class="text-danger d-block">
                                * Lưu ý: Ngrok chỉ dùng để test localhost. Khi chạy production bắt buộc dùng domain thật và HTTPS.
                            </small>
                        </div>
                    </div>

                    <!-- BƯỚC 4 -->
                    <div class="wizard-step">
                        <div class="wizard-step-number">4</div>
                        <div class="wizard-step-content">
                            <h6 class="fw-bold mb-1">Cấu hình Webhook trên trang quản lý SePay</h6>
                            <p class="small text-muted mb-2">Truy cập <strong>my.sepay.vn</strong> → Webhooks → Thêm Webhook mới với thông số:</p>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered small mb-2">
                                    <tbody>
                                        <tr><th class="bg-light w-25">URL</th><td><code>{{ url('/api/webhook/sepay') }}</code></td></tr>
                                        <tr><th class="bg-light">Loại giao dịch</th><td><strong>Tiền vào (in)</strong></td></tr>
                                        <tr><th class="bg-light">Định dạng</th><td><strong>JSON</strong></td></tr>
                                        <tr><th class="bg-light">Xác thực</th><td><strong>API Key</strong></td></tr>
                                        <tr><th class="bg-light">Authorization</th><td><code>Apikey &lt;SEPAY_TOKEN&gt;</code></td></tr>
                                        <tr><th class="bg-light">Tùy chọn</th><td>Bật <em>"Dùng để xác thực thanh toán"</em></td></tr>
                                        <tr><th class="bg-light">Prefix</th><td><code>{{ $bankAccount->prefix ?: 'naptien' }}</code></td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">SePay phải gửi đúng API Key giống token mà website đang lưu trong hệ thống.</small>
                        </div>
                    </div>

                    <!-- BƯỚC 5 -->
                    <div class="wizard-step mb-0">
                        <div class="wizard-step-number">5</div>
                        <div class="wizard-step-content">
                            <h6 class="fw-bold mb-2">Kiểm tra kết quả cấu hình</h6>
                            <button type="button" class="btn btn-primary btn-sm mb-3" id="btn-check-config-wizard" onclick="runCheckConfig()">
                                <i class="ti ti-search me-1"></i> [ 🔍 Kiểm tra cấu hình ]
                            </button>

                            <div id="wizard-checklist-box" style="display:none;">
                                <div id="checklist-items"></div>
                                <div id="wizard-final-status" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: KHU VỰC TEST & MONITOR & SECURITY CHECKLIST -->
        <div class="col-xl-5 col-lg-12">
            <!-- 3. KHU VỰC TEST -->
            <div class="card sepay-card">
                <div class="sepay-card-header bg-light-subtle">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="ti ti-flask text-info me-2"></i> 🧪 Kiểm tra SePay
                    </h5>
                    <span class="badge bg-info">Test An Toàn</span>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Các công cụ kiểm tra bên dưới chạy độc lập, <strong>tuyệt đối KHÔNG cộng tiền</strong> và không tạo số dư ảo.
                    </p>

                    <div class="d-flex gap-2 mb-3">
                        <button type="button" class="btn btn-outline-primary w-50" id="btn-run-check" onclick="runCheckConfig()">
                            <i class="ti ti-checklist me-1"></i> Kiểm tra cấu hình
                        </button>
                        <button type="button" class="btn btn-outline-info w-50" id="btn-run-auth" onclick="runTestAuth()">
                            <i class="ti ti-shield-lock me-1"></i> Test Authorization
                        </button>
                    </div>

                    <!-- KẾT QUẢ TEST CONFIG -->
                    <div id="test-config-result" class="p-3 border rounded bg-light-subtle mb-3" style="display:none;">
                        <h6 class="fw-bold mb-2 small text-uppercase">Kết quả kiểm tra hệ thống:</h6>
                        <div id="test-config-details"></div>
                    </div>

                    <!-- KẾT QUẢ TEST AUTH -->
                    <div id="test-auth-result" class="p-3 border rounded bg-light-subtle mb-3" style="display:none;">
                        <h6 class="fw-bold mb-2 small text-uppercase">Kết quả xác thực Authorization Header:</h6>
                        <div id="test-auth-details"></div>
                    </div>

                    <!-- TEST GIAO DỊCH THỰC TẾ -->
                    <div class="p-3 border rounded bg-light-subtle mt-3">
                        <h6 class="fw-bold text-success mb-2">
                            <i class="ti ti-cash me-1"></i> 💰 Test giao dịch thực tế
                        </h6>
                        <ol class="small ps-3 mb-0 text-muted">
                            <li>Chuyển một khoản nhỏ (ví dụ: 2.000đ) vào STK <strong>{{ $bankAccount->account_number }}</strong> ({{ $bankAccount->bank_name }}).</li>
                            <li>Nội dung chuyển khoản chuẩn: <strong class="text-danger">{{ $bankAccount->prefix ?: 'naptien' }}&lt;ID_USER&gt;</strong> (Ví dụ User #1: <code>{{ $bankAccount->prefix ?: 'naptien' }}1</code>).</li>
                            <li>Chờ SePay gửi Webhook tự động đến server.</li>
                            <li>Theo dõi kết quả cộng tiền hiển thị ngay bên dưới.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- 4. REAL WEBHOOK MONITOR -->
            <div class="card sepay-card">
                <div class="sepay-card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="ti ti-activity-heartbeat text-danger me-2"></i> Real Webhook Monitor
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="pulse-dot bg-success"></span>
                        <small class="text-muted" id="monitor-timer">Tự cập nhật 5s</small>
                    </div>
                </div>
                <div class="card-body">
                    <div id="webhook-live-status" class="mb-3">
                        @if ($recentWebhookLogs->isNotEmpty())
                            <div class="p-3 rounded border border-success bg-success-subtle text-dark">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-success">🟢 Đã nhận webhook</span>
                                    <small class="text-muted">{{ $recentWebhookLogs->first()->created_at->format('H:i:s d/m/Y') }}</small>
                                </div>
                                <div class="small webhook-details-box">
                                    <div><strong>Ngân hàng:</strong> <span class="webhook-val">{{ $recentWebhookLogs->first()->bank_name }}</span></div>
                                    <div><strong>Số tiền:</strong> <span class="text-success fw-bold">{{ number_format($recentWebhookLogs->first()->amount) }}đ</span></div>
                                    <div><strong>User:</strong> <span class="webhook-val">{{ $recentWebhookLogs->first()->user ? '#' . $recentWebhookLogs->first()->user->id . ' - ' . $recentWebhookLogs->first()->user->username : ($recentWebhookLogs->first()->user_id ? '#' . $recentWebhookLogs->first()->user_id : 'Không xác định') }}</span></div>
                                    <div><strong>Nội dung:</strong> <code>{{ $recentWebhookLogs->first()->content }}</code></div>
                                    <div><strong>Reference:</strong> <code>{{ $recentWebhookLogs->first()->reference_code }}</code></div>
                                    <div><strong>Kết quả:</strong> <span class="badge {{ $recentWebhookLogs->first()->status === 'SUCCESS' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $recentWebhookLogs->first()->status }}</span> - <span class="webhook-val">{{ $recentWebhookLogs->first()->message }}</span></div>
                                </div>
                            </div>
                        @else
                            <div class="p-4 text-center rounded border bg-light-subtle">
                                <div class="text-muted mb-2">⏳ Đang chờ webhook từ SePay...</div>
                                <small class="text-muted">Khi có giao dịch chuyển khoản mới, hệ thống sẽ tự động cập nhật ngay tại đây.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 6. SECURITY CHECKLIST -->
            <div class="card sepay-card">
                <div class="sepay-card-header bg-light-subtle">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="ti ti-shield-check text-success me-2"></i> Security Checklist
                    </h5>
                    <span class="badge bg-success">11/11 Tiêu Chuẩn</span>
                </div>
                <div class="card-body p-3">
                    <div class="row g-1 small">
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>Authorization bắt buộc:</strong> Xác thực qua Header <code>Authorization: Apikey &lt;TOKEN&gt;</code></span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>hash_equals():</strong> So sánh Token thời gian hằng số, chống timing attacks.</span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>Token không hardcode:</strong> Lấy an toàn từ Config/Database, bảo mật tuyệt đối.</span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>Token không ghi log:</strong> Đảm bảo secret không bị lọt vào file log hay màn hình.</span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>transferType = "in":</strong> Chỉ chấp nhận giao dịch tiền vào, bỏ qua rút tiền.</span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>Amount &gt; 0:</strong> Ép kiểu số nguyên dương, chống bypass âm tiền & float precision.</span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>Nội dung naptien&lt;ID&gt;:</strong> Trích xuất chuẩn xác ID người dùng nạp tiền.</span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>User phải tồn tại:</strong> Kiểm tra user trong DB trước khi thao tác số dư.</span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>Duplicate Protection:</strong> Khóa transaction_id duy nhất trên bảng <code>bank_deposits</code>.</span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>DB Transaction & Atomic:</strong> Dùng <code>lockForUpdate()</code> chống race condition nạp 2 lần.</span>
                        </div>
                        <div class="col-12 check-item">
                            <span class="check-icon check-icon-pass">✓</span>
                            <span><strong>HTTPS Production:</strong> Bắt buộc giao thức mã hóa đường truyền cho Webhook.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. WEBHOOK HISTORY (10 GIAO DỊCH GẦN NHẤT) -->
    <div class="card sepay-card">
        <div class="sepay-card-header">
            <h5 class="card-title mb-0 fw-bold">
                <i class="ti ti-history text-primary me-2"></i> Lịch sử Webhook SePay (10 webhook gần nhất)
            </h5>
            <button class="btn btn-sm btn-outline-secondary" onclick="fetchWebhookLogs()">
                <i class="ti ti-refresh me-1"></i> Làm mới
            </button>
        </div>
        <div class="card-body px-0 py-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap w-100">
                    <thead class="bg-light-subtle text-muted small">
                        <tr>
                            <th class="ps-3">Thời gian</th>
                            <th>Ngân hàng</th>
                            <th>Nội dung</th>
                            <th>Số tiền</th>
                            <th>User</th>
                            <th>Reference</th>
                            <th class="text-end pe-3">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody id="webhook-logs-body">
                        @forelse($recentWebhookLogs as $log)
                            <tr>
                                <td class="ps-3 small">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $log->bank_name ?: 'SePay' }}</span></td>
                                <td><code>{{ $log->content ?: '—' }}</code></td>
                                <td class="fw-bold text-success">{{ number_format($log->amount) }} đ</td>
                                <td>
                                    @if($log->user)
                                        <a href="{{ route('admin.users.show', $log->user->id) }}">
                                            #{{ $log->user->id }} ({{ $log->user->username }})
                                        </a>
                                    @elseif($log->user_id)
                                        #{{ $log->user_id }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td><code>{{ $log->reference_code ?: '—' }}</code></td>
                                <td class="text-end pe-3">
                                    @php
                                        $badgeClass = match($log->status) {
                                            'SUCCESS' => 'bg-success',
                                            'DUPLICATE' => 'bg-warning text-dark',
                                            'USER_NOT_FOUND' => 'bg-danger',
                                            'INVALID_AMOUNT' => 'bg-danger',
                                            'UNAUTHORIZED' => 'bg-dark',
                                            'IGNORED' => 'bg-secondary',
                                            default => 'bg-danger'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}" title="{{ $log->message }}">
                                        {{ $log->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Chưa có dữ liệu Webhook nào được ghi nhận cho tài khoản này.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const checkConfigUrl = "{{ route('admin.bank-accounts.check-config', $bankAccount->id) }}";
    const testAuthUrl = "{{ route('admin.bank-accounts.test-auth', $bankAccount->id) }}";
    const webhookLogsUrl = "{{ route('admin.bank-accounts.webhook-logs', $bankAccount->id) }}";
    const csrfToken = "{{ csrf_token() }}";

    function runCheckConfig() {
        const btn1 = $('#btn-check-config-wizard');
        const btn2 = $('#btn-run-check');
        btn1.prop('disabled', true).html('<i class="ti ti-loader rotate me-1"></i> Đang kiểm tra...');
        btn2.prop('disabled', true).html('<i class="ti ti-loader rotate me-1"></i> Đang kiểm tra...');

        $.ajax({
            url: checkConfigUrl,
            type: 'POST',
            data: { _token: csrfToken },
            dataType: 'json',
            success: function(res) {
                btn1.prop('disabled', false).html('<i class="ti ti-search me-1"></i> [ 🔍 Kiểm tra cấu hình ]');
                btn2.prop('disabled', false).html('<i class="ti ti-checklist me-1"></i> Kiểm tra cấu hình');

                if (res.success) {
                    let html = '';
                    let checklistHtml = '';
                    $.each(res.checks, function(key, item) {
                        const icon = item.pass ? '<span class="text-success fw-bold">✓</span>' : '<span class="text-danger fw-bold">✗</span>';
                        const itemClass = item.pass ? 'text-success' : 'text-danger';
                        html += `<div class="d-flex justify-content-between py-1 border-bottom small">
                            <span>${icon} <strong>${item.label}</strong>: <span class="text-muted">${item.note}</span></span>
                            <span class="${itemClass} fw-bold">${item.pass ? 'PASS' : 'FAIL'}</span>
                        </div>`;

                        checklistHtml += `<div class="check-item">
                            <span class="check-icon ${item.pass ? 'check-icon-pass' : 'check-icon-fail'}">${item.pass ? '✓' : '✗'}</span>
                            <div><strong>${item.label}</strong>: <span class="text-muted small">${item.note}</span></div>
                        </div>`;
                    });

                    $('#test-config-details').html(html);
                    $('#test-config-result').slideDown();

                    $('#checklist-items').html(checklistHtml);
                    if (res.all_pass) {
                        $('#wizard-final-status').html('<div class="alert alert-success fw-bold mb-0 text-center"><i class="ti ti-circle-check me-1"></i> 🟢 SETUP SEPAY HOÀN TẤT - HỆ THỐNG SẴN SÀNG</div>');
                    } else {
                        $('#wizard-final-status').html('<div class="alert alert-warning fw-bold mb-0 text-center"><i class="ti ti-alert-triangle me-1"></i> 🟡 VUI LÒNG BỔ SUNG CÁC MỤC CHƯA PASS Ở TRÊN</div>');
                    }
                    $('#wizard-checklist-box').slideDown();
                }
            },
            error: function() {
                btn1.prop('disabled', false).html('<i class="ti ti-search me-1"></i> [ 🔍 Kiểm tra cấu hình ]');
                btn2.prop('disabled', false).html('<i class="ti ti-checklist me-1"></i> Kiểm tra cấu hình');
                alert('Không thể kết nối đến máy chủ để kiểm tra cấu hình.');
            }
        });
    }

    function runTestAuth() {
        const btn = $('#btn-run-auth');
        btn.prop('disabled', true).html('<i class="ti ti-loader rotate me-1"></i> Đang test...');

        $.ajax({
            url: testAuthUrl,
            type: 'POST',
            data: { _token: csrfToken },
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('<i class="ti ti-shield-lock me-1"></i> Test Authorization');

                if (res.status === 'no_token_configured') {
                    $('#test-auth-details').html(`<div class="alert alert-danger small mb-0">${res.message}</div>`);
                    $('#test-auth-result').slideDown();
                    return;
                }

                let html = '';
                const tests = [res.no_token, res.wrong_token, res.valid_token];
                tests.forEach(t => {
                    const pass = t.result === 'PASS';
                    html += `<div class="py-1 border-bottom small">
                        <div class="d-flex justify-content-between">
                            <strong>${t.name} (Mong đợi: ${t.expected})</strong>
                            <span class="badge ${pass ? 'bg-success' : 'bg-danger'}">${t.result}</span>
                        </div>
                        <div class="text-muted">${t.message}</div>
                    </div>`;
                });

                html += `<div class="mt-2 text-success small fw-semibold">✓ An toàn: Kiểm tra xác thực độc lập, không cộng tiền, không tạo giao dịch.</div>`;

                $('#test-auth-details').html(html);
                $('#test-auth-result').slideDown();
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="ti ti-shield-lock me-1"></i> Test Authorization');
                alert('Lỗi kiểm tra Authorization.');
            }
        });
    }

    function fetchWebhookLogs() {
        $.ajax({
            url: webhookLogsUrl,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.success && res.logs) {
                    let rows = '';
                    if (res.logs.length === 0) {
                        rows = '<tr><td colspan="7" class="text-center py-4 text-muted">Chưa có dữ liệu Webhook nào được ghi nhận cho tài khoản này.</td></tr>';
                    } else {
                        res.logs.forEach(log => {
                            let badgeClass = 'bg-danger';
                            if (log.status === 'SUCCESS') badgeClass = 'bg-success';
                            else if (log.status === 'DUPLICATE') badgeClass = 'bg-warning text-dark';
                            else if (log.status === 'UNAUTHORIZED') badgeClass = 'bg-dark';
                            else if (log.status === 'IGNORED') badgeClass = 'bg-secondary';

                            rows += `<tr>
                                <td class="ps-3 small">${log.created_at}</td>
                                <td><span class="badge bg-light text-dark border">${log.bank_name}</span></td>
                                <td><code>${log.content}</code></td>
                                <td class="fw-bold text-success">${log.amount}</td>
                                <td>${log.user}</td>
                                <td><code>${log.reference_code}</code></td>
                                <td class="text-end pe-3">
                                    <span class="badge ${badgeClass}" title="${log.message}">${log.status}</span>
                                </td>
                            </tr>`;
                        });
                    }
                    $('#webhook-logs-body').html(rows);

                    // Update live monitor
                    if (res.logs.length > 0) {
                        const top = res.logs[0];
                        let statusColor = top.status === 'SUCCESS' ? 'bg-success-subtle border-success' : 'bg-warning-subtle border-warning';
                        let badgeCol = top.status === 'SUCCESS' ? 'bg-success' : 'bg-warning text-dark';
                        let monitorHtml = `<div class="p-3 rounded border ${statusColor}">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold ${top.status === 'SUCCESS' ? 'text-success' : 'text-warning'}">🟢 Đã nhận webhook</span>
                                <small class="text-muted">${top.created_at}</small>
                            </div>
                            <div class="small webhook-details-box">
                                <div><strong>Ngân hàng:</strong> <span class="webhook-val">${top.bank_name}</span></div>
                                <div><strong>Số tiền:</strong> <span class="text-success fw-bold">${top.amount}</span></div>
                                <div><strong>User:</strong> <span class="webhook-val">${top.user}</span></div>
                                <div><strong>Nội dung:</strong> <code>${top.content}</code></div>
                                <div><strong>Reference:</strong> <code>${top.reference_code}</code></div>
                                <div><strong>Kết quả:</strong> <span class="badge ${badgeCol}">${top.status}</span> - <span class="webhook-val">${top.message}</span></div>
                            </div>
                        </div>`;
                        $('#webhook-live-status').html(monitorHtml);
                    }
                }
            }
        });
    }

    // Auto poll 5s
    setInterval(fetchWebhookLogs, 5000);
</script>
@endpush
