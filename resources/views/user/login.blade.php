@extends('layouts.user.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Đăng Nhập</h1>
            <p class="auth-subtitle">Chào mừng bạn quay trở lại!</p>
        </div>

        @if (session('error'))
            <div style="background:#fee2e2;color:#dc2626;padding:12px;border-radius:8px;font-size:0.85rem;margin-bottom:16px;border:1px solid #fecaca;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="on" novalidate id="loginForm">
            @csrf

            <div class="login-id-switch" role="tablist" aria-label="Kiểu đăng nhập">
                <button type="button" class="login-id-switch-btn active" id="loginModeEmail" data-mode="email">Email</button>
                <button type="button" class="login-id-switch-btn" id="loginModeUsername" data-mode="username">Tên tài khoản</button>
            </div>

            <div class="form-group">
                <label for="username" class="form-label" id="loginIdentifierLabel">Email</label>
                <input id="username"
                       type="email"
                       class="form-input"
                       name="username"
                       value="{{ old('username') }}"
                       required
                       autofocus
                       autocomplete="email"
                       inputmode="email"
                       autocapitalize="none"
                       autocorrect="off"
                       spellcheck="false"
                       placeholder="VD: example@gmail.com">
                <div class="login-email-hint" id="loginIdentifierHint">Chọn email đã lưu trong trình duyệt hoặc nhập email của bạn.</div>
                @error('username')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password"
                       type="password"
                       class="form-input"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="••••••••">
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="display:flex;justify-content:space-between;align-items:center;">
                <div style="display:flex;align-items:center;gap:6px;font-size:0.85rem;">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="cursor:pointer;">
                    <label for="remember" style="cursor:pointer;color:#666;">Ghi nhớ</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:0.85rem;color:var(--primary);text-decoration:none;">Quên mật khẩu?</a>
                @endif
            </div>

            <button type="submit" class="auth-btn">
                Đăng Nhập
            </button>
        </form>

        @if (config_get('login_social.google.active', false) || config_get('login_social.facebook.active', false))
            <div class="social-divider">Hoặc tiếp tục với</div>
            
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
            Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
        </div>
    </div>
</div>

@push('css')
<style>
    .login-id-switch {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4px;
        margin-bottom: 18px;
        padding: 4px;
        background: #f4f5f7;
        border: 1px solid #e5e7eb;
        border-radius: 11px;
    }
    .login-id-switch-btn {
        min-height: 34px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #64748b;
        font: inherit;
        font-size: .8rem;
        font-weight: 700;
        cursor: pointer;
        transition: background-color .16s ease, color .16s ease, box-shadow .16s ease;
    }
    .login-id-switch-btn.active {
        background: #fff;
        color: #dc2626;
        box-shadow: 0 2px 8px rgba(15,23,42,.08);
    }
    .login-email-hint {
        margin-top: 6px;
        color: #94a3b8;
        font-size: .72rem;
        line-height: 1.4;
    }
    [data-theme="dark"] .login-id-switch { background:#202020; border-color:#303030; }
    [data-theme="dark"] .login-id-switch-btn.active { background:#2a2a2a; }
</style>
@endpush

@push('js')
<script>
(function () {
    function setupLoginModeSwitch() {
        var input = document.getElementById('username');
        var label = document.getElementById('loginIdentifierLabel');
        var hint = document.getElementById('loginIdentifierHint');
        var emailBtn = document.getElementById('loginModeEmail');
        var usernameBtn = document.getElementById('loginModeUsername');
        if (!input || !emailBtn || !usernameBtn) return;

        function setMode(mode) {
            var emailMode = mode === 'email';
            emailBtn.classList.toggle('active', emailMode);
            usernameBtn.classList.toggle('active', !emailMode);

            input.type = emailMode ? 'email' : 'text';
            input.setAttribute('autocomplete', emailMode ? 'email' : 'username');
            input.setAttribute('inputmode', emailMode ? 'email' : 'text');
            input.placeholder = emailMode ? 'VD: example@gmail.com' : 'Nhập tên tài khoản';
            label.textContent = emailMode ? 'Email' : 'Tên tài khoản';
            hint.textContent = emailMode
                ? 'Chọn email đã lưu trong trình duyệt hoặc nhập email của bạn.'
                : 'Đăng nhập bằng tên tài khoản đã đăng ký.';

            input.value = '';
            input.focus();
        }

        emailBtn.addEventListener('click', function () { setMode('email'); });
        usernameBtn.addEventListener('click', function () { setMode('username'); });

        var oldValue = input.value || '';
        if (oldValue && oldValue.indexOf('@') === -1) {
            usernameBtn.classList.add('active');
            emailBtn.classList.remove('active');
            input.type = 'text';
            input.setAttribute('autocomplete', 'username');
            input.setAttribute('inputmode', 'text');
            input.placeholder = 'Nhập tên tài khoản';
            label.textContent = 'Tên tài khoản';
            hint.textContent = 'Đăng nhập bằng tên tài khoản đã đăng ký.';
        }
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', setupLoginModeSwitch);
    else setupLoginModeSwitch();
})();
</script>
@endpush
@endsection
