<?php $__env->startSection('title', 'Đăng nhập'); ?>

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

        <form method="POST" action="<?php echo e(route('login')); ?>" autocomplete="on" novalidate>
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="username" class="form-label">Tên tài khoản hoặc Email</label>
                <input id="username"
                       type="text"
                       class="form-input"
                       name="username"
                       value="<?php echo e(old('username')); ?>"
                       required
                       autofocus
                       autocomplete="email"
                       inputmode="email"
                       autocapitalize="none"
                       autocorrect="off"
                       spellcheck="false"
                       placeholder="Nhập tên tài khoản hoặc email">
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
                <input id="password"
                       type="password"
                       class="form-input"
                       name="password"
                       required
                       autocomplete="off"
                       data-lpignore="true"
                       data-form-type="other"
                       placeholder="••••••••">
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

            <button type="submit" class="auth-btn">Đăng Nhập</button>
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

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\user\login.blade.php ENDPATH**/ ?>