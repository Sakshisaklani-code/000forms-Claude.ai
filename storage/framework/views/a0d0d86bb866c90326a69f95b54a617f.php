

<?php $__env->startSection('title', 'Message Sent!'); ?>

<?php $__env->startSection('content'); ?>
<div style="min-height: calc(100vh - 64px); display: flex; align-items: center; justify-content: center; padding: 2rem; background: var(--bg-primary);">
    <div style="max-width: 420px; width: 100%; text-align: center;">
        <div style="font-size: 3.5rem; margin-bottom: 1.5rem;">✅</div>
        <h1 style="font-size: 1.6rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.02em; margin-bottom: 0.75rem;">
            Message Sent!
        </h1>
        <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin-bottom: 2rem;">
            Your form submission was received successfully. The owner of this form will be in touch soon.
        </p>
        <button onclick="history.back()" style="display: inline-flex; align-items: center; gap: 0.5rem; background: var(--accent); color: var(--bg-primary); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; font-size: 0.95rem; cursor: pointer; transition: all 0.2s; font-family: var(--font-display);">
            ← Go Back
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\pages\form-submitted.blade.php ENDPATH**/ ?>