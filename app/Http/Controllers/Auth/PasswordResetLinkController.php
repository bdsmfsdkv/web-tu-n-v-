<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
                // Local là môi trường test: xóa token cũ để có thể bấm thử lại ngay,
                // không bắt người test phải chờ throttle 60 giây.
                if ($isLocal) {
                    $repository->delete($user);
                } else {
                    return back()
                        ->withInput($request->only('email'))
                        ->withErrors(['email' => 'Bạn vừa yêu cầu email đặt lại mật khẩu. Vui lòng đợi khoảng 60 giây rồi thử lại.']);
                }
            }

            try {
                $token = $broker->createToken($user);
                $resetUrl = route('password.reset', [
                    'token' => $token,
                    'email' => $user->getEmailForPasswordReset(),
                ]);

                // LOCAL: không chờ SMTP. Hiện link reset ngay để test toàn bộ flow.
                // Khi đưa lên host với APP_ENV=production, nhánh này không chạy và
                // email thật vẫn được gửi qua SMTP bên dưới.
                if ($isLocal) {
                    Log::info('LOCAL PASSWORD RESET URL', [
                        'email' => $user->getEmailForPasswordReset(),
                        'url' => $resetUrl,
                    ]);

                    return back()
                        ->withInput($request->only('email'))
                        ->with('status', 'Đã tạo liên kết đặt lại mật khẩu để test local. Bấm nút bên dưới để tiếp tục.')
                        ->with('local_reset_url', $resetUrl);
                }

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
                    ->with('error', 'Không thể tạo liên kết đặt lại mật khẩu lúc này. Vui lòng thử lại sau.');
            }
        } finally {
            $lock->release();
        }
    }
}
