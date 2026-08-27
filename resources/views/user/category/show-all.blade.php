@extends('layouts.user.app')
@section('title', $title)

@push('css')
<style>
    @media (max-width: 520px) {
        section[id^="categories-"] .category-img { aspect-ratio: 4 / 3; }
        section[id^="categories-"] .category-img img { object-fit: contain; }
    }
</style>
@endpush

@section('content')
    <x-hero-header title="DANH MỤC GAME" description="Danh sách các danh mục tài khoản game" />

    @php
        $groupedCategories = [];
        if (isset($gameGroups)) {
            foreach($gameGroups as $gg) {
                $groupedCategories[trim($gg->name)] = collect([]);
            }
        }
        
        foreach($categories as $category) {
            if ($category->gameGroup) {
                $groupName = trim($category->gameGroup->name);
                if (!isset($groupedCategories[$groupName])) {
                    $groupedCategories[$groupName] = collect([]);
                }
                $groupedCategories[$groupName]->push($category);
            } else {
                $groupName = $category->platform ? trim($category->platform) : 'Danh Mục Game';
                if (!isset($groupedCategories[$groupName])) {
                    $groupedCategories[$groupName] = collect([]);
                }
                $groupedCategories[$groupName]->push($category);
            }
        }
    @endphp

    @if ($categories->count() > 0)
        @foreach ($groupedCategories as $platform => $group)
            @if($group->count() > 0)
                @php
                    $targetGroupUrl = $group->count() === 1
                        ? ($group->first()->url ?? route('category.index', ['slug' => $group->first()->slug]))
                        : route('category.group', ['slug' => Str::slug($platform)]);
                @endphp
                <section class="section" id="categories-{{ Str::slug($platform) }}" style="padding-top: {{ $loop->first ? '20px' : '40px' }};">
                    <div class="container">
                        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h2 class="section-title" style="margin-bottom: 0;">{{ $platform }}</h2>
                            <a href="{{ $targetGroupUrl }}" style="color: var(--primary); font-weight: 600; font-size: 0.95rem; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                                Xem tất cả <span>&rarr;</span>
                            </a>
                        </div>
                        <div class="category-grid">
                            @foreach ($group as $category)
                                @if ($category->active)
                                    @php
                                        $categoryUrl = ($category instanceof \App\Models\RandomCategory) || (!empty($category->is_random))
                                            ? route('random.index', ['slug' => $category->slug])
                                            : route('category.index', ['slug' => $category->slug]);
                                    @endphp
                                    <a href="{{ $categoryUrl }}" class="category-card" style="position: relative;">
                                        @if(isset($category->tag_image) && $category->tag_image)
                                        <img src="{{ $category->tag_image }}" alt="Tag" style="position: absolute; top: 0; right: 0; max-width: 60px; z-index: 10;" loading="lazy" decoding="async">
                                        @endif
                                        <div class="category-img">
                                             <img src="{{ asset($category->thumbnail) }}" alt="{{ $category->name }}" loading="lazy" decoding="async">
                                        </div>
                                        <div class="category-body">
                                            <div class="category-name">{{ $category->name }}</div>
                                            <div class="category-count">
                                                <span class="badge-stock"><i class="fa-solid fa-box-open me-1"></i> Còn: <strong>{{ number_format($category->allAccount) }}</strong></span>
                                                <span class="badge-sold"><i class="fa-solid fa-cart-shopping me-1"></i> Đã bán: <strong>{{ number_format($category->soldCount) }}</strong></span>
                                            </div>
                                            <div class="category-cta-wrapper">
                                                @if(config_get('site_view_all_image'))
                                                    <img src="{{ asset(config_get('site_view_all_image')) }}" alt="Xem ngay" class="category-cta-img">
                                                @else
                                                    <span class="category-btn-cta">
                                                        <span>XEM NGAY</span>
                                                        <i class="fa-solid fa-arrow-right cta-icon"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @else
        <section class="section" style="padding-top: 40px;">
            <div class="container">
                <div class="empty-state" style="text-align: center; padding: 80px 20px; width: 100%;">
                    <span class="iconify" data-icon="bx:box" style="font-size: 48px; color: #94a3b8; margin-bottom: 12px; display: inline-block;"></span>
                    <div style="color: #94a3b8; font-size: 0.95rem;">Chưa có tài khoản nào</div>
                </div>
            </div>
        </section>
    @endif
@endsection
