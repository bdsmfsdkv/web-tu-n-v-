@extends('layouts.user.app')

@section('title', 'Quên mật khẩu')

@push('css')
<style>
    .password-recovery-card .auth-header { margin-bottom: 22px !important; }
    .password-recovery-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc2626;
        font-size: 1.45rem;
        background: #fff1f2;
        border: 1px solid #fecdd3;
        border-radius: 18px;
        box-shadow: 0 8px 20px rgba(220,38,38,.08);
    }
    .password-help-text {
        margin: -5px 0 18px;
        color: #64748b;
        font-size: .78rem;
        line-height: 1.55;
    }
    .password-alert {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 16px;
        padding: 11px 38px 11px 12px;
        font-size: .82rem;
        line-height: 1.45;
        border-radius: 10px;
    }
    .password-alert.success { color: #166534; background: #f0fdf4; border: 1px solid #bbf7d0; }
    .password-alert.error { color: #b91c1c; background: #fef2f2; border: 1px solid #fecaca; }
    .password-alert-close {
        position: absolute;
        top: 7px;
        right: 8px;
        width: 25px;
        height: 25px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: inherit;
        background: transparent;
        border: 0;
        border-radius: 50%;
        cursor: pointer;
    }
    .password-back-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        margin-top: 16px;
        color: #64748b;
        font-size: .84rem;
        font-weight: 650;
        text-decoration: none;
    }
    .password-back-link:hover { color: #dc2626; }
    [data-theme="dark"] .password-recovery-icon { background: #2a1718; border-color: #4b2427; }
    [data-theme="dark"] .password-help-text,
    [data-theme="dark"] .password-back-link { color: #a3a3a3; }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-card password-recovery-card">
        <div class="auth-header">
            <div class="password-recovery-icon">
                <i class="fa-solid fa-key"></i>
            </div>
            <h1 class="auth-title">Quên Mật Khẩu</h1>
            <p class="auth-subtitle">Nhập email đã đăng ký để nhận liên kết đặt lại mật khẩu.</p>
        </div>

        @if (session('status'))
            <div class="password-alert success">
                <i class="fa-solid fa-circle-check" style="margin-top:2px;"></i>
                <span>{{ session('status') }}</span>
                <button type="button" class="password-alert-close" onclick="this.parentElement.remove()" aria-label="Đóng">×</button>
            </div>
        @endif

        @if (session('error'))
            <div class="password-alert error">
                <i class="fa-solid fa-circle-exclamation" style="margin-top:2px;"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="password-alert-close" onclick="this.parentElement.remove()" aria-label="Đóng">×</button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" autocomplete="on">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input id="email"
                       type="email"
                       class="form-input @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="email"
                       inputmode="email"
                       autocapitalize="none"
                       autocorrect="off"
                       spellcheck="false"
                       placeholder="vidu@gmail.com">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <p class="password-help-text">
                Liên kết đặt lại mật khẩu sẽ được gửi tới email này. Hãy kiểm tra cả mục Spam/Thư rác nếu chưa thấy thư.
            </p>

            <button type="submit" class="auth-btn">
                <i class="fa-regular fa-paper-plane" style="margin-right:7px;"></i>
                Gửi Liên Kết Đặt Lại Mật Khẩu
            </button>

            <a href="{{ route('login') }}" class="password-back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại đăng nhập
            </a>
        </form>
    </div>
</div>
@endsection
