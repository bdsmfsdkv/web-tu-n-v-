<!DOCTYPE html>
<html lang="vi" data-theme="light">
@include('layouts.user.head')
<body style="min-height:100vh;display:flex;flex-direction:column;margin:0;">
    <div id="fui-toast"></div>
    <!-- Navbar -->
    @include('layouts.user.header')
    
    <main style="padding-top:64px;flex:1;">
        @yield('content')
    </main>

    @include('layouts.user.footer')

    <!-- Deposit Method Modal -->
    <div id="depositMethodModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:10000;align-items:flex-end;justify-content:center;backdrop-filter:blur(4px);" onclick="if(event.target===this)this.style.display='none'">
        <div class="deposit-modal-content" style="border-radius:16px 16px 0 0;padding:24px 20px 32px;width:100%;max-width:480px;animation:slideUpModal .25s ease-out;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                <h3 class="deposit-modal-title" style="font-size:1.1rem;font-weight:700;margin:0;">Chọn phương thức nạp</h3>
                <button class="deposit-modal-close" onclick="document.getElementById('depositMethodModal').style.display='none'" style="background:none;border:none;font-size:1.3rem;cursor:pointer;padding:4px;">✕</button>
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <a href="{{ route('profile.deposit-card') }}" class="deposit-modal-link" style="display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;border:1px solid #e5e7eb;text-decoration:none;transition:all .2s;">
                    <div class="deposit-modal-icon-bg card-icon-bg" style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <span class="iconify card-icon" data-icon="ant-design:credit-card-outlined" style="font-size:1.4rem;"></span>
                    </div>
                    <div>
                        <div class="deposit-modal-text" style="font-weight:600;font-size:0.95rem;">Nạp thẻ cào</div>
                        <div class="deposit-modal-subtext" style="font-size:0.78rem;margin-top:2px;">Viettel, Vinaphone, Mobifone...</div>
                    </div>
                    <span class="iconify deposit-modal-arrow" style="margin-left:auto;font-size:1.2rem;" data-icon="ant-design:right-outlined"></span>
                </a>
                <a href="{{ route('profile.deposit-atm') }}" class="deposit-modal-link" style="display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;border:1px solid #e5e7eb;text-decoration:none;transition:all .2s;">
                    <div class="deposit-modal-icon-bg atm-icon-bg" style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <span class="iconify atm-icon" data-icon="ant-design:bank-outlined" style="font-size:1.4rem;"></span>
                    </div>
                    <div>
                        <div class="deposit-modal-text" style="font-weight:600;font-size:0.95rem;">Nạp ngân hàng</div>
                        <div class="deposit-modal-subtext" style="font-size:0.78rem;margin-top:2px;">Chuyển khoản tự động, nhận tiền ngay</div>
                    </div>
                    <span class="iconify deposit-modal-arrow" style="margin-left:auto;font-size:1.2rem;" data-icon="ant-design:right-outlined"></span>
                </a>
                @if (config_get('payment.usdt.active', true))
                <a href="{{ route('profile.deposit-usdt') }}" class="deposit-modal-link" style="display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;border:1px solid #e5e7eb;text-decoration:none;transition:all .2s;">
                    <div class="deposit-modal-icon-bg usdt-icon-bg" style="width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-brands fa-usps usdt-icon" style="font-size:1.4rem;"></i>
                    </div>
                    <div>
                        <div class="deposit-modal-text" style="font-weight:600;font-size:0.95rem;">Nạp USDT</div>
                        <div class="deposit-modal-subtext" style="font-size:0.78rem;margin-top:2px;">Thanh toán bằng tiền điện tử</div>
                    </div>
                    <span class="iconify deposit-modal-arrow" style="margin-left:auto;font-size:1.2rem;" data-icon="ant-design:right-outlined"></span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <style>
        @keyframes slideUpModal { from { transform: translateY(100%); } to { transform: translateY(0); } }
        .deposit-modal-content { background: #ffffff; }
        .deposit-modal-title { color: #111827; }
        .deposit-modal-close { color: #9ca3af; }
        .deposit-modal-link { color: inherit; border-color: #e5e7eb; }
        .deposit-modal-text { color: #111827; }
        .deposit-modal-subtext { color: #6b7280; }
        .deposit-modal-arrow { color: #d1d5db; }
        .card-icon-bg { background: #fef2f2; }
        .card-icon { color: var(--primary); }
        .atm-icon-bg { background: #f0fdf4; }
        .atm-icon { color: #16a34a; }
        .usdt-icon-bg { background: #fef3c7; }
        .usdt-icon { color: #d97706; }

        [data-theme="dark"] .deposit-modal-content { background: #262626; border-top: 1px solid #404040; }
        [data-theme="dark"] .deposit-modal-title { color: #f9fafb; }
        [data-theme="dark"] .deposit-modal-close { color: #6b7280; }
        [data-theme="dark"] .deposit-modal-link { border-color: #404040; color: #f9fafb; }
        [data-theme="dark"] .deposit-modal-link:hover { background: #171717; }
        [data-theme="dark"] .deposit-modal-text { color: #f9fafb; }
        [data-theme="dark"] .deposit-modal-subtext { color: #9ca3af; }
        [data-theme="dark"] .card-icon-bg { background: rgba(220, 38, 38, 0.1); }
        [data-theme="dark"] .atm-icon-bg { background: rgba(22, 163, 74, 0.1); }
    </style>

    <!-- Floating Support -->
    <div class="floating-support">
        <a href="https://zalo.me/{{ config_get('zalo', '0123456789') }}" target="_blank" rel="noopener noreferrer" class="support-item zalo" title="Hỗ trợ Zalo" aria-label="Hỗ trợ Zalo">
            <img src="https://shopaccgamev2.tuanori.vn/images/zalo.webp" alt="Zalo">
            <span class="support-text">Chat Zalo</span>
        </a>
        <a href="{{ config_get('facebook', 'https://facebook.com') }}" target="_blank" rel="noopener noreferrer" class="support-item messenger" title="Hỗ trợ Facebook" aria-label="Hỗ trợ Facebook">
            <img src="https://shopaccgamev2.tuanori.vn/images/facebook.webp" alt="Facebook">
            <span class="support-text">Facebook</span>
        </a>
        <a href="tel:{{ config_get('phone', '0123456789') }}" class="support-item hotline" title="Hotline">
            <div class="phone-icon-wrapper">
                <span class="iconify" data-icon="ant-design:phone-filled"></span>
            </div>
            <span class="support-text">{{ config_get('phone', '0123456789') }}</span>
        </a>
    </div>

    <style>
        .floating-support {
            position: fixed;
            bottom: 80px;
            right: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 9999;
        }
        .support-item {
            position: relative;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .support-item img {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }
        .support-item.zalo {
            background: #fff;
        }
        .support-item.messenger {
            background: #fff;
        }
        .support-item.hotline {
            background: #ef4444;
            color: white;
            animation: pulse-red 2s infinite;
        }
        .phone-icon-wrapper {
            font-size: 24px;
            display: flex;
            align-items: center;
        }
        .support-item:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .support-text {
            position: absolute;
            right: 100%;
            margin-right: 12px;
            background: #fff;
            color: #1f2937;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transform: translateX(10px);
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            pointer-events: none;
        }
        .support-text::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -4px;
            transform: translateY(-50%);
            border-width: 5px 0 5px 5px;
            border-style: solid;
            border-color: transparent transparent transparent #fff;
        }
        .support-item:hover .support-text {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
        [data-theme="dark"] .support-text {
            background: #1f2937;
            color: #f3f4f6;
            border: 1px solid #374151;
        }
        [data-theme="dark"] .support-text::after {
            border-color: transparent transparent transparent #1f2937;
        }
        @media (max-width: 768px) {
            .floating-support {
                bottom: 70px;
                right: 16px;
                gap: 10px;
            }
            .support-item {
                width: 40px;
                height: 40px;
            }
            .support-item img, .phone-icon-wrapper {
                font-size: 20px;
                width: 20px;
                height: 20px;
            }
            .support-text {
                display: none;
            }
        }
    </style>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" title="Lên đầu trang" aria-label="Lên đầu trang">
        <span class="iconify" data-icon="ant-design:arrow-up-outlined"></span>
    </button>
    
    <script src="https://cdn.jsdelivr.net/gh/lelinh014756/fui-toast-js@master/assets/js/toast@1.0.1/fuiToast.min.js"></script>
    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
    <script src="{{ asset('assets/js/discount-code.js') }}?v={{ filemtime(public_path('assets/js/discount-code.js')) }}"></script>
    <script>
    (function() {
      function hidePreloader() {
        var p = document.getElementById('pagePreloader');
        if (p && p.parentNode) {
          p.style.opacity = '0';
          setTimeout(function() {
            p.remove();
          }, 300);
        }
      }
      document.addEventListener('DOMContentLoaded', function() {
        setTimeout(hidePreloader, 100);
      });
      setTimeout(hidePreloader, 1000); // safety fallback
    })();
  </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v833ccba57c9e4d2798f2e76cebdd09a11778172276447" integrity="sha512-57MDmcccJXYtNnH+ZiBwzC4jb2rvgVCEokYN+L/nLlmO8rfYT/gIpW2A569iJ/3b+0UEasghjuZH/ma3wIs/EQ==" data-cf-beacon='{"version":"2024.11.0","token":"ff8b28eff4d24470ab279ba48041523b","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>

    <!-- Live Purchase Toast -->
    <div id="live-purchase-toast" class="live-purchase-toast">
        <button type="button" class="toast-close" onclick="document.getElementById('live-purchase-toast').classList.remove('show')" aria-label="Đóng">×</button>
        <div class="toast-body">
            <div class="toast-icon-bg">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div class="toast-content">
                <div class="toast-text-desc"><strong class="toast-username" id="toast-username">nguyen***</strong> vừa mua</div>
                <div class="toast-item" id="toast-item">Acc Liên Quân VIP</div>
                <div class="toast-meta">
                    <span class="toast-price" id="toast-price">50.000đ</span>
                    <span class="toast-time" id="toast-time">vừa xong</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .live-purchase-toast {
            position: fixed;
            bottom: 20px;
            left: -320px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            width: 260px;
            border-left: 4px solid #0d6efd;
            z-index: 10000;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
            transform: translateX(0);
            opacity: 0;
            pointer-events: none;
            font-family: inherit;
        }
        .live-purchase-toast.show {
            transform: translateX(340px);
            opacity: 1;
            pointer-events: auto;
        }
        .live-purchase-toast .toast-close {
            position: absolute;
            top: 4px;
            right: 6px;
            cursor: pointer;
            color: #9ca3af;
            font-size: 14px;
            line-height: 1;
            background: transparent;
            border: none;
            padding: 2px;
            transition: color 0.15s;
        }
        .live-purchase-toast .toast-close:hover {
            color: #ef4444;
        }
        .live-purchase-toast .toast-body {
            display: flex;
            padding: 9px 10px;
            align-items: center;
            gap: 9px;
        }
        .live-purchase-toast .toast-icon-bg {
            width: 32px;
            height: 32px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.95rem;
        }
        .live-purchase-toast .toast-content {
            flex: 1;
            min-width: 0;
        }
        .live-purchase-toast .toast-text-desc {
            font-size: 0.76rem;
            color: #6b7280;
            line-height: 1.2;
        }
        .live-purchase-toast .toast-username {
            color: #111827;
            font-weight: 600;
        }
        .live-purchase-toast .toast-item {
            font-size: 0.84rem;
            font-weight: 600;
            color: #2563eb;
            line-height: 1.25;
            margin: 1px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .live-purchase-toast .toast-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.74rem;
            line-height: 1;
        }
        .live-purchase-toast .toast-price {
            color: #dc2626;
            font-weight: 700;
        }
        .live-purchase-toast .toast-time {
            color: #9ca3af;
        }

        /* Dark mode */
        [data-theme="dark"] .live-purchase-toast {
            background: #1f2937;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
            border-left-color: #3b82f6;
        }
        [data-theme="dark"] .live-purchase-toast .toast-text-desc {
            color: #9ca3af;
        }
        [data-theme="dark"] .live-purchase-toast .toast-username {
            color: #f3f4f6;
        }
        [data-theme="dark"] .live-purchase-toast .toast-item {
            color: #60a5fa;
        }
        [data-theme="dark"] .live-purchase-toast .toast-icon-bg {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
        }
        
        @media (max-width: 768px) {
            .live-purchase-toast {
                left: 16px;
                right: auto;
                bottom: 12px;
                transform: translateX(-120%);
                width: calc(100% - 32px);
                max-width: 280px;
            }
            .live-purchase-toast.show {
                transform: translateX(0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const firstNames = ['nguyen', 'tran', 'le', 'pham', 'hoang', 'huynh', 'phan', 'vu', 'vo', 'dang', 'bui', 'do', 'ho', 'ngo', 'duong', 'ly', 'tuan', 'hieu', 'nam', 'duc', 'dat', 'long', 'khanh', 'huy', 'tung', 'minh', 'quan', 'son', 'linh', 'trang', 'anh', 'phong', 'thanh', 'hai', 'viet', 'hung', 'thang', 'trung', 'kien', 'quang', 'bao', 'khoa', 'tai'];
            const suffixes = ['pro', 'vip', 'boy', 'gaming', '99', '2k', '2k1', '2k2', '2k3', '2k4', '2k5', '2k6', '2k7', '2k8', 'ff', 'lq', 'yt', 'tv', 'vn'];
            const phonePrefixes = ['098', '097', '096', '086', '091', '094', '088', '090', '093', '089', '070', '079', '077', '076', '078', '032', '033', '034', '035', '036', '037', '038', '039', '056', '058'];

            function generateRealisticUsername() {
                const mode = Math.floor(Math.random() * 4);
                if (mode === 0) {
                    const p = phonePrefixes[Math.floor(Math.random() * phonePrefixes.length)];
                    const d = Math.floor(10 + Math.random() * 90);
                    return `${p}${d}***`;
                } else if (mode === 1) {
                    const name = firstNames[Math.floor(Math.random() * firstNames.length)];
                    const num = Math.floor(10 + Math.random() * 990);
                    const sep = Math.random() > 0.7 ? '_' : '';
                    return `${name}${sep}${num}***`;
                } else if (mode === 2) {
                    const name = firstNames[Math.floor(Math.random() * firstNames.length)];
                    const suf = suffixes[Math.floor(Math.random() * suffixes.length)];
                    const sep = Math.random() > 0.6 ? '_' : '';
                    return `${name}${sep}${suf}***`;
                } else {
                    const f = firstNames[Math.floor(Math.random() * firstNames.length)];
                    const s = firstNames[Math.floor(Math.random() * firstNames.length)];
                    return `${f}${s}***`;
                }
            }

            const items = [
                'Acc Liên Quân VIP', 'Acc Free Fire', 'Random Blox Fruits', 'Acc Ngọc Rồng',
                'Random 50k', 'Cày thuê Rank', 'Nạp Quân Huy', 'Nạp Kim Cương', 'Acc Roblox'
            ];
            
            const prices = [20000, 50000, 70000, 100000, 150000, 200000, 350000];
            const timeLabels = ['vừa xong', '12s trước', '25s trước', '41s trước', '1p trước'];

            function showFakePurchase() {
                const toast = document.getElementById('live-purchase-toast');
                if (!toast) return;
                
                document.getElementById('toast-username').textContent = generateRealisticUsername();
                document.getElementById('toast-item').textContent = items[Math.floor(Math.random() * items.length)];
                
                const price = prices[Math.floor(Math.random() * prices.length)];
                document.getElementById('toast-price').textContent = new Intl.NumberFormat('vi-VN').format(price) + 'đ';
                document.getElementById('toast-time').textContent = timeLabels[Math.floor(Math.random() * timeLabels.length)];
                
                toast.classList.add('show');
                
                // Giữ 3.2s
                setTimeout(() => {
                    toast.classList.remove('show');
                    scheduleNextPurchase();
                }, 3200);
            }

            function scheduleNextPurchase() {
                // Tần suất thưa hơn: cách 25s - 55s mới hiện 1 lần
                const nextDelay = Math.floor(25000 + Math.random() * 30000);
                setTimeout(showFakePurchase, nextDelay);
            }

            // Lần đầu xuất hiện sau 8s - 15s kể từ khi vào web
            setTimeout(showFakePurchase, Math.floor(8000 + Math.random() * 7000));
        });
    </script>
    
    @stack('scripts')
</body>
</html>
