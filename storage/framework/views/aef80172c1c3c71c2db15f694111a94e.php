<?php $__env->startSection('title', 'Đặt lại mật khẩu'); ?>

<?php $__env->startPush('css'); ?>
<style>
    .password-recovery-card .auth-header { margin-bottom: 22px !important; }
    .password-recovery-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc2626;
        font-size: 1.45rem;
        background: #fff1f2;
        border: 1px solid #fecdd3;
        border-radius: 18px;
        box-shadow: 0 8px 20px rgba(220,38,38,.08);
    }
    .password-readonly {
        background: #f8fafc !important;
        color: #64748b !important;
        cursor: default;
    }
    .password-back-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        margin-top: 16px;
        color: #64748b;
        font-size: .84rem;
        font-weight: 650;
        text-decoration: none;
    }
    .password-back-link:hover { color: #dc2626; }
    [data-theme="dark"] .password-recovery-icon { background: #2a1718; border-color: #4b2427; }
    [data-theme="dark"] .password-readonly { background: #202020 !important; color: #a3a3a3 !important; }
    [data-theme="dark"] .password-back-link { color: #a3a3a3; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="auth-card password-recovery-card">
        <div class="auth-header">
            <div class="password-recovery-icon">
                <i class="fa-solid fa-lock-open"></i>
            </div>
            <h1 class="auth-title">Đặt Lại Mật Khẩu</h1>
            <p class="auth-subtitle">Tạo mật khẩu mới cho tài khoản của bạn.</p>
        </div>

        <form method="POST" action="<?php echo e(route('password.store')); ?>" autocomplete="on">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="token" value="<?php echo e($request->route('token')); ?>">

            <div class="form-group">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input id="email"
                       type="email"
                       class="form-input password-readonly <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="email"
                       value="<?php echo e(old('email', $request->email)); ?>"
                       required
                       readonly
                       autocomplete="email">
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
                <label for="password" class="form-label">Mật khẩu mới</label>
                <input id="password"
                       type="password"
                       class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="password"
                       required
                       autofocus
                       autocomplete="new-password"
                       placeholder="Nhập mật khẩu mới">
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
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                <input id="password_confirmation"
                       type="password"
                       class="form-input"
                       name="password_confirmation"
                       required
                       autocomplete="new-password"
                       placeholder="Nhập lại mật khẩu mới">
            </div>

            <button type="submit" class="auth-btn">
                <i class="fa-solid fa-shield-halved" style="margin-right:7px;"></i>
                Cập Nhật Mật Khẩu
            </button>

            <a href="<?php echo e(route('login')); ?>" class="password-back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại đăng nhập
            </a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\auth\reset-password.blade.php ENDPATH**/ ?>