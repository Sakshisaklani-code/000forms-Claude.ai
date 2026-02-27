

<?php $__env->startSection('title', '000form - Free Form Backend for Your Website'); ?>

<?php $__env->startSection('content'); ?>


<section class="hero">
    <div class="hero-bg">
        <div class="hero-gradient hero-gradient-1"></div>
        <div class="hero-gradient hero-gradient-2"></div>
        <div class="hero-grid"></div>
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
        </div>
    </div>

    <!-- Two Options Section -->
    <section class="options-section">
        <div class="container">
            <div class="options-label animate-fade-in">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Choose your path
            </div>

            <div class="options-grid">
                <!-- Option A: Quick Use -->
                <div class="opt-card opt-card--quick animate-scale-in">
                    <div class="opt-card__glow"></div>
                    
                    <div class="opt-card__head">
                        <div class="opt-tag opt-tag--green">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                            </svg>
                            Quick Start
                        </div>
                        <h3>Use it instantly — no account needed</h3>
                        <p>Verify your email once and get a personal endpoint that forwards submissions straight to your inbox.</p>
                    </div>

                    <!-- Code Block -->
                    <div class="opt-code">
                        <div class="opt-code__header">
                            <div class="opt-code__dots">
                                <span class="opt-code__dot opt-code__dot--red"></span>
                                <span class="opt-code__dot opt-code__dot--yellow"></span>
                                <span class="opt-code__dot opt-code__dot--green"></span>
                            </div>
                            <span class="opt-code__filename">index.html</span>
                            <button class="opt-code__copy" id="codeCopyBtn">                                
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                <span id="copyLabel">Copy</span>
                            </button>
                        </div>
                        
                        <div class="opt-code__body">
                            <pre><span class="token-tag">&lt;form</span> <span class="token-attr">action</span>=<span class="token-string">"<?php echo e(config('app.url')); ?>/f/<span id="heroEmailPlaceholder" class="token-variable">your-email@example.com</span>"</span><span class="token-attr">method</span>=<span class="token-string">"POST"</span><span class="token-tag">&gt;</span>
    <span class="token-tag">&lt;input</span> <span class="token-attr">type</span>=<span class="token-string">"text"</span> <span class="token-attr">name</span>=<span class="token-string">"name"</span> <span class="token-attr">placeholder</span>=<span class="token-string">"Full name"</span> <span class="token-attr">required</span><span class="token-tag">&gt;</span>
    <span class="token-tag">&lt;input</span> <span class="token-attr">type</span>=<span class="token-string">"email"</span> <span class="token-attr">name</span>=<span class="token-string">"email"</span> <span class="token-attr">placeholder</span>=<span class="token-string">"Email address"</span> <span class="token-attr">required</span><span class="token-tag">&gt;</span>
    <span class="token-tag">&lt;textarea</span> <span class="token-attr">name</span>=<span class="token-string">"message"</span> <span class="token-attr">placeholder</span>=<span class="token-string">"Your message..."</span> 
    <span class="token-attr">rows</span>=<span class="token-string">"4"</span> <span class="token-attr">required</span><span class="token-tag">&gt;&lt;/textarea&gt;</span>
    <span class="token-tag">&lt;button</span> <span class="token-attr">type</span>=<span class="token-string">"submit"</span><span class="token-tag">&gt;</span>Send message<span class="token-tag">&lt;/button&gt;</span>
    <span class="token-tag">&lt;/form&gt;</span></pre>
                        </div>

                        <!-- Verify Section -->
                        <div class="opt-verify">
                            <div class="opt-verify__wrapper">
                                <div class="opt-verify__field">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                    <input type="email" id="heroEmail" placeholder="Enter your email to verify" autocomplete="email">
                                </div>
                                <button class="opt-verify__btn" id="heroVerifyBtn">
                                    <span class="btn-text">Verify email</span>
                                    <span class="btn-spinner" style="display:none">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <path d="M12 6v6l4 2"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                            <div class="opt-verify__status" id="heroEmailStatus"></div>
                        </div>
                    </div>
                </div>

                <!-- Option B: Full Dashboard -->
                <div class="opt-card opt-card--full animate-scale-in-delay">
                    <div class="opt-card__glow"></div>
                    
                    <div class="opt-card__head">
                        <div class="opt-tag opt-tag--blue">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <path d="M3 9h18M9 21V9"/>
                            </svg>
                            Full Access
                        </div>
                        <h3>Create an account — get the dashboard</h3>
                        <p>Manage all your endpoints in one place. Perfect for tracking, history, and control.</p>
                    </div>

                    <!-- Feature Grid -->
                    <div class="opt-features">
                        <div class="opt-feature">
                            <div class="opt-feature__icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="16"/>
                                    <line x1="8" y1="12" x2="16" y2="12"/>
                                </svg>
                            </div>
                            <div class="opt-feature__content">
                                <h4>Multiple endpoints</h4>
                                <p>Create separate endpoints for each form</p>
                            </div>
                        </div>

                        <div class="opt-feature">
                            <div class="opt-feature__icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                            </div>
                            <div class="opt-feature__content">
                                <h4>Submission history</h4>
                                <p>Browse, filter, and search everything</p>
                            </div>
                        </div>

                        <div class="opt-feature">
                            <div class="opt-feature__icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                                </svg>
                            </div>
                            <div class="opt-feature__content">
                                <h4>Analytics graphs</h4>
                                <p>Visualize submission trends</p>
                            </div>
                        </div>

                        <div class="opt-feature">
                            <div class="opt-feature__icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                            </div>
                            <div class="opt-feature__content">
                                <h4>CSV export</h4>
                                <p>Download data anytime</p>
                            </div>
                        </div>

                        <div class="opt-feature">
                            <div class="opt-feature__icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="10" y1="15" x2="10" y2="9"/>
                                    <line x1="14" y1="15" x2="14" y2="9"/>
                                </svg>
                            </div>
                            <div class="opt-feature__content">
                                <h4>Pause forms</h4>
                                <p>Stop submissions instantly</p>
                            </div>
                        </div>

                        <div class="opt-feature">
                            <div class="opt-feature__icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                            </div>
                            <div class="opt-feature__content">
                                <h4>Advanced search</h4>
                                <p>Find submissions instantly</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="opt-cta">
                        <a href="<?php echo e(route('signup')); ?>" class="opt-cta__btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="8.5" cy="7" r="4"/>
                                <line x1="20" y1="8" x2="20" y2="14"/>
                                <line x1="23" y1="11" x2="17" y2="11"/>
                            </svg>
                            Create free account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<!-- Features Section -->
<section class="features" id="features">
    <div class="container">
        <div class="section-header">
            <h2>Everything you need, nothing you don't</h2>
            <p>Simple, powerful form handling that just works</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <path d="M22 6l-10 7L2 6"/>
                    </svg>
                </div>
                <h4>Email notifications</h4>
                <p>Get instant email alerts for every submission. Reply directly from your inbox.</p>
            </div>

            <div class="feature-card">
                <div class="feature-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <h4>Spam protection</h4>
                <p>Built-in honeypot and smart filtering keep your inbox spam-free.</p>
            </div>

            <div class="feature-card">
                <div class="feature-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                </div>
                <h4>Instant setup</h4>
                <p>Create an endpoint in seconds. Just point your form to our URL.</p>
            </div>

            <div class="feature-card">
                <div class="feature-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <path d="M3 9h18M9 21V9"/>
                    </svg>
                </div>
                <h4>Dashboard</h4>
                <p>View and manage all submissions in one clean interface.</p>
            </div>

            <div class="feature-card">
                <div class="feature-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                </div>
                <h4>CSV export</h4>
                <p>Export your data anytime. Your submissions belong to you.</p>
            </div>

            <div class="feature-card">
                <div class="feature-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 18 22 12 16 6"/>
                        <polyline points="8 6 2 12 8 18"/>
                    </svg>
                </div>
                <h4>AJAX support</h4>
                <p>Submit forms without page reloads using JavaScript fetch.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works">
    <div class="container">
        <div class="section-header">
            <h2>Up and running in 3 simple steps</h2>
            <p>No complicated setup. No backend code. Just forms that work.</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step__number">1</div>
                <div class="step__content">
                    <h4>Create your endpoint</h4>
                    <p>Sign up and create a new form. We'll generate a unique URL for you.</p>
                </div>
            </div>

            <div class="step">
                <div class="step__number">2</div>
                <div class="step__content">
                    <h4>Point your form to us</h4>
                    <p>Update your HTML form's action attribute with your new endpoint URL.</p>
                </div>
            </div>

            <div class="step">
                <div class="step__number">3</div>
                <div class="step__content">
                    <h4>Receive submissions</h4>
                    <p>Get email notifications and manage everything in your dashboard.</p>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="<?php echo e(route('signup')); ?>" class="btn btn-primary btn-lg">
                Start sending forms today
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>  
/* ==========================================================================
   Hero Section - COMPLETELY REVISED FOR PROPER ALIGNMENT
   ========================================================================== */

/* Reset any global hero styles */
.hero {
    min-height: unset !important;
    height: auto !important;
    padding-top: 6rem !important;
    padding-bottom: 2rem !important;
    position: relative;
    display: block !important;
}

/* Center container */
.hero .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    width: 100%;
}

/* Hero content - perfectly centered */
.hero-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
    padding: 2rem 1rem 0rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

/* Badge - centered with proper spacing */
.hero-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 0.5rem 1.2rem 0.5rem 1rem;
    border-radius: 100px;
    background: rgba(0, 255, 136, 0.07);
    border: 1px solid rgba(0, 255, 136, 0.22);
    color: #00ff88;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    margin-bottom: 1.5rem;
    width: fit-content;
}

/* Title - centered */
.hero-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.03em;
    margin: 0 0 1.5rem;
    color: #fff;
    text-align: center;
}

.hero-title .highlight {
    background: linear-gradient(135deg, #00ff88, #78b4ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Description - centered with max-width */
.hero-description {
    font-size: clamp(1rem, 2vw, 1.2rem);
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.7);
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}

/* Subtle grid lines */
.hero-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
    background-size: 52px 52px;
    pointer-events: none;
    mask-image: radial-gradient(ellipse 70% 100% at 50% 0%, black 30%, transparent 100%);
}

/* Options Section - ensure it starts after hero */
.options-section {
    padding: 1rem 0 5rem;
    position: relative;
    margin-top: 1rem;
}

.options-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: rgba(255, 255, 255, 0.3);
    margin-bottom: 2rem;
}

.options-label svg {
    opacity: 0.5;
}

.options-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    align-items: stretch;
}

/* Cards */
.opt-card {
    position: relative;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(10px);
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.75rem;
    overflow: hidden;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.opt-card--quick {
    border: 1px solid rgba(0, 255, 136, 0.15);
    box-shadow: 0 8px 32px rgba(0, 255, 136, 0.05);
}

.opt-card--full {
    border: 1px solid rgba(120, 180, 255, 0.15);
    box-shadow: 0 8px 32px rgba(120, 180, 255, 0.05);
}

.opt-card:hover {
    transform: translateY(-2px);
}

.opt-card--quick:hover {
    border-color: rgba(0, 255, 136, 0.3);
    box-shadow: 0 12px 48px rgba(0, 255, 136, 0.1);
}

.opt-card--full:hover {
    border-color: rgba(120, 180, 255, 0.3);
    box-shadow: 0 12px 48px rgba(120, 180, 255, 0.1);
}

.opt-card__glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at center, rgba(255,255,255,0.03) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s;
    pointer-events: none;
}

.opt-card:hover .opt-card__glow {
    opacity: 1;
}

/* Card Header */
.opt-card__head h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.95);
    margin: 0.75rem 0 0.5rem;
    line-height: 1.3;
}

.opt-card__head p {
    font-size: 0.9rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.5);
    margin: 0;
}

/* Tags */
.opt-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 100px;
    backdrop-filter: blur(4px);
}

.opt-tag--green {
    background: rgba(0, 255, 136, 0.1);
    border: 1px solid rgba(0, 255, 136, 0.3);
    color: #00ff88;
}

.opt-tag--blue {
    background: rgba(120, 180, 255, 0.1);
    border: 1px solid rgba(120, 180, 255, 0.3);
    color: #78b4ff;
}

/* Code Block */
.opt-code {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.3);
}

/* ── FIX: was padding: 0rem 1rem — header had zero height ── */
.opt-code__header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.6rem 1rem;          /* ← vertical padding added */
    background: rgba(255, 255, 255, 0.03);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    min-height: 36px;              /* ← guarantees visible height */
}

.opt-code__dots {
    display: flex;
    gap: 6px;
    align-items: center;
}

.opt-code__dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}

.opt-code__dot--red { background: #ff5f57; }
.opt-code__dot--yellow { background: #febc2e; }
.opt-code__dot--green { background: #28c840; }

.opt-code__filename {
    flex: 1;
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.3);
    font-family: 'SF Mono', 'Fira Code', monospace;
}

/* Copy button */
.opt-code__copy {
    display: flex;
    align-items: center;
    gap: 4px;
    min-height: 24px!important;
    padding: 2px 10px;
    background: none;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 4px;
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.7rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    line-height: 1;
    white-space: nowrap;
    flex-shrink: 0;
}

.opt-code__copy:hover {
    border-color: rgba(255, 255, 255, 0.3);
    color: rgba(255, 255, 255, 0.9);
    background: rgba(255, 255, 255, 0.05);
}

.opt-code__body {
    padding: 1.25rem;
    overflow-x: auto;
}

.opt-code__body pre {
    font-family: 'SF Mono', 'Fira Code', 'Courier New', monospace;
    font-size: 0.75rem;
    line-height: 1.8;
    margin: 0;
    color: rgba(255, 255, 255, 0.7);
}

.token-tag { color: #79c0ff; }
.token-attr { color: #ff7b72; }
.token-string { color: #a5d6ff; }
.token-variable { color: #00ff88; font-weight: 600; }

/* Verify Section */
.opt-verify {
    border-top: 1px solid rgba(0, 255, 136, 0.1);
    background: rgba(0, 255, 136, 0.02);
}

.opt-verify__wrapper {
    display: flex;
    gap: 8px;
    padding: 1rem;
}

.opt-verify__field {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 12px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.opt-verify__field:focus-within {
    border-color: #00ff88;
    box-shadow: 0 0 0 3px rgba(0, 255, 136, 0.1);
}

.opt-verify__field svg {
    stroke: rgba(255, 255, 255, 0.3);
}

.opt-verify__field input {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    padding: 10px 0;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.85rem;
}

.opt-verify__field input::placeholder {
    color: rgba(255, 255, 255, 0.2);
}

.opt-verify__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 0 20px;
    background: #00ff88;
    border: none;
    border-radius: 8px;
    color: #000;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
}

.opt-verify__btn:hover:not(:disabled) {
    background: #00e87a;
    transform: translateY(-1px);
    box-shadow: 0 4px 20px rgba(0, 255, 136, 0.3);
}

.opt-verify__btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.opt-verify__btn.verified {
    background: rgba(0, 255, 136, 0.1);
    color: #00ff88;
    border: 1px solid rgba(0, 255, 136, 0.3);
}

.opt-verify__status {
    padding: 0 1rem;
    font-size: 0.75rem;
    min-height: 2rem;
}

.opt-verify__status.verified { color: #00ff88; }
.opt-verify__status.error { color: #ff7070; }
.opt-verify__status.pending { color: rgba(255, 255, 255, 0.5); }

/* Benefits */
.opt-benefits {
    display: flex;
    gap: 1.5rem;
    padding-top: 0.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.opt-benefit {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
}

.opt-benefit svg {
    stroke: #00ff88;
}

/* Features Grid (Option B) */
.opt-features {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.opt-feature {
    display: flex;
    gap: 12px;
    padding: 0.75rem;
    border-radius: 10px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.opt-feature:hover {
    background: rgba(120, 180, 255, 0.05);
}

.opt-feature__icon {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 10px;
    background: rgba(120, 180, 255, 0.1);
    border: 1px solid rgba(120, 180, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #78b4ff;
}

.opt-feature__content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    margin: 0 0 2px;
}

.opt-feature__content p {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.4);
    margin: 0;
    line-height: 1.4;
}

/* CTA */
.opt-cta {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.opt-cta__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 1rem;
    background: #78b4ff;
    border: none;
    border-radius: 12px;
    color: #000;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.opt-cta__btn:hover {
    background: #5fa0ff;
    transform: translateY(-1px);
    box-shadow: 0 4px 24px rgba(120, 180, 255, 0.3);
}

.opt-cta__note {
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.25);
    margin: 0;
}

/* Features Section */
.features {
    padding: 5rem 0;
    background: linear-gradient(to bottom, transparent, rgba(0, 255, 136, 0.02));
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-top: 3rem;
}

.feature-card {
    padding: 2rem 1.5rem;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.feature-card:hover {
    transform: translateY(-4px);
    border-color: rgba(0, 255, 136, 0.2);
    box-shadow: 0 12px 40px rgba(0, 255, 136, 0.1);
}

.feature-card__icon {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    background: rgba(0, 255, 136, 0.1);
    border: 1px solid rgba(0, 255, 136, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    color: #00ff88;
}

.feature-card h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.95);
    margin: 0 0 0.5rem;
}

.feature-card p {
    font-size: 0.9rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.5);
    margin: 0;
}

/* How It Works */
.how-it-works {
    padding: 5rem 0;
}

.steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 3rem;
    margin: 3rem 0 4rem;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.step__number {
    width: 60px;
    height: 60px;
    border-radius: 30px;
    background: linear-gradient(135deg, rgba(0, 255, 136, 0.1), transparent);
    border: 1px solid rgba(0, 255, 136, 0.3);
    color: #00ff88;
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.step__content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.95);
    margin: 0 0 0.5rem;
}

.step__content p {
    font-size: 0.9rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.5);
    margin: 0;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 0.75rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-primary {
    background: #00ff88;
    color: #000;
}

.btn-primary:hover {
    background: #00e87a;
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0, 255, 136, 0.3);
}

.btn-lg {
    padding: 1rem 2.5rem;
    font-size: 1rem;
}

/* Section Headers */
.section-header {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.section-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.95);
    margin: 0 0 1rem;
}

.section-header p {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.5);
    margin: 0;
}

.text-center {
    text-align: center;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out;
}

.animate-slide-up {
    animation: slideUp 0.6s ease-out;
}

.animate-slide-up-delay {
    animation: slideUp 0.6s ease-out 0.2s both;
}

.animate-scale-in {
    animation: scaleIn 0.5s ease-out;
}

.animate-scale-in-delay {
    animation: scaleIn 0.5s ease-out 0.1s both;
}

/* Responsive */
@media (max-width: 1024px) {
    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 820px) {
    .hero {
        padding-top: 5rem !important;
    }
    
    .hero-content {
        padding: 1.5rem 1rem 2rem;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .options-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .steps {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .opt-features {
        grid-template-columns: 1fr;
    }
    
    .opt-benefits {
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .opt-verify__wrapper {
        flex-direction: column;
    }
    
    .opt-verify__btn {
        padding: 0.75rem;
        width: 100%;
    }
}

@media (max-width: 480px) {
    .hero .container {
        padding: 0 1rem;
    }
    
    .hero-content {
        padding: 1rem 0.5rem 1.5rem;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
    
    .opt-card {
        padding: 1.5rem;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroEmail = document.getElementById('heroEmail');
    const heroPlaceholder = document.getElementById('heroEmailPlaceholder');
    const heroVerifyBtn = document.getElementById('heroVerifyBtn');
    const heroStatus = document.getElementById('heroEmailStatus');
    const copyBtn = document.getElementById('codeCopyBtn');
    const copyLabel = document.getElementById('copyLabel');
    let pollInterval = null;

    // Live email preview
    heroEmail?.addEventListener('input', function() {
        const email = this.value.trim();
        heroPlaceholder.textContent = email && email.includes('@') ? email : 'your-email@example.com';
    });

    // Copy code
    copyBtn?.addEventListener('click', async function() {
        const code = document.querySelector('.opt-code__body pre').innerText;
        
        try {
            await navigator.clipboard.writeText(code);
            copyLabel.textContent = 'Copied!';
            copyBtn.style.color = '#00ff88';
            copyBtn.style.borderColor = 'rgba(0, 255, 136, 0.4)';
            
            setTimeout(() => {
                copyLabel.textContent = 'Copy';
                copyBtn.style.color = '';
                copyBtn.style.borderColor = '';
            }, 2000);
        } catch (err) {
            console.error('Failed to copy:', err);
        }
    });

    // Verify email
    heroVerifyBtn?.addEventListener('click', function() {
        const email = heroEmail.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email || !emailRegex.test(email)) {
            setStatus('Please enter a valid email address', 'error');
            heroEmail.focus();
            return;
        }

        // Disable button and show spinner
        heroVerifyBtn.disabled = true;
        heroVerifyBtn.querySelector('.btn-text').style.display = 'none';
        heroVerifyBtn.querySelector('.btn-spinner').style.display = 'inline';
        setStatus('Sending verification email...', 'pending');

        // Send verification
        fetch('<?php echo e(route("playground.verify")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                setStatus('✅ Check your inbox — click the verification link', 'pending');
                startPolling(email);
            } else {
                setStatus(data.message || 'Failed to send verification email', 'error');
                resetButton();
            }
        })
        .catch(() => {
            setStatus('Network error. Please try again.', 'error');
            resetButton();
        });
    });

    function startPolling(email) {
        let attempts = 0;
        const maxAttempts = 40;
        
        if (pollInterval) clearInterval(pollInterval);
        
        pollInterval = setInterval(() => {
            attempts++;
            
            if (attempts > maxAttempts) {
                clearInterval(pollInterval);
                setStatus('Verification timed out. Please try again.', 'error');
                resetButton();
                return;
            }

            fetch('<?php echo e(route("playground.check-verified")); ?>?email=' + encodeURIComponent(email))
                .then(response => response.json())
                .then(data => {
                    if (data.verified) {
                        clearInterval(pollInterval);
                        
                        // Save to localStorage and update UI
                        localStorage.setItem('verified_email', email);
                        heroPlaceholder.textContent = email;
                        
                        // Update button
                        heroVerifyBtn.disabled = false;
                        heroVerifyBtn.querySelector('.btn-text').textContent = '✓ Verified';
                        heroVerifyBtn.querySelector('.btn-text').style.display = 'inline';
                        heroVerifyBtn.querySelector('.btn-spinner').style.display = 'none';
                        heroVerifyBtn.classList.add('verified');
                        
                        setStatus('✅ Verified! Your endpoint is ready — copy the code above', 'verified');
                    }
                })
                .catch(() => {});
        }, 3000);
    }

    function resetButton() {
        heroVerifyBtn.disabled = false;
        heroVerifyBtn.querySelector('.btn-text').style.display = 'inline';
        heroVerifyBtn.querySelector('.btn-spinner').style.display = 'none';
    }

    function setStatus(message, type) {
        heroStatus.textContent = message;
        heroStatus.className = 'opt-verify__status ' + type;
    }

    // Restore verified state
    const savedEmail = localStorage.getItem('verified_email');
    if (savedEmail && heroEmail) {
        heroEmail.value = savedEmail;
        heroPlaceholder.textContent = savedEmail;
        
        // Check if still verified
        fetch('<?php echo e(route("playground.check-verified")); ?>?email=' + encodeURIComponent(savedEmail))
            .then(response => response.json())
            .then(data => {
                if (data.verified) {
                    setStatus('✅ Verified! Your endpoint is ready', 'verified');
                    heroVerifyBtn.querySelector('.btn-text').textContent = '✓ Verified';
                    heroVerifyBtn.classList.add('verified');
                }
            })
            .catch(() => {});
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000form\resources\views/pages/home.blade.php ENDPATH**/ ?>