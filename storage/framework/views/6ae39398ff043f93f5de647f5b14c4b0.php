

<?php $__env->startSection('title', 'Đăng ký tài khoản'); ?>

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
        max-width: 440px;
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
        margin-top: 12px;
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
            <h1 class="auth-title">Đăng Ký Tài Khoản</h1>
            <p class="auth-subtitle">Tạo tài khoản để sử dụng dịch vụ dễ dàng hơn</p>
        </div>

        <?php if (isset($component)) { $__componentOriginal9b1df53224e42948610ceb30d6d57a7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9b1df53224e42948610ceb30d6d57a7c = $attributes; } ?>
<?php $component = App\View\Components\AlertError::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('alert-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AlertError::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9b1df53224e42948610ceb30d6d57a7c)): ?>
<?php $attributes = $__attributesOriginal9b1df53224e42948610ceb30d6d57a7c; ?>
<?php unset($__attributesOriginal9b1df53224e42948610ceb30d6d57a7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9b1df53224e42948610ceb30d6d57a7c)): ?>
<?php $component = $__componentOriginal9b1df53224e42948610ceb30d6d57a7c; ?>
<?php unset($__componentOriginal9b1df53224e42948610ceb30d6d57a7c); ?>
<?php endif; ?>

        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="username" class="form-label">Tên tài khoản</label>
                <input id="username" type="text" class="form-input" name="username" value="<?php echo e(old('username')); ?>" required autofocus placeholder="VD: tuanori">
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
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-input" name="email" value="<?php echo e(old('email')); ?>" required placeholder="VD: example@gmail.com">
                <?php $__errorArgs = ['email'];
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
                <input id="password" type="password" class="form-input" name="password" required placeholder="Tối thiểu 8 ký tự">
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

            <div class="form-group">
                <label for="password-confirm" class="form-label">Xác nhận mật khẩu</label>
                <input id="password-confirm" type="password" class="form-input" name="password_confirmation" required placeholder="Nhập lại mật khẩu">
            </div>

            <button type="submit" class="auth-btn">
                Đăng Ký Ngay
            </button>
        </form>

        <?php if(config_get('login_social.google.active', false) || config_get('login_social.facebook.active', false)): ?>
            <div class="social-divider">Hoặc đăng ký bằng</div>
            
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
            Đã có tài khoản? <a href="<?php echo e(route('login')); ?>">Đăng nhập</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/user/register.blade.php ENDPATH**/ ?>