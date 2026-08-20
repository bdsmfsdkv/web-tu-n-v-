<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Field thực tế dùng để xác thực sau khi kiểm tra input.
     */
    protected string $fieldInput = 'username';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Cho phép đăng nhập bằng username hoặc email.
     */
    public function authenticate(): void
    {
        $login = trim((string) $this->input('username'));
        $this->fieldInput = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $this->ensureIsNotRateLimited();

        $credentials = [
            $this->fieldInput => $login,
            'password' => (string) $this->input('password'),
        ];

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        $login = trim((string) $this->input('username'));

        return Str::transliterate(Str::lower($login) . '|' . $this->ip());
    }
}
