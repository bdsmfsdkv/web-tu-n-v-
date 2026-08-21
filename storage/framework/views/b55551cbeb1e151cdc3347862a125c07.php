<?php $__env->startSection('title', 'Đăng ký tài khoản'); ?>

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

        <form method="POST" action="<?php echo e(route('register')); ?>" autocomplete="on">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="username" class="form-label">Tên tài khoản</label>
                <input id="username"
                       type="text"
                       class="form-input"
                       name="username"
                       value="<?php echo e(old('username')); ?>"
                       required
                       autofocus
                       autocomplete="username"
                       autocapitalize="none"
                       spellcheck="false"
                       placeholder="Tên tài khoản">
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
                <input id="email"
                       type="email"
                       class="form-input"
                       name="email"
                       value="<?php echo e(old('email')); ?>"
                       required
                       autocomplete="email"
                       inputmode="email"
                       autocapitalize="none"
                       spellcheck="false"
                       placeholder="VD: example@gmail.com">
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
                <input id="password"
                       type="password"
                       class="form-input"
                       name="password"
                       required
                       autocomplete="new-password"
                       placeholder="Tối thiểu 8 ký tự">
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
                <input id="password-confirm"
                       type="password"
                       class="form-input"
                       name="password_confirmation"
                       required
                       autocomplete="new-password"
                       placeholder="Nhập lại mật khẩu">
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

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\user\register.blade.php ENDPATH**/ ?>