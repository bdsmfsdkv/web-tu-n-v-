@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section" style="padding-bottom: 90px;">
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
                                        <strong>{{ number_format($user->balance) }} VND</strong></span>
                                </div>
                            </div>

                            <div class="info-content">
                                @if (session('error'))
                                    <div class="alert alert-danger" style="margin-bottom: 16px;">
                                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success" style="margin-bottom: 16px;">
                                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                                    </div>
                                @endif

                                <div class="transaction-history">
                                    <style>
                                        .random-order-item {
                                            background: #ffffff;
                                            border: 1px solid #e2e8f0;
                                            border-radius: 12px;
                                            margin-bottom: 14px;
                                            padding: 16px;
                                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
                                            transition: all 0.2s ease;
                                            display: flex;
                                            flex-direction: column;
                                            gap: 12px;
                                        }

                                        .random-order-item:hover {
                                            border-color: rgba(220, 38, 38, 0.3);
                                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
                                        }

                                        /* Card Top Row */
                                        .r-order-top {
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            gap: 8px;
                                            padding-bottom: 10px;
                                            border-bottom: 1px solid #f1f5f9;
                                        }

                                        .r-order-badge-id {
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 6px;
                                            background: #f1f5f9;
                                            color: #334155;
                                            font-size: 0.8rem;
                                            font-weight: 750;
                                            padding: 4px 10px;
                                            border-radius: 6px;
                                            letter-spacing: 0.3px;
                                        }

                                        .r-order-status-badge {
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 5px;
                                            background: #f0fdf4;
                                            color: #16a34a;
                                            border: 1px solid #bbf7d0;
                                            font-size: 0.76rem;
                                            font-weight: 700;
                                            padding: 3px 9px;
                                            border-radius: 9999px;
                                        }

                                        /* Card Middle Content */
                                        .r-order-body {
                                            display: flex;
                                            align-items: center;
                                            gap: 14px;
                                        }

                                        .r-order-thumb-wrap {
                                            width: 64px;
                                            height: 64px;
                                            border-radius: 8px;
                                            overflow: hidden;
                                            background: #f8fafc;
                                            border: 1px solid #e2e8f0;
                                            flex-shrink: 0;
                                        }

                                        .r-order-thumb {
                                            width: 100%;
                                            height: 100%;
                                            object-fit: cover;
                                            display: block;
                                        }

                                        .r-order-details {
                                            flex: 1;
                                            min-width: 0;
                                            display: flex;
                                            flex-direction: column;
                                            gap: 4px;
                                        }

                                        .r-order-name {
                                            font-size: 0.98rem;
                                            font-weight: 750;
                                            color: #0f172a;
                                            margin: 0;
                                            white-space: nowrap;
                                            overflow: hidden;
                                            text-overflow: ellipsis;
                                        }

                                        .r-order-meta-row {
                                            display: flex;
                                            flex-wrap: wrap;
                                            align-items: center;
                                            gap: 8px 12px;
                                            font-size: 0.82rem;
                                            color: #64748b;
                                        }

                                        .r-order-meta-tag {
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 4px;
                                        }

                                        .r-order-meta-tag strong {
                                            color: #0f172a;
                                            font-weight: 600;
                                        }

                                        .r-order-price-val {
                                            font-size: 1.1rem;
                                            font-weight: 850;
                                            color: #dc2626;
                                            white-space: nowrap;
                                            text-align: right;
                                        }

                                        /* Card Bottom Actions */
                                        .r-order-bottom {
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            gap: 12px;
                                            padding-top: 10px;
                                            border-top: 1px dashed #f1f5f9;
                                        }

                                        .btn-view-random-order {
                                            display: inline-flex;
                                            align-items: center;
                                            justify-content: center;
                                            gap: 7px;
                                            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                                            color: #ffffff !important;
                                            font-size: 0.84rem;
                                            font-weight: 700;
                                            padding: 8px 16px;
                                            border-radius: 7px;
                                            text-decoration: none !important;
                                            transition: all 0.2s ease;
                                            box-shadow: 0 2px 6px rgba(220, 38, 38, 0.2);
                                        }

                                        .btn-view-random-order:hover {
                                            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
                                            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
                                        }

                                        /* Mobile Responsive */
                                        @media (max-width: 600px) {
                                            .random-order-item {
                                                padding: 12px;
                                                gap: 10px;
                                            }

                                            .r-order-thumb-wrap {
                                                width: 52px;
                                                height: 52px;
                                            }

                                            .r-order-name {
                                                font-size: 0.9rem;
                                            }

                                            .r-order-meta-row {
                                                font-size: 0.76rem;
                                                gap: 4px 8px;
                                            }

                                            .r-order-price-val {
                                                font-size: 1rem;
                                            }

                                            .r-order-bottom {
                                                flex-direction: column;
                                                align-items: stretch;
                                                gap: 8px;
                                            }

                                            .r-order-mobile-price-row {
                                                display: flex;
                                                align-items: center;
                                                justify-content: space-between;
                                                width: 100%;
                                            }

                                            .btn-view-random-order {
                                                width: 100%;
                                                padding: 9px 12px;
                                                font-size: 0.82rem;
                                            }
                                        }

                                        /* Dark Mode */
                                        [data-theme="dark"] .random-order-item {
                                            background: #1e1e1e;
                                            border-color: #2d2d2d;
                                        }

                                        [data-theme="dark"] .random-order-item:hover {
                                            border-color: #404040;
                                            background: #232323;
                                        }

                                        [data-theme="dark"] .r-order-top {
                                            border-color: #2a2a2a;
                                        }

                                        [data-theme="dark"] .r-order-badge-id {
                                            background: #2a2a2a;
                                            color: #cbd5e1;
                                        }

                                        [data-theme="dark"] .r-order-status-badge {
                                            background: rgba(34, 197, 94, 0.15);
                                            color: #4ade80;
                                            border-color: rgba(34, 197, 94, 0.3);
                                        }

                                        [data-theme="dark"] .r-order-thumb-wrap {
                                            background: #2a2a2a;
                                            border-color: #333333;
                                        }

                                        [data-theme="dark"] .r-order-name {
                                            color: #f1f5f9;
                                        }

                                        [data-theme="dark"] .r-order-meta-row {
                                            color: #94a3b8;
                                        }

                                        [data-theme="dark"] .r-order-meta-tag strong {
                                            color: #f1f5f9;
                                        }

                                        [data-theme="dark"] .r-order-bottom {
                                            border-color: #2a2a2a;
                                        }

                                        .empty-state-box {
                                            text-align: center;
                                            padding: 48px 20px;
                                            background: #ffffff;
                                            border-radius: 12px;
                                            border: 1px solid #e2e8f0;
                                            margin-bottom: 24px;
                                        }

                                        [data-theme="dark"] .empty-state-box {
                                            background: #1e1e1e;
                                            border-color: #2d2d2d;
                                        }
                                    </style>

                                    @forelse($orders as $order)
                                        @php
                                            $cleanId = strtoupper(substr(str_replace('ORD-', '', str_replace('LEGACY-', '', $order->order_batch_id)), 0, 8));
                                            $catName = $order->category->name ?? 'Tài khoản ngẫu nhiên';
                                            $catThumb = !empty($order->category->thumbnail) ? asset($order->category->thumbnail) : 'https://via.placeholder.com/100';
                                            $timeFormatted = \Carbon\Carbon::parse($order->purchase_time)->format('d/m/Y H:i');
                                        @endphp

                                        <div class="random-order-item">
                                            <!-- Top Row: Mã Đơn & Trạng Thái -->
                                            <div class="r-order-top">
                                                <span class="r-order-badge-id">
                                                    <i class="fa-solid fa-receipt" style="color: #ef4444;"></i>
                                                    Mã: <strong>#{{ $cleanId }}</strong>
                                                </span>
                                                <span class="r-order-status-badge">
                                                    <i class="fa-solid fa-circle-check"></i> Hoàn thành
                                                </span>
                                            </div>

                                            <!-- Middle Body: Ảnh + Tên + Thông tin + Giá -->
                                            <div class="r-order-body">
                                                <div class="r-order-thumb-wrap">
                                                    <img src="{{ $catThumb }}" alt="{{ $catName }}" class="r-order-thumb" loading="lazy">
                                                </div>
                                                <div class="r-order-details">
                                                    <h3 class="r-order-name" title="{{ $catName }}">{{ $catName }}</h3>
                                                    <div class="r-order-meta-row">
                                                        <span class="r-order-meta-tag">
                                                            <i class="fa-solid fa-boxes-stacked" style="color: #3b82f6;"></i>
                                                            Số lượng: <strong>{{ $order->quantity }} nick</strong>
                                                        </span>
                                                        <span class="r-order-meta-tag">
                                                            <i class="fa-regular fa-clock"></i>
                                                            {{ $timeFormatted }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="r-order-price-val desktop-only" style="display: none;">
                                                    {{ number_format($order->total_price) }}đ
                                                </div>
                                            </div>

                                            <!-- Bottom Row: Tổng Tiền & Nút Lấy Tài Khoản -->
                                            <div class="r-order-bottom">
                                                <div class="r-order-mobile-price-row">
                                                    <span style="font-size: 0.82rem; color: #64748b; font-weight: 500;">Tổng thanh toán:</span>
                                                    <span class="r-order-price-val">{{ number_format($order->total_price) }}đ</span>
                                                </div>
                                                <a href="{{ route('profile.purchased-random-account-detail', $order->order_batch_id) }}" class="btn-view-random-order">
                                                    <i class="fa-solid fa-key"></i> Lấy tài khoản & Mật khẩu
                                                    <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="empty-state-box">
                                            <i class="fa-solid fa-box-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                                            <p style="color: #64748b; margin: 0 0 12px 0; font-weight: 600;">Bạn chưa mua tài khoản ngẫu nhiên nào.</p>
                                            <a href="/" class="btn-view-random-order" style="display: inline-flex;">
                                                <i class="fa-solid fa-cart-shopping"></i> Mua ngay bây giờ
                                            </a>
                                        </div>
                                    @endforelse

                                    <div class="pagination" style="display: flex; justify-content: center; margin-top: 20px;">
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
