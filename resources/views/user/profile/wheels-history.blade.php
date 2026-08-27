@extends('layouts.user.app')

@section('title', $title ?? 'Lịch sử vận may')

@section('content')
<section class="profile-section" style="padding-bottom: 90px; min-height: 80vh;">
    <div class="container">
        <div class="profile-container">
            <div class="profile-header mb-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h1 class="profile-title mb-1" style="font-size: 1.4rem; font-weight: 800; letter-spacing: -0.3px;">
                            <i class="fa-solid fa-clock-rotate-left text-danger me-2"></i> LỊCH SỬ VẬN MAY
                        </h1>
                        <p class="text-muted small mb-0">Xem lại toàn bộ lượt quay và phần thưởng bạn đã nhận</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="stat-badge-light">
                            <span class="stat-badge-dot"></span>
                            <span class="stat-label">Tổng quay:</span>
                            <span class="stat-val text-primary">{{ number_format($wheelHistories->total() ?? $wheelHistories->count()) }} lượt</span>
                        </div>
                        <div class="stat-badge-light">
                            <span class="stat-label">Số dư ví:</span>
                            <span class="stat-val text-danger">{{ number_format($user->balance) }}đ</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-content">
                @include('layouts.user.sidebar')

                <div class="profile-main">
                    <style>
                        /* Lightweight Header Stats */
                        .stat-badge-light {
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            background: #ffffff;
                            border: 1px solid #e5e7eb;
                            padding: 6px 14px;
                            border-radius: 20px;
                            font-size: 0.82rem;
                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
                        }
                        [data-theme="dark"] .stat-badge-light {
                            background: #1e1e24;
                            border-color: rgba(255, 255, 255, 0.08);
                        }
                        .stat-badge-dot {
                            width: 6px;
                            height: 6px;
                            border-radius: 50%;
                            background: #22c55e;
                            display: inline-block;
                        }
                        .stat-label {
                            color: #64748b;
                            font-weight: 600;
                        }
                        [data-theme="dark"] .stat-label {
                            color: #a1a1aa;
                        }
                        .stat-val {
                            font-weight: 800;
                        }

                        /* Lightweight Wheel History Cards */
                        .wheel-history-card {
                            background: #ffffff;
                            border: 1px solid #eef2f6;
                            border-radius: 12px;
                            padding: 14px 18px;
                            margin-bottom: 10px;
                            transition: var(--transition-smooth);
                        }
                        .wheel-history-card:hover {
                            border-color: rgba(220, 38, 38, 0.25);
                            background: #fafafa;
                            transform: translateY(-1px);
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
                        }
                        [data-theme="dark"] .wheel-history-card {
                            background: #18181b;
                            border-color: rgba(255, 255, 255, 0.06);
                        }
                        [data-theme="dark"] .wheel-history-card:hover {
                            background: #1e1e22;
                            border-color: rgba(239, 68, 68, 0.3);
                        }

                        .wheel-card-grid {
                            display: grid;
                            grid-template-columns: 2fr 1fr 1.8fr auto;
                            align-items: center;
                            gap: 16px;
                        }
                        @media (max-width: 768px) {
                            .wheel-card-grid {
                                grid-template-columns: 1fr;
                                gap: 10px;
                            }
                        }

                        .wheel-info-box {
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            min-width: 0;
                        }
                        .wheel-icon-wrap {
                            width: 38px;
                            height: 38px;
                            border-radius: 10px;
                            background: rgba(220, 38, 38, 0.08);
                            color: var(--primary);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 1rem;
                            flex-shrink: 0;
                        }
                        [data-theme="dark"] .wheel-icon-wrap {
                            background: rgba(239, 68, 68, 0.12);
                            color: #f87171;
                        }

                        .wheel-title-text {
                            font-weight: 750;
                            font-size: 0.92rem;
                            color: #1e293b;
                            line-height: 1.3;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                        [data-theme="dark"] .wheel-title-text {
                            color: #f8fafc;
                        }
                        .wheel-time-text {
                            font-size: 0.76rem;
                            color: #94a3b8;
                            margin-top: 2px;
                            display: flex;
                            align-items: center;
                            gap: 6px;
                            flex-wrap: wrap;
                        }

                        .wheel-spin-tag {
                            background: #f1f5f9;
                            color: #475569;
                            padding: 1px 7px;
                            border-radius: 4px;
                            font-size: 0.7rem;
                            font-weight: 700;
                        }
                        [data-theme="dark"] .wheel-spin-tag {
                            background: #27272a;
                            color: #cbd5e1;
                        }

                        .wheel-cost-text {
                            font-weight: 750;
                            font-size: 0.92rem;
                            color: #ef4444;
                        }

                        .wheel-reward-pill {
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            padding: 5px 12px;
                            border-radius: 20px;
                            font-size: 0.82rem;
                            font-weight: 700;
                            max-width: 100%;
                            word-break: break-word;
                        }
                        .reward-gold {
                            background: rgba(234, 179, 8, 0.1);
                            color: #b45309;
                            border: 1px solid rgba(234, 179, 8, 0.2);
                        }
                        .reward-money {
                            background: rgba(34, 197, 94, 0.1);
                            color: #15803d;
                            border: 1px solid rgba(34, 197, 94, 0.2);
                        }
                        .reward-empty {
                            background: #f1f5f9;
                            color: #64748b;
                            border: 1px solid #e2e8f0;
                        }
                        .reward-special {
                            background: rgba(168, 85, 247, 0.1);
                            color: #7e22ce;
                            border: 1px solid rgba(168, 85, 247, 0.2);
                        }
                        [data-theme="dark"] .reward-gold { background: rgba(234, 179, 8, 0.15); color: #fde047; border-color: rgba(234, 179, 8, 0.25); }
                        [data-theme="dark"] .reward-money { background: rgba(34, 197, 94, 0.15); color: #86efac; border-color: rgba(34, 197, 94, 0.25); }
                        [data-theme="dark"] .reward-empty { background: #27272a; color: #94a3b8; border-color: rgba(255, 255, 255, 0.08); }
                        [data-theme="dark"] .reward-special { background: rgba(168, 85, 247, 0.15); color: #d8b4fe; border-color: rgba(168, 85, 247, 0.25); }

                        .btn-wheel-detail {
                            background: #ffffff;
                            color: #475569;
                            border: 1px solid #e2e8f0;
                            padding: 5px 12px;
                            border-radius: 8px;
                            font-size: 0.78rem;
                            font-weight: 700;
                            cursor: pointer;
                            display: inline-flex;
                            align-items: center;
                            gap: 5px;
                            transition: var(--transition-smooth);
                        }
                        .btn-wheel-detail:hover {
                            background: var(--primary);
                            color: #ffffff;
                            border-color: var(--primary);
                            transform: translateY(-1px);
                        }
                        [data-theme="dark"] .btn-wheel-detail {
                            background: #27272a;
                            border-color: rgba(255, 255, 255, 0.08);
                            color: #cbd5e1;
                        }
                        [data-theme="dark"] .btn-wheel-detail:hover {
                            background: var(--primary);
                            color: #ffffff;
                            border-color: var(--primary);
                        }

                        /* Modal */
                        .modal {
                            position: fixed;
                            z-index: 1050;
                            inset: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(15, 23, 42, 0.6);
                            backdrop-filter: blur(4px);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            opacity: 0;
                            visibility: hidden;
                            pointer-events: none;
                            transition: opacity 0.2s ease, visibility 0.2s ease;
                        }
                        .modal.active, .modal.show {
                            opacity: 1;
                            visibility: visible;
                            pointer-events: auto;
                        }
                        .modal__content {
                            background: #ffffff;
                            margin: auto;
                            width: 92%;
                            max-width: 440px;
                            border-radius: 14px;
                            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.15);
                            overflow: hidden;
                            transform: scale(0.95) translateY(8px);
                            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
                            border: 1px solid #e2e8f0;
                        }
                        .modal.active .modal__content {
                            transform: scale(1) translateY(0);
                        }
                        [data-theme="dark"] .modal__content {
                            background: #18181b;
                            border-color: rgba(255, 255, 255, 0.1);
                        }

                        .modal__header {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            padding: 16px 20px;
                            border-bottom: 1px solid #f1f5f9;
                            background: #f8fafc;
                        }
                        [data-theme="dark"] .modal__header {
                            background: #212124;
                            border-color: rgba(255, 255, 255, 0.06);
                        }
                        .modal__title {
                            margin: 0;
                            font-size: 1.05rem;
                            font-weight: 800;
                            color: #0f172a;
                            display: flex;
                            align-items: center;
                            gap: 8px;
                        }
                        [data-theme="dark"] .modal__title {
                            color: #f8fafc;
                        }
                        .modal__close {
                            background: none;
                            border: none;
                            font-size: 1.5rem;
                            color: #94a3b8;
                            cursor: pointer;
                            line-height: 1;
                            padding: 0;
                            transition: color 0.2s;
                        }
                        .modal__close:hover {
                            color: #ef4444;
                        }

                        .modal__body {
                            padding: 20px;
                        }
                        .modal-detail-box {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            padding: 10px 12px;
                            background: #f8fafc;
                            border: 1px solid #f1f5f9;
                            border-radius: 8px;
                            margin-bottom: 8px;
                        }
                        [data-theme="dark"] .modal-detail-box {
                            background: #212124;
                            border-color: rgba(255, 255, 255, 0.05);
                        }
                        .modal-detail-label {
                            font-size: 0.8rem;
                            font-weight: 600;
                            color: #64748b;
                            display: flex;
                            align-items: center;
                            gap: 6px;
                        }
                        [data-theme="dark"] .modal-detail-label {
                            color: #a1a1aa;
                        }
                        .modal-detail-val {
                            font-size: 0.9rem;
                            font-weight: 800;
                            color: #0f172a;
                        }
                        [data-theme="dark"] .modal-detail-val {
                            color: #f8fafc;
                        }

                        .modal__footer {
                            padding: 12px 20px;
                            border-top: 1px solid #f1f5f9;
                            background: #f8fafc;
                            text-align: right;
                        }
                        [data-theme="dark"] .modal__footer {
                            background: #212124;
                            border-color: rgba(255, 255, 255, 0.06);
                        }

                        /* Empty State */
                        .empty-wheel-box {
                            text-align: center;
                            padding: 48px 20px;
                            background: #ffffff;
                            border: 1px solid #eef2f6;
                            border-radius: 12px;
                        }
                        [data-theme="dark"] .empty-wheel-box {
                            background: #18181b;
                            border-color: rgba(255, 255, 255, 0.06);
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

                        @forelse($wheelHistories as $history)
                            <div class="wheel-history-card">
                                <div class="wheel-card-grid">
                                    <!-- Wheel Info + Time + Spin tag -->
                                    <div class="wheel-info-box">
                                        <div class="wheel-icon-wrap">
                                            <i class="fa-solid fa-dharmachakra"></i>
                                        </div>
                                        <div style="min-width: 0;">
                                            <div class="wheel-title-text" title="{{ $history->luckyWheel->name ?? 'Vòng quay may mắn' }}">
                                                {{ $history->luckyWheel->name ?? 'Vòng quay may mắn' }}
                                            </div>
                                            <div class="wheel-time-text">
                                                <span><i class="fa-regular fa-clock me-1"></i>{{ $history->created_at->format('H:i - d/m/Y') }}</span>
                                                <span class="wheel-spin-tag">{{ $history->spin_count }} lượt</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cost -->
                                    <div>
                                        <span class="wheel-cost-text">-{{ number_format($history->total_cost) }}đ</span>
                                    </div>

                                    <!-- Reward -->
                                    <div>
                                        @php
                                            $rt = $history->reward_type;
                                            $desc = $history->description ?: 'Chúc bạn may mắn lần sau';
                                            $rewardClass = 'reward-special';
                                            $rewardIcon = 'fa-gift';
                                            if ($rt === 'gold' || str_contains(strtolower($desc), 'vàng') || str_contains(strtolower($desc), 'kc') || str_contains(strtolower($desc), 'kim cương') || str_contains(strtolower($desc), 'ngọc')) {
                                                $rewardClass = 'reward-special';
                                                $rewardIcon = 'fa-gem';
                                            } elseif ($rt === 'money' || str_contains(strtolower($desc), 'vnđ') || str_contains(strtolower($desc), 'đ')) {
                                                $rewardClass = 'reward-money';
                                                $rewardIcon = 'fa-coins';
                                            } elseif ($rt === 'empty' || str_contains(strtolower($desc), 'may mắn')) {
                                                $rewardClass = 'reward-empty';
                                                $rewardIcon = 'fa-face-smile';
                                            }
                                        @endphp
                                        <span class="wheel-reward-pill {{ $rewardClass }}">
                                            <i class="fa-solid {{ $rewardIcon }}"></i> {{ $desc }}
                                        </span>
                                    </div>

                                    <!-- Action -->
                                    <div class="text-end">
                                        <button type="button" class="btn-wheel-detail view-details" data-id="{{ $history->id }}">
                                            <i class="fa-solid fa-eye"></i> <span>Chi tiết</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-wheel-box">
                                <i class="fa-solid fa-dharmachakra text-muted mb-3" style="font-size: 2.5rem;"></i>
                                <h5 class="fw-bold mb-1">Chưa có lượt quay nào</h5>
                                <p class="text-muted small mb-3">Bạn chưa tham gia quay vòng quay may mắn nào trên hệ thống.</p>
                                <a href="{{ route('home') }}" class="btn btn-sm btn-danger px-3 py-2" style="border-radius: 8px; font-weight: 700; background: var(--brand-gradient); border: none;">
                                    <i class="fa-solid fa-play me-1"></i> Thử Vận May Ngay
                                </a>
                            </div>
                        @endforelse

                        <div class="pagination mt-3">
                            {{ $wheelHistories->links('user.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Wheel Details Modal -->
<div id="wheelDetailsModal" class="modal">
    <div class="modal__content">
        <div class="modal__header">
            <h2 class="modal__title">
                <i class="fa-solid fa-dharmachakra text-danger"></i> Chi tiết lượt quay #<span id="wheel-id"></span>
            </h2>
            <button type="button" class="modal__close" onclick="closeWheelModal()">&times;</button>
        </div>

        <div class="modal__body">
            <div id="wheel-modal-loading" class="text-center py-4">
                <div class="spinner-border text-danger" role="status">
                    <span class="visually-hidden">Đang tải...</span>
                </div>
                <p class="mt-2 text-muted small">Đang tải thông tin phần thưởng...</p>
            </div>

            <div id="wheel-modal-content" style="display: none;">
                <div class="modal-detail-box">
                    <span class="modal-detail-label"><i class="fa-regular fa-calendar-check text-primary"></i> Thời gian:</span>
                    <span class="modal-detail-val" id="wheel-time"></span>
                </div>
                <div class="modal-detail-box">
                    <span class="modal-detail-label"><i class="fa-solid fa-dharmachakra text-danger"></i> Vòng quay:</span>
                    <span class="modal-detail-val" id="wheel-name"></span>
                </div>
                <div class="modal-detail-box">
                    <span class="modal-detail-label"><i class="fa-solid fa-rotate text-info"></i> Lượt quay:</span>
                    <span class="modal-detail-val" id="wheel-spin-count"></span>
                </div>
                <div class="modal-detail-box">
                    <span class="modal-detail-label"><i class="fa-solid fa-receipt text-warning"></i> Chi phí:</span>
                    <span class="modal-detail-val text-danger" id="wheel-cost" style="color: #ef4444 !important;"></span>
                </div>
                <div class="modal-detail-box">
                    <span class="modal-detail-label"><i class="fa-solid fa-gift text-success"></i> Phần thưởng:</span>
                    <span class="modal-detail-val text-success" id="wheel-reward" style="color: #16a34a !important;"></span>
                </div>
            </div>

            <div id="wheel-modal-error" class="alert alert-danger" style="display: none;">
                <i class="fa-solid fa-circle-exclamation me-2"></i> <span id="wheel-error-message"></span>
            </div>
        </div>

        <div class="modal__footer">
            <button type="button" class="btn btn-sm btn-secondary px-3" style="border-radius: 6px; font-weight: 700;" onclick="closeWheelModal()">ĐÓNG</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                const wheelId = this.getAttribute('data-id');
                document.getElementById('wheel-id').textContent = wheelId;
                document.getElementById('wheel-modal-loading').style.display = 'block';
                document.getElementById('wheel-modal-content').style.display = 'none';
                document.getElementById('wheel-modal-error').style.display = 'none';
                openWheelModal();

                fetch(`/profile/wheel-history/${wheelId}`)
                    .then(r => r.json())
                    .then(data => {
                        document.getElementById('wheel-modal-loading').style.display = 'none';
                        if (data.status === 'success') {
                            document.getElementById('wheel-time').textContent = new Date(data.created_at).toLocaleString('vi-VN');
                            document.getElementById('wheel-name').textContent = data.lucky_wheel ? data.lucky_wheel.name : 'Vòng quay may mắn';
                            document.getElementById('wheel-spin-count').textContent = data.spin_count + ' lượt';
                            document.getElementById('wheel-cost').textContent = '-' + new Intl.NumberFormat('vi-VN').format(data.total_cost) + 'đ';
                            document.getElementById('wheel-reward').textContent = data.description || '—';
                            document.getElementById('wheel-modal-content').style.display = 'block';
                        } else {
                            document.getElementById('wheel-error-message').textContent = data.message || 'Đã xảy ra lỗi';
                            document.getElementById('wheel-modal-error').style.display = 'block';
                        }
                    })
                    .catch(() => {
                        document.getElementById('wheel-modal-loading').style.display = 'none';
                        document.getElementById('wheel-error-message').textContent = 'Lỗi kết nối, vui lòng thử lại';
                        document.getElementById('wheel-modal-error').style.display = 'block';
                    });
            });
        });
    });

    function openWheelModal() {
        document.getElementById('wheelDetailsModal').classList.add('active');
    }

    function closeWheelModal() {
        document.getElementById('wheelDetailsModal').classList.remove('active');
    }

    document.getElementById('wheelDetailsModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeWheelModal();
    });
</script>
@endpush
