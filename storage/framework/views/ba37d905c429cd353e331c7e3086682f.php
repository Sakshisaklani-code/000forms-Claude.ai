<?php $__env->startSection('title', 'Pricing - 000form'); ?>

<?php $__env->startSection('content'); ?>

<div style="padding: 8rem 0 4rem;">
    <div class="container" style="max-width: 800px;">
        <div class="text-center" style="margin-bottom: 4rem;">
            <h1 style="margin-bottom: 1rem;">Simple, transparent pricing</h1>
            <p class="text-muted" style="font-size: 1.25rem;">Free forever. No credit card required. No hidden fees.</p>
        </div>
        
        <div class="card" style="padding: 3rem; text-align: center; border-color: var(--accent); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; right: 0; background: var(--accent); color: var(--bg-primary); padding: 0.5rem 2rem; font-size: 0.875rem; font-weight: 600; transform: rotate(45deg) translate(25%, -50%); transform-origin: center;">
                FREE
            </div>
            
            <h2 style="font-size: 3rem; margin-bottom: 0.5rem;">$0</h2>
            <p class="text-muted" style="margin-bottom: 2rem;">Forever free, no strings attached</p>
            
            <ul style="list-style: none; text-align: left; max-width: 400px; margin: 0 auto 2rem;">
                <li style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Unlimited forms</span>
                </li>
                <li style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Unlimited submissions</span>
                </li>
                <li style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Email notifications</span>
                </li>
                <li style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Spam protection</span>
                </li>
                <li style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Dashboard & analytics</span>
                </li>
                <li style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>CSV export</span>
                </li>
                <li style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>AJAX support</span>
                </li>
                <li style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Custom redirects</span>
                </li>
            </ul>
            
            <a href="<?php echo e(route('signup')); ?>" class="btn btn-primary btn-lg">Get Started Free</a>
        </div>
        
        <div class="text-center mt-4">
            <h3 style="margin-bottom: 1rem;">Why is it free?</h3>
            <p class="text-muted" style="max-width: 500px; margin: 0 auto;">
                We believe form handling should be accessible to everyone. 000form is a passion project 
                built to help developers ship faster without worrying about backend infrastructure.
            </p>
        </div>
        
        <div class="card mt-4" style="background: var(--bg-secondary);">
            <h3 style="margin-bottom: 1rem;">Need more?</h3>
            <p class="text-muted" style="margin-bottom: 1rem;">
                We're working on premium features for teams and high-volume users:
            </p>
            <ul style="color: var(--text-muted); padding-left: 1.5rem; line-height: 2;">
                <li>File uploads</li>
                <li>Custom domains</li>
                <li>Webhooks & integrations</li>
                <li>Team collaboration</li>
                <li>Priority support</li>
            </ul>
            <p class="text-muted mt-3">
                <a href="mailto:hello@000form.com">Contact us</a> if you're interested in early access.
            </p>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/pages/pricing.blade.php ENDPATH**/ ?>