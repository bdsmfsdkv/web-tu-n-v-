<footer class="footer" style="color:#4a4a4a;margin-top:auto;">
    <div class="container">
        <div class="footer-grid" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:40px;margin-bottom:40px;">
            <!-- Brand -->
            <div class="footer-brand">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                    <img src="<?php echo e(config_get('site_logo_footer', config_get('site_logo'))); ?>" alt="<?php echo e(config_get('site_name')); ?>" width="120" height="32" style="height:32px; width:auto;" loading="lazy">
                </div>
                <p style="font-size:0.85rem;line-height:1.7;margin:0;">
                    <?php echo e(config_get('site_description')); ?>

                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 style="color:#1a1a1a;font-size:0.9rem;margin-bottom:14px;text-transform:uppercase;letter-spacing:1px;">Truy cập nhanh</h4>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                    <li><a href="/" class="footer-link" style="color:#333;text-decoration:none;font-size:0.85rem;transition:color .2s;">Trang Chủ</a></li>
                    <li><a href="<?php echo e(route('profile.deposit-card')); ?>" class="footer-link" style="color:#333;text-decoration:none;font-size:0.85rem;transition:color .2s;">Nạp Tiền</a></li>
                    <li><a href="<?php echo e(route('profile.transaction-history')); ?>" class="footer-link" style="color:#333;text-decoration:none;font-size:0.85rem;transition:color .2s;">Lịch Sử Mua</a></li>
                    <li><a href="<?php echo e(route('news.index')); ?>" class="footer-link" style="color:#333;text-decoration:none;font-size:0.85rem;transition:color .2s;">Tin Tức</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 style="color:#1a1a1a;font-size:0.9rem;margin-bottom:14px;text-transform:uppercase;letter-spacing:1px;">Hỗ trợ</h4>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                    <li><a href="#" class="footer-link" style="color:#333;text-decoration:none;font-size:0.85rem;">Liên hệ</a></li>
                    <li><a href="<?php echo e(route('faq')); ?>" class="footer-link" style="color:#333;text-decoration:none;font-size:0.85rem;">Câu hỏi thường gặp</a></li>
                    <li><a href="<?php echo e(route('terms')); ?>" class="footer-link" style="color:#333;text-decoration:none;font-size:0.85rem;">Điều khoản sử dụng</a></li>
                    <li><a href="<?php echo e(route('privacy')); ?>" class="footer-link" style="color:#333;text-decoration:none;font-size:0.85rem;">Chính sách bảo mật</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 style="color:#1a1a1a;font-size:0.9rem;margin-bottom:14px;text-transform:uppercase;letter-spacing:1px;">Liên hệ</h4>
                <div style="display:flex;flex-direction:column;gap:10px;font-size:0.85rem;">
                    <div>Email: <a href="mailto:<?php echo e(config_get('email')); ?>"><?php echo e(config_get('email')); ?></a></div>
                    <div>Hotline: <?php echo e(config_get('phone')); ?></div>
                    <div>Giờ làm việc: <?php echo e(config_get('working_hours')); ?></div>
                </div>
                <div style="display:flex;gap:10px;margin-top:16px;">
                    <?php if(config_get('facebook')): ?>
                    <a href="<?php echo e(config_get('facebook')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook" style="color:#1877f2;font-size:1.5rem;"><i class="fab fa-facebook"></i></a>
                    <?php endif; ?>
                    <?php if(config_get('youtube')): ?>
                    <a href="<?php echo e(config_get('youtube')); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube" style="color:#ff0000;font-size:1.5rem;"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                    <?php if(config_get('telegram')): ?>
                    <a href="<?php echo e(config_get('telegram')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Telegram" style="color:#0088cc;font-size:1.5rem;"><i class="fab fa-telegram"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div style="border-top:1px solid #e5e7eb;padding:20px 0;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;font-size:0.8rem;">
            <div>© <?php echo e(date('Y')); ?> <?php echo e(config_get('site_name')); ?>. Tất cả quyền được bảo lưu.</div>
            <div style="display:flex;align-items:center;gap:8px;">
                Thiết kế bởi <a href="https://cmsbvq.com" rel="noopener noreferrer" style="font-weight:700;color:var(--primary,#dc2626);text-decoration:none;" target="_blank">CMSBVQ.COM</a>
            </div>
        </div>
    </div>
</footer>

<!-- Mobile Bottom Nav -->
<nav class="mobile-bottom-nav">
    <a href="/" class="bottom-nav-item active">
        <span class="iconify" data-icon="ant-design:home-outlined"></span>
        <span>Trang chủ</span>
    </a>
    <a href="/#categories" class="bottom-nav-item">
        <span class="iconify" data-icon="ant-design:appstore-outlined"></span>
        <span>Danh mục</span>
    </a>
    <a href="javascript:void(0)" class="bottom-nav-item " onclick="document.getElementById('depositMethodModal').style.display='flex'">
        <span class="iconify" data-icon="ant-design:wallet-outlined"></span>
        <span>Nạp tiền</span>
    </a>
    <a href="<?php echo e(route('profile.transaction-history')); ?>" class="bottom-nav-item ">
        <span class="iconify" data-icon="ant-design:history-outlined"></span>
        <span>Lịch sử</span>
    </a>
    <?php if(Auth::check()): ?>
    <a href="/profile" class="bottom-nav-item ">
        <span class="iconify" data-icon="ant-design:user-outlined"></span>
        <span>Tài khoản</span>
    </a>
    <?php else: ?>
    <a href="<?php echo e(route('login')); ?>" class="bottom-nav-item ">
        <span class="iconify" data-icon="ant-design:login-outlined"></span>
        <span>Đăng nhập</span>
    </a>
    <?php endif; ?>
</nav>
<?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/layouts/user/footer.blade.php ENDPATH**/ ?>