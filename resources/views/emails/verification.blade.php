<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0a0a0a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #0a0a0a; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width: 600px;">
                    <!-- Header -->
                    <tr>
                        <td style="padding-bottom: 30px; text-align: center;">
                            <span style="font-family: 'Courier New', monospace; font-size: 28px; font-weight: bold; color: #fafafa;">
                                <span style="color: #00ff88;">000</span>form
                            </span>
                        </td>
                    </tr>
                    
                    <!-- Main Content -->
                    <tr>
                        <td style="background-color: #111111; border-radius: 12px; padding: 40px; border: 1px solid #1a1a1a; text-align: center;">
                            <div style="width: 64px; height: 64px; background-color: rgba(0, 255, 136, 0.15); border-radius: 50%; margin: 0 auto 24px; display: flex; align-items: center; justify-content: center;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#00ff88" stroke-width="2" style="display: block;">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            
                            <h1 style="margin: 0 0 12px; font-size: 24px; font-weight: 600; color: #fafafa;">
                                Verify your email
                            </h1>
                            
                            <p style="margin: 0 0 8px; color: #888888; font-size: 15px; line-height: 1.6;">
                                Click the button below to verify this email address for your form:
                            </p>
                            
                            <p style="margin: 0 0 32px; color: #fafafa; font-size: 16px; font-weight: 500;">
                                {{ $form->name }}
                            </p>
                            
                            <a href="{{ $verificationUrl }}" 
                               style="display: inline-block; padding: 14px 32px; background-color: #00ff88; color: #050505; text-decoration: none; font-weight: 600; border-radius: 8px; font-size: 15px;">
                                Verify Email Address
                            </a>
                            
                            <p style="margin: 32px 0 0; color: #555555; font-size: 13px; line-height: 1.6;">
                                If you didn't create this form, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding-top: 24px; text-align: center;">
                            <p style="margin: 0; color: #555555; font-size: 12px;">
                                Sent by <a href="{{ config('app.url') }}" style="color: #00ff88; text-decoration: none;">000form.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
