

<?php $__env->startSection('title', 'Library - 000form'); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/library.css')); ?>" rel="stylesheet">
<style>
    /* Additional styles for form previews */
    .form-preview {
        background: #0a0a0a;
        border: 1px solid #1a1a1a;
        border-radius: 10px;
        padding: 1.5rem;
        height: 220px;
        display: flex;
        flex-direction: column;
        transition: all 0.2s ease;
    }

    .form-card:hover {
        border-color: #00ff88;
        background: #0d0d0d;
    }

    .preview-field {
        background: #111111;
        border: 1px solid #1f1f1f;
        border-radius: 6px;
        padding: 0.6rem 0.8rem;
        margin-bottom: 0.6rem;
        color: #888888;
        font-size: 0.8rem;
        font-family: 'Outfit', sans-serif;
        width: 100%;
        display: block;
    }

    .preview-field:last-of-type {
        margin-bottom: 0.8rem;
    }

    .preview-row {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.6rem;
    }

    .preview-row .preview-field {
        margin-bottom: 0;
        flex: 1;
    }

    .preview-button {
        background: #00ff88;
        color: #050505;
        border: none;
        border-radius: 6px;
        padding: 0.6rem;
        font-size: 0.8rem;
        font-weight: 500;
        width: 100%;
        text-align: center;
        opacity: 0.9;
    }

    .preview-label {
        color: #00ff88;
        font-size: 0.7rem;
        font-weight: 500;
        margin-bottom: 0.3rem;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .preview-radio-group {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.8rem;
        padding: 0.3rem 0;
    }

    .preview-radio {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        color: #888888;
        font-size: 0.8rem;
    }

    .preview-radio-dot {
        width: 12px;
        height: 12px;
        border: 2px solid #2a2a2a;
        border-radius: 50%;
        display: inline-block;
    }

    .preview-radio-dot.selected {
        border-color: #00ff88;
        background: #00ff88;
    }

    .preview-checkbox {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #888888;
        font-size: 0.8rem;
        margin-bottom: 0.8rem;
    }

    .preview-checkbox-square {
        width: 14px;
        height: 14px;
        border: 2px solid #2a2a2a;
        border-radius: 4px;
        display: inline-block;
    }

    .preview-checkbox-square.checked {
        background: #00ff88;
        border-color: #00ff88;
    }

    .preview-textarea {
        background: #111111;
        border: 1px solid #1f1f1f;
        border-radius: 6px;
        padding: 0.6rem;
        color: #888888;
        font-size: 0.8rem;
        width: 100%;
        height: 60px;
        margin-bottom: 0.8rem;
        resize: none;
    }

    .preview-select {
        background: #111111;
        border: 1px solid #1f1f1f;
        border-radius: 6px;
        padding: 0.6rem;
        color: #888888;
        font-size: 0.8rem;
        width: 100%;
        margin-bottom: 0.8rem;
    }

    .form-card-wrapper {
        transition: transform 0.2s ease;
    }

    .form-card-wrapper:hover {
        transform: translateY(-4px);
    }

    .form-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .form-type-link {
        margin-top: auto;
    }
</style>
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
                        <a href="<?php echo e(route('Home.library.ApplicationForm')); ?>" class="category-link">
                            <span>Application Forms</span>
                            <span class="category-count">6</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Contact Forms</span>
                            <span class="category-count">12</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Donation Forms</span>
                            <span class="category-count">8</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Feedback Forms</span>
                            <span class="category-count">9</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Order Forms</span>
                            <span class="category-count">7</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Registration Forms</span>
                            <span class="category-count">8</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Request Forms</span>
                            <span class="category-count">5</span>
                        </a>
                        <a href="#" class="category-link">
                            <span>Signup Forms</span>
                            <span class="category-count">6</span>
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
                            <span class="preview-label">Application Form</span>
                            <div class="preview-field">John Doe</div>
                            <div class="preview-field">john@email.com</div>
                            <div class="preview-field">(555) 123-4567</div>
                            <div class="preview-row">
                                <div class="preview-field">City</div>
                                <div class="preview-field">State</div>
                            </div>
                            <div class="preview-button">Apply Now</div>
                        </div>
                        
                        <div class="form-type-link">
                            <div class="form-card-header">
                                <span class="form-badge">Application Forms</span>
                            </div>
                            <a href="<?php echo e(route('Home.library.ApplicationForm')); ?>" class="view-more-link">
                                View 6 templates
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
                            <span class="preview-label">Contact Form</span>
                            <div class="preview-field">Your Name</div>
                            <div class="preview-field">your@email.com</div>
                            <div class="preview-textarea">Your message here...</div>
                            <div class="preview-button">Send Message</div>
                        </div>
                        
                        <div class="form-type-link">
                            <div class="form-card-header">
                                <span class="form-badge">Contact Forms</span>
                            </div>
                            <a href="#" class="view-more-link">
                                View 12 templates
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
                            <span class="preview-label">Donation Form</span>
                            <div class="preview-field">Full Name</div>
                            <div class="preview-field">email@example.com</div>
                            <div class="preview-row">
                                <div class="preview-field">$25</div>
                                <div class="preview-field">$50</div>
                                <div class="preview-field">$100</div>
                            </div>
                            <div class="preview-field">Custom amount</div>
                            <div class="preview-button">Donate Now</div>
                        </div>
                        
                        <div class="form-type-link">
                            <div class="form-card-header">
                                <span class="form-badge">Donation Forms</span>
                            </div>
                            <a href="#" class="view-more-link">
                                View 8 templates
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
                            <span class="preview-label">Feedback Form</span>
                            <div class="preview-field">Your Name</div>
                            <div class="preview-select">
                                <span>Select rating ▼</span>
                            </div>
                            <div class="preview-radio-group">
                                <span class="preview-radio">
                                    <span class="preview-radio-dot selected"></span> 5
                                </span>
                                <span class="preview-radio">
                                    <span class="preview-radio-dot"></span> 4
                                </span>
                                <span class="preview-radio">
                                    <span class="preview-radio-dot"></span> 3
                                </span>
                            </div>
                            <div class="preview-textarea">Your feedback...</div>
                            <div class="preview-button">Submit Feedback</div>
                        </div>
                        
                        <div class="form-type-link">
                            <div class="form-card-header">
                                <span class="form-badge">Feedback Forms</span>
                            </div>
                            <a href="#" class="view-more-link">
                                View 9 templates
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
                            <span class="preview-label">Order Form</span>
                            <div class="preview-row">
                                <div class="preview-field">Product</div>
                                <div class="preview-field">Qty</div>
                            </div>
                            <div class="preview-row">
                                <div class="preview-field">Size</div>
                                <div class="preview-field">Color</div>
                            </div>
                            <div class="preview-field">Email address</div>
                            <div class="preview-checkbox">
                                <span class="preview-checkbox-square checked"></span>
                                Same as shipping
                            </div>
                            <div class="preview-button">Place Order</div>
                        </div>
                        
                        <div class="form-type-link">
                            <div class="form-card-header">
                                <span class="form-badge">Order Forms</span>
                            </div>
                            <a href="#" class="view-more-link">
                                View 7 templates
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
                            <span class="preview-label">Registration Form</span>
                            <div class="preview-field">Username</div>
                            <div class="preview-field">Email</div>
                            <div class="preview-field">Password</div>
                            <div class="preview-field">Confirm password</div>
                            <div class="preview-checkbox">
                                <span class="preview-checkbox-square"></span>
                                Accept terms
                            </div>
                            <div class="preview-button">Register</div>
                        </div>
                        
                        <div class="form-type-link">
                            <div class="form-card-header">
                                <span class="form-badge">Registration Forms</span>
                            </div>
                            <a href="#" class="view-more-link">
                                View 8 templates
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
                            <span class="preview-label">Request Form</span>
                            <div class="preview-field">Full Name</div>
                            <div class="preview-field">Email</div>
                            <div class="preview-select">
                                <span>Request type ▼</span>
                            </div>
                            <div class="preview-textarea">Describe your request...</div>
                            <div class="preview-button">Submit Request</div>
                        </div>
                        
                        <div class="form-type-link">
                            <div class="form-card-header">
                                <span class="form-badge">Request Forms</span>
                            </div>
                            <a href="#" class="view-more-link">
                                View 5 templates
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Signup Form Card -->
                <div class="form-card-wrapper">
                    <div class="form-card">
                        <div class="form-preview">
                            <span class="preview-label">Signup Form</span>
                            <div class="preview-field">Full name</div>
                            <div class="preview-field">Email</div>
                            <div class="preview-field">Password</div>
                            <div class="preview-checkbox">
                                <span class="preview-checkbox-square checked"></span>
                                Subscribe to newsletter
                            </div>
                            <div class="preview-button">Sign Up</div>
                        </div>
                        
                        <div class="form-type-link">
                            <div class="form-card-header">
                                <span class="form-badge">Signup Forms</span>
                            </div>
                            <a href="#" class="view-more-link">
                                View 6 templates
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\Library\htmlTemplates.blade.php ENDPATH**/ ?>