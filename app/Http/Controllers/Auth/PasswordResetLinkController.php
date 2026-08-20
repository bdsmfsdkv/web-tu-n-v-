<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        $repository = $broker->getRepository();

        if ($repository->recentlyCreatedToken($user)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Bạn vừa yêu cầu email đặt lại mật khẩu. Vui lòng đợi khoảng 60 giây rồi thử lại.']);
        }

        $token = $broker->createToken($user);
        $resetUrl = route('password.reset', [
            'token' => $token,
            'email' => $user->getEmailForPasswordReset(),
        ]);

        try {
            $body = "KUNCHEAP - Đặt lại mật khẩu\n\n"
                . "Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản KUNCHEAP.\n\n"
                . "Mở liên kết sau để tạo mật khẩu mới:\n"
                . $resetUrl . "\n\n"
                . "Liên kết đặt lại mật khẩu có thời hạn. Nếu bạn không yêu cầu thao tác này, hãy bỏ qua email này.\n\n"
                . "KUNCHEAP\n"
                . "admin@kuncheap.site";

            Mail::raw($body, function ($message) use ($validated) {
                $message
                    ->to($validated['email'])
                    ->subject('KUNCHEAP - Đặt lại mật khẩu');
            });

            Log::info('Đã gửi email đặt lại mật khẩu trực tiếp qua SMTP', [
                'email' => $validated['email'],
            ]);

            return back()->with('status', 'Đã gửi liên kết đặt lại mật khẩu. Vui lòng kiểm tra hộp thư và cả mục Spam/Thư rác.');
        } catch (\Throwable $e) {
            // Xóa token vừa tạo nếu email không gửi được để người dùng có thể thử lại ngay.
            $repository->delete($user);

            Log::error('Lỗi gửi link đặt lại mật khẩu trực tiếp', [
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
