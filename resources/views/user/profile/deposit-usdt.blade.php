@extends('layouts.user.app')

@section('title', $title)

@push('css')
    <style>
        /* BASE LAYOUT */
        .recharge-page {
            padding: 40px 20px;
            font-family: 'Inter', sans-serif;
        }
        .container-custom {
            max-width: 1100px;
            margin: 0 auto;
        }
        .grid-layout {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
        }
        .col-left {
            flex: 1 1 55%;
            min-width: 300px;
        }
        .col-right {
            flex: 1 1 35%;
            min-width: 300px;
        }

        /* CARDS */
        .card-custom {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.06);
            height: 100%;
        }
        .card-header-flex {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        .card-title {
            font-weight: 700;
            font-size: 1.15rem;
            margin: 0;
            color: #111827;
        }

        /* ICONS */
        .icon-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .icon-box-primary {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
        }
        .icon-box-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        /* FORM ELEMENTS */
        .form-label-custom {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
            font-size: 0.95rem;
        }
        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-custom {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 14px 60px 14px 16px;
            font-size: 1rem;
            outline: none;
            background: #fff;
            color: #111827;
            transition: all 0.2s;
        }
        .input-custom:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }
        .input-suffix {
            position: absolute;
            right: 16px;
            font-weight: 700;
            color: #dc2626;
            pointer-events: none;
        }
        .text-hint {
            display: block;
            color: #6b7280;
            font-size: 0.85rem;
            margin-top: 6px;
        }

        /* INFO BOXES */
        .info-box-custom {
            border: 1px dashed #ef4444;
            border-radius: 8px;
            padding: 16px;
            background: rgba(239, 68, 68, 0.03);
            margin-bottom: 24px;
        }
        .info-box-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            margin-top: 12px;
            border-top: 1px dashed rgba(239, 68, 68, 0.3);
        }

        /* BUTTONS */
        .btn-submit {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        .btn-pay {
            background: #3b82f6;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-pay:hover {
            background: #2563eb;
        }

        /* ALERTS & NOTICES */
        .alert-notice {
            border-left: 4px solid #ef4444;
            background: rgba(239, 68, 68, 0.05);
            padding: 16px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            line-height: 1.5;
            color: #374151;
        }
        .guide-list {
            background: #f9fafb;
            padding: 16px;
            border-radius: 8px;
        }
        .guide-item {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 0.85rem;
            color: #4b5563;
            line-height: 1.5;
        }
        .guide-item:last-child {
            margin-bottom: 0;
        }

        /* TABLE */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 10px;
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        .custom-table th, .custom-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        .custom-table th {
            background: #f9fafb;
            font-weight: 600;
            color: #4b5563;
            white-space: nowrap;
        }
        .custom-table tbody tr:hover {
            background: rgba(0,0,0,0.01);
        }

        /* BADGES */
        .badge-custom {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        .badge-pending { background: #fef3c7; color: #d97706; }
        .badge-success { background: #d1fae5; color: #059669; }
        .badge-danger { background: #fee2e2; color: #dc2626; }

        /* MOBILE LIST */
        .mobile-history-list {
            display: none;
            flex-direction: column;
            gap: 16px;
        }
        .mobile-card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            background: #fff;
        }
        .mobile-card-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 0.85rem;
        }
        .mobile-card-row.border-top {
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
            margin-top: 12px;
            margin-bottom: 0;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .table-container { display: none; }
            .mobile-history-list { display: flex; }
            .col-left, .col-right { flex: 1 1 100%; }
            .recharge-page { padding: 20px 12px; }
        }

        /* MODAL */
        #paymentModalOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 100000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .custom-modal-content {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            width: 90%;
            max-width: 420px;
            animation: popIn .3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            position: relative;
        }
        @keyframes popIn {
            from { transform: scale(0.9) translateY(20px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn-close-modal {
            background: #f3f4f6;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #6b7280;
            transition: all 0.2s;
        }
        .btn-close-modal:hover {
            background: #e5e7eb;
            color: #111827;
        }
        .qr-container {
            text-align: center;
            margin-bottom: 24px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 12px;
            border: 1px dashed #d1d5db;
        }
        .modal-info-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 16px;
        }
        .modal-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px dashed #d1d5db;
        }
        .modal-info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .modal-info-row:first-child {
            padding-top: 0;
        }
        .copy-btn { 
            background: #e2e8f0; color: #475569; border: none; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; cursor: pointer; font-weight: 600; margin-left: 8px; transition: 0.2s;
        }
        .copy-btn:hover { background: #cbd5e1; }

        /* DARK MODE SUPPORT */
        [data-theme="dark"] .card-custom, [data-theme="dark"] .mobile-card {
            background: #262626 !important;
            border-color: #404040 !important;
        }
        [data-theme="dark"] .card-title, [data-theme="dark"] .form-label-custom, [data-theme="dark"] .custom-table th, [data-theme="dark"] .custom-table td, [data-theme="dark"] .text-hint {
            color: #f3f4f6 !important;
        }
        [data-theme="dark"] .input-custom {
            background: #141414 !important;
            border-color: #404040 !important;
            color: #f3f4f6 !important;
        }
        [data-theme="dark"] .input-suffix {
            color: #ef4444 !important;
        }
        [data-theme="dark"] .info-box-custom {
            background: rgba(239, 68, 68, 0.1) !important;
            border-color: #ef4444 !important;
        }
        [data-theme="dark"] .guide-list {
            background: #141414 !important;
        }
        [data-theme="dark"] .guide-item {
            color: #d1d5db !important;
        }
        [data-theme="dark"] .alert-notice {
            color: #f3f4f6 !important;
            background: rgba(239, 68, 68, 0.15) !important;
        }
        [data-theme="dark"] .custom-table th {
            background: #1f1f1f !important;
            border-color: #404040 !important;
        }
        [data-theme="dark"] .custom-table td, [data-theme="dark"] .mobile-card-row.border-top {
            border-color: #404040 !important;
        }
        [data-theme="dark"] .custom-table tbody tr:hover {
            background: rgba(255,255,255,0.03) !important;
        }
        [data-theme="dark"] .custom-modal-content {
            background: #262626 !important;
            border: 1px solid #404040;
        }
        [data-theme="dark"] .qr-container, [data-theme="dark"] .modal-info-box {
            background: #141414 !important;
            border-color: #404040 !important;
        }
        [data-theme="dark"] .btn-close-modal {
            background: #404040 !important;
            color: #d1d5db !important;
        }
        [data-theme="dark"] .btn-close-modal:hover {
            background: #525252 !important;
            color: #f3f4f6 !important;
        }
        [data-theme="dark"] .modal-info-row {
            border-color: #404040 !important;
        }
        [data-theme="dark"] select.input-custom option {
            background: #262626;
            color: #f3f4f6;
        }
        [data-theme="dark"] .copy-btn { background: #334155; color: #f3f4f6; }
        [data-theme="dark"] .copy-btn:hover { background: #475569; }
    </style>
@endpush

@section('content')
<section class="recharge-page">
    <div class="container-custom">
        
        @if (session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; font-weight: 500;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid-layout">
            <!-- LEFT COLUMN: FORM -->
            <div class="col-left">
                <div class="card-custom">
                    <div class="card-header-flex">
                        <div class="icon-box icon-box-primary">
                            <i class="fa-solid fa-circle-dollar-to-slot"></i>
                        </div>
                        <h2 class="card-title">Nạp tiền qua USDT (Tự động)</h2>
                    </div>

                    <form action="{{ route('profile.deposit-usdt') }}" method="POST" id="usdtForm">
                        @csrf
                        
                        <div style="margin-bottom: 24px;">
                            <label for="usdt-amount" class="form-label-custom">Số lượng USDT cần nạp</label>
                            <div class="input-group-custom">
                                <input type="number" class="input-custom" id="usdt-amount" name="amount" min="1" step="0.01" placeholder="Ví dụ: 10, 50, 100..." required>
                                <span class="input-suffix">USDT</span>
                            </div>
                            <span class="text-hint">Hạn mức tối thiểu: 1 USDT</span>
                        </div>

                        <div class="info-box-custom">
                            <div style="font-size: 0.95rem;">Tỷ giá quy đổi: <strong style="color: #dc2626;">1 USDT = {{ number_format($rate) }} VND</strong></div>
                            <div class="info-box-row">
                                <span style="font-size: 0.95rem; font-weight: 600;">Thực nhận:</span>
                                <span id="vnd-received" style="font-weight: 700; color: #059669; font-size: 1.25rem;">0 VND</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-bolt"></i> Xác nhận tạo hoá đơn
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIGHT COLUMN: GUIDE -->
            <div class="col-right">
                <div class="card-custom">
                    <div class="card-header-flex">
                        <div class="icon-box icon-box-warning">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <h2 class="card-title">Lưu ý & Hướng dẫn</h2>
                    </div>
                    
                    <div class="alert-notice">
                        <div style="margin-bottom: 8px;"><strong>Mạng lưới hỗ trợ:</strong> Cổng thanh toán hỗ trợ các chuỗi phổ biến: <strong>TRC20, BEP20, ERC20...</strong></div>
                        <div style="opacity: 0.9;">Khách hàng có thể quét mã QR hiển thị hoặc copy địa chỉ ví chính xác để thanh toán từ các ví cá nhân (Trust Wallet, Metamask, Binance, OKX...).</div>
                    </div>

                    <div class="guide-list">
                        <div class="guide-item">
                            <i class="fa-solid fa-circle-check" style="color: #059669; font-size: 1rem; margin-top: 2px;"></i>
                            <span>Số tiền được tự động cộng vào tài khoản sau khi Blockchain xác nhận thành công (thường mất 1-3 phút).</span>
                        </div>
                        <div class="guide-item">
                            <i class="fa-solid fa-circle-check" style="color: #059669; font-size: 1rem; margin-top: 2px;"></i>
                            <span>Vui lòng điền đúng số lượng cần nạp và lưu ý phí mạng lưới (gas fee) của sàn giao dịch trước khi gửi.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HISTORY TABLE -->
        <div style="margin-top: 32px;">
            <div class="card-custom">
                <div class="card-header-flex">
                    <div class="icon-box icon-box-primary">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <h2 class="card-title">Lịch sử hoá đơn USDT</h2>
                </div>

                <!-- Desktop Table View -->
                <div class="table-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Mã yêu cầu</th>
                                <th>Số tiền quy đổi</th>
                                <th>Tỷ giá</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td style="font-weight: 600; color: #dc2626;">{{ $transaction->request_code }}</td>
                                    <td>
                                        <div style="font-weight: 700; color: #059669;">{{ number_format($transaction->usdt_amount, 2) }} USDT</div>
                                        <div style="font-size: 0.8rem; color: #6b7280; margin-top: 4px;">≈ {{ number_format($transaction->vnd_amount) }} VND</div>
                                    </td>
                                    <td style="color: #6b7280;">{{ number_format($transaction->exchange_rate) }} <span style="font-size: 0.8rem;">VND/USDT</span></td>
                                    <td style="color: #4b5563;">{{ $transaction->created_at->format('H:i d/m/Y') }}</td>
                                    <td>
                                        @if($transaction->status === 'pending')
                                            <span class="badge-custom badge-pending">Chờ thanh toán</span>
                                        @elseif($transaction->status === 'completed')
                                            <span class="badge-custom badge-success">Thành công</span>
                                        @else
                                            <span class="badge-custom badge-danger">Đã huỷ</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->status === 'pending')
                                            <button class="btn-pay view-payment" data-code="{{ $transaction->request_code }}" data-amount="{{ $transaction->usdt_amount }}">
                                                <i class="fa-solid fa-qrcode"></i> Thanh toán
                                            </button>
                                        @else
                                            <span style="color: #9ca3af;">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px 0; color: #6b7280;">
                                        <i class="fa-solid fa-inbox" style="font-size: 2rem; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                                        Chưa có giao dịch nạp USDT nào
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile List View -->
                <div class="mobile-history-list">
                    @forelse($transactions as $transaction)
                        <div class="mobile-card">
                            <div class="mobile-card-row">
                                <strong style="color: #dc2626; font-size: 0.95rem;">{{ $transaction->request_code }}</strong>
                                @if($transaction->status === 'pending')
                                    <span class="badge-custom badge-pending">Chờ thanh toán</span>
                                @elseif($transaction->status === 'completed')
                                    <span class="badge-custom badge-success">Thành công</span>
                                @else
                                    <span class="badge-custom badge-danger">Đã huỷ</span>
                                @endif
                            </div>
                            <div class="mobile-card-row">
                                <span style="color: #6b7280;">Số lượng:</span>
                                <strong style="color: #059669;">{{ number_format($transaction->usdt_amount, 2) }} USDT</strong>
                            </div>
                            <div class="mobile-card-row">
                                <span style="color: #6b7280;">Thực nhận:</span>
                                <strong>≈ {{ number_format($transaction->vnd_amount) }} VND</strong>
                            </div>
                            <div class="mobile-card-row">
                                <span style="color: #6b7280;">Tỷ giá:</span>
                                <span style="color: #4b5563;">{{ number_format($transaction->exchange_rate) }}</span>
                            </div>
                            <div class="mobile-card-row border-top">
                                <span style="color: #6b7280; font-size: 0.8rem;">{{ $transaction->created_at->format('H:i d/m/Y') }}</span>
                                @if($transaction->status === 'pending')
                                    <button class="btn-pay view-payment" data-code="{{ $transaction->request_code }}" data-amount="{{ $transaction->usdt_amount }}">
                                        <i class="fa-solid fa-qrcode"></i> Thanh toán
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 0; color: #6b7280; border: 1px dashed #e5e7eb; border-radius: 12px;">
                            Chưa có giao dịch nạp USDT nào
                        </div>
                    @endforelse
                </div>

                @if($transactions->hasPages())
                    <div style="margin-top: 24px;">
                        {{ $transactions->links('user.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Custom Overlay Modal -->
<div id="paymentModalOverlay" onclick="if(event.target===this)this.style.display='none'">
    <div class="custom-modal-content">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color, #111827);">Thanh toán USDT</h3>
            <button class="btn-close-modal" onclick="document.getElementById('paymentModalOverlay').style.display='none'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <div class="qr-container">
            <img src="" alt="QR Code" id="payment-qr" style="width: 180px; height: 180px; display: inline-block; border-radius: 8px;">
            <div style="font-size: 0.85rem; color: #6b7280; margin-top: 12px;">Quét mã QR để chuyển tiền nhanh</div>
        </div>

        <div style="margin-bottom: 20px;">
            <label class="form-label-custom">Chọn mạng lưới / Ví nhận:</label>
            <div class="input-group-custom" style="border-radius: 8px;">
                <select id="modal-network" class="input-custom" style="padding: 10px; cursor: pointer;">
                    @foreach($usdtAccounts as $acc)
                        <option value="{{ $acc->wallet_address }}" data-type="{{ $acc->type }}" data-qr="{{ $acc->qr_image }}">{{ $acc->name }} ({{ strtoupper($acc->type) }})</option>
                    @endforeach
                    @if($usdtAccounts->isEmpty())
                        <option value="">Chưa có ví USDT nào</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="modal-info-box">
            <div class="modal-info-row">
                <span style="color: #6b7280; font-size: 0.9rem;">Địa chỉ ví:</span>
                <div style="display: flex; align-items: center; justify-content: flex-end; max-width: 65%;">
                    <strong id="modal-wallet-address" style="font-size: 0.9rem; word-break: break-all; text-align: right; color: var(--text-color, #111827);">Đang tải...</strong>
                    <button class="copy-btn" id="copy-wallet" data-clipboard-text=""><i class="far fa-copy"></i> Copy</button>
                </div>
            </div>
            <div class="modal-info-row">
                <span style="color: #6b7280; font-size: 0.9rem;">Số lượng nạp:</span>
                <div style="display: flex; align-items: center;">
                    <strong id="modal-amount" style="font-size: 1.1rem; color: #dc2626;">0.00 USDT</strong>
                    <button class="copy-btn" id="copy-amount" data-clipboard-text=""><i class="far fa-copy"></i> Copy</button>
                </div>
            </div>
            <div class="modal-info-row">
                <span style="color: #6b7280; font-size: 0.9rem;">Nội dung (Memo):</span>
                <div style="display: flex; align-items: center;">
                    <strong id="modal-code" style="font-size: 1rem; color: #3b82f6;">USDT_...</strong>
                    <button class="copy-btn" id="copy-code" data-clipboard-text=""><i class="far fa-copy"></i> Copy</button>
                </div>
            </div>
        </div>

        <div style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 4px; font-size: 0.85rem; color: #d97706; line-height: 1.5;">
            <i class="fa-solid fa-triangle-exclamation" style="margin-right: 4px;"></i> 
            Vui lòng chuyển <strong>chính xác số tiền</strong> (bao gồm số lẻ) và ghi đúng <strong>Nội dung (Memo)</strong> để được xử lý tự động.
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>

@if(session('auto_show_modal'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const autoShowData = @json(session('auto_show_modal'));
        const modalOverlay = document.getElementById('paymentModalOverlay');
        const modalAmount = document.getElementById('modal-amount');
        const modalCode = document.getElementById('modal-code');
        const networkSelect = document.getElementById('modal-network');
        
        const amountVal = parseFloat(autoShowData.amount).toFixed(2);
        const code = autoShowData.code;
        
        modalAmount.textContent = amountVal + ' USDT';
        modalCode.textContent = code;
        
        document.getElementById('copy-amount').setAttribute('data-clipboard-text', amountVal);
        document.getElementById('copy-code').setAttribute('data-clipboard-text', code);
        
        if (networkSelect) {
            const ev = new Event('change');
            networkSelect.dispatchEvent(ev);
        }
        
        modalOverlay.style.display = 'flex';
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Clipboard.js init
        var clipboard = new ClipboardJS('.copy-btn');

        clipboard.on('success', function(e) {
            const originalText = e.trigger.innerHTML;
            e.trigger.innerHTML = '<i class="fas fa-check"></i> Đã chép';

            if (typeof FuiToast !== 'undefined') {
                FuiToast.success('Đã sao chép: ' + e.text);
            }

            setTimeout(function() {
                e.trigger.innerHTML = originalText;
            }, 2000);

            e.clearSelection();
        });

        const rate = {{ $rate }};
        const amountInput = document.getElementById('usdt-amount');
        const vndReceived = document.getElementById('vnd-received');

        if (amountInput && vndReceived) {
            amountInput.addEventListener('input', function() {
                let amount = parseFloat(this.value) || 0;
                let total = amount * rate;
                vndReceived.textContent = new Intl.NumberFormat('vi-VN').format(total) + ' VND';
            });
        }

        const viewBtns = document.querySelectorAll('.view-payment');
        const modalOverlay = document.getElementById('paymentModalOverlay');
        const modalAmount = document.getElementById('modal-amount');
        const modalCode = document.getElementById('modal-code');
        const modalQr = document.getElementById('payment-qr');
        const networkSelect = document.getElementById('modal-network');
        const modalWalletAddress = document.getElementById('modal-wallet-address');

        function updateModalNetworkInfo() {
            if (!networkSelect) return;
            const selectedOption = networkSelect.options[networkSelect.selectedIndex];
            if (!selectedOption) return;

            const walletAddress = selectedOption.value || '';
            const type = selectedOption.getAttribute('data-type') || '';
            const customQr = selectedOption.getAttribute('data-qr') || '';
            
            modalWalletAddress.textContent = walletAddress || 'Chưa cấu hình ví';
            document.getElementById('copy-wallet').setAttribute('data-clipboard-text', walletAddress);
            
            if (customQr) {
                modalQr.src = customQr;
                modalQr.style.display = 'inline-block';
            } else if (walletAddress && type === 'trc20') {
                let qrData = walletAddress;
                // Nếu là TRC20 thì auto-gen QR code
                modalQr.src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrData)}&size=300x300`;
                modalQr.style.display = 'inline-block';
            } else {
                // Hiển thị icon 404 cho Binance nếu không có custom QR
                modalQr.src = 'https://placehold.co/200x200/f3f4f6/9ca3af.png?text=404+QR';
                modalQr.style.display = 'inline-block';
            }
        }

        if (networkSelect) {
            networkSelect.addEventListener('change', updateModalNetworkInfo);
        }

        viewBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const originalCode = this.getAttribute('data-code');
                const amount = this.getAttribute('data-amount');
                
                const amountVal = parseFloat(amount).toFixed(2);
                const displayCode = 'Nap{{ Auth::id() }}';

                modalAmount.textContent = amountVal + ' USDT';
                modalCode.textContent = displayCode;
                
                document.getElementById('copy-amount').setAttribute('data-clipboard-text', amountVal);
                document.getElementById('copy-code').setAttribute('data-clipboard-text', displayCode);
                
                updateModalNetworkInfo();
                
                modalOverlay.style.display = 'flex';
            });
        });
    });
</script>
@endpush
