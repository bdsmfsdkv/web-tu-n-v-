@extends('layouts.user.app')

@section('title', $title)

@push('css')
<style>
    .account-language-row .info-value {
        overflow: visible !important;
    }

    .account-language-picker {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 7px;
    }

    .account-language-btn {
        min-height: 34px;
        padding: 6px 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        color: #475569;
        font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        font-size: .76rem;
        font-weight: 750;
        line-height: 1;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        cursor: pointer;
        transition: border-color .16s ease, background-color .16s ease, color .16s ease, transform .16s ease, box-shadow .16s ease;
    }

    .account-language-btn img {
        width: 19px;
        height: 14px;
        object-fit: cover;
        border-radius: 2px;
    }

    .account-language-btn:hover {
        color: #dc2626;
        border-color: #fecaca;
        background: #fff7f7;
        transform: translateY(-1px);
    }

    .account-language-btn.active {
        color: #fff;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border-color: #dc2626;
        box-shadow: 0 6px 14px rgba(220, 38, 38, .18);
    }

    [data-theme="dark"] .account-language-btn {
        color: #d1d5db;
        background: #202020;
        border-color: #343434;
    }

    [data-theme="dark"] .account-language-btn:hover {
        color: #fca5a5;
        background: #2a1d1d;
        border-color: #7f1d1d;
    }

    [data-theme="dark"] .account-language-btn.active {
        color: #fff;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border-color: #dc2626;
    }

    @media (max-width: 640px) {
        .account-language-row {
            align-items: flex-start !important;
        }

        .account-language-row .info-value {
            width: 100% !important;
        }

        .account-language-picker {
            margin-top: 8px;
            justify-content: flex-start;
        }
    }
</style>
@endpush

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-user-circle me-2"></i> THÔNG TIN TÀI KHOẢN</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> THÔNG TIN TÀI KHOẢN</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-id-card me-2"></i> ID tài khoản
                                    </div>
                                    <div class="info-value">{{ $user->id }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-user me-2"></i> Tên đăng nhập
                                    </div>
                                    <div class="info-value">{{ $user->username }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-envelope me-2"></i> Email
                                    </div>
                                    <div class="info-value">{{ $user->email }}</div>
                                </div>

                                <div class="info-row account-language-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-globe me-2"></i> Ngôn ngữ
                                    </div>
                                    <div class="info-value">
                                        <div class="account-language-picker" id="accountLanguagePicker" aria-label="Chọn ngôn ngữ">
                                            <button type="button" class="account-language-btn" data-lang="vi" onclick="setLanguage('vi')">
                                                <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/vn.svg" alt="VN"> VI
                                            </button>
                                            <button type="button" class="account-language-btn" data-lang="en" onclick="setLanguage('en')">
                                                <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/us.svg" alt="US"> EN
                                            </button>
                                            <button type="button" class="account-language-btn" data-lang="zh-CN" onclick="setLanguage('zh-CN')">
                                                <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/cn.svg" alt="CN"> ZH
                                            </button>
                                            <button type="button" class="account-language-btn" data-lang="ko" onclick="setLanguage('ko')">
                                                <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/kr.svg" alt="KR"> KO
                                            </button>
                                            <button type="button" class="account-language-btn" data-lang="ja" onclick="setLanguage('ja')">
                                                <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/jp.svg" alt="JP"> JA
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-key me-2"></i> Mật khẩu
                                    </div>
                                    <div class="info-value">
                                        ********
                                        <a href="{{ route('profile.change-password') }}" class="change-password-link">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Đổi mật khẩu
                                        </a>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-wallet me-2"></i> Số dư
                                    </div>
                                    <div class="info-value info-value--highlight">
                                        {{ number_format($user->balance) }} VND
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-money-bill-trend-up me-2"></i> Tổng nạp
                                    </div>
                                    <div class="info-value">
                                        {{ number_format($user->total_deposited) }} VND
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-gem me-2"></i> Vật Phẩm
                                    </div>
                                    <div class="info-value">
                                        {{ number_format($user->gem) }}
                                        <a href="{{ route('profile.withdraw-gem') }}" class="change-password-link">
                                            <i class="fa-solid fa-gem me-1"></i> Rút Vật Phẩm
                                        </a>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-calendar-check me-2"></i> Ngày tạo
                                    </div>
                                    <div class="info-value">
                                        {{ $user->created_at->format('H:i d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var currentLang = localStorage.getItem('sunihost_lang') || 'vi';
        document.querySelectorAll('#accountLanguagePicker .account-language-btn').forEach(function (button) {
            button.classList.toggle('active', button.getAttribute('data-lang') === currentLang);
        });
    });
</script>
@endpush
