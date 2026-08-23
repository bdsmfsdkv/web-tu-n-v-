@extends('layouts.user.app')

@section('title', $title)

@section('content')

    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                    <div class="profile-header">
                        <h1 class="profile-title"><i class="fa-solid fa-building-columns me-2"></i> NẠP TIỀN QUA NGÂN HÀNG</h1>
                    </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label">SỐ DƯ:</span>
                                    <span class="balance-value">{{ number_format(Auth::user()->balance ?? 0) }} VND</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <!-- Thông báo -->
                                @if ($errors->any())
                                    <div class="service__alert service__alert--error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <div>
                                            <span>Đã có lỗi xảy ra:</span>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <button type="button" class="service__alert-close">&times;</button>
                                    </div>
                                @endif
                                @foreach (['error', 'success'] as $msg)
                                    @if (session($msg))
                                        <div
                                            class="service__alert service__alert--{{ $msg === 'error' ? 'error' : 'success' }}">
                                            <i
                                                class="fas fa-{{ $msg === 'error' ? 'exclamation-circle' : 'check-circle' }}"></i>
                                            <div>
                                                <span>{{ session($msg) }}</span>
                                            </div>
                                            <button type="button" class="service__alert-close">&times;</button>
                                        </div>
                                    @endif
                                @endforeach
                                <!-- Kết thúc thông báo -->

                                <style>
                                    .deposit-grid { display: grid; grid-template-columns: 1fr; gap: 24px; margin-top: 20px; }
                                    @media (min-width: 992px) { .deposit-grid { grid-template-columns: 350px 1fr; } }
                                    
                                    .d-box { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
                                    .d-box-title { font-weight: 700; font-size: 1.1rem; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
                                    
                                    .promo-box { border-color: #fef08a; background: #fefce8; }
                                    .promo-box .d-box-title { color: #854d0e; }
                                    .promo-tags { display: flex; gap: 12px; flex-wrap: wrap; }
                                    .promo-tag { background: rgba(234, 179, 8, 0.2); color: #854d0e; font-size: 0.85rem; padding: 6px 12px; border-radius: 20px; font-weight: 600; border: 1px solid rgba(234, 179, 8, 0.4); }
                                    
                                    .step-list { display: flex; flex-direction: column; gap: 16px; }
                                    .step-item { display: flex; gap: 16px; }
                                    .step-num { width: 28px; height: 28px; border-radius: 50%; background: #ef4444; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; }
                                    .step-content h4 { margin: 0 0 4px 0; font-size: 1rem; color: #1e293b; font-weight: 600; }
                                    .step-content p { margin: 0; font-size: 0.85rem; color: #64748b; }
                                    
                                    .bank-options { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
                                    .bank-opt { border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; cursor: pointer; transition: 0.2s; display: flex; flex-direction: row; align-items: center; gap: 12px; }
                                    .bank-opt:hover { border-color: #cbd5e1; background: #f8fafc; }
                                    .bank-opt.active { border-color: #ef4444; background: #fef2f2; box-shadow: 0 0 0 1px #ef4444; }
                                    .bank-opt-img { width: 40px; height: 40px; border-radius: 4px; flex-shrink: 0; background: #fff; display: flex; align-items: center; justify-content: center; padding: 2px; border: 1px solid #eee; }
                                    .bank-opt-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
                                    .bank-opt-info { display: flex; flex-direction: column; gap: 2px; }
                                    .bank-opt-name { font-weight: 700; color: #1e293b; font-size: 1.05rem; }
                                    .bank-opt-owner { font-size: 0.85rem; color: #64748b; }
                                    
                                    .amount-input-group { margin-bottom: 16px; }
                                    .amount-input-group label { display: block; font-weight: 600; color: #1e293b; margin-bottom: 8px; font-size: 0.95rem; }
                                    .amount-input { width: 100%; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 1rem; outline: none; transition: 0.2s; background: #f8fafc; }
                                    .amount-input:focus { border-color: #ef4444; background: #fff; }
                                    
                                    .quick-amounts { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px; }
                                    .btn-quick { background: #fff; border: 1px solid #e5e7eb; padding: 8px 16px; border-radius: 6px; font-size: 0.9rem; font-weight: 600; color: #475569; cursor: pointer; transition: 0.2s; }
                                    .btn-quick:hover, .btn-quick.active { border-color: #ef4444; color: #ef4444; background: #fef2f2; }
                                    
                                    .btn-submit { width: 100%; background: #ef4444; color: #fff; border: none; padding: 14px; border-radius: 8px; font-size: 1.05rem; font-weight: 700; cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
                                    .btn-submit:hover { background: #dc2626; }
                                    .btn-submit:disabled { background: #cbd5e1; cursor: not-allowed; }
                                    
                                    .qr-result { display: flex; flex-direction: column; gap: 24px; align-items: center; text-align: center; }
                                    @media (min-width: 768px) { .qr-result { flex-direction: row; text-align: left; align-items: flex-start; } }
                                    .qr-image { background: #fff; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; width: 250px; flex-shrink: 0; }
                                    .qr-image img { width: 100%; height: auto; display: block; border-radius: 8px; }
                                    .qr-info { flex: 1; width: 100%; }
                                    .info-row-qr { display: flex; flex-direction: column; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px dashed #e5e7eb; }
                                    .info-row-qr:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
                                    .info-row-qr span.lbl { font-size: 0.85rem; color: #64748b; margin-bottom: 4px; }
                                    .info-row-qr span.val { font-size: 1.05rem; font-weight: 700; color: #1e293b; display: flex; justify-content: space-between; align-items: center; }
                                    .info-row-qr span.val .copy-btn { background: #e2e8f0; color: #475569; border: none; padding: 4px 12px; border-radius: 4px; font-size: 0.8rem; cursor: pointer; font-weight: 600; }
                                    .info-row-qr span.val .copy-btn:hover { background: #cbd5e1; }
                                    
                                    /* Dark mode */
                                    [data-theme="dark"] .d-box { background: #171717; border-color: #2a2a2a; }
                                    [data-theme="dark"] .d-box-title { color: #f8fafc; }
                                    [data-theme="dark"] .promo-box { background: rgba(133, 77, 14, 0.1); border-color: rgba(234, 179, 8, 0.2); }
                                    [data-theme="dark"] .promo-box .d-box-title { color: #fde047; }
                                    [data-theme="dark"] .promo-tag { color: #fef08a; }
                                    [data-theme="dark"] .step-content h4 { color: #f8fafc; }
                                    [data-theme="dark"] .step-content p { color: #94a3b8; }
                                    [data-theme="dark"] .bank-opt { border-color: #333; background: #262626; }
                                    [data-theme="dark"] .bank-opt:hover { border-color: #404040; background: #333; }
                                    [data-theme="dark"] .bank-opt.active { border-color: #ef4444; background: rgba(239, 68, 68, 0.1); }
                                    [data-theme="dark"] .bank-opt-img { background: #1e1e1e; border-color: #333; }
                                    [data-theme="dark"] .bank-opt-name { color: #f8fafc; }
                                    [data-theme="dark"] .bank-opt-owner { color: #94a3b8; }
                                    [data-theme="dark"] .amount-input-group label { color: #f8fafc; }
                                    [data-theme="dark"] .amount-input { background: #262626; border-color: #333; color: #f8fafc; }
                                    [data-theme="dark"] .amount-input:focus { border-color: #ef4444; background: #1f1f1f; }
                                    [data-theme="dark"] .btn-quick { background: #262626; border-color: #333; color: #cbd5e1; }
                                    [data-theme="dark"] .btn-quick:hover, [data-theme="dark"] .btn-quick.active { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.1); }
                                    [data-theme="dark"] .btn-submit:disabled { background: #404040; color: #6b7280; }
                                    [data-theme="dark"] .qr-image { background: #262626; border-color: #333; }
                                    [data-theme="dark"] .info-row-qr { border-bottom-color: #333; }
                                    [data-theme="dark"] .info-row-qr span.lbl { color: #94a3b8; }
                                    [data-theme="dark"] .info-row-qr span.val { color: #f8fafc; }
                                    [data-theme="dark"] .info-row-qr span.val .copy-btn { background: #334155; color: #f8fafc; }
                                    [data-theme="dark"] .info-row-qr span.val .copy-btn:hover { background: #475569; }
                                    [data-theme="dark"] .profile-info-card { color: #e2e8f0; }
                                    [data-theme="dark"] .balance-info { color: #e2e8f0; }
                                    [data-theme="dark"] .history-header { color: #f8fafc; }
                                    [data-theme="dark"] .history-table { color: #e2e8f0; }
                                    [data-theme="dark"] .history-table td { color: #cbd5e1; }
                                </style>

                                <div class="deposit-grid">
                                    <!-- Left Column -->
                                    <div class="deposit-left">
                                        <div class="d-box promo-box">
                                            <div class="d-box-title"><i class="fa-solid fa-gift"></i> Khuyến mãi nạp bank</div>
                                            <div class="promo-tags">
                                                <div class="promo-tag">Nạp từ 100.000đ &rarr; +5%</div>
                                                <div class="promo-tag">Nạp từ 1.000.000đ &rarr; +10%</div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-box">
                                            <div class="d-box-title"><i class="fa-solid fa-lightbulb"></i> Hướng dẫn nạp tiền</div>
                                            <div class="step-list">
                                                <div class="step-item">
                                                    <div class="step-num">1</div>
                                                    <div class="step-content">
                                                        <h4>Tạo hoá đơn</h4>
                                                        <p>Chọn ngân hàng và nhập số tiền muốn nạp.</p>
                                                    </div>
                                                </div>
                                                <div class="step-item">
                                                    <div class="step-num">2</div>
                                                    <div class="step-content">
                                                        <h4>Chuyển khoản</h4>
                                                        <p>Quét QR hoặc chuyển đúng số tiền và nội dung CK.</p>
                                                    </div>
                                                </div>
                                                <div class="step-item">
                                                    <div class="step-num">3</div>
                                                    <div class="step-content">
                                                        <h4>Tự động cộng tiền</h4>
                                                        <p>Hệ thống xác nhận và cộng tiền trong 1-5 phút.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="deposit-right">
                                        <div class="d-box" id="step-form">
                                            <div class="d-box-title"><i class="fa-solid fa-file-invoice"></i> Tạo hoá đơn nạp tiền</div>
                                            
                                            <div class="amount-input-group">
                                                <label>Chọn ngân hàng</label>
                                                <div class="bank-options">
                                                    @if(count($bankAccounts) > 0)
                                                        @foreach($bankAccounts as $account)
                                                            <div class="bank-opt" data-bank="{{ $account->bank_name }}" data-acc="{{ $account->account_number }}" data-name="{{ $account->account_name }}" data-prefix="{{ $account->prefix }}">
                                                                @if($account->image)
                                                                    <div class="bank-opt-img">
                                                                        <img src="{{ asset($account->image) }}" alt="{{ $account->bank_name }}">
                                                                    </div>
                                                                @endif
                                                                <div class="bank-opt-info">
                                                                    <div class="bank-opt-name">{{ $account->bank_name }}</div>
                                                                    <div class="bank-opt-owner">{{ $account->account_name }}</div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-danger">Hiện tại chưa có tài khoản ngân hàng nào.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="amount-input-group">
                                                <label>Số tiền nạp</label>
                                                <input type="number" id="deposit-amount" class="amount-input" placeholder="Nhập số tiền muốn nạp">
                                            </div>
                                            
                                            <div class="quick-amounts">
                                                <button type="button" class="btn-quick" data-val="50000">50K</button>
                                                <button type="button" class="btn-quick" data-val="100000">100K</button>
                                                <button type="button" class="btn-quick" data-val="200000">200K</button>
                                                <button type="button" class="btn-quick" data-val="500000">500K</button>
                                                <button type="button" class="btn-quick" data-val="1000000">1M</button>
                                            </div>

                                            <button id="btn-create-invoice" class="btn-submit" disabled>
                                                <i class="fa-solid fa-file-invoice"></i> Tạo hoá đơn
                                            </button>
                                        </div>

                                        <!-- QR Result Step -->
                                        <div class="d-box" id="step-qr" style="display: none;">
                                            <div class="d-box-title"><i class="fa-solid fa-qrcode"></i> Quét mã thanh toán</div>
                                            <div class="qr-result">
                                                <div class="qr-image">
                                                    <img id="qr-img" src="" alt="QR Code">
                                                </div>
                                                <div class="qr-info">
                                                    <div class="info-row-qr">
                                                        <span class="lbl">Ngân hàng</span>
                                                        <span class="val" id="qr-bank"></span>
                                                    </div>
                                                    <div class="info-row-qr">
                                                        <span class="lbl">Chủ tài khoản</span>
                                                        <span class="val" id="qr-name"></span>
                                                    </div>
                                                    <div class="info-row-qr">
                                                        <span class="lbl">Số tài khoản</span>
                                                        <span class="val">
                                                            <span id="qr-acc"></span>
                                                            <button class="copy-btn" id="copy-acc" data-clipboard-text=""><i class="far fa-copy"></i> Copy</button>
                                                        </span>
                                                    </div>
                                                    <div class="info-row-qr">
                                                        <span class="lbl">Số tiền</span>
                                                        <span class="val" style="color: #ef4444;">
                                                            <span id="qr-amount"></span>
                                                            <button class="copy-btn" id="copy-amt" data-clipboard-text=""><i class="far fa-copy"></i> Copy</button>
                                                        </span>
                                                    </div>
                                                    <div class="info-row-qr">
                                                        <span class="lbl">Nội dung chuyển khoản (Bắt buộc)</span>
                                                        <span class="val" style="color: #ef4444;">
                                                            <span id="qr-content"></span>
                                                            <button class="copy-btn" id="copy-content" data-clipboard-text=""><i class="far fa-copy"></i> Copy</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button id="btn-back" class="btn-submit" style="margin-top: 24px; background: #64748b;">
                                                <i class="fa-solid fa-arrow-left"></i> Tạo hoá đơn khác
                                            </button>

                                            <!-- Waiting status animation -->
                                            <div class="deposit-waiting-box" id="deposit-waiting-box" style="margin-top: 18px; padding: 14px; background: #eff6ff; border: 1px dashed #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 10px; color: #1d4ed8; font-size: 0.9rem;">
                                                <span class="waiting-spinner"></span>
                                                <span>Đang đợi nhận tiền từ ngân hàng... Hệ thống sẽ tự động cập nhật ngay khi tiền vào.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal thông báo nạp thành công xịn sò -->
                                <div id="deposit-success-modal" class="deposit-success-modal" style="display: none;">
                                    <div class="dsm-backdrop"></div>
                                    <div class="dsm-dialog">
                                        <div class="dsm-badge-icon">
                                            <div class="dsm-icon-ring"></div>
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <h3 class="dsm-title">NẠP TIỀN THÀNH CÔNG!</h3>
                                        <p class="dsm-subtitle">Giao dịch của bạn đã được ghi nhận và cộng tiền vào tài khoản</p>
                                        
                                        <div class="dsm-amount-card">
                                            <div class="dsm-amount-label">Số tiền cộng vào tài khoản</div>
                                            <div class="dsm-amount-value" id="dsm-amount">+0 đ</div>
                                        </div>

                                        <div class="dsm-details">
                                            <div class="dsm-row">
                                                <span>Ngân hàng</span>
                                                <strong id="dsm-bank">MBBank</strong>
                                            </div>
                                            <div class="dsm-row">
                                                <span>Mã giao dịch</span>
                                                <strong id="dsm-txid">---</strong>
                                            </div>
                                            <div class="dsm-row">
                                                <span>Số dư mới</span>
                                                <strong id="dsm-balance" style="color: #10b981;">0 đ</strong>
                                            </div>
                                            <div class="dsm-row">
                                                <span>Thời gian</span>
                                                <span id="dsm-time" style="color: #64748b;">Vừa xong</span>
                                            </div>
                                        </div>

                                        <div class="dsm-actions">
                                            <button type="button" class="dsm-btn dsm-btn-primary" id="dsm-btn-close">
                                                <i class="fa-solid fa-gamepad"></i> Trải nghiệm dịch vụ ngay
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <style>
                                    /* Waiting spinner */
                                    .waiting-spinner {
                                        width: 18px;
                                        height: 18px;
                                        border: 2px solid #3b82f6;
                                        border-top-color: transparent;
                                        border-radius: 50%;
                                        display: inline-block;
                                        animation: spin 0.8s linear infinite;
                                    }
                                    @keyframes spin {
                                        to { transform: rotate(360deg); }
                                    }

                                    /* Modal Popup Success */
                                    .deposit-success-modal {
                                        position: fixed;
                                        inset: 0;
                                        z-index: 999999;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        padding: 16px;
                                    }
                                    .dsm-backdrop {
                                        position: absolute;
                                        inset: 0;
                                        background: rgba(15, 23, 42, 0.75);
                                        backdrop-filter: blur(6px);
                                        -webkit-backdrop-filter: blur(6px);
                                        animation: fadeIn 0.3s ease;
                                    }
                                    .dsm-dialog {
                                        position: relative;
                                        width: 100%;
                                        max-width: 440px;
                                        background: #ffffff;
                                        border-radius: 20px;
                                        padding: 32px 24px 24px;
                                        text-align: center;
                                        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
                                        animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                                        border: 1px solid rgba(255, 255, 255, 0.2);
                                    }
                                    [data-theme="dark"] .dsm-dialog {
                                        background: #1e293b;
                                        color: #f8fafc;
                                        border-color: #334155;
                                    }
                                    .dsm-badge-icon {
                                        width: 72px;
                                        height: 72px;
                                        margin: -60px auto 16px;
                                        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                                        border-radius: 50%;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: #fff;
                                        font-size: 32px;
                                        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
                                        position: relative;
                                    }
                                    .dsm-icon-ring {
                                        position: absolute;
                                        inset: -6px;
                                        border-radius: 50%;
                                        border: 2px dashed #10b981;
                                        animation: spin 8s linear infinite;
                                    }
                                    .dsm-title {
                                        font-size: 1.35rem;
                                        font-weight: 800;
                                        color: #10b981;
                                        margin-bottom: 6px;
                                        letter-spacing: 0.5px;
                                    }
                                    .dsm-subtitle {
                                        font-size: 0.85rem;
                                        color: #64748b;
                                        margin-bottom: 20px;
                                    }
                                    [data-theme="dark"] .dsm-subtitle {
                                        color: #94a3b8;
                                    }
                                    .dsm-amount-card {
                                        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
                                        border: 1px solid #bbf7d0;
                                        border-radius: 14px;
                                        padding: 14px;
                                        margin-bottom: 18px;
                                    }
                                    [data-theme="dark"] .dsm-amount-card {
                                        background: rgba(16, 185, 129, 0.1);
                                        border-color: rgba(16, 185, 129, 0.25);
                                    }
                                    .dsm-amount-label {
                                        font-size: 0.78rem;
                                        text-transform: uppercase;
                                        color: #059669;
                                        font-weight: 700;
                                        letter-spacing: 0.5px;
                                        margin-bottom: 4px;
                                    }
                                    [data-theme="dark"] .dsm-amount-label {
                                        color: #34d399;
                                    }
                                    .dsm-amount-value {
                                        font-size: 1.8rem;
                                        font-weight: 800;
                                        color: #047857;
                                    }
                                    [data-theme="dark"] .dsm-amount-value {
                                        color: #10b981;
                                    }
                                    .dsm-details {
                                        background: #f8fafc;
                                        border-radius: 12px;
                                        padding: 12px 16px;
                                        margin-bottom: 20px;
                                        display: flex;
                                        flex-direction: column;
                                        gap: 10px;
                                        font-size: 0.88rem;
                                        text-align: left;
                                    }
                                    [data-theme="dark"] .dsm-details {
                                        background: #0f172a;
                                    }
                                    .dsm-row {
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        color: #475569;
                                    }
                                    [data-theme="dark"] .dsm-row {
                                        color: #cbd5e1;
                                    }
                                    .dsm-row strong {
                                        color: #0f172a;
                                    }
                                    [data-theme="dark"] .dsm-row strong {
                                        color: #f1f5f9;
                                    }
                                    .dsm-actions {
                                        display: flex;
                                        gap: 10px;
                                    }
                                    .dsm-btn {
                                        flex: 1;
                                        padding: 12px 18px;
                                        border-radius: 10px;
                                        font-weight: 700;
                                        font-size: 0.95rem;
                                        cursor: pointer;
                                        border: none;
                                        transition: all 0.2s ease;
                                        display: inline-flex;
                                        align-items: center;
                                        justify-content: center;
                                        gap: 8px;
                                    }
                                    .dsm-btn-primary {
                                        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                                        color: #ffffff;
                                        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
                                    }
                                    .dsm-btn-primary:hover {
                                        opacity: 0.92;
                                        transform: translateY(-1px);
                                    }

                                    @keyframes fadeIn {
                                        from { opacity: 0; }
                                        to { opacity: 1; }
                                    }
                                    @keyframes popIn {
                                        0% { opacity: 0; transform: scale(0.8); }
                                        100% { opacity: 1; transform: scale(1); }
                                    }
                                </style>

                                <div class="deposit-history">
                                    <div class="history-header">LỊCH SỬ NẠP TIỀN</div>
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Thời gian</th>
                                                    <th>Số tiền</th>
                                                    <th>Ngân hàng</th>
                                                    <th>Nội dung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($transactions) && count($transactions) > 0)
                                                    @foreach ($transactions as $transaction)
                                                        <tr>
                                                            <td>{{ $transaction->created_at }}</td>
                                                            <td class="text-success">
                                                                {{ number_format($transaction->amount) }} VND</td>
                                                            <td>{{ $transaction->bank }}</td>
                                                            <td>{{ $transaction->content }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="no-data">Không có dữ liệu</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if (isset($transactions) && $transactions->hasPages())
                                        <div class="pagination">
                                            {{ $transactions->links('user.pagination.custom') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
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

                // UI Logic
                const bankOpts = document.querySelectorAll('.bank-opt');
                const btnQuick = document.querySelectorAll('.btn-quick');
                const inputAmount = document.getElementById('deposit-amount');
                const btnSubmit = document.getElementById('btn-create-invoice');
                const btnBack = document.getElementById('btn-back');
                
                const stepForm = document.getElementById('step-form');
                const stepQr = document.getElementById('step-qr');
                
                let selectedBank = null;
                const userId = "{{ Auth::user()->id ?? '' }}";
                let pollInterval = null;
                let lastSeenDepositId = {{ isset($transactions) && count($transactions) > 0 ? ($transactions->first()->id ?? 0) : 0 }};
                
                function checkSubmit() {
                    const amount = parseInt(inputAmount.value);
                    if (selectedBank && amount >= 10000) {
                        btnSubmit.disabled = false;
                    } else {
                        btnSubmit.disabled = true;
                    }
                }

                bankOpts.forEach(opt => {
                    opt.addEventListener('click', function() {
                        bankOpts.forEach(o => o.classList.remove('active'));
                        this.classList.add('active');
                        selectedBank = {
                            bank: this.dataset.bank,
                            acc: this.dataset.acc,
                            name: this.dataset.name,
                            prefix: this.dataset.prefix
                        };
                        checkSubmit();
                    });
                });

                btnQuick.forEach(btn => {
                    btn.addEventListener('click', function() {
                        btnQuick.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        inputAmount.value = this.dataset.val;
                        checkSubmit();
                    });
                });
                
                inputAmount.addEventListener('input', function() {
                    btnQuick.forEach(b => b.classList.remove('active'));
                    checkSubmit();
                });

                function triggerConfetti() {
                    if (typeof confetti === 'function') {
                        confetti({
                            particleCount: 80,
                            spread: 70,
                            origin: { y: 0.6 }
                        });
                        setTimeout(function() {
                            confetti({
                                particleCount: 50,
                                angle: 60,
                                spread: 55,
                                origin: { x: 0 }
                            });
                            confetti({
                                particleCount: 50,
                                angle: 120,
                                spread: 55,
                                origin: { x: 1 }
                            });
                        }, 250);
                    }
                }

                function playSuccessSound() {
                    try {
                        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                        const osc = audioCtx.createOscillator();
                        const gain = audioCtx.createGain();
                        osc.connect(gain);
                        gain.connect(audioCtx.destination);
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(587.33, audioCtx.currentTime); // D5
                        osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.1); // A5
                        gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
                        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.45);
                        osc.start();
                        osc.stop(audioCtx.currentTime + 0.5);
                    } catch (e) {}
                }

                function showDepositSuccess(deposit, newBalanceFormatted) {
                    document.getElementById('dsm-amount').textContent = '+' + deposit.amount_formatted;
                    document.getElementById('dsm-bank').textContent = deposit.bank || 'Ngân hàng';
                    document.getElementById('dsm-txid').textContent = deposit.transaction_id || '---';
                    document.getElementById('dsm-balance').textContent = (newBalanceFormatted || '0') + ' đ';
                    document.getElementById('dsm-time').textContent = deposit.created_at || 'Vừa xong';

                    document.getElementById('deposit-success-modal').style.display = 'flex';
                    playSuccessSound();
                    triggerConfetti();

                    // Update UI balance values
                    document.querySelectorAll('[data-user-balance]').forEach(el => {
                        el.textContent = newBalanceFormatted;
                    });
                    const pageBalanceVal = document.querySelector('.balance-value');
                    if (pageBalanceVal) {
                        pageBalanceVal.textContent = newBalanceFormatted + ' VND';
                    }

                    if (typeof FuiToast !== 'undefined') {
                        FuiToast.success('Nạp thành công +' + deposit.amount_formatted);
                    }
                }

                function startPolling() {
                    if (pollInterval) clearInterval(pollInterval);
                    pollInterval = setInterval(function() {
                        fetch('{{ route('profile.deposit-atm.check') }}?after_id=' + lastSeenDepositId, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.success && res.found && res.deposit) {
                                lastSeenDepositId = res.deposit.id;
                                clearInterval(pollInterval);
                                showDepositSuccess(res.deposit, res.new_balance_formatted);
                            }
                        })
                        .catch(() => {});
                    }, 3000);
                }

                btnSubmit.addEventListener('click', function() {
                    const amount = inputAmount.value;
                    const content = selectedBank.prefix + userId;
                    
                    document.getElementById('qr-bank').textContent = selectedBank.bank;
                    document.getElementById('qr-name').textContent = selectedBank.name;
                    document.getElementById('qr-acc').textContent = selectedBank.acc;
                    document.getElementById('qr-amount').textContent = new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
                    document.getElementById('qr-content').textContent = content;
                    
                    document.getElementById('copy-acc').setAttribute('data-clipboard-text', selectedBank.acc);
                    document.getElementById('copy-amt').setAttribute('data-clipboard-text', amount);
                    document.getElementById('copy-content').setAttribute('data-clipboard-text', content);
                    
                    document.getElementById('qr-img').src = `https://img.vietqr.io/image/${selectedBank.bank}-${selectedBank.acc}-compact2.png?amount=${amount}&addInfo=${content}&accountName=${selectedBank.name}`;
                    
                    stepForm.style.display = 'none';
                    stepQr.style.display = 'block';

                    startPolling();
                });
                
                if (btnBack) {
                    btnBack.addEventListener('click', function() {
                        if (pollInterval) clearInterval(pollInterval);
                        stepQr.style.display = 'none';
                        stepForm.style.display = 'block';
                    });
                }

                document.getElementById('dsm-btn-close')?.addEventListener('click', function() {
                    document.getElementById('deposit-success-modal').style.display = 'none';
                    window.location.reload();
                });

                // Close alert buttons
                const alertCloseButtons = document.querySelectorAll('.service__alert-close');
                alertCloseButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        this.closest('.service__alert').remove();
                    });
                });
            });
        </script>
    @endpush

@endsection
