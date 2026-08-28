<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.exists' => 'Không tìm thấy tài khoản với địa chỉ email này.',
        ]);

        $broker = Password::broker();
        $user = $broker->getUser([
            'email' => $validated['email'],
        ]);

        if (! $user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Không tìm thấy tài khoản với địa chỉ email này.']);
        }

        $isLocal = app()->environment('local');

        // Chặn hai request quên mật khẩu chạy cùng lúc cho cùng một email.
        $lock = Cache::lock('forgot-password:'.sha1(strtolower($validated['email'])), 15);

        if (! $lock->get()) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Yêu cầu đặt lại mật khẩu đang được xử lý. Vui lòng chờ vài giây rồi thử lại.']);
        }

        try {
            $repository = $broker->getRepository();

            if ($repository->recentlyCreatedToken($user)) {
                // Local cho phép test lại ngay; production vẫn giữ throttle an toàn.
                if ($isLocal) {
                    $repository->delete($user);
                } else {
                    return back()
                        ->withInput($request->only('email'))
                        ->withErrors(['email' => 'Bạn vừa yêu cầu email đặt lại mật khẩu. Vui lòng đợi khoảng 60 giây rồi thử lại.']);
                }
            }

            try {
                // Tạo token bằng password broker rồi dùng notification chuẩn của User.
                // Không gọi Mail::send() trực tiếp để tránh hai luồng gửi reset khác nhau.
                $token = $broker->createToken($user);

                if ($isLocal) {
                    $resetUrl = route('password.reset', [
                        'token' => $token,
                        'email' => $user->getEmailForPasswordReset(),
                    ]);

                    Log::info('LOCAL PASSWORD RESET URL', [
                        'email' => $user->getEmailForPasswordReset(),
                        'url' => $resetUrl,
                    ]);
                }

                $user->sendPasswordResetNotification($token);

                Log::info('Đã gửi email đặt lại mật khẩu qua ResetPasswordNotification', [
                    'email' => $validated['email'],
                ]);

                return back()->with('status', 'Đã gửi liên kết đặt lại mật khẩu. Vui lòng kiểm tra hộp thư và cả mục Spam/Thư rác.');
            } catch (\Throwable $e) {
                try {
                    $repository->delete($user);
                } catch (\Throwable $cleanupError) {
                    Log::warning('Không thể dọn token đặt lại mật khẩu sau lỗi', [
                        'email' => $validated['email'],
                        'error' => $cleanupError->getMessage(),
                    ]);
                }

                Log::error('Lỗi xử lý liên kết đặt lại mật khẩu', [
                    'email' => $validated['email'],
                    'exception' => get_class($e),
                    'error' => $e->getMessage(),
                ]);

                return back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Không thể gửi email lúc này. Vui lòng thử lại sau.');
            }
        } finally {
            $lock->release();
        }
    }
}
