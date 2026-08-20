<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        try {
            $status = Password::sendResetLink([
                'email' => $validated['email'],
            ]);

            if ($status === Password::RESET_LINK_SENT) {
                return back()->with('status', 'Đã gửi liên kết đặt lại mật khẩu. Vui lòng kiểm tra hộp thư và cả mục Spam/Thư rác.');
            }

            if ($status === Password::RESET_THROTTLED) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Bạn vừa yêu cầu email đặt lại mật khẩu. Vui lòng đợi khoảng 60 giây rồi thử lại.']);
            }

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Không thể gửi liên kết đặt lại mật khẩu. Vui lòng thử lại sau.']);
        } catch (\Throwable $e) {
            Log::error('Lỗi gửi link đặt lại mật khẩu', [
                'email' => $validated['email'],
                'exception' => get_class($e),
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Không thể gửi email lúc này. Vui lòng kiểm tra cấu hình SMTP hoặc thử lại sau.');
        }
    }
}
