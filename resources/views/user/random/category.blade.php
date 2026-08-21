@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <x-hero-header :title="strtoupper($category->name)" description="" />

    <section class="section" style="padding: 40px 0;">
        <div class="container">
            <!-- Mô tả danh mục -->
            @if($category->description)
            <div class="card" style="margin-bottom: 24px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px;">
                <div style="color: var(--text-color); line-height: 1.6;">
                    {!! nl2br(e($category->description)) !!}
                </div>
            </div>
            @endif

            <!-- Mua Box -->
            <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px;">
                <div style="display: flex; gap: 24px; flex-wrap: wrap;">
                    <div style="flex: 0 0 auto; width: 260px; max-width: 100%;">
                        <img src="{{ !empty($category->thumbnail) ? asset($category->thumbnail) : 'https://via.placeholder.com/300x180' }}" alt="{{ $category->name }}" style="width: 100%; border-radius: 12px; object-fit: cover; border: 1px solid var(--border-color);">
                    </div>
                    <div style="flex: 1; min-width: 280px; display: flex; flex-direction: column; justify-content: center;">
                        <h2 style="margin: 0 0 12px 0; font-size: 1.4rem; color: var(--text-color); font-weight: 700;">Mua Tài Khoản Ngẫu Nhiên</h2>
                        <p style="color: var(--text-muted); margin: 0 0 16px 0; font-size: 0.95rem;">Bạn sẽ nhận được 1 tài khoản ngẫu nhiên từ danh mục <strong>{{ $category->name }}</strong></p>
                        
                        <div style="display: flex; gap: 24px; margin-bottom: 24px; align-items: center; font-size: 0.95rem;">
                            <div>
                                <span style="color: var(--text-muted);">Còn lại: </span>
                                <span style="color: #10b981; font-weight: 600;">{{ number_format($availableCount) }} acc</span>
                            </div>
                            <div>
                                <span style="color: var(--text-muted);">Giá: </span>
                                <span style="color: #ef4444; font-weight: 700; font-size: 1.1rem;">{{ number_format($price) }}đ</span>
                            </div>
                        </div>

                        <div>
                            @if($availableCount > 0)
                            <button onclick="openPurchaseModal()" style="background: #ef4444; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; transition: all 0.2s;">
                                Mua Ngẫu Nhiên
                            </button>
                            @else
                            <button disabled style="background: #4b5563; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: not-allowed; opacity: 0.7;">
                                Đã Hết Hàng
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Mua Hàng -->
    <div id="randomPurchaseModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:10000; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; width: 100%; max-width: 480px; animation: modalPop 0.2s ease-out; display: flex; flex-direction: column;">
            
            <div style="display:flex; justify-content:space-between; align-items:center; padding: 20px 24px; border-bottom: 1px solid var(--border-color);">
                <h3 style="font-size:1.15rem; font-weight:700; margin:0; color: var(--text-color);">Xác nhận mua</h3>
                <button onclick="closePurchaseModal()" style="background:none; border:none; font-size:1.4rem; cursor:pointer; color: var(--text-muted); padding: 0;">✕</button>
            </div>
            
            <div style="padding: 24px;">
                <div style="display: flex; gap: 16px; background: rgba(0,0,0,0.2); padding: 16px; border-radius: 12px; margin-bottom: 24px; border: 1px solid var(--border-color);">
                    <img src="{{ !empty($category->thumbnail) ? asset($category->thumbnail) : 'https://via.placeholder.com/150' }}" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                    <div style="display: flex; flex-direction: column; justify-content: center;">
                        <h4 style="margin:0 0 4px 0; font-size: 1.05rem; font-weight: 600; color: var(--text-color);">{{ $category->name }}</h4>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">
                            Giá: <span style="color:#ef4444; font-weight:600;">{{ number_format($price) }}đ</span>/acc
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 2px;">
                            Còn {{ number_format($availableCount) }} tài khoản
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600; color: var(--text-color);">Số lượng mua</label>
                    <div style="display: flex; gap: 10px;">
                        <button onclick="changeQuantity(-1)" style="width: 44px; height: 44px; border-radius: 8px; border: 1px solid var(--border-color); background: rgba(0,0,0,0.2); color: var(--text-color); font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">-</button>
                        <input type="number" id="purchaseQuantity" value="1" min="1" max="{{ $availableCount }}" onchange="updateTotalPrice()" style="width: 80px; height: 44px; text-align: center; border-radius: 8px; border: 1px solid var(--border-color); background: rgba(0,0,0,0.2); color: var(--text-color); font-weight: 600; font-size: 1.1rem; outline: none;">
                        <button onclick="changeQuantity(1)" style="width: 44px; height: 44px; border-radius: 8px; border: 1px solid var(--border-color); background: rgba(0,0,0,0.2); color: var(--text-color); font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">+</button>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); margin-bottom: 24px;">
                    <span style="color: var(--text-muted); font-weight: 500;">Tổng thanh toán:</span>
                    <span id="totalPriceDisplay" style="color: #ef4444; font-weight: 700; font-size: 1.3rem;">{{ number_format($price) }}đ</span>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-muted); font-size: 0.9rem;">Mã giảm giá</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="discountCode" placeholder="NHẬP MÃ GIẢM GIÁ..." style="flex: 1; height: 44px; padding: 0 16px; border-radius: 8px; border: 1px solid var(--border-color); background: rgba(0,0,0,0.2); color: var(--text-color); outline: none;">
                        <button onclick="applyDiscount()" style="height: 44px; padding: 0 20px; border-radius: 8px; border: 1px solid var(--border-color); background: rgba(0,0,0,0.2); color: var(--text-color); font-weight: 600; cursor: pointer; transition: 0.2s;">Áp dụng</button>
                    </div>
                    <div id="discount-message" class="modal__discount-message" style="margin-top: 8px; font-size: 0.9rem;"></div>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button onclick="closePurchaseModal()" style="flex: 1; height: 46px; border-radius: 8px; border: 1px solid var(--border-color); background: rgba(0,0,0,0.2); color: var(--text-color); font-weight: 600; cursor: pointer; transition: 0.2s;">Hủy</button>
                    <button onclick="submitPurchase()" id="btnSubmitPurchase" style="flex: 1; height: 46px; border-radius: 8px; border: none; background: #ef4444; color: white; font-weight: 600; cursor: pointer; transition: 0.2s;">Xác nhận mua</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes modalPop {
            0% { transform: scale(0.95); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        [data-theme="light"] {
            --bg-card: #ffffff;
            --border-color: #e5e7eb;
            --text-color: #111827;
            --text-muted: #6b7280;
        }
        [data-theme="dark"] {
            --bg-card: #1f1f1f;
            --border-color: #333333;
            --text-color: #f9fafb;
            --text-muted: #9ca3af;
        }
    </style>
@endsection

@push('scripts')
<script>
    const unitPrice = {{ $price }};
    const maxQty = {{ $availableCount }};
    
    function openPurchaseModal() {
        @auth
            document.getElementById('randomPurchaseModal').style.display = 'flex';
            // Initialize discount handler
            initDiscountHandler('random_account', {{ $category->id }}, unitPrice);
        @else
            FuiToast.error("Vui lòng đăng nhập để mua hàng!");
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 1500);
        @endauth
    }

    function closePurchaseModal() {
        document.getElementById('randomPurchaseModal').style.display = 'none';
        document.getElementById('purchaseQuantity').value = 1;
        document.getElementById('discountCode').value = '';
        updateTotalPrice();
    }

    function changeQuantity(delta) {
        const input = document.getElementById('purchaseQuantity');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        if (val > maxQty) val = maxQty;
        input.value = val;
        updateTotalPrice();
    }

    function updateTotalPrice() {
        let val = parseInt(document.getElementById('purchaseQuantity').value);
        if (isNaN(val) || val < 1) val = 1;
        if (val > maxQty) val = maxQty;
        document.getElementById('purchaseQuantity').value = val;
        
        const total = val * unitPrice;
        document.getElementById('totalPriceDisplay').innerText = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
        
        // Update originalPrice in discount handler
        if (typeof discountHandler !== 'undefined') {
            discountHandler.originalPrice = total;
            discountHandler.discountedPrice = total;
        }
    }
    
    function applyDiscount() {
        const qty = parseInt(document.getElementById('purchaseQuantity').value);
        checkDiscountCode('random_account', qty);
    }

    function submitPurchase() {
        const btn = document.getElementById('btnSubmitPurchase');
        const qty = parseInt(document.getElementById('purchaseQuantity').value);
        const discountCode = document.getElementById('discountCode').value.trim();

        if (qty < 1 || qty > maxQty) {
            FuiToast.error("Số lượng không hợp lệ!");
            return;
        }
        
        let finalDiscountCode = discountCode;
        if (typeof discountHandler !== 'undefined' && discountHandler.discountCode) {
            finalDiscountCode = discountHandler.discountCode;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

        fetch("{{ route('random.category.purchase', $category->slug) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                quantity: qty,
                discount_code: finalDiscountCode
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                FuiToast.success(data.message);
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 1500);
            } else {
                FuiToast.error(data.message);
                btn.disabled = false;
                btn.innerText = 'Xác nhận mua';
            }
        })
        .catch(err => {
            console.error(err);
            FuiToast.error("Có lỗi xảy ra, vui lòng thử lại sau.");
            btn.disabled = false;
            btn.innerText = 'Xác nhận mua';
        });
    }
</script>
@endpush
