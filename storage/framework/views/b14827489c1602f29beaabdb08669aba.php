

<?php $__env->startSection('title', $verified ? 'Endpoint Active' : 'Activate Your Form Endpoint'); ?>

<?php $__env->startSection('content'); ?>
<div style="min-height: calc(100vh - 64px); display: flex; align-items: center; justify-content: center; padding: 2rem; background: var(--bg-primary);">
    <div style="max-width: 520px; width: 100%;">

        <?php if($verified): ?>
            
            <div style="text-align:center; margin-bottom: 2rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
                <h1 style="font-size: 1.6rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.02em; margin-bottom: 0.5rem;">
                    Endpoint Active
                </h1>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">
                    This form endpoint is verified and accepting submissions.
                </p>
            </div>

            <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                <div style="font-size: 0.75rem; font-family: var(--font-mono); color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.75rem;">
                    Your form action URL
                </div>
                <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 6px; padding: 0.875rem 1rem; font-family: var(--font-mono); font-size: 0.85rem; color: var(--accent); word-break: break-all;">
                    <?php echo e(config('app.url')); ?>/f/<?php echo e($email); ?>

                </div>
                <p style="color: var(--text-muted); font-size: 0.8rem; margin-top: 0.75rem; margin-bottom: 0;">
                    Use this as the <code style="color: var(--accent);">action</code> attribute in any HTML form. Submissions will be sent to <strong style="color: var(--text-primary);"><?php echo e($email); ?></strong>.
                </p>
            </div>

            <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                <div style="font-size: 0.75rem; font-family: var(--font-mono); color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.75rem;">
                    Example usage
                </div>
                <pre style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 6px; padding: 1rem; font-family: var(--font-mono); font-size: 0.8rem; color: var(--text-secondary); overflow-x: auto; margin: 0; white-space: pre-wrap;">&lt;form action="<?php echo e(config('app.url')); ?>/f/<?php echo e($email); ?>" method="POST"&gt;
  &lt;input type="text" name="name" placeholder="Name" required&gt;
  &lt;input type="email" name="email" placeholder="Email" required&gt;
  &lt;textarea name="message" required&gt;&lt;/textarea&gt;
  &lt;button type="submit"&gt;Send&lt;/button&gt;
&lt;/form&gt;</pre>
            </div>

        <?php else: ?>
            
            <div style="text-align:center; margin-bottom: 2rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📬</div>
                <h1 style="font-size: 1.6rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.02em; margin-bottom: 0.5rem;">
                    Activate Your Endpoint
                </h1>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">
                    A verification email has been sent to <strong style="color: var(--text-primary);"><?php echo e($email); ?></strong>.
                    Click the link in your inbox to activate this endpoint.
                </p>
            </div>

            <div style="background: rgba(255,170,0,0.08); border: 1px solid rgba(255,170,0,0.2); border-radius: 8px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;">
                <p style="color: var(--warning); font-size: 0.875rem; margin: 0; line-height: 1.6;">
                    ⏱ The verification link expires in <strong>15 minutes</strong>. Once verified, all form submissions to
                    <code style="font-family: var(--font-mono);"><?php echo e(config('app.url')); ?>/f/<?php echo e($email); ?></code>
                    will be delivered to your inbox.
                </p>
            </div>
        <?php endif; ?>

        <div style="text-align:center;">
            <a href="<?php echo e(route('playground.index')); ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">
                ← Back to Playground
            </a>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/pages/form-endpoint-info.blade.php ENDPATH**/ ?>