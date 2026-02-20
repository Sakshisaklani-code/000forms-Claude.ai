

<?php $__env->startSection('title', $success ? 'Email Verified' : 'Verification Failed'); ?>

<?php $__env->startSection('content'); ?>
<div style="min-height: calc(100vh - 64px); display: flex; align-items: center; justify-content: center; padding: 2rem; background: var(--bg-primary);">
    <div style="max-width: 440px; width: 100%; text-align: center;">
        <div style="font-size: 3.5rem; margin-bottom: 1.5rem;">
            <?php echo e($success ? '✅' : '❌'); ?>

        </div>
        <h1 style="font-size: 1.6rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.75rem; letter-spacing: -0.02em;">
            <?php echo e($success ? 'Email Verified!' : 'Verification Failed'); ?>

        </h1>
        <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin-bottom: 2rem;">
            <?php echo e($message); ?>

        </p>
        <?php if($success): ?>
            <div style="background: rgba(0,255,136,0.08); border: 1px solid rgba(0,255,136,0.2); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                <p style="color: var(--success); font-size: 0.85rem; font-family: var(--font-mono); margin: 0;">
                    <?php echo e($email ?? ''); ?>

                </p>
            </div>
        <?php endif; ?>
        <a href="<?php echo e(route('playground.index')); ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; background: var(--accent); color: var(--bg-primary); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-size: 0.95rem; transition: all 0.2s;">
            ← Back to Playground
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\pages\playground-verify-result.blade.php ENDPATH**/ ?>