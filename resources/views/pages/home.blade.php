@extends('layouts.app')

@section('title', '000form - Free Form Backend for Your Website')

@section('content')

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

            {{-- ── TWO WAYS TO USE 000form ── --}}
                <div class="usage-paths">
                    <p class="usage-paths__label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Two ways to use 000form :
                    </p>
                    <div class="usage-paths__grid">

                        <!-- ① Instant — no account -->
                        <div class="usage-path">
                            <div class="usage-path__eyebrow">
                                Option 1 &nbsp;·&nbsp; No account needed
                            </div>
                            <p class="usage-path__body">
                                Verify your email once and instantly get a personal endpoint.
                                Point any HTML form's <code>action</code> to it — submissions
                                land straight in your inbox. That's it.
                            </p>
                            <ol class="usage-path__steps">
                                <li>Enter your email in the code block below &amp; Verify</li>
                                <li>Click the confirmation link we email you</li>
                                <li>Your endpoint is live: <code>/f/you@email.com</code></li>
                            </ol>
                            <span class="usage-path__hint">↓ Scroll down to try it right now</span>
                        </div>

                        <div class="usage-paths__or">or</div>

                        <!-- ② Full dashboard -->
                        <div class="usage-path">
                            <div class="usage-path__eyebrow">
                                Option 2 &nbsp;·&nbsp; Register account
                            </div>
                            <p class="usage-path__body">
                                Create a free account to manage multiple forms, browse full
                                submission history and track everything in one place.
                            </p>
                            <ol class="usage-path__steps">
                                <li>Sign up — takes 30 seconds, no card required</li>
                                <li>Create a form and grab its unique endpoint</li>
                                <li>View, search submission from the dashboard</li>
                            </ol>
                            <a href="{{ route('signup') }}" class="usage-path__cta">
                                Create your free account
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>

                    </div>
                </div>
            {{-- ── END TWO WAYS ── --}}

            <div class="hero-actions">
                <a href="{{ route('signup') }}" class="btn btn-primary btn-lg">
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
                        <div class="code-header-left">
                            <span class="code-lang">HTML</span>
                        </div>
                        <div class="code-header-right">
                            <div class="email-verify-wrapper">
                                <div class="email-input-group">
                                    <svg class="email-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                    <input type="email" id="heroEmail" class="email-input" placeholder="your@email.com">
                                </div>
                                <button class="verify-btn" id="heroVerifyBtn">
                                    <span class="btn-text">Verify</span>
                                    <span class="btn-spinner" style="display: none;">⟳</span>
                                </button>
                                <button class="copy-btn" id="heroCopyBtn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                    <span class="copy-text">Copy</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="code-content">
                        <div class="code-scroll">
                            <pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"{{ config('app.url') }}/f/<span id="heroEmailPlaceholder" class="email-highlight">your-email@example.com</span>"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
    <span class="tag">&lt;div</span> <span class="attr">class</span>=<span class="string">"form-row"</span><span class="tag">&gt;</span>
        <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"name"</span> <span class="attr">placeholder</span>=<span class="string">"Full Name"</span> <span class="attr">required</span><span class="tag">&gt;</span>
        <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span> <span class="attr">placeholder</span>=<span class="string">"Email"</span> <span class="attr">required</span><span class="tag">&gt;</span>
    <span class="tag">&lt;/div&gt;</span>
    <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your Message"</span> <span class="attr">rows</span>=<span class="string">"4"</span> <span class="attr">required</span><span class="tag">&gt;&lt;/textarea&gt;</span>
    <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
                        </div>
                    </div>
                    <div class="code-footer">
                        <div class="status-message" id="heroEmailStatus"></div>
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
            <a href="{{ route('signup') }}" class="btn btn-primary btn-lg">Create Your First Form</a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ─── Two Ways to Use — Brighter with #00ff88 Theme ─── */

.usage-paths {
    margin: 2rem 0 2.5rem;
}

.usage-paths__label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.75rem;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    font-weight: 600;
    color: #00ff88;
    margin-bottom: 1rem;
}

.usage-paths__label svg {
    stroke: #00ff88;
}

.usage-paths__grid {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: stretch;
    gap: 0;
    border: 1px solid rgba(0, 255, 136, 0.3);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 255, 136, 0.15);
}

/* Divider */
.usage-paths__or {
    display: flex;
    align-items: center;
    justify-content: center;
    writing-mode: horizontal-tb;
    padding: 0 1rem;
    font-size: 0.7rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    font-weight: 700;
    color: #00ff88;
    position: relative;
}

.usage-paths__or::before,
.usage-paths__or::after {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 1px;
    height: calc(50% - 14px);
    background: rgba(0, 255, 136, 0.3);
}

.usage-paths__or::before { top: 0; }
.usage-paths__or::after  { bottom: 0; }

/* Each path card */
.usage-path {
    padding: 1.5rem 1.75rem;
}

.usage-path:first-child {
    border-right: 1px solid rgba(0, 255, 136, 0.3);
}

.usage-path__eyebrow {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #00ff88;
    margin-bottom: 0.6rem;
}

.usage-path__eyebrow svg {
    stroke: currentColor;
}

.usage-path__body {
    font-size: 0.82rem;
    line-height: 1.65;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 1rem;
}

.usage-path__body code {
    font-size: 0.78rem;
    background: rgba(0, 255, 136, 0.15);
    padding: 0.15rem 0.3rem;
    border-radius: 4px;
    color: #00ff88;
    border: 1px solid rgba(0, 255, 136, 0.3);
}

/* Numbered steps */
.usage-path__steps {
    list-style: none;
    padding: 0;
    margin: 0 0 1.1rem;
    counter-reset: up-step;
}

.usage-path__steps li {
    counter-increment: up-step;
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    font-size: 0.8rem;
    line-height: 1.5;
    color: rgba(255, 255, 255, 0.9);
    padding: 0.35rem 0;
    border-bottom: 1px solid rgba(0, 255, 136, 0.15);
}

.usage-path__steps li:last-child {
    border-bottom: none;
}

.usage-path__steps li::before {
    content: counter(up-step);
    min-width: 20px;
    height: 20px;
    border-radius: 50%;
    background: rgba(0, 255, 136, 0.2);
    border: 1px solid #00ff88;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.62rem;
    font-weight: 700;
    flex-shrink: 0;
    margin-top: 1px;
    color: white;
}

/* Hint text (option 1) */
.usage-path__hint {
    display: inline-block;
    font-size: 0.76rem;
    color: #00ff88;
    font-style: italic;
}

/* CTA link (option 2) */
.usage-path__cta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    padding: 7px 16px;
    border-radius: 8px;
    border: 1px solid #00ff88;
    background: rgba(0, 255, 136, 0.15);
    color: white;
    transition: all 0.2s ease;
}

.usage-path__cta:hover {
    background: #00ff88;
    border-color: #00ff88;
    color: #000000;
    gap: 10px;
    box-shadow: 0 0 15px rgba(0, 255, 136, 0.5);
}

.usage-path__cta svg {
    stroke: currentColor;
}

/* Responsive */
@media (max-width: 680px) {
    .usage-paths__grid {
        grid-template-columns: 1fr;
    }

    .usage-path:first-child {
        border-right: none;
        border-bottom: 1px solid rgba(0, 255, 136, 0.3);
    }

    .usage-paths__or {
        writing-mode: horizontal-tb;
        padding: 0.6rem 1.5rem;
        flex-direction: row;
    }

    .usage-paths__or::before,
    .usage-paths__or::after {
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        width: calc(50% - 18px);
        height: 1px;
        background: rgba(0, 255, 136, 0.3);
    }

    .usage-paths__or::before { left: 0; }
    .usage-paths__or::after  { left: auto; right: 0; }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const heroEmail = document.getElementById('heroEmail');
        const heroVerifyBtn = document.getElementById('heroVerifyBtn');
        const heroEmailStatus = document.getElementById('heroEmailStatus');
        const heroEmailPlaceholder = document.getElementById('heroEmailPlaceholder');
        const heroCopyBtn = document.getElementById('heroCopyBtn');
        const testFormContainer = document.getElementById('testFormContainer');
        const heroTestForm = document.getElementById('heroTestForm');
        const testResponse = document.getElementById('testResponse');
        
        let isVerified = false;
        let verifiedEmail = '';
        let pollInterval = null;

        const appUrl = '{{ config('app.url') }}';

        heroEmail.addEventListener('input', function() {
            const email = this.value.trim();
            if (email && email.includes('@')) {
                heroEmailPlaceholder.textContent = email;
                heroEmailPlaceholder.classList.add('email-highlight');
            } else {
                heroEmailPlaceholder.textContent = 'your-email@example.com';
            }
        });

        heroCopyBtn.addEventListener('click', function() {
            let codeContent = document.querySelector('.code-content pre').innerText;
            const email = heroEmail.value.trim();
            
            if (email && email.includes('@')) {
                codeContent = codeContent.replace('your-email@example.com', email);
            }
            
            navigator.clipboard.writeText(codeContent).then(() => {
                const copyText = heroCopyBtn.querySelector('.copy-text');
                const originalText = copyText ? copyText.textContent : 'Copy';
                
                if (copyText) {
                    copyText.textContent = 'Copied!';
                } else {
                    heroCopyBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Copied!';
                }
                
                heroCopyBtn.classList.add('copied');
                setTimeout(() => {
                    if (copyText) {
                        copyText.textContent = originalText;
                    } else {
                        heroCopyBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copy';
                    }
                    heroCopyBtn.classList.remove('copied');
                }, 2000);
            }).catch(() => {
                showStatus('Failed to copy code', 'error');
            });
        });

        heroVerifyBtn.addEventListener('click', function() {
            const email = heroEmail.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email) {
                showStatus('Please enter an email address', 'error');
                heroEmail.focus();
                return;
            }
            if (!emailRegex.test(email)) {
                showStatus('Please enter a valid email address', 'error');
                heroEmail.focus();
                return;
            }

            heroVerifyBtn.disabled = true;
            const btnText = heroVerifyBtn.querySelector('.btn-text');
            const btnSpinner = heroVerifyBtn.querySelector('.btn-spinner');
            
            if (btnText) btnText.style.display = 'none';
            if (btnSpinner) btnSpinner.style.display = 'inline';
            
            showStatus('Sending verification email...', 'pending');

            fetch('{{ route("playground.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showStatus('✅ Verification email sent! Check your inbox and click the link.', 'pending');
                    pollVerification(email);
                } else {
                    showStatus(data.message || 'Failed to send verification', 'error');
                    resetVerifyButton();
                }
            })
            .catch(error => {
                console.error('Verification error:', error);
                showStatus('Network error. Please try again.', 'error');
                resetVerifyButton();
            });
        });

        function pollVerification(email) {
            let attempts = 0;
            const maxAttempts = 40;
            
            if (pollInterval) {
                clearInterval(pollInterval);
            }
            
            pollInterval = setInterval(() => {
                attempts++;
                
                if (attempts > maxAttempts) {
                    clearInterval(pollInterval);
                    showStatus('Verification timed out. Please try again.', 'error');
                    resetVerifyButton();
                    return;
                }

                fetch('{{ route("playground.check-verified") }}?email=' + encodeURIComponent(email))
                .then(response => response.json())
                .then(data => {
                    if (data.verified) {
                        clearInterval(pollInterval);
                        isVerified = true;
                        verifiedEmail = email;
                        
                        localStorage.setItem('verified_email', email);
                        
                        showStatus('✅ Email verified! You can use the form now.', 'verified');
                        
                        const btnText = heroVerifyBtn.querySelector('.btn-text');
                        const btnSpinner = heroVerifyBtn.querySelector('.btn-spinner');
                        
                        if (btnText) {
                            btnText.textContent = '✓ Verified';
                            btnText.style.display = 'inline';
                        }
                        if (btnSpinner) btnSpinner.style.display = 'none';
                        
                        heroVerifyBtn.classList.add('verified');
                        heroVerifyBtn.disabled = false;
                        
                        testFormContainer.style.display = 'block';
                        testFormContainer.style.animation = 'fadeIn 0.5s ease';
                        
                        heroEmailPlaceholder.textContent = email;
                    }
                })
                .catch(error => {
                    console.error('Polling error:', error);
                });
            }, 3000);
        }

        function resetVerifyButton() {
            heroVerifyBtn.disabled = false;
            const btnText = heroVerifyBtn.querySelector('.btn-text');
            const btnSpinner = heroVerifyBtn.querySelector('.btn-spinner');
            
            if (btnText) btnText.style.display = 'inline';
            if (btnSpinner) btnSpinner.style.display = 'none';
            
            heroVerifyBtn.classList.remove('verified');
        }

        function showStatus(message, type) {
            heroEmailStatus.textContent = message;
            heroEmailStatus.className = 'status-message ' + type;
        }

        heroTestForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!isVerified) {
                testResponse.textContent = '⚠️ Please verify your email first.';
                testResponse.className = 'test-response error';
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const formData = new FormData(this);
            formData.append('recipient_email', verifiedEmail);

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="btn-spinner">⟳</span> Sending...';
            testResponse.textContent = '';
            testResponse.className = 'test-response';

            fetch('{{ route("playground.submit") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    testResponse.textContent = '✅ Test message sent! Check your inbox.';
                    testResponse.className = 'test-response success';
                    this.reset();
                    
                    setTimeout(() => {
                        testResponse.style.opacity = '0';
                        setTimeout(() => {
                            testResponse.style.opacity = '1';
                            testResponse.textContent = '';
                            testResponse.className = 'test-response';
                        }, 300);
                    }, 5000);
                } else {
                    testResponse.textContent = data.message || 'Failed to send test message.';
                    testResponse.className = 'test-response error';
                }
            })
            .catch(error => {
                console.error('Test submission error:', error);
                testResponse.textContent = 'Network error. Please try again.';
                testResponse.className = 'test-response error';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Send Test Message';
            });
        });

        const savedEmail = localStorage.getItem('verified_email');
        if (savedEmail) {
            heroEmail.value = savedEmail;
            heroEmailPlaceholder.textContent = savedEmail;
            
            fetch('{{ route("playground.check-verified") }}?email=' + encodeURIComponent(savedEmail))
            .then(response => response.json())
            .then(data => {
                if (data.verified) {
                    isVerified = true;
                    verifiedEmail = savedEmail;
                    showStatus('✅ Email verified! You can test the form.', 'verified');
                    
                    const btnText = heroVerifyBtn.querySelector('.btn-text');
                    if (btnText) btnText.textContent = '✓ Verified';
                    heroVerifyBtn.classList.add('verified');
                    testFormContainer.style.display = 'block';
                }
            });
        }

        if (!document.querySelector('#fadeAnimation')) {
            const style = document.createElement('style');
            style.id = 'fadeAnimation';
            style.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(style);
        }

        console.log('Hero section with verification loaded');
    });
</script>
@endpush