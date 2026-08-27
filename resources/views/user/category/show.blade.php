@extends('layouts.user.app')

@section('title', $category->name)

@push('css')
    <link href="/css/category-attribute-fix.css?v={{ filemtime(public_path('css/category-attribute-fix.css')) }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Hero Section -->
    <x-hero-header :title="$category->name" :description="$category->description" />

    <!-- Account List Section -->
    <section class="account-section">
        <div class="container">
            <!-- Filter Bar -->
            <form action="" method="GET" class="filter-inline-bar">
                <input type="text" name="code" class="filter-input" placeholder="Nhập mã số..." value="{{ request('code') }}">
                
                <select name="price_range" class="filter-select">
                    <option value="">Khoảng giá (Tất cả)</option>
                    <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>Dưới 50K</option>
                    <option value="50000-200000" {{ request('price_range') == '50000-200000' ? 'selected' : '' }}>50K - 200K</option>
                    <option value="200000-500000" {{ request('price_range') == '200000-500000' ? 'selected' : '' }}>200K - 500K</option>
                    <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>500K - 1 Triệu</option>
                    <option value="1000000" {{ request('price_range') == '1000000' ? 'selected' : '' }}>Trên 1 Triệu</option>
                </select>

                @php
                    $presetAttrs = [];
                    if (isset($presetConfig) && isset($presetConfig['attributes'])) {
                        foreach ($presetConfig['attributes'] as $attr) {
                            $presetAttrs[$attr['key']] = $attr;
                        }
                    }
                @endphp

                @foreach($dynamicKeys as $key)
                    @php
                        $attrMeta = $presetAttrs[$key] ?? null;
                        $hasOptions = $attrMeta && !empty($attrMeta['options']);
                        $currentVal = request("details.{$key}");
                    @endphp

                    @if($hasOptions)
                        <select name="details[{{ $key }}]" class="filter-select">
                            <option value="">{{ $attrMeta['label'] ?? $key }} (Tất cả)</option>
                            @foreach($attrMeta['options'] as $opt)
                                <option value="{{ $opt }}" {{ $currentVal == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" name="details[{{ $key }}]" class="filter-input" placeholder="Tìm {{ $key }}..." value="{{ $currentVal }}">
                    @endif
                @endforeach

                <select name="status" class="filter-select">
                    <option value="">Trạng Thái</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Chưa bán</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Đã bán</option>
                </select>

                <button type="submit" class="filter-btn filter-btn-search">
                    <i class="fa-solid fa-search"></i> Tìm kiếm
                </button>
                <a href="{{ request()->url() }}" class="filter-btn filter-btn-reset">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            </form>

            <!-- Account Grid -->
            <div class="account-grid">
                @php
                    $discountPercent = config_get('payment.card.discount_percent', 0);
                @endphp

                @forelse($accounts as $account)
                    @php
                        $cardPrice = ($discountPercent < 100 && $discountPercent > 0)
                            ? $account->price / ((100 - $discountPercent) / 100)
                            : $account->price * 1.25;
                        $discountRatio = $cardPrice > 0 ? round(100 - ($account->price / $cardPrice) * 100) : 0;
                        $details = is_array($account->details) ? $account->details : (json_decode($account->details, true) ?? []);
                    @endphp

                    <div class="account-card" data-id="{{ $account->id }}">
                        <!-- Media & Badges -->
                        <div class="account-media">
                            <a href="{{ route('account.show', ['id' => $account->id]) }}" class="account-img-link" title="Xem chi tiết tài khoản #{{ $account->id }}">
                                <img src="{{ $account->thumb }}" alt="Tài khoản #{{ $account->id }}" class="account-img" {{ $loop->index < 6 ? 'fetchpriority=high decoding=async' : 'loading=lazy decoding=async' }}>
                            </a>
                            
                            <div class="account-badge-code">
                                <i class="fa-solid fa-hashtag"></i> {{ $account->id }}
                            </div>

                            @if(!empty($account->is_flash_sale))
                                <div class="account-badge-tag badge-flash"><i class="fa-solid fa-bolt"></i> Flash Sale</div>
                            @elseif($discountRatio > 0)
                                <div class="account-badge-tag badge-discount">-{{ $discountRatio }}%</div>
                            @else
                                <div class="account-badge-tag badge-hot"><i class="fa-solid fa-fire"></i> Hot</div>
                            @endif
                        </div>

                        <!-- Attributes Grid -->
                        <div class="account-info">
                            @if(count($details) > 0)
                                <div class="account-details-grid">
                                    @foreach(array_slice($details, 0, 4) as $detail)
                                        <div class="account-detail-tile" title="{{ $detail['key'] ?? '' }}: {{ $detail['value'] ?? '' }}">
                                            <span class="account-detail-label">{{ $detail['key'] ?? '' }}</span>
                                            <span class="account-detail-value">{{ $detail['value'] ?? '-' }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Pricing Section -->
                        <div class="account-pricing-section">
                            <div class="price-atm-wrap">
                                <span class="price-label-atm">ATM / Ví Momo</span>
                                <span class="price-value-atm">{{ number_format($account->price) }}<small>đ</small></span>
                            </div>
                            <div class="price-card-wrap">
                                <span class="price-label-card">Thẻ cào</span>
                                <span class="price-value-card">{{ number_format($cardPrice) }}đ</span>
                            </div>
                        </div>

                        <!-- Action Buttons (CTA) -->
                        <div class="account-actions-btns">
                            <a href="{{ route('account.show', ['id' => $account->id]) }}" class="btn-card-action btn-card-detail">
                                <i class="fa-solid fa-eye"></i> Chi tiết
                            </a>
                            <button type="button" 
                                class="btn-card-action btn-card-buy" 
                                data-id="{{ $account->id }}"
                                data-price="{{ (float)$account->price }}"
                                data-price-formatted="{{ number_format($account->price) }}"
                                data-thumb="{{ $account->thumb }}"
                                data-category="{{ $category->name ?? 'Tài khoản Game' }}"
                                onclick="openQuickBuyModal(this)">
                                <i class="fa-solid fa-bolt"></i> Mua ngay
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="no-data-empty" style="text-align: center; padding: 60px 0; grid-column: 1 / -1; width: 100%;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px; color: #a0aec0; margin-bottom: 16px;">
                            <path d="M21 8v13H3V8"></path>
                            <path d="M1 3h22v5H1z"></path>
                            <path d="M10 12h4v4h-4z"></path>
                        </svg>
                        <p style="color: #a0aec0; font-size: 1rem; margin: 0;">Chưa có tài khoản nào trong danh mục này</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center; width: 100%; margin-top: 24px;">
                {{ $accounts->links('user.pagination.custom') }}
            </div>
        </div>
    </section>

    <!-- Quick Buy Modal (Popup Mua Nhanh 1-Click) -->
    <div id="quickBuyModal" class="quick-buy-modal">
        <div class="quick-buy-backdrop" onclick="closeQuickBuyModal()"></div>
        <div class="quick-buy-dialog">
            <div class="quick-buy-header">
                <div class="quick-buy-title">
                    <i class="fa-solid fa-bolt" style="color: #ef4444;"></i> Mua Nhanh Tài Khoản <span id="qb-account-id-title" style="color: #ef4444;">#0</span>
                </div>
                <button type="button" class="quick-buy-close" onclick="closeQuickBuyModal()">&times;</button>
            </div>

            <div class="quick-buy-body">
                <!-- Summary Card -->
                <div class="qb-summary-card">
                    <img id="qb-account-thumb" src="" alt="Thumbnail" class="qb-thumb">
                    <div class="qb-summary-info">
                        <div class="qb-category-name" id="qb-category-name">Game</div>
                        <div class="qb-code-badge">Mã số: <strong id="qb-account-id-badge">#0</strong></div>
                        <div class="qb-price-display">
                            <span class="qb-price-label">Giá ATM/Ví:</span>
                            <span class="qb-price-val" id="qb-price-display">0đ</span>
                        </div>
                    </div>
                </div>

                <!-- Discount Code Box -->
                <div class="qb-discount-box">
                    <div class="qb-discount-input-wrap">
                        <input type="text" id="qb-discount-input" placeholder="Nhập mã giảm giá (nếu có)..." class="qb-input" onkeydown="if(event.key==='Enter'){event.preventDefault(); applyQuickDiscount();}">
                        <button type="button" id="qb-discount-btn" class="qb-btn-apply" onclick="applyQuickDiscount()">Áp dụng</button>
                    </div>
                    <div id="qb-discount-msg" class="qb-msg"></div>
                </div>

                <!-- User Balance Section -->
                @auth
                    <div class="qb-balance-box">
                        <div class="qb-balance-row">
                            <span style="color: #64748b; font-weight: 500;">Số dư hiện tại:</span>
                            <strong style="color: #16a34a; font-size: 1rem;">{{ number_format(Auth::user()->balance) }}đ</strong>
                        </div>
                        <div id="qb-balance-status" class="qb-balance-status">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>
                @else
                    <div class="qb-guest-notice">
                        <i class="fa-solid fa-circle-info" style="font-size: 1.2rem;"></i>
                        <div>
                            <strong>Bạn chưa đăng nhập</strong><br>
                            Vui lòng đăng nhập để thực hiện giao dịch mua tài khoản.
                        </div>
                    </div>
                @endauth
            </div>

            <div class="quick-buy-footer">
                @auth
                    <div id="qb-auth-actions" style="display: flex; gap: 8px; width: 100%;">
                        <!-- Populated by JS -->
                    </div>
                @else
                    <a href="{{ route('login') }}" class="qb-btn qb-btn-primary" style="text-decoration: none;">
                        <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập ngay
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Quick Buy JavaScript Logic -->
    <script>
        const QUICK_BUY_CONFIG = {
            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            userBalance: {{ Auth::check() ? (float)Auth::user()->balance : 0 }},
            csrfToken: '{{ csrf_token() }}',
            depositAtmUrl: '{{ route('profile.deposit-atm') }}',
            depositCardUrl: '{{ route('profile.deposit-card') }}',
            validateDiscountUrl: '/discount-code/validate'
        };

        let currentQuickAccount = {
            id: 0,
            originalPrice: 0,
            finalPrice: 0,
            appliedDiscountCode: ''
        };

        function openQuickBuyModal(trigger) {
            let id, priceFormatted, priceNumber, thumbUrl, categoryName;

            if (typeof trigger === 'object' && trigger !== null) {
                id = trigger.getAttribute('data-id');
                priceNumber = parseFloat(trigger.getAttribute('data-price')) || 0;
                priceFormatted = trigger.getAttribute('data-price-formatted') || new Intl.NumberFormat('vi-VN').format(priceNumber);
                thumbUrl = trigger.getAttribute('data-thumb') || '';
                categoryName = trigger.getAttribute('data-category') || 'Tài khoản Game';
            } else {
                id = arguments[0];
                priceFormatted = arguments[1];
                priceNumber = arguments[2];
                thumbUrl = arguments[3];
                categoryName = arguments[4];
            }

            currentQuickAccount.id = id;
            currentQuickAccount.originalPrice = priceNumber;
            currentQuickAccount.finalPrice = priceNumber;
            currentQuickAccount.appliedDiscountCode = '';

            // Populate UI Elements
            document.getElementById('qb-account-id-title').innerText = '#' + id;
            document.getElementById('qb-account-id-badge').innerText = '#' + id;
            document.getElementById('qb-category-name').innerText = categoryName;
            document.getElementById('qb-account-thumb').src = thumbUrl;
            document.getElementById('qb-price-display').innerText = priceFormatted + 'đ';

            const discountInput = document.getElementById('qb-discount-input');
            if (discountInput) discountInput.value = '';
            
            const msgEl = document.getElementById('qb-discount-msg');
            if (msgEl) {
                msgEl.innerText = '';
                msgEl.className = 'qb-msg';
            }

            updateQuickBuyBalanceUI();

            const modal = document.getElementById('quickBuyModal');
            if (modal) {
                modal.classList.add('active');
            }
        }

        function closeQuickBuyModal() {
            const modal = document.getElementById('quickBuyModal');
            if (modal) {
                modal.classList.remove('active');
            }
        }

        function updateQuickBuyBalanceUI() {
            if (!QUICK_BUY_CONFIG.isLoggedIn) return;

            const statusEl = document.getElementById('qb-balance-status');
            const actionsEl = document.getElementById('qb-auth-actions');
            if (!statusEl || !actionsEl) return;

            const diff = QUICK_BUY_CONFIG.userBalance - currentQuickAccount.finalPrice;

            if (diff >= 0) {
                statusEl.innerHTML = `<span style="color: #16a34a;"><i class="fa-solid fa-circle-check"></i> Đủ tiền thanh toán (Số dư sau mua: <strong>${new Intl.NumberFormat('vi-VN').format(diff)}đ</strong>)</span>`;
                actionsEl.innerHTML = `
                    <button type="button" class="qb-btn qb-btn-submit" id="btn-submit-quick-buy" onclick="executeQuickBuy()">
                        <i class="fa-solid fa-bolt"></i> XÁC NHẬN MUA NGAY
                    </button>
                `;
            } else {
                const missing = Math.abs(diff);
                statusEl.innerHTML = `<span style="color: #dc2626;"><i class="fa-solid fa-triangle-exclamation"></i> Thiếu <strong>${new Intl.NumberFormat('vi-VN').format(missing)}đ</strong> để mua tài khoản này.</span>`;
                actionsEl.innerHTML = `
                    <a href="${QUICK_BUY_CONFIG.depositAtmUrl}" class="qb-btn qb-btn-atm" style="text-decoration:none;">
                        <i class="fa-solid fa-building-columns"></i> Nạp ATM/Momo
                    </a>
                    <a href="${QUICK_BUY_CONFIG.depositCardUrl}" class="qb-btn qb-btn-card" style="text-decoration:none;">
                        <i class="fa-solid fa-credit-card"></i> Nạp Thẻ Cào
                    </a>
                `;
            }
        }

        function applyQuickDiscount() {
            const codeInput = document.getElementById('qb-discount-input');
            const code = codeInput ? codeInput.value.trim() : '';
            const msgEl = document.getElementById('qb-discount-msg');
            const btnEl = document.getElementById('qb-discount-btn');

            if (!code) {
                if (msgEl) {
                    msgEl.innerText = 'Vui lòng nhập mã giảm giá';
                    msgEl.className = 'qb-msg error';
                }
                return;
            }

            btnEl.disabled = true;
            btnEl.innerText = 'Đang ktra...';

            fetch(QUICK_BUY_CONFIG.validateDiscountUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': QUICK_BUY_CONFIG.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    code: code,
                    context: 'account',
                    item_id: currentQuickAccount.id
                })
            })
            .then(res => res.json())
            .then(data => {
                btnEl.disabled = false;
                btnEl.innerText = 'Áp dụng';

                if (data.success) {
                    currentQuickAccount.appliedDiscountCode = code;
                    const discountAmt = data.data.discount_amount || 0;
                    currentQuickAccount.finalPrice = Math.max(0, currentQuickAccount.originalPrice - discountAmt);

                    document.getElementById('qb-price-display').innerHTML = `
                        <span style="text-decoration: line-through; color: #94a3b8; font-size: 0.82rem; margin-right: 4px;">
                            ${new Intl.NumberFormat('vi-VN').format(currentQuickAccount.originalPrice)}đ
                        </span>
                        <span>${new Intl.NumberFormat('vi-VN').format(currentQuickAccount.finalPrice)}đ</span>
                    `;

                    if (msgEl) {
                        msgEl.innerText = `Áp dụng thành công! Giảm ${new Intl.NumberFormat('vi-VN').format(discountAmt)}đ`;
                        msgEl.className = 'qb-msg success';
                    }
                    updateQuickBuyBalanceUI();
                } else {
                    if (msgEl) {
                        msgEl.innerText = data.message || 'Mã giảm giá không hợp lệ';
                        msgEl.className = 'qb-msg error';
                    }
                }
            })
            .catch(err => {
                btnEl.disabled = false;
                btnEl.innerText = 'Áp dụng';
                if (msgEl) {
                    msgEl.innerText = 'Lỗi kết nối kiểm tra mã giảm giá';
                    msgEl.className = 'qb-msg error';
                }
            });
        }

        function executeQuickBuy() {
            const submitBtn = document.getElementById('btn-submit-quick-buy');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> ĐANG XỬ LÝ...';
            }

            fetch(`/account/${currentQuickAccount.id}/purchase`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': QUICK_BUY_CONFIG.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    discount_code: currentQuickAccount.appliedDiscountCode,
                    return_url: window.location.pathname + window.location.search + window.location.hash
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (typeof FuiToast !== 'undefined') {
                        FuiToast.success(data.message || 'Mua tài khoản thành công!');
                    } else {
                        alert(data.message || 'Mua tài khoản thành công!');
                    }
                    setTimeout(() => {
                        sessionStorage.setItem('refreshPurchaseSource', '1');
                        sessionStorage.setItem('purchaseReturnScrollY', String(window.scrollY));
                        window.location.assign(data.redirect_url || '/profile/purchased-accounts');
                    }, 1000);
                } else {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fa-solid fa-bolt"></i> XÁC NHẬN MUA NGAY';
                    }
                    if (typeof FuiToast !== 'undefined') {
                        FuiToast.error(data.message || 'Giao dịch thất bại!');
                    } else {
                        alert('Lỗi: ' + (data.message || 'Giao dịch thất bại!'));
                    }
                }
            })
            .catch(err => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa-solid fa-bolt"></i> XÁC NHẬN MUA NGAY';
                }
                if (typeof FuiToast !== 'undefined') {
                    FuiToast.error('Đã xảy ra lỗi kết nối, vui lòng thử lại sau!');
                } else {
                    alert('Đã xảy ra lỗi kết nối!');
                }
            });
        }

        // Close modal on Escape key press
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeQuickBuyModal();
        });
    </script>
@endsection
