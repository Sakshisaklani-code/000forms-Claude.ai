<?php $__env->startSection('title', 'Submission Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <a href="<?php echo e(route('dashboard.forms.show', $form->id)); ?>" class="text-muted" style="font-size: 0.875rem;">
            ← Back to <?php echo e($form->name); ?>

        </a>
        <h1 class="page-title">Submission Details</h1>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <?php if($submission->reply_to): ?>
            <a href="mailto:<?php echo e($submission->reply_to); ?>" class="btn btn-primary btn-sm">
                Reply via Email
            </a>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(route('dashboard.submissions.spam', [$form->id, $submission->id])); ?>" style="margin: 0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-secondary btn-sm">Mark as Spam</button>
        </form>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; align-items: start;">
    <!-- Submission Data -->
    <div class="card">
        <h4 style="margin-bottom: 1.5rem;">Form Data</h4>
        
        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            <?php $__currentLoopData = $submission->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!str_starts_with($key, '_')): ?>
                    <div>
                        <div class="form-label" style="margin-bottom: 0.25rem;"><?php echo e(ucwords(str_replace('_', ' ', $key))); ?></div>
                        <div style="padding: 0.75rem 1rem; background: var(--bg-tertiary); border-radius: 6px; word-break: break-word;">
                            
                            <?php if(is_array($value)): ?>
                                
                                <?php if($key === 'uploads' && isset($value[0]) && is_array($value[0]) && isset($value[0]['name'])): ?>
                                    
                                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fileData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $extension = strtolower($fileData['extension'] ?? pathinfo($fileData['name'], PATHINFO_EXTENSION));
                                                $isImage = strpos($fileData['type'] ?? '', 'image/') === 0;
                                                $absolutePath = $fileData['absolute_path'] ?? null;
                                                $fileExists = $absolutePath && file_exists($absolutePath);
                                            ?>
                                            
                                            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: var(--bg-secondary); border-radius: 4px; border: 1px solid var(--border-color);">
                                                
                                                <span style="font-size: 1.5rem;">
                                                    <?php if($isImage): ?>
                                                        <i class="bi bi-card-image"></i>
                                                    <?php elseif(in_array($extension, ['pdf'])): ?>
                                                        <i class="bi bi-file-pdf"></i>
                                                    <?php elseif(in_array($extension, ['doc', 'docx'])): ?>
                                                        <i class="bi bi-file-earmark-word"></i>
                                                    <?php elseif(in_array($extension, ['xls', 'xlsx', 'csv'])): ?>
                                                        <i class="bi bi-file-earmark-spreadsheet"></i>
                                                    <?php else: ?>
                                                        <i class="bi bi-paperclip"></i>
                                                    <?php endif; ?>
                                                </span>
                                                
                                                <div style="flex: 1;">
                                                    <div style="font-weight: 500; color: var(--text);">
                                                        <?php echo e($fileData['name']); ?>

                                                    </div>
                                                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.15rem;">
                                                        <?php echo e(round($fileData['size'] / 1024, 2)); ?> KB
                                                        <?php if(isset($fileData['type'])): ?>
                                                            • <?php echo e($fileData['type']); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if(!$fileExists): ?>
                                                        <div style="font-size: 0.75rem; color: var(--error); margin-top: 0.25rem;">
                                                            File not found on server
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                
                                                <form method="POST" action="<?php echo e(route('dashboard.submissions.download', [$form->id, $submission->id])); ?>" style="margin: 0;">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="file_index" value="<?php echo e($index); ?>">
                                                    <button type="submit" 
                                                            style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.75rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 4px; color: var(--text); text-decoration: none; font-size: 0.8rem; cursor: pointer;"
                                                            <?php if(!$fileExists): ?> disabled <?php endif; ?>>
                                                        <span><i class="bi bi-download"></i></span>
                                                        Download
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    
                                
                                <?php elseif(isset($value['name']) && isset($value['size']) && isset($value['path'])): ?>
                                    <?php
                                        $extension = strtolower($value['extension'] ?? pathinfo($value['name'], PATHINFO_EXTENSION));
                                        $isImage = strpos($value['type'] ?? '', 'image/') === 0;
                                        $absolutePath = $value['absolute_path'] ?? null;
                                        $fileExists = $absolutePath && file_exists($absolutePath);
                                    ?>
                                    
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        
                                        <span style="font-size: 1.5rem;">
                                            <?php if($isImage): ?>
                                                <i class="bi bi-card-image"></i>
                                            <?php elseif(in_array($extension, ['pdf'])): ?>
                                                <i class="bi bi-file-pdf"></i>
                                            <?php elseif(in_array($extension, ['doc', 'docx'])): ?>
                                                <i class="bi bi-file-earmark-word"></i>
                                            <?php elseif(in_array($extension, ['xls', 'xlsx', 'csv'])): ?>
                                                <i class="bi bi-file-earmark-spreadsheet"></i>
                                            <?php else: ?>
                                                <i class="bi bi-paperclip"></i>
                                            <?php endif; ?>
                                        </span>
                                        
                                        <div style="flex: 1;">
                                            <div style="font-weight: 500; color: var(--text);">
                                                <?php echo e($value['name']); ?>

                                            </div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.15rem;">
                                                <?php echo e(round($value['size'] / 1024, 2)); ?> KB
                                                <?php if(isset($value['type'])): ?>
                                                    • <?php echo e($value['type']); ?>

                                                <?php endif; ?>
                                            </div>
                                            <?php if(!$fileExists): ?>
                                                <div style="font-size: 0.75rem; color: var(--error); margin-top: 0.25rem;">
                                                    File not found on server
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        
                                        <form method="POST" action="<?php echo e(route('dashboard.submissions.download', [$form->id, $submission->id])); ?>" style="margin: 0;">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="field_name" value="<?php echo e($key); ?>">
                                            <button type="submit" 
                                                    style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.75rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 4px; color: var(--text); text-decoration: none; font-size: 0.8rem; cursor: pointer;"
                                                    <?php if(!$fileExists): ?> disabled <?php endif; ?>>
                                                <span><i class="bi bi-download"></i></span>
                                                Download
                                            </button>
                                        </form>
                                    </div>
                                    
                                <?php else: ?>
                                    
                                    <pre style="margin: 0; font-family: monospace; font-size: 0.85rem;"><?php echo e(json_encode($value, JSON_PRETTY_PRINT)); ?></pre>
                                <?php endif; ?>
                                
                            <?php elseif(filter_var($value, FILTER_VALIDATE_EMAIL)): ?>
                                <a href="mailto:<?php echo e($value); ?>"><?php echo e($value); ?></a>
                                
                            <?php elseif(filter_var($value, FILTER_VALIDATE_URL)): ?>
                                <a href="<?php echo e($value); ?>" target="_blank" rel="noopener noreferrer"><?php echo e($value); ?></a>
                                
                            <?php else: ?>
                                
                                <?php echo nl2br(e($value)); ?>

                            <?php endif; ?>
                            
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    
    <!-- Metadata -->
    <div>
        <div class="card mb-3">
            <h4 style="margin-bottom: 1rem;">Details</h4>
            
            <div style="font-size: 0.875rem;">
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                    <span class="text-muted">Submitted</span>
                    <span><?php echo e($submission->created_at->format('M j, Y g:i A')); ?></span>
                </div>
                
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                    <span class="text-muted">IP Address</span>
                    <span class="mono"><?php echo e($submission->ip_address ?? 'Unknown'); ?></span>
                </div>
                
                <?php if($submission->referrer): ?>
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                        <span class="text-muted">Referrer</span>
                        <span style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?php echo e(parse_url($submission->referrer, PHP_URL_HOST)); ?>

                        </span>
                    </div>
                <?php endif; ?>
                
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                    <span class="text-muted">Email Sent</span>
                    <span><?php echo e($submission->email_sent ? 'Yes' : 'No'); ?></span>
                </div>
                
                
                <?php if($submission->metadata && isset($submission->metadata['has_attachment']) && $submission->metadata['has_attachment']): ?>
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                        <span class="text-muted">Attachments</span>
                        <span style="color: var(--success);">
                            <?php echo e($submission->metadata['attachment_count'] ?? 1); ?> file(s)
                        </span>
                    </div>
                    
                    
                    <?php if(isset($submission->metadata['attachment_name'])): ?>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                            <span class="text-muted">File Name</span>
                            <span style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?php echo e($submission->metadata['attachment_name']); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(isset($submission->metadata['attachment_size'])): ?>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                            <span class="text-muted">File Size</span>
                            <span><?php echo e(round($submission->metadata['attachment_size'] / 1024, 2)); ?> KB</span>
                        </div>
                    <?php endif; ?>
                    
                    
                    <?php if(isset($submission->metadata['attachments']) && is_array($submission->metadata['attachments'])): ?>
                        <?php
                            $totalSize = array_sum(array_column($submission->metadata['attachments'], 'size'));
                        ?>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                            <span class="text-muted">Total Size</span>
                            <span><?php echo e(round($totalSize / 1024, 2)); ?> KB</span>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Delete -->
        <div class="card" style="border-color: rgba(255,68,68,0.3);">
            <h4 style="color: var(--error); margin-bottom: 0.75rem; font-size: 0.9rem;">Delete Submission</h4>
            <p class="text-muted" style="font-size: 0.8rem; margin-bottom: 1rem;">This cannot be undone.</p>
            <form id="delete-submission-<?php echo e($submission->id); ?>" method="POST" action="<?php echo e(route('dashboard.submissions.destroy', [$form->id, $submission->id])); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            </form>
            <button type="button" class="btn btn-danger btn-sm" style="width: 100%;" onclick="deleteSubmission('<?php echo e($form->id); ?>', '<?php echo e($submission->id); ?>')">
                Delete
            </button>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function deleteSubmission(formId, submissionId) {
    if (confirm('Are you sure you want to delete this submission? This action cannot be undone.')) {
        document.getElementById(`delete-submission-${submissionId}`).submit();
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\dashboard\submissions\show.blade.php ENDPATH**/ ?>