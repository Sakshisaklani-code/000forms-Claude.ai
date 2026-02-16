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
            padding: 12px 0;
            border-bottom: 1px solid #1a1a1a;
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
            margin: 0;
            font-size: 14px;
            color: #fafafa;
        }
        .attachment-icon {
            display: inline-block;
            margin-right: 8px;
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
        <div class="email-header">
            <div class="brand">
                <span class="highlight">000</span>form
            </div>
            <h1>New submission: <?php echo e($form->name); ?></h1>
        </div>
        
        <div class="email-body">
            <p class="submission-intro">
                Received <?php echo e($submission ? $submission->created_at->format('M j, Y') . ' at ' . $submission->created_at->format('g:i A') : now()->format('M j, Y') . ' at ' . now()->format('g:i A')); ?>

            </p>
            
            <p class="submission-intro">Here's what they had to say:</p>
            
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="field-item">
                    <div class="field-label"><?php echo e(str_replace('_', ' ', $key)); ?></div>
                    <div class="field-value"><?php echo nl2br(e($value)); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($hasAttachment): ?>
                <div class="attachment-info">
                    <p>
                        <span class="attachment-icon">📎</span>
                        <strong>Attachment:</strong> <?php echo e($attachmentName); ?> (<?php echo e($attachmentSize); ?>)
                    </p>
                </div>
            <?php endif; ?>
            
            <?php if($submission): ?>
                <a href="<?php echo e(route('dashboard.submissions.show', [$form->id, $submission->id])); ?>" class="cta-button">
                    View in Dashboard
                </a>
            <?php endif; ?>
            
            <?php if($submission): ?>
                <div class="timestamp metadata">
                    <span style="margin-right: 16px;">
                        <strong>IP:</strong> <?php echo e($submission->ip_address ?? 'N/A'); ?>

                    </span>
                    <?php if($submission->referrer): ?>
                    <span>
                        <strong>From:</strong> <?php echo e(parse_url($submission->referrer, PHP_URL_HOST) ?? $submission->referrer); ?>

                    </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="email-footer">
            <p>Sent via <a href="<?php echo e(config('app.url')); ?>">000form.com</a></p>
            <p style="margin-top: 8px; color: #333333; font-size: 11px;">
                Form: <?php echo e($form->name); ?> (<?php echo e($form->slug); ?>)
            </p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\emails\submission-basic.blade.php ENDPATH**/ ?>