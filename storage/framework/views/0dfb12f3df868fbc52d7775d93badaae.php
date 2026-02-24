<?php $__env->startSection('title', 'Thank You - 000form'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="auth-container text-center">
        <div style="width: 80px; height: 80px; background: rgba(0, 255, 136, 0.15); border-radius: 50%; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        
        <h1 style="font-size: 2rem; margin-bottom: 1rem;"><?php echo e($message); ?></h1>
        
        <p class="text-muted" style="margin-bottom: 2rem;">
            Your submission has been received.
        </p>
        
        <?php if($referer): ?>
            <a href="<?php echo e($referer); ?>" class="btn btn-secondary">
                ← Go Back
            </a>
        <?php endif; ?>
        
        <p class="text-muted" style="margin-top: 3rem; font-size: 0.8rem;">
            Powered by <a href="<?php echo e(route('home')); ?>">000form</a>
        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000form\resources\views/pages/thank-you.blade.php ENDPATH**/ ?>