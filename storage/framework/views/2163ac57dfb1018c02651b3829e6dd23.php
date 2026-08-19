<?php $__env->startSection('title', $title); ?>

<?php $__env->startPush('css'); ?>
<style>
    .news-page {
        padding: 40px 0;
        background-color: transparent;
        min-height: 100vh;
    }
    .news-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .news-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color, #1f2937);
        margin-bottom: 10px;
    }
    .news-header p {
        color: var(--text-muted, #6b7280);
        font-size: 1.1rem;
    }
    
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }
    
    .news-card {
        background: var(--bg-card, #fff);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--border-color, #e5e7eb);
        padding: 12px;
    }
    
    .news-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .news-thumb-wrapper {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
    }

    .news-thumb {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .news-card:hover .news-thumb {
        transform: scale(1.05);
    }
    
    .news-content {
        padding: 16px 4px 4px 4px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .news-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-color, #1f2937);
        margin: 0 0 12px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 0.85rem;
        color: var(--text-muted, #6b7280);
    }
    
    .news-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: var(--bg-card, #fff);
        border-radius: 12px;
        border: 1px solid var(--border-color, #e5e7eb);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--text-muted, #9ca3af);
        margin-bottom: 16px;
    }

    .empty-state h3 {
        color: var(--text-color, #374151);
        margin-bottom: 8px;
    }

    .empty-state p {
        color: var(--text-muted, #6b7280);
    }

    /* Dark mode */
    [data-theme="dark"] .news-card,
    [data-theme="dark"] .empty-state {
        background: #171717;
        border-color: #2a2a2a;
    }
    [data-theme="dark"] .news-header h1,
    [data-theme="dark"] .news-title,
    [data-theme="dark"] .empty-state h3 {
        color: #f9fafb;
    }
    [data-theme="dark"] .news-header p,
    [data-theme="dark"] .news-meta,
    [data-theme="dark"] .empty-state p {
        color: #9ca3af;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="news-page">
    <div class="container">
        <div class="news-header">
            <h1>Tin Tức & Sự Kiện</h1>
            <p>Cập nhật những thông tin, sự kiện và khuyến mãi mới nhất</p>
        </div>

        <?php if($newsList->count() > 0): ?>
            <div class="news-grid">
                <?php $__currentLoopData = $newsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('news.show', $news->slug)); ?>" class="news-card">
                        <div class="news-thumb-wrapper">
                            <img src="<?php echo e($news->thumbnail); ?>" alt="<?php echo e($news->title); ?>" class="news-thumb" onerror="this.src='https://via.placeholder.com/400x200?text=News'">
                        </div>
                        <div class="news-content">
                            <h3 class="news-title"><?php echo e($news->title); ?></h3>
                            <div class="news-meta">
                                <span class="date"><span class="iconify" data-icon="ant-design:calendar-outlined"></span> <?php echo e($news->created_at->format('d/m/Y')); ?></span>
                                <span class="views"><span class="iconify" data-icon="ant-design:eye-outlined"></span> <?php echo e(number_format($news->views)); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="d-flex justify-content-center">
                <?php echo e($newsList->links('pagination::bootstrap-5')); ?>

            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="far fa-newspaper"></i>
                <h3>Chưa có bài viết nào</h3>
                <p>Tin tức và sự kiện sẽ được chúng tôi cập nhật trong thời gian sớm nhất.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\user\news\index.blade.php ENDPATH**/ ?>