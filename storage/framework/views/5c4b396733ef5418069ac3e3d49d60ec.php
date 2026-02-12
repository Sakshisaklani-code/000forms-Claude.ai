<?php $__env->startSection('title', '000form - Free Form Backend for Your Website'); ?>

<?php $__env->startSection('content'); ?>
<!-- Navigation -->
<nav class="nav">
    <div class="nav-inner">
        <a href="/" class="nav-logo">
            <span>000</span>form
        </a>
        
        <ul class="nav-links">
            <li><a href="#features">Features</a></li>
            <li><a href="#how-it-works">How It Works</a></li>
            <li><a href="<?php echo e(route('docs')); ?>">Docs</a></li>
            <li><a href="<?php echo e(route('pricing')); ?>">Pricing</a></li>
        </ul>
        
        <div class="nav-actions">
            <a href="<?php echo e(route('login')); ?>" class="btn btn-ghost">Login</a>
            <a href="<?php echo e(route('signup')); ?>" class="btn btn-primary">Get Started Free</a>
        </div>
        
        <button class="nav-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg">
        <div class="hero-gradient hero-gradient-1"></div>
        <div class="hero-gradient hero-gradient-2"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
                Forever Free • No Credit Card Required
            </div>
            
            <h1 class="hero-title">
                Form backend for <span class="highlight">static sites</span>
            </h1>
            
            <p class="hero-description">
                Connect your HTML forms to our endpoint and receive submissions in your inbox. 
                No backend code, no servers, no hassle. Just forms that work.
            </p>
            
            <div class="hero-actions">
                <a href="<?php echo e(route('signup')); ?>" class="btn btn-primary btn-lg">
                    Start for Free
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#how-it-works" class="btn btn-secondary btn-lg">
                    See How It Works
                </a>
            </div>
            
            <div class="hero-code">
                <div class="code-block">
                    <div class="code-header">
                        <span class="code-lang">HTML</span>
                        <button class="code-copy">Copy</button>
                    </div>
                    <div class="code-content">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"https://000form.com/f/your-id"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span> <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features" id="features">
    <div class="container">
        <div class="section-header">
            <h2>Everything you need, nothing you don't</h2>
            <p>Simple, powerful form handling that just works. No complex setup, no monthly fees.</p>
        </div>
        
        <div class="features-grid">
            <div class="card feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <path d="M22 6l-10 7L2 6"/>
                    </svg>
                </div>
                <h4 class="feature-title">Email Notifications</h4>
                <p>Get instant email notifications whenever someone submits your form. Reply directly to the sender.</p>
            </div>
            
            <div class="card feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <h4 class="feature-title">Spam Protection</h4>
                <p>Built-in honeypot fields and smart detection keep your inbox clean from spam submissions.</p>
            </div>
            
            <div class="card feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                </div>
                <h4 class="feature-title">Instant Setup</h4>
                <p>Create your form endpoint in seconds. Just point your form's action to our URL and you're done.</p>
            </div>
            
            <div class="card feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <path d="M3 9h18M9 21V9"/>
                    </svg>
                </div>
                <h4 class="feature-title">Dashboard</h4>
                <p>View all your submissions in a clean dashboard. Search, export, and manage everything in one place.</p>
            </div>
            
            <div class="card feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                </div>
                <h4 class="feature-title">CSV Export</h4>
                <p>Export your submissions as CSV files anytime. Your data belongs to you.</p>
            </div>
            
            <div class="card feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 18 22 12 16 6"/>
                        <polyline points="8 6 2 12 8 18"/>
                    </svg>
                </div>
                <h4 class="feature-title">AJAX Support</h4>
                <p>Use JavaScript fetch or XMLHttpRequest for seamless form submissions without page reloads.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works" id="how-it-works">
    <div class="container">
        <div class="section-header">
            <h2>Up and running in 3 steps</h2>
            <p>No complicated setup. No backend code. Just forms that work.</p>
        </div>
        
        <div class="steps">
            <div class="step">
                <span class="step-number">1</span>
                <h4 class="step-title">Create your form endpoint</h4>
                <p>Sign up and create a new form. We'll generate a unique endpoint URL for you.</p>
            </div>
            
            <div class="step">
                <span class="step-number">2</span>
                <h4 class="step-title">Point your form to us</h4>
                <p>Update your HTML form's action attribute to your new endpoint URL. That's it!</p>
            </div>
            
            <div class="step">
                <span class="step-number">3</span>
                <h4 class="step-title">Receive submissions</h4>
                <p>Get email notifications and view all submissions in your dashboard.</p>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?php echo e(route('signup')); ?>" class="btn btn-primary btn-lg">Create Your First Form</a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="features">
    <div class="container">
        <div class="card" style="text-align: center; padding: 4rem 2rem;">
            <h2 style="margin-bottom: 1rem;">Ready to simplify your forms?</h2>
            <p style="max-width: 500px; margin: 0 auto 2rem;">
                Join thousands of developers who trust 000form for their static sites. 
                Forever free, no credit card required.
            </p>
            <a href="<?php echo e(route('signup')); ?>" class="btn btn-primary btn-lg">Get Started Free</a>
        </div>
    </div>
</section>

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
                <li><a href="/terms">Terms</a></li>
            </ul>
            
            <p class="footer-copy">&copy; <?php echo e(date('Y')); ?> 000form. All rights reserved.</p>
        </div>
    </div>
</footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/pages/home.blade.php ENDPATH**/ ?>