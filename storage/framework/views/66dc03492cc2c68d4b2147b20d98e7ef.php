<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
           <a href="<?php echo e(route('admin.index')); ?>" class="d-flex justify-content-center align-items-center">
    <img src="<?php echo e(config_get('site_logo')); ?>"
         alt="Logo"
         style="height: 50px; width: auto;">
</a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption"><label>Quản lý chung</label></li>
                
                <li class="pc-item <?php echo e(request()->routeIs('admin.index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.index')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Bảng điều khiển</span>
                    </a>
                </li>
                
                <li class="pc-item pc-caption"><label>Người dùng & Giao dịch</label></li>

                <li class="pc-item pc-hasmenu <?php echo e(request()->is('admin/users*') ? 'active pc-trigger' : ''); ?>">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Người dùng</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu" style="display: <?php echo e(request()->is('admin/users*') ? 'block' : 'none'); ?>;">
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.users.index')); ?>">Danh sách thành viên</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu <?php echo e(request()->is('admin/history*') ? 'active pc-trigger' : ''); ?>">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-history"></i></span>
                        <span class="pc-mtext">Lịch sử</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu" style="display: <?php echo e(request()->is('admin/history*') ? 'block' : 'none'); ?>;">
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.history.transactions')); ?>">Giao dịch tiền</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.history.accounts')); ?>">Mua tài khoản</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.history.random-accounts')); ?>">Mua acc random</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.history.services')); ?>">Dịch vụ</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.history.deposits.bank')); ?>">Nạp ngân hàng</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.history.deposits.card')); ?>">Nạp thẻ cào</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.history.discount-usages')); ?>">Sử dụng mã giảm giá</a></li>
                    </ul>
                </li>
                
                <li class="pc-item <?php echo e(request()->routeIs('admin.installments.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.installments.index')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-receipt"></i></span>
                        <span class="pc-mtext">Quản lý Trả Góp</span>
                    </a>
                </li>
                
                <li class="pc-item <?php echo e(request()->routeIs('admin.flash-sales.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.flash-sales.index')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-bolt"></i></span>
                        <span class="pc-mtext">Flash Sale</span>
                    </a>
                </li>

                <li class="pc-item pc-caption"><label>Sản phẩm & Dịch vụ</label></li>

                <li class="pc-item pc-hasmenu <?php echo e(request()->is('admin/game-groups*') ? 'active pc-trigger' : ''); ?>">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-category"></i></span>
                        <span class="pc-mtext">Nhóm Game</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu" style="display: <?php echo e(request()->is('admin/game-groups*') ? 'block' : 'none'); ?>;">
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.game-groups.index')); ?>">Danh sách nhóm</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu <?php echo e(request()->is('admin/categories*') || request()->is('admin/accounts*') ? 'active pc-trigger' : ''); ?>">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-device-gamepad"></i></span>
                        <span class="pc-mtext">Acc Game Thường</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu" style="display: <?php echo e(request()->is('admin/categories*') || request()->is('admin/accounts*') ? 'block' : 'none'); ?>;">
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.categories.index')); ?>">Danh mục</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.accounts.index')); ?>">Tài khoản</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu <?php echo e(request()->is('admin/random-categories*') || request()->is('admin/random-accounts*') ? 'active pc-trigger' : ''); ?>">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dice-5"></i></span>
                        <span class="pc-mtext">Acc Random</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu" style="display: <?php echo e(request()->is('admin/random-categories*') || request()->is('admin/random-accounts*') ? 'block' : 'none'); ?>;">
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.random-categories.index')); ?>">Danh mục Random</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.random-accounts.index')); ?>">Tài khoản Random</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu <?php echo e(request()->is('admin/services*') || request()->is('admin/packages*') ? 'active pc-trigger' : ''); ?>">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-briefcase"></i></span>
                        <span class="pc-mtext">Cày Thuê / Dịch vụ</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu" style="display: <?php echo e(request()->is('admin/services*') || request()->is('admin/packages*') ? 'block' : 'none'); ?>;">
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.services.index')); ?>">Danh sách dịch vụ</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.packages.index')); ?>">Gói dịch vụ</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu <?php echo e(request()->is('admin/lucky-wheels*') || request()->is('admin/withdrawals/resources*') || request()->is('admin/reward-items*') ? 'active pc-trigger' : ''); ?>">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-device-gamepad-2"></i></span>
                        <span class="pc-mtext">Minigame</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu" style="display: <?php echo e(request()->is('admin/lucky-wheels*') || request()->is('admin/withdrawals/resources*') || request()->is('admin/reward-items*') ? 'block' : 'none'); ?>;">
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.reward-items.index')); ?>">Kho thưởng (Vật phẩm)</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.lucky-wheels.index')); ?>">Danh sách Vòng Quay</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.withdrawals.resources.index')); ?>">Yêu cầu rút vật phẩm</a></li>
                    </ul>
                </li>
                
                <li class="pc-item pc-caption"><label>Hệ thống</label></li>

                <li class="pc-item <?php echo e(request()->routeIs('admin.discount-codes.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.discount-codes.index')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-ticket"></i></span>
                        <span class="pc-mtext">Mã giảm giá</span>
                    </a>
                </li>
                
                <li class="pc-item <?php echo e(request()->routeIs('admin.bank-accounts.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.bank-accounts.index')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-building-bank"></i></span>
                        <span class="pc-mtext">Tài khoản Ngân hàng</span>
                    </a>
                </li>
                
                <li class="pc-item <?php echo e(request()->routeIs('admin.affiliates.index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.affiliates.index')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Tiếp thị liên kết</span>
                    </a>
                </li>

                <li class="pc-item <?php echo e(request()->routeIs('admin.news.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.news.index')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-news"></i></span>
                        <span class="pc-mtext">Quản lý Tin tức</span>
                    </a>
                </li>

                <li class="pc-item pc-hasmenu <?php echo e(request()->is('admin/settings*') ? 'active pc-trigger' : ''); ?>">
                    <a href="#" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-settings"></i></span>
                        <span class="pc-mtext">Cài đặt hệ thống</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu" style="display: <?php echo e(request()->is('admin/settings*') ? 'block' : 'none'); ?>;">
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.settings.index')); ?>">Cấu hình chung</a></li>
                        <li class="pc-item"><a class="pc-link" href="<?php echo e(route('admin.settings.notifications')); ?>">Thông báo hệ thống</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\layouts\admin\sidebar.blade.php ENDPATH**/ ?>