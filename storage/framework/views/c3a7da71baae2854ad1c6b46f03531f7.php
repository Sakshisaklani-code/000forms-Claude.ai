<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="000form - Free form backend for your websites. No server required.">
    <title><?php echo $__env->yieldContent('title', '000form - Free Form Backend'); ?></title>
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('images/favicon/file-text-fill.svg')); ?>" type="image/svg+xml">
    <!-- Canonical Tag --> 
    <link rel="canonical" href="https://000form.com/" />
    <!-- FontsStyles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="/css/app.css">
    <!-- Open Graph Tags --> 
    <meta property="og:title" content="000Forms - Smart Form Submissions" /> 
    <meta property="og:description" content="Easily create and manage forms with 000Forms, a Laravel-powered solution." /> 
    <meta property="og:type" content="website" /> 
    <meta property="og:url" content="https://000form.com/" /> 
    <meta property="og:image" content="<?php echo e(asset('images/og-image/og-image.jpg')); ?>" /> 
    <meta property="og:site_name" content="000Forms" />
    <!-- Index and follow for SEO -->
    <meta name="robots" content="index, follow">
    <!-- Schema.org JSON-LD --> 
    <script type="application/ld+json"> 
       { 
            "@context": "https://schema.org", 
            "@type": "Organization", 
            "name": "000Forms", 
            "alternateName": "000Forms", 
            "url": "<?php echo e(url('/')); ?>", 
        }
    </script>
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
<?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000form\resources\views/layouts/app.blade.php ENDPATH**/ ?>