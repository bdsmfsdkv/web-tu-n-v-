@extends('layouts.user.app')

@section('title', 'Lịch sử mua trả góp')

@section('content')
<div class="container" style="padding: 24px 0 90px;">
    <div class="profile-layout" style="display: flex; gap: 24px;">
        @include('layouts.user.sidebar')

        <div class="profile-main" style="flex: 1;">
            <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-hand-holding-usd" style="color: var(--primary);"></i> Lịch sử mua trả góp
                </h2>

                <div class="table-responsive">
                    <table style="width: 100%; text-align: left; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); color: var(--text-muted);">
                                <th style="padding: 12px;">Mã #</th>
                                <th style="padding: 12px;">Tài khoản</th>
                                <th style="padding: 12px;">Tổng giá</th>
                                <th style="padding: 12px;">Đã trả</th>
                                <th style="padding: 12px;">Còn lại</th>
                                <th style="padding: 12px;">Hạn chót</th>
                                <th style="padding: 12px;">Trạng thái</th>
                                <th style="padding: 12px;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($installments as $installment)
                                @php
                                    $remaining = $installment->total_price - $installment->paid_amount;
                                    $isOverdue = $installment->expire_date < now() && $installment->status == 'active';
                                @endphp
                                <tr style="border-bottom: 1px solid var(--border-color); color: var(--text-color);">
                                    <td style="padding: 12px; font-weight: 600;">#{{ $installment->id }}</td>
                                    <td style="padding: 12px;">
                                        <a href="{{ route('account.show', $installment->game_account_id) }}" style="color: var(--primary); text-decoration: underline;">
                                            Nick #{{ $installment->game_account_id }}
                                        </a>
                                    </td>
                                    <td style="padding: 12px; font-weight: 600;">{{ number_format($installment->total_price) }}đ</td>
                                    <td style="padding: 12px; color: #10b981;">{{ number_format($installment->paid_amount) }}đ</td>
                                    <td style="padding: 12px; color: #ef4444;">{{ number_format($remaining) }}đ</td>
                                    <td style="padding: 12px; {{ $isOverdue ? 'color: #ef4444; font-weight: bold;' : '' }}">
                                        {{ $installment->expire_date->format('d/m/Y H:i') }}
                                        @if($isOverdue) <br><small>(Quá hạn)</small> @endif
                                    </td>
                                    <td style="padding: 12px;">
                                        @if($installment->status === 'completed')
                                            <span style="background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">Hoàn thành</span>
                                        @elseif($installment->status === 'cancelled')
                                            <span style="background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">Đã hủy</span>
                                        @elseif($isOverdue)
                                            <span style="background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">Quá hạn</span>
                                        @else
                                            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">Đang trả góp</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px;">
                                        @if($installment->status === 'active' && !$isOverdue && $remaining > 0)
                                            <button onclick="openPayModal({{ $installment->id }}, {{ $remaining }})" style="background: var(--primary); color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">Thanh toán</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="padding: 24px; text-align: center; color: var(--text-muted);">Bạn chưa có hợp đồng mua trả góp nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 24px; display: flex; justify-content: center;">
                    {{ $installments->links('user.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thanh Toán -->
<style>
    .pay-modal {
        position: fixed;
        inset: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.65);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }
    .pay-modal.active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }
    .pay-modal-content {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        transform: scale(0.95) translateY(8px);
        transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .pay-modal.active .pay-modal-content {
        transform: scale(1) translateY(0);
    }
</style>
<div id="payModal" class="pay-modal" onclick="if(event.target===this)closePayModal()">
    <div class="pay-modal-content">
        <div style="display:flex; justify-content:space-between; align-items:center; padding: 16px 20px; border-bottom: 1px solid var(--border-color);">
            <h3 style="font-size:1.15rem; font-weight:700; margin:0; color: var(--text-color);">Thanh toán trả góp</h3>
            <button onclick="closePayModal()" style="background:none; border:none; font-size:1.4rem; cursor:pointer; color: var(--text-muted);">✕</button>
        </div>
        
        <div style="padding: 20px;">
            <input type="hidden" id="payInstallmentId" value="">
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-color);">Số tiền cần thanh toán còn lại:</label>
                <div id="payRemainingText" style="font-size: 1.2rem; font-weight: bold; color: #ef4444; margin-bottom: 8px;">0đ</div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-color);">Nhập số tiền muốn thanh toán đợt này:</label>
                <input type="number" id="payAmountInput" min="10000" placeholder="Tối thiểu 10,000đ" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; background: rgba(0,0,0,0.05); color: var(--text-color); font-size: 1rem;">
                <div style="display: flex; gap: 8px; margin-top: 10px;">
                    <button onclick="setPayAmount(0.5)" style="flex: 1; padding: 6px; font-size: 0.85rem; border: 1px solid var(--border-color); border-radius: 4px; background: transparent; color: var(--text-color); cursor: pointer;">50%</button>
                    <button onclick="setPayAmount(1)" style="flex: 1; padding: 6px; font-size: 0.85rem; border: 1px solid var(--border-color); border-radius: 4px; background: transparent; color: var(--text-color); cursor: pointer;">Tất toán (100%)</button>
                </div>
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button onclick="closePayModal()" style="flex: 1; padding: 10px; border-radius: 6px; border: 1px solid var(--border-color); background: transparent; color: var(--text-color); font-weight: 600; cursor: pointer;">Hủy</button>
                <button onclick="submitPay()" id="btnSubmitPay" style="flex: 1; padding: 10px; border-radius: 6px; border: none; background: var(--primary); color: white; font-weight: 600; cursor: pointer;">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentRemaining = 0;

    function openPayModal(id, remaining) {
        document.getElementById('payInstallmentId').value = id;
        currentRemaining = remaining;
        document.getElementById('payRemainingText').innerText = new Intl.NumberFormat('vi-VN').format(remaining) + 'đ';
        document.getElementById('payAmountInput').value = remaining; // Mặc định tất toán
        const modal = document.getElementById('payModal');
        if (modal) {
            modal.classList.add('active');
        }
    }

    function closePayModal() {
        const modal = document.getElementById('payModal');
        if (modal) {
            modal.classList.remove('active');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePayModal();
    });

    function setPayAmount(ratio) {
        const amount = currentRemaining * ratio;
        document.getElementById('payAmountInput').value = Math.floor(amount);
    }

    function submitPay() {
        const id = document.getElementById('payInstallmentId').value;
        let amount = parseInt(document.getElementById('payAmountInput').value);
        const btn = document.getElementById('btnSubmitPay');

        if(isNaN(amount) || amount < 10000) {
            FuiToast.error("Số tiền thanh toán tối thiểu là 10,000đ!");
            return;
        }

        if(amount > currentRemaining) amount = currentRemaining;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>...';

        fetch(`/installment/${id}/pay`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ amount: amount })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                FuiToast.success(data.message);
                setTimeout(() => window.location.reload(), 1500);
            } else {
                FuiToast.error(data.message);
                btn.disabled = false;
                btn.innerHTML = 'Xác nhận';
            }
        })
        .catch(err => {
            FuiToast.error("Lỗi kết nối!");
            btn.disabled = false;
            btn.innerHTML = 'Xác nhận';
        });
    }
</script>
<style>
    @keyframes modalPop {
        0% { transform: scale(0.95); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
@endsection
