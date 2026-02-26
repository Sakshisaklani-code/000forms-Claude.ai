<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="description" content="000form - Free form backend for your websites. No server required.">
    <title><?php echo $__env->yieldContent('title', '000form - Free Form Backend'); ?></title>
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('images/favicon/000formFavicon.png')); ?>" type="image/svg+xml">
    <!-- Canonical Tag --> 
    <link rel="canonical" href="https://000form.com/" />
    <!-- Keywords --> 
    <meta name="keywords" content="forms, laravel forms, php form builder, contact forms, form submissions, 000Form">
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
    <style>
        /* Mobile menu styles */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 100;
        }
        
        .mobile-menu-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background: var(--text-primary);
            margin: 5px 0;
            transition: 0.3s;
            border-radius: 3px;
        }
        
        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }
        
        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .nav-links,
            .nav-actions {
                display: none;
                width: 100%;
            }
            
            .nav-links.active,
            .nav-actions.active {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1rem;
                padding: 1rem 0;
            }
            
            .nav-links.active {
                border-top: 1px solid var(--border-color);
                margin-top: 1rem;
            }
            
            .nav-inner {
                flex-wrap: wrap;
            }
            
            .footer-inner {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .footer-links {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 0 1rem;
            }
            
            .nav-logo {
                font-size: 1.5rem;
            }
            
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
        .nav-logo img{
            height: 35px;
            /* filter: brightness(0) saturate(100%) invert(74%) sepia(69%) saturate(500%) hue-rotate(100deg) brightness(105%); */
        }
    </style>
</head>
<body>

    <nav class="nav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <img src="<?php echo e(asset('images/logo/000formlogo.png')); ?>" alt="000form Logo">
            </a>
            
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <ul class="nav-links" id="navLinks">
                <li><a href="<?php echo e(route('docs')); ?>">Documentation</a></li>
                <li><a href="<?php echo e(route('pricing')); ?>">Pricing</a></li>
                <li><a href="<?php echo e(route('Home.library')); ?>">Library</a></li>
            </ul>
            
            <div class="nav-actions" id="navActions">
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

    <script src="/js/app.js"></script>
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('mobileMenuToggle');
            const navLinks = document.getElementById('navLinks');
            const navActions = document.getElementById('navActions');
            
            if (toggle && navLinks && navActions) {
                toggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    navLinks.classList.toggle('active');
                    navActions.classList.toggle('active');
                });
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000form\resources\views/layouts/app.blade.php ENDPATH**/ ?>