

<?php $__env->startSection('title', 'Pricing - 000form'); ?>

<?php $__env->startSection('content'); ?>
    <nav class="nav">
        <div class="nav-inner">
            <a href="/" class="nav-logo"><span>000</span>form</a>
            <ul class="nav-links">
                <li><a href="/#features">Features</a></li>
                <li><a href="<?php echo e(route('docs')); ?>">Docs</a></li>
                <li><a href="<?php echo e(route('pricing')); ?>" style="color: var(--accent);">Pricing</a></li>
            </ul>
            <div class="nav-actions">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-ghost">Login</a>
                    <a href="<?php echo e(route('signup')); ?>" class="btn btn-primary">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-inner">
                <div class="nav-logo">
                    <span>000</span>form
                </div>
                
                <ul class="footer-links">
                    <li><a href="<?php echo e(route('docs')); ?>">Documentation</a></li>
                    <li><a href="<?php echo e(route('pricing')); ?>">Pricing</a></li>
                    <li><a href="mailto:support@000form.com">Support</a></li>
                    <li><a href="/privacy">Privacy</a></li>
                    <li><a href="/library">Library</a></li>
                </ul>
                
                <p class="footer-copy">&copy; <?php echo e(date('Y')); ?> 000form. All rights reserved.</p>
            </div>
        </div>
    </footer>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/layouts/appLanding.blade.php ENDPATH**/ ?>