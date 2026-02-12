<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Form Submission</title>
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
                            <h1 style="margin: 0 0 8px; font-size: 20px; font-weight: 600; color: #fafafa;">
                                New submission: {{ $form->name }}
                            </h1>
                            <p style="margin: 0 0 24px; color: #888888; font-size: 14px;">
                                Received {{ now()->format('M j, Y \a\t g:i A') }}
                            </p>

                            
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                @foreach($data as $key => $value)
                                    @if(!str_starts_with($key, '_') && !is_array($value))
                                        <tr>
                                            <td style="padding: 12px 0; border-bottom: 1px solid #1a1a1a;">
                                                <div style="font-size: 12px; font-weight: 500; color: #555555; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                                                    {{ ucwords(str_replace('_', ' ', $key)) }}
                                                </div>
                                                <div style="font-size: 15px; color: #fafafa; line-height: 1.5;">
                                                    {!! nl2br(e($value)) !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                @if(isset($data['upload']) && is_array($data['upload']) && isset($attachmentPath))
                                <!-- Uploaded File Display -->
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #1a1a1a;">
                                        <div style="font-size: 12px; font-weight: 500; color: #555555; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                                            Uploaded File
                                        </div>
                                        
                                        @php
                                            $mimeType = $data['upload']['type'] ?? '';
                                            $isImage = str_starts_with($mimeType, 'image/');
                                        @endphp
                                        
                                        @if($isImage && file_exists($attachmentPath))
                                            <!-- Display image inline using Laravel's embed -->
                                            <div style="margin-bottom: 16px;">
                                                <img src="{{ $message->embed($attachmentPath) }}" 
                                                     alt="{{ $data['upload']['name'] }}" 
                                                     style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #1a1a1a; display: block;">
                                            </div>
                                        @else
                                            <!-- For non-images, show file icon -->
                                            <div style="background-color: #1a1a1a; border-radius: 8px; padding: 24px; text-align: center; margin-bottom: 16px;">
                                                <div style="font-size: 48px; margin-bottom: 8px;">📄</div>
                                                <div style="color: #fafafa; font-weight: 500; font-size: 14px;">{{ $data['upload']['name'] }}</div>
                                                <div style="color: #888888; font-size: 12px; margin-top: 4px;">Download attached</div>
                                            </div>
                                        @endif
                                        
                                        <div style="font-size: 13px; color: #888888; line-height: 1.6;">
                                            <div><strong style="color: #aaa;">Filename:</strong> {{ $data['upload']['name'] ?? 'N/A' }}</div>
                                            <div><strong style="color: #aaa;">Size:</strong> {{ isset($data['upload']['size']) ? number_format($data['upload']['size'] / 1024, 2) . ' KB' : 'N/A' }}</div>
                                            <div><strong style="color: #aaa;">Type:</strong> {{ $data['upload']['type'] ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </table>
                            
                            @if($submission)
                                <div style="margin-top: 24px;">
                                    <a href="{{ route('dashboard.submissions.show', [$form->id, $submission->id]) }}" 
                                       style="display: inline-block; padding: 12px 24px; background-color: #00ff88; color: #050505; text-decoration: none; font-weight: 500; border-radius: 6px; font-size: 14px;">
                                        View in Dashboard
                                    </a>
                                </div>
                            @endif

                            <!-- Metadata -->
                            @if($submission)
                            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #1a1a1a;">
                                <div style="font-size: 12px; color: #555555;">
                                    <span style="margin-right: 16px;">
                                        <strong style="color: #888888;">IP:</strong> {{ $submission->ip_address ?? 'N/A' }}
                                    </span>
                                    @if($submission->referrer)
                                    <span>
                                        <strong style="color: #888888;">From:</strong> {{ parse_url($submission->referrer, PHP_URL_HOST) ?? $submission->referrer }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding-top: 24px; text-align: center;">
                            <p style="margin: 0; color: #555555; font-size: 12px;">
                                Sent via <a href="{{ config('app.url') }}" style="color: #00ff88; text-decoration: none;">000form.com</a>
                            </p>
                            <p style="margin: 8px 0 0; color: #333333; font-size: 11px;">
                                Form: {{ $form->name }} ({{ $form->slug }})
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>