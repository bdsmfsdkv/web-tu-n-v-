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

        <form method="POST" action="{{ route('login') }}" autocomplete="on" novalidate>
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
                       inputmode="text"
                       autocapitalize="none"
                       autocorrect="off"
                       spellcheck="false"
                       placeholder="Nhập tên tài khoản">
                @error('username')
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
@endsection
