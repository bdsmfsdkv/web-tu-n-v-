<?php $__env->startSection('title', 'Nhận xét của khách hàng'); ?>
<?php $__env->startSection('content'); ?>

<div class="container" style="margin-top: 30px; margin-bottom: 40px;">
    <div class="section-header" style="text-align:center; margin-bottom: 25px;">
        <h2 class="section-title" style="display:inline-block; font-size: 1.5rem; justify-content: center; width: 100%;">
            <span class="iconify" data-icon="ant-design:star-filled" style="color:#faad14; font-size: 1.6rem; vertical-align: middle;"></span> 
            Nhận xét của khách hàng khi sử dụng dịch vụ tại shop 
            <span class="iconify" data-icon="ant-design:star-filled" style="color:#faad14; font-size: 1.6rem; vertical-align: middle;"></span>
        </h2>
    </div>

    <div style="margin-bottom: 15px; font-weight: 600; color: #4b5563;">
        <?php if(isset($purchases) && $purchases->total() > 0): ?>
            Tổng có <?php echo e($purchases->total() + 110); ?> đánh giá
        <?php else: ?>
            Tổng có 118 đánh giá
        <?php endif; ?>
    </div>

    <div class="review-grid">
        <?php
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
        ?>

        <?php $__currentLoopData = $displayReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="review-card">
                <div class="review-header">
                    <img src="<?php echo e($review['avatar']); ?>" alt="Avatar" class="review-avatar" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($review['name'])); ?>&background=random'">
                    <div class="review-info">
                        <div class="review-name"><?php echo e($review['name']); ?></div>
                        <div class="review-meta">
                            <span class="review-stars">
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                                <span class="iconify" data-icon="ant-design:star-filled"></span>
                            </span>
                            <span class="review-id">đã mua nick <?php echo e($review['id']); ?></span>
                        </div>
                    </div>
                </div>
                <div class="review-text"><?php echo e($review['text']); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if(isset($purchases) && $purchases->hasPages()): ?>
        <div style="margin-top: 30px;">
            <?php echo e($purchases->links()); ?>

        </div>
    <?php elseif(!isset($purchases) || !$purchases->hasPages()): ?>
        <!-- Dummy Pagination if not enough real data -->
        <div style="margin-top: 30px;" class="custom-pagination">
            <nav>
                <ul class="pagination">
                    <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; Previous">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                    <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                    <li class="page-item"><a class="page-link" href="?page=2">2</a></li>
                    <li class="page-item"><a class="page-link" href="?page=3">3</a></li>
                    <li class="page-item"><a class="page-link" href="?page=4">4</a></li>
                    <li class="page-item"><a class="page-link" href="?page=5">5</a></li>
                    <li class="page-item"><a class="page-link" href="?page=6">6</a></li>
                    <li class="page-item">
                        <a class="page-link" href="?page=2" rel="next" aria-label="Next &raquo;">&rsaquo;</a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\user\reviews.blade.php ENDPATH**/ ?>