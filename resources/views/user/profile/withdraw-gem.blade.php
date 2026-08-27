@extends('layouts.user.app')

@section('title', $title)

@push('css')
<style>
    /* Item Selector Grid */
    .gem-items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 10px;
        margin-bottom: 20px;
        width: 100%;
        box-sizing: border-box;
    }

    .gem-item-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 120px;
        box-sizing: border-box;
        min-width: 0;
        width: 100%;
    }

    .gem-item-card:hover {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.04);
        transform: translateY(-2px);
    }

    .gem-item-card.active {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.08);
        box-shadow: 0 0 0 1px #3b82f6;
    }

    .gem-check-badge {
        display: none;
        position: absolute;
        top: 6px;
        right: 6px;
        background: #3b82f6;
        color: #ffffff;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        font-size: 0.65rem;
        align-items: center;
        justify-content: center;
    }

    .gem-item-card.active .gem-check-badge {
        display: flex;
    }

    .gem-item-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        flex-shrink: 0;
    }

    .gem-item-icon-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .gem-item-icon-box i {
        font-size: 1.4rem;
    }

    .gem-item-name {
        font-size: 0.76rem;
        font-weight: 700;
        color: #1e293b;
        text-transform: uppercase;
        margin-bottom: 4px;
        width: 100%;
        line-height: 1.25;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
    }

    .gem-item-balance {
        font-size: 0.95rem;
        font-weight: 800;
        color: #3b82f6;
    }

    /* Form & Placeholder */
    .gem-form-placeholder {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 24px 16px;
        text-align: center;
        color: #64748b;
        font-size: 0.88rem;
        font-weight: 600;
        background: #f8fafc;
        margin-bottom: 20px;
    }

    .gem-withdraw-form {
        display: none;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 16px;
        margin-bottom: 24px;
    }

    .gem-notes-card {
        background: rgba(59, 130, 246, 0.04);
        border: 1px solid rgba(59, 130, 246, 0.15);
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 18px;
    }

    .gem-notes-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1d4ed8;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .gem-notes-list {
        margin: 0;
        padding-left: 18px;
        color: #475569;
        font-size: 0.82rem;
        line-height: 1.6;
    }

    /* History Table Desktop */
    .history-table-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 10px;
    }

    .history-table {
        width: 100%;
        min-width: 660px;
        border-collapse: collapse;
        text-align: left;
    }

    .history-table th {
        background: rgba(59, 130, 246, 0.06);
        padding: 12px 14px;
        font-size: 0.78rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
        border-bottom: 1px solid #e2e8f0;
    }

    .history-table td {
        padding: 12px 14px;
        font-size: 0.85rem;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        vertical-align: middle;
    }

    .history-table tr:last-child td {
        border-bottom: none;
    }

    .history-table tbody tr:hover {
        background: rgba(59, 130, 246, 0.02);
    }

    .history-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-processing {
        background: rgba(234, 179, 8, 0.12);
        color: #b45309;
        border: 1px solid rgba(234, 179, 8, 0.28);
    }

    .status-success {
        background: rgba(16, 185, 129, 0.12);
        color: #047857;
        border: 1px solid rgba(16, 185, 129, 0.28);
    }

    .status-cancelled, .status-error {
        background: rgba(239, 68, 68, 0.12);
        color: #b91c1c;
        border: 1px solid rgba(239, 68, 68, 0.28);
    }

    /* Mobile History Cards (Only on Mobile) */
    .mobile-history-list {
        display: none;
        flex-direction: column;
        gap: 10px;
    }

    .mobile-history-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .mhc-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px dashed #e2e8f0;
        padding-bottom: 6px;
    }

    .mhc-time {
        font-size: 0.75rem;
        color: #64748b;
    }

    .mhc-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px 12px;
        font-size: 0.82rem;
    }

    .mhc-row-full {
        grid-column: 1 / -1;
    }

    .mhc-label {
        color: #64748b;
        font-size: 0.75rem;
    }

    .mhc-val {
        font-weight: 600;
        color: #1e293b;
    }

    .mhc-val.highlight {
        color: #3b82f6;
        font-weight: 800;
    }

    /* Responsive Breakdown */
    @media (max-width: 768px) {
        .gem-items-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .gem-item-card {
            padding: 10px 6px;
            min-height: 110px;
        }

        .gem-item-name {
            font-size: 0.72rem;
        }

        .gem-item-balance {
            font-size: 0.88rem;
        }

        .gem-withdraw-form {
            padding: 14px;
            border-radius: 12px;
        }

        /* Show mobile cards, hide table on mobile */
        .history-table-container {
            display: none;
        }

        .mobile-history-list {
            display: flex;
        }
    }

    /* Dark Mode */
    [data-theme="dark"] .gem-item-card {
        background: #171717;
        border-color: #2a2a2a;
    }

    [data-theme="dark"] .gem-item-name {
        color: #f1f5f9;
    }

    [data-theme="dark"] .gem-item-card:hover {
        background: rgba(59, 130, 246, 0.12);
        border-color: #3b82f6;
    }

    [data-theme="dark"] .gem-item-card.active {
        background: rgba(59, 130, 246, 0.18);
        border-color: #3b82f6;
    }

    [data-theme="dark"] .gem-form-placeholder {
        background: #171717;
        border-color: #2a2a2a;
        color: #94a3b8;
    }

    [data-theme="dark"] .gem-withdraw-form {
        background: #171717;
        border-color: #2a2a2a;
    }

    [data-theme="dark"] .gem-notes-card {
        background: rgba(59, 130, 246, 0.08);
        border-color: rgba(59, 130, 246, 0.2);
    }

    [data-theme="dark"] .gem-notes-title {
        color: #60a5fa;
    }

    [data-theme="dark"] .gem-notes-list {
        color: #cbd5e1;
    }

    [data-theme="dark"] .history-table th {
        background: rgba(59, 130, 246, 0.1);
        color: #94a3b8;
        border-bottom-color: #2a2a2a;
    }

    [data-theme="dark"] .history-table td {
        color: #f1f5f9;
        border-bottom-color: #2a2a2a;
    }

    [data-theme="dark"] .history-table tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    [data-theme="dark"] .mobile-history-card {
        background: #171717;
        border-color: #2a2a2a;
    }

    [data-theme="dark"] .mhc-top {
        border-bottom-color: #2a2a2a;
    }

    [data-theme="dark"] .mhc-val {
        color: #f1f5f9;
    }

    [data-theme="dark"] .mhc-label {
        color: #94a3b8;
    }
</style>
@endpush

@section('content')
    <section class="profile-section" style="padding-bottom: 90px;">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-gem me-2"></i> RÚT VẬT PHẨM</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <!-- Card 1: Tạo yêu cầu rút -->
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label">
                                        <i class="fa-solid fa-coins me-2" style="color: #3b82f6;"></i> TẠO YÊU CẦU RÚT VẬT PHẨM
                                    </span>
                                </div>
                            </div>

                            <div class="info-content" style="padding: 16px;">
                                @if (session('error'))
                                    <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px; font-size: 0.88rem;">
                                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px; font-size: 0.88rem;">
                                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Hướng dẫn & Lưu ý -->
                                <div class="gem-notes-card">
                                    <div class="gem-notes-title">
                                        <i class="fa-solid fa-circle-info"></i> HƯỚNG DẪN & LƯU Ý KHI RÚT
                                    </div>
                                    <ul class="gem-notes-list">
                                        <li>Chọn một loại vật phẩm hoặc CC bạn muốn rút trong danh sách bên dưới.</li>
                                        <li>Điền <strong>chính xác Tên nhân vật hoặc ID Game</strong> để Admin duyệt gửi vật phẩm trong <strong>1 - 24 giờ</strong>.</li>
                                    </ul>
                                </div>

                                <!-- Chọn vật phẩm Grid -->
                                <div style="font-weight: 700; font-size: 0.88rem; margin-bottom: 10px; color: var(--text-main, #1e293b);">
                                    <i class="fa-solid fa-hand-pointer me-1" style="color: #3b82f6;"></i> CHỌN VẬT PHẨM CẦN RÚT:
                                </div>

                                <div class="gem-items-grid">
                                    <!-- CC Card -->
                                    <div class="gem-item-card" onclick='selectGemItem({{ $gemBalance }})' id="item-card-gem">
                                        <div class="gem-check-badge"><i class="fa-solid fa-check"></i></div>
                                        <div class="gem-item-icon-box" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                                            <i class="fa-solid fa-gem"></i>
                                        </div>
                                        <div class="gem-item-name">CC</div>
                                        <div class="gem-item-balance">{{ number_format($gemBalance) }}</div>
                                    </div>

                                    <!-- Reward Items từ vòng quay -->
                                    @foreach($rewardItems as $item)
                                        <div class="gem-item-card" onclick='selectItem({{ $item->id }}, @json($item->name), {{ $item->available_amount }}, {{ $item->min_withdraw }}, {{ $item->max_withdraw }})' id="item-card-{{ $item->id }}">
                                            <div class="gem-check-badge"><i class="fa-solid fa-check"></i></div>
                                            <div class="gem-item-icon-box" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                                                @if($item->icon)
                                                    <img src="{{ asset($item->icon) }}" alt="{{ $item->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <i class="fa-solid fa-gift" style="display: none;"></i>
                                                @else
                                                    <i class="fa-solid fa-gift"></i>
                                                @endif
                                            </div>
                                            <div class="gem-item-name" title="{{ $item->name }}">{{ $item->name }}</div>
                                            <div class="gem-item-balance">{{ number_format($item->available_amount) }}</div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Placeholder khi chưa chọn -->
                                <div class="gem-form-placeholder" id="form-placeholder">
                                    <i class="fa-regular fa-hand-pointer me-1" style="color: #3b82f6;"></i> Nhấn vào một vật phẩm ở trên để điền thông tin rút
                                </div>

                                <!-- Form rút vật phẩm -->
                                <div class="gem-withdraw-form" id="withdraw-form">
                                    <form action="{{ route('profile.withdraw-gem') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="reward_item_id" id="reward_item_id">

                                        <div class="form-group mb-3">
                                            <label class="form-label" id="withdraw-amount-label" style="font-weight: 600; font-size: 0.86rem; margin-bottom: 5px;">
                                                <i class="fa-solid fa-coins me-1" style="color: #3b82f6;"></i> Số lượng muốn rút:
                                            </label>
                                            <input type="number" class="form-control" name="amount" id="amount" min="1" required placeholder="Nhập số lượng cần rút" style="border-radius: 8px; font-size: 0.9rem; padding: 10px 14px;">
                                            <small style="color: #64748b; display: block; margin-top: 4px; font-size: 0.78rem;" id="withdraw-limit-text"></small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" style="font-weight: 600; font-size: 0.86rem; margin-bottom: 5px;">
                                                <i class="fa-solid fa-user me-1" style="color: #3b82f6;"></i> Tên nhân vật / ID Game:
                                            </label>
                                            <input type="text" class="form-control" name="character_name" placeholder="Nhập chính xác ID hoặc Tên nhân vật" required style="border-radius: 8px; font-size: 0.9rem; padding: 10px 14px;">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" style="font-weight: 600; font-size: 0.86rem; margin-bottom: 5px;">
                                                <i class="fa-solid fa-server me-1" style="color: #3b82f6;"></i> Máy chủ / Phương thức đăng nhập:
                                            </label>
                                            <input type="text" class="form-control" name="server" placeholder="Ví dụ: Server 1, Facebook, Garena, hoặc để trống" style="border-radius: 8px; font-size: 0.9rem; padding: 10px 14px;">
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="form-label" style="font-weight: 600; font-size: 0.86rem; margin-bottom: 5px;">
                                                <i class="fa-solid fa-note-sticky me-1" style="color: #3b82f6;"></i> Ghi chú (nếu có):
                                            </label>
                                            <input type="text" class="form-control" name="user_note" placeholder="Nhập ghi chú thêm cho Admin (không bắt buộc)" style="border-radius: 8px; font-size: 0.9rem; padding: 10px 14px;">
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-weight: 700; border-radius: 10px; text-transform: uppercase; font-size: 0.92rem;">
                                            <i class="fa-solid fa-paper-plane me-1"></i> XÁC NHẬN TẠO YÊU CẦU RÚT
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Lịch sử rút vật phẩm -->
                        <div class="profile-info-card mt-4">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label">
                                        <i class="fa-solid fa-clock-rotate-left me-2" style="color: #3b82f6;"></i> LỊCH SỬ RÚT VẬT PHẨM
                                    </span>
                                </div>
                            </div>

                            <div class="info-content" style="padding: 16px;">
                                <!-- Desktop Table View -->
                                <div class="history-table-container">
                                    <table class="history-table">
                                        <thead>
                                            <tr>
                                                <th>Thời gian</th>
                                                <th>Vật phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Tên NV / ID</th>
                                                <th>Máy chủ</th>
                                                <th>Ghi chú</th>
                                                <th style="text-align: center;">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($withdrawals as $w)
                                                <tr>
                                                    <td style="color: #64748b; font-size: 0.82rem;">{{ $w->created_at->format('H:i d/m/Y') }}</td>
                                                    <td style="font-weight: 700;">{{ $w->rewardItem?->name ?? 'CC' }}</td>
                                                    <td style="font-weight: 800; color: #3b82f6; font-size: 0.92rem;">{{ number_format($w->amount) }}</td>
                                                    <td style="font-weight: 600;">{{ $w->character_name }}</td>
                                                    <td style="color: #64748b;">{{ $w->server ?: '—' }}</td>
                                                    <td style="color: #64748b;">{{ $w->user_note ?: '—' }}</td>
                                                    <td style="text-align: center;">
                                                        @if($w->status === 'processing' || $w->status === 'pending')
                                                            <span class="history-status-badge status-processing">
                                                                <i class="fa-solid fa-hourglass-half"></i> Đang xử lý
                                                            </span>
                                                        @elseif($w->status === 'completed' || $w->status === 'success')
                                                            <span class="history-status-badge status-success">
                                                                <i class="fa-solid fa-check"></i> Hoàn thành
                                                            </span>
                                                        @else
                                                            <span class="history-status-badge status-cancelled">
                                                                <i class="fa-solid fa-xmark"></i> Đã hủy
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" style="padding: 35px 20px; text-align: center; color: #94a3b8;">
                                                        <i class="fa-solid fa-inbox" style="font-size: 2rem; margin-bottom: 8px; display: block; opacity: 0.4;"></i>
                                                        Chưa có yêu cầu rút vật phẩm nào.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile Card List View -->
                                <div class="mobile-history-list">
                                    @forelse($withdrawals as $w)
                                        <div class="mobile-history-card">
                                            <div class="mhc-top">
                                                <span class="mhc-time"><i class="fa-regular fa-clock me-1"></i> {{ $w->created_at->format('H:i d/m/Y') }}</span>
                                                @if($w->status === 'processing' || $w->status === 'pending')
                                                    <span class="history-status-badge status-processing">
                                                        <i class="fa-solid fa-hourglass-half"></i> Đang xử lý
                                                    </span>
                                                @elseif($w->status === 'completed' || $w->status === 'success')
                                                    <span class="history-status-badge status-success">
                                                        <i class="fa-solid fa-check"></i> Hoàn thành
                                                    </span>
                                                @else
                                                    <span class="history-status-badge status-cancelled">
                                                        <i class="fa-solid fa-xmark"></i> Đã hủy
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="mhc-body">
                                                <div>
                                                    <div class="mhc-label">Vật phẩm</div>
                                                    <div class="mhc-val">{{ $w->rewardItem?->name ?? 'CC' }}</div>
                                                </div>
                                                <div>
                                                    <div class="mhc-label">Số lượng</div>
                                                    <div class="mhc-val highlight">{{ number_format($w->amount) }}</div>
                                                </div>
                                                <div>
                                                    <div class="mhc-label">Tên NV / ID</div>
                                                    <div class="mhc-val">{{ $w->character_name }}</div>
                                                </div>
                                                <div>
                                                    <div class="mhc-label">Máy chủ</div>
                                                    <div class="mhc-val">{{ $w->server ?: '—' }}</div>
                                                </div>
                                                @if($w->user_note)
                                                    <div class="mhc-row-full">
                                                        <div class="mhc-label">Ghi chú</div>
                                                        <div class="mhc-val" style="font-weight: normal; color: #64748b;">{{ $w->user_note }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div style="padding: 30px 10px; text-align: center; color: #94a3b8;">
                                            <i class="fa-solid fa-inbox" style="font-size: 1.8rem; margin-bottom: 6px; display: block; opacity: 0.4;"></i>
                                            Chưa có yêu cầu rút vật phẩm nào.
                                        </div>
                                    @endforelse
                                </div>

                                @if($withdrawals->hasPages())
                                    <div style="padding-top: 14px;">
                                        {{ $withdrawals->links('user.pagination.custom') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function selectItem(id, name, balance, min, max) {
            document.querySelectorAll('.gem-item-card').forEach(card => card.classList.remove('active'));
            
            const cardEl = document.getElementById('item-card-' + id);
            if (cardEl) cardEl.classList.add('active');
            
            if (balance <= 0 || (min > 0 && balance < min)) {
                document.getElementById('withdraw-form').style.display = 'none';
                const placeholder = document.getElementById('form-placeholder');
                placeholder.style.display = 'block';
                placeholder.style.color = '#ef4444';
                placeholder.style.borderColor = 'rgba(239, 68, 68, 0.4)';
                placeholder.innerHTML = `<i class="fa-solid fa-circle-exclamation me-1"></i> Số lượng <strong>${name}</strong> không đủ để rút (Số dư: ${new Intl.NumberFormat('vi-VN').format(balance)} / Tối thiểu: ${min > 0 ? new Intl.NumberFormat('vi-VN').format(min) : 1}).`;
                return;
            }

            const placeholder = document.getElementById('form-placeholder');
            placeholder.style.display = 'none';
            placeholder.style.color = '#64748b';
            placeholder.style.borderColor = '#cbd5e1';
            
            document.getElementById('withdraw-form').style.display = 'block';
            
            document.getElementById('reward_item_id').value = id;
            document.getElementById('withdraw-amount-label').innerHTML = `<i class="fa-solid fa-coins me-1" style="color: #3b82f6;"></i> Số lượng <strong>${name}</strong> muốn rút:`;
            
            const amountInput = document.getElementById('amount');
            amountInput.min = min > 0 ? min : 1;
            amountInput.max = max > 0 ? Math.min(balance, max) : balance;
            amountInput.value = '';
            
            let limitText = `Giới hạn: Tối thiểu ${new Intl.NumberFormat('vi-VN').format(min > 0 ? min : 1)}`;
            if (max > 0) limitText += ` — Tối đa ${new Intl.NumberFormat('vi-VN').format(max)}`;
            limitText += ` (Số dư: ${new Intl.NumberFormat('vi-VN').format(balance)})`;
            document.getElementById('withdraw-limit-text').textContent = limitText;

            if (window.innerWidth <= 768) {
                document.getElementById('withdraw-form').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function selectGemItem(balance) {
            document.querySelectorAll('.gem-item-card').forEach(card => card.classList.remove('active'));
            document.getElementById('item-card-gem').classList.add('active');

            if (balance <= 0) {
                document.getElementById('withdraw-form').style.display = 'none';
                const placeholder = document.getElementById('form-placeholder');
                placeholder.style.display = 'block';
                placeholder.style.color = '#ef4444';
                placeholder.style.borderColor = 'rgba(239, 68, 68, 0.4)';
                placeholder.innerHTML = `<i class="fa-solid fa-circle-exclamation me-1"></i> Bạn không có số dư CC để thực hiện rút.`;
                return;
            }

            const placeholder = document.getElementById('form-placeholder');
            placeholder.style.display = 'none';
            
            document.getElementById('withdraw-form').style.display = 'block';
            document.getElementById('reward_item_id').value = '';
            document.getElementById('withdraw-amount-label').innerHTML = `<i class="fa-solid fa-coins me-1" style="color: #3b82f6;"></i> Số lượng <strong>CC</strong> muốn rút:`;
            
            const amountInput = document.getElementById('amount');
            amountInput.min = 1;
            amountInput.max = balance;
            amountInput.value = '';
            document.getElementById('withdraw-limit-text').textContent = `Có thể rút tối đa ${new Intl.NumberFormat('vi-VN').format(balance)} CC (Tối thiểu: 1)`;

            if (window.innerWidth <= 768) {
                document.getElementById('withdraw-form').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        const selectedRewardItemId = @json($selectedRewardItemId);
        if (selectedRewardItemId) {
            const el = document.getElementById('item-card-' + selectedRewardItemId);
            if (el) el.click();
        }
    </script>
@endpush
