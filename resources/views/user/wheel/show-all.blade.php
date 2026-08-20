@extends('layouts.user.app')
@section('title', $title)
@section('content')
    <x-hero-header title="VÒNG QUAY MAY MẮN" description="Danh sách các vòng quay may mắn" />

    <section class="section" style="padding-top: 40px;">
        <div class="container">
            <div class="category-grid">
                @if ($categories->count() > 0)
                    @foreach ($categories as $category)
                        @if ($category->active)
                            <a href="{{ route('lucky.index', ['slug' => $category->slug]) }}" class="category-card" style="position: relative;">
                                <div class="category-img">
                                    <img src="{{ asset($category->thumbnail) }}" alt="{{ $category->name }}">
                                </div>
                                <div class="category-body" style="display: flex; flex-direction: column;">
                                    <div class="category-name">{{ $category->name }}</div>
                                    <div class="category-count" style="display:flex;gap:8px;font-size:0.8rem;margin-bottom:10px;">
                                        <span style="color:#64748b;">Đã quay: {{ number_format($category->soldCount) }}</span>
                                    </div>
                                    <div style="color: var(--primary); font-weight: 700; font-size: 1.1rem; margin-bottom: 12px;">
                                        {{ number_format($category->price_per_spin) }}đ / 1 lượt
                                    </div>
                                    <div class="category-cta-wrapper">
                                        @if(config_get('site_view_all_image'))
                                            <img src="{{ asset(config_get('site_view_all_image')) }}" alt="Xem ngay" class="category-cta-img">
                                        @else
                                            <span class="category-btn-cta">
                                                <span>Xem ngay</span>
                                                <i class="fa-solid fa-arrow-right cta-icon"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                @else
                    <div class="empty-state" style="text-align: center; padding: 60px 20px; width: 100%; grid-column: 1/-1;">
                        <span class="iconify" data-icon="bx:box" style="font-size: 48px; color: #94a3b8; margin-bottom: 12px; display: inline-block;"></span>
                        <div style="color: #94a3b8; font-size: 0.95rem;">Chưa có vòng quay nào</div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
