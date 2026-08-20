@extends('layouts.user.app')

@section('title', $category->name)

@push('css')
<style>
    /* Account attributes: keep every label/value readable and aligned. */
    html body .account-card .account-info {
        padding: 14px !important;
        min-width: 0 !important;
    }

    html body .account-card .account-details-grid {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 10px !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 0 !important;
    }

    html body .account-card .account-detail-tile {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        width: 100% !important;
        min-width: 0 !important;
        min-height: 76px !important;
        margin: 0 !important;
        padding: 9px 10px !important;
        gap: 5px !important;
        text-align: center !important;
        background: linear-gradient(145deg, #ffffff 0%, #f7f9ff 100%) !important;
        border: 1px solid #e6eaf2 !important;
        border-radius: 10px !important;
        box-shadow: 0 3px 10px rgba(15, 23, 42, .045) !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
        transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease !important;
    }

    html body .account-card .account-detail-label {
        display: block !important;
        width: 100% !important;
        min-width: 0 !important;
        margin: 0 !important;
        color: #64748b !important;
        font-size: .76rem !important;
        font-weight: 700 !important;
        line-height: 1.25 !important;
        text-align: center !important;
        white-space: normal !important;
        overflow-wrap: anywhere !important;
    }

    html body .account-card .account-detail-value {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        margin: 0 !important;
        color: #111827 !important;
        font-size: .98rem !important;
        font-weight: 800 !important;
        line-height: 1.3 !important;
        text-align: center !important;
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: clip !important;
        overflow-wrap: anywhere !important;
        word-break: normal !important;
    }

    @media (hover: hover) and (pointer: fine) {
        html body .account-card .account-detail-tile:hover {
            transform: translateY(-2px) !important;
            border-color: rgba(220, 38, 38, .24) !important;
            box-shadow: 0 7px 16px rgba(15, 23, 42, .08) !important;
        }
    }

    @media (max-width: 520px) {
        html body .account-card .account-details-grid {
            grid-template-columns: 1fr !important;
            gap: 8px !important;
        }

        html body .account-card .account-detail-tile {
            min-height: 62px !important;
        }
    }

    [data-theme="dark"] body .account-card .account-detail-tile {
        background: #202020 !important;
        border-color: #303030 !important;
        box-shadow: none !important;
    }

    [data-theme="dark"] body .account-card .account-detail-label {
        color: #9ca3af !important;
    }

    [data-theme="dark"] body .account-card .account-detail-value {
        color: #f3f4f6 !important;
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <x-hero-header title="{{ $category->name }}" description="{{ $category->description }}" />

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

                @php
                    $presetAttrs = [];
                    if (isset($presetConfig) && isset($presetConfig['attributes'])) {
                        foreach ($presetConfig['attributes'] as $attr) {
                            $presetAttrs[$attr['key']] = $attr;
                        }
                    }
                @endphp

                @foreach($dynamicKeys as $key)
                    @php
                        $attrMeta = $presetAttrs[$key] ?? null;
                        $hasOptions = $attrMeta && !empty($attrMeta['options']);
                        $currentVal = request("details.{$key}");
                    @endphp

                    @if($hasOptions)
                        <select name="details[{{ $key }}]" class="filter-select">
                            <option value="">{{ $attrMeta['label'] ?? $key }} (Tất cả)</option>
                            @foreach($attrMeta['options'] as $opt)
                                <option value="{{ $opt }}" {{ $currentVal == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" name="details[{{ $key }}]" class="filter-input" placeholder="Tìm {{ $key }}..." value="{{ $currentVal }}">
                    @endif
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
                                <div class="account-row account-details-grid">
                                    @foreach(array_slice($details, 0, 6) as $detail)
                                        <div class="info-item account-detail-tile">
                                            <span class="info-item__title account-detail-label">{{ $detail['key'] ?? '' }}:</span>
                                            <span class="info-value account-detail-value" title="{{ $detail['value'] ?? '' }}">{{ $detail['value'] ?? '' }}</span>
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
