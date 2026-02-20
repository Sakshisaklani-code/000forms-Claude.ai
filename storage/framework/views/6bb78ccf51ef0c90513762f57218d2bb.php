<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #f8f9fa;
            color: #333333;
            padding: 24px;
            border-bottom: 2px solid #00ff88;
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
            background-color: #ffffff;
        }
        .submission-intro {
            margin-bottom: 24px;
            font-size: 14px;
            color: #666666;
        }
        
        /* Box styles for fields */
        .fields-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 24px 0;
        }
        .field-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 16px;
            border-left: 4px solid #00ff88;
        }
        .field-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .field-value {
            color: #212529;
            font-size: 15px;
            line-height: 1.5;
            word-wrap: break-word;
            background-color: #ffffff;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        
        /* Attachment box */
        .attachment-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 24px 0;
            border-left: 4px solid #00ff88;
        }
        .attachment-box p {
            margin: 0 0 12px 0;
            font-weight: 600;
            color: #495057;
        }
        .attachment-list {
            margin: 0;
            padding-left: 0;
            list-style: none;
        }
        .attachment-list li {
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .attachment-list li:last-child {
            border-bottom: none;
        }
        .attachment-list .file-name {
            color: #00ff88;
            font-weight: 500;
        }
        .attachment-list .file-meta {
            color: #666666;
            font-size: 12px;
            margin-left: auto;
        }
        
        /* Info box */
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 16px;
            margin-top: 24px;
            font-size: 13px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        .info-value {
            color: #666666;
        }
        
        .cta-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #00ff88;
            color: #000000;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 24px;
            border: none;
        }
        .cta-button:hover {
            background-color: #00cc6a;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px 24px;
            text-align: center;
            font-size: 12px;
            color: #666666;
            border-top: 1px solid #e9ecef;
        }
        .email-footer a {
            color: #00ff88;
            text-decoration: none;
        }
        .timestamp {
            color: #666666;
            font-size: 13px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
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
            
            <!-- Fields in boxes -->
            <div class="fields-container">
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="field-box">
                        <div class="field-label"><?php echo e(str_replace('_', ' ', $key)); ?></div>
                        <div class="field-value"><?php echo nl2br(e($value)); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <?php if($hasAttachment && $attachmentCount > 0): ?>
                <!-- Attachment box -->
                <div class="attachment-box">
                    <p>📎 <?php echo e($attachmentCount); ?> Attachment<?php echo e($attachmentCount > 1 ? 's' : ''); ?></p>
                    <ul class="attachment-list">
                        <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span class="file-name"><?php echo e($attachment['name']); ?></span>
                                <span class="file-meta"><?php echo e($attachment['size']); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if($submission): ?>
                <div style="text-align: center;">
                    <a href="<?php echo e(route('dashboard.submissions.show', [$form->id, $submission->id])); ?>" class="cta-button">
                        View in Dashboard
                    </a>
                </div>
            <?php endif; ?>
            
            <!-- Info box for metadata -->
            <?php if($submission): ?>
                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">IP Address:</span>
                        <span class="info-value"><?php echo e($submission->ip_address ?? 'N/A'); ?></span>
                    </div>
                    <?php if($submission->referrer): ?>
                    <div class="info-row">
                        <span class="info-label">From:</span>
                        <span class="info-value"><?php echo e(parse_url($submission->referrer, PHP_URL_HOST) ?? $submission->referrer); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="email-footer">
            <p>Sent via <a href="<?php echo e(config('app.url')); ?>">000form.com</a></p>
            <p style="margin-top: 8px; color: #999999; font-size: 11px;">
                Form: <?php echo e($form->name); ?> (<?php echo e($form->slug); ?>)
            </p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\emails\submission-box.blade.php ENDPATH**/ ?>