@extends('layouts.user.app')

@section('title', 'Chi tiết tài khoản #' . $account->id)

@push('css')
    <link href="{{ asset('css/related-account-cards.css') }}?v={{ filemtime(public_path('css/related-account-cards.css')) }}" rel="stylesheet">
@endpush

@section('content')
<!-- SimpleLightbox Library -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.js"></script>

<div class="container account-detail-page-container">
    <!-- Breadcrumb & Quay lai button -->
    <div class="account-detail-header-bar">
        <div class="page-breadcrumb">
            <a href="/" class="breadcrumb-link"><i class="fas fa-home"></i> <span>Trang Chủ</span></a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ $categoryUrl ?? route('category.index', ['slug' => $account->category->slug ?? '']) }}" class="breadcrumb-link">{{ $account->category->name ?? 'Danh Mục' }}</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">#{{ $account->id }}</span>
        </div>
        <a href="{{ $categoryUrl ?? route('category.index', ['slug' => $account->category->slug ?? '']) }}" class="detail-back-link">
            <i class="fas fa-arrow-left"></i> <span class="back-text-full">Quay lại {{ $account->category->name ?? 'danh mục' }}</span><span class="back-text-short">Quay lại</span>
        </a>
    </div>

    <div class="ecom-layout">
        <!-- Left Column -->
        <div class="ecom-left">
            <!-- Gallery Box -->
            <div class="ecom-box ecom-gallery-box">
                <div class="ecom-gallery-inner">
                    <!-- Vertical Thumbnails -->
                    <div class="ecom-thumbs-vertical">
                        @foreach (array_slice($images, 0, 8) as $index => $image)
                            <img src="{{ $image }}" class="ecom-thumb" onclick="changeMainImage('{{ $image }}', {{ $index }})" alt="Ảnh tài khoản {{ $index + 1 }}" width="80" height="50" loading="{{ $index === 0 ? 'eager' : 'lazy' }}" decoding="async">
                        @endforeach
                    </div>
                    <!-- Main Image -->
                    <div class="ecom-main-img-wrapper" style="cursor: pointer;" onclick="openLightbox()">
                        <img src="{{ $images[0] ?? '' }}" id="ecom-main-img" class="ecom-main-img" alt="Ảnh tài khoản #{{ $account->id }}" width="800" height="450" fetchpriority="high" decoding="async">
                        <div class="ecom-img-count"><i class="far fa-images"></i> 1/{{ count($images) }}</div>
                    </div>

                    <!-- Hidden Full Gallery for Lightbox -->
                    <div id="lightbox-gallery" style="display: none;">
                        @foreach ($images as $image)
                            <a href="{{ $image }}" class="detail__images-link">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Note Box -->
            @if ($account->note)
            <div class="ecom-box ecom-note-box" style="margin-top: 20px;">
                <h3 class="ecom-box-title">Chi tiết dịch vụ</h3>
                <div class="ecom-note-content">{!! nl2br(e($account->note)) !!}</div>
            </div>
            @endif
            
            <!-- Related Accounts Grid -->
            @if(isset($relatedAccounts) && $relatedAccounts->count() > 0)
            <div class="ecom-box ecom-all-images-box" style="margin-top: 20px; border-color: transparent;">
                <h3 class="ecom-box-title" style="font-size: 1.3rem;">Tài khoản cùng danh mục</h3>
                <div class="related-accounts">
                    @foreach ($relatedAccounts as $related)
                        <article class="related-account-card">
                            <a href="{{ route('account.show', ['id' => $related->id]) }}" class="related-account-image">
                                <img src="{{ $related->thumb ?: asset('assets/images/default.jpg') }}" alt="Tài khoản #{{ $related->id }}" loading="lazy" decoding="async">
                                <span class="related-account-code">Mã #{{ $related->id }}</span>
                            </a>
                            <div class="related-account-content">
                                <div class="related-account-price">{{ number_format($related->price) }}đ</div>
                                <a href="{{ route('account.show', ['id' => $related->id]) }}" class="related-account-link">Xem chi tiết</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="ecom-right">
            <div class="ecom-box ecom-info-box">
                <h1 class="ecom-title">{{ $account->category->name ?? 'Tài khoản Game' }}</h1>
                <div class="ecom-id">Mã số: <strong>#{{ $account->category->slug ?? 'YSO' }}{{ $account->id }}</strong></div>
                
                <hr class="ecom-divider">

                <div class="ecom-attr-header">Thông tin acc</div>
                <div class="ecom-attr-list">
                    @php
                        $details = is_array($account->details) ? $account->details : json_decode($account->details, true) ?? [];
                    @endphp
                    @foreach($details as $detail)
                        <div class="ecom-attr-row">
                            <span class="ecom-attr-label">{{ mb_strtoupper($detail['key'] ?? '') }}</span>
                            <span class="ecom-attr-value">{{ $detail['value'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="ecom-price-box">
                    @php
                        $discountPercent = (float) config_get('payment.card.discount_percent', 0);
                        $cardPrice = ($discountPercent > 0 && $discountPercent < 100) 
                            ? round($account->price / ((100 - $discountPercent) / 100)) 
                            : $account->price;
                        $hasDiscount = $cardPrice > $account->price;
                        $discountRatio = $hasDiscount ? round((($cardPrice - $account->price) / $cardPrice) * 100) : 0;
                    @endphp
                    <div class="ecom-price-row">
                        @if($hasDiscount && $discountRatio > 0)
                            <span class="old-price">{{ number_format($cardPrice) }}đ</span>
                            <span class="new-price">{{ number_format($account->price) }}đ</span>
                            <span class="discount-badge">-{{ $discountRatio }}%</span>
                        @else
                            <span class="new-price">{{ number_format($account->price) }}đ</span>
                            <span class="discount-badge price-best-badge">
                                <i class="fa-solid fa-shield-halved me-1"></i> GIÁ TỐT NHẤT
                            </span>
                        @endif
                    </div>
                    <div class="ecom-price-subtitle">
                        @if($hasDiscount && $discountRatio > 0)
                            <i class="fa-solid fa-credit-card me-1"></i> Thẻ cào: <strong>{{ number_format($cardPrice) }}đ</strong> | Thanh toán qua ATM/MoMo tiết kiệm <strong>{{ $discountRatio }}%</strong>
                        @else
                            <i class="fa-solid fa-circle-check text-success me-1"></i> Rẻ vô đối, thanh toán tự động 24/7 nhận tài khoản ngay
                        @endif
                    </div>
                </div>

                <hr class="ecom-divider">

                <div class="ecom-actions">
                    @if ($account->status === 'available')
                        <div class="ecom-action-row-1">
                            <a href="{{ route('profile.deposit-card') }}" class="ecom-btn-action ecom-btn-outline">
                                <i class="fas fa-credit-card"></i> <span>Nạp Thẻ</span>
                            </a>
                            <button type="button" class="ecom-btn-action ecom-btn-solid" onclick="buyAccount({{ $account->id }})">
                                <i class="fas fa-bolt"></i> <span>Mua Ngay</span>
                            </button>
                        </div>
                        <div class="ecom-or-divider">--- HOẶC NẠP NHANH ---</div>
                        <a href="{{ route('profile.deposit-atm') }}" class="ecom-btn-atm">
                            <span class="atm-btn-title"><i class="fas fa-qrcode"></i> NẠP TIỀN ATM / QR / MOMO TỰ ĐỘNG</span>
                            <small class="atm-btn-sub">Giá chỉ: <strong>{{ number_format($account->price) }}đ</strong></small>
                        </a>
                    @else
                        <div class="detail__purchased" style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; padding: 18px; border-radius: 12px; text-align: center; font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-lock"></i> TÀI KHOẢN NÀY ĐÃ ĐƯỢC BÁN
                        </div>
                    @endif
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
            countElement.innerHTML = '<i class="far fa-images"></i> ' + (index + 1) + '/{{ count($images) }}';
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
    @if ($account->status === 'available')
    <div id="purchaseModal" class="modal-modern">
        <div class="modal__content" style="border-radius: 16px; border: 1px solid rgba(226,232,240,0.8); box-shadow: 0 10px 40px rgba(0,0,0,0.3); overflow: hidden;">
            <div class="modal__header" style="background: var(--primary, #dc2626); padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; color: #fff;">
                <h2 class="modal__title" style="font-size: 1.05rem; font-weight: 800; margin: 0; color: #fff; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-cart-shopping"></i> XÁC NHẬN MUA TÀI KHOẢN #{{ $account->id }}
                </h2>
                <button class="modal__close" onclick="closePurchaseModal()" style="border: none; background: none; font-size: 1.25rem; cursor: pointer; color: #fff; line-height: 1; padding: 2px 6px;"><i class="fas fa-times"></i></button>
            </div>

            <div class="modal__body" style="padding: 18px 20px;">
                <div class="modal__info" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; margin-bottom: 16px;">
                    <div class="modal__row" style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 10px;">
                        <span class="modal__label" style="color: #64748b; font-weight: 600; white-space: nowrap; flex-shrink: 0;">Danh mục:</span>
                        <span class="modal__value" style="font-weight: 700; color: #0f172a; text-align: right; word-break: break-word;">{{ $account->category->name ?? 'Tài khoản Game' }}</span>
                    </div>
                    <div class="modal__row" style="display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                        <span class="modal__label" style="color: #64748b; font-weight: 600; white-space: nowrap; flex-shrink: 0;">Giá thanh toán:</span>
                        <span class="modal__value modal__value--price" id="account-price" style="font-size: 1.25rem; font-weight: 900; color: #dc2626;">{{ number_format($account->price) }}đ</span>
                    </div>
                </div>

                <div class="modal__discount" style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem; color: #475569;">Mã giảm giá (nếu có)</label>
                    <div class="discount-input-group" style="display: flex; gap: 8px; width: 100%; align-items: stretch;">
                        <input type="text" id="discount-code" class="modal__input" placeholder="Nhập mã ưu đãi..." style="flex: 1 1 auto; min-width: 0; padding: 9px 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none; font-size: 0.88rem; box-sizing: border-box;">
                        <button class="modal__btn--check" onclick="checkDiscountCode('account')" style="flex: 0 0 auto; flex-shrink: 0; white-space: nowrap; padding: 9px 16px; border-radius: 8px; border: none; background: #334155; color: #fff; font-weight: 700; cursor: pointer; font-size: 0.85rem; box-sizing: border-box;">Áp dụng</button>
                    </div>
                    <div id="discount-message" class="modal__discount-message" style="margin-top: 6px; font-size: 0.82rem;"></div>
                </div>

                @auth
                    @if (Auth::user()->balance < $account->price)
                        <div class="modal__notice" style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.25); color: #dc2626; padding: 12px; border-radius: 8px; font-size: 0.85rem; line-height: 1.5; margin-bottom: 14px;">
                            <strong><i class="fas fa-exclamation-triangle"></i> Số dư hiện tại không đủ!</strong><br>
                            Bạn cần thêm <strong>{{ number_format($account->price - Auth::user()->balance) }}đ</strong> để hoàn tất mua tài khoản này.
                        </div>
                    @endif
                @else
                    <div class="modal__notice" style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.25); color: #2563eb; padding: 12px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 14px;">
                        <strong><i class="fas fa-info-circle"></i> Chưa đăng nhập</strong><br>
                        Vui lòng đăng nhập tài khoản để thực hiện giao dịch an toàn.
                    </div>
                @endauth
            </div>

            <div class="modal__footer" style="padding: 14px 20px 18px; border-top: 1px solid #f1f5f9; display: flex; gap: 8px; flex-wrap: nowrap;">
                @auth
                    @if (Auth::user()->balance < $account->price)
                        <a class="modal__btn modal__btn--card" href="{{ route('profile.deposit-card') }}" style="flex: 1; padding: 10px 12px; text-align: center; border-radius: 8px; font-weight: 700; text-decoration: none; background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; font-size: 0.85rem; white-space: nowrap;"><i class="fas fa-credit-card"></i> NẠP THẺ</a>
                        <a class="modal__btn modal__btn--wallet" href="{{ route('profile.deposit-atm') }}" style="flex: 1.3; padding: 10px 12px; text-align: center; border-radius: 8px; font-weight: 800; text-decoration: none; background: var(--brand-gradient, linear-gradient(135deg, #dc2626, #ef4444)); color: #fff; box-shadow: 0 4px 12px rgba(220,38,38,0.25); font-size: 0.85rem; white-space: nowrap;"><i class="fas fa-qrcode"></i> NẠP ATM / QR</a>
                    @else
                        <button class="modal__btn modal__btn--submit" onclick="submitPurchase()" style="flex: 2; padding: 11px 14px; border-radius: 8px; border: none; font-weight: 800; background: var(--brand-gradient, linear-gradient(135deg, #dc2626, #ef4444)); color: #fff; cursor: pointer; box-shadow: 0 4px 12px rgba(220,38,38,0.25); font-size: 0.9rem; white-space: nowrap;"><i class="fas fa-check-circle"></i> XÁC NHẬN MUA</button>
                    @endif
                @else
                    <a class="modal__btn modal__btn--submit" href="{{ route('login') }}" style="flex: 2; padding: 11px 14px; text-align: center; border-radius: 8px; border: none; font-weight: 800; background: var(--brand-gradient, linear-gradient(135deg, #dc2626, #ef4444)); color: #fff; text-decoration: none; font-size: 0.9rem; white-space: nowrap;"><i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP</a>
                @endauth
                <button class="modal__btn modal__btn--close" onclick="closePurchaseModal()" style="flex: 1; padding: 11px 14px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f1f5f9; color: #475569; font-weight: 700; cursor: pointer; font-size: 0.85rem; white-space: nowrap;">ĐÓNG</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Installment Modal -->
    <div id="installmentModal" class="modal-modern">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title">ĐĂNG KÝ TRẢ GÓP #{{ $account->id }}</h2>
                <button class="modal__close" onclick="closeInstallmentModal()"><i class="fas fa-times"></i></button>
            </div>

            <div class="modal__body">
                <div class="modal__info">
                    <div class="modal__row">
                        <span class="modal__label">Giá trị tài khoản:</span>
                        <span class="modal__value" style="color: #ef4444; font-weight: bold;">{{ number_format($account->price) }} đ</span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Trả trước (20%):</span>
                        <span class="modal__value" style="color: #10b981; font-weight: bold;">{{ number_format($account->price * 0.2) }} đ</span>
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

                @auth
                    @if (Auth::user()->balance < ($account->price * 0.2))
                        <div class="modal__notice">
                            <strong><i class="fas fa-exclamation-triangle"></i> Số dư không đủ!</strong><br>
                            Bạn cần tối thiểu {{ number_format($account->price * 0.2) }} đ để trả trước cho tài khoản này.
                        </div>
                    @endif
                @else
                    <div class="modal__notice">
                        <strong><i class="fas fa-info-circle"></i> Chưa đăng nhập</strong><br>
                        Vui lòng đăng nhập để thực hiện giao dịch.
                    </div>
                @endauth
            </div>

            <div class="modal__footer">
                @auth
                    @if (Auth::user()->balance < ($account->price * 0.2))
                        <a class="modal__btn modal__btn--wallet" href="{{ route('profile.deposit-atm') }}"><i class="fas fa-university"></i> NẠP THÊM TIỀN</a>
                    @else
                        <button class="modal__btn modal__btn--submit" onclick="submitInstallment()"><i class="fas fa-check-circle"></i> XÁC NHẬN TRẢ GÓP</button>
                    @endif
                @else
                    <a class="modal__btn modal__btn--submit" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP</a>
                @endauth
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
                    modal.classList.add('active');
                    // Initialize discount handler
                    if (typeof initDiscountHandler === 'function') {
                        initDiscountHandler('account', accountId, {{ $account->price }});
                    }
                }
            }

            function submitPurchase() {
                const accountId = {{ $account->id }};
                const submitBtn = document.querySelector('.modal__btn--submit');
                if (submitBtn && submitBtn.disabled) {
                    return;
                }
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ĐANG XỬ LÝ...';
                }
                
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
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            discount_code: finalDiscountCode,
                            return_url: @json($categoryUrl)
                        })
                    })
                    .then(async response => {
                        const data = await response.json().catch(() => null);
                        if (!data) {
                            throw new Error('Máy chủ trả về dữ liệu không hợp lệ.');
                        }
                        return data;
                    })
                    .then(data => {
                        if (data.success) {
                            if (typeof FuiToast !== 'undefined') {
                                FuiToast.success(data.message || 'Mua tài khoản thành công!');
                            } else {
                                alert('Thành công! ' + data.message);
                            }
                            
                            // Đổi nút thành Đang chuyển hướng
                            if(submitBtn) {
                                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ĐANG CHUYỂN HƯỚNG...';
                                submitBtn.disabled = true;
                            }

                            setTimeout(() => {
                                closePurchaseModal();
                                sessionStorage.setItem('refreshPurchaseSource', '1');
                                sessionStorage.setItem('purchaseReturnScrollY', '0');
                                window.location.assign(data.redirect_url);
                            }, 1500);
                        } else {
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> XÁC NHẬN MUA';
                            }
                            if (typeof FuiToast !== 'undefined') {
                                FuiToast.error(data.message || 'Giao dịch thất bại!');
                            } else {
                                alert('Lỗi! ' + data.message);
                            }
                        }
                    })
                    .catch(error => {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> XÁC NHẬN MUA';
                        }
                        console.error('Error:', error);
                        if (typeof FuiToast !== 'undefined') {
                            FuiToast.error(error.message || 'Đã xảy ra lỗi kết nối, vui lòng thử lại sau!');
                        } else {
                            alert('Lỗi! Đã xảy ra lỗi khi xử lý giao dịch');
                        }
                    });
            }

            function showRechargeModal(type) {
                window.location.href = '{{ route('profile.deposit-atm') }}';
            }

            function closePurchaseModal() {
                const modal = document.getElementById('purchaseModal');
                if (modal) {
                    modal.classList.remove('active');
                }
                const dcInput = document.getElementById('discount-code');
                if (dcInput) dcInput.value = '';
                if (typeof discountHandler !== 'undefined') {
                    discountHandler.discountCode = '';
                    discountHandler.discountedPrice = {{ $account->price }};
                    discountHandler.updatePriceDisplay({{ $account->price }});
                    discountHandler.showMessage('', 'info');
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

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closePurchaseModal();
                    closeInstallmentModal();
                }
            });

            function showInstallmentModal() {
                const modal = document.getElementById('installmentModal');
                if (modal) {
                    modal.classList.add('active');
                }
            }

            function closeInstallmentModal() {
                const modal = document.getElementById('installmentModal');
                if (modal) {
                    modal.classList.remove('active');
                }
            }

            function submitInstallment() {
                const accountId = {{ $account->id }};
                const duration = document.getElementById('installmentDuration').value;
                const btn = document.querySelector('#installmentModal .modal__btn--submit');

                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ĐANG XỬ LÝ...';
                btn.disabled = true;

                fetch(`/installment/${accountId}/create`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
@endsection
