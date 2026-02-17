<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <a href="<?php echo e(route('dashboard.forms.create')); ?>" class="btn btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Form
    </a>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="card stat-card">
        <div class="stat-label">Total Forms</div>
        <div class="stat-value"><?php echo e($stats['total_forms']); ?></div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Total Submissions</div>
        <div class="stat-value"><?php echo e(number_format($stats['total_submissions'])); ?></div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Unread</div>
        <div class="stat-value accent"><?php echo e($stats['total_unread']); ?></div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">This Month</div>
        <div class="stat-value"><?php echo e($stats['forms_this_month']); ?> new</div>
    </div>
</div>

<!-- Forms List -->
<?php if($forms->count() > 0): ?>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Form Name</th>
                    <th>Endpoint</th>
                    <th>Submissions</th>
                    <th>Status</th>
                    <th>Last Submission</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('dashboard.forms.show', $form->id)); ?>" class="table-link">
                                <?php echo e($form->name); ?>

                            </a>
                            <?php if($form->unread_count > 0): ?>
                                <span class="badge badge-success" style="margin-left: 0.5rem;">
                                    <?php echo e($form->unread_count); ?> new
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <code class="mono" style="font-size: 0.85rem; color: var(--text-muted);">
                                /f/<?php echo e($form->slug); ?>

                            </code>
                        </td>
                        <td><?php echo e(number_format($form->submission_count)); ?></td>
                        <td>
                            <?php if(!$form->email_verified): ?>
                                <span class="badge badge-warning">
                                    <span class="badge-dot"></span>
                                    Pending Verification
                                </span>
                            <?php elseif($form->status === 'active'): ?>
                                <span class="badge badge-success">
                                    <span class="badge-dot"></span>
                                    Active
                                </span>
                            <?php else: ?>
                                <span class="badge badge-warning">
                                    <span class="badge-dot"></span>
                                    Paused
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted">
                            <?php echo e($form->last_submission_at ? $form->last_submission_at->diffForHumans() : 'Never'); ?>

                        </td>
                        <td class="text-right">
                            <a href="<?php echo e(route('dashboard.forms.show', $form->id)); ?>" class="btn btn-ghost btn-sm">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="card">
        <div class="empty-state">
            <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="empty-title">No forms yet</h3>
            <p class="empty-description">Create your first form endpoint to start collecting submissions.</p>
            <a href="<?php echo e(route('dashboard.forms.create')); ?>" class="btn btn-primary">
                Create Your First Form
            </a>
        </div>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\dashboard\index.blade.php ENDPATH**/ ?>