<?php $__env->startSection('title', 'Quên mật khẩu'); ?>

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
    .password-help-text {
        margin: -5px 0 18px;
        color: #64748b;
        font-size: .78rem;
        line-height: 1.55;
    }
    .password-alert {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 16px;
        padding: 11px 38px 11px 12px;
        font-size: .82rem;
        line-height: 1.45;
        border-radius: 10px;
    }
    .password-alert.success { color: #166534; background: #f0fdf4; border: 1px solid #bbf7d0; }
    .password-alert.error { color: #b91c1c; background: #fef2f2; border: 1px solid #fecaca; }
    .password-alert-close {
        position: absolute;
        top: 7px;
        right: 8px;
        width: 25px;
        height: 25px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: inherit;
        background: transparent;
        border: 0;
        border-radius: 50%;
        cursor: pointer;
    }
    .password-local-test {
        margin: -2px 0 16px;
        padding: 12px;
        color: #1e3a8a;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        font-size: .8rem;
        line-height: 1.5;
    }
    .password-local-test strong { display: block; margin-bottom: 6px; }
    .password-local-test a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 11px;
        color: #fff;
        background: #2563eb;
        border-radius: 8px;
        font-weight: 700;
        text-decoration: none;
    }
    .password-local-test code {
        display: block;
        margin-top: 8px;
        padding: 7px 8px;
        color: #334155;
        background: rgba(255,255,255,.7);
        border-radius: 7px;
        overflow-wrap: anywhere;
        word-break: break-all;
        user-select: all;
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
    [data-theme="dark"] .password-help-text,
    [data-theme="dark"] .password-back-link { color: #a3a3a3; }
    [data-theme="dark"] .password-local-test { color: #bfdbfe; background: #172554; border-color: #1e40af; }
    [data-theme="dark"] .password-local-test code { color: #cbd5e1; background: rgba(15,23,42,.65); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="auth-card password-recovery-card">
        <div class="auth-header">
            <div class="password-recovery-icon">
                <i class="fa-solid fa-key"></i>
            </div>
            <h1 class="auth-title">Quên Mật Khẩu</h1>
            <p class="auth-subtitle">Nhập email đã đăng ký để nhận liên kết đặt lại mật khẩu.</p>
        </div>

        <?php if(session('status')): ?>
            <div class="password-alert success">
                <i class="fa-solid fa-circle-check" style="margin-top:2px;"></i>
                <span><?php echo e(session('status')); ?></span>
                <button type="button" class="password-alert-close" onclick="this.parentElement.remove()" aria-label="Đóng">×</button>
            </div>
        <?php endif; ?>

        <?php if(app()->environment('local') && session('local_reset_url')): ?>
            <div class="password-local-test">
                <strong>Test local — không cần chờ Gmail</strong>
                <a href="<?php echo e(session('local_reset_url')); ?>">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    Mở Trang Đặt Mật Khẩu Mới
                </a>
                <code><?php echo e(session('local_reset_url')); ?></code>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="password-alert error">
                <i class="fa-solid fa-circle-exclamation" style="margin-top:2px;"></i>
                <span><?php echo e(session('error')); ?></span>
                <button type="button" class="password-alert-close" onclick="this.parentElement.remove()" aria-label="Đóng">×</button>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('password.email')); ?>" autocomplete="on">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input id="email"
                       type="email"
                       class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="email"
                       value="<?php echo e(old('email')); ?>"
                       required
                       autofocus
                       autocomplete="email"
                       inputmode="email"
                       autocapitalize="none"
                       autocorrect="off"
                       spellcheck="false"
                       placeholder="vidu@gmail.com">
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

            <p class="password-help-text">
                Liên kết đặt lại mật khẩu sẽ được gửi tới email này. Hãy kiểm tra cả mục Spam/Thư rác nếu chưa thấy thư.
            </p>

            <button type="submit" class="auth-btn">
                <i class="fa-regular fa-paper-plane" style="margin-right:7px;"></i>
                Gửi Liên Kết Đặt Lại Mật Khẩu
            </button>

            <a href="<?php echo e(route('login')); ?>" class="password-back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại đăng nhập
            </a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\auth\forgot-password.blade.php ENDPATH**/ ?>