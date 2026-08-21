@extends('layouts.user.app')
@section('title', $wheel->name)

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/wheel.css') }}">
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
            <div class="left-panel-stack" style="display: flex; flex-direction: column; gap: 24px;">
                <!-- Main Wheel Card -->
                <div class="main-card">
                    <div class="wheel-arena-wrapper">
                        <div class="wheel-image-container">
                            <img src="{{ asset($wheel->wheel_image) }}" alt="Vòng quay" class="wheel-image">
                        </div>
                        <img src="/" class="center-pointer-core" id="btnSpinCenterInner" style="object-fit: contain; background: transparent; border-radius: 50%;" onerror="this.src='';">
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

                        <button type="button" class="btn-white" id="trial-btn">CHƠI THỬ</button>
                        <button type="button" class="btn-blue" id="spin-btn">QUAY NGAY</button>
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
                                @php
                                    $rewardItem = \App\Models\RewardItem::first();
                                    $unitName = $rewardItem ? $rewardItem->unit : 'KIM CƯƠNG';
                                @endphp
                                <span class="user-balance">{{ number_format(Auth::check() ? Auth::user()->gem : 0) }}</span> 
                                <span class="inventory-unit">{{ $unitName }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="inventory-buttons">
                        <a href="{{ route('profile.wheels-history') }}" class="btn-history">
                            <i class="fas fa-history"></i> Lịch Sử Quay
                        </a>
                        <a href="{{ route('profile.withdraw-gem') }}" class="btn-withdraw">
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
                                            <div class="history-name">{{ Str::limit($item->user->username, 4) }}***</div>
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
                            <div style="text-align: center; color: var(--text-muted); padding: 20px 0;">
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
            // Spin the wheel
            let isSpinning = false;
            const spinBtn = document.getElementById('spin-btn');
            const centerSpinBtn = document.getElementById('btnSpinCenterInner');
            const wheelElement = document.querySelector('.wheel-image');
            const spinCount = document.getElementById('spin-count');
            const totalItems = 8; // Fixed to 8 items on the wheel
            const arcAngle = 360 / totalItems;

            const trialBtn = document.getElementById('trial-btn');
            
            // Pass the wheel config to JS for trial spins
            const wheelConfig = @json($wheel->config);

            if (spinBtn) spinBtn.addEventListener('click', () => spinWheel(false));
            if (centerSpinBtn) centerSpinBtn.addEventListener('click', () => spinWheel(false));
            if (trialBtn) trialBtn.addEventListener('click', () => spinWheel(true));

            function spinWheel(isTrial) {
                if (isSpinning) return;

                isSpinning = true;
                spinBtn.disabled = true;
                trialBtn.disabled = true;

                if (isTrial) {
                    if (!Array.isArray(wheelConfig) || wheelConfig.length === 0) {
                        showSpinError('Vòng quay chưa được cấu hình.');
                        return;
                    }

                    const probabilities = wheelConfig.map(reward => {
                        const trialProbability = Number(reward.trial_probability);
                        const probability = Number(reward.probability);
                        return Number.isFinite(trialProbability) && trialProbability > 0
                            ? trialProbability
                            : (Number.isFinite(probability) && probability > 0 ? probability : 0);
                    });
                    const totalProb = probabilities.reduce((sum, probability) => sum + probability, 0);

                    if (totalProb <= 0) {
                        showSpinError('Xác suất quay thử chưa được cấu hình.');
                        return;
                    }

                    let rand = Math.random() * totalProb;
                    let currentSum = 0;
                    let selectedIndex = 0;

                    for (let i = 0; i < wheelConfig.length; i++) {
                        currentSum += probabilities[i];
                        if (rand <= currentSum) {
                            selectedIndex = i;
                            break;
                        }
                    }

                    const reward = wheelConfig[selectedIndex];
                    const stopAngle = -(selectedIndex * arcAngle);
                    const extraRotations = 5;
                    const totalRotation = stopAngle - (360 * extraRotations);

                    wheelElement.style.transform = `rotate(${totalRotation}deg)`;

                    setTimeout(() => {
                        const resultMessage = `${reward.content} (Chơi thử)`;
                        showResult(resultMessage);
                        isSpinning = false;
                        spinBtn.disabled = false;
                        trialBtn.disabled = false;

                        setTimeout(() => {
                            wheelElement.style.transition = 'none';
                            wheelElement.style.transform = 'rotate(0deg)';
                            setTimeout(() => {
                                wheelElement.style.transition = 'transform 5s cubic-bezier(0.2, 0.8, 0.3, 1)';
                            }, 50);
                        }, 1000);
                    }, 5000);
                    
                    return;
                }

                // Get spin count
                const spinCountValue = parseInt(spinCount.value);
                if (spinCountValue > 10) {
                    if (typeof FuiToast !== 'undefined') {
                        FuiToast.error("Mỗi lần quay tối đa 10 lần");
                    } else {
                        alert("Mỗi lần quay tối đa 10 lần")
                    }
                    isSpinning = false;
                    spinBtn.disabled = false;
                    trialBtn.disabled = false;
                } else {
                    // Send AJAX request to the server
                    fetch('{{ route('lucky.spin', $wheel->slug) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                spin_count: spinCountValue
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                if (typeof FuiToast !== 'undefined') {
                                    FuiToast.error(data.message);
                                } else {
                                    alert(data.message);
                                }
                                isSpinning = false;
                                spinBtn.disabled = false;
                                trialBtn.disabled = false;
                                return;
                            }

                            // Get the reward from server
                            const reward = data.rewards[0]; // Lấy phần thưởng
                            const selectedIndex = reward.index;

                            // Calculate the angle to stop at
                            const stopAngle = -(selectedIndex * arcAngle);
                            const extraRotations = 5; // Add extra rotations for effect
                            const totalRotation = stopAngle - (360 * extraRotations);

                            // Rotate wheel
                            wheelElement.style.transform = `rotate(${totalRotation}deg)`;

                            // Show result after animation ends
                            setTimeout(() => {
                                // Hiển thị kết quả với số lượt quay
                                const resultMessage = spinCountValue > 1 ?
                                    `${reward.content} x ${spinCountValue} lượt quay` :
                                    reward.content;

                                showResult(resultMessage);
                                isSpinning = false;
                                spinBtn.disabled = false;
                                trialBtn.disabled = false;

                                // Update user balance if provided
                                if (data.new_gem !== undefined) {
                                    // Update balance display if you have one
                                    const balanceElement = document.querySelector('.user-balance');
                                    if (balanceElement) {
                                        balanceElement.textContent = new Intl.NumberFormat('vi-VN')
                                            .format(
                                                data.new_gem);
                                    }
                                }

                                // Reset wheel after a delay
                                setTimeout(() => {
                                    wheelElement.style.transition = 'none';
                                    wheelElement.style.transform = 'rotate(0deg)';
                                    setTimeout(() => {
                                        wheelElement.style.transition =
                                            'transform 5s cubic-bezier(0.2, 0.8, 0.3, 1)';
                                    }, 50);
                                }, 1000);

                            }, 5000);
                        })
                        .catch(error => {
                            // console.error('Error:', error);
                            if (typeof FuiToast !== 'undefined') {
                                FuiToast.error('Có lỗi xảy ra. Vui lòng thử lại sau.');
                            } else {
                                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                            }
                            isSpinning = false;
                            spinBtn.disabled = false;
                            trialBtn.disabled = false;
                        });
                }
            }

            function showSpinError(message) {
                isSpinning = false;
                spinBtn.disabled = false;
                trialBtn.disabled = false;

                if (typeof FuiToast !== 'undefined') {
                    FuiToast.error(message);
                } else {
                    alert(message);
                }
            }

            // Show result modal
            function showResult(prize) {
                const modal = document.getElementById('result-modal');
                const rewardText = document.getElementById('result-reward');

                rewardText.textContent = prize;
                modal.classList.add('active');
            }

            // Handle modal close
            const modalClose = document.getElementById('modal-close');
            const continueBtn = document.getElementById('continue-btn');

            modalClose.addEventListener('click', closeModal);
            continueBtn.addEventListener('click', closeModal);

            function closeModal() {
                const modal = document.getElementById('result-modal');
                modal.classList.remove('active');
            }

        });
    </script>
@endpush
