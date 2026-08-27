@extends('layouts.user.app')

@section('title', $title ?? 'Chi tiết đơn hàng random')

@php
    $backCategoryUrl = $returnUrl ?? route('home');
    if (!$returnUrl && isset($order->category) && !empty($order->category->slug)) {
        $backCategoryUrl = route('random.index', ['slug' => $order->category->slug]);
    } elseif (!$returnUrl && session()->has('last_category_url') && !empty(session('last_category_url'))) {
        $backCategoryUrl = session('last_category_url');
    }
@endphp

@section('content')
<section class="profile-section" style="padding-bottom: 90px; min-height: 80vh;">
    <div class="container">
        <div class="profile-container">
            <div class="profile-header mb-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ $backCategoryUrl }}" class="btn-back-link" title="Quay lại danh mục">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="profile-title mb-1" style="font-size: 1.5rem; font-weight: 800;">
                                ĐƠN HÀNG #{{ str_replace(['ORD-', 'LEGACY-'], '', $order->batch_id) }}
                            </h1>
                            <div class="d-flex align-items-center gap-2 text-muted small">
                                <span><i class="fa-regular fa-clock me-1"></i> {{ \Carbon\Carbon::parse($order->purchase_time)->format('H:i - d/m/Y') }}</span>
                                <span>•</span>
                                <span>{{ \Carbon\Carbon::parse($order->purchase_time)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="order-status-badge">
                        <span class="status-pulse-dot"></span>
                        <i class="fa-solid fa-circle-check me-1"></i> GIAO DỊCH HOÀN TẤT
                    </div>
                </div>
            </div>

            <div class="profile-content">
                @include('layouts.user.sidebar')

                <div class="profile-main">
                    <style>
                        /* Modern Order Detail Styles */
                        .btn-back-link {
                            width: 42px;
                            height: 42px;
                            border-radius: 12px;
                            background: #f1f5f9;
                            color: #334155;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            text-decoration: none;
                            transition: var(--transition-smooth);
                            border: 1px solid #e2e8f0;
                        }
                        .btn-back-link:hover {
                            background: var(--primary);
                            color: #ffffff;
                            transform: translateY(-2px);
                            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
                        }
                        [data-theme="dark"] .btn-back-link {
                            background: #27272a;
                            border-color: rgba(255, 255, 255, 0.08);
                            color: #f8fafc;
                        }
                        [data-theme="dark"] .btn-back-link:hover {
                            background: var(--primary);
                            color: #ffffff;
                        }

                        .order-status-badge {
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            background: rgba(34, 197, 94, 0.12);
                            color: #16a34a;
                            border: 1px solid rgba(34, 197, 94, 0.3);
                            padding: 6px 14px;
                            border-radius: 30px;
                            font-size: 0.82rem;
                            font-weight: 800;
                            letter-spacing: 0.5px;
                        }
                        .status-pulse-dot {
                            width: 8px;
                            height: 8px;
                            background: #16a34a;
                            border-radius: 50%;
                            display: inline-block;
                            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
                            animation: statusPulse 1.8s infinite;
                        }
                        @keyframes statusPulse {
                            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
                            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
                            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
                        }
                        [data-theme="dark"] .order-status-badge {
                            background: rgba(34, 197, 94, 0.18);
                            color: #4ade80;
                            border-color: rgba(74, 222, 128, 0.3);
                        }

                        /* Order Summary Card */
                        .order-summary-card {
                            background: #ffffff;
                            border: 1px solid #e2e8f0;
                            border-radius: 16px;
                            padding: 24px;
                            margin-bottom: 24px;
                            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
                            transition: var(--transition-smooth);
                        }
                        [data-theme="dark"] .order-summary-card {
                            background: #18181b;
                            border-color: rgba(255, 255, 255, 0.08);
                            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.3);
                        }

                        .order-meta-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                            gap: 16px;
                        }
                        .order-meta-box {
                            background: #f8fafc;
                            border: 1px solid #f1f5f9;
                            border-radius: 12px;
                            padding: 14px 16px;
                            display: flex;
                            align-items: center;
                            gap: 14px;
                            transition: var(--transition-smooth);
                        }
                        .order-meta-box:hover {
                            border-color: #cbd5e1;
                            transform: translateY(-2px);
                        }
                        [data-theme="dark"] .order-meta-box {
                            background: #27272a;
                            border-color: rgba(255, 255, 255, 0.05);
                        }
                        [data-theme="dark"] .order-meta-box:hover {
                            border-color: rgba(255, 255, 255, 0.12);
                            background: #2d2d30;
                        }

                        .order-meta-icon {
                            width: 44px;
                            height: 44px;
                            border-radius: 12px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 1.2rem;
                            flex-shrink: 0;
                        }
                        .icon-category { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
                        .icon-quantity { background: rgba(168, 85, 247, 0.12); color: #a855f7; }
                        .icon-total { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
                        .icon-time { background: rgba(234, 179, 8, 0.12); color: #eab308; }

                        .order-meta-info {
                            flex: 1;
                            min-width: 0;
                        }
                        .order-meta-label {
                            font-size: 0.76rem;
                            font-weight: 700;
                            color: #64748b;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            margin-bottom: 2px;
                        }
                        [data-theme="dark"] .order-meta-label {
                            color: #a1a1aa;
                        }
                        .order-meta-val {
                            font-size: 1rem;
                            font-weight: 800;
                            color: #0f172a;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                        [data-theme="dark"] .order-meta-val {
                            color: #f8fafc;
                        }

                        /* Account Vault Section */
                        .vault-section {
                            background: #ffffff;
                            border: 1px solid #e2e8f0;
                            border-radius: 16px;
                            padding: 24px;
                            margin-bottom: 24px;
                            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
                        }
                        [data-theme="dark"] .vault-section {
                            background: #18181b;
                            border-color: rgba(255, 255, 255, 0.08);
                        }

                        .vault-header {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            flex-wrap: wrap;
                            gap: 12px;
                            padding-bottom: 18px;
                            margin-bottom: 20px;
                            border-bottom: 1px solid #f1f5f9;
                        }
                        [data-theme="dark"] .vault-header {
                            border-color: rgba(255, 255, 255, 0.06);
                        }

                        .vault-title {
                            font-size: 1.15rem;
                            font-weight: 800;
                            color: #0f172a;
                            display: flex;
                            align-items: center;
                            gap: 8px;
                        }
                        [data-theme="dark"] .vault-title {
                            color: #f8fafc;
                        }

                        .btn-vault-action {
                            display: inline-flex;
                            align-items: center;
                            gap: 7px;
                            padding: 8px 16px;
                            border-radius: 10px;
                            font-size: 0.85rem;
                            font-weight: 700;
                            border: none;
                            cursor: pointer;
                            transition: var(--transition-smooth);
                        }
                        .btn-vault-copy-all {
                            background: var(--brand-gradient);
                            color: #ffffff;
                            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
                        }
                        .btn-vault-copy-all:hover {
                            opacity: 0.95;
                            transform: translateY(-2px);
                            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.35);
                            color: #ffffff;
                        }
                        .btn-vault-export {
                            background: #334155;
                            color: #ffffff;
                        }
                        .btn-vault-export:hover {
                            background: #1e293b;
                            transform: translateY(-2px);
                        }
                        [data-theme="dark"] .btn-vault-export {
                            background: #27272a;
                            border: 1px solid rgba(255, 255, 255, 0.1);
                        }
                        [data-theme="dark"] .btn-vault-export:hover {
                            background: #3f3f46;
                        }

                        /* Account Cards */
                        .acc-card {
                            background: #f8fafc;
                            border: 1px solid #e2e8f0;
                            border-radius: 14px;
                            padding: 16px;
                            margin-bottom: 14px;
                            transition: var(--transition-smooth);
                        }
                        .acc-card:hover {
                            border-color: #cbd5e1;
                            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
                        }
                        [data-theme="dark"] .acc-card {
                            background: #212124;
                            border-color: rgba(255, 255, 255, 0.06);
                        }
                        [data-theme="dark"] .acc-card:hover {
                            background: #27272a;
                            border-color: rgba(255, 255, 255, 0.12);
                        }

                        .acc-card-header {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            margin-bottom: 12px;
                            padding-bottom: 10px;
                            border-bottom: 1px dashed #e2e8f0;
                        }
                        [data-theme="dark"] .acc-card-header {
                            border-color: rgba(255, 255, 255, 0.08);
                        }

                        .acc-card-num {
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            font-size: 0.82rem;
                            font-weight: 800;
                            color: var(--primary);
                            background: rgba(220, 38, 38, 0.1);
                            padding: 3px 10px;
                            border-radius: 20px;
                        }

                        .acc-fields-grid {
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 12px;
                        }
                        @media (max-width: 768px) {
                            .acc-fields-grid {
                                grid-template-columns: 1fr;
                            }
                        }

                        .acc-field-box {
                            background: #ffffff;
                            border: 1px solid #e2e8f0;
                            border-radius: 10px;
                            padding: 10px 14px;
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            gap: 10px;
                        }
                        [data-theme="dark"] .acc-field-box {
                            background: #18181b;
                            border-color: rgba(255, 255, 255, 0.08);
                        }

                        .acc-field-info {
                            flex: 1;
                            min-width: 0;
                        }
                        .acc-field-label {
                            font-size: 0.72rem;
                            font-weight: 700;
                            color: #94a3b8;
                            text-transform: uppercase;
                            margin-bottom: 2px;
                        }
                        .acc-field-val {
                            font-family: 'Consolas', 'Courier New', monospace;
                            font-size: 0.95rem;
                            font-weight: 700;
                            color: #0f172a;
                            word-break: break-all;
                            letter-spacing: 0.5px;
                        }
                        [data-theme="dark"] .acc-field-val {
                            color: #f8fafc;
                        }

                        .btn-field-action {
                            background: #f1f5f9;
                            color: #475569;
                            border: 1px solid #e2e8f0;
                            width: 32px;
                            height: 32px;
                            border-radius: 8px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            cursor: pointer;
                            transition: var(--transition-smooth);
                            flex-shrink: 0;
                        }
                        .btn-field-action:hover {
                            background: var(--primary);
                            color: #ffffff;
                            border-color: var(--primary);
                        }
                        [data-theme="dark"] .btn-field-action {
                            background: #27272a;
                            border-color: rgba(255, 255, 255, 0.08);
                            color: #a1a1aa;
                        }
                        [data-theme="dark"] .btn-field-action:hover {
                            background: var(--primary);
                            color: #ffffff;
                            border-color: var(--primary);
                        }

                        /* Alert Security Box */
                        .order-security-alert {
                            background: linear-gradient(135deg, rgba(234, 179, 8, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%);
                            border: 1px solid rgba(234, 179, 8, 0.3);
                            border-radius: 14px;
                            padding: 16px 20px;
                            display: flex;
                            align-items: center;
                            gap: 14px;
                            color: #b45309;
                            font-size: 0.88rem;
                            line-height: 1.5;
                        }
                        [data-theme="dark"] .order-security-alert {
                            background: linear-gradient(135deg, rgba(234, 179, 8, 0.15) 0%, rgba(24, 24, 27, 0.6) 100%);
                            border-color: rgba(234, 179, 8, 0.25);
                            color: #fde047;
                        }
                        .order-security-alert i {
                            font-size: 1.4rem;
                            flex-shrink: 0;
                        }
                    </style>

                    <!-- Order Summary Master Card -->
                    <div class="order-summary-card">
                        <div class="order-meta-grid">
                            <div class="order-meta-box">
                                <div class="order-meta-icon icon-category">
                                    <i class="fa-solid fa-gamepad"></i>
                                </div>
                                <div class="order-meta-info">
                                    <div class="order-meta-label">Danh mục</div>
                                    <div class="order-meta-val" title="{{ $order->category->name ?? 'Tài khoản ngẫu nhiên' }}">
                                        {{ $order->category->name ?? 'Tài khoản ngẫu nhiên' }}
                                    </div>
                                </div>
                            </div>

                            <div class="order-meta-box">
                                <div class="order-meta-icon icon-quantity">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                                <div class="order-meta-info">
                                    <div class="order-meta-label">Số lượng</div>
                                    <div class="order-meta-val">{{ $order->quantity }} Tài khoản</div>
                                </div>
                            </div>

                            <div class="order-meta-box">
                                <div class="order-meta-icon icon-total">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                                <div class="order-meta-info">
                                    <div class="order-meta-label">Tổng thanh toán</div>
                                    <div class="order-meta-val text-danger" style="color: #ef4444 !important;">
                                        {{ number_format($order->total_price) }}đ
                                    </div>
                                </div>
                            </div>

                            <div class="order-meta-box">
                                <div class="order-meta-icon icon-time">
                                    <i class="fa-regular fa-calendar-check"></i>
                                </div>
                                <div class="order-meta-info">
                                    <div class="order-meta-label">Thời gian mua</div>
                                    <div class="order-meta-val">
                                        {{ \Carbon\Carbon::parse($order->purchase_time)->format('H:i d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Locker / Vault -->
                    <div class="vault-section">
                        @php
                            $allAccountsStr = '';
                            foreach($order->accounts as $acc) {
                                $str = $acc->account_name . ($acc->password ? '|' . $acc->password : '');
                                $allAccountsStr .= $str . "\n";
                            }
                            $allAccountsStr = trim($allAccountsStr);
                        @endphp

                        <div class="vault-header">
                            <div class="vault-title">
                                <i class="fa-solid fa-key text-danger"></i>
                                Danh Sách Tài Khoản Đã Nhận ({{ $order->quantity }})
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn-vault-action btn-vault-copy-all" onclick="copyToClipboardText('{{ addslashes(str_replace("\n", "\\n", $allAccountsStr)) }}', 'Đã sao chép tất cả tài khoản & mật khẩu!')">
                                    <i class="fa-solid fa-copy"></i> Copy Tất Cả
                                </button>
                                <button type="button" class="btn-vault-action btn-vault-export" onclick="exportToTxt('{{ addslashes(str_replace("\n", "\\n", $allAccountsStr)) }}', 'don_hang_random_{{ str_replace(['ORD-', 'LEGACY-'], '', $order->batch_id) }}.txt')">
                                    <i class="fa-solid fa-file-arrow-down"></i> Tải File TXT
                                </button>
                            </div>
                        </div>

                        @foreach($order->accounts as $index => $acc)
                            <div class="acc-card">
                                <div class="acc-card-header">
                                    <div class="acc-card-num">
                                        <i class="fa-solid fa-hashtag"></i> Tài khoản #{{ $index + 1 }}
                                    </div>
                                    <button type="button" class="btn btn-xs btn-outline-danger fw-bold d-flex align-items-center gap-1" onclick="copyToClipboardText('{{ addslashes($acc->account_name . ($acc->password ? '|' . $acc->password : '')) }}', 'Đã copy TK|MK #{{ $index + 1 }}!')" style="border-radius: 8px; font-size: 0.75rem; padding: 3px 10px;">
                                        <i class="fa-solid fa-copy"></i> Copy Cả Cặp
                                    </button>
                                </div>

                                <div class="acc-fields-grid">
                                    <!-- Username Field -->
                                    <div class="acc-field-box">
                                        <div class="acc-field-info">
                                            <div class="acc-field-label"><i class="fa-solid fa-user me-1"></i> Tài khoản / Username</div>
                                            <div class="acc-field-val" id="user-val-{{ $index }}">{{ $acc->account_name }}</div>
                                        </div>
                                        <button type="button" class="btn-field-action" title="Sao chép tài khoản" onclick="copyToClipboardText('{{ addslashes($acc->account_name) }}', 'Đã sao chép tài khoản!')">
                                            <i class="fa-solid fa-clone"></i>
                                        </button>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="acc-field-box">
                                        <div class="acc-field-info">
                                            <div class="acc-field-label"><i class="fa-solid fa-lock me-1"></i> Mật khẩu / Password</div>
                                            <div class="acc-field-val" id="pass-val-{{ $index }}">
                                                @if($acc->password)
                                                    <span class="pass-masked">••••••••</span>
                                                    <span class="pass-plain d-none">{{ $acc->password }}</span>
                                                @else
                                                    <span class="text-muted small">Không có mật khẩu</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($acc->password)
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn-field-action" title="Hiện/Ẩn mật khẩu" onclick="togglePassVisibility({{ $index }})">
                                                <i class="fa-solid fa-eye" id="eye-icon-{{ $index }}"></i>
                                            </button>
                                            <button type="button" class="btn-field-action" title="Sao chép mật khẩu" onclick="copyToClipboardText('{{ addslashes($acc->password) }}', 'Đã sao chép mật khẩu!')">
                                                <i class="fa-solid fa-clone"></i>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="order-security-alert mt-4">
                            <i class="fa-solid fa-shield-halved"></i>
                            <div>
                                <strong>Lưu ý bảo mật quan trọng:</strong> Vui lòng đăng nhập kiểm tra tài khoản và tiến hành đổi mật khẩu hoặc liên kết thông tin bảo mật của bạn ngay sau khi nhận để đảm bảo an toàn tuyệt đối!
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="{{ route('profile.purchased-random-accounts') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2" style="border-radius: 10px; font-weight: 700;">
                            <i class="fa-solid fa-list-ul"></i> Xem Tất Cả Đơn Hàng
                        </a>
                        <a href="{{ $backCategoryUrl }}" class="btn btn-danger d-inline-flex align-items-center gap-2" style="border-radius: 10px; font-weight: 700; background: var(--brand-gradient); border: none;">
                            <i class="fa-solid fa-cart-shopping"></i> Tiếp Tục Mua Sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function togglePassVisibility(index) {
        var box = document.getElementById('pass-val-' + index);
        var eye = document.getElementById('eye-icon-' + index);
        if (!box) return;
        var masked = box.querySelector('.pass-masked');
        var plain = box.querySelector('.pass-plain');
        if (masked && plain) {
            if (plain.classList.contains('d-none')) {
                plain.classList.remove('d-none');
                masked.classList.add('d-none');
                if (eye) {
                    eye.classList.remove('fa-eye');
                    eye.classList.add('fa-eye-slash');
                }
            } else {
                plain.classList.add('d-none');
                masked.classList.remove('d-none');
                if (eye) {
                    eye.classList.remove('fa-eye-slash');
                    eye.classList.add('fa-eye');
                }
            }
        }
    }

    function copyToClipboardText(text, successMsg) {
        if (!text) return;
        navigator.clipboard.writeText(text).then(() => {
            var msg = successMsg || "Đã sao chép vào khay nhớ tạm!";
            if (typeof FuiToast !== 'undefined') {
                FuiToast.success(msg);
            } else if (typeof toastr !== 'undefined') {
                toastr.success(msg);
            } else if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: msg,
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                alert(msg);
            }
        }).catch(err => {
            console.error('Lỗi sao chép:', err);
            if (typeof FuiToast !== 'undefined') {
                FuiToast.error("Trình duyệt không hỗ trợ sao chép tự động!");
            }
        });
    }

    function exportToTxt(content, filename) {
        try {
            const formattedContent = content.replace(/\\n/g, '\r\n');
            const blob = new Blob([formattedContent], { type: 'text/plain;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            var msg = "Đã xuất file " + filename;
            if (typeof FuiToast !== 'undefined') {
                FuiToast.success(msg);
            }
        } catch (err) {
            console.error('Lỗi khi xuất file:', err);
            if (typeof FuiToast !== 'undefined') {
                FuiToast.error("Có lỗi xảy ra khi xuất file TXT!");
            }
        }
    }
</script>
@endpush
@endsection
