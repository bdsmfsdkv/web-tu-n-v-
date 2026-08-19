<!DOCTYPE html>
<html lang="vi"data-theme="light">
<?php echo $__env->make('layouts.admin.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="dark" style=""> 
    <div class="loader-bg">
        <div class="loader-track"><div class="loader-fill"></div></div>
    </div>
    
    <div class="main-wrapper">
        <?php echo $__env->make('layouts.admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.admin.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="pc-container">
            <div class="pc-content">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <?php echo $__env->make('layouts.admin.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/layouts/admin/app.blade.php ENDPATH**/ ?>