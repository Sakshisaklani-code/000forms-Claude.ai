<?php $__env->startSection('title', 'Create Form'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Create New Form</h1>
</div>

<div class="card" style="max-width: 600px;">
    <?php if($errors->any()): ?>
        <div class="alert alert-error mb-3">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo e(route('dashboard.forms.store')); ?>">
        <?php echo csrf_field(); ?>
        
        <div class="form-group">
            <label for="name" class="form-label">Form Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="form-input" 
                value="<?php echo e(old('name')); ?>"
                placeholder="e.g., Contact Form, Newsletter Signup"
                required
            >
            <p class="form-help">A friendly name to identify this form in your dashboard.</p>
        </div>
        
        <div class="form-group">
            <label for="recipient_email" class="form-label">Recipient Email</label>
            <input 
                type="email" 
                id="recipient_email" 
                name="recipient_email" 
                class="form-input" 
                value="<?php echo e(old('recipient_email', auth()->user()->email)); ?>"
                placeholder="you@example.com"
                required
            >
            <p class="form-help">Form submissions will be sent to this email address. You'll need to verify it.</p>
        </div>
        
        <div class="form-group">
            <label for="cc_emails" class="form-label">CC Email Addresses (Optional)</label>
            <input 
                type="text" 
                id="cc_emails" 
                name="cc_emails" 
                class="form-input" 
                value="<?php echo e(old('cc_emails')); ?>"
                placeholder="cc@example.com"
            >
            <p class="form-help">Separate multiple email addresses with commas. These addresses will receive a copy of all submissions.</p>
        </div>
        
        <label for="auto_response_enabled" class="form-label">Auto-Response Settings</label>
        
        <div class="form-group">
            <label class="form-checkbox" style="display: flex; align-items: center;">
                <input type="checkbox" name="auto_response_enabled" value="1" <?php echo e(old('auto_response_enabled') ? 'checked' : ''); ?>>
                <span style="font-weight: 300;">Enable auto-response email</span>
            </label>
            <p class="form-help">Send an automatic thank-you email to users who submit this form. The email will be sent from <?php echo e(config('mail.from.address')); ?></p>
        </div>
        
        <div id="autoResponseFields" style="display: <?php echo e(old('auto_response_enabled') ? 'block' : 'none'); ?>;">
            <div class="form-group">
                <label for="auto_response_message" class="form-label">Auto-Response Message</label>
                <textarea 
                    id="auto_response_message" 
                    name="auto_response_message" 
                    class="form-input" 
                    rows="6" 
                    placeholder="Write your thank you message here..."
                ><?php echo e(old('auto_response_message', "Dear {visitor_name},\n\nThank you for contacting us! We have received your submission and will get back to you shortly.\n\nBest regards,\nThe {site_name} Team")); ?></textarea>
            </div>
        </div>
        
        
        <div class="form-group">
            <label for="redirect_url" class="form-label">Redirect URL (optional)</label>
            <input 
                type="url" 
                id="redirect_url" 
                name="redirect_url" 
                class="form-input" 
                value="<?php echo e(old('redirect_url')); ?>"
                placeholder="https://yoursite.com/thank-you"
            >
            <p class="form-help">Where to redirect users after submission. Leave empty to show our default thank-you page.</p>
        </div>
        
        <div class="form-group">
            <label for="success_message" class="form-label">Success Message (optional)</label>
            <input 
                type="text" 
                id="success_message" 
                name="success_message" 
                class="form-input" 
                value="<?php echo e(old('success_message', 'Thank you for your submission!')); ?>"
                placeholder="Thank you for your submission!"
            >
            <p class="form-help">Shown on our thank-you page or returned in JSON response.</p>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">
                Create Form
            </button>
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const autoResponseCheckbox = document.querySelector('input[name="auto_response_enabled"]');
    const autoResponseFields = document.getElementById('autoResponseFields');
    
    function toggleAutoResponseFields() {
        autoResponseFields.style.display = autoResponseCheckbox.checked ? 'block' : 'none';
    }
    
    autoResponseCheckbox.addEventListener('change', toggleAutoResponseFields);
    toggleAutoResponseFields();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\dashboard\forms\create.blade.php ENDPATH**/ ?>