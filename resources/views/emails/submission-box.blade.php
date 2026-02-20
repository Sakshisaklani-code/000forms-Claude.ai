<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #fafafa;
            background-color: #0a0a0a;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #111111;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            border: 1px solid #1a1a1a;
        }
        .email-header {
            background-color: #0a0a0a;
            color: #fafafa;
            padding: 24px;
            border-bottom: 1px solid #1a1a1a;
        }
        .email-header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        .email-header .brand {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .email-header .brand .highlight {
            color: #00ff88;
        }
        .email-body {
            padding: 32px 24px;
            background-color: #111111;
        }
        .email-body p {
            margin: 0 0 16px 0;
            color: #888888;
        }
        .submission-intro {
            margin-bottom: 24px;
            font-size: 14px;
            color: #888888;
        }
        .field-item {
            padding: 12px 10px;
            border: 1px solid #494949;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .field-item:last-child {
            border-bottom: none;
        }
        .field-label {
            font-weight: 500;
            color: #a7a6a6;
            margin-bottom: 4px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .field-value {
            color: #fafafa;
            font-size: 15px;
            line-height: 1.5;
            word-wrap: break-word;
        }
        .attachment-info {
            background-color: #1a1a1a;
            border-left: 4px solid #00ff88;
            padding: 16px;
            margin: 24px 0;
            border-radius: 4px;
        }
        .attachment-info p {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: #fafafa;
        }
        .attachment-info p:last-child {
            margin-bottom: 0;
        }
        .attachment-icon {
            display: inline-block;
            margin-right: 8px;
        }
        .attachment-list {
            margin-top: 12px;
            padding-left: 0;
            list-style: none;
        }
        .attachment-list li {
            padding: 8px 0;
            color: #fafafa;
            font-size: 13px;
            border-bottom: 1px solid #222222;
        }
        .attachment-list li:last-child {
            border-bottom: none;
        }
        .attachment-list .file-name {
            color: #00ff88;
            font-weight: 500;
        }
        .attachment-list .file-meta {
            color: #888888;
            font-size: 12px;
            margin-left: 8px;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #00ff88;
            color: #000000!important;
            text-decoration: none;
            font-weight: 700;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 24px;
        }
        .email-footer {
            background-color: #0a0a0a;
            padding: 20px 24px;
            text-align: center;
            font-size: 12px;
            color: #555555;
            border-top: 1px solid #1a1a1a;
        }
        .email-footer a {
            color: #00ff88;
            text-decoration: none;
        }
        .timestamp {
            color: #888888;
            font-size: 13px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #1a1a1a;
        }
        .metadata {
            font-size: 12px;
            color: #555555;
        }
        .metadata strong {
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="email-container">

        {{-- HEADER --}}
        <div class="email-header">
            <div class="brand">
                <span class="highlight">000</span>form
            </div>
            {{-- FIX: was {{ form->name }}, missing @ --}}
            <h1>New submission: {{ $form->name }}</h1>
        </div>

        <div class="email-body">
            <p class="submission-intro">
                Received {{ $submittedAt ?? '' }}
            </p>

            <p class="submission-intro">Here's what they had to say:</p>

            {{-- FIX: was bare foreach with no @, and $value was used but never defined --}}
            @foreach($data as $key => $value)
                @if(!empty($value))
                    <div class="field-item">
                        <div class="field-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</div>
                        <div class="field-value">{!! nl2br(e($value)) !!}</div>
                    </div>
                @endif
            @endforeach

            {{-- ATTACHMENTS SECTION --}}
            {{--
                $attachments      = email attachment objects (used by mailer to attach files)
                $attachments (blade) comes from $formData['attachments_metadata'] passed as $attachments to view
                We use $attachments array which contains: name, size, type, path
            --}}
            @php
                // Resolve correct attachment list — blade receives 'attachments' from viewData
                // which maps to attachments_metadata (has name/size/type/path keys)
                $attachmentList = $attachments ?? [];
            @endphp

            @if($hasAttachment && !empty($attachmentList))
                <div class="attachment-info">
                    <p>
                        <span class="attachment-icon">📎</span>
                        <strong>{{ $attachmentCount }} Attachment{{ $attachmentCount > 1 ? 's' : '' }}:</strong>
                    </p>
                    <ul class="attachment-list">
                        @foreach($attachmentList as $attachment)
                            @php
                                $fileName  = $attachment['name'] ?? 'file';
                                $fileSize  = isset($attachment['size']) ? number_format($attachment['size'] / 1024, 1) . ' KB' : '';
                                $mimeType  = $attachment['type'] ?? '';
                                $isImage   = str_starts_with($mimeType, 'image/');
                                // Build public URL from stored path so image renders in email
                                $fileUrl   = isset($attachment['path'])
                                    ? rtrim(config('app.url'), '/') . '/storage/' . ltrim($attachment['path'], '/')
                                    : null;
                            @endphp
                            <li>
                                {{-- Show inline image preview for image attachments --}}
                                <span class="file-name">{{ $fileName }}</span>
                                @if($fileSize)
                                    <span class="file-meta">({{ $fileSize }})</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Dashboard button only shown when a real submission object exists --}}
            @if($submission)
                <a href="{{ $appUrl }}" class="cta-button">
                    View in Dashboard
                </a>
            @endif

            {{-- FIX: was wrapped in orphaned @endif with no opening @if --}}
            @if($submission)
                <div class="timestamp metadata">
                    <span style="margin-right: 16px;">
                        <strong>IP:</strong> {{ $submission->ip_address ?? 'N/A' }}
                    </span>
                    @if(!empty($submission->referrer))
                        <span>
                            <strong>From:</strong> {{ parse_url($submission->referrer, PHP_URL_HOST) ?? $submission->referrer }}
                        </span>
                    @endif
                </div>
            @endif

        </div>

        <div class="email-footer">
            <p>Sent via <a href="{{ $appUrl ?? '#' }}">000form.com</a></p>
            <p style="margin-top: 8px; color: #333333; font-size: 11px;">
                Form: {{ $form->name ?? '' }}
            </p>
        </div>

    </div>
</body>
</html>