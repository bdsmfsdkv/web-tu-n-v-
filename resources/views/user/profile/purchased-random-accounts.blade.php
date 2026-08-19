@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-boxes-stacked me-2"></i> TÀI KHOẢN NGẪU NHIÊN ĐÃ MUA</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> SỐ DƯ HIỆN TẠI:
                                        {{ number_format($user->balance) }} VND</span>
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

                                <div class="transaction-history">
                                    <style>
                                        .random-order-card { display: flex; align-items: center; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; margin-bottom: 12px; padding: 16px 20px; text-decoration: none; color: inherit; transition: 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
                                        .random-order-card:hover { border-color: #cbd5e1; background: #f8fafc; }
                                        .r-order-id { width: auto; min-width: 60px; padding: 0 12px; height: 40px; background: #ef4444; color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.95rem; margin-right: 16px; flex-shrink: 0; }
                                        .r-order-info { flex: 1; }
                                        .r-order-title { font-weight: 700; font-size: 1.05rem; color: #111827; margin-bottom: 4px; display: flex; align-items: center; gap: 6px; }
                                        .r-order-qty { color: #64748b; font-weight: 500; font-size: 0.9rem; }
                                        .r-order-time { font-size: 0.85rem; color: #94a3b8; }
                                        .r-order-price-box { text-align: right; margin-right: 20px; }
                                        .r-order-price { color: #ef4444; font-weight: 700; font-size: 1.05rem; margin-bottom: 4px; }
                                        .r-order-status { border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
                                        .r-order-arrow { color: #cbd5e1; font-size: 1.2rem; }
                                        
                                        [data-theme="dark"] .random-order-card { background: #171717; border-color: #2a2a2a; }
                                        [data-theme="dark"] .random-order-card:hover { border-color: #404040; background: #262626; }
                                        [data-theme="dark"] .r-order-title { color: #f8fafc; }
                                        [data-theme="dark"] .r-order-qty { color: #9ca3af; }
                                        [data-theme="dark"] .r-order-time { color: #6b7280; }
                                        [data-theme="dark"] .r-order-arrow { color: #404040; }
                                        
                                        .empty-state-box { text-align: center; padding: 40px; background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 24px; }
                                        [data-theme="dark"] .empty-state-box { background: #171717; border-color: #2a2a2a; }
                                    </style>

                                    @forelse($orders as $order)
                                        <a href="{{ route('profile.purchased-random-account-detail', $order->order_batch_id) }}" class="random-order-card">
                                            <div class="r-order-id">
                                                #{{ strtoupper(substr(str_replace('ORD-', '', str_replace('LEGACY-', '', $order->order_batch_id)), 0, 8)) }}
                                            </div>
                                            <div class="r-order-info">
                                                <div class="r-order-title">
                                                    {{ $order->category->name ?? 'Tài khoản ngẫu nhiên' }} 
                                                    <span class="r-order-qty">x{{ $order->quantity }} acc</span>
                                                </div>
                                                <div class="r-order-time">
                                                    {{ \Carbon\Carbon::parse($order->purchase_time)->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                            <div class="r-order-price-box">
                                                <div class="r-order-price">{{ number_format($order->total_price) }}đ</div>
                                                <div class="r-order-status">Hoàn thành</div>
                                            </div>
                                            <div class="r-order-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="empty-state-box">
                                            <span class="iconify" data-icon="ant-design:inbox-outlined" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 12px;"></span>
                                            <p style="color: #64748b; margin: 0; font-weight: 600;">Bạn chưa mua tài khoản nào.</p>
                                        </div>
                                    @endforelse

                                    <div class="pagination">
                                        {{ $orders->links('user.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
