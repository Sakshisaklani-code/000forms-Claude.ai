<?php $__env->startSection('title', 'Error - 000form'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="auth-container text-center">
        <div style="width: 80px; height: 80px; background: rgba(255, 68, 68, 0.15); border-radius: 50%; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--error)" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        </div>
        
        <h1 style="font-size: 2rem; margin-bottom: 1rem;">Something went wrong</h1>
        
        <p class="text-muted" style="margin-bottom: 2rem;">
            <?php echo e($message); ?>

        </p>
        
        <a href="javascript:history.back()" class="btn btn-secondary">
            ← Go Back
        </a>
        
        <p class="text-muted" style="margin-top: 3rem; font-size: 0.8rem;">
            Powered by <a href="<?php echo e(route('home')); ?>">000form</a>
        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\pages\error.blade.php ENDPATH**/ ?>