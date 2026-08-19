@extends('layouts.user.app')
@section('title', $title)

@push('css')
    <style>
        :root {
            --bg-card: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-subtle: #e5e7eb;
            --bg-body: #f8f9fa;
        }

        [data-theme="dark"] {
            --bg-card: #121212;
            --text-main: #f8fafc;
            --text-muted: #9ca3af;
            --border-subtle: #27272a;
            --bg-body: #000000;
        }

        .withdraw-page {
            padding: 40px 0;
            color: var(--text-main, #1f2937);
        }

        .withdraw-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .withdraw-line {
            width: 30px;
            height: 4px;
            background: #3b82f6;
            border-radius: 4px;
        }

        .withdraw-header-text h2 {
            font-size: 1.5rem;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-main, #1f2937);
        }

        .withdraw-header-text p {
            font-size: 0.75rem;
            color: var(--text-muted, #6b7280);
            margin: 5px 0 0 0;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .withdraw-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        @media (min-width: 992px) {
            .withdraw-layout {
                grid-template-columns: 2fr 1fr;
            }
        }

        .withdraw-card {
            background: var(--bg-card, #ffffff);
            border-radius: 24px;
            border: 1px solid var(--border-subtle, #e5e7eb);
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .request-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .request-icon {
            width: 50px;
            height: 50px;
            background: #3b82f6;
            color: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .request-header h3 {
            font-size: 1.1rem;
            font-weight: 800;
            margin: 0;
            color: var(--text-main, #1f2937);
        }

        .request-header p {
            font-size: 0.75rem;
            color: var(--text-muted, #6b7280);
            margin: 5px 0 0 0;
            font-weight: 600;
            text-transform: uppercase;
        }

        .section-label {
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--text-muted, #6b7280);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .item-card {
            border: 2px solid var(--border-subtle, #e5e7eb);
            border-radius: 16px;
            padding: 20px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--bg-card, #ffffff);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .item-card:hover {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.05);
        }

        .item-card.active {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
        }

        .item-icon {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .item-name {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--text-main, #1f2937);
            text-transform: uppercase;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .item-balance {
            font-size: 1rem;
            font-weight: 900;
            color: var(--text-muted, #6b7280);
        }

        .item-card.active .item-balance {
            color: #3b82f6;
        }

        .form-placeholder {
            border: 1px dashed var(--border-subtle, #e5e7eb);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            color: var(--text-muted, #6b7280);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .withdraw-form {
            display: none;
            background: var(--bg-card, #ffffff);
            border: 1px solid var(--border-subtle, #e5e7eb);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main, #1f2937);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            height: 48px;
            background: var(--bg-body, #f8f9fa);
            border: 1px solid var(--border-subtle, #e5e7eb);
            border-radius: 12px;
            padding: 0 16px;
            color: var(--text-main, #1f2937);
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-submit {
            width: 100%;
            height: 48px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: #2563eb;
        }

        .notes-card {
            background: var(--bg-card, #ffffff);
            border-radius: 24px;
            border: 1px solid var(--border-subtle, #e5e7eb);
            padding: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .notes-card::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 6px;
            background: #3b82f6;
        }

        .notes-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .notes-title {
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--text-main, #1f2937);
            margin: 0;
        }

        .notes-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .notes-list li {
            position: relative;
            padding-left: 15px;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: var(--text-muted, #6b7280);
            line-height: 1.6;
        }

        .notes-list li::before {
            content: '-';
            position: absolute;
            left: 0;
            color: #6b7280;
        }

        .notes-list li strong {
            color: #ef4444; /* red for exactly */
        }
        
        .notes-list li .highlight-blue {
            color: #3b82f6;
            font-weight: 700;
        }

        .btn-history-outline {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            height: 48px;
            background: rgba(59, 130, 246, 0.05);
            border: 2px solid rgba(59, 130, 246, 0.3);
            color: #3b82f6;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
            transition: all 0.2s;
        }

        .btn-history-outline:hover {
            background: rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
            color: #3b82f6;
        }
    </style>
@endpush

@section('content')
    <div class="container withdraw-page">
        
        <div class="withdraw-header">
            <div class="withdraw-line"></div>
            <div class="withdraw-header-text">
                <h2>RÚT VẬT PHẨM</h2>
                <p>RÚT CÁC VẬT PHẨM BẠN ĐÃ TRÚNG TỪ VÒNG QUAY VỀ TÀI KHOẢN GAME</p>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; border-radius: 12px; padding: 15px; margin-bottom: 24px;">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; border-radius: 12px; padding: 15px; margin-bottom: 24px;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="withdraw-layout">
            <!-- Left Panel -->
            <div class="withdraw-card">
                <div class="request-header">
                    <div class="request-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div>
                        <h3>TẠO YÊU CẦU RÚT</h3>
                        <p>ĐIỀN THÔNG TIN TÀI KHOẢN GAME ĐỂ RÚT VẬT PHẨM</p>
                    </div>
                </div>

                <div class="section-label">CHỌN VẬT PHẨM</div>
                
                <div class="items-grid">
                    @foreach($rewardItems as $item)
                        @php
                            // Determine user balance for this item based on logic (gem for now)
                            $balance = Auth::check() ? Auth::user()->gem : 0;
                        @endphp
                        <div class="item-card" onclick="selectItem({{ $item->id }}, '{{ $item->name }}', {{ $balance }}, {{ $item->min_withdraw }}, {{ $item->max_withdraw }})" id="item-card-{{ $item->id }}">
                            <img src="{{ $item->icon ? asset($item->icon) : asset('assets/images/gem.png') }}" class="item-icon" onerror="this.src='https://i.imgur.com/NpL6V6y.png'">
                            <div class="item-name">{{ $item->name }}</div>
                            <div class="item-balance">{{ number_format($balance) }}</div>
                        </div>
                    @endforeach
                    
                    @if($rewardItems->count() == 0)
                        <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted, #6b7280); padding: 20px;">
                            Chưa có vật phẩm nào trong kho thưởng.
                        </div>
                    @endif
                </div>

                <div class="form-placeholder" id="form-placeholder">
                    Vui lòng chọn vật phẩm bạn muốn rút ở trên
                </div>

                <div class="withdraw-form" id="withdraw-form">
                    <form action="{{ route('profile.withdraw-gem') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reward_item_id" id="reward_item_id">
                        
                        <div class="form-group">
                            <label class="form-label" id="withdraw-amount-label">Số lượng rút</label>
                            <input type="number" class="form-control" name="amount" id="amount" min="1" required>
                            <small style="color: #6b7280; display: block; margin-top: 6px;" id="withdraw-limit-text"></small>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tên nhân vật / ID Game</label>
                            <input type="text" class="form-control" name="character_name" placeholder="Nhập chính xác ID hoặc Tên nhân vật" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Ghi chú (Nếu có)</label>
                            <input type="text" class="form-control" name="user_note" placeholder="Ví dụ: Đăng nhập Facebook">
                        </div>
                        
                        <div class="form-group" style="display: none;">
                            <label class="form-label">Máy chủ</label>
                            <select name="server" class="form-control">
                                <option value="1">Máy chủ 1</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-submit">TẠO YÊU CẦU</button>
                    </form>
                </div>
            </div>

            <!-- Right Panel -->
            <div>
                <div class="notes-card">
                    <div class="notes-header">
                        <h3 class="notes-title">LƯU Ý KHI RÚT</h3>
                    </div>
                    
                    <ul class="notes-list">
                        <li>Vật phẩm sẽ được chuyển vào tài khoản game của bạn trong vòng <span class="highlight-blue">1-24h</span>.</li>
                        <li>Vui lòng điền <strong>chính xác</strong> tên nhân vật hoặc ID game (tùy game yêu cầu). Nếu sai có thể bị mất vật phẩm.</li>
                        <li>Nếu hệ thống đang quá tải, thời gian có thể lâu hơn dự kiến.</li>
                        <li>Mọi thắc mắc vui lòng liên hệ Admin qua Fanpage hỗ trợ.</li>
                    </ul>

                    <a href="{{ route('profile.wheels-history') }}" class="btn-history-outline">
                        <i class="fas fa-history"></i> XEM LỊCH SỬ RÚT
                    </a>
                </div>
            </div>
        </div>
        {{-- ===== LỊCH SỬ RÚT ===== --}}
        <div class="container" style="padding-bottom: 50px;">
            <div class="withdraw-header" style="margin-top: 10px; margin-bottom: 20px;">
                <div class="withdraw-line"></div>
                <div class="withdraw-header-text">
                    <h2>LỊCH SỬ RÚT VẬT PHẨM</h2>
                    <p>CÁC YÊU CẦU RÚT VẬT PHẨM CỦA BẠN</p>
                </div>
            </div>

            <div class="withdraw-card" style="padding: 0; overflow: hidden;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                        <thead>
                            <tr style="background: rgba(59,130,246,0.07); border-bottom: 1px solid var(--border-subtle, #e5e7eb);">
                                <th style="padding: 14px 20px; text-align: left; font-weight: 700; color: var(--text-muted, #6b7280); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Thời gian</th>
                                <th style="padding: 14px 20px; text-align: left; font-weight: 700; color: var(--text-muted, #6b7280); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Số lượng</th>
                                <th style="padding: 14px 20px; text-align: left; font-weight: 700; color: var(--text-muted, #6b7280); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Tên nhân vật</th>
                                <th style="padding: 14px 20px; text-align: left; font-weight: 700; color: var(--text-muted, #6b7280); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Ghi chú</th>
                                <th style="padding: 14px 20px; text-align: center; font-weight: 700; color: var(--text-muted, #6b7280); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $w)
                                <tr style="border-bottom: 1px solid var(--border-subtle, #e5e7eb); transition: background 0.15s;" onmouseover="this.style.background='rgba(59,130,246,0.03)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 14px 20px; color: var(--text-muted, #6b7280); font-size: 0.82rem;">{{ $w->created_at->format('H:i d/m/Y') }}</td>
                                    <td style="padding: 14px 20px; font-weight: 700; color: var(--text-main, #1f2937);">{{ number_format($w->amount) }}</td>
                                    <td style="padding: 14px 20px; color: var(--text-main, #1f2937);">{{ $w->character_name }}</td>
                                    <td style="padding: 14px 20px; color: var(--text-muted, #6b7280);">{{ $w->user_note ?: '—' }}</td>
                                    <td style="padding: 14px 20px; text-align: center;">
                                        @if($w->status === 'processing')
                                            <span style="display: inline-block; padding: 4px 12px; background: rgba(234,179,8,0.1); color: #eab308; border: 1px solid rgba(234,179,8,0.25); border-radius: 8px; font-size: 0.78rem; font-weight: 700;">⏳ Đang xử lý</span>
                                        @elseif($w->status === 'completed')
                                            <span style="display: inline-block; padding: 4px 12px; background: rgba(16,185,129,0.1); color: #10b981; border: 1px solid rgba(16,185,129,0.25); border-radius: 8px; font-size: 0.78rem; font-weight: 700;">✓ Hoàn thành</span>
                                        @else
                                            <span style="display: inline-block; padding: 4px 12px; background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.25); border-radius: 8px; font-size: 0.78rem; font-weight: 700;">✕ Đã hủy</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding: 40px; text-align: center; color: var(--text-muted, #6b7280);">
                                        <i class="fa-solid fa-inbox" style="font-size: 2rem; margin-bottom: 10px; display: block; opacity: 0.4;"></i>
                                        Chưa có lịch sử rút vật phẩm nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($withdrawals->hasPages())
                    <div style="padding: 16px 20px; border-top: 1px solid var(--border-subtle, #e5e7eb);">
                        {{ $withdrawals->links('user.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function selectItem(id, name, balance, min, max) {
            // Remove active class from all
            document.querySelectorAll('.item-card').forEach(card => card.classList.remove('active'));
            
            // Add active class to selected
            document.getElementById('item-card-' + id).classList.add('active');
            
            if (balance <= 0 || (min > 0 && balance < min)) {
                // Hide form, show placeholder with error message
                document.getElementById('withdraw-form').style.display = 'none';
                const placeholder = document.getElementById('form-placeholder');
                placeholder.style.display = 'block';
                placeholder.style.color = '#ef4444';
                placeholder.style.borderColor = 'rgba(239, 68, 68, 0.3)';
                placeholder.innerHTML = `<i class="fa-solid fa-circle-exclamation" style="margin-right: 5px;"></i> Bạn không đủ số lượng để rút ${name}. (Tối thiểu: ${min > 0 ? min : 1})`;
                return;
            }

            // Hide placeholder, show form
            const placeholder = document.getElementById('form-placeholder');
            placeholder.style.display = 'none';
            placeholder.style.color = 'var(--text-muted, #6b7280)'; // Reset
            placeholder.style.borderColor = '#27272a'; // Reset
            
            document.getElementById('withdraw-form').style.display = 'block';
            
            // Set form values
            document.getElementById('reward_item_id').value = id;
            document.getElementById('amount').min = min > 0 ? min : 1;
            document.getElementById('amount').max = max > 0 ? Math.min(balance, max) : balance;
            
            let limitText = `Giới hạn rút: Tối thiểu ${min > 0 ? min : 1}`;
            if (max > 0) limitText += ` - Tối đa ${max}`;
            document.getElementById('withdraw-limit-text').textContent = limitText;
        }
    </script>
@endpush
