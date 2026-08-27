@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section" style="padding-bottom: 90px;">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-coins me-2"></i> RÚT VÀNG</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-coins me-2"></i> SỐ VÀNG HIỆN TẠI:
                                        {{ number_format(auth()->user()->gold) }}</span>
                                </div>
                            </div>

                            <div class="info-content">
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('profile.withdraw-gold') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="amount" class="form-label">
                                            <i class="fa-solid fa-coins me-2"></i> Số lượng vàng muốn rút
                                        </label>
                                        <input type="number" value="0"
                                            class="form-control @error('amount') is-invalid @enderror" id="amount"
                                            name="amount" required min="{{ $minWithdrawGold }}" max="{{ $maxWithdrawGold }}">
                                        <div class="form-text">Tối thiểu: {{ number_format($minWithdrawGold) }} vàng - Tối đa: {{ number_format($maxWithdrawGold) }} vàng</div>
                                        @error('amount')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="game" class="form-label">
                                            <i class="fa-solid fa-gamepad me-2"></i> Chọn game
                                        </label>
                                        <select class="form-control @error('game') is-invalid @enderror" id="game" name="game" required>
                                            <option value="">Chọn loại game</option>
                                            <option value="Liên Quân Mobile" {{ old('game') == 'Liên Quân Mobile' ? 'selected' : '' }}>Liên Quân Mobile</option>
                                            <option value="Free Fire" {{ old('game') == 'Free Fire' ? 'selected' : '' }}>Free Fire</option>
                                            <option value="Ngọc Rồng Online" {{ old('game') == 'Ngọc Rồng Online' ? 'selected' : '' }}>Ngọc Rồng Online</option>
                                            <option value="Ninja School" {{ old('game') == 'Ninja School' ? 'selected' : '' }}>Ninja School</option>
                                            <option value="Khác" {{ old('game') == 'Khác' ? 'selected' : '' }}>Khác</option>
                                        </select>
                                        @error('game')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="character_name" class="form-label">
                                            <i class="fa-solid fa-user me-2"></i> Tên nhân vật
                                        </label>
                                        <input type="text"
                                            class="form-control @error('character_name') is-invalid @enderror"
                                            id="character_name" name="character_name" value="{{ old('character_name') }}"
                                            required>
                                        @error('character_name')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="server" class="form-label">
                                            <i class="fa-solid fa-server me-2"></i> Máy chủ
                                        </label>
                                        <input type="text"
                                            class="form-control @error('server') is-invalid @enderror"
                                            id="server" name="server" value="{{ old('server') }}"
                                            placeholder="Nhập máy chủ hoặc cách đăng nhập (VD: Facebook, Garena...)"
                                            required>
                                        @error('server')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="user_note" class="form-label">
                                            <i class="fa-solid fa-note-sticky me-2"></i> Ghi chú
                                        </label>
                                        <textarea class="form-control @error('user_note') is-invalid @enderror" id="user_note" name="user_note" rows="3"
                                            placeholder="Ghi chú thêm về yêu cầu rút vàng (nếu có)">{{ old('user_note') }}</textarea>
                                        @error('user_note')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-check me-2"></i> Gửi yêu cầu
                                        </button>
                                    </div>
                                </form>

                                <div class="withdrawal-history mt-5">
                                    <div class="history-header">LỊCH SỬ RÚT VÀNG</div>
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Trạng thái</th>
                                                    <th>Thời gian</th>
                                                    <th>Game</th>
                                                    <th>Số lượng</th>
                                                    <th>Tên nhân vật</th>
                                                    <th>Máy chủ</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($withdrawals) && count($withdrawals) > 0)
                                                    @foreach ($withdrawals as $withdrawal)
                                                        <tr>
                                                            <td>
                                                                {!! display_status($withdrawal->status) !!}
                                                            </td>
                                                            <td>{{ $withdrawal->created_at->format('d/m/Y H:i:s') }}</td>
                                                            <td>{{ $withdrawal->game }}</td>
                                                            <td>{{ number_format($withdrawal->amount) }}</td>
                                                            <td>{{ $withdrawal->character_name }}</td>
                                                            <td>{{ $withdrawal->server }}</td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info view-details"
                                                                    data-id="{{ $withdrawal->id }}" data-type="gold">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7" class="text-center">Chưa có lịch sử rút vàng</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if (isset($withdrawals) && count($withdrawals) > 0)
                                        <div class="pagination-area mt-3">
                                            {{ $withdrawals->links('user.pagination.custom') }}
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

    <!-- Withdrawal Details Modal -->
    <style>
        .modal {
            position: fixed;
            z-index: 1050;
            inset: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(15, 23, 42, 0.65);
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
            background-color: #fff;
            margin: auto;
            width: 90%;
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transform: scale(0.95) translateY(8px);
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .modal.active .modal__content, .modal.show .modal__content {
            transform: scale(1) translateY(0);
        }
        .modal__header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #e5e7eb; background-color: #f8fafc; }
        .modal__title { margin: 0; font-size: 1.25rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; }
        .modal__close { background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer; line-height: 1; padding: 0; transition: color 0.2s; }
        .modal__close:hover { color: #ef4444; }
        .modal__body { padding: 20px; flex: 1; }
        .modal__footer { padding: 16px 20px; border-top: 1px solid #e5e7eb; background-color: #f8fafc; text-align: right; }
        .modal__btn { padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.2s; border: none; }
        .modal__btn--close { background-color: #e2e8f0; color: #475569; }
        .modal__btn--close:hover { background-color: #cbd5e1; }
        .modal__row { display: flex; margin-bottom: 12px; font-size: 0.95rem; }
        .modal__row:last-child { margin-bottom: 0; }
        .modal__label { width: 130px; color: #64748b; font-weight: 500; display: flex; align-items: center; flex-shrink: 0; }
        .modal__value { flex: 1; color: #0f172a; font-weight: 600; }
        [data-theme="dark"] .modal__content { background-color: #171717; border: 1px solid #2a2a2a; }
        [data-theme="dark"] .modal__header { background-color: #0f172a; border-bottom-color: #333; }
        [data-theme="dark"] .modal__title { color: #f8fafc; }
        [data-theme="dark"] .modal__close { color: #94a3b8; }
        [data-theme="dark"] .modal__footer { background-color: #0f172a; border-top-color: #333; }
        [data-theme="dark"] .modal__btn--close { background-color: #334155; color: #f8fafc; }
        [data-theme="dark"] .modal__label { color: #94a3b8; }
        [data-theme="dark"] .modal__value { color: #f8fafc; }
    </style>
    <div id="withdrawalDetailsModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title"><i class="fa-solid fa-circle-info me-2"></i> Chi tiết rút vàng #<span
                        id="withdrawal-id"></span></h2>
                <button class="modal__close" onclick="closeWithdrawalModal()">&times;</button>
            </div>

            <div class="modal__body">
                <div id="modal-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="mt-2">Đang tải thông tin...</p>
                </div>

                <div id="modal-content" class="modal__info" style="display: none;">
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-calendar me-2"></i> Thời gian:</span>
                        <span class="modal__value" id="withdrawal-time"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-coins me-2"></i> Loại tài nguyên:</span>
                        <span class="modal__value" id="withdrawal-type"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-gamepad me-2"></i> Game:</span>
                        <span class="modal__value" id="withdrawal-game"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-coins me-2"></i> Số lượng:</span>
                        <span class="modal__value" id="withdrawal-amount"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-user me-2"></i> Tên nhân vật:</span>
                        <span class="modal__value" id="character-name"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-server me-2"></i> Máy chủ:</span>
                        <span class="modal__value" id="withdrawal-server"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-circle-check me-2"></i> Trạng thái:</span>
                        <span class="modal__value" id="withdrawal-status"></span>
                    </div>
                    <div class="modal__row" id="user-note-container">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Ghi chú người dùng:</span>
                        <span class="modal__value" id="user-note"></span>
                    </div>
                    <div class="modal__row" id="admin-note-container">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Ghi chú admin:</span>
                        <span class="modal__value" id="admin-note"></span>
                    </div>
                </div>

                <div id="modal-error" class="alert alert-danger" style="display: none;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <span id="error-message"></span>
                </div>
            </div>

            <div class="modal__footer">
                <button class="modal__btn modal__btn--close" onclick="closeWithdrawalModal()">ĐÓNG</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all view details buttons
            const viewButtons = document.querySelectorAll('.view-details');

            // Add click event to each button
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const withdrawalId = this.getAttribute('data-id');
                    document.getElementById('withdrawal-id').textContent = withdrawalId;

                    // Show loading, hide content and errors
                    document.getElementById('modal-loading').style.display = 'block';
                    document.getElementById('modal-content').style.display = 'none';
                    document.getElementById('modal-error').style.display = 'none';

                    // Show the modal
                    openWithdrawalModal();

                    // Fetch withdrawal details via AJAX
                    fetch(`/profile/withdrawal-history/${withdrawalId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modal-loading').style.display = 'none';

                            if (data.status === 'success') {
                                // Format data and populate the modal
                                document.getElementById('withdrawal-time').textContent =
                                    new Date(
                                        data.created_at).toLocaleString('vi-VN');
                                document.getElementById('withdrawal-type').textContent = data
                                    .type === 'gold' ? 'Vàng' : 'Ngọc';
                                document.getElementById('withdrawal-game').textContent = data
                                    .game;
                                document.getElementById('withdrawal-amount').textContent =
                                    new Intl.NumberFormat('vi-VN').format(data.amount);
                                document.getElementById('character-name').textContent = data
                                    .character_name;
                                document.getElementById('withdrawal-server').textContent =
                                    data.server;
                                document.getElementById('withdrawal-status').innerHTML = data
                                    .status_html;

                                // Display user note if exists
                                if (data.user_note) {
                                    document.getElementById('user-note').textContent = data
                                        .user_note;
                                    document.getElementById('user-note-container').style
                                        .display = 'flex';
                                } else {
                                    document.getElementById('user-note').textContent =
                                        "Không có ghi chú";
                                }

                                // Display admin note if exists
                                if (data.admin_note) {
                                    document.getElementById('admin-note').textContent = data
                                        .admin_note;
                                    document.getElementById('admin-note-container').style
                                        .display = 'flex';
                                } else {
                                    document.getElementById('admin-note').textContent =
                                        "Không có ghi chú";
                                }

                                // Show the content
                                document.getElementById('modal-content').style.display =
                                    'block';
                            } else {
                                // Show error message
                                document.getElementById('error-message').textContent = data
                                    .message || 'Đã xảy ra lỗi khi tải dữ liệu';
                                document.getElementById('modal-error').style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching withdrawal details:', error);
                            document.getElementById('modal-loading').style.display = 'none';
                            document.getElementById('error-message').textContent =
                                'Đã xảy ra lỗi kết nối, vui lòng thử lại sau';
                            document.getElementById('modal-error').style.display = 'block';
                        });
                });
            });
        });

        // Function to open withdrawal modal
        function openWithdrawalModal() {
            document.getElementById('withdrawalDetailsModal').classList.add('active');
        }

        // Function to close withdrawal modal
        function closeWithdrawalModal() {
            document.getElementById('withdrawalDetailsModal').classList.remove('active');
        }
    </script>
@endpush
