<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px; background-color: #f8f9fa;">
    <div style="background-color: white; padding: 30px; border-radius: 10px; text-align: center;">
        <h2 style="color: #333;">Verifikasi Akun Tiket Bus</h2>
        <p>Halo,</p>
        <p>Terima kasih telah mendaftar. Berikut adalah kode OTP Anda:</p>
        
        <h1 style="background-color: #e0e7ff; color: #4338ca; padding: 15px; border-radius: 8px; display: inline-block; letter-spacing: 5px;">
            {{ $otp }}
        </h1>

        <p style="margin-top: 20px; color: #666;">Kode ini berlaku selama 5 menit.</p>
        <p style="color: #666;">Jangan berikan kode ini kepada siapapun.</p>
    </div>
</body>
</html>