<?php $__env->startSection('title', 'Chi tiết tài khoản random #' . $account->id); ?>
<?php $__env->startPush('css'); ?>
<style>
    .detail__images-list {
        grid-template-columns: 1fr;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0 = $attributes; } ?>
<?php $component = App\View\Components\HeroHeader::resolve(['title' => 'THÔNG TIN TÀI KHOẢN RANDOM #'.e($account->id).'','description' => 'Tài khoản random từ danh mục '.e($account->category->name).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\HeroHeader::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0)): ?>
<?php $attributes = $__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0; ?>
<?php unset($__attributesOriginal676d920e8bb32a4c96cd6e6c6ba00de0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0)): ?>
<?php $component = $__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0; ?>
<?php unset($__componentOriginal676d920e8bb32a4c96cd6e6c6ba00de0); ?>
<?php endif; ?>

    <section class="detail">
        <div class="container">
            <div class="detail__content">
                <!-- Action Buttons -->
                <div class="detail__actions">
                    <?php if($account->status === 'available'): ?>
                        <button class="detail__btn detail__btn--primary" onclick="buyAccount(<?php echo e($account->id); ?>)">MUA
                            NGAY</button>
                        <a class="detail__btn detail__btn--card" href="<?php echo e(route('profile.deposit-card')); ?>">NẠP THẺ</a>
                        <button class="detail__btn detail__btn--wallet" onclick="showRechargeModal('wallet')">NẠP
                            ATM</button>
                    <?php else: ?>
                        <div class="detail__purchased">
                            <h2 class="detail__purchased-title">Tài khoản này đã được mua</h2>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Account Info -->
                <div class="detail__info">
                    <h2 class="detail__info-title">Thông tin tài khoản random</h2>

                    <div class="detail__info-row">
                        <div class="detail__info-label">ID:</div>
                        <div class="detail__info-value">#<?php echo e($account->id); ?></div>
                    </div>

                    <div class="detail__info-row">
                        <div class="detail__info-label">Danh mục:</div>
                        <div class="detail__info-value"><?php echo e($account->category->name); ?></div>
                    </div>

                    <div class="detail__info-row">
                        <div class="detail__info-label">Máy chủ:</div>
                        <div class="detail__info-value"><?php echo e($account->server); ?></div>
                    </div>

                    <div class="detail__info-row">
                        <div class="detail__info-label">Giá:</div>
                        <div class="detail__info-value account-price-value"><?php echo e(number_format($account->price)); ?>đ</div>
                    </div>

                    <?php if(!empty($account->note)): ?>
                        <div class="detail__info-row">
                            <div class="detail__info-label">Ghi chú:</div>
                            <div class="detail__info-value"><?php echo e($account->note); ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Account Preview -->
                <?php if($account->thumbnail): ?>
                    <div class="detail__images">
                        <h2 class="detail__images-title">Hình ảnh tài khoản random <span
                                class="text-danger">#<?php echo e($account->id); ?></span>
                        </h2>
                        <div class="detail__images-list">
                            <!-- Using data-src instead of src for SimpleLightbox -->
                            <a href="<?php echo e($account->thumbnail); ?>" title="Xem ảnh lớn" class="detail__images-link">
                                <img src="<?php echo e($account->thumbnail); ?>" alt="Tài khoản Random #<?php echo e($account->id); ?>"
                                    class="detail__images-item">
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Purchase Modal -->
    <div id="purchaseModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title">XÁC NHẬN MUA TÀI KHOẢN RANDOM #<?php echo e($account->id); ?></h2>
                <button class="modal__close" onclick="closePurchaseModal()">&times;</button>
            </div>

            <div class="modal__body">
                <div class="modal__info">
                    <div class="modal__row">
                        <span class="modal__label">Danh mục:</span>
                        <span class="modal__value"><?php echo e($account->category->name); ?></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Máy chủ:</span>
                        <span class="modal__value"><?php echo e($account->server); ?></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Giá tiền:</span>
                        <span class="modal__value modal__value--price"
                            id="account-price"><?php echo e(number_format($account->price)); ?>đ</span>
                    </div>
                </div>

                <div class="modal__discount">
                    <div class="modal__row">
                        <input type="text" id="discount-code" class="modal__input" placeholder="Nhập mã giảm giá nếu có">
                        <button class="modal__btn modal__btn--check" onclick="checkDiscountCode('random_account')">Kiểm
                            tra</button>
                    </div>
                    <div id="discount-message" class="modal__discount-message"></div>
                </div>

                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->balance < $account->price): ?>
                        <div class="modal__notice">
                            Bạn cần thêm <?php echo e(number_format($account->price - Auth::user()->balance)); ?>đ để mua tài khoản này.
                            Bạn hãy click vào nút nạp thẻ để nạp thêm và mua tài khoản.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="modal__notice">
                        Vui lòng đăng nhập để thực hiện giao dịch.
                    </div>
                <?php endif; ?>
            </div>

            <div class="modal__footer">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->balance < $account->price): ?>
                        <a class="modal__btn modal__btn--card" href="<?php echo e(route('profile.deposit-card')); ?>">NẠP THẺ CÀO</a>
                        <button class="modal__btn modal__btn--wallet" onclick="showRechargeModal('wallet')">NẠP ATM</button>
                    <?php else: ?>
                        <button class="modal__btn modal__btn--card" onclick="submitPurchase()">XÁC NHẬN
                            MUA</button>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="modal__btn modal__btn--wallet" href="<?php echo e(route('login')); ?>">ĐĂNG NHẬP</a>
                <?php endif; ?>
                <button class="modal__btn modal__btn--close" onclick="closePurchaseModal()">ĐÓNG</button>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the lightbox for detail images
            const lightbox = new SimpleLightbox('.detail__images-link', {
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
                initDiscountHandler('random_account', accountId, <?php echo e($account->price); ?>);
            }
        }

        function closePurchaseModal() {
            const modal = document.getElementById('purchaseModal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        function submitPurchase() {
            const accountId = <?php echo e($account->id); ?>;
            const discountInfo = getDiscountInfo();

            fetch(`/random/account/${accountId}/purchase`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        discount_code: discountInfo.discountCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (typeof FuiToast !== 'undefined') {
                            FuiToast.success('Thành công! ' + data.message);
                        } else {
                            alert('Thành công! ' + data.message);
                        }
                        window.location.href = data.redirect_url ||
                            '<?php echo e(route('profile.purchased-random-accounts')); ?>';
                    } else {
                        if (typeof FuiToast !== 'undefined') {
                            FuiToast.error(data.message);
                        } else {
                            alert('Lỗi! ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof FuiToast !== 'undefined') {
                        FuiToast.error('Đã xảy ra lỗi khi xử lý giao dịch');
                    } else {
                        alert('Lỗi! Đã xảy ra lỗi khi xử lý giao dịch');
                    }
                });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\user\random\detail.blade.php ENDPATH**/ ?>