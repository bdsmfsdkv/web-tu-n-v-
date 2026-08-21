@extends('layouts.user.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Đăng Nhập</h1>
            <p class="auth-subtitle">Chào mừng bạn quay trở lại!</p>
        </div>

        @if (session('success'))
            <div style="background:#ecfdf5;color:#15803d;padding:12px;border-radius:8px;font-size:0.85rem;margin-bottom:16px;border:1px solid #bbf7d0;display:flex;gap:8px;align-items:flex-start;">
                <i class="fas fa-check-circle" style="margin-top:2px;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div style="background:#fee2e2;color:#dc2626;padding:12px;border-radius:8px;font-size:0.85rem;margin-bottom:16px;border:1px solid #fecaca;display:flex;gap:8px;align-items:flex-start;">
                <i class="fas fa-exclamation-circle" style="margin-top:2px;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div style="background:#fff7ed;color:#c2410c;padding:12px;border-radius:8px;font-size:0.85rem;margin-bottom:16px;border:1px solid #fed7aa;display:flex;gap:8px;align-items:flex-start;">
                <i class="fas fa-triangle-exclamation" style="margin-top:2px;"></i>
                <div>
                    <strong>Đăng nhập chưa thành công.</strong>
                    <div style="margin-top:3px;">{{ $errors->first() }}</div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="on" novalidate>
            @csrf

            <div class="form-group">
                <label for="username" class="form-label">Tên tài khoản hoặc Email</label>
                <input id="username"
                       type="text"
                       class="form-input"
                       name="username"
                       value="{{ old('username') }}"
                       required
                       autofocus
                       autocomplete="username"
                       autocapitalize="none"
                       autocorrect="off"
                       spellcheck="false"
                       placeholder="Nhập tên tài khoản hoặc email">
                @error('username')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <div style="position:relative;">
                    <input id="password"
                           type="password"
                           class="form-input"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="••••••••"
                           style="padding-right:46px;">
                    <button type="button" id="toggleLoginPassword" aria-label="Hiện mật khẩu" title="Hiện/ẩn mật khẩu" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);border:0;background:transparent;color:#64748b;cursor:pointer;padding:6px;display:flex;align-items:center;justify-content:center;">
                        <span class="iconify" data-icon="ant-design:eye-outlined"></span>
                    </button>
                </div>
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

            <button type="submit" class="auth-btn">Đăng Nhập</button>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('password');
    var button = document.getElementById('toggleLoginPassword');
    if (!input || !button) return;
    button.addEventListener('click', function () {
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.setAttribute('aria-label', show ? 'Ẩn mật khẩu' : 'Hiện mật khẩu');
        var icon = button.querySelector('.iconify');
        if (icon) icon.setAttribute('data-icon', show ? 'ant-design:eye-invisible-outlined' : 'ant-design:eye-outlined');
    });
});
</script>
@endsection
