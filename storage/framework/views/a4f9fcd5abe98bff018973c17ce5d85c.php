<?php $__env->startSection('title', 'Đặt lại mật khẩu'); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/auth.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="register-section">
        <div class="container">
            <div class="register-container">
                <div class="register-header">
                    <h1 class="register-title">Đặt lại mật khẩu</h1>
                    <p class="register-subtitle">Vui lòng nhập mật khẩu mới cho tài khoản của bạn</p>
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

                <form method="POST" action="<?php echo e(route('password.store')); ?>" class="register-form">
                    <?php echo csrf_field(); ?>

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="<?php echo e($request->route('token')); ?>">

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
                            name="email" value="<?php echo e(old('email', $request->email)); ?>" required autofocus readonly>
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
                        <input id="password" type="password" class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="password" required>
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
                        <input id="password_confirmation" type="password" class="form-input" name="password_confirmation"
                            required>
                    </div>

                    <button type="submit" class="register-btn">
                        Đặt lại mật khẩu
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

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\auth\reset-password.blade.php ENDPATH**/ ?>