

<?php $__env->startSection('title', 'Form Not Active - 000form'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="auth-container text-center">
        <div style="width: 80px; height: 80px; background: rgba(245, 158, 11, 0.12); border-radius: 50%; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>

        <h1 style="font-size: 2rem; margin-bottom: 0.75rem;">Form Not Active</h1>

        <p class="text-muted" style="margin-bottom: 2rem; line-height: 1.6;">
            <?php echo e($message ?? 'The owner of this form has disabled this form and it is no longer accepting submissions.'); ?>

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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/pages/form-not-active.blade.php ENDPATH**/ ?>