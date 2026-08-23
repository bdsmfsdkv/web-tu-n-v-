@extends('layouts.user.app')

@section('title', 'Chi tiết tài khoản random #' . $account->id)

@push('css')
    <link href="{{ asset('css/related-account-cards.css') }}?v={{ filemtime(public_path('css/related-account-cards.css')) }}" rel="stylesheet">
@endpush

@section('content')
<!-- SimpleLightbox Library -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.js"></script>

<div class="container" style="padding-top: 24px; padding-bottom: 40px;">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb" style="margin-bottom: 24px;">
        <a href="/" class="breadcrumb-link"><i class="fas fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('random.index', ['slug' => $account->category->slug ?? '']) }}" class="breadcrumb-link">{{ $account->category->name ?? 'Danh Mục' }}</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Tài khoản #{{ $account->id }}</span>
    </div>

    <div class="ecom-layout">
        <!-- Left Column -->
        <div class="ecom-left">
            <!-- Gallery Box -->
            @php
                $displayImage = !empty($account->thumbnail) ? asset($account->thumbnail) : (!empty($account->category->thumbnail) ? asset($account->category->thumbnail) : 'https://via.placeholder.com/600x400');
            @endphp
            <div class="ecom-box ecom-gallery-box">
                <div class="ecom-gallery-inner">
                    <div class="ecom-thumbs-vertical">
                        <img src="{{ $displayImage }}" class="ecom-thumb" onclick="changeMainImage('{{ $displayImage }}', 0)" alt="Ảnh tài khoản" width="80" height="50" decoding="async">
                    </div>
                    <div class="ecom-main-img-wrapper" style="cursor: pointer;" onclick="openLightbox()">
                        <img src="{{ $displayImage }}" id="ecom-main-img" class="ecom-main-img" alt="Ảnh tài khoản #{{ $account->id }}" width="800" height="450" fetchpriority="high" decoding="async">
                        <div class="ecom-img-count"><i class="far fa-images"></i> 1/1</div>
                    </div>

                    <div id="lightbox-gallery" style="display: none;">
                        <a href="{{ $displayImage }}" class="detail__images-link">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Note Box -->
            @if ($account->note)
            <div class="ecom-box ecom-note-box" style="margin-top: 20px;">
                <h3 class="ecom-box-title">Chi tiết tài khoản / Ghi chú</h3>
                <div class="ecom-note-content">{!! nl2br(e($account->note)) !!}</div>
            </div>
            @endif
            
            <!-- Related Accounts Grid -->
            @if(isset($relatedAccounts) && $relatedAccounts->count() > 0)
            <div class="ecom-box ecom-all-images-box" style="margin-top: 20px; border-color: transparent;">
                <h3 class="ecom-box-title" style="font-size: 1.3rem;">Tài khoản cùng danh mục</h3>
                <div class="related-accounts">
                    @foreach ($relatedAccounts as $related)
                        @php
                            $relImg = !empty($related->thumbnail) ? asset($related->thumbnail) : (!empty($account->category->thumbnail) ? asset($account->category->thumbnail) : 'https://via.placeholder.com/300x180');
                        @endphp
                        <article class="related-account-card">
                            <a href="{{ route('random.account.show', ['id' => $related->id]) }}" class="related-account-image">
                                <img src="{{ $relImg }}" alt="Tài khoản #{{ $related->id }}" loading="lazy" decoding="async">
                                <span class="related-account-code">Mã #{{ $related->id }}</span>
                            </a>
                            <div class="related-account-content">
                                <div class="related-account-price">{{ number_format($related->price) }}đ</div>
                                <a href="{{ route('random.account.show', ['id' => $related->id]) }}" class="related-account-link">Xem chi tiết</a>
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
                <h1 class="ecom-title">{{ $account->category->name ?? 'Tài khoản Random' }}</h1>
                <div class="ecom-id">Mã số: <strong>#{{ $account->category->slug ?? 'RD' }}{{ $account->id }}</strong></div>
                
                <hr class="ecom-divider">

                <div class="ecom-attr-header">Thông tin</div>
                <div class="ecom-attr-list">
                    <div class="ecom-attr-row">
                        <span class="ecom-attr-label">DANH MỤC</span>
                        <span class="ecom-attr-value">{{ $account->category->name ?? 'Random' }}</span>
                    </div>
                    @if($account->server)
                    <div class="ecom-attr-row">
                        <span class="ecom-attr-label">MÁY CHỦ</span>
                        <span class="ecom-attr-value">{{ $account->server }}</span>
                    </div>
                    @endif
                    <div class="ecom-attr-row">
                        <span class="ecom-attr-label">TỈ LỆ TRÚNG</span>
                        <span class="ecom-attr-value" style="color: #10b981; font-weight: 700;">100% NHẬN NICK</span>
                    </div>
                </div>

                <div class="ecom-price-box">
                    <div class="ecom-price-row">
                        @php
                            $discountPercent = config_get('payment.card.discount_percent', 0);
                            $cardPrice = $account->price / ((100 - $discountPercent) / 100);
                            $discountRatio = round(100 - ($account->price / $cardPrice) * 100);
                        @endphp
                        <span class="old-price">{{ number_format($cardPrice) }}đ</span>
                        <span class="new-price">{{ number_format($account->price) }}đ</span>
                        @if($discountRatio > 0)
                        <span class="discount-badge">-{{ $discountRatio }}%</span>
                        @endif
                    </div>
                    <div class="ecom-price-subtitle">Tài khoản ngẫu nhiên, giá siêu rẻ</div>
                </div>

                <hr class="ecom-divider">

                <div class="ecom-actions">
                    @if ($account->status === 'available')
                        <div class="ecom-action-row-1">
                            <a href="{{ route('profile.deposit-card') }}" class="ecom-btn ecom-btn-outline"><i class="fas fa-shopping-cart"></i> Nạp thẻ</a>
                            <button class="ecom-btn ecom-btn-solid" onclick="buyAccount({{ $account->id }})">Mua Ngay</button>
                        </div>
                        <div class="ecom-or-divider">--- hoặc ---</div>
                        <a href="{{ route('profile.deposit-atm') }}" class="ecom-btn ecom-btn-atm" style="margin-top: 10px; width: 100%; background: #0bcfa5ffff; border-color: #0bcfa5ffff; color: white; text-decoration: none;">
                            Mua Bằng ATM, Momo<br>
                            <small>{{ number_format($account->price) }} Đ</small>
                        </a>
                    @else
                        <div class="detail__purchased" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; padding: 20px; border-radius: 8px; text-align: center; font-weight: 700; font-size: 1.1rem;">
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
            <h2 class="modal__title">XÁC NHẬN MUA TÀI KHOẢN #{{ $account->id }}</h2>
            <button class="modal__close" onclick="closePurchaseModal()"><i class="fas fa-times"></i></button>
        </div>

        <div class="modal__body">
            <div class="modal__info">
                <div class="modal__row">
                    <span class="modal__label">Danh mục:</span>
                    <span class="modal__value">{{ $account->category->name ?? 'Tài khoản Random' }}</span>
                </div>
                <div class="modal__row">
                    <span class="modal__label">Mã số acc:</span>
                    <span class="modal__value">#{{ $account->id }}</span>
                </div>
                <div class="modal__row">
                    <span class="modal__label">Giá tiền:</span>
                    <span class="modal__value modal__value--price" id="account-price">{{ number_format($account->price) }} đ</span>
                </div>
            </div>

            <div class="modal__discount">
                <div class="discount-input-group" style="display: flex; gap: 10px;">
                    <input type="text" id="discount-code" class="modal__input" placeholder="Nhập mã giảm giá nếu có" style="flex: 1; padding: 8px 12px; border-radius: 4px; border: 1px solid #d9d9d9;">
                    <button class="modal__btn--check" onclick="checkDiscountCode('random_account')" style="padding: 8px 16px; border-radius: 4px; border: 1px solid #d9d9d9; background: #f5f5f5; cursor: pointer;">Áp dụng</button>
                </div>
                <div id="discount-message" class="modal__discount-message" style="margin-top: 8px; font-size: 0.9rem;"></div>
            </div>

            @auth
                @if (Auth::user()->balance < $account->price)
                    <div class="modal__notice">
                        <strong><i class="fas fa-exclamation-triangle"></i> Số dư không đủ!</strong><br>
                        Bạn cần thêm {{ number_format($account->price - Auth::user()->balance) }} đ để mua tài khoản này.
                        Vui lòng nạp thêm tiền để tiếp tục.
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
                @if (Auth::user()->balance < $account->price)
                    <a class="modal__btn modal__btn--card" href="{{ route('profile.deposit-card') }}"><i class="fas fa-credit-card"></i> NẠP THẺ CÀO</a>
                    <a class="modal__btn modal__btn--wallet" href="{{ route('profile.deposit-atm') }}"><i class="fas fa-university"></i> NẠP ATM</a>
                @else
                    <button class="modal__btn modal__btn--submit" onclick="submitPurchase()"><i class="fas fa-check-circle"></i> XÁC NHẬN MUA</button>
                @endif
            @else
                <a class="modal__btn modal__btn--submit" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP</a>
            @endauth
            <button class="modal__btn modal__btn--close" onclick="closePurchaseModal()"><i class="fas fa-times"></i> ĐÓNG</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        const modal = document.getElementById('purchaseModal');
        window.addEventListener('click', function(event) {
            if (event.target === modal) closePurchaseModal();
        });
    });

    function buyAccount(accountId) {
        const modal = document.getElementById('purchaseModal');
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            initDiscountHandler('random_account', accountId, {{ $account->price }});
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
        const accountId = {{ $account->id }};
        let finalDiscountCode = '';
        if (typeof discountHandler !== 'undefined' && discountHandler.discountCode) {
            finalDiscountCode = discountHandler.discountCode;
        } else {
            const dcInput = document.getElementById('discount-code');
            if (dcInput) finalDiscountCode = dcInput.value.trim();
        }

        const submitBtn = document.querySelector('.modal__btn--submit');
        if(submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ĐANG XỬ LÝ...';
            submitBtn.disabled = true;
        }

        fetch(`/random/account/${accountId}/purchase`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                }
                setTimeout(() => {
                    window.location.href = data.redirect_url || '{{ route('profile.purchased-random-accounts') }}';
                }, 1500);
            } else {
                if (typeof FuiToast !== 'undefined') {
                    FuiToast.error(data.message || 'Giao dịch thất bại!');
                }
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> XÁC NHẬN MUA';
                    submitBtn.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof FuiToast !== 'undefined') {
                FuiToast.error('Đã xảy ra lỗi kết nối, vui lòng thử lại sau!');
            }
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> XÁC NHẬN MUA';
                submitBtn.disabled = false;
            }
        });
    }
</script>
@endpush
@endsection
