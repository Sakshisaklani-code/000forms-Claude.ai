<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Form Submission</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0a0a0a;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #0a0a0a; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width: 600px; width: 100%;">

                    {{-- Logo --}}
                    <tr>
                        <td style="padding-bottom: 28px;">
                            <span style="font-family: 'Courier New', monospace; font-size: 22px; font-weight: 700; color: #fafafa; letter-spacing: -0.02em;">
                                <span style="color: #00ff88;">000</span>form.com
                            </span>
                        </td>
                    </tr>

                    {{-- Main Card --}}
                    <tr>
                        <td style="background-color: #111111; border-radius: 12px; border: 1px solid #1a1a1a; overflow: hidden;">

                            {{-- Card Header --}}
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding: 20px 28px; background-color: #0d0d0d; border-bottom: 1px solid #1a1a1a;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td>
                                                    <span style="font-size: 13px; font-weight: 600; color: #fafafa;">📬 New Form Submission</span>
                                                </td>
                                                <td align="right">
                                                    <span style="display: inline-block; background: rgba(0,255,136,0.1); border: 1px solid rgba(0,255,136,0.2); color: #00ff88; font-size: 11px; font-family: 'Courier New', monospace; padding: 3px 10px; border-radius: 100px;">
                                                        Playground
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- Card Body --}}
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding: 28px;">

                                        {{-- Title & Meta --}}
                                        <h1 style="margin: 0 0 6px; font-size: 20px; font-weight: 700; color: #fafafa; letter-spacing: -0.02em;">
                                            New submission received
                                        </h1>
                                        <p style="margin: 0 0 28px; color: #555555; font-size: 13px; font-family: 'Courier New', monospace;">
                                            {{ $submittedAt }}
                                        </p>

                                        {{-- Fields --}}
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">

                                            {{-- Name --}}
                                            <tr>
                                                <td style="padding: 14px 0; border-bottom: 1px solid #1a1a1a;">
                                                    <div style="font-size: 11px; font-weight: 600; color: #555555; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 5px; font-family: 'Courier New', monospace;">
                                                        Name
                                                    </div>
                                                    <div style="font-size: 15px; color: #fafafa; line-height: 1.5;">
                                                        {{ $formData['name'] }}
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- Email --}}
                                            <tr>
                                                <td style="padding: 14px 0; border-bottom: 1px solid #1a1a1a;">
                                                    <div style="font-size: 11px; font-weight: 600; color: #555555; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 5px; font-family: 'Courier New', monospace;">
                                                        Email
                                                    </div>
                                                    <div style="font-size: 15px; line-height: 1.5;">
                                                        <a href="mailto:{{ $formData['sender_email'] }}" style="color: #00ff88; text-decoration: none;">
                                                            {{ $formData['sender_email'] }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- Message --}}
                                            <tr>
                                                <td style="padding: 14px 0; border-bottom: 1px solid #1a1a1a;">
                                                    <div style="font-size: 11px; font-weight: 600; color: #555555; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 5px; font-family: 'Courier New', monospace;">
                                                        Message
                                                    </div>
                                                    <div style="font-size: 15px; color: #fafafa; line-height: 1.5;">
                                                       {!! nl2br(e($formData['message'])) !!}
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- Extra custom fields --}}
                                            @if (!empty($formData['extra_fields']))
                                                @foreach ($formData['extra_fields'] as $key => $value)
                                                    @if (!str_starts_with($key, '_'))
                                                        <tr>
                                                            <td style="padding: 14px 0; border-bottom: 1px solid #1a1a1a;">
                                                                <div style="font-size: 11px; font-weight: 600; color: #555555; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 5px; font-family: 'Courier New', monospace;">
                                                                    {{ ucwords(str_replace(['_', '-'], ' ', $key)) }}
                                                                </div>
                                                                <div style="font-size: 15px; color: #fafafa; line-height: 1.5;">
                                                                    {!! nl2br(e(is_array($value) ? implode(', ', $value) : $value)) !!}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif

                                            {{-- Source --}}
                                            <tr>
                                                <td style="padding: 14px 0;">
                                                    <div style="font-size: 11px; font-weight: 600; color: #555555; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 5px; font-family: 'Courier New', monospace;">
                                                        Source
                                                    </div>
                                                    <div style="font-size: 13px; color: #888888; line-height: 1.5; font-family: 'Courier New', monospace;">
                                                        {{ $formData['app_url'] ?? config('app.url') }} — Playground
                                                    </div>
                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding-top: 24px; text-align: center;">
                            <p style="margin: 0 0 6px; color: #555555; font-size: 12px; line-height: 1.6;">
                                Sent via <a href="{{ config('app.url') }}" style="color: #00ff88; text-decoration: none;">{{ config('app.name') }}</a> Playground
                                to <strong style="color: #888888;">{{ $formData['recipient_email'] }}</strong>
                            </p>
                            <p style="margin: 0; color: #333333; font-size: 11px;">
                                To stop receiving submissions, simply don't use this email in the playground.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>