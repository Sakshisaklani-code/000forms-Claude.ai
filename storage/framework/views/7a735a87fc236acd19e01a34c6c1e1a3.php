<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for your submission</title>
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
                                Thank you for your submission
                            </h1>
                            <p style="margin: 0 0 24px; color: #888888; font-size: 14px;">
                                <?php echo e($form->name); ?>

                            </p>
                            
                            <div style="padding: 20px; background-color: #0a0a0a; border-radius: 8px; border: 1px solid #1a1a1a;">
                                <p style="margin: 0; font-size: 15px; color: #fafafa; line-height: 1.6;">
                                    <?php echo e($form->auto_reply_message); ?>

                                </p>
                            </div>
                            
                            <?php if(!empty($submissionData)): ?>
                                <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #1a1a1a;">
                                    <p style="margin: 0 0 16px; font-size: 12px; font-weight: 500; color: #555555; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Your Submission
                                    </p>
                                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                        <?php $__currentLoopData = $submissionData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(!str_starts_with($key, '_') && $key !== 'email'): ?>
                                                <tr>
                                                    <td style="padding: 8px 0;">
                                                        <div style="font-size: 12px; color: #666666; margin-bottom: 2px;">
                                                            <?php echo e(ucwords(str_replace('_', ' ', $key))); ?>

                                                        </div>
                                                        <div style="font-size: 14px; color: #cccccc;">
                                                            <?php echo nl2br(e($value)); ?>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding-top: 24px; text-align: center;">
                            <p style="margin: 0; color: #555555; font-size: 12px;">
                                This is an automated message from <a href="<?php echo e(config('app.url')); ?>" style="color: #00ff88; text-decoration: none;">000form.com</a>
                            </p>
                            <?php if($form->recipient_email): ?>
                                <p style="margin: 8px 0 0; color: #333333; font-size: 11px;">
                                    Questions? Contact us at <?php echo e($form->recipient_email); ?>

                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\emails\auto-reply.blade.php ENDPATH**/ ?>