
<div class="profile-sidebar">
    <div class="sidebar-header">
        <h2 class="sidebar-title">MENU TÀI KHOẢN</h2>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.index') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.index')); ?>" class="sidebar-link">
                <i class="fa-solid fa-user"></i> Thông tin tài khoản
            </a>
        </li>
        <?php if(config_get('payment.card.active', true)): ?>
            <li class="sidebar-item <?php echo e(request()->routeIs('profile.deposit-card') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('profile.deposit-card')); ?>" class="sidebar-link">
                    <i class="fa-solid fa-credit-card"></i> Nạp tiền thẻ cào
                </a>
            </li>
        <?php endif; ?>
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.deposit-atm') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.deposit-atm')); ?>" class="sidebar-link">
                <i class="fa-solid fa-money-bill-transfer"></i> Nạp tiền ATM
            </a>
        </li>
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.transaction-history') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.transaction-history')); ?>" class="sidebar-link">
                <i class="fa-solid fa-chart-line"></i> Biến động số dư
            </a>
        </li>
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.withdraw.*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.withdraw.create')); ?>" class="sidebar-link">
                <i class="fa-solid fa-money-bill-wave"></i> Rút tiền
            </a>
        </li>
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.affiliate') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.affiliate')); ?>" class="sidebar-link">
                <i class="fa-solid fa-users"></i> Tiếp thị liên kết
            </a>
        </li>
    </ul>

    <div class="sidebar-header mt-4">
        <h2 class="sidebar-title">MENU GIAO DỊCH</h2>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.wheels-history') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.wheels-history')); ?>" class="sidebar-link">
                <i class="fa-solid fa-clock-rotate-left"></i> Lịch sử vòng quay
            </a>
        </li>
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.purchased-accounts') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.purchased-accounts')); ?>" class="sidebar-link">
                <i class="fa-solid fa-box"></i> Tài khoản đã mua
            </a>
        </li>
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.purchased-random-accounts') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.purchased-random-accounts')); ?>" class="sidebar-link">
                <i class="fa-solid fa-dice"></i> Random đã mua
            </a>
        </li>
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.installments') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.installments')); ?>" class="sidebar-link">
                <i class="fa-solid fa-hand-holding-usd"></i> Mua trả góp
            </a>
        </li>
        
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.services-history') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.services-history')); ?>" class="sidebar-link">
                <i class="fa-solid fa-clipboard-list"></i> Dịch vụ đã thuê
            </a>
        </li>
        <li class="sidebar-item <?php echo e(request()->routeIs('profile.withdraw-gem') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('profile.withdraw-gem')); ?>" class="sidebar-link">
                <i class="fa-solid fa-box-archive"></i> Lịch sử rút vật phẩm
            </a>
        </li>
    </ul>
</div>
<?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/layouts/user/sidebar.blade.php ENDPATH**/ ?>