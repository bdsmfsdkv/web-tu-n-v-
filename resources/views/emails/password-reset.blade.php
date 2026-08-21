<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }} - Đặt lại mật khẩu</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#202124;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%;background:#f4f6f8;margin:0;padding:0;">
    <tr>
        <td align="center" style="padding:28px 12px;">
            <table role="presentation" width="620" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:620px;background:#ffffff;border-collapse:separate;border-spacing:0;border-radius:10px;overflow:hidden;box-shadow:0 1px 4px rgba(15,23,42,.08);">
                <tr>
                    <td align="center" style="background:#1f45dc;padding:28px 28px 32px;">
                        <div style="font-size:20px;line-height:1.2;font-weight:800;color:#ffffff;letter-spacing:.5px;margin-bottom:18px;">{{ $siteName }}</div>
                        <div style="font-size:24px;line-height:1.3;font-weight:800;color:#ffffff;">Đặt lại mật khẩu</div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:34px 32px 30px;">
                        <p style="margin:0 0 18px;font-size:15px;line-height:1.7;color:#202124;">Xin chào <strong>{{ $userName }}</strong>!</p>

                        <p style="margin:0 0 18px;font-size:15px;line-height:1.7;color:#202124;">
                            Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn trên <strong>{{ $siteName }}</strong>.
                        </p>

                        <p style="margin:0 0 26px;font-size:15px;line-height:1.7;color:#202124;">
                            Vui lòng nhấp vào nút bên dưới để tạo mật khẩu mới:
                        </p>

                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td align="center" style="padding:0 0 28px;">
                                    <a href="{{ $resetUrl }}" target="_blank" rel="noopener" style="display:inline-block;background:#1f45dc;color:#ffffff;text-decoration:none;font-size:15px;line-height:20px;font-weight:700;padding:13px 24px;border-radius:6px;">Đặt lại mật khẩu</a>
                                </td>
                            </tr>
                        </table>

                        <div style="background:#f5f5f5;border-radius:6px;padding:18px 18px;margin:0 0 22px;">
                            <p style="margin:0 0 10px;font-size:14px;line-height:1.6;color:#5f6368;">
                                Liên kết đặt lại mật khẩu này sẽ hết hạn sau <strong>{{ $expireMinutes }} phút</strong>.
                            </p>
                            <p style="margin:0;font-size:14px;line-height:1.6;color:#5f6368;">
                                Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này. Tài khoản của bạn sẽ không bị thay đổi.
                            </p>
                        </div>

                        <p style="margin:0 0 8px;font-size:14px;line-height:1.6;color:#3c4043;">
                            Nếu bạn gặp sự cố khi nhấp vào nút “Đặt lại mật khẩu”, hãy sao chép và dán URL này vào trình duyệt:
                        </p>

                        <p style="margin:0 0 24px;font-size:13px;line-height:1.6;word-break:break-all;overflow-wrap:anywhere;">
                            <a href="{{ $resetUrl }}" target="_blank" rel="noopener" style="color:#1a73e8;text-decoration:underline;">{{ $resetUrl }}</a>
                        </p>

                        <p style="margin:0;font-size:14px;line-height:1.65;color:#3c4043;">
                            Trân trọng,<br>
                            <strong>{{ $siteName }}</strong><br>
                            <a href="mailto:{{ $supportEmail }}" style="color:#5f6368;text-decoration:none;">{{ $supportEmail }}</a>
                        </p>
                    </td>
                </tr>
            </table>

            <div style="max-width:620px;margin:14px auto 0;font-size:12px;line-height:1.5;color:#8a8f98;text-align:center;">
                Email tự động từ {{ $siteName }}. Vui lòng không chia sẻ liên kết đặt lại mật khẩu cho người khác.
            </div>
        </td>
    </tr>
</table>
</body>
</html>
