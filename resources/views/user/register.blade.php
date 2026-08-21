@extends('layouts.user.app')

@section('title', 'Đăng ký tài khoản')

@push('css')
<style>
    .password-input-wrap { position: relative; }
    .password-input-wrap .form-input { padding-right: 48px !important; }
    .password-toggle {
        position: absolute;
        top: 50%;
        right: 7px;
        width: 34px;
        height: 34px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transform: translateY(-50%);
        color: #64748b;
        background: transparent;
        border: 0;
        border-radius: 8px;
        cursor: pointer;
    }
    .password-toggle:hover,
    .password-toggle:focus-visible { color: #dc2626; background: #fff1f2; outline: none; }
    [data-theme="dark"] .password-toggle { color: #a3a3a3; }
    [data-theme="dark"] .password-toggle:hover,
    [data-theme="dark"] .password-toggle:focus-visible { color: #f87171; background: #2a1718; }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Đăng Ký Tài Khoản</h1>
            <p class="auth-subtitle">Tạo tài khoản để sử dụng dịch vụ dễ dàng hơn</p>
        </div>

        <x-alert-error />

        <form method="POST" action="{{ route('register') }}" autocomplete="on">
            @csrf

            <div class="form-group">
                <label for="username" class="form-label">Tên tài khoản</label>
                <input id="username"
                       type="text"
                       class="form-input"
                       name="username"
                       value="{{ old('username') }}"
                       required
                       autofocus
                       autocomplete="username"
                       autocapitalize="none"
                       spellcheck="false"
                       placeholder="Tên tài khoản">
                @error('username')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email"
                       type="email"
                       class="form-input"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       inputmode="email"
                       autocapitalize="none"
                       spellcheck="false"
                       placeholder="VD: example@gmail.com">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="password-input-wrap">
                    <input id="password"
                           type="password"
                           class="form-input"
                           name="password"
                           required
                           autocomplete="new-password"
                           placeholder="Tối thiểu 8 ký tự">
                    <button type="button"
                            class="password-toggle"
                            data-password-target="password"
                            aria-label="Hiện mật khẩu"
                            aria-pressed="false">
                        <i class="fa-regular fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">Xác nhận mật khẩu</label>
                <div class="password-input-wrap">
                    <input id="password-confirm"
                           type="password"
                           class="form-input"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           placeholder="Nhập lại mật khẩu">
                    <button type="button"
                            class="password-toggle"
                            data-password-target="password-confirm"
                            aria-label="Hiện mật khẩu"
                            aria-pressed="false">
                        <i class="fa-regular fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="auth-btn">
                Đăng Ký Ngay
            </button>
        </form>

        @if (config_get('login_social.google.active', false) || config_get('login_social.facebook.active', false))
            <div class="social-divider">Hoặc đăng ký bằng</div>
            
            @if (config_get('login_social.google.active', false))
                <a href="{{ route('auth.google') }}" class="social-btn">
                    <span class="iconify" data-icon="flat-color-icons:google" style="font-size:1.2rem;"></span>
                    Google
                </a>
            @endif
            
            @if (config_get('login_social.facebook.active', false))
                <a href="{{ route('auth.facebook') }}" class="social-btn">
                    <span class="iconify" data-icon="logos:facebook" style="font-size:1.2rem;"></span>
                    Facebook
                </a>
            @endif
        @endif

        <div class="auth-links">
            Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.password-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = document.getElementById(this.getAttribute('data-password-target'));
            if (!input) return;

            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            this.setAttribute('aria-pressed', String(show));
            this.setAttribute('aria-label', show ? 'Ẩn mật khẩu' : 'Hiện mật khẩu');

            var icon = this.querySelector('i');
            icon.classList.toggle('fa-eye', !show);
            icon.classList.toggle('fa-eye-slash', show);
        });
    });
});
</script>
@endsection
