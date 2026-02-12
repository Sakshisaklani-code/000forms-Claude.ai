<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for contacting us</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0a0a0a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #0a0a0a; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width: 600px;">
                    <!-- Header -->
                    <tr>
                        <td style="padding-bottom: 30px;">
                            <span style="font-family: 'Courier New', monospace; font-size: 24px; font-weight: bold; color: #fafafa;">
                                <span style="color: #00ff88;">000</span>form
                            </span>
                        </td>
                    </tr>
                    
                    <!-- Main Content -->
                    <tr>
                        <td style="background-color: #111111; border-radius: 12px; padding: 32px; border: 1px solid #1a1a1a;">
                            <h1 style="margin: 0 0 24px; font-size: 20px; font-weight: 600; color: #fafafa;">
                                Thank you for your submission
                            </h1>
                            
                            <div style="color: #d0d0d0; line-height: 1.8; font-size: 15px; white-space: pre-wrap;">{{ $messageContent }}</div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding-top: 24px; text-align: center;">
                            <p style="margin: 0; color: #555555; font-size: 12px;">
                                This is an automated response from <a href="{{ config('app.url') }}" style="color: #00ff88; text-decoration: none;">{{ $form->name }}</a>
                            </p>
                            <p style="margin: 8px 0 0; color: #333333; font-size: 11px;">
                                Powered by <a href="https://000form.com" style="color: #00ff88; text-decoration: none;">000form.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>