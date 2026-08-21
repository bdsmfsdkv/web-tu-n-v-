@extends('layouts.user.app')

@section('title', 'Đặt lại mật khẩu')

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
    .password-readonly {
        background: #f8fafc !important;
        color: #64748b !important;
        cursor: default;
    }
    .password-input-wrap {
        position: relative;
    }
    .password-input-wrap .form-input {
        padding-right: 46px !important;
    }
    .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
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
        transition: color .15s ease, background-color .15s ease;
    }
    .password-toggle:hover,
    .password-toggle:focus-visible {
        color: #dc2626;
        background: #fff1f2;
        outline: none;
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
    [data-theme="dark"] .password-readonly { background: #202020 !important; color: #a3a3a3 !important; }
    [data-theme="dark"] .password-toggle { color: #a3a3a3; }
    [data-theme="dark"] .password-toggle:hover,
    [data-theme="dark"] .password-toggle:focus-visible { color: #f87171; background: #2a1718; }
    [data-theme="dark"] .password-back-link { color: #a3a3a3; }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-card password-recovery-card">
        <div class="auth-header">
            <div class="password-recovery-icon">
                <i class="fa-solid fa-lock-open"></i>
            </div>
            <h1 class="auth-title">Đặt Lại Mật Khẩu</h1>
            <p class="auth-subtitle">Tạo mật khẩu mới cho tài khoản của bạn.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" autocomplete="on">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input id="email"
                       type="email"
                       class="form-input password-readonly @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ old('email', $request->email) }}"
                       required
                       readonly
                       autocomplete="email">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu mới</label>
                <div class="password-input-wrap">
                    <input id="password"
                           type="password"
                           class="form-input @error('password') is-invalid @enderror"
                           name="password"
                           required
                           autofocus
                           autocomplete="new-password"
                           placeholder="Nhập mật khẩu mới">
                    <button type="button"
                            class="password-toggle"
                            data-password-target="password"
                            aria-label="Hiện mật khẩu"
                            aria-pressed="false">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                <div class="password-input-wrap">
                    <input id="password_confirmation"
                           type="password"
                           class="form-input"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           placeholder="Nhập lại mật khẩu mới">
                    <button type="button"
                            class="password-toggle"
                            data-password-target="password_confirmation"
                            aria-label="Hiện mật khẩu"
                            aria-pressed="false">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="auth-btn">
                <i class="fa-solid fa-shield-halved" style="margin-right:7px;"></i>
                Cập Nhật Mật Khẩu
            </button>

            <a href="{{ route('login') }}" class="password-back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại đăng nhập
            </a>
        </form>
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
            if (icon) {
                icon.classList.toggle('fa-eye', !show);
                icon.classList.toggle('fa-eye-slash', show);
            }
        });
    });
});
</script>
@endsection
