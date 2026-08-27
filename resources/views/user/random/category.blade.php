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
            <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color, #e2e8f0); border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);">
                <div style="display: flex; gap: 28px; flex-wrap: wrap; align-items: center;">
                    <div style="flex: 0 0 auto; width: 280px; max-width: 100%; position: relative;">
                        <img src="{{ !empty($category->thumbnail) ? asset($category->thumbnail) : 'https://via.placeholder.com/300x180' }}" alt="{{ $category->name }}" style="width: 100%; border-radius: 14px; object-fit: cover; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                        <div style="position: absolute; top: 10px; left: 10px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(6px); color: #fbbf24; font-size: 0.75rem; font-weight: 800; padding: 4px 10px; border-radius: 6px; border: 1px solid rgba(251, 191, 36, 0.3);">
                            <i class="fa-solid fa-dice"></i> RANDOM
                        </div>
                    </div>
                    <div style="flex: 1; min-width: 280px; display: flex; flex-direction: column; justify-content: center;">
                        <h2 style="margin: 0 0 10px 0; font-size: 1.45rem; color: var(--text-color, #0f172a); font-weight: 800; letter-spacing: -0.3px;">Mua Tài Khoản Ngẫu Nhiên</h2>
                        <p style="color: var(--text-muted, #64748b); margin: 0 0 18px 0; font-size: 0.95rem; line-height: 1.5;">Hệ thống sẽ tự động gửi 1 tài khoản ngẫu nhiên từ danh mục <strong>{{ $category->name }}</strong> vào tài khoản của bạn ngay sau khi thanh toán.</p>
                        
                        <div style="display: flex; gap: 12px; margin-bottom: 24px; align-items: center; font-size: 0.92rem; flex-wrap: wrap;">
                            <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); padding: 6px 14px; border-radius: 8px;">
                                <span style="color: #059669; font-weight: 600;">Còn lại: </span>
                                <strong style="color: #059669; font-weight: 800;">{{ number_format($availableCount) }} acc</strong>
                            </div>
                            <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.25); padding: 6px 14px; border-radius: 8px;">
                                <span style="color: #dc2626; font-weight: 600;">Giá: </span>
                                <strong style="color: #dc2626; font-weight: 900; font-size: 1.15rem;">{{ number_format($price) }}đ</strong>
                            </div>
                            <div style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.25); padding: 6px 14px; border-radius: 8px;">
                                <span style="color: #2563eb; font-weight: 600;">Tỉ lệ trúng: </span>
                                <strong style="color: #2563eb; font-weight: 800;">100% NHẬN NICK</strong>
                            </div>
                        </div>

                        <div>
                            @if($availableCount > 0)
                            <button onclick="openPurchaseModal()" style="background: var(--brand-gradient, linear-gradient(135deg, #ef4444 0%, #dc2626 100%)); color: white; border: none; padding: 13px 32px; border-radius: 10px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(220,38,38,0.35); display: inline-flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-bolt"></i> MUA NGAY BÂY GIỜ
                            </button>
                            @else
                            <button disabled style="background: #475569; color: white; border: none; padding: 13px 32px; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: not-allowed; opacity: 0.7;">
                                <i class="fa-solid fa-ban"></i> TẠM HẾT HÀNG
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Mua Hàng Siêu Mượt -->
    <div id="randomPurchaseModal" class="random-modal-container">
        <div class="random-modal-backdrop" onclick="closePurchaseModal()"></div>
        <div class="random-modal-dialog">
            
            <div class="random-modal-header" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid rgba(226,232,240,0.8);">
                <h3 class="random-modal-title" style="margin: 0; font-size: 1.15rem; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-cart-shopping" style="color: var(--primary);"></i> Xác Nhận Mua Hàng
                </h3>
                <button type="button" onclick="closePurchaseModal()" class="random-modal-close" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #94a3b8; padding: 4px;">✕</button>
            </div>
            
            <div class="random-modal-body" style="padding: 20px;">
                <div class="random-summary-box" style="display: flex; gap: 14px; background: rgba(0,0,0,0.02); border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; margin-bottom: 18px;">
                    <img src="{{ !empty($category->thumbnail) ? asset($category->thumbnail) : 'https://via.placeholder.com/150' }}" alt="{{ $category->name }}" class="random-summary-thumb" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                    <div style="display: flex; flex-direction: column; justify-content: center; min-width: 0;">
                        <h4 style="margin:0 0 4px 0; font-size: 1rem; font-weight: 700; color: var(--text-color); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $category->name }}</h4>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">
                            Đơn giá: <strong style="color:#dc2626; font-weight:800;">{{ number_format($price) }}đ</strong>/acc
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-top: 2px;">
                            Kho còn: {{ number_format($availableCount) }} tài khoản
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 700; font-size: 0.9rem; color: var(--text-color);">Số lượng cần mua</label>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <button type="button" onclick="changeQuantity(-1)" class="btn-qty-ctrl" style="width: 40px; height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f8fafc; font-size: 1.2rem; font-weight: 700; cursor: pointer;">-</button>
                        <input type="number" id="purchaseQuantity" value="1" min="1" max="{{ $availableCount }}" onchange="updateTotalPrice()" class="input-qty-val" style="width: 80px; height: 40px; text-align: center; border-radius: 8px; border: 1px solid #cbd5e1; font-weight: 800; font-size: 1rem;">
                        <button type="button" onclick="changeQuantity(1)" class="btn-qty-ctrl" style="width: 40px; height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f8fafc; font-size: 1.2rem; font-weight: 700; cursor: pointer;">+</button>
                    </div>
                </div>

                <div class="random-total-row" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: rgba(220, 38, 38, 0.05); border: 1px dashed rgba(220, 38, 38, 0.3); border-radius: 10px; margin-bottom: 18px;">
                    <span style="color: var(--text-color); font-weight: 600;">Tổng thanh toán:</span>
                    <span id="totalPriceDisplay" style="color: #dc2626; font-weight: 900; font-size: 1.3rem;">{{ number_format($price) }}đ</span>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-muted); font-size: 0.85rem;">Mã giảm giá (nếu có)</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" id="discountCode" placeholder="Nhập mã khuyến mãi..." class="input-discount-code" style="flex: 1; padding: 9px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.9rem; outline: none;" onkeydown="if(event.key==='Enter'){event.preventDefault(); applyDiscount();}">
                        <button type="button" onclick="applyDiscount()" class="btn-apply-discount" style="padding: 9px 18px; border-radius: 8px; border: none; background: #334155; color: #fff; font-weight: 700; cursor: pointer;">Áp dụng</button>
                    </div>
                    <div id="discount-message" class="modal__discount-message" style="margin-top: 6px; font-size: 0.85rem;"></div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 10px;">
                    <button type="button" onclick="closePurchaseModal()" class="btn-modal-cancel" style="padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f1f5f9; color: #475569; font-weight: 700; cursor: pointer;">Hủy bỏ</button>
                    <button type="button" onclick="submitPurchase()" id="btnSubmitPurchase" class="btn-modal-confirm" style="padding: 12px; border-radius: 8px; border: none; background: var(--brand-gradient, linear-gradient(135deg, #ef4444 0%, #dc2626 100%)); color: #fff; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(220,38,38,0.3);">Xác nhận mua</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .random-modal-container {
            position: fixed;
            inset: 0;
            z-index: 10050;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            box-sizing: border-box;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .random-modal-container.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .random-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
        }

        .random-modal-dialog {
            position: relative;
            background: var(--bg-card, #ffffff);
            border: 1px solid var(--border-color, #e5e7eb);
            border-radius: 16px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2);
            overflow: hidden;
            z-index: 2;
            display: flex;
            flex-direction: column;
            transform: scale(0.97);
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .random-modal-container.active .random-modal-dialog {
            transform: scale(1);
        }

        .random-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color, #e5e7eb);
            background: rgba(0, 0, 0, 0.02);
        }

        .random-modal-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-color, #111827);
        }

        .random-modal-close {
            background: none;
            border: none;
            font-size: 1.3rem;
            line-height: 1;
            cursor: pointer;
            color: var(--text-muted, #9ca3af);
            padding: 2px 6px;
            border-radius: 5px;
            transition: color 0.15s, background 0.15s;
        }

        .random-modal-close:hover {
            color: #ef4444;
            background: #fee2e2;
        }

        .random-modal-body {
            padding: 18px;
        }

        .random-summary-box {
            display: flex;
            gap: 12px;
            background: rgba(0, 0, 0, 0.03);
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            border: 1px solid var(--border-color, #e5e7eb);
        }

        .random-summary-thumb {
            width: 58px;
            height: 58px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            background: #0f172a;
        }

        .btn-qty-ctrl {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid var(--border-color, #cbd5e1);
            background: rgba(0, 0, 0, 0.03);
            color: var(--text-color, #111827);
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .input-qty-val {
            width: 72px;
            height: 40px;
            text-align: center;
            border-radius: 8px;
            border: 1px solid var(--border-color, #cbd5e1);
            background: rgba(0, 0, 0, 0.02);
            color: var(--text-color, #111827);
            font-weight: 700;
            font-size: 1.05rem;
            outline: none;
        }

        .random-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-top: 1px solid var(--border-color, #e5e7eb);
            border-bottom: 1px solid var(--border-color, #e5e7eb);
            margin-bottom: 18px;
        }

        .input-discount-code {
            flex: 1;
            height: 40px;
            padding: 0 12px;
            border-radius: 8px;
            border: 1px solid var(--border-color, #cbd5e1);
            background: rgba(0, 0, 0, 0.02);
            color: var(--text-color, #111827);
            outline: none;
            font-size: 0.85rem;
        }

        .btn-apply-discount {
            height: 40px;
            padding: 0 16px;
            border-radius: 8px;
            border: 1px solid var(--border-color, #cbd5e1);
            background: rgba(0, 0, 0, 0.04);
            color: var(--text-color, #111827);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .btn-modal-cancel {
            flex: 1;
            height: 42px;
            border-radius: 8px;
            border: 1px solid var(--border-color, #cbd5e1);
            background: rgba(0, 0, 0, 0.04);
            color: var(--text-color, #111827);
            font-weight: 600;
            cursor: pointer;
        }

        .btn-modal-confirm {
            flex: 1;
            height: 42px;
            border-radius: 8px;
            border: none;
            background: #ef4444;
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
        }
        
        [data-theme="light"] {
            --bg-card: #ffffff;
            --border-color: #e5e7eb;
            --text-color: #111827;
            --text-muted: #6b7280;
        }
        [data-theme="dark"] {
            --bg-card: #1e1e1e;
            --border-color: #2e2e2e;
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
            const modal = document.getElementById('randomPurchaseModal');
            if (modal) {
                modal.classList.add('active');
                
                // Initialize discount handler
                if (typeof initDiscountHandler === 'function') {
                    initDiscountHandler('random_account', {{ $category->id }}, unitPrice);
                }
            }
        @else
            if (typeof FuiToast !== 'undefined') {
                FuiToast.error("Vui lòng đăng nhập để mua hàng!");
            } else {
                alert("Vui lòng đăng nhập để mua hàng!");
            }
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 1200);
        @endauth
    }

    function closePurchaseModal() {
        const modal = document.getElementById('randomPurchaseModal');
        if (modal) {
            modal.classList.remove('active');
        }
        const qtyInput = document.getElementById('purchaseQuantity');
        if (qtyInput) qtyInput.value = 1;
        const dcInput = document.getElementById('discountCode');
        if (dcInput) dcInput.value = '';
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
        if (typeof checkDiscountCode === 'function') {
            checkDiscountCode('random_account', qty);
        }
    }

    function submitPurchase() {
        const btn = document.getElementById('btnSubmitPurchase');
        const qty = parseInt(document.getElementById('purchaseQuantity').value);
        const discountCode = document.getElementById('discountCode').value.trim();

        if (qty < 1 || qty > maxQty) {
            if (typeof FuiToast !== 'undefined') FuiToast.error("Số lượng không hợp lệ!");
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
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                quantity: qty,
                discount_code: finalDiscountCode,
                return_url: window.location.pathname + window.location.search + window.location.hash
            })
        })
        .then(async res => {
            const data = await res.json().catch(() => null);
            if (!data) {
                throw new Error('Máy chủ trả về dữ liệu không hợp lệ.');
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                if (typeof FuiToast !== 'undefined') FuiToast.success(data.message);
                setTimeout(() => {
                    sessionStorage.setItem('refreshPurchaseSource', '1');
                    sessionStorage.setItem('purchaseReturnScrollY', String(window.scrollY));
                    window.location.assign(data.redirect_url);
                }, 1200);
            } else {
                if (typeof FuiToast !== 'undefined') FuiToast.error(data.message);
                btn.disabled = false;
                btn.innerText = 'Xác nhận mua';
            }
        })
        .catch(err => {
            console.error(err);
            if (typeof FuiToast !== 'undefined') FuiToast.error(err.message || "Có lỗi xảy ra, vui lòng thử lại sau.");
            btn.disabled = false;
            btn.innerText = 'Xác nhận mua';
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePurchaseModal();
    });
</script>
@endpush
