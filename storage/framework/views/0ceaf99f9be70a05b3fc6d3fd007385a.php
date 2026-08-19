<section class="page-title-section">
    <div class="container">
        <?php if(!isset($hideBreadcrumb) || !$hideBreadcrumb): ?>
        <!-- Breadcrumb -->
        <div class="page-breadcrumb">
            <a href="/" class="breadcrumb-link"><i class="fas fa-home"></i> Trang Chủ</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current"><?php echo e($title); ?></span>
        </div>
        <?php endif; ?>

        <!-- Title -->
        <h1 class="page-title-heading">
            <span class="title-bar"></span>
            <?php echo e($title); ?>

        </h1>

        <!-- Description Box -->
        <?php if(isset($description) && $description): ?>
            <div class="page-desc-box">
                <?php echo $description; ?>

            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\components\hero-header.blade.php ENDPATH**/ ?>