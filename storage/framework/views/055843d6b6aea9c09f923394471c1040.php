<?php $__env->startSection('title', 'Email Verification - 000form'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="auth-container text-center">
        <?php if($success): ?>
            <div style="width: 80px; height: 80px; background: rgba(0, 255, 136, 0.15); border-radius: 50%; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            
            <h1 style="font-size: 2rem; margin-bottom: 1rem;">Email Verified!</h1>
            
            <p class="text-muted" style="margin-bottom: 2rem;">
                <?php echo e($message); ?>

            </p>
            
            <?php if(isset($form)): ?>
                <p style="margin-bottom: 2rem;">
                    Your form <strong><?php echo e($form->name); ?></strong> is now active and ready to receive submissions.
                </p>
            <?php endif; ?>
            
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary">
                Go to Dashboard
            </a>
        <?php else: ?>
            <div style="width: 80px; height: 80px; background: rgba(255, 68, 68, 0.15); border-radius: 50%; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--error)" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            
            <h1 style="font-size: 2rem; margin-bottom: 1rem;">Verification Failed</h1>
            
            <p class="text-muted" style="margin-bottom: 2rem;">
                <?php echo e($message); ?>

            </p>
            
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary">
                Go to Dashboard
            </a>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\pages\verification-result.blade.php ENDPATH**/ ?>