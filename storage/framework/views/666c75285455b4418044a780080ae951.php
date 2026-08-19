<?php $__env->startSection('title', $title); ?>

<?php $__env->startPush('css'); ?>
<style>
    .page-container {
        padding: 40px 0;
        min-height: 80vh;
    }
    
    .page-content-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        background: var(--bg-card, #fff);
        border: 1px solid var(--border-color, #e5e7eb);
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--primary, #dc2626);
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color, #1f2937);
        margin: 0;
    }

    .page-body {
        color: var(--text-muted, #4b5563);
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .page-body h1, .page-body h2, .page-body h3, .page-body h4, .page-body h5, .page-body h6 {
        color: var(--text-color, #1f2937);
        margin-top: 1.5em;
        margin-bottom: 0.5em;
        font-weight: 600;
    }

    .page-body p {
        margin-bottom: 1em;
    }

    .page-body ul, .page-body ol {
        margin-bottom: 1em;
        padding-left: 20px;
    }

    .page-body li {
        margin-bottom: 0.5em;
    }

    .page-body a {
        color: var(--primary, #dc2626);
        text-decoration: none;
    }

    .page-body a:hover {
        text-decoration: underline;
    }

    /* Dark mode adjustments */
    [data-theme="dark"] .page-content-wrapper {
        background: #171717;
        border-color: #2a2a2a;
    }
    [data-theme="dark"] .page-title,
    [data-theme="dark"] .page-body h1, 
    [data-theme="dark"] .page-body h2, 
    [data-theme="dark"] .page-body h3 {
        color: #f9fafb;
    }
    [data-theme="dark"] .page-body {
        color: #d1d5db;
    }

    @media (max-width: 768px) {
        .page-content-wrapper {
            padding: 20px;
        }
        .page-title {
            font-size: 1.5rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-container">
    <div class="container">
        <div class="page-content-wrapper">
            <div class="page-header">
                <h1 class="page-title"><?php echo e($title); ?></h1>
            </div>
            
            <div class="page-body">
                <?php echo $content; ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/user/page.blade.php ENDPATH**/ ?>