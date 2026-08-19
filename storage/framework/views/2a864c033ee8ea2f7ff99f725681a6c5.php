

<?php $__env->startSection('title', 'Chi tiết tài khoản #' . $account->id); ?>

<?php $__env->startSection('content'); ?>
<!-- SimpleLightbox Library -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.js"></script>

<div class="container" style="padding-top: 24px; padding-bottom: 40px;">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb" style="margin-bottom: 24px;">
        <a href="/" class="breadcrumb-link"><i class="fas fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator">/</span>
        <a href="<?php echo e(route('category.index', ['slug' => $account->category->slug ?? ''])); ?>" class="breadcrumb-link"><?php echo e($account->category->name ?? 'Danh Mục'); ?></a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Tài khoản #<?php echo e($account->id); ?></span>
    </div>

    <div class="ecom-layout">
        <!-- Left Column -->
        <div class="ecom-left">
            <!-- Gallery Box -->
            <div class="ecom-box ecom-gallery-box">
                <div class="ecom-gallery-inner">
                    <!-- Vertical Thumbnails -->
                    <div class="ecom-thumbs-vertical">
                        <?php $__currentLoopData = array_slice($images, 0, 8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e($image); ?>" class="ecom-thumb" onclick="changeMainImage('<?php echo e($image); ?>', <?php echo e($index); ?>)" alt="Thumb">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <!-- Main Image -->
                    <div class="ecom-main-img-wrapper" style="cursor: pointer;" onclick="openLightbox()">
                        <img src="<?php echo e($images[0] ?? ''); ?>" id="ecom-main-img" class="ecom-main-img" alt="Main Image">
                        <div class="ecom-img-count"><i class="far fa-images"></i> 1/<?php echo e(count($images)); ?></div>
                    </div>

                    <!-- Hidden Full Gallery for Lightbox -->
                    <div id="lightbox-gallery" style="display: none;">
                        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($image); ?>" class="detail__images-link">
                                <img src="<?php echo e($image); ?>" alt="Hình ảnh tài khoản">
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Note Box -->
            <?php if($account->note): ?>
            <div class="ecom-box ecom-note-box" style="margin-top: 20px;">
                <h3 class="ecom-box-title">Chi tiết dịch vụ</h3>
                <div class="ecom-note-content"><?php echo nl2br(e($account->note)); ?></div>
            </div>
            <?php endif; ?>
            
            <!-- Related Accounts Grid -->
            <?php if(isset($relatedAccounts) && $relatedAccounts->count() > 0): ?>
            <div class="ecom-box ecom-all-images-box" style="margin-top: 20px; border-color: transparent;">
                <h3 class="ecom-box-title" style="font-size: 1.3rem;">Tài khoản liên quan</h3>
                <div class="account-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
                    <?php $__currentLoopData = $relatedAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="account-card" style="border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; background: var(--box-bg);">
                            <div class="account-media" style="position: relative;">
                                <a href="<?php echo e(route('account.show', ['id' => $related->id])); ?>">
                                    <img src="<?php echo e($related->thumb ?? asset('assets/images/default.jpg')); ?>" alt="Account" style="width: 100%; height: 120px; object-fit: cover;">
                                </a>
                                <div style="position: absolute; bottom: 0; left: 0; background: rgba(0,0,0,0.6); color: #fff; padding: 2px 8px; font-size: 0.8rem; border-top-right-radius: 4px;">Mã số: <?php echo e($related->id); ?></div>
                            </div>
                            <div class="account-info" style="padding: 10px; flex-grow: 1; text-align: center;">
                                <div style="color: #ef4444; font-weight: bold; font-size: 1.1rem; margin-bottom: 8px;"><?php echo e(number_format($related->price)); ?> VNĐ</div>
                                <a href="<?php echo e(route('account.show', ['id' => $related->id])); ?>" class="ecom-btn ecom-btn-outline" style="width: 100%; padding: 6px; font-size: 0.85rem;">XEM CHI TIẾT</a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right Column -->
        <div class="ecom-right">
            <div class="ecom-box ecom-info-box">
                <h1 class="ecom-title"><?php echo e($account->category->name ?? 'Tài khoản Game'); ?></h1>
                <div class="ecom-id">Mã số: <strong>#<?php echo e($account->category->slug ?? 'YSO'); ?><?php echo e($account->id); ?></strong></div>
                
                <hr class="ecom-divider">

                <div class="ecom-attr-header">Thông tin acc</div>
                <div class="ecom-attr-list">
                    <?php
                        $details = is_array($account->details) ? $account->details : json_decode($account->details, true) ?? [];
                    ?>
                    <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="ecom-attr-row">
                            <span class="ecom-attr-label"><?php echo e(mb_strtoupper($detail['key'] ?? '')); ?></span>
                            <span class="ecom-attr-value"><?php echo e($detail['value'] ?? ''); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="ecom-price-box">
                    <div class="ecom-price-row">
                        <?php
                            $discountPercent = config_get('payment.card.discount_percent');
                            $cardPrice = $account->price / ((100 - $discountPercent) / 100);
                            $discountRatio = round(100 - ($account->price / $cardPrice) * 100);
                        ?>
                        <span class="old-price"><?php echo e(number_format($cardPrice)); ?>đ</span>
                        <span class="new-price"><?php echo e(number_format($account->price)); ?>đ</span>
                        <span class="discount-badge">-<?php echo e($discountRatio); ?>%</span>
                    </div>
                    <div class="ecom-price-subtitle">Rẻ vô đối, giá tốt nhất thị trường</div>
                </div>

                <hr class="ecom-divider">

                <div class="ecom-actions">
                    <?php if($account->status === 'available'): ?>
                        <div class="ecom-action-row-1">
                            <a href="<?php echo e(route('profile.deposit-card')); ?>" class="ecom-btn ecom-btn-outline"><i class="fas fa-shopping-cart"></i> Nạp thẻ</a>
                            <button class="ecom-btn ecom-btn-solid" onclick="buyAccount(<?php echo e($account->id); ?>)">Mua Ngay</button>
                        </div>
                        <div class="ecom-or-divider">--- hoặc ---</div>
                        <button class="ecom-btn ecom-btn-atm" style="margin-top: 10px; width: 100%; background: #0bcfa5ffff; border-color: #0bcfa5ffff; color: white;" onclick="showRechargeModal('wallet')">
                            Mua Bằng ATM, Momo<br>
                            <small><?php echo e(number_format($account->price)); ?> Đ</small>
                        </button>
                        <button class="ecom-btn" style="margin-top: 10px; width: 100%; background: #3b82f6; border-color: #3b82f6; color: white;" onclick="showInstallmentModal()">
                            <i class="fas fa-hand-holding-usd"></i> Mua Trả Góp<br>
                            <small>Trả trước từ <?php echo e(number_format($account->price * 0.2)); ?> Đ</small>
                        </button>
                    <?php else: ?>
                        <div class="detail__purchased" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; padding: 20px; border-radius: 8px; text-align: center; font-weight: 700; font-size: 1.1rem;">
                            <i class="fas fa-lock"></i> TÀI KHOẢN NÀY ĐÃ ĐƯỢC BÁN
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentImageIndex = 0;
    let galleryLightbox = null;

    function changeMainImage(src, index = 0) {
        document.getElementById('ecom-main-img').src = src;
        currentImageIndex = index;
        const countElement = document.querySelector('.ecom-img-count');
        if (countElement) {
            countElement.innerHTML = '<i class="far fa-images"></i> ' + (index + 1) + '/<?php echo e(count($images)); ?>';
        }
    }

    function openLightbox() {
        if (galleryLightbox) {
            const links = document.querySelectorAll('#lightbox-gallery .detail__images-link');
            if (links && links[currentImageIndex]) {
                links[currentImageIndex].click();
            }
        }
    }
</script>

    <!-- Purchase Modal -->
    <div id="purchaseModal" class="modal-modern">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title">XÁC NHẬN MUA TÀI KHOẢN #<?php echo e($account->id); ?></h2>
                <button class="modal__close" onclick="closePurchaseModal()"><i class="fas fa-times"></i></button>
            </div>

            <div class="modal__body">
                <div class="modal__info">
                    <div class="modal__row">
                        <span class="modal__label">Nhà phát hành:</span>
                        <span class="modal__value">N/A</span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Danh mục:</span>
                        <span class="modal__value"><?php echo e($account->category->name ?? 'Tài khoản Game'); ?></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Giá tiền:</span>
                        <span class="modal__value modal__value--price"
                            id="account-price"><?php echo e(number_format($account->price)); ?> đ</span>
                    </div>
                </div>

                <div class="modal__discount">
                    <div class="discount-input-group" style="display: flex; gap: 10px;">
                        <input type="text" id="discount-code" class="modal__input" placeholder="Nhập mã giảm giá nếu có" style="flex: 1; padding: 8px 12px; border-radius: 4px; border: 1px solid #d9d9d9;">
                        <button class="modal__btn--check" onclick="checkDiscountCode('account')" style="padding: 8px 16px; border-radius: 4px; border: 1px solid #d9d9d9; background: #f5f5f5; cursor: pointer;">Áp dụng</button>
                    </div>
                    <div id="discount-message" class="modal__discount-message" style="margin-top: 8px; font-size: 0.9rem;"></div>
                </div>

                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->balance < $account->price): ?>
                        <div class="modal__notice">
                            <strong><i class="fas fa-exclamation-triangle"></i> Số dư không đủ!</strong><br>
                            Bạn cần thêm <?php echo e(number_format($account->price - Auth::user()->balance)); ?> đ để mua tài khoản này.
                            Vui lòng nạp thêm tiền để tiếp tục.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="modal__notice">
                        <strong><i class="fas fa-info-circle"></i> Chưa đăng nhập</strong><br>
                        Vui lòng đăng nhập để thực hiện giao dịch.
                    </div>
                <?php endif; ?>
            </div>

            <div class="modal__footer">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->balance < $account->price): ?>
                        <a class="modal__btn modal__btn--card" href="<?php echo e(route('profile.deposit-card')); ?>"><i class="fas fa-credit-card"></i> NẠP THẺ CÀO</a>
                        <button class="modal__btn modal__btn--wallet" onclick="showRechargeModal('wallet')"><i class="fas fa-university"></i> NẠP ATM</button>
                    <?php else: ?>
                        <button class="modal__btn modal__btn--submit" onclick="submitPurchase()"><i class="fas fa-check-circle"></i> XÁC NHẬN MUA</button>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="modal__btn modal__btn--submit" href="<?php echo e(route('login')); ?>"><i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP</a>
                <?php endif; ?>
                <button class="modal__btn modal__btn--close" onclick="closePurchaseModal()"><i class="fas fa-times"></i> ĐÓNG</button>
            </div>
        </div>
    </div>

    <!-- Installment Modal -->
    <div id="installmentModal" class="modal-modern">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title">ĐĂNG KÝ TRẢ GÓP #<?php echo e($account->id); ?></h2>
                <button class="modal__close" onclick="closeInstallmentModal()"><i class="fas fa-times"></i></button>
            </div>

            <div class="modal__body">
                <div class="modal__info">
                    <div class="modal__row">
                        <span class="modal__label">Giá trị tài khoản:</span>
                        <span class="modal__value" style="color: #ef4444; font-weight: bold;"><?php echo e(number_format($account->price)); ?> đ</span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Trả trước (20%):</span>
                        <span class="modal__value" style="color: #10b981; font-weight: bold;"><?php echo e(number_format($account->price * 0.2)); ?> đ</span>
                    </div>
                </div>

                <div style="margin: 16px 0;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Chọn thời hạn trả góp:</label>
                    <select id="installmentDuration" class="modal__input" style="width: 100%; background: transparent; color: inherit; border-color: var(--border-color, #4b5563);">
                        <option value="7" style="color: #000;">7 Ngày</option>
                        <option value="30" style="color: #000;">30 Ngày</option>
                        <option value="60" style="color: #000;">60 Ngày</option>
                    </select>
                </div>

                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->balance < ($account->price * 0.2)): ?>
                        <div class="modal__notice">
                            <strong><i class="fas fa-exclamation-triangle"></i> Số dư không đủ!</strong><br>
                            Bạn cần tối thiểu <?php echo e(number_format($account->price * 0.2)); ?> đ để trả trước cho tài khoản này.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="modal__notice">
                        <strong><i class="fas fa-info-circle"></i> Chưa đăng nhập</strong><br>
                        Vui lòng đăng nhập để thực hiện giao dịch.
                    </div>
                <?php endif; ?>
            </div>

            <div class="modal__footer">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->balance < ($account->price * 0.2)): ?>
                        <button class="modal__btn modal__btn--wallet" onclick="showRechargeModal('wallet')"><i class="fas fa-university"></i> NẠP THÊM TIỀN</button>
                    <?php else: ?>
                        <button class="modal__btn modal__btn--submit" onclick="submitInstallment()"><i class="fas fa-check-circle"></i> XÁC NHẬN TRẢ GÓP</button>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="modal__btn modal__btn--submit" href="<?php echo e(route('login')); ?>"><i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP</a>
                <?php endif; ?>
                <button class="modal__btn modal__btn--close" onclick="closeInstallmentModal()"><i class="fas fa-times"></i> ĐÓNG</button>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                // Initialize the lightbox for account images
                galleryLightbox = new SimpleLightbox('.detail__images-link', {
                    captionPosition: 'bottom',
                    captionsData: 'alt',
                    closeText: '×',
                    navText: ['←', '→'],
                    animationSpeed: 250,
                    enableKeyboard: true,
                    scaleImageToRatio: true,
                    disableRightClick: true
                });
            });

            function buyAccount(accountId) {
                const modal = document.getElementById('purchaseModal');
                if (modal) {
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                    // Initialize discount handler
                    initDiscountHandler('account', accountId, <?php echo e($account->price); ?>);
                }
            }

            function submitPurchase() {
                const accountId = <?php echo e($account->id); ?>;
                
                let finalDiscountCode = '';
                if (typeof discountHandler !== 'undefined' && discountHandler.discountCode) {
                    finalDiscountCode = discountHandler.discountCode;
                } else {
                    const dcInput = document.getElementById('discount-code');
                    if (dcInput) finalDiscountCode = dcInput.value.trim();
                }

                fetch(`/account/${accountId}/purchase`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({
                            discount_code: finalDiscountCode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (typeof FuiToast !== 'undefined') {
                                FuiToast.success(data.message || 'Mua tài khoản thành công!');
                            } else {
                                alert('Thành công! ' + data.message);
                            }
                            
                            // Đổi nút thành Đang xử lý
                            const submitBtn = document.querySelector('.modal__btn--submit');
                            if(submitBtn) {
                                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ĐANG CHUYỂN HƯỚNG...';
                                submitBtn.disabled = true;
                            }

                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 1500);
                        } else {
                            if (typeof FuiToast !== 'undefined') {
                                FuiToast.error(data.message || 'Giao dịch thất bại!');
                            } else {
                                alert('Lỗi! ' + data.message);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (typeof FuiToast !== 'undefined') {
                            FuiToast.error('Đã xảy ra lỗi kết nối, vui lòng thử lại sau!');
                        } else {
                            alert('Lỗi! Đã xảy ra lỗi khi xử lý giao dịch');
                        }
                    });
            }

            function showRechargeModal(type) {
                // Open the depositMethodModal defined in app.blade.php
                const depositModal = document.getElementById('depositMethodModal');
                if (depositModal) {
                    depositModal.style.display = 'flex';
                }
            }

            function closePurchaseModal() {
                const modal = document.getElementById('purchaseModal');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }

            // Close modal when clicking outside
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('purchaseModal');
                const instModal = document.getElementById('installmentModal');
                window.addEventListener('click', function(event) {
                    if (event.target === modal) closePurchaseModal();
                    if (event.target === instModal) closeInstallmentModal();
                });
            });

            function showInstallmentModal() {
                const modal = document.getElementById('installmentModal');
                if (modal) {
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeInstallmentModal() {
                const modal = document.getElementById('installmentModal');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }

            function submitInstallment() {
                const accountId = <?php echo e($account->id); ?>;
                const duration = document.getElementById('installmentDuration').value;
                const btn = document.querySelector('#installmentModal .modal__btn--submit');

                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ĐANG XỬ LÝ...';
                btn.disabled = true;

                fetch(`/installment/${accountId}/create`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({ duration: duration })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        if(typeof FuiToast !== 'undefined') FuiToast.success(data.message);
                        setTimeout(() => window.location.href = data.redirect_url, 1500);
                    } else {
                        if(typeof FuiToast !== 'undefined') FuiToast.error(data.message);
                        btn.innerHTML = '<i class="fas fa-check-circle"></i> XÁC NHẬN TRẢ GÓP';
                        btn.disabled = false;
                    }
                })
                .catch(err => {
                    if(typeof FuiToast !== 'undefined') FuiToast.error('Đã xảy ra lỗi, vui lòng thử lại!');
                    btn.innerHTML = '<i class="fas fa-check-circle"></i> XÁC NHẬN TRẢ GÓP';
                    btn.disabled = false;
                });
            }
        </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/user/account/detail.blade.php ENDPATH**/ ?>