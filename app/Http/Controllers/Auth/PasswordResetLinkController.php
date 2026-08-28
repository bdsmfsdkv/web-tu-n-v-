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
        $user = $broker->getUser(['email' => $validated['email']]);

        if (! $user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Không tìm thấy tài khoản với địa chỉ email này.']);
        }

        $lock = Cache::lock('forgot-password:' . sha1(strtolower($validated['email'])), 15);

        if (! $lock->get()) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Yêu cầu đặt lại mật khẩu đang được xử lý. Vui lòng chờ vài giây rồi thử lại.']);
        }

        try {
            $repository = $broker->getRepository();
            $isDebug = config('app.debug');

            if ($repository->recentlyCreatedToken($user)) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Bạn vừa yêu cầu email đặt lại mật khẩu. Vui lòng đợi khoảng 60 giây rồi thử lại.']);
            }

            try {
                $token = $broker->createToken($user);
                $user->sendPasswordResetNotification($token);

                Log::info('Password reset email sent successfully', [
                    'user_id' => $user->id,
                    'email' => $user->getEmailForPasswordReset(),
                    'mailer' => config('mail.default'),
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                    'scheme' => config('mail.mailers.smtp.scheme'),
                    'from' => config('mail.from.address'),
                ]);

                return back()->with('status', 'Đã gửi liên kết đặt lại mật khẩu. Vui lòng kiểm tra hộp thư và mục Spam/Thư rác.');
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                $previous = $e->getPrevious()?->getMessage();

                try {
                    $repository->delete($user);
                } catch (\Throwable $cleanupError) {
                    Log::warning('Could not clean password reset token after mail failure', [
                        'email' => $validated['email'],
                        'error' => $cleanupError->getMessage(),
                    ]);
                }

                Log::error('PASSWORD RESET SMTP FAILURE', [
                    'user_id' => $user->id,
                    'email' => $validated['email'],
                    'exception' => get_class($e),
                    'error' => $error,
                    'previous' => $previous,
                    'mailer' => config('mail.default'),
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                    'scheme' => config('mail.mailers.smtp.scheme'),
                    'username' => config('mail.mailers.smtp.username'),
                    'from' => config('mail.from.address'),
                ]);

                $message = 'Không thể gửi email đặt lại mật khẩu.';

                if ($isDebug) {
                    $message .= ' Lỗi SMTP: ' . $error;
                    if ($previous) {
                        $message .= ' | Chi tiết trước đó: ' . $previous;
                    }
                } else {
                    $message .= ' Vui lòng thử lại sau hoặc liên hệ quản trị viên.';
                }

                return back()
                    ->withInput($request->only('email'))
                    ->with('error', $message);
            }
        } catch (\Throwable $e) {
            Log::error('PASSWORD RESET UNEXPECTED FAILURE', [
                'email' => $validated['email'],
                'exception' => get_class($e),
                'error' => $e->getMessage(),
            ]);

            $message = 'Không thể xử lý yêu cầu đặt lại mật khẩu.';
            if ($isDebug) {
                $message .= ' Lỗi: ' . $e->getMessage();
            }

            return back()
                ->withInput($request->only('email'))
                ->with('error', $message);
        } finally {
            $lock->release();
        }
    }
}
