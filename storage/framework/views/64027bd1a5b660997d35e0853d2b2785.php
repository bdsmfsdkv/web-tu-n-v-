<footer class="footer" style="margin-top:auto;padding:36px 0 20px;">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:40px;margin-bottom:32px;flex-wrap:wrap;">
            <!-- Left Side: Brand Info -->
            <div style="flex:1 1 320px;max-width:400px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                    <?php if(config_get('site_logo_footer', config_get('site_logo'))): ?>
                        <img src="<?php echo e(asset(config_get('site_logo_footer', config_get('site_logo')))); ?>" alt="<?php echo e(config_get('site_name')); ?>" width="140" height="36" style="height:36px; width:auto; object-fit:contain;" loading="lazy">
                    <?php else: ?>
                        <span class="brand-text" style="font-weight:800;font-size:1.3rem;color:var(--primary,#dc2626);"><?php echo e(config_get('site_name', 'ShopGame')); ?></span>
                    <?php endif; ?>
                </div>
                <p style="font-size:0.88rem;line-height:1.7;margin:0 0 16px;color:#64748b;">
                    <?php echo e(config_get('site_description', 'Hệ thống cung cấp tài khoản game uy tín hàng đầu, tự động 24/7.')); ?>

                </p>
                <div style="display:flex;gap:12px;align-items:center;">
                    <?php if(config_get('facebook')): ?>
                    <a href="<?php echo e(config_get('facebook')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook" style="color:#1877f2;font-size:1.4rem;transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-facebook"></i></a>
                    <?php endif; ?>
                    <?php if(config_get('youtube')): ?>
                    <a href="<?php echo e(config_get('youtube')); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube" style="color:#ff0000;font-size:1.4rem;transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                    <?php if(config_get('telegram')): ?>
                    <a href="<?php echo e(config_get('telegram')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Telegram" style="color:#0088cc;font-size:1.4rem;transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="fab fa-telegram"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Side: Links Columns -->
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(140px, 1fr));gap:28px;flex:2 1 500px;">
                <!-- Quick Links -->
                <div class="footer-col">
                    <h4 style="color:#1a1a1a;font-size:0.9rem;font-weight:700;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px;">Truy cập nhanh</h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                        <li><a href="/" class="footer-link">Trang Chủ</a></li>
                        <li><a href="<?php echo e(route('profile.deposit-card')); ?>" class="footer-link">Nạp Tiền</a></li>
                        <li><a href="<?php echo e(route('profile.transaction-history')); ?>" class="footer-link">Lịch Sử Mua</a></li>
                        <li><a href="<?php echo e(route('news.index')); ?>" class="footer-link">Tin Tức</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="footer-col">
                    <h4 style="color:#1a1a1a;font-size:0.9rem;font-weight:700;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px;">Hỗ trợ</h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                        <li><a href="<?php echo e(config_get('zalo') ? 'https://zalo.me/' . config_get('zalo') : '#'); ?>" class="footer-link" <?php echo e(config_get('zalo') ? 'target="_blank" rel="noopener noreferrer"' : ''); ?>>Liên hệ</a></li>
                        <li><a href="<?php echo e(route('faq')); ?>" class="footer-link">Câu hỏi thường gặp</a></li>
                        <li><a href="<?php echo e(route('terms')); ?>" class="footer-link">Điều khoản sử dụng</a></li>
                        <li><a href="<?php echo e(route('privacy')); ?>" class="footer-link">Chính sách bảo mật</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-col">
                    <h4 style="color:#1a1a1a;font-size:0.9rem;font-weight:700;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px;">Liên hệ</h4>
                    <div class="footer-contact-list" style="display:flex;flex-direction:column;gap:10px;font-size:0.85rem;color:#64748b;">
                        <?php if(config_get('email')): ?>
                        <div>Email: <a href="mailto:<?php echo e(config_get('email')); ?>" class="footer-link" style="color:var(--text-color,#1e293b);font-weight:500;"><?php echo e(config_get('email')); ?></a></div>
                        <?php endif; ?>
                        <?php if(config_get('phone')): ?>
                        <div>Hotline: <a href="tel:<?php echo e(config_get('phone')); ?>" class="footer-link" style="color:var(--primary,#dc2626);font-weight:700;"><?php echo e(config_get('phone')); ?></a></div>
                        <?php endif; ?>
                        <?php if(config_get('working_hours')): ?>
                        <div>Giờ làm việc: <span style="font-weight:500;color:var(--text-color,#1e293b);"><?php echo e(config_get('working_hours')); ?></span></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom-bar" style="border-top:1px solid #e5e7eb;padding:20px 0;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;font-size:0.8rem;">
            <div>© <?php echo e(date('Y')); ?> <?php echo e(config_get('site_name')); ?>. Tất cả quyền được bảo lưu.</div>
            <div style="display:flex;align-items:center;gap:8px;">
                <?php if(config_get('zalo')): ?>
                    <a href="https://zalo.me/<?php echo e(config_get('zalo')); ?>" target="_blank" rel="noopener noreferrer" style="color:#0068ff;text-decoration:none;font-weight:600;">Zalo: <?php echo e(config_get('zalo')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<!-- Mobile Bottom Nav with Glassmorphism & Floating Action Button -->
<nav class="mobile-bottom-nav">
    <div class="mobile-bottom-nav-container">
        <a href="/" class="bottom-nav-item <?php echo e(request()->is('/') ? 'active' : ''); ?>">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:home-outlined"></span>
            </div>
            <span class="bottom-nav-label">Trang chủ</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        <a href="/#categories" class="bottom-nav-item">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:appstore-outlined"></span>
            </div>
            <span class="bottom-nav-label">Danh mục</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        
        <!-- Floating Center Action Button for Deposit -->
        <a href="javascript:void(0)" class="bottom-nav-item bottom-nav-fab" onclick="document.getElementById('depositMethodModal').style.display='flex'">
            <div class="bottom-fab-btn">
                <i class="fa-solid fa-wallet"></i>
                <div class="bottom-fab-pulse"></div>
            </div>
            <span class="bottom-nav-label fab-label">Nạp tiền</span>
        </a>

        <a href="<?php echo e(route('profile.transaction-history')); ?>" class="bottom-nav-item <?php echo e(request()->routeIs('profile.transaction-history') ? 'active' : ''); ?>">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:history-outlined"></span>
            </div>
            <span class="bottom-nav-label">Lịch sử</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        <?php if(Auth::check()): ?>
        <a href="/profile" class="bottom-nav-item <?php echo e(request()->is('profile*') && !request()->routeIs('profile.transaction-history') ? 'active' : ''); ?>">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:user-outlined"></span>
            </div>
            <span class="bottom-nav-label">Tài khoản</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="bottom-nav-item <?php echo e(request()->routeIs('login') ? 'active' : ''); ?>">
            <div class="bottom-nav-icon-wrap">
                <span class="iconify" data-icon="ant-design:login-outlined"></span>
            </div>
            <span class="bottom-nav-label">Đăng nhập</span>
            <span class="bottom-nav-indicator"></span>
        </a>
        <?php endif; ?>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\resources\views/layouts/user/footer.blade.php ENDPATH**/ ?>