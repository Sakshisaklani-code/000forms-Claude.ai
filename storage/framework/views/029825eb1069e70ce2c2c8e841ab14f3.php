

<?php $__env->startSection('title', 'Library - 000form'); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/library.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- Library Hero Section -->
<section class="library-hero">
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
                Form Library • Copy & Paste Ready
            </div>
            
            <h1 class="hero-title">
                Form templates for <span class="highlight">every need</span>
            </h1>
            
            <p class="hero-description">
                Browse our collection of beautiful, ready-to-use form templates. 
                Built with multiple frameworks, completely free.
            </p>
        </div>
    </div>
</section>

<!-- Library Content -->
<section class="library-content">
    <div class="library-grid">
        
        <!-- Sidebar -->
        <aside class="library-sidebar">
            <div class="sidebar-card">
                
                <!-- Framework Selector -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Technology</h3>
                    
                    <div class="tech-list">
                        <a href="#" class="tech-link active">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <path d="M22 6l-10 7L2 6"/>
                            </svg>
                            HTML Forms
                            <span class="tech-count">24</span>
                        </a>
                        
                        <a href="#" class="tech-link">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="4" y="4" width="16" height="16" rx="2" ry="2"/>
                                <path d="M8 8h8v8H8z"/>
                                <path d="M12 8v8M8 12h8"/>
                            </svg>
                            Tailwind Forms
                            <span class="tech-count">18</span>
                        </a>
                        
                        <a href="#" class="tech-link">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 8v8M8 12h8"/>
                            </svg>
                            React Forms
                            <span class="tech-count">15</span>
                        </a>
                    </div>
                </div>
                
                <!-- Form Categories -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Categories</h3>
                    
                    <div class="category-list">
                        <a href="#" class="category-link active">
                            <span>All Forms</span>
                            <span class="category-count">57</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Application Forms</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Contact Forms</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Donation Forms</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Feedback Forms</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Order Forms</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Registration Forms</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Request Forms</span>
                        </a>
                    </div>
                </div>
            </div>
        </aside>
        
<main>
    <!-- Form Blocks Grid -->
    <div class="forms-grid">
        
        <!-- Application Form Card -->
        <div class="form-card-wrapper">
            <div class="form-card">
                
                
                <div class="form-preview">
                    <pre><span class="form-tag">&lt;form&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"text"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Full Name"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"email"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Email"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"tel"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Phone"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;button&gt;</span>Apply Now<span class="form-tag">&lt;/button&gt;</span>
<span class="form-tag">&lt;/form&gt;</span></pre>
                </div>
                
                <div class="form-type-link">
                    <div class="form-card-header">
                        <span class="form-badge">Application Form</span>
                    </div>
                    <a href="<?php echo e(route('Home.library.ApplicationForm')); ?>" class="view-more-link">
                        View all 6 templates
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Contact Form Card -->
        <div class="form-card-wrapper">
            <div class="form-card">
                
                <div class="form-preview">
                    <pre><span class="form-tag">&lt;form</span> <span class="form-attr">class=</span><span class="form-string">"space-y-4"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">class=</span><span class="form-string">"w-full px-4 py-2 rounded border"</span> 
         <span class="form-attr">placeholder=</span><span class="form-string">"Your Name"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">class=</span><span class="form-string">"w-full px-4 py-2 rounded border"</span> 
         <span class="form-attr">placeholder=</span><span class="form-string">"Email"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;textarea</span> <span class="form-attr">class=</span><span class="form-string">"w-full px-4 py-2 rounded border"</span> 
            <span class="form-attr">placeholder=</span><span class="form-string">"Message"</span><span class="form-tag">&gt;&lt;/textarea&gt;</span>
  <span class="form-tag">&lt;button</span> <span class="form-attr">class=</span><span class="form-string">"bg-blue-500 text-white px-6 py-2 rounded"</span><span class="form-tag">&gt;</span>
    Send Message
  <span class="form-tag">&lt;/button&gt;</span>
<span class="form-tag">&lt;/form&gt;</span></pre>
                </div>
                
                <div class="form-type-link">
                    <div class="form-card-header">
                        <span class="form-badge">Contact Form</span>
                    </div>
                    <a href="#" class="view-more-link">
                        View 12+ templates
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Donation Form Card -->
        <div class="form-card-wrapper">
            <div class="form-card">
                
                <div class="form-preview">
                    <pre><span class="form-property">const</span> <span class="form-tag">DonationForm</span> = () =&gt; {
  <span class="form-property">const</span> [amount, setAmount] = <span class="form-tag">useState</span>('');
  
  <span class="form-property">return</span> (
    <span class="form-tag">&lt;form</span> <span class="form-attr">onSubmit=</span><span class="form-string">{handleSubmit}</span><span class="form-tag">&gt;</span>
      <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"number"</span> 
             <span class="form-attr">value=</span><span class="form-string">{amount}</span>
             <span class="form-attr">onChange=</span><span class="form-string">{(e) => setAmount(e.target.value)}</span>
             <span class="form-attr">placeholder=</span><span class="form-string">"Amount"</span><span class="form-tag">/&gt;</span>
      <span class="form-tag">&lt;button</span> <span class="form-attr">type=</span><span class="form-string">"submit"</span><span class="form-tag">&gt;</span>Donate<span class="form-tag">&lt;/button&gt;</span>
    <span class="form-tag">&lt;/form&gt;</span>
  )
}</pre>
                </div>
                
                <div class="form-type-link">
                    <div class="form-card-header">
                        <span class="form-badge">Donation Form</span>
                    </div>
                    <a href="#" class="view-more-link">
                        View 12+ templates
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Feedback Form Card -->
        <div class="form-card-wrapper">
            <div class="form-card">
                
                <div class="form-preview">
                    <pre><span class="form-tag">&lt;form&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"text"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Name"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;select&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>Rating<span class="form-tag">&lt;/option&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>5 - Excellent<span class="form-tag">&lt;/option&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>4 - Good<span class="form-tag">&lt;/option&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>3 - Average<span class="form-tag">&lt;/option&gt;</span>
  <span class="form-tag">&lt;/select&gt;</span>
  <span class="form-tag">&lt;textarea</span> <span class="form-attr">placeholder=</span><span class="form-string">"Your feedback"</span><span class="form-tag">&gt;&lt;/textarea&gt;</span>
  <span class="form-tag">&lt;button&gt;</span>Submit Feedback<span class="form-tag">&lt;/button&gt;</span>
<span class="form-tag">&lt;/form&gt;</span></pre>
                </div>
                
                <div class="form-type-link">
                    <div class="form-card-header">
                        <span class="form-badge">Feedback Form</span>
                    </div>
                    <a href="#" class="view-more-link">
                        View 12+ templates
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Order Form Card -->
        <div class="form-card-wrapper">
            <div class="form-card">
                
                <div class="form-preview">
                    <pre><span class="form-tag">&lt;form</span> <span class="form-attr">class=</span><span class="form-string">"space-y-4 max-w-md"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;div</span> <span class="form-attr">class=</span><span class="form-string">"flex gap-4"</span><span class="form-tag">&gt;</span>
    <span class="form-tag">&lt;input</span> <span class="form-attr">class=</span><span class="form-string">"flex-1 px-4 py-2 border rounded"</span> 
           <span class="form-attr">placeholder=</span><span class="form-string">"Product"</span><span class="form-tag">&gt;</span>
    <span class="form-tag">&lt;input</span> <span class="form-attr">class=</span><span class="form-string">"w-24 px-4 py-2 border rounded"</span> 
           <span class="form-attr">placeholder=</span><span class="form-string">"Qty"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;/div&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">class=</span><span class="form-string">"w-full px-4 py-2 border rounded"</span> 
         <span class="form-attr">placeholder=</span><span class="form-string">"Email"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;button</span> <span class="form-attr">class=</span><span class="form-string">"w-full bg-green-500 text-white py-2 rounded"</span><span class="form-tag">&gt;</span>
    Place Order
  <span class="form-tag">&lt;/button&gt;</span>
<span class="form-tag">&lt;/form&gt;</span></pre>
                </div>
                
                <div class="form-type-link">
                    <div class="form-card-header">
                        <span class="form-badge">Order Form</span>
                    </div>
                    <a href="#" class="view-more-link">
                        View 12+ templates
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Registration Form Card -->
        <div class="form-card-wrapper">
            <div class="form-card">
                
                <div class="form-preview">
                    <pre><span class="form-property">const</span> <span class="form-tag">RegisterForm</span> = () =&gt; {
  <span class="form-property">return</span> (
    <span class="form-tag">&lt;form&gt;</span>
      <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"text"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Username"</span> <span class="form-tag">/&gt;</span>
      <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"email"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Email"</span> <span class="form-tag">/&gt;</span>
      <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"password"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Password"</span> <span class="form-tag">/&gt;</span>
      <span class="form-tag">&lt;button</span> <span class="form-attr">type=</span><span class="form-string">"submit"</span><span class="form-tag">&gt;</span>
        Register
      <span class="form-tag">&lt;/button&gt;</span>
    <span class="form-tag">&lt;/form&gt;</span>
  )
}</pre>
                </div>
                
                <div class="form-type-link">
                    <div class="form-card-header">
                        <span class="form-badge">Registration Form</span>
                    </div>
                    <a href="#" class="view-more-link">
                        View 12+ templates
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Request Form Card -->
        <div class="form-card-wrapper">
            <div class="form-card">
                
                <div class="form-preview">
                    <pre><span class="form-tag">&lt;form&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"text"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Full Name"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"email"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Email"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;select&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>Request Type<span class="form-tag">&lt;/option&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>Feature Request<span class="form-tag">&lt;/option&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>Bug Report<span class="form-tag">&lt;/option&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>Support<span class="form-tag">&lt;/option&gt;</span>
  <span class="form-tag">&lt;/select&gt;</span>
  <span class="form-tag">&lt;textarea</span> <span class="form-attr">placeholder=</span><span class="form-string">"Details"</span><span class="form-tag">&gt;&lt;/textarea&gt;</span>
  <span class="form-tag">&lt;button&gt;</span>Submit Request<span class="form-tag">&lt;/button&gt;</span>
<span class="form-tag">&lt;/form&gt;</span></pre>
                </div>
                
                <div class="form-type-link">
                    <div class="form-card-header">
                        <span class="form-badge">Request Form</span>
                    </div>
                    <a href="#" class="view-more-link">
                        View 12+ templates
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Request Form Card -->
        <div class="form-card-wrapper">
            <div class="form-card">
                
                <div class="form-preview">
                    <pre><span class="form-tag">&lt;form&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"text"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Full Name"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;input</span> <span class="form-attr">type=</span><span class="form-string">"email"</span> <span class="form-attr">placeholder=</span><span class="form-string">"Email"</span><span class="form-tag">&gt;</span>
  <span class="form-tag">&lt;select&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>Request Type<span class="form-tag">&lt;/option&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>Feature Request<span class="form-tag">&lt;/option&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>Bug Report<span class="form-tag">&lt;/option&gt;</span>
    <span class="form-tag">&lt;option&gt;</span>Support<span class="form-tag">&lt;/option&gt;</span>
  <span class="form-tag">&lt;/select&gt;</span>
  <span class="form-tag">&lt;textarea</span> <span class="form-attr">placeholder=</span><span class="form-string">"Details"</span><span class="form-tag">&gt;&lt;/textarea&gt;</span>
  <span class="form-tag">&lt;button&gt;</span>Submit Request<span class="form-tag">&lt;/button&gt;</span>
<span class="form-tag">&lt;/form&gt;</span></pre>
                </div>
                
                <div class="form-type-link">
                    <div class="form-card-header">
                        <span class="form-badge">Signup Form</span>
                    </div>
                    <a href="#" class="view-more-link">
                        View 12+ templates
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
    </div>

    
    
    <!-- View All Categories Link -->
    <div class="view-all-categories">
        <a href="#" class="view-all-link">
            <span>Browse all form categories</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</main>

</div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/Library/htmlTemplates.blade.php ENDPATH**/ ?>