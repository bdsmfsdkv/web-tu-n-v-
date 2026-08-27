@extends('layouts.user.app')

@section('title', $title ?? 'Tài khoản đã mua')

@section('content')
<section class="profile-section" style="padding-bottom: 90px; min-height: 80vh;">
    <div class="container">
        <div class="profile-container">
            <div class="profile-header mb-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h1 class="profile-title mb-1" style="font-size: 1.5rem; font-weight: 800;">
                            <i class="fa-solid fa-box-open text-danger me-2"></i> TÀI KHOẢN ĐÃ MUA
                        </h1>
                        <p class="text-muted small mb-0">Quản lý và xem lại thông tin các tài khoản game bạn đã mua</p>
                    </div>
                    <div class="balance-pill-badge">
                        <i class="fa-solid fa-wallet text-warning"></i>
                        <span>Số dư: <strong>{{ number_format($user->balance) }}đ</strong></span>
                    </div>
                </div>
            </div>

            <div class="profile-content">
                @include('layouts.user.sidebar')

                <div class="profile-main">
                    <style>
                        /* Modern Purchased Accounts Styles */
                        .balance-pill-badge {
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                            background: #f8fafc;
                            border: 1px solid #e2e8f0;
                            padding: 8px 16px;
                            border-radius: 30px;
                            font-size: 0.9rem;
                            color: #334155;
                        }
                        [data-theme="dark"] .balance-pill-badge {
                            background: #1e1e24;
                            border-color: rgba(255, 255, 255, 0.08);
                            color: #e2e8f0;
                        }

                        .purchased-acc-card {
                            background: #ffffff;
                            border: 1px solid #e2e8f0;
                            border-radius: 16px;
                            margin-bottom: 20px;
                            padding: 20px;
                            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
                            transition: var(--transition-smooth);
                        }
                        .purchased-acc-card:hover {
                            border-color: rgba(220, 38, 38, 0.3);
                            transform: translateY(-2px);
                            box-shadow: 0 8px 24px rgba(220, 38, 38, 0.08);
                        }
                        [data-theme="dark"] .purchased-acc-card {
                            background: #18181b;
                            border-color: rgba(255, 255, 255, 0.08);
                            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
                        }
                        [data-theme="dark"] .purchased-acc-card:hover {
                            border-color: rgba(239, 68, 68, 0.4);
                            background: #1e1e22;
                        }

                        /* Card Header */
                        .p-acc-header {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            flex-wrap: wrap;
                            gap: 10px;
                            padding-bottom: 14px;
                            border-bottom: 1px solid #f1f5f9;
                            margin-bottom: 16px;
                        }
                        [data-theme="dark"] .p-acc-header {
                            border-color: rgba(255, 255, 255, 0.06);
                        }

                        .p-acc-order-code {
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            font-weight: 800;
                            font-size: 0.95rem;
                            color: #0f172a;
                            background: #f1f5f9;
                            padding: 4px 12px;
                            border-radius: 8px;
                        }
                        [data-theme="dark"] .p-acc-order-code {
                            background: #27272a;
                            color: #f8fafc;
                        }

                        .p-acc-status-badge {
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            background: rgba(34, 197, 94, 0.12);
                            color: #16a34a;
                            border: 1px solid rgba(34, 197, 94, 0.3);
                            padding: 4px 12px;
                            border-radius: 20px;
                            font-size: 0.78rem;
                            font-weight: 800;
                            letter-spacing: 0.5px;
                        }
                        [data-theme="dark"] .p-acc-status-badge {
                            background: rgba(34, 197, 94, 0.18);
                            color: #4ade80;
                            border-color: rgba(74, 222, 128, 0.3);
                        }

                        /* Meta Grid */
                        .p-acc-meta-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                            gap: 10px;
                            margin-bottom: 16px;
                        }
                        .p-acc-meta-box {
                            background: #f8fafc;
                            border: 1px solid #f1f5f9;
                            border-radius: 10px;
                            padding: 10px 14px;
                        }
                        [data-theme="dark"] .p-acc-meta-box {
                            background: #27272a;
                            border-color: rgba(255, 255, 255, 0.05);
                        }
                        .p-acc-meta-label {
                            font-size: 0.72rem;
                            font-weight: 700;
                            color: #64748b;
                            text-transform: uppercase;
                            margin-bottom: 2px;
                        }
                        [data-theme="dark"] .p-acc-meta-label {
                            color: #a1a1aa;
                        }
                        .p-acc-meta-val {
                            font-size: 0.95rem;
                            font-weight: 800;
                            color: #0f172a;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                        [data-theme="dark"] .p-acc-meta-val {
                            color: #f8fafc;
                        }

                        /* Vault / Secret Credentials Box */
                        .p-acc-vault {
                            background: #ffffff;
                            border: 1px solid #e2e8f0;
                            border-radius: 12px;
                            padding: 14px;
                            margin-bottom: 14px;
                        }
                        [data-theme="dark"] .p-acc-vault {
                            background: #212124;
                            border-color: rgba(255, 255, 255, 0.06);
                        }

                        .p-acc-fields {
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 10px;
                        }
                        @media (max-width: 768px) {
                            .p-acc-fields {
                                grid-template-columns: 1fr;
                            }
                        }

                        .p-acc-field-item {
                            background: #f8fafc;
                            border: 1px solid #e2e8f0;
                            border-radius: 8px;
                            padding: 8px 12px;
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            gap: 8px;
                        }
                        [data-theme="dark"] .p-acc-field-item {
                            background: #18181b;
                            border-color: rgba(255, 255, 255, 0.08);
                        }

                        .p-acc-field-text {
                            font-family: 'Consolas', 'Courier New', monospace;
                            font-size: 0.92rem;
                            font-weight: 700;
                            color: #0f172a;
                            word-break: break-all;
                        }
                        [data-theme="dark"] .p-acc-field-text {
                            color: #f8fafc;
                        }

                        .btn-acc-action {
                            background: #f1f5f9;
                            color: #475569;
                            border: 1px solid #e2e8f0;
                            width: 30px;
                            height: 30px;
                            border-radius: 6px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            cursor: pointer;
                            transition: var(--transition-smooth);
                            flex-shrink: 0;
                            font-size: 0.85rem;
                        }
                        .btn-acc-action:hover {
                            background: var(--primary);
                            color: #ffffff;
                            border-color: var(--primary);
                        }
                        [data-theme="dark"] .btn-acc-action {
                            background: #27272a;
                            border-color: rgba(255, 255, 255, 0.08);
                            color: #a1a1aa;
                        }
                        [data-theme="dark"] .btn-acc-action:hover {
                            background: var(--primary);
                            color: #ffffff;
                            border-color: var(--primary);
                        }

                        /* Footer Actions */
                        .p-acc-footer {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            flex-wrap: wrap;
                            gap: 8px;
                            padding-top: 10px;
                        }

                        .p-acc-warning {
                            font-size: 0.8rem;
                            color: #d97706;
                            display: flex;
                            align-items: center;
                            gap: 5px;
                            font-weight: 600;
                        }
                        [data-theme="dark"] .p-acc-warning {
                            color: #fde047;
                        }

                        .btn-copy-pair {
                            background: var(--brand-gradient);
                            color: #ffffff;
                            border: none;
                            padding: 6px 14px;
                            border-radius: 8px;
                            font-size: 0.8rem;
                            font-weight: 700;
                            cursor: pointer;
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            transition: var(--transition-smooth);
                        }
                        .btn-copy-pair:hover {
                            opacity: 0.95;
                            transform: translateY(-1px);
                            color: #ffffff;
                            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
                        }

                        .btn-detail-link {
                            background: #f1f5f9;
                            color: #334155;
                            border: 1px solid #e2e8f0;
                            padding: 6px 14px;
                            border-radius: 8px;
                            font-size: 0.8rem;
                            font-weight: 700;
                            text-decoration: none;
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            transition: var(--transition-smooth);
                        }
                        .btn-detail-link:hover {
                            background: #e2e8f0;
                            color: #0f172a;
                        }
                        [data-theme="dark"] .btn-detail-link {
                            background: #27272a;
                            border-color: rgba(255, 255, 255, 0.08);
                            color: #f8fafc;
                        }
                        [data-theme="dark"] .btn-detail-link:hover {
                            background: #3f3f46;
                        }

                        /* Empty State */
                        .empty-state-card {
                            background: #ffffff;
                            border: 1px solid #e2e8f0;
                            border-radius: 16px;
                            padding: 60px 24px;
                            text-align: center;
                        }
                        [data-theme="dark"] .empty-state-card {
                            background: #18181b;
                            border-color: rgba(255, 255, 255, 0.08);
                        }
                        .empty-state-icon {
                            width: 80px;
                            height: 80px;
                            border-radius: 50%;
                            background: rgba(220, 38, 38, 0.08);
                            color: var(--primary);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 2.2rem;
                            margin: 0 auto 16px;
                        }
                    </style>

                    <div class="transaction-history">
                        @if (session('error'))
                            <div class="alert alert-danger mb-3">
                                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success mb-3">
                                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                            </div>
                        @endif

                        @forelse($transactions as $index => $transaction)
                            <div class="purchased-acc-card">
                                <!-- Card Header -->
                                <div class="p-acc-header">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="p-acc-order-code">
                                            <i class="fa-solid fa-receipt text-danger"></i> #{{ $transaction->order_code ?? ('ORD-' . $transaction->id) }}
                                        </span>
                                        <span class="text-muted small">
                                            <i class="fa-regular fa-clock me-1"></i> {{ ($transaction->purchased_at ?? $transaction->created_at)->format('H:i d/m/Y') }}
                                        </span>
                                    </div>
                                    <div class="p-acc-status-badge">
                                        <i class="fa-solid fa-circle-check"></i> HOÀN TẤT
                                    </div>
                                </div>

                                <!-- Meta Grid -->
                                <div class="p-acc-meta-grid">
                                    <div class="p-acc-meta-box">
                                        <div class="p-acc-meta-label">Danh mục</div>
                                        <div class="p-acc-meta-val" title="{{ $transaction->category_name ?? ($transaction->category->name ?? 'Tài khoản Game') }}">
                                            {{ $transaction->category_name ?? ($transaction->category->name ?? 'Tài khoản Game') }}
                                        </div>
                                    </div>

                                    <div class="p-acc-meta-box">
                                        <div class="p-acc-meta-label">Số lượng</div>
                                        <div class="p-acc-meta-val">1 Tài khoản</div>
                                    </div>

                                    <div class="p-acc-meta-box">
                                        <div class="p-acc-meta-label">Giá mua</div>
                                        <div class="p-acc-meta-val text-danger" style="color: #ef4444 !important;">
                                            {{ number_format($transaction->price) }}đ
                                        </div>
                                    </div>

                                    <div class="p-acc-meta-box">
                                        <div class="p-acc-meta-label">Thời gian</div>
                                        <div class="p-acc-meta-val">
                                            {{ ($transaction->purchased_at ?? $transaction->created_at)->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Secret Credentials Vault -->
                                <div class="p-acc-vault">
                                    <div class="p-acc-fields">
                                        <!-- Username -->
                                        <div class="p-acc-field-item">
                                            <div style="flex: 1; min-width: 0;">
                                                <div class="text-muted small" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">
                                                    <i class="fa-solid fa-user me-1"></i> Tài khoản
                                                </div>
                                                <div class="p-acc-field-text">{{ $transaction->account_name }}</div>
                                            </div>
                                            <button type="button" class="btn-acc-action" title="Sao chép tài khoản" onclick="copyToClipboardText('{{ addslashes($transaction->account_name) }}', 'Đã sao chép tài khoản!')">
                                                <i class="fa-solid fa-clone"></i>
                                            </button>
                                        </div>

                                        <!-- Password -->
                                        <div class="p-acc-field-item">
                                            <div style="flex: 1; min-width: 0;" id="p-acc-pass-box-{{ $index }}">
                                                <div class="text-muted small" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">
                                                    <i class="fa-solid fa-lock me-1"></i> Mật khẩu
                                                </div>
                                                <div class="p-acc-field-text">
                                                    @if($transaction->password)
                                                        <span class="pass-masked">••••••••</span>
                                                        <span class="pass-plain d-none">{{ $transaction->password }}</span>
                                                    @else
                                                        <span class="text-muted small">Không có mật khẩu</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($transaction->password)
                                            <div class="d-flex gap-1">
                                                <button type="button" class="btn-acc-action" title="Hiện/Ẩn mật khẩu" onclick="togglePassSingle({{ $index }})">
                                                    <i class="fa-solid fa-eye" id="p-eye-{{ $index }}"></i>
                                                </button>
                                                <button type="button" class="btn-acc-action" title="Sao chép mật khẩu" onclick="copyToClipboardText('{{ addslashes($transaction->password) }}', 'Đã sao chép mật khẩu!')">
                                                    <i class="fa-solid fa-clone"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="p-acc-footer">
                                    <div class="p-acc-warning">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <span>Đổi mật khẩu ngay sau khi nhận nick!</span>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button type="button" class="btn-copy-pair" onclick="copyToClipboardText('{{ addslashes($transaction->account_name . "|" . $transaction->password) }}', 'Đã copy TK|MK!')">
                                            <i class="fa-solid fa-copy"></i> Copy Cả Cặp
                                        </button>
                                        <button type="button" class="btn-detail-link" onclick="exportToTxt('{{ addslashes($transaction->account_name . "|" . $transaction->password) }}', 'don_hang_{{ $transaction->id }}.txt')">
                                            <i class="fa-solid fa-download"></i> File TXT
                                        </button>
                                        <a href="{{ route('profile.purchased-account-detail', ['id' => $transaction->id]) }}" class="btn-detail-link">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state-card">
                                <div class="empty-state-icon">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                                <h4 class="fw-bold mb-2">Chưa có tài khoản nào</h4>
                                <p class="text-muted small mb-4">Bạn chưa mua bất kỳ tài khoản game nào trên hệ thống.</p>
                                <a href="{{ route('home') }}" class="btn btn-danger px-4 py-2" style="border-radius: 10px; font-weight: 700; background: var(--brand-gradient); border: none;">
                                    <i class="fa-solid fa-cart-plus me-1"></i> Khám Phá Shop Ngay
                                </a>
                            </div>
                        @endforelse

                        <div class="pagination mt-4">
                            {{ $transactions->links('user.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function togglePassSingle(index) {
        var box = document.getElementById('p-acc-pass-box-' + index);
        var eye = document.getElementById('p-eye-' + index);
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
