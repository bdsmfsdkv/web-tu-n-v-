<?php $__env->startSection('title', $title ?? 'Cài đặt hệ thống'); ?>

<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="row align-items-center mb-4">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0"><i class="ti ti-settings me-2"></i>Cài đặt hệ thống</h2>
                        <p class="text-muted">Quản lý cấu hình website và hệ thống</p>
                    </div>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-triangle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Tabs Navigation -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body p-2">

                    <ul class="nav nav-pills flex-wrap gap-2" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo e(session('tab', 'general') === 'general' ? 'active' : ''); ?>" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                <i class="ti ti-settings me-1"></i> Chung
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo e(session('tab') === 'social' ? 'active' : ''); ?>" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">
                                <i class="ti ti-share me-1"></i> Mạng xã hội
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo e(session('tab') === 'email' ? 'active' : ''); ?>" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab">
                                <i class="ti ti-mail me-1"></i> Email & SMTP
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo e(session('tab') === 'payment' ? 'active' : ''); ?>" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab">
                                <i class="ti ti-credit-card me-1"></i> Thanh toán
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo e(session('tab') === 'login' ? 'active' : ''); ?>" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
                                <i class="ti ti-login me-1"></i> Đăng nhập MXH
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo e(session('tab') === 'terms' ? 'active' : ''); ?>" id="terms-tab" data-bs-toggle="tab" data-bs-target="#terms" type="button" role="tab">
                                <i class="ti ti-file-text me-1"></i> Điều khoản
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tabs Content -->
            <div class="tab-content" id="settingsTabsContent">
                <div class="tab-pane fade <?php echo e(session('tab', 'general') === 'general' ? 'show active' : ''); ?>" id="general" role="tabpanel">
                    <?php echo $__env->make('admin.settings.partials.general', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(session('tab') === 'social' ? 'show active' : ''); ?>" id="social" role="tabpanel">
                    <?php echo $__env->make('admin.settings.partials.social', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(session('tab') === 'email' ? 'show active' : ''); ?>" id="email" role="tabpanel">
                    <?php echo $__env->make('admin.settings.partials.email', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(session('tab') === 'payment' ? 'show active' : ''); ?>" id="payment" role="tabpanel">
                    <?php echo $__env->make('admin.settings.partials.payment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(session('tab') === 'login' ? 'show active' : ''); ?>" id="login" role="tabpanel">
                    <?php echo $__env->make('admin.settings.partials.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(session('tab') === 'terms' ? 'show active' : ''); ?>" id="terms" role="tabpanel">
                    <?php echo $__env->make('admin.settings.partials.terms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            
                    
</div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>