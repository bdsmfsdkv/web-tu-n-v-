@extends('layouts.user.app')

@section('title', 'Chi tiết tài khoản #' . $account->id)

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
        <a href="{{ route('category.index', ['slug' => $account->category->slug ?? '']) }}" class="breadcrumb-link">{{ $account->category->name ?? 'Danh Mục' }}</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Tài khoản #{{ $account->id }}</span>
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
                    <div class="ecom-price-row">
                        @php
                            $discountPercent = config_get('payment.card.discount_percent');
                            $cardPrice = $account->price / ((100 - $discountPercent) / 100);
                            $discountRatio = round(100 - ($account->price / $cardPrice) * 100);
                        @endphp
                        <span class="old-price">{{ number_format($cardPrice) }}đ</span>
                        <span class="new-price">{{ number_format($account->price) }}đ</span>
                        <span class="discount-badge">-{{ $discountRatio }}%</span>
                    </div>
                    <div class="ecom-price-subtitle">Rẻ vô đối, giá tốt nhất thị trường</div>
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
                        {{-- <button class="ecom-btn" style="margin-top: 10px; width: 100%; background: #3b82f6; border-color: #3b82f6; color: white;" onclick="showInstallmentModal()">
                            <i class="fas fa-hand-holding-usd"></i> Mua Trả Góp<br>
                            <small>Trả trước từ {{ number_format($account->price * 0.2) }} Đ</small>
                        </button> --}}
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
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title">XÁC NHẬN MUA TÀI KHOẢN #{{ $account->id }}</h2>
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
                        <span class="modal__value">{{ $account->category->name ?? 'Tài khoản Game' }}</span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Giá tiền:</span>
                        <span class="modal__value modal__value--price"
                            id="account-price">{{ number_format($account->price) }} đ</span>
                    </div>
                </div>

                <div class="modal__discount">
                    <div class="discount-input-group" style="display: flex; gap: 10px;">
                        <input type="text" id="discount-code" class="modal__input" placeholder="Nhập mã giảm giá nếu có" style="flex: 1; padding: 8px 12px; border-radius: 4px; border: 1px solid #d9d9d9;">
                        <button class="modal__btn--check" onclick="checkDiscountCode('account')" style="padding: 8px 16px; border-radius: 4px; border: 1px solid #d9d9d9; background: #f5f5f5; cursor: pointer;">Áp dụng</button>
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
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

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
                    initDiscountHandler('account', accountId, {{ $account->price }});
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

                fetch(`/account/${accountId}/purchase`, {
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
                                closePurchaseModal();
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
                window.location.href = '{{ route('profile.deposit-atm') }}';
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
