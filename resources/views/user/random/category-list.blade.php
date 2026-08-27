@extends('layouts.user.app')

@section('title', $title)

@push('css')
    <link href="/css/category-attribute-fix.css?v={{ filemtime(public_path('css/category-attribute-fix.css')) }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Hero Section -->
    <x-hero-header :title="$category->name" :description="$category->description" />

    <!-- Account List Section -->
    <section class="account-section">
        <div class="container">
            <!-- Filter Bar -->
            <form action="" method="GET" class="filter-inline-bar">
                <input type="text" name="code" class="filter-input" placeholder="Nhập mã số..." value="{{ request('code') }}">
                
                <select name="price_range" class="filter-select">
                    <option value="">Khoảng giá (Tất cả)</option>
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
                @php
                    $discountPercent = config_get('payment.card.discount_percent', 0);
                @endphp

                @forelse($accounts as $account)
                    @php
                        $cardPrice = ($discountPercent < 100 && $discountPercent > 0)
                            ? $account->price / ((100 - $discountPercent) / 100)
                            : $account->price * 1.25;
                        $discountRatio = $cardPrice > 0 ? round(100 - ($account->price / $cardPrice) * 100) : 0;
                        $thumb = !empty($account->thumbnail) ? asset($account->thumbnail) : (!empty($category->thumbnail) ? asset($category->thumbnail) : 'https://via.placeholder.com/300x180');
                    @endphp

                    <div class="account-card" data-id="{{ $account->id }}">
                        <!-- Media & Badges -->
                        <div class="account-media">
                            <a href="{{ route('random.account.show', ['id' => $account->id]) }}" class="account-img-link" title="Xem chi tiết tài khoản #{{ $account->id }}">
                                <img src="{{ $thumb }}" alt="Tài khoản #{{ $account->id }}" class="account-img" {{ $loop->index < 6 ? 'fetchpriority=high decoding=async' : 'loading=lazy decoding=async' }}>
                            </a>
                            
                            <div class="account-badge-code">
                                <i class="fa-solid fa-hashtag"></i> {{ $account->id }}
                            </div>

                            @if($discountRatio > 0)
                                <div class="account-badge-tag badge-discount">-{{ $discountRatio }}%</div>
                            @else
                                <div class="account-badge-tag badge-hot"><i class="fa-solid fa-fire"></i> Random</div>
                            @endif
                        </div>

                        <!-- Card Info / Note -->
                        <div class="account-info">
                            @if(!empty($account->note))
                                <div style="color: #64748b; font-size: 0.76rem; line-height: 1.35; padding: 4px 2px;">
                                    <span style="font-weight: 700; color: #0f172a;"><i class="fa-solid fa-circle-info" style="color: #3b82f6;"></i> Mô tả:</span> 
                                    {{ Str::limit($account->note, 50) }}
                                </div>
                            @else
                                <div style="color: #64748b; font-size: 0.76rem; line-height: 1.35; padding: 4px 2px;">
                                    <span style="font-weight: 700; color: #16a34a;"><i class="fa-solid fa-check-circle"></i> Tỉ lệ 100% trúng acc chuẩn VIP</span>
                                </div>
                            @endif
                        </div>

                        <!-- Pricing Section -->
                        <div class="account-pricing-section">
                            <div class="price-atm-wrap">
                                <span class="price-label-atm">ATM / Ví Momo</span>
                                <span class="price-value-atm">{{ number_format($account->price) }}<small>đ</small></span>
                            </div>
                            <div class="price-card-wrap">
                                <span class="price-label-card">Thẻ cào</span>
                                <span class="price-value-card">{{ number_format($cardPrice) }}đ</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="account-actions-btns">
                            <a href="{{ route('random.account.show', ['id' => $account->id]) }}" class="btn-card-action btn-card-detail">
                                <i class="fa-solid fa-eye"></i> Chi tiết
                            </a>
                            <a href="{{ route('random.account.show', ['id' => $account->id]) }}" class="btn-card-action btn-card-buy">
                                <i class="fa-solid fa-bolt"></i> Mua ngay
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="no-data-empty" style="text-align: center; padding: 60px 0; grid-column: 1 / -1; width: 100%;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px; color: #a0aec0; margin-bottom: 16px;">
                            <path d="M21 8v13H3V8"></path>
                            <path d="M1 3h22v5H1z"></path>
                            <path d="M10 12h4v4h-4z"></path>
                        </svg>
                        <p style="color: #a0aec0; font-size: 1rem; margin: 0;">Chưa có tài khoản nào trong danh mục này</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center; width: 100%; margin-top: 24px;">
                {{ $accounts->links('user.pagination.custom') }}
            </div>
        </div>
    </section>
@endsection
