<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
            color: #1f2937;
            line-height: 1.6;
        }
        .content h2 {
            color: #1f2937;
            margin-top: 0;
        }
        .content p {
            margin: 15px 0;
            color: #4b5563;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #2563eb;
        }
        .button-wrapper {
            text-align: center;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            border-top: 1px solid #e5e7eb;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            color: #92400e;
        }
        .url-box {
            background-color: #f3f4f6;
            padding: 12px;
            border-radius: 6px;
            word-break: break-all;
            font-size: 13px;
            font-family: monospace;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Reset Password</h1>
        </div>

        <div class="content">
            <h2>Halo {{ $user->name }},</h2>

            <p>Kami menerima permintaan untuk mereset password akun Anda. Jika Anda tidak membuat permintaan ini, abaikan email ini.</p>

            <p>Silakan klik tombol di bawah untuk mereset password Anda:</p>

            <div class="button-wrapper">
                <a href="{{ $resetUrl }}" class="button">Reset Password</a>
            </div>

            <p>Atau salin dan paste URL ini di browser Anda:</p>
            <div class="url-box">{{ $resetUrl }}</div>

            <div class="warning">
                ⚠️ <strong>Link ini berlaku selama 60 menit.</strong> Setelah itu, Anda harus membuat permintaan reset password baru.
            </div>

            <p>Jika Anda memiliki pertanyaan, hubungi kami di <strong>annpundung@sisteminformasikotacerdas.id</strong></p>

            <p>
                Terima kasih,<br>
                <strong>Tim Anpundung</strong>
            </p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Anpundung - Sistem Informasi Kota Cerdas. Semua hak dilindungi.</p>
            <p>Email ini dikirim ke {{ $user->email }} karena ada permintaan reset password untuk akun tersebut.</p>
        </div>
    </div>
</body>
</html>
