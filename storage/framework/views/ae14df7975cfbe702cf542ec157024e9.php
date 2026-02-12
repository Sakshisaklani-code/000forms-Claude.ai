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

<!-- Forms Created Chart -->
<?php if($forms->count() > 0): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="padding: 1.5rem;">
        <h3 style="margin: 0 0 1.5rem 0; font-size: 1rem; font-weight: 600; color: var(--text-primary);">Forms Created Over Time</h3>
        <div id="formsChart" style="height: 200px; position: relative;"></div>
    </div>
</div>
<?php endif; ?>

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

<?php if($forms->count() > 0): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = <?php echo json_encode($chartData ?? [], 15, 512) ?>;
    
    if (!chartData || chartData.length === 0) return;
    
    const chartContainer = document.getElementById('formsChart');
    const width = chartContainer.offsetWidth;
    const height = 200;
    const padding = { top: 20, right: 20, bottom: 30, left: 40 };
    
    // Find max value for scaling
    const maxValue = Math.max(...chartData.map(d => d.count));
    const chartWidth = width - padding.left - padding.right;
    const chartHeight = height - padding.top - padding.bottom;
    
    // Create SVG
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', width);
    svg.setAttribute('height', height);
    svg.style.overflow = 'visible';
    
    // Background grid lines
    const gridGroup = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    for (let i = 0; i <= 4; i++) {
        const y = padding.top + (chartHeight / 4) * i;
        const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        line.setAttribute('x1', padding.left);
        line.setAttribute('y1', y);
        line.setAttribute('x2', width - padding.right);
        line.setAttribute('y2', y);
        line.setAttribute('stroke', 'var(--border-color, #e5e7eb)');
        line.setAttribute('stroke-width', '1');
        line.setAttribute('stroke-dasharray', '2,2');
        line.setAttribute('opacity', '0.5');
        gridGroup.appendChild(line);
    }
    svg.appendChild(gridGroup);
    
    // Calculate points for the line
    const points = chartData.map((d, i) => {
        const x = padding.left + (chartWidth / (chartData.length - 1)) * i;
        const y = padding.top + chartHeight - (d.count / maxValue) * chartHeight;
        return { x, y, count: d.count, label: d.label };
    });
    
    // Create gradient for area fill
    const defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
    const gradient = document.createElementNS('http://www.w3.org/2000/svg', 'linearGradient');
    gradient.setAttribute('id', 'areaGradient');
    gradient.setAttribute('x1', '0%');
    gradient.setAttribute('y1', '0%');
    gradient.setAttribute('x2', '0%');
    gradient.setAttribute('y2', '100%');
    
    const stop1 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
    stop1.setAttribute('offset', '0%');
    stop1.setAttribute('style', 'stop-color:var(--primary-color, #3b82f6);stop-opacity:0.2');
    
    const stop2 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
    stop2.setAttribute('offset', '100%');
    stop2.setAttribute('style', 'stop-color:var(--primary-color, #3b82f6);stop-opacity:0');
    
    gradient.appendChild(stop1);
    gradient.appendChild(stop2);
    defs.appendChild(gradient);
    svg.appendChild(defs);
    
    // Create area path
    let areaPath = `M ${padding.left} ${height - padding.bottom}`;
    points.forEach(p => {
        areaPath += ` L ${p.x} ${p.y}`;
    });
    areaPath += ` L ${points[points.length - 1].x} ${height - padding.bottom} Z`;
    
    const area = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    area.setAttribute('d', areaPath);
    area.setAttribute('fill', 'url(#areaGradient)');
    svg.appendChild(area);
    
    // Create line path
    let linePath = `M ${points[0].x} ${points[0].y}`;
    points.forEach((p, i) => {
        if (i > 0) {
            linePath += ` L ${p.x} ${p.y}`;
        }
    });
    
    const line = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    line.setAttribute('d', linePath);
    line.setAttribute('fill', 'none');
    line.setAttribute('stroke', 'var(--primary-color, #3b82f6)');
    line.setAttribute('stroke-width', '2');
    line.setAttribute('stroke-linecap', 'round');
    line.setAttribute('stroke-linejoin', 'round');
    svg.appendChild(line);
    
    // Add points
    points.forEach((p, i) => {
        const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
        circle.setAttribute('cx', p.x);
        circle.setAttribute('cy', p.y);
        circle.setAttribute('r', '4');
        circle.setAttribute('fill', 'white');
        circle.setAttribute('stroke', 'var(--primary-color, #3b82f6)');
        circle.setAttribute('stroke-width', '2');
        circle.style.cursor = 'pointer';
        circle.style.transition = 'r 0.2s ease';
        
        // Hover effect
        circle.addEventListener('mouseenter', function() {
            this.setAttribute('r', '6');
            tooltip.style.opacity = '1';
            tooltip.style.transform = 'translateY(0)';
            tooltip.textContent = `${p.label}: ${p.count} form${p.count !== 1 ? 's' : ''}`;
            tooltip.style.left = (p.x - tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = (p.y - 35) + 'px';
        });
        
        circle.addEventListener('mouseleave', function() {
            this.setAttribute('r', '4');
            tooltip.style.opacity = '0';
            tooltip.style.transform = 'translateY(-5px)';
        });
        
        svg.appendChild(circle);
        
        // X-axis labels
        if (chartData.length <= 12 || i % Math.ceil(chartData.length / 12) === 0) {
            const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            text.setAttribute('x', p.x);
            text.setAttribute('y', height - padding.bottom + 20);
            text.setAttribute('text-anchor', 'middle');
            text.setAttribute('font-size', '11');
            text.setAttribute('fill', 'var(--text-muted, #6b7280)');
            text.textContent = p.label;
            svg.appendChild(text);
        }
    });
    
    // Y-axis labels
    for (let i = 0; i <= 4; i++) {
        const value = Math.round((maxValue / 4) * (4 - i));
        const y = padding.top + (chartHeight / 4) * i;
        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', padding.left - 10);
        text.setAttribute('y', y + 4);
        text.setAttribute('text-anchor', 'end');
        text.setAttribute('font-size', '11');
        text.setAttribute('fill', 'var(--text-muted, #6b7280)');
        text.textContent = value;
        svg.appendChild(text);
    }
    
    // Create tooltip
    const tooltip = document.createElement('div');
    tooltip.style.position = 'absolute';
    tooltip.style.background = 'rgba(0, 0, 0, 0.8)';
    tooltip.style.color = 'white';
    tooltip.style.padding = '6px 10px';
    tooltip.style.borderRadius = '4px';
    tooltip.style.fontSize = '12px';
    tooltip.style.pointerEvents = 'none';
    tooltip.style.opacity = '0';
    tooltip.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
    tooltip.style.transform = 'translateY(-5px)';
    tooltip.style.whiteSpace = 'nowrap';
    tooltip.style.zIndex = '1000';
    chartContainer.style.position = 'relative';
    chartContainer.appendChild(tooltip);
    
    chartContainer.appendChild(svg);
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Projects-By-Sir\000form-11-02-2026\resources\views/dashboard/index.blade.php ENDPATH**/ ?>