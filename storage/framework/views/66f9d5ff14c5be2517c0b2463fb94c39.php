<?php $__env->startSection('title', 'Quên mật khẩu'); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/auth.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="register-section">
        <div class="container">
            <div class="register-container">
                <div class="register-header">
                    <h1 class="register-title">Quên mật khẩu</h1>
                    <p class="register-subtitle">Vui lòng nhập địa chỉ email của bạn để đặt lại mật khẩu</p>
                </div>

                <?php if(session('status')): ?>
                    <div class="service__alert service__alert--success">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <span><?php echo e(session('status')); ?></span>
                        </div>
                        <button type="button" class="service__alert-close">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="service__alert service__alert--error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <span><?php echo e(session('error')); ?></span>
                        </div>
                        <button type="button" class="service__alert-close">&times;</button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('password.email')); ?>" class="register-form">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="email" class="form-label">Địa chỉ Email</label>
                        <input id="email" type="email" class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="email" value="<?php echo e(old('email')); ?>" required autofocus>
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

                    <button type="submit" class="register-btn">
                        Gửi liên kết đặt lại mật khẩu
                    </button>

                    <div class="login-link mt-3">
                        <a href="<?php echo e(route('login')); ?>">
                            <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>