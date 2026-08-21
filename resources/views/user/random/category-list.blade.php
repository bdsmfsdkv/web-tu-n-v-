@extends('layouts.user.app')

@section('title', $title)

@push('css')
    <link href="/css/category-attribute-fix.css?v=20260820-1" rel="stylesheet">
@endpush

@section('content')
    <!-- Hero Section -->
    <x-hero-header :title="$category->name" :description="$category->description" />

    <!-- Account List Section -->
    <section class="account-section">
        <div class="container">
            <!-- Filter Bar -->
            <form action="" method="GET" class="filter-inline-bar">
                <input type="text" name="code" class="filter-input" placeholder="Mã số..." value="{{ request('code') }}">
                
                <select name="price_range" class="filter-select">
                    <option value="">Khoảng giá</option>
                    <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>Dưới 50K</option>
                    <option value="50000-200000" {{ request('price_range') == '50000-200000' ? 'selected' : '' }}>50K - 200K</option>
                    <option value="200000-500000" {{ request('price_range') == '200000-500000' ? 'selected' : '' }}>200K - 500K</option>
                    <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>500K - 1 Triệu</option>
                    <option value="1000000" {{ request('price_range') == '1000000' ? 'selected' : '' }}>Trên 1 Triệu</option>
                </select>

                <select name="status" class="filter-select">
                    <option value="">Trạng Thái</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Chưa bán</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Đã bán</option>
                </select>

                <button type="submit" class="filter-btn filter-btn-search">
                    <i class="fa-solid fa-search"></i> Tìm kiếm
                </button>
                <a href="{{ request()->url() }}" class="filter-btn filter-btn-reset">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            </form>

            <!-- Account Grid -->
            <div class="account-grid">
                @forelse($accounts as $account)
                    <div class="account-card">
                        <div class="account-media">
                            <a href="{{ route('random.account.show', ['id' => $account->id]) }}">
                                <img src="{{ !empty($account->thumbnail) ? asset($account->thumbnail) : (!empty($category->thumbnail) ? asset($category->thumbnail) : 'https://via.placeholder.com/300x180') }}" alt="Account Preview" class="account-img">
                            </a>
                            <div class="account-code">Mã số: {{ $account->id }}</div>
                            <div class="account-price-top">ATM/VÍ ĐIỆN TỬ: {{ number_format($account->price) }} VND</div>
                        </div>

                        <div class="account-info">
                            @if(!empty($account->note))
                                <div class="account-row" style="padding: 10px 0 0 0; color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">
                                    <span style="font-weight: 600; color: var(--text-color);"><i class="fa-solid fa-circle-info"></i> Ghi chú:</span> 
                                    {{ Str::limit($account->note, 60) }}
                                </div>
                            @endif
                        </div>

                        <div class="account-actions">
                            <div class="card-price">CARD:
                                {{ number_format($account->price / ((100 - config_get('payment.card.discount_percent', 0)) / 100)) }}
                                Đ</div>
                            <a href="{{ route('random.account.show', ['id' => $account->id]) }}"
                                class="action-btn action-btn--detail">XEM CHI TIẾT</a>
                        </div>
                    </div>
                @empty
                    <div class="no-data-empty" style="text-align: center; padding: 60px 0; grid-column: 1 / -1; width: 100%;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px; color: #a0aec0; margin-bottom: 16px;">
                            <path d="M21 8v13H3V8"></path>
                            <path d="M1 3h22v5H1z"></path>
                            <path d="M10 12h4v4h-4z"></path>
                        </svg>
                        <p style="color: #a0aec0; font-size: 1rem; margin: 0;">Chưa có tài khoản nào</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center; width: 100%;">
                {{ $accounts->links('user.pagination.custom') }}
            </div>
        </div>
    </section>
@endsection
