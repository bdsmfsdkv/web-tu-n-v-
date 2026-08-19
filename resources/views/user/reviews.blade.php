@extends('layouts.user.app')
@section('title', 'Nhận xét của khách hàng')
@section('content')

<div class="container" style="margin-top: 30px; margin-bottom: 40px;">
    <div class="section-header" style="text-align:center; margin-bottom: 25px;">
        <h2 class="section-title" style="display:inline-block; font-size: 1.5rem; justify-content: center; width: 100%;">
            <span class="iconify" data-icon="ant-design:star-filled" style="color:#faad14; font-size: 1.6rem; vertical-align: middle;"></span> 
            Nhận xét của khách hàng khi sử dụng dịch vụ tại shop 
            <span class="iconify" data-icon="ant-design:star-filled" style="color:#faad14; font-size: 1.6rem; vertical-align: middle;"></span>
        </h2>
    </div>

    <div style="margin-bottom: 15px; font-weight: 600; color: #4b5563;">
        @if(isset($purchases) && $purchases->total() > 0)
            Tổng có {{ $purchases->total() + 110 }} đánh giá
        @else
            Tổng có 118 đánh giá
        @endif
    </div>

    <div class="review-grid">
        @php
            $fakeTexts = [
                'Giao dịch nhanh gọn, uy tín',
                'Đã ủng hộ lần t2 rất uy tín ok',
                'Sản phẩm chất lượng.',
                'Acc ngon, giá rẻ',
                'Nhân viên hỗ trợ nhiệt tình',
                'Lần tới sẽ ủng hộ tiếp',
                'Sản phẩm chất lượng, quá đỉnh',
                'Ok....'
            ];
            $displayReviews = [];
            
            // Lấy từ DB
            if(isset($purchases) && count($purchases) > 0) {
                foreach($purchases as $purchase) {
                    $username = $purchase->user ? $purchase->user->username : 'KhachHang';
                    $maskedName = substr($username, 0, 3) . '****' . substr($username, -2);
                    $displayReviews[] = [
                        'name' => $maskedName,
                        'id' => $purchase->game_account_id ?? rand(10000, 99999),
                        'text' => $fakeTexts[array_rand($fakeTexts)],
                        'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'
                    ];
                }
            }
            
            // Bù thêm dummy nếu trang này ít
            if(count($displayReviews) < 24) {
                $staticNames = ['thi****00', 'Trà****nh', 'Kha****ai', 'Kha****ai', 'kho****55', 'djv****12', 'Min****ận', 'Min****ận', 'Trà****áo', 'tru****02', 'tru****02', 'sew****ya', 'nuk****ne', 'Har****oa', 'Ngu****ng', 'dai****45', 'kie****an', 'kie****an', 'hao****11', 'Luu****22', 'Tan****99', 'Phi****88', 'Hai****77', 'Son****66'];
                
                $needed = 24 - count($displayReviews);
                for($i = 0; $i < $needed; $i++) {
                    $displayReviews[] = [
                        'name' => $staticNames[array_rand($staticNames)],
                        'id' => rand(10000, 99999),
                        'text' => $fakeTexts[array_rand($fakeTexts)],
                        'avatar' => 'https://shoptrautft.com/unknown-avatar.jpeg'
                    ];
                }
            }
        @endphp

        @foreach($displayReviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <img src="{{ $review['avatar'] }}" alt="Avatar" class="review-avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($review['name']) }}&background=random'">
                    <div class="review-info">
                        <div class="review-name">{{ $review['name'] }}</div>
                        <div class="review-meta">
                            <span class="review-stars">
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                            </span>
                            <span class="review-id">đã mua nick {{ $review['id'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="review-text">{{ $review['text'] }}</div>
            </div>
        @endforeach
    </div>

    @if(isset($purchases) && $purchases->hasPages())
        <div style="margin-top: 30px;">
            {{ $purchases->links('user.pagination.custom') }}
        </div>
    @elseif(!isset($purchases) || !$purchases->hasPages())
        <!-- Dummy Pagination if not enough real data -->
        <div style="display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 24px; flex-wrap: wrap;">
            <span style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.2); color:rgba(255, 255, 255, 0.4); font-size:0.9rem; cursor:not-allowed; background: transparent;">&laquo;</span>
            <span style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; background:#1d4ed8; color:#ffffff; font-weight:700; font-size:0.95rem; border:1px solid #1d4ed8; box-shadow: 0 4px 6px -1px rgba(29, 78, 216, 0.5);">1</span>
            <a href="?page=2" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.3); color:#3b82f6; font-size:0.95rem; text-decoration:none; transition:all 0.2s; background: transparent;" onmouseover="this.style.background='rgba(59, 130, 246, 0.1)';this.style.borderColor='#3b82f6';" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255, 255, 255, 0.3)';">2</a>
            <a href="?page=3" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.3); color:#3b82f6; font-size:0.95rem; text-decoration:none; transition:all 0.2s; background: transparent;" onmouseover="this.style.background='rgba(59, 130, 246, 0.1)';this.style.borderColor='#3b82f6';" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255, 255, 255, 0.3)';">3</a>
            <a href="?page=4" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.3); color:#3b82f6; font-size:0.95rem; text-decoration:none; transition:all 0.2s; background: transparent;" onmouseover="this.style.background='rgba(59, 130, 246, 0.1)';this.style.borderColor='#3b82f6';" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255, 255, 255, 0.3)';">4</a>
            <a href="?page=2" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.3); color:#3b82f6; font-size:0.9rem; text-decoration:none; transition:all 0.2s; background: transparent;" onmouseover="this.style.background='rgba(59, 130, 246, 0.1)';this.style.borderColor='#3b82f6';" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255, 255, 255, 0.3)';">&raquo;</a>
        </div>
    @endif
</div>

<style>
    .review-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) {
        .review-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .review-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .review-grid { grid-template-columns: 1fr; }
    }
    .review-card {
        background: #fff;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .review-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    [data-theme="dark"] .review-card {
        background: #1f1f1f;
        border-color: #333;
    }
    .review-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    .review-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    .review-info {
        flex: 1;
    }
    .review-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1f2937;
        margin-bottom: 4px;
    }
    [data-theme="dark"] .review-name {
        color: #f3f4f6;
    }
    .review-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
    }
    .review-stars {
        color: #faad14;
        display: flex;
        gap: 2px;
    }
    .review-id {
        color: #9ca3af;
    }
    .review-text {
        font-size: 0.9rem;
        color: #4b5563;
        line-height: 1.5;
    }
    [data-theme="dark"] .review-text {
        color: #9ca3af;
    }

    /* Fake Pagination styles since standard laravel pagination might need bootstrap */
    .custom-pagination .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        gap: 5px;
    }
    .custom-pagination .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #374151;
        background-color: #fff;
        border: none;
        font-weight: 500;
    }
    .custom-pagination .page-item.active .page-link {
        z-index: 3;
        color: red;
        background-color: transparent;
        font-weight: bold;
    }
    .custom-pagination .page-item:not(.active) .page-link:hover {
        color: red;
        background-color: #f3f4f6;
        border-radius: 4px;
    }
    [data-theme="dark"] .custom-pagination .page-link {
        background-color: #1f1f1f;
        color: #d1d5db;
    }
    [data-theme="dark"] .custom-pagination .page-item.active .page-link {
        color: #ef4444;
    }
    [data-theme="dark"] .custom-pagination .page-item:not(.active) .page-link:hover {
        background-color: #374151;
        color: #ef4444;
    }
</style>
@endsection
