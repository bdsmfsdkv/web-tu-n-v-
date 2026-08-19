

<?php $__env->startSection('title', 'Đăng nhập'); ?>

<?php $__env->startPush('css'); ?>
<style>
    .auth-page {
        min-height: calc(100vh - 64px - 300px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background-color: transparent;
    }
    .auth-card {
        background: #fff;
        width: 100%;
        max-width: 420px;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        padding: 32px;
        border: 1px solid #e5e7eb;
    }
    .auth-header {
        text-align: center;
        margin-bottom: 24px;
    }
    .auth-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 8px 0;
    }
    .auth-subtitle {
        color: #666;
        font-size: 0.9rem;
        margin: 0;
    }
    .form-group {
        margin-bottom: 16px;
    }
    .form-label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 6px;
        color: #333;
    }
    .form-input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #d9d9d9;
        font-size: 0.9rem;
        transition: all 0.2s;
        outline: none;
    }
    .form-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px var(--primary-glow);
    }
    .form-error {
        color: #dc2626;
        font-size: 0.8rem;
        margin-top: 4px;
        display: block;
    }
    .auth-btn {
        width: 100%;
        padding: 12px;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 8px;
    }
    .auth-btn:hover {
        background: var(--primary-dark);
    }
    .auth-links {
        text-align: center;
        margin-top: 20px;
        font-size: 0.85rem;
    }
    .auth-links a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }
    .auth-links a:hover {
        text-decoration: underline;
    }
    .social-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 24px 0;
        color: #999;
        font-size: 0.8rem;
    }
    .social-divider::before, .social-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e5e7eb;
    }
    .social-divider:not(:empty)::before {
        margin-right: .25em;
    }
    .social-divider:not(:empty)::after {
        margin-left: .25em;
    }
    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #333;
        font-weight: 500;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.2s;
        margin-bottom: 10px;
    }
    .social-btn:hover {
        background: #f9f9f9;
        border-color: #d9d9d9;
    }
    .social-btn img {
        width: 20px;
        height: 20px;
    }
    /* Dark Mode */
    [data-theme="dark"] .auth-card {
        background: #171717;
        border-color: #2a2a2a;
    }
    [data-theme="dark"] .auth-title { color: #fff; }
    [data-theme="dark"] .auth-subtitle { color: #999; }
    [data-theme="dark"] .form-label { color: #ccc; }
    [data-theme="dark"] .form-input {
        background: #262626;
        border-color: #404040;
        color: #fff;
    }
    [data-theme="dark"] .social-divider::before, [data-theme="dark"] .social-divider::after {
        border-color: #2a2a2a;
    }
    [data-theme="dark"] .social-btn {
        background: #262626;
        border-color: #404040;
        color: #ccc;
    }
    [data-theme="dark"] .social-btn:hover {
        background: #333;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Đăng Nhập</h1>
            <p class="auth-subtitle">Chào mừng bạn quay trở lại!</p>
        </div>

        <?php if(session('error')): ?>
            <div style="background:#fee2e2;color:#dc2626;padding:12px;border-radius:8px;font-size:0.85rem;margin-bottom:16px;border:1px solid #fecaca;">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="username" class="form-label">Tên tài khoản hoặc Email</label>
                <input id="username" type="text" class="form-input" name="username" value="<?php echo e(old('username')); ?>" required autofocus placeholder="Nhập tài khoản">
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="form-error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" type="password" class="form-input" name="password" required placeholder="••••••••">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="form-error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group" style="display:flex;justify-content:space-between;align-items:center;">
                <div style="display:flex;align-items:center;gap:6px;font-size:0.85rem;">
                    <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?> style="cursor:pointer;">
                    <label for="remember" style="cursor:pointer;color:#666;">Ghi nhớ</label>
                </div>
                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" style="font-size:0.85rem;color:var(--primary);text-decoration:none;">Quên mật khẩu?</a>
                <?php endif; ?>
            </div>

            <button type="submit" class="auth-btn">
                Đăng Nhập
            </button>
        </form>

        <?php if(config_get('login_social.google.active', false) || config_get('login_social.facebook.active', false)): ?>
            <div class="social-divider">Hoặc tiếp tục với</div>
            
            <?php if(config_get('login_social.google.active', false)): ?>
                <a href="<?php echo e(route('auth.google')); ?>" class="social-btn">
                    <span class="iconify" data-icon="flat-color-icons:google" style="font-size:1.2rem;"></span>
                    Google
                </a>
            <?php endif; ?>
            
            <?php if(config_get('login_social.facebook.active', false)): ?>
                <a href="<?php echo e(route('auth.facebook')); ?>" class="social-btn">
                    <span class="iconify" data-icon="logos:facebook" style="font-size:1.2rem;"></span>
                    Facebook
                </a>
            <?php endif; ?>
        <?php endif; ?>

        <div class="auth-links">
            Chưa có tài khoản? <a href="<?php echo e(route('register')); ?>">Đăng ký ngay</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/user/login.blade.php ENDPATH**/ ?>