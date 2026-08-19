@extends('layouts.user.app')

@section('title', $title)

@push('css')
<style>
    .article-page {
        padding: 40px 0;
        background-color: transparent;
        min-height: 100vh;
    }
    
    .article-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted, #6b7280);
        text-decoration: none;
        margin-bottom: 24px;
        font-size: 0.95rem;
        transition: color 0.2s;
    }
    
    .back-link:hover {
        color: var(--primary, #3b82f6);
    }

    .article-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--text-color, #1f2937);
        margin: 0 0 16px 0;
        line-height: 1.3;
    }

    .article-meta {
        display: flex;
        gap: 20px;
        color: var(--text-muted, #6b7280);
        font-size: 0.95rem;
        padding-bottom: 24px;
        margin-bottom: 24px;
        border-bottom: 1px solid var(--border-color, #e5e7eb);
    }

    .article-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .article-content {
        color: var(--text-color, #374151);
        font-size: 1.05rem;
        line-height: 1.8;
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 16px 0;
    }

    /* Dark mode adjustments */
    [data-theme="dark"] .article-title { color: #f9fafb; }
    [data-theme="dark"] .article-content { color: #d1d5db; }
    [data-theme="dark"] .article-meta, [data-theme="dark"] .back-link { color: #9ca3af; }
    [data-theme="dark"] .article-meta { border-color: #2a2a2a; }
    [data-theme="dark"] .back-link:hover { color: #f9fafb; }
</style>
@endpush

@section('content')
<div class="article-page">
    <div class="container">
        <div class="article-container">
            <a href="{{ route('news.index') }}" class="back-link">
                <span class="iconify" data-icon="ant-design:arrow-left-outlined"></span> Quay lại tin tức
            </a>

            <h1 class="article-title">{{ $news->title }}</h1>
            
            <div class="article-meta">
                <span title="Ngày đăng"><span class="iconify" data-icon="ant-design:calendar-outlined"></span> {{ $news->created_at->format('d/m/Y') }}</span>
                <span title="Lượt xem"><span class="iconify" data-icon="ant-design:eye-outlined"></span> {{ number_format($news->views) }} lượt xem</span>
            </div>

            <div class="article-content">
                {!! $news->content !!}
            </div>
        </div>
    </div>
</div>
@endsection
