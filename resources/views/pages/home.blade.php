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
                            <span class="code-badge">Test it now</span>
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
                        <div class="test-form" id="testFormContainer" style="display: none;">
                            <div class="test-form-header">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 12H4M12 4v16"/>
                                </svg>
                                <h4>Test your endpoint</h4>
                            </div>
                            <form id="heroTestForm" class="mini-test-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="test-form-row">
                                    <input type="text" name="name" placeholder="Your Name" required>
                                </div>
                                <div class="test-form-row">
                                    <input type="email" name="email" placeholder="Your Email" required>
                                </div>
                                <div class="test-form-row">
                                    <textarea name="message" placeholder="Test message" rows="2" required></textarea>
                                </div>
                                <button type="submit" class="btn-submit-mini">
                                    <span>Send Test Message</span>
                                </button>
                            </form>
                            <div id="testResponse" class="test-response"></div>
                        </div>
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

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="card cta-card">
            <h2>Ready to simplify your forms?</h2>
            <p>Join thousands of developers who trust 000form for their static sites. Forever free, no credit card required.</p>
            <a href="{{ route('signup') }}" class="btn btn-primary btn-lg">Get Started Free</a>
        </div>
    </div>
</section>

@endsection

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

        // Get app URL from config
        const appUrl = '{{ config('app.url') }}';

        // Update email in code snippet
        heroEmail.addEventListener('input', function() {
            const email = this.value.trim();
            if (email && email.includes('@')) {
                heroEmailPlaceholder.textContent = email;
                heroEmailPlaceholder.classList.add('email-highlight');
            } else {
                heroEmailPlaceholder.textContent = 'your-email@example.com';
            }
        });

        // Copy code functionality
        heroCopyBtn.addEventListener('click', function() {
            // Get the code content and replace placeholder with actual email if available
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

        // Verify email
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

            // Disable verify button and show loading
            heroVerifyBtn.disabled = true;
            const btnText = heroVerifyBtn.querySelector('.btn-text');
            const btnSpinner = heroVerifyBtn.querySelector('.btn-spinner');
            
            if (btnText) btnText.style.display = 'none';
            if (btnSpinner) btnSpinner.style.display = 'inline';
            
            showStatus('Sending verification email...', 'pending');

            // Send verification request
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

        // Poll for verification status
        function pollVerification(email) {
            let attempts = 0;
            const maxAttempts = 40; // 2 minutes (3s * 40)
            
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
                        
                        // Save to localStorage
                        localStorage.setItem('verified_email', email);
                        
                        // Update UI
                        showStatus('✅ Email verified! You can now test the form.', 'verified');
                        
                        const btnText = heroVerifyBtn.querySelector('.btn-text');
                        const btnSpinner = heroVerifyBtn.querySelector('.btn-spinner');
                        
                        if (btnText) {
                            btnText.textContent = '✓ Verified';
                            btnText.style.display = 'inline';
                        }
                        if (btnSpinner) btnSpinner.style.display = 'none';
                        
                        heroVerifyBtn.classList.add('verified');
                        heroVerifyBtn.disabled = false;
                        
                        // Show test form with animation
                        testFormContainer.style.display = 'block';
                        testFormContainer.style.animation = 'fadeIn 0.5s ease';
                        
                        // Update placeholder to show verified email
                        heroEmailPlaceholder.textContent = email;
                    }
                })
                .catch(error => {
                    console.error('Polling error:', error);
                });
            }, 3000);
        }

        // Reset verify button
        function resetVerifyButton() {
            heroVerifyBtn.disabled = false;
            const btnText = heroVerifyBtn.querySelector('.btn-text');
            const btnSpinner = heroVerifyBtn.querySelector('.btn-spinner');
            
            if (btnText) btnText.style.display = 'inline';
            if (btnSpinner) btnSpinner.style.display = 'none';
            
            heroVerifyBtn.classList.remove('verified');
        }

        // Show status message
        function showStatus(message, type) {
            heroEmailStatus.textContent = message;
            heroEmailStatus.className = 'status-message ' + type;
        }

        // Handle test form submission
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

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="btn-spinner">⟳</span> Sending...';
            testResponse.textContent = '';
            testResponse.className = 'test-response';

            // Send test submission
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
                    
                    // Show success message and clear after 5 seconds
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

        // Check if email was previously verified (from localStorage)
        const savedEmail = localStorage.getItem('verified_email');
        if (savedEmail) {
            heroEmail.value = savedEmail;
            heroEmailPlaceholder.textContent = savedEmail;
            
            // Check verification status
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

        // Add fade animation if not exists
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