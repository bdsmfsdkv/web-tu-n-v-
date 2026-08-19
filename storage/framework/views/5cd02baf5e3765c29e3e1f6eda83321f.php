
    <!-- Preloader -->
    <div id="pagePreloader" style="position:fixed;inset:0;z-index:99999;background:rgba(var(--bs-body-bg-rgb,255,255,255),0.7);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;transition:opacity .3s ease;">
      <span class="antd-spin"><i></i><i></i><i></i><i></i></span>
    </div>
    <style>
      .antd-spin {
        display: inline-block;
        width: 32px;
        height: 32px;
        position: relative;
        animation: antdSpinRotate 1.2s linear infinite;
      }

      .antd-spin i {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--bs-primary, #5955D1);
        opacity: .3;
        animation: antdSpinDot 1s ease-in-out infinite;
      }

      .antd-spin i:nth-child(1) {
        top: 0;
        left: 50%;
        margin-left: -5px;
        animation-delay: 0s;
      }

      .antd-spin i:nth-child(2) {
        right: 0;
        top: 50%;
        margin-top: -5px;
        animation-delay: .4s;
      }

      .antd-spin i:nth-child(3) {
        bottom: 0;
        left: 50%;
        margin-left: -5px;
        animation-delay: .8s;
      }

      .antd-spin i:nth-child(4) {
        left: 0;
        top: 50%;
        margin-top: -5px;
        animation-delay: 1.2s;
      }

      @keyframes antdSpinRotate {
        to {
          transform: rotate(360deg);
        }
      }

      @keyframes antdSpinDot {

        0%,
        100% {
          opacity: .3;
          transform: scale(.6);
        }

        50% {
          opacity: 1;
          transform: scale(1);
        }
      }
    </style>
<nav class="navbar">
    <div class="nav-container">
        <a href="/" class="nav-brand">
            <img src="<?php echo e(config_get('site_logo')); ?>" alt="<?php echo e(config_get('site_name')); ?>" width="120" height="32" style="height:32px; width:auto;">
        </a>

        <button class="nav-toggle" id="navToggle">
            <span></span><span></span><span></span>
        </button>

        <ul class="nav-links" id="navLinks">
            <li class="nav-offcanvas-header">
                <a href="/" class="nav-brand">
                    <img src="<?php echo e(config_get('site_logo')); ?>" alt="<?php echo e(config_get('site_name')); ?>" width="105" height="28" style="height:28px; width:auto;">
                </a>
                <button class="nav-close" id="navClose" onclick="closeNav()" aria-label="Close mobile menu">
                    <span class="iconify" data-icon="ant-design:close-outlined"></span>
                </button>
            </li>
            <li><a href="/" class="nav-link-item"><span class="iconify"
                        data-icon="ant-design:home-outlined"></span> Trang Chủ</a></li>
            <style>
                @media (min-width: 992px) {
                    .nav-mega-dropdown.full-width-dropdown {
                        position: static !important;
                    }
                    .nav-mega-dropdown.full-width-dropdown .mega-menu {
                        width: 100vw;
                        left: 50% !important;
                        right: auto !important;
                        transform: translateX(-50%) !important;
                        border-radius: 0;
                        border-left: none;
                        border-right: none;
                        box-sizing: border-box;
                    }
                }
            </style>
            <li class="nav-mega-dropdown full-width-dropdown">
                <a href="#" class="nav-link-item"><span class="iconify"
                        data-icon="ant-design:appstore-outlined"></span> Danh Mục <span class="iconify nav-arrow"
                        data-icon="ant-design:down-outlined" style="font-size:0.65rem;"></span></a>
                <div class="mega-menu">
                    <div class="mega-menu-inner">
                        <?php
                            $navCategories = \App\Models\Category::where('active', 1)->get();
                            $navRandomCategories = \App\Models\RandomCategory::where('active', 1)->get();
                            $navServices = \App\Models\GameService::where('active', 1)->get();
                        ?>
                        
                        <?php $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('category.index', ['slug' => $cat->slug])); ?>" class="mega-menu-item">
                            <?php if($cat->thumbnail): ?>
                            <img src="<?php echo e($cat->thumbnail); ?>" alt="" class="mega-menu-icon">
                            <?php else: ?>
                            <span class="iconify mega-menu-icon-fallback" data-icon="ant-design:folder-outlined"></span>
                            <?php endif; ?>
                            <span><?php echo e($cat->name); ?></span>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = $navRandomCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('random.index', ['slug' => $cat->slug])); ?>" class="mega-menu-item">
                            <?php if($cat->thumbnail): ?>
                            <img src="<?php echo e($cat->thumbnail); ?>" alt="" class="mega-menu-icon">
                            <?php else: ?>
                            <span class="iconify mega-menu-icon-fallback" data-icon="ant-design:gift-outlined"></span>
                            <?php endif; ?>
                            <span><?php echo e($cat->name); ?></span>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = $navServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('service.show', ['slug' => $cat->slug])); ?>" class="mega-menu-item">
                            <?php if($cat->thumbnail): ?>
                            <img src="<?php echo e($cat->thumbnail); ?>" alt="" class="mega-menu-icon">
                            <?php else: ?>
                            <span class="iconify mega-menu-icon-fallback" data-icon="ant-design:tool-outlined"></span>
                            <?php endif; ?>
                            <span><?php echo e($cat->name); ?></span>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </li>
            <li class="nav-dropdown">
                <a href="#" class="nav-link-item"><span class="iconify"
                        data-icon="ant-design:dollar-outlined"></span> Nạp Tiền <span class="iconify nav-arrow"
                        data-icon="ant-design:down-outlined" style="font-size:0.65rem;"></span></a>
                <ul class="nav-dropdown-menu">
                    <li><a href="<?php echo e(route('profile.deposit-card')); ?>"><span class="iconify"
                                data-icon="ant-design:credit-card-outlined"></span> Nạp thẻ cào</a></li>
                    <li><a href="<?php echo e(route('profile.deposit-atm')); ?>"><span class="iconify"
                                data-icon="ant-design:bank-outlined"></span> Nạp ngân hàng</a></li>
                    <li><a href="<?php echo e(route('profile.deposit-usdt')); ?>"><span class="iconify"
                                data-icon="ant-design:bank-outlined"></span> Nạp Usdt </a></li>
                </ul>
            </li>
            <li><a href="<?php echo e(route('profile.transaction-history')); ?>" class="nav-link-item"><span class="iconify"
                        data-icon="ant-design:history-outlined"></span> Lịch Sử</a></li>
            <li><a href="<?php echo e(route('news.index')); ?>" class="nav-link-item"><span class="iconify"
                        data-icon="ant-design:notification-outlined"></span> Tin Tức</a></li>
            <li><a href="<?php echo e(route('profile.affiliate')); ?>" class="nav-link-item" style="color: #10b981; font-weight: bold;"><span class="iconify"
                        data-icon="ant-design:link-outlined"></span> Tiếp Thị Liên Kết</a></li>
                
        </ul>
    

        <div class="nav-user">
            <!-- Premium Language Switcher Dropdown -->
            <div class="ant-header-lang-dropdown mr-2" style="position: relative; margin-right: 12px;">
                <div class="ant-header-lang-trigger" style="background: var(--bg-card, #fff); border: 1px solid var(--border-color, #e5e7eb); border-radius: 24px; padding: 4px 12px; height: 36px; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s;">
                    <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/vn.svg" id="currentLangFlag" alt="Flag" style="width: 20px; height: 14px; border-radius: 2px; object-fit: cover;">
                    <span class="ant-header-lang-text" id="currentLangText" style="font-weight: 600; font-size: 14px; color: var(--text-color, #111827);">VI</span>
                    <span class="iconify" data-icon="ant-design:down-outlined" style="font-size: 12px; color: var(--text-muted, #6b7280);"></span>
                </div>
                <div class="ant-dropdown-menu" id="langDropdownMenu" style="position: absolute; z-index: 1000; width: 140px; right: 0; background: var(--bg-card, #fff); border: 1px solid var(--border-color, #e5e7eb); border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-top: 8px; overflow: hidden; padding: 4px;">
                    <div class="ant-dropdown-item" onclick="setLanguage('vi')" style="padding: 10px 16px; border-radius: 8px; cursor: pointer;">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/vn.svg" alt="VN" style="width: 20px; height: 14px; border-radius: 2px; object-fit: cover; margin-right: 8px;">
                        <span style="font-weight: 500; color: var(--text-color, #111827);">Tiếng Việt</span>
                    </div>
                    <div class="ant-dropdown-item" onclick="setLanguage('en')" style="padding: 10px 16px; border-radius: 8px; cursor: pointer;">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/us.svg" alt="EN" style="width: 20px; height: 14px; border-radius: 2px; object-fit: cover; margin-right: 8px;">
                        <span style="font-weight: 500; color: var(--text-color, #111827);">English</span>
                    </div>
                    <div class="ant-dropdown-item" onclick="setLanguage('zh-CN')" style="padding: 10px 16px; border-radius: 8px; cursor: pointer;">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/cn.svg" alt="ZH" style="width: 20px; height: 14px; border-radius: 2px; object-fit: cover; margin-right: 8px;">
                        <span style="font-weight: 500; color: var(--text-color, #111827);">简体中文</span>
                    </div>
                    <div class="ant-dropdown-item" onclick="setLanguage('ko')" style="padding: 10px 16px; border-radius: 8px; cursor: pointer;">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/kr.svg" alt="KO" style="width: 20px; height: 14px; border-radius: 2px; object-fit: cover; margin-right: 8px;">
                        <span style="font-weight: 500; color: var(--text-color, #111827);">한국어</span>
                    </div>
                    <div class="ant-dropdown-item" onclick="setLanguage('ja')" style="padding: 10px 16px; border-radius: 8px; cursor: pointer;">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/jp.svg" alt="JA" style="width: 20px; height: 14px; border-radius: 2px; object-fit: cover; margin-right: 8px;">
                        <span style="font-weight: 500; color: var(--text-color, #111827);">日本語</span>
                    </div>
                </div>
            </div>

            <button class="theme-toggle" id="themeToggle" title="Chuyển giao diện" aria-label="Toggle dark mode">
                <span class="icon-sun"><span class="iconify" data-icon="ant-design:sun-outlined"></span></span>
                <span class="icon-moon"><span class="iconify" data-icon="ant-design:moon-outlined"></span></span>
            </button>

            <?php if(Auth::check()): ?>
            <div class="nav-avatar-wrapper" id="avatarWrapper">
                <div class="nav-user-profile" onclick="toggleAvatarMenu()"
                    style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                    <div style="text-align:right;">
                        <div style="font-weight:600;font-size:0.85rem;line-height:1.2;"><?php echo e(Auth::user()->username); ?></div>
                        <div style="font-size:0.75rem;color:#737373;"><?php echo e(number_format(Auth::user()->balance)); ?>đ</div>
                    </div>
                    <button class="nav-avatar" id="avatarBtn" aria-label="User menu">
                        <?php echo e(strtoupper(substr(Auth::user()->username, 0, 1))); ?>

                    </button>
                </div>
                <div class="avatar-dropdown" id="avatarDropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-name"><?php echo e(Auth::user()->username); ?></div>
                        <div class="dropdown-email"><?php echo e(Auth::user()->email ?? ''); ?></div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="/profile" class="dropdown-item">
                        <span class="iconify" data-icon="ant-design:dashboard-outlined"></span> Tài Khoản
                    </a>
                    <a href="<?php echo e(route('profile.deposit-card')); ?>" class="dropdown-item">
                        <span class="iconify" data-icon="ant-design:dollar-outlined"></span> Nạp Tiền
                    </a>
                    <a href="<?php echo e(route('profile.transaction-history')); ?>" class="dropdown-item">
                        <span class="iconify" data-icon="ant-design:history-outlined"></span> Lịch Sử Mua
                    </a>
                          <?php if(Auth::check() && Auth()->user()->role == 'admin'): ?>
                    <a href="<?php echo e(route('admin.index')); ?>" class="dropdown-item">
                        <span class="iconify" data-icon="ant-design:dashboard-outlined"></span> Admin
                           <?php endif; ?>
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;width:100%;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item dropdown-logout" style="width:100%;text-align:left;background:transparent;border:none;cursor:pointer;">
                            <span class="iconify" data-icon="ant-design:logout-outlined"></span> Đăng Xuất
                        </button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" style="text-decoration:none;font-weight:600;padding:8px 16px;border-radius:8px;background:var(--primary);color:#fff;">Đăng Nhập</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="nav-overlay" id="navOverlay"></div>
<?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/layouts/user/header.blade.php ENDPATH**/ ?>