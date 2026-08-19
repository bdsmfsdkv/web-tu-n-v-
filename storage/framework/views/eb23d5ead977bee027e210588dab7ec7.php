<!-- Mobile Menu (Bottom Navigation) -->
<div class="menu-mobile">
    <ul class="menu-mobile__list">
        <li class="menu-mobile__item">
            <a href="/" class="menu-mobile__link <?php echo e(request()->is('/') ? 'active' : ''); ?>">
                <i class="fas fa-home"></i>
                <span>Trang chủ</span>
            </a>
        </li>
        <li class="menu-mobile__item">
            <a href="<?php echo e(route('category.show-all')); ?>"
                class="menu-mobile__link <?php echo e(request()->routeIs('category*') ? 'active' : ''); ?>">
                <i class="fas fa-gamepad"></i>
                <span>Tài khoản</span>
            </a>
        </li>
        <li class="menu-mobile__item">
            <a href="<?php echo e(route('random.show-all')); ?>"
                class="menu-mobile__link <?php echo e(request()->routeIs('random*') ? 'active' : ''); ?>">
                <i class="fas fa-random"></i>
                <span>Random</span>
            </a>
        </li>
        <li class="menu-mobile__item">
            <a href="<?php echo e(route('service.show-all')); ?>"
                class="menu-mobile__link <?php echo e(request()->routeIs('service*') ? 'active' : ''); ?>">
                <i class="fas fa-cogs"></i>
                <span>Dịch vụ</span>
            </a>
        </li>
        <li class="menu-mobile__item">
            <a href="<?php echo e(route('profile.index')); ?>"
                class="menu-mobile__link <?php echo e(request()->routeIs('profile*') ? 'active' : ''); ?>">
                <i class="fas fa-user"></i>
                <span>Tài khoản</span>
            </a>
        </li>
    </ul>
</div>

<!-- Mobile Overlay Menu (Fullscreen) - Hidden by default -->
<div class="mobile-overlay-menu">
    <div class="mobile-overlay-menu__header">
        <h2 class="mobile-overlay-menu__title">Menu</h2>
        <button class="mobile-overlay-menu__close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="mobile-overlay-menu__content">
        <div class="mobile-overlay-menu__section">
            <h3 class="mobile-overlay-menu__section-title">Tài khoản</h3>
            <ul class="mobile-overlay-menu__links">
                <?php if(auth()->guard()->guest()): ?>
                    <li>
                        <a href="<?php echo e(route('login')); ?>" class="mobile-overlay-menu__link">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('register')); ?>" class="mobile-overlay-menu__link">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo e(route('profile.index')); ?>" class="mobile-overlay-menu__link">
                            <i class="fas fa-user-circle"></i> <?php echo e(Auth::user()->username); ?>

                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('profile.deposit-card')); ?>" class="mobile-overlay-menu__link">
                            <i class="fas fa-wallet"></i> Số dư: <?php echo e(number_format(Auth::user()->balance)); ?>đ
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="mobile-overlay-menu__link mobile-overlay-menu__button">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="mobile-overlay-menu__section">
            <h3 class="mobile-overlay-menu__section-title">Danh mục</h3>
            <ul class="mobile-overlay-menu__links">
                <li>
                    <a href="<?php echo e(route('category.show-all')); ?>" class="mobile-overlay-menu__link">
                        <i class="fas fa-gamepad"></i> Tài khoản Game
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('random.show-all')); ?>" class="mobile-overlay-menu__link">
                        <i class="fas fa-random"></i> Random Account
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('service.show-all')); ?>" class="mobile-overlay-menu__link">
                        <i class="fas fa-cogs"></i> Dịch vụ Game
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Overlay backdrop for mobile menu -->
<div class="mobile-overlay"></div>
<?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\layouts\user\menu-mobile.blade.php ENDPATH**/ ?>