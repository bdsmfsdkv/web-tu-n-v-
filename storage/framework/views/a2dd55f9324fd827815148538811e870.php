<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-user-circle me-2"></i> THÔNG TIN TÀI KHOẢN</h1>
                </div>

                <div class="profile-content">
                    <?php echo $__env->make('layouts.user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> THÔNG TIN TÀI
                                        KHOẢN</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <style>
                                    .info-content { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
                                    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px dashed #e2e8f0; }
                                    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
                                    .info-row:first-child { padding-top: 0; }
                                    .info-label { color: #64748b; font-weight: 500; font-size: 0.95rem; display: flex; align-items: center; }
                                    .info-label i { width: 24px; color: #94a3b8; }
                                    .info-value { color: #0f172a; font-weight: 600; font-size: 1rem; text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 12px; }
                                    .info-value--highlight { color: #ef4444; font-size: 1.1rem; }
                                    .change-password-link { background: #fef2f2; color: #ef4444; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; text-decoration: none; transition: 0.2s; border: 1px solid #fecaca; }
                                    .change-password-link:hover { background: #fee2e2; color: #dc2626; }
                                    
                                    /* Dark mode */
                                    [data-theme="dark"] .info-content { background: #171717; border: 1px solid #2a2a2a; }
                                    [data-theme="dark"] .info-row { border-bottom-color: #333; }
                                    [data-theme="dark"] .info-label { color: #9ca3af; }
                                    [data-theme="dark"] .info-value { color: #f8fafc; }
                                    [data-theme="dark"] .change-password-link { background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); }
                                    [data-theme="dark"] .change-password-link:hover { background: rgba(239, 68, 68, 0.2); }
                                    
                                    @media (max-width: 576px) {
                                        .info-row { flex-direction: column; align-items: flex-start; gap: 8px; }
                                        .info-value { width: 100%; justify-content: space-between; flex-direction: row-reverse; }
                                    }
                                </style>
                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-id-card me-2"></i> ID tài khoản
                                    </div>
                                    <div class="info-value"><?php echo e($user->id); ?></div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-user me-2"></i> Tên đăng nhập
                                    </div>
                                    <div class="info-value"><?php echo e($user->username); ?></div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-envelope me-2"></i> Email
                                    </div>
                                    <div class="info-value"><?php echo e($user->email); ?></div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-key me-2"></i> Mật khẩu
                                    </div>
                                    <div class="info-value">
                                        ********
                                        <a href="<?php echo e(route('profile.change-password')); ?>" class="change-password-link">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Đổi mật khẩu
                                        </a>
                                    </div>
                                </div>


                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-wallet me-2"></i> Số dư
                                    </div>
                                    <div class="info-value info-value--highlight">
                                        <?php echo e(number_format($user->balance)); ?> VND
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-money-bill-trend-up me-2"></i> Tổng nạp
                                    </div>
                                        <?php echo e(number_format($user->total_deposited)); ?> VND
                                    </div>
                                </div>

                             

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-gem me-2"></i> Vật Phẩm
                                    </div>
                                    <div class="info-value">
                                        <?php echo e(number_format($user->gem)); ?>

                                        <a href="<?php echo e(route('profile.withdraw-gem')); ?>" class="change-password-link">
                                            <i class="fa-solid fa-gem me-1"></i> Rút Vật Phẩm
                                        </a>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-calendar-check me-2"></i> Ngày tạo
                                    </div>
                                    <div class="info-value">
                                        <?php echo e($user->created_at->format('H:i d/m/Y')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\user\profile\profile.blade.php ENDPATH**/ ?>