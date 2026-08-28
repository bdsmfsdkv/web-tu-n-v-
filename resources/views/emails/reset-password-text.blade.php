{{ $siteName }} - Đặt lại mật khẩu

Xin chào {{ $notifiable->username ?? 'bạn' }}!

Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản {{ $siteName }} của bạn.

Mở liên kết sau để tiếp tục:
{{ $resetUrl }}

Liên kết này sẽ hết hạn sau {{ $expireMinutes }} phút.

Nếu bạn không yêu cầu đặt lại mật khẩu, bạn có thể bỏ qua email này.

Trân trọng,
{{ $siteName }}
