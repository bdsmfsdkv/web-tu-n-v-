@extends('layouts.user.app')

@section('title', $category->name)

@section('content')
    <!-- Hero Section -->
    <x-hero-header title="{{ $category->name }}" description="{{ $category->description }}" />

    <!-- Account List Section -->
    <section class="account-section">
        <div class="container">
            <!-- Filter Bar -->
            <form action="" method="GET" class="filter-inline-bar">
                <input type="text" name="code" class="filter-input" placeholder="Mã số..." value="{{ request('code') }}">
                
                <input type="number" name="price_from" class="filter-input" placeholder="Giá từ..." value="{{ request('price_from') }}">
                <input type="number" name="price_to" class="filter-input" placeholder="Giá đến..." value="{{ request('price_to') }}">

                @foreach($dynamicKeys as $key)
                    <input type="text" name="details[{{ $key }}]" class="filter-input" placeholder="Tìm {{ $key }}..." value="{{ request("details.{$key}") }}">
                @endforeach

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
                            <a href="{{ route('account.show', ['id' => $account->id]) }}">
                                <img src="{{ $account->thumb }}" alt="Account Preview" class="account-img">
                            </a>
                            <div class="account-code">Mã số: {{ $account->id }}</div>
                            <div class="account-price-top">ATM/VÍ ĐIỆN TỬ: {{ number_format($account->price) }} VND</div>
                        </div>

                        <div class="account-info">
                            @php
                                $details = is_array($account->details) ? $account->details : json_decode($account->details, true) ?? [];
                            @endphp
                            
                            @if(count($details) > 0)
                                <div class="account-row" style="flex-wrap: wrap; gap: 16px 8px; margin-bottom: 8px; border: none;">
                                    @foreach(array_slice($details, 0, 4) as $detail)
                                    <div class="info-item" style="width: 45%;">
                                        <span class="info-item__title">{{ $detail['key'] ?? '' }}:</span>
                                        <span class="info-value">{{ $detail['value'] ?? '' }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="account-actions">
                            <div class="card-price">CARD:
                                {{ number_format($account->price / ((100 - config_get('payment.card.discount_percent')) / 100)) }}
                                Đ</div>
                            <a href="{{ route('account.show', ['id' => $account->id]) }}"
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
