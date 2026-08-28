<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }} - Đặt lại mật khẩu</title>
</head>
<body style="margin:0;padding:20px;background:#f9f9f9;font-family:Arial,Helvetica,sans-serif;color:#333;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:600px;background:#ffffff;border-collapse:collapse;">
                    <tr>
                        <td align="center" style="background:#0E3EDA;color:#ffffff;padding:24px 20px;">
                            <div style="font-size:22px;line-height:1.3;font-weight:700;">{{ $siteName }}</div>
                            <div style="font-size:20px;line-height:1.4;font-weight:700;margin-top:8px;">Đặt lại mật khẩu</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 24px;">
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;">Xin chào <strong>{{ $notifiable->username ?? 'bạn' }}</strong>!</p>
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;">
                                Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản {{ $siteName }} của bạn.
                            </p>
                            <p style="margin:0 0 20px;font-size:15px;line-height:1.6;">
                                Nhấp vào nút bên dưới để tiếp tục.
                            </p>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tr>
                                    <td align="center" style="border-radius:5px;background:#0E3EDA;">
                                        <a href="{{ $resetUrl }}" target="_blank" rel="noopener" style="display:inline-block;padding:12px 22px;color:#ffffff;text-decoration:none;font-size:15px;font-weight:700;">Đặt lại mật khẩu</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:24px 0 0;font-size:13px;line-height:1.6;color:#666;">
                                Liên kết này sẽ hết hạn sau {{ $expireMinutes }} phút.
                            </p>
                            <p style="margin:8px 0 0;font-size:13px;line-height:1.6;color:#666;">
                                Nếu bạn không yêu cầu đặt lại mật khẩu, bạn có thể bỏ qua email này.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:1px solid #ddd;padding:16px 24px;text-align:center;font-size:12px;line-height:1.5;color:#777;">
                            Email tự động từ {{ $siteName }}.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
