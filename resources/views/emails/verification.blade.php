{{-- Verification View --}}
{{-- This view handles the display and user interaction for Verification. --}}
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background-color: #FAF8F5; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background-color: #FFFFFF; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .header { background-color: #FFFFFF; padding: 30px; text-align: center; border-bottom: 1px solid #F5E6D3; }
        .logo { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 800; color: #8B1C3A; text-decoration: none; }
        .logo span { color: #D4A574; }
        .content { padding: 40px; text-align: center; }
        .card { background-color: #FFFFFF; border: 2px solid #8B1C3A; border-radius: 20px; padding: 30px; margin-top: 20px; }
        .code { font-size: 48px; font-weight: 800; color: #8B1C3A; letter-spacing: 10px; margin: 20px 0; }
        .expiry { color: #FF4444; font-weight: 700; font-size: 14px; margin-top: 10px; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #888888; background-color: #F9F9F9; }
        .message { color: #1A1A1A; font-size: 16px; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ url('/') }}" class="logo">Mille<span>nium</span></a>
        </div>
        <div class="content">
            <h2 style="color: #8B1C3A;">Verification Code</h2>
            <p class="message">Hello! Use the following code to complete your login or action at Millenium.</p>
            
            <div class="card">
                <div class="code">{{ $code }}</div>
                <p class="expiry">⚠️ This code expires in 10 minutes</p>
            </div>

            <p class="message" style="margin-top: 30px; font-size: 14px; color: #555;">If you did not request this code, please ignore this email or contact support if you have concerns.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Millenium Luxury Hospitality. All rights reserved.<br>
            Damas, Yaoundé, Cameroon
        </div>
    </div>
</body>
</html>
