<?php $__env->startSection('title', 'Edit ' . $form->name); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <a href="<?php echo e(route('dashboard.forms.show', $form->id)); ?>" class="text-muted" style="font-size: 0.875rem;">
            ← Back to <?php echo e($form->name); ?>

        </a>
        <h1 class="page-title">Form Settings</h1>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; align-items: start;">
    <div class="card">
        <form method="POST" action="<?php echo e(route('dashboard.forms.update', $form->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="form-group">
                <label for="name" class="form-label">Form Name</label>
                <input type="text" id="name" name="name" class="form-input" value="<?php echo e(old('name', $form->name)); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="recipient_email" class="form-label">Recipient Email</label>
                <input type="email" id="recipient_email" name="recipient_email" class="form-input" value="<?php echo e(old('recipient_email', $form->recipient_email)); ?>" required>
                <p class="form-help">Changing this will require re-verification.</p>
            </div>
            
            <div class="form-group">
                <label for="cc_emails" class="form-label">CC Email Addresses (Optional)</label>
                <input 
                    type="text" 
                    id="cc_emails" 
                    name="cc_emails" 
                    class="form-input" 
                    value="<?php echo e(old('cc_emails', is_array($form->cc_emails) ? implode(', ', $form->cc_emails) : $form->cc_emails)); ?>"
                    placeholder="cc1@example.com, cc2@example.com"
                >
                <p class="form-help">Separate multiple email addresses with commas. These addresses will receive a copy of all submissions.</p>
            </div>
            
            <label for="auto_response_enabled" class="form-label">Auto-Response Settings</label>
            
            <div class="form-group">
                <label class="form-checkbox" style="display: flex; align-items: center;">
                    <input type="checkbox" name="auto_response_enabled" value="1" <?php echo e($form->auto_response_enabled ? 'checked' : ''); ?>>
                    <span style="margin-left: 10px; font-weight: 600;">Enable auto-response email</span>
                </label>
                <p class="form-help">Send an automatic thank-you email to users who submit this form. The email will be sent from <?php echo e(config('mail.from.address')); ?></p>
            </div>
            
            <div id="autoResponseFields" style="display: <?php echo e($form->auto_response_enabled ? 'block' : 'none'); ?>;;">
                <div class="form-group">
                    <label for="auto_response_message" class="form-label">Auto-Response Message</label>
                    <textarea 
                        id="auto_response_message" 
                        name="auto_response_message" 
                        class="form-input" 
                        rows="6" 
                        placeholder="Write your thank you message here..."
                    ><?php echo e(old('auto_response_message', $form->auto_response_message ?? "Dear {visitor_name},\n\nThank you for contacting us! We have received your submission and will get back to you shortly.\n\nBest regards,\nThe {site_name} Team")); ?></textarea>
                    <p class="form-help">
                </div>
            </div>
            
            <div class="form-group">
                <label for="redirect_url" class="form-label">Redirect URL</label>
                <input type="url" id="redirect_url" name="redirect_url" class="form-input" value="<?php echo e(old('redirect_url', $form->redirect_url)); ?>" placeholder="https://yoursite.com/thank-you">
            </div>
            
            <div class="form-group">
                <label for="success_message" class="form-label">Success Message</label>
                <input type="text" id="success_message" name="success_message" class="form-input" value="<?php echo e(old('success_message', $form->success_message)); ?>">
            </div>
            
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-input">
                    <option value="active" <?php echo e($form->status === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="paused" <?php echo e($form->status === 'paused' ? 'selected' : ''); ?>>Paused</option>
                </select>
            </div>
            
            <hr style="border: none; border-top: 1px solid var(--border-color); margin: 2rem 0;">
            
            <h4 style="margin-bottom: 1rem;">Options</h4>
            
            <div class="form-group">
                <label class="form-checkbox">
                    <input type="checkbox" name="honeypot_enabled" value="1" <?php echo e($form->honeypot_enabled ? 'checked' : ''); ?>>
                    <span>Enable honeypot spam protection</span>
                </label>
            </div>
            
            <div class="form-group">
                <label class="form-checkbox">
                    <input type="checkbox" name="email_notifications" value="1" <?php echo e($form->email_notifications ? 'checked' : ''); ?>>
                    <span>Send email notifications</span>
                </label>
            </div>
            
            <div class="form-group">
                <label class="form-checkbox">
                    <input type="checkbox" name="store_submissions" value="1" <?php echo e($form->store_submissions ? 'checked' : ''); ?>>
                    <span>Store submissions in dashboard</span>
                </label>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo e(route('dashboard.forms.show', $form->id)); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    
    <div class="card" style="border-color: rgba(255,68,68,0.3);">
        <h4 style="color: var(--error); margin-bottom: 1rem;">Danger Zone</h4>
        <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 1rem;">
            Deleting this form will permanently remove all submissions. This cannot be undone.
        </p>
        <form id="delete-form-<?php echo e($form->id); ?>" method="POST" action="<?php echo e(route('dashboard.forms.destroy', $form->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
        </form>
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteForm('<?php echo e($form->id); ?>', '<?php echo e($form->name); ?>')">
            Delete Form
        </button>
    </div>
</div>

<script>
function deleteForm(formId, formName) {
    if (confirm(`Are you sure you want to delete "${formName}"? This action cannot be undone.`)) {
        document.getElementById(`delete-form-${formId}`).submit();
    }
}

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
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\dashboard\forms\edit.blade.php ENDPATH**/ ?>