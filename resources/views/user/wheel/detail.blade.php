@extends('layouts.user.app')
@section('title', $wheel->name)

@push('css')
    @php
        $wheelImageHost = parse_url($wheel->wheel_image, PHP_URL_HOST);
    @endphp
    @if($wheelImageHost && $wheelImageHost !== request()->getHost())
        <link rel="preconnect" href="https://{{ $wheelImageHost }}" crossorigin>
        <link rel="dns-prefetch" href="https://{{ $wheelImageHost }}">
    @endif
    <link rel="preload" as="image" href="{{ asset($wheel->wheel_image) }}" fetchpriority="high">
    @if($wheel->pointer_image)
        <link rel="preload" as="image" href="{{ asset($wheel->pointer_image) }}" fetchpriority="high">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/wheel.css') }}?v={{ file_exists(public_path('assets/css/wheel.css')) ? filemtime(public_path('assets/css/wheel.css')) : time() }}">
@endpush

@section('content')
    <div class="wheel-page">
    <div class="container" style="padding-top: 20px; padding-bottom: 40px;">
        
        <!-- Top Header Box -->
        <div class="wheel-header-box">
            <div class="wheel-header-title">
                <div class="wheel-header-icon">
                    <i class="fas fa-dharmachakra"></i>
                </div>
                {{ mb_strtoupper($wheel->name) }}
            </div>
            <div class="wheel-header-desc">
                {!! $wheel->description ?: 'Thử vận may và nhận phần thưởng hấp dẫn.' !!}
            </div>
            <div class="online-badge">
                <div class="online-dot"></div> Đang có 545+ người chơi trực tuyến
            </div>
        </div>

        <div class="layout-grid">
            <!-- Left Panel -->
            <div class="left-panel-stack">
                <!-- Main Wheel Card -->
                <div class="main-card">
                    <div class="wheel-arena-wrapper">
                        <div class="wheel-image-container">
                            <img src="{{ asset($wheel->wheel_image) }}" alt="Vòng quay" class="wheel-image" fetchpriority="high" decoding="async">
                        </div>
                        @if($wheel->pointer_image)
                            <img src="{{ asset($wheel->pointer_image) }}" alt="Mũi tên vòng quay" class="wheel-pointer wheel-pointer-image">
                        @else
                            <span class="wheel-pointer wheel-pointer-default" aria-hidden="true"></span>
                        @endif
                        <button type="button" class="center-pointer-core" id="btnSpinCenterInner" aria-label="Quay ngay" style="background: transparent; border: 0; border-radius: 50%;" disabled></button>
                    </div>

                    <div class="action-controls">
                        <div class="price-display">
                            {{ number_format($wheel->price_per_spin) }}đ
                        </div>
                        
                        <div class="discount-input-group">
                            <input type="text" placeholder="NHẬP MÃ GIẢM GIÁ">
                            <button type="button">ÁP DỤNG</button>
                        </div>
                        
                        <select id="spin-count" class="spin-select">
                            <option value="1" selected>QUAY X 1/ {{ number_format($wheel->price_per_spin) }} 1 LẦN</option>
                            <option value="2">QUAY X 2/ {{ number_format($wheel->price_per_spin * 2) }}</option>
                            <option value="3">QUAY X 3/ {{ number_format($wheel->price_per_spin * 3) }}</option>
                            <option value="4">QUAY X 4/ {{ number_format($wheel->price_per_spin * 4) }}</option>
                            <option value="5">QUAY X 5/ {{ number_format($wheel->price_per_spin * 5) }}</option>
                            <option value="10">QUAY X 10/ {{ number_format($wheel->price_per_spin * 10) }}</option>
                        </select>

                        <div class="action-buttons-group">
                            <button type="button" class="btn-white" id="trial-btn" disabled>CHƠI THỬ</button>
                            <button type="button" class="btn-blue" id="spin-btn" disabled>QUAY NGAY</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Panel -->
            <div class="right-panel-stack">
                <!-- Inventory Box -->
                <div class="inventory-box">
                    <div class="inventory-header">
                        <div class="inventory-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div>
                            <div class="inventory-label">BẠN ĐANG CÓ</div>
                            <div class="inventory-amount">
                                <span class="user-balance">{{ number_format($itemBalance) }}</span>
                                <span class="inventory-unit">{{ $inventoryUnit ?? ($linkedItem?->unit ?? 'KIM CƯƠNG') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="inventory-buttons">
                        <a href="{{ route('profile.wheels-history') }}" class="btn-history">
                            <i class="fas fa-history"></i> Lịch Sử Quay
                        </a>
                        <a href="{{ route('profile.withdraw-gem', $linkedItem ? ['item' => $linkedItem->id] : []) }}" class="btn-withdraw">
                            <i class="fas fa-gift"></i> Rút Quà
                        </a>
                    </div>
                </div>

                <!-- History Box -->
                <div class="history-box">
                    <div class="history-header">
                        <h3 class="history-title">NHẬT KÝ</h3>
                        <button class="btn-top-quay"><i class="fas fa-trophy"></i> Top Quay</button>
                    </div>
                    
                    <div class="history-list">
                        @if (count($history) > 0)
                            @foreach ($history as $item)
                                <div class="history-card">
                                    <div class="history-card-left">
                                        <div class="history-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="history-info">
                                            <div class="history-name">{{ Str::substr($item->user?->username ?? 'Khách', 0, 4) }}***</div>
                                            <div class="history-reward">
                                                Trúng {{ $item->description }}{{ $item->spin_count > 1 ? ' x' . $item->spin_count : '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="history-time">
                                        {{ $item->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="history-empty" style="text-align: center; color: var(--text-muted); padding: 20px 0;">
                                Chưa có lịch sử quay nào.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Result Modal -->
    <div class="result-modal" id="result-modal">
        <div class="modal-content">
            <button class="modal-close" id="modal-close"><i class="fas fa-times"></i></button>
            <div class="result-icon">
                <i class="fas fa-gift"></i>
            </div>
            <h3 class="result-title">Chúc mừng!</h3>
            <p class="result-desc">Bạn đã quay trúng phần thưởng:</p>
            <div class="result-reward" id="result-reward">Tài khoản VIP</div>
            <button class="btn-blue" id="continue-btn" style="width: 100%;">Tiếp tục</button>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const spinBtn = document.getElementById('spin-btn');
            const centerSpinBtn = document.getElementById('btnSpinCenterInner');
            const wheelElement = document.querySelector('.wheel-image');
            const spinCount = document.getElementById('spin-count');
            const trialBtn = document.getElementById('trial-btn');
            const resultModal = document.getElementById('result-modal');
            const resultReward = document.getElementById('result-reward');

            if (!wheelElement || !spinBtn) return;

            const SPIN_URL = @json(route('lucky.spin', $wheel->slug));
            const CSRF_TOKEN = @json(csrf_token());
            const rawConfig = @json($wheel->config);
            const wheelConfig = Array.isArray(rawConfig) ? rawConfig : [];
            const totalItems = wheelConfig.length;
            const arcAngle = totalItems ? 360 / totalItems : 0;

            // Chỉ các ô đang bật mới được phép trúng, giữ lại index gốc để animation dừng đúng ô trên ảnh.
            const activeSlots = wheelConfig
                .map((reward, index) => ({ reward, index }))
                .filter(({ reward }) => reward && (reward.active === undefined || Boolean(reward.active)));

            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            const numberFormatter = new Intl.NumberFormat('vi-VN');
            const balanceNodes = document.querySelectorAll('[data-user-balance]');
            const itemBalanceNode = document.querySelector('.user-balance');
            const itemUnitNode = document.querySelector('.inventory-unit');

            let isSpinning = false;
            let wheelReady = false;
            let currentRotation = 0;

            function setSpinButtons(disabled) {
                spinBtn.disabled = disabled;
                if (trialBtn) trialBtn.disabled = disabled;
                if (centerSpinBtn) centerSpinBtn.disabled = disabled;
            }

            function showToast(message, type) {
                if (typeof FuiToast !== 'undefined') {
                    const options = { id: 'wheel-spin-toast', isClose: true, duration: 3000 };
                    if (type === 'success' && typeof FuiToast.success === 'function') {
                        FuiToast.success(message, options);
                        return;
                    }
                    FuiToast.error(message, options);
                } else {
                    alert(message);
                }
            }

            async function prepareWheel() {
                try {
                    if (!wheelElement.complete) {
                        await new Promise((resolve, reject) => {
                            wheelElement.addEventListener('load', resolve, { once: true });
                            wheelElement.addEventListener('error', reject, { once: true });
                        });
                    }
                    if (wheelElement.decode) await wheelElement.decode();
                    wheelReady = activeSlots.length > 0;
                } catch (error) {
                    console.warn('Wheel image failed to load or decode.', error);
                }

                setSpinButtons(!wheelReady);
                if (!wheelReady) {
                    showToast(totalItems ? 'Không thể tải ảnh vòng quay.' : 'Vòng quay chưa được cấu hình.');
                }
            }

            function pickTrialSlot() {
                const weights = activeSlots.map(({ reward }) => {
                    const trial = Number(reward.trial_probability);
                    if (Number.isFinite(trial) && trial > 0) return trial;
                    const base = Number(reward.probability);
                    return Number.isFinite(base) && base > 0 ? base : 0;
                });
                const total = weights.reduce((sum, weight) => sum + weight, 0);
                if (total <= 0) return null;

                let rand = Math.random() * total;
                for (let i = 0; i < activeSlots.length; i++) {
                    rand -= weights[i];
                    if (rand <= 0) return activeSlots[i];
                }
                return activeSlots[activeSlots.length - 1];
            }

            function animateSpin(selectedIndex) {
                // Ô thứ i (0..N-1 theo chiều kim đồng hồ, ô 0 ở 12h) cần góc (360 - i * arcAngle) để về đỉnh.
                const targetMod = ((360 - (selectedIndex * arcAngle)) % 360 + 360) % 360;
                const currentMod = ((currentRotation % 360) + 360) % 360;
                let forwardDelta = targetMod - currentMod;
                if (forwardDelta <= 0) forwardDelta += 360;

                if (prefersReducedMotion.matches) {
                    wheelElement.style.transition = 'none';
                    currentRotation = currentMod + forwardDelta;
                    wheelElement.style.transform = `rotate(${currentRotation}deg)`;
                    return Promise.resolve();
                }

                // Đưa góc về khoảng [0,360) trước mỗi lượt để số không phình to sau nhiều lượt quay.
                // Phải tắt transition và ép reflow, nếu không lượt quay sau sẽ bị cắt ngắn.
                if (currentRotation !== currentMod) {
                    wheelElement.style.transition = 'none';
                    wheelElement.style.transform = `rotate(${currentMod}deg)`;
                    void wheelElement.offsetWidth;
                    wheelElement.style.transition = '';
                }

                currentRotation = currentMod + 360 * 6 + forwardDelta;

                return new Promise(resolve => {
                    let settled = false;
                    let fallbackTimer = 0;

                    const done = event => {
                        if (event && event.target !== wheelElement) return;
                        if (settled) return;
                        settled = true;
                        clearTimeout(fallbackTimer);
                        wheelElement.removeEventListener('transitionend', done);
                        wheelElement.style.willChange = 'auto';
                        resolve();
                    };

                    wheelElement.addEventListener('transitionend', done);
                    wheelElement.style.willChange = 'transform';

                    // Ép browser flush style trước khi đổi transform để transition luôn chạy.
                    requestAnimationFrame(() => {
                        wheelElement.style.transform = `rotate(${currentRotation}deg)`;
                    });

                    fallbackTimer = setTimeout(done, 6000);
                });
            }

            function showResult(prize) {
                if (!resultModal || !resultReward) return;
                resultReward.textContent = prize;
                resultModal.classList.add('active');
            }

            function applyBalances(data) {
                // Cập nhật số dư tiền mặt tài khoản trên thanh navbar/drawer
                if (data.new_balance !== undefined && data.new_balance !== null) {
                    balanceNodes.forEach(el => {
                        el.textContent = numberFormatter.format(data.new_balance);
                    });
                }

                // Cập nhật số dư "BẠN ĐANG CÓ" ở cột bên phải theo đúng loại tài nguyên của vòng quay
                let newInvBalance = null;
                if (data.inventory && data.inventory.balance !== undefined && data.inventory.balance !== null) {
                    newInvBalance = data.inventory.balance;
                } else if (data.linked_item_balance !== undefined && data.linked_item_balance !== null) {
                    newInvBalance = data.linked_item_balance;
                }

                if (itemBalanceNode && newInvBalance !== null) {
                    itemBalanceNode.textContent = numberFormatter.format(newInvBalance);
                    itemBalanceNode.classList.remove('balance-updated');
                    void itemBalanceNode.offsetWidth; // ép reflow để kích hoạt lại animation
                    itemBalanceNode.classList.add('balance-updated');
                }

                if (itemUnitNode && data.inventory && data.inventory.unit) {
                    itemUnitNode.textContent = data.inventory.unit;
                } else if (itemUnitNode && data.reward_unit && data.reward_item_id === data.linked_item_id) {
                    itemUnitNode.textContent = data.reward_unit;
                }
            }

            function addHistoryEntry(entry) {
                if (!entry) return;
                const historyList = document.querySelector('.history-list');
                if (!historyList) return;

                // Xoá dòng "Chưa có lịch sử quay nào" nếu có
                const emptyPlaceholder = historyList.querySelector('.history-empty');
                if (emptyPlaceholder) {
                    emptyPlaceholder.remove();
                }

                const card = document.createElement('div');
                card.className = 'history-card history-card-new';

                const cardLeft = document.createElement('div');
                cardLeft.className = 'history-card-left';

                const avatar = document.createElement('div');
                avatar.className = 'history-avatar';
                avatar.innerHTML = '<i class="fas fa-user"></i>';

                const info = document.createElement('div');
                info.className = 'history-info';

                const nameDiv = document.createElement('div');
                nameDiv.className = 'history-name';
                nameDiv.textContent = entry.username || 'Người chơi';

                const rewardDiv = document.createElement('div');
                rewardDiv.className = 'history-reward';
                rewardDiv.textContent = entry.reward_text || `Trúng ${entry.description || ''}`;

                info.appendChild(nameDiv);
                info.appendChild(rewardDiv);
                cardLeft.appendChild(avatar);
                cardLeft.appendChild(info);

                const timeDiv = document.createElement('div');
                timeDiv.className = 'history-time';
                timeDiv.textContent = entry.time || 'Vừa xong';

                card.appendChild(cardLeft);
                card.appendChild(timeDiv);

                // Chèn lên đầu danh sách
                historyList.insertBefore(card, historyList.firstChild);

                // Giữ tối đa 10 thẻ lịch sử mới nhất
                while (historyList.children.length > 10) {
                    historyList.lastElementChild.remove();
                }
            }

            function finishSpin() {
                isSpinning = false;
                setSpinButtons(false);
            }

            async function spinWheel(isTrial) {
                if (isSpinning || !wheelReady) return;

                isSpinning = true;
                setSpinButtons(true);

                if (isTrial) {
                    const slot = pickTrialSlot();
                    if (!slot) {
                        showToast('Xác suất quay thử chưa được cấu hình.');
                        finishSpin();
                        return;
                    }

                    await animateSpin(slot.index);
                    showResult(`${slot.reward.content} (Chơi thử)`);
                    finishSpin();
                    return;
                }

                const spinCountValue = Math.max(1, Math.min(10, parseInt(spinCount?.value ?? '1', 10) || 1));

                try {
                    const response = await fetch(SPIN_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        body: JSON.stringify({ spin_count: spinCountValue })
                    });

                    const rawBody = await response.text();
                    let data;
                    try {
                        data = JSON.parse(rawBody);
                    } catch (error) {
                        console.warn('Wheel spin returned non-JSON response.', { status: response.status, body: rawBody.slice(0, 500) });
                        throw new Error('Phản hồi máy chủ không hợp lệ.');
                    }

                    if (!response.ok || !data.success) {
                        if (response.status === 429) {
                            throw new Error('Bạn quay quá nhanh, vui lòng chờ một chút.');
                        }
                        if (response.status === 401) {
                            throw new Error(data.message || 'Vui lòng đăng nhập để có thể quay.');
                        }
                        throw new Error(data.message || 'Không thể quay lúc này. Vui lòng thử lại.');
                    }

                    const reward = Array.isArray(data.rewards) ? data.rewards[0] : null;
                    const selectedIndex = Number(reward?.index);
                    if (!reward || !Number.isInteger(selectedIndex) || selectedIndex < 0 || selectedIndex >= totalItems) {
                        console.warn('Wheel spin returned an invalid reward index.', data);
                        throw new Error('Kết quả quay không hợp lệ.');
                    }

                    await animateSpin(selectedIndex);

                    const modalText = reward.content;
                    showResult(modalText);
                    applyBalances(data);
                    addHistoryEntry(data.history_entry);
                } catch (error) {
                    console.warn('Wheel spin request failed.', error);
                    showToast(error.message || 'Có lỗi xảy ra. Vui lòng thử lại sau.');
                } finally {
                    finishSpin();
                }
            }

            spinBtn.addEventListener('click', () => spinWheel(false));
            if (centerSpinBtn) centerSpinBtn.addEventListener('click', () => spinWheel(false));
            if (trialBtn) trialBtn.addEventListener('click', () => spinWheel(true));

            function closeModal() {
                if (resultModal) resultModal.classList.remove('active');
            }

            document.getElementById('modal-close')?.addEventListener('click', closeModal);
            document.getElementById('continue-btn')?.addEventListener('click', closeModal);
            resultModal?.addEventListener('click', event => {
                if (event.target === resultModal) closeModal();
            });
            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') closeModal();
            });

            prepareWheel();
        });
    </script>
@endpush
