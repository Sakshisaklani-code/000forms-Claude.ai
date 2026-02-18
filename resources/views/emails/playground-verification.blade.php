<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #050505;
            color: #fafafa;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            max-width: 560px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .card {
            background: #0d0d0d;
            border: 1px solid #1a1a1a;
            border-radius: 12px;
            padding: 40px;
        }
        .logo {
            font-family: monospace;
            font-size: 1.4rem;
            font-weight: 700;
            color: #fafafa;
            margin-bottom: 32px;
        }
        .logo span { color: #00ff88; }
        h1 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0 0 12px;
            letter-spacing: -0.02em;
        }
        p {
            color: #888;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0 0 24px;
        }
        .btn {
            display: inline-block;
            background: #00ff88;
            color: #050505;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 28px;
        }
        .url-box {
            background: #111;
            border: 1px solid #1a1a1a;
            border-radius: 6px;
            padding: 12px;
            font-family: monospace;
            font-size: 0.78rem;
            color: #555;
            word-break: break-all;
            margin-bottom: 28px;
        }
        .footer {
            border-top: 1px solid #1a1a1a;
            padding-top: 20px;
            color: #444;
            font-size: 0.8rem;
        }
        .expiry {
            background: rgba(255,170,0,0.08);
            border: 1px solid rgba(255,170,0,0.15);
            border-radius: 6px;
            padding: 10px 14px;
            color: #ffaa00;
            font-size: 0.82rem;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="logo">000<span>form</span>.com</div>
        <h1>Verify your email address</h1>
        <p>
            Someone (hopefully you!) entered <strong style="color:#fafafa;">{{ $recipientEmail }}</strong>
            as a form submission recipient on the <strong style="color:#fafafa;">{{ $appName }} Playground</strong>.
            Click the button below to confirm you own this address.
        </p>
        <div class="expiry">⏱ This link expires in 15 minutes.</div>
        <a href="{{ $verifyUrl }}" class="btn">Verify My Email</a>
        <p style="font-size:0.82rem; color:#555;">
            Or copy and paste this URL into your browser:
        </p>
        <div class="url-box">{{ $verifyUrl }}</div>
        <div class="footer">
            If you didn't request this, you can safely ignore this email.
            No account has been created and no further emails will be sent.
        </div>
    </div>
</div>
</body>
</html>