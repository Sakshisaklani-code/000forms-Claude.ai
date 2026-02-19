<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="000form - Free form backend for your websites. No server required.">
    <title><?php echo $__env->yieldContent('title', '000form - Free Form Backend'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <nav class="nav">
        <div class="nav-inner">
            <a href="/" class="nav-logo"><span>000</span>form</a>
            <ul class="nav-links">
                <li><a href="<?php echo e(route('docs')); ?>">Documentation</a></li>
                <li><a href="<?php echo e(route('pricing')); ?>">Pricing</a></li>
                <li><a href="<?php echo e(route('Home.library')); ?>">Library</a></li>
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
    <script src="/js/app.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <footer class="footer">
        <div class="container">
            <div class="footer-inner">
                <div class="nav-logo"><span>000</span>form</div>
                <ul class="footer-links">
                    <li><a href="/ajax">AJAX</a></li>
                    <li><a href="<?php echo e(route('playground.index')); ?>">Playground</a></li>
                    <!-- <li><a href="mailto:support@000form.com">Support</a></li> -->
                </ul>
                <p class="footer-copy">&copy; <?php echo e(date('Y')); ?> 000form</p>
            </div>
        </div>
    </footer>

</body>
</html>
<?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/layouts/app.blade.php ENDPATH**/ ?>