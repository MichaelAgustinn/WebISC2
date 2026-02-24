<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #050914;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #050914; padding: 40px 20px;">
        <tr>
            <td align="center">

                <table width="100%" cellpadding="0" cellspacing="0"
                    style="max-width: 600px; background-color: #0f204b; border-radius: 12px; border: 1px solid rgba(212, 175, 55, 0.2); overflow: hidden;">

                    <tr>
                        <td align="center" style="padding: 40px 20px 20px;">
                            <h2 style="color: #d4af37; margin: 0; font-size: 24px; letter-spacing: 2px;">RESET PASSWORD
                            </h2>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding: 20px 40px; color: #94a3b8; font-size: 16px; line-height: 1.6; text-align: center;">
                            <p style="margin: 0 0 20px;">
                                Halo <strong style="color: #ffffff;">{{ $user->name }}</strong>,
                            </p>
                            <p style="margin: 0 0 30px;">
                                Kami menerima permintaan untuk mengatur ulang password akun Anda di <strong>Informatics
                                    Study Club</strong>. Silakan klik tombol di bawah ini untuk membuat password baru.
                            </p>

                            <a href="{{ $url }}" target="_blank"
                                style="display: inline-block; background-color: #d4af37; color: #0f204b; font-weight: bold; font-size: 16px; text-decoration: none; padding: 14px 30px; border-radius: 6px; text-transform: uppercase; letter-spacing: 1px;">
                                Buat Password Baru
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding: 10px 40px 30px; color: #94a3b8; font-size: 14px; line-height: 1.6; text-align: center;">
                            <p style="margin: 0;">
                                Tautan ini hanya berlaku selama <strong>60 menit</strong>.<br>
                                Jika Anda tidak pernah meminta pengaturan ulang password, abaikan saja email ini. Akun
                                Anda tetap aman.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding: 20px 40px; background-color: rgba(0, 0, 0, 0.2); border-top: 1px solid rgba(255, 255, 255, 0.05); color: #64748b; font-size: 12px; line-height: 1.5;">
                            Jika Anda kesulitan mengklik tombol di atas, *copy* dan *paste* URL di bawah ini ke browser
                            Anda:
                            <br><br>
                            <a href="{{ $url }}"
                                style="color: #d4af37; word-break: break-all;">{{ $url }}</a>
                        </td>
                    </tr>
                </table>

                <p style="color: #64748b; font-size: 12px; margin-top: 20px; text-align: center;">
                    &copy; {{ date('Y') }} Informatics Study Club. All rights reserved.
                </p>

            </td>
        </tr>
    </table>

</body>

</html>
