

<?php $__env->startSection('title', 'Form Playground'); ?>

<?php $__env->startSection('content'); ?>
<div class="playground-wrapper">
    <div class="container">

        
        <div class="playground-header">
            <div class="playground-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8zm4.292 0a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8z"/>
                </svg>
                Live Testing Tool
            </div>
            <h1 class="playground-title">Playground</h1>
            <p class="playground-subtitle">Build your form, preview it live, and test real email delivery — all in one place.</p>
        </div>

        
        <div class="playground-main">

            
            <div class="panel editor-panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8zm4.292 0a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8z"/>
                        </svg>
                        HTML Editor
                    </div>
                    <div class="editor-tabs">
                        <button class="tab-btn active" data-tab="code">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                <path d="M6.854 4.646a.5.5 0 0 1 0 .708L4.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0m2.292 0a.5.5 0 0 0 0 .708L11.793 8l-2.647 2.646a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708 0"/>
                            </svg>
                            HTML
                        </button>
                        <button class="tab-btn" data-tab="css">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1.5 0h13l-1.5 14.5-5.5 1.5-5.5-1.5z" opacity=".3"/>
                                <path d="M1.5 0h6.5v1H2.5L1.5 0zm11 0h-4.5v1h3.5l1-1zM8 10.5l-3.5-.5-.2-2h1l.1 1 2.6.4V10.5zm0-4H4.8l-.2-2H8V3H3.5l.5 7 4 .5V6.5z"/>
                            </svg>
                            CSS
                        </button>
                    </div>
                </div>

                
                <div class="tab-content active" id="tab-code">
                    <div class="editor-toolbar">
                        <span class="editor-lang">HTML</span>
                        <button class="copy-btn" id="copyHtml">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                                <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                            </svg>
                            Copy
                        </button>
                    </div>
                    <textarea id="htmlEditor" class="code-editor" spellcheck="false">&lt;!-- Paste this anywhere — replace YOUR@EMAIL.COM with your verified email --&gt;
&lt;form action="<?php echo e(config('app.url')); ?>/f/YOUR@EMAIL.COM" method="POST" class="preview-form"&gt;

    &lt;div class="form-row"&gt;
        &lt;div class="col"&gt;
            &lt;input type="text" name="name" placeholder="Full Name" required&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;input type="email" name="email" placeholder="Email Address" required&gt;
        &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class="form-group"&gt;
        &lt;textarea name="message" placeholder="Your Message" rows="6" required&gt;&lt;/textarea&gt;
    &lt;/div&gt;

    &lt;button type="submit" class="submit-btn"&gt;Submit Form&lt;/button&gt;

&lt;/form&gt;</textarea>
                </div>

                
                <div class="tab-content" id="tab-css">
                    <div class="editor-toolbar">
                        <span class="editor-lang">CSS</span>
                        <button class="copy-btn" id="copyCss">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                                <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                            </svg>
                            Copy
                        </button>
                    </div>
                    <textarea id="cssEditor" class="code-editor" spellcheck="false">.preview-form {
    max-width: 100%;
    font-family: sans-serif;
}

/* Two-column row */
.form-row {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.form-row .col {
    flex: 1;
    min-width: 0;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.4rem;
    font-weight: 500;
    color: #e5e7eb;
    font-size: 0.9rem;
}

.form-row input,
.form-group input,
.form-group textarea,
input[type="text"],
input[type="email"],
input[type="tel"],
input[type="url"],
textarea {
    width: 100%;
    padding: 0.65rem 0.9rem;
    border: 1px solid #2d2d2d;
    border-radius: 6px;
    font-size: 0.9rem;
    background: #1a1a1a;
    color: #ffffff;
    transition: border-color 0.2s;
    box-sizing: border-box;
}

.form-row input:focus,
.form-group input:focus,
.form-group textarea:focus,
input:focus,
textarea:focus {
    outline: none;
    border-color: #00ff88;
    box-shadow: 0 0 0 3px rgba(0,255,136,0.1);
}

input::placeholder,
textarea::placeholder {
    color: #555;
}

textarea {
    resize: vertical;
}

select {
    width: 100%;
    padding: 0.65rem 0.9rem;
    border: 1px solid #2d2d2d;
    border-radius: 6px;
    font-size: 0.9rem;
    background: #1a1a1a;
    color: #ffffff;
    box-sizing: border-box;
}

button[type="submit"],
.submit-btn {
    background: #00ff88;
    color: #050505;
    border: none;
    padding: 0.75rem 1.25rem;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    width: 100%;
    transition: all 0.2s;
    margin-top: 0.5rem;
}

button[type="submit"]:hover,
.submit-btn:hover {
    background: #00cc6a;
    transform: translateY(-1px);
}

@media (max-width: 480px) {
    .form-row { flex-direction: column; gap: 0.5rem; }
}</textarea>
                </div>
            </div>

            
            <div class="panel preview-panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                        Live Preview
                    </div>
                    <div class="preview-live-dot">
                        <span class="live-dot"></span> Live
                    </div>
                </div>

                <div class="preview-body">
                    
                    <div class="email-config-box">
                        <label for="recipientEmail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                            </svg>
                            Send submissions to:
                        </label>
                        <div class="email-row">
                            <input type="email" id="recipientEmail" class="email-input" placeholder="your@email.com" value="">
                            <button class="verify-btn" id="verifyEmailBtn">Verify</button>
                        </div>
                        <div id="emailStatus" class="email-status"></div>
                    </div>

                    
                    <div id="formPreview" class="preview-content">
                        
                    </div>

                    
                    <div id="responseMessage" class="response-message"></div>
                </div>
            </div>
        </div>

        
        <div class="how-it-works-panel">
            <div class="how-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                </svg>
                How it works
            </div>
            <div class="how-steps">
                <div class="how-step">
                    <span class="step-num">1</span>
                    <span>Enter your email and click <strong>Verify</strong> — we'll send a confirmation link</span>
                </div>
                <div class="how-step">
                    <span class="step-num">2</span>
                    <span>Edit the HTML (and CSS) on the left to design your form</span>
                </div>
                <div class="how-step">
                    <span class="step-num">3</span>
                    <span>Fill in and submit the preview form on the right</span>
                </div>
                <div class="how-step">
                    <span class="step-num">4</span>
                    <span>Submission details land in your inbox</span>
                </div>
            </div>
        </div>

    </div>
</div>


<div id="toast" class="toast"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>

/* ============================================
   Playground Page — uses global CSS variables
   ============================================ */

.playground-wrapper {
    background: var(--bg-primary);
    min-height: calc(100vh - 64px);
    padding: 3rem 0 4rem;
    font-family: var(--font-display);
}

/* ---- Header ---- */
.playground-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.playground-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.9rem;
    background: var(--accent-glow);
    border: 1px solid rgba(0,255,136,0.2);
    border-radius: 100px;
    font-size: 0.78rem;
    color: var(--accent);
    font-family: var(--font-mono);
    letter-spacing: 0.04em;
    margin-bottom: 1rem;
}

.playground-title {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.03em;
    margin-bottom: 0.5rem;
}

.playground-subtitle {
    font-size: 1.05rem;
    color: var(--text-secondary);
    max-width: 520px;
    margin: 0 auto;
}

/* ---- Main Grid ---- */
.playground-main {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    align-items: stretch;
}

/* ---- Panels ---- */
.panel {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: border-color 0.2s ease;
}

.panel:hover {
    border-color: var(--border-hover);
}

.panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.875rem 1.25rem;
    background: var(--bg-tertiary);
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
}

.panel-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-size: 0.95rem;
    color: var(--text-primary);
}

.panel-title svg {
    color: var(--accent);
}

/* ---- Editor Tabs ---- */
.editor-tabs {
    display: flex;
    gap: 0.25rem;
    background: var(--bg-primary);
    border-radius: 6px;
    padding: 3px;
}

.tab-btn {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--text-muted);
    background: transparent;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: var(--font-mono);
    transition: all 0.15s ease;
}

.tab-btn:hover {
    color: var(--text-secondary);
}

.tab-btn.active {
    background: var(--bg-tertiary);
    color: var(--accent);
}

/* ---- Tab Content ---- */
.tab-content {
    display: none;
    flex-direction: column;
    flex: 1;
}

.tab-content.active {
    display: flex;
}

/* ---- Editor Toolbar ---- */
.editor-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 1rem;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
}

.editor-lang {
    font-family: var(--font-mono);
    font-size: 0.7rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.copy-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.7rem;
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    border-radius: 5px;
    color: var(--text-muted);
    font-size: 0.78rem;
    font-family: var(--font-mono);
    cursor: pointer;
    transition: all 0.15s ease;
}

.copy-btn:hover {
    color: var(--accent);
    border-color: var(--accent);
}

.copy-btn.copied {
    color: var(--success);
    border-color: var(--success);
}

/* ---- Code Textarea ---- */
.code-editor {
    flex: 1;
    width: 100%;
    min-height: 480px;
    font-family: var(--font-mono);
    font-size: 13px;
    line-height: 1.65;
    padding: 1rem 1.25rem;
    background: var(--bg-primary);
    color: var(--text-secondary);
    border: none;
    resize: none;
    outline: none;
    white-space: pre;
    overflow: auto;
    tab-size: 2;
}

.code-editor:focus {
    color: var(--text-primary);
}

/* ---- Preview Panel ---- */
.preview-live-dot {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.75rem;
    color: var(--text-muted);
    font-family: var(--font-mono);
}

.live-dot {
    width: 7px;
    height: 7px;
    background: var(--accent);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; box-shadow: 0 0 0 0 var(--accent-glow); }
    50% { opacity: 0.7; box-shadow: 0 0 0 5px transparent; }
}

.preview-body {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    overflow-y: auto;
}

/* ---- Email Config ---- */
.email-config-box {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    flex-shrink: 0;
}

.email-config-box label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    color: var(--text-secondary);
    font-size: 0.82rem;
    font-weight: 500;
    margin-bottom: 0.6rem;
}

.email-row {
    display: flex;
    gap: 0.5rem;
}

.email-input {
    flex: 1;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 6px;
    padding: 0.55rem 0.85rem;
    color: var(--text-primary);
    font-size: 0.9rem;
    font-family: var(--font-mono);
    transition: all 0.2s ease;
    min-width: 0;
}

.email-input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
}

.email-input::placeholder { color: var(--text-muted); }

.verify-btn {
    padding: 0.55rem 1.1rem;
    background: var(--accent);
    color: var(--bg-primary);
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
    font-family: var(--font-display);
    flex-shrink: 0;
}

.verify-btn:hover {
    background: var(--text-primary);
    transform: translateY(-1px);
}

.verify-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.email-status {
    margin-top: 0.5rem;
    font-size: 0.8rem;
    min-height: 1rem;
}

.email-status.verified {
    color: var(--success);
}

.email-status.pending {
    color: var(--warning);
}

.email-status.error {
    color: var(--error);
}

/* ---- Form Preview Content ---- */
.preview-content {
    flex: 1;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1.25rem;
    min-height: 300px;
}

/* ---- Injected Form Styles ---- */
.preview-content .preview-form { max-width: 100%; }
.preview-content .form-group { margin-bottom: 1.1rem; }
.preview-content .form-group label {
    display: block;
    margin-bottom: 0.35rem;
    font-weight: 500;
    color: var(--text-secondary);
    font-size: 0.9rem;
}
.preview-content .form-group input,
.preview-content .form-group textarea {
    width: 100%;
    padding: 0.6rem 0.85rem;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 0.9rem;
    background: var(--bg-tertiary);
    color: var(--text-primary);
    font-family: var(--font-display);
    transition: all 0.2s;
}
.preview-content .form-group input:focus,
.preview-content .form-group textarea:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
}
.preview-content .form-group input::placeholder,
.preview-content .form-group textarea::placeholder { color: var(--text-muted); }
.preview-content .submit-btn {
    background: var(--accent);
    color: var(--bg-primary);
    border: none;
    padding: 0.7rem 1.25rem;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    width: 100%;
    font-family: var(--font-display);
    transition: all 0.2s ease;
}
.preview-content .submit-btn:hover {
    background: var(--text-primary);
    transform: translateY(-1px);
}
.preview-content .submit-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}
.preview-content .submit-btn.loading {
    position: relative;
    color: transparent;
}
.preview-content .submit-btn.loading::after {
    content: '';
    position: absolute;
    width: 1rem;
    height: 1rem;
    top: 50%; left: 50%;
    margin: -0.5rem 0 0 -0.5rem;
    border: 2px solid var(--bg-primary);
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* ---- Response Message ---- */
.response-message {
    display: none;
    padding: 0.85rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    flex-shrink: 0;
}
.response-message.show { display: block; }
.response-message.success {
    background: rgba(0,255,136,0.08);
    border: 1px solid rgba(0,255,136,0.2);
    color: var(--success);
}
.response-message.error {
    background: rgba(255,68,68,0.08);
    border: 1px solid rgba(255,68,68,0.2);
    color: var(--error);
}

/* ---- How It Works ---- */
.how-it-works-panel {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
}

.how-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.how-header svg { color: var(--accent); }

.how-steps {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
}

.how-step {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    font-size: 0.85rem;
    color: var(--text-secondary);
    line-height: 1.5;
}

.step-num {
    flex-shrink: 0;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--accent);
    color: var(--bg-primary);
    font-size: 0.72rem;
    font-weight: 700;
    border-radius: 50%;
    font-family: var(--font-mono);
    margin-top: 1px;
}

.how-step strong { color: var(--text-primary); }

/* ---- Toast ---- */
.toast {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-family: var(--font-mono);
    opacity: 0;
    pointer-events: none;
    transition: all 0.3s ease;
    z-index: 9999;
    white-space: nowrap;
}

.toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

/* ---- Responsive ---- */
@media (max-width: 900px) {
    .playground-main { grid-template-columns: 1fr; }
    .how-steps { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 540px) {
    .how-steps { grid-template-columns: 1fr; }
    .playground-title { font-size: 2.25rem; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       Elements
    ============================================================ */
    const htmlEditor      = document.getElementById('htmlEditor');
    const cssEditor       = document.getElementById('cssEditor');
    const formPreview     = document.getElementById('formPreview');
    const responseDiv     = document.getElementById('responseMessage');
    const recipientEmail  = document.getElementById('recipientEmail');
    const verifyBtn       = document.getElementById('verifyEmailBtn');
    const emailStatus     = document.getElementById('emailStatus');
    const toast           = document.getElementById('toast');

    let isVerified        = false;
    let injectedStyle     = null;
    let verifiedEmail     = localStorage.getItem('playground_verified_email') || '';

    /* ============================================================
       Tab Switching
    ============================================================ */
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const tab = btn.dataset.tab;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + tab).classList.add('active');
        });
    });

    /* ============================================================
       Copy Buttons
    ============================================================ */
    function setupCopy(btnId, getContent) {
        const btn = document.getElementById(btnId);
        if (!btn) return;
        btn.addEventListener('click', () => {
            navigator.clipboard.writeText(getContent()).then(() => {
                btn.innerHTML = '✓ Copied!';
                btn.classList.add('copied');
                setTimeout(() => {
                    btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16"><path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/><path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/></svg> Copy`;
                    btn.classList.remove('copied');
                }, 2000);
            }).catch(() => showToast('Failed to copy'));
        });
    }

    setupCopy('copyHtml', () => htmlEditor.value);
    setupCopy('copyCss',  () => cssEditor.value);

    /* ============================================================
       Live Preview — HTML + scoped CSS injection
    ============================================================ */
    function decodeHtml(html) {
        const t = document.createElement('textarea');
        t.innerHTML = html;
        return t.value;
    }

    function injectCss(css) {
        if (injectedStyle) injectedStyle.remove();
        try {
            const scoped = css.replace(/(^|\})\s*([^{@][^{]*)\{/g, (match, closing, selector) => {
                const scopedSelector = selector
                    .split(',')
                    .map(s => '.preview-content ' + s.trim())
                    .join(', ');
                return (closing || '') + ' ' + scopedSelector + ' {';
            });
            injectedStyle = document.createElement('style');
            injectedStyle.id = 'playground-user-css';
            injectedStyle.textContent = scoped;
            document.head.appendChild(injectedStyle);
        } catch(e) {}
    }

    function updatePreview() {
        const decoded = decodeHtml(htmlEditor.value);
        formPreview.innerHTML = decoded;
        injectCss(cssEditor.value);
        attachFormHandler();
    }

    let previewTimer;
    function scheduleUpdate() {
        clearTimeout(previewTimer);
        previewTimer = setTimeout(updatePreview, 250);
    }

    htmlEditor.addEventListener('input', scheduleUpdate);
    cssEditor.addEventListener('input', scheduleUpdate);
    updatePreview();

    /* ============================================================
       Email Verification Functions
    ============================================================ */
    
    function updateHtmlCodeWithEmail(email) {
        let currentHtml = htmlEditor.value;
        // Replace YOUR@EMAIL.COM or any email in the action attribute
        const actionRegex = /(action=["'].*\/f\/)([^"']+)(["'])/;
        const match = currentHtml.match(actionRegex);
        
        if (match) {
            // Update the email in the action attribute
            const newHtml = currentHtml.replace(actionRegex, `$1${email}$3`);
            htmlEditor.value = newHtml;
            
            // Also update the preview
            scheduleUpdate();
            
            // Highlight the change briefly
            const placeholder = document.getElementById('heroEmailPlaceholder');
            if (placeholder) {
                placeholder.textContent = email;
                placeholder.classList.add('email-highlight');
                setTimeout(() => {
                    placeholder.classList.remove('email-highlight');
                }, 1000);
            }
            
            showToast(`Email updated in HTML code`);
        }
    }

    function checkEmailVerification(email) {
        return fetch('<?php echo e(route("playground.check-verified")); ?>?email=' + encodeURIComponent(email), {
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.verified) {
                isVerified = true;
                verifiedEmail = email;
                localStorage.setItem('playground_verified_email', email);
                setEmailStatus('✅ Email verified! You can now submit the form.', 'verified');
                verifyBtn.innerHTML = '✓ Verified';
                verifyBtn.style.background = 'var(--success)';
                verifyBtn.disabled = false;
                
                // Update HTML code with verified email
                updateHtmlCodeWithEmail(email);
            } else {
                isVerified = false;
            }
            return data.verified;
        })
        .catch(() => {
            isVerified = false;
            return false;
        });
    }

    function setEmailStatus(msg, type) {
        emailStatus.textContent = msg;
        emailStatus.className = 'email-status' + (type ? ' ' + type : '');
    }

    function pollVerification(email) {
        let attempts = 0;
        const max = 40;
        
        if (window.verificationInterval) {
            clearInterval(window.verificationInterval);
        }
        
        setEmailStatus(`⏳ Verification email sent to ${email}. Check your inbox and click the link...`, 'pending');
        
        window.verificationInterval = setInterval(() => {
            attempts++;
            
            if (attempts > max) {
                clearInterval(window.verificationInterval);
                setEmailStatus('Verification timed out. Please try again.', 'error');
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = 'Verify';
                return;
            }

            checkEmailVerification(email).then(verified => {
                if (verified) {
                    clearInterval(window.verificationInterval);
                }
            });
        }, 3000);
    }

    /* ============================================================
       Verify Button Click Handler
    ============================================================ */
    verifyBtn.addEventListener('click', () => {
        const email = recipientEmail.value.trim();
        const emailRx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email) {
            setEmailStatus('Please enter an email address', 'error');
            recipientEmail.focus();
            return;
        }
        if (!emailRx.test(email)) {
            setEmailStatus('Enter a valid email address', 'error');
            recipientEmail.focus();
            return;
        }

        // Immediately update HTML code with the email being verified
        updateHtmlCodeWithEmail(email);

        verifyBtn.disabled = true;
        verifyBtn.innerHTML = 'Sending…';
        setEmailStatus('', '');

        fetch('<?php echo e(route("playground.verify")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                setEmailStatus(`✅ Verification email sent to ${email}! Check your inbox and click the link.`, 'pending');
                pollVerification(email);
            } else {
                setEmailStatus(data.message || 'Failed to send verification', 'error');
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = 'Verify';
            }
        })
        .catch(() => {
            setEmailStatus('Network error. Please try again.', 'error');
            verifyBtn.disabled = false;
            verifyBtn.innerHTML = 'Verify';
        });
    });

    // Update HTML code as user types email (real-time)
    recipientEmail.addEventListener('input', function() {
        const email = this.value.trim();
        if (email && email.includes('@')) {
            // Update HTML code in real-time as user types
            updateHtmlCodeWithEmail(email);
        }
    });

    /* ============================================================
       Form Submit Handler
    ============================================================ */
    function resolveRecipientEmail(form) {
        // Try to extract email from action URL: /f/email@example.com
        const action = form.getAttribute('action') || '';
        const match = action.match(/\/f\/([^\s/?#]+@[^\s/?#]+\.[^\s/?#]+)/i);
        if (match) return decodeURIComponent(match[1]);

        // Try to find an email input in the form
        const emailInput = form.querySelector('input[type="email"]');
        if (emailInput && emailInput.value) return emailInput.value;

        // Fall back to the recipient email input on the page
        const inputVal = recipientEmail.value.trim();
        if (inputVal) return inputVal;

        return null;
    }

    function handleSubmit(e) {
        e.preventDefault();

        const form = e.target;
        const emailRx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Resolve where to send the submission
        const targetEmail = resolveRecipientEmail(form);

        if (!targetEmail || !emailRx.test(targetEmail)) {
            showResponse('⚠️ No valid recipient email found. Set the form <code>action="/f/your@email.com"</code> or enter an email above.', 'error');
            return;
        }

        // Show loading state
        const submitBtn = form.querySelector('[type="submit"]');
        if (submitBtn) { 
            submitBtn.classList.add('loading'); 
            submitBtn.disabled = true; 
        }
        responseDiv.className = 'response-message';

        // First check if the email is verified
        checkEmailVerification(targetEmail).then(verified => {
            if (!verified) {
                showResponse(`⚠️ Please verify <strong>${targetEmail}</strong> first. Click Verify above.`, 'error');
                recipientEmail.value = targetEmail;
                recipientEmail.focus();
                if (submitBtn) { 
                    submitBtn.classList.remove('loading'); 
                    submitBtn.disabled = false; 
                }
                return;
            }

            // Proceed with form submission
            const formData = new FormData(form);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            formData.append('recipient_email', targetEmail);

            // Log what we're sending
            console.log('Submitting to:', targetEmail);

            fetch('<?php echo e(route("playground.submit")); ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async r => {
                const data = await r.json();
                if (!r.ok) {
                    throw new Error(data.message || 'Submission failed');
                }
                return data;
            })
            .then(data => {
                if (data.success) {
                    showResponse(`✅ Submission sent to <strong>${targetEmail}</strong>`, 'success');
                    form.reset();
                    showToast('Form submitted!');
                } else {
                    showResponse(data.message || 'An error occurred.', 'error');
                }
            })
            .catch(error => {
                console.error('Submission error:', error);
                showResponse(error.message || 'Network error. Please try again.', 'error');
            })
            .finally(() => {
                if (submitBtn) { 
                    submitBtn.classList.remove('loading'); 
                    submitBtn.disabled = false; 
                }
            });
        });
    }

    function attachFormHandler() {
        const forms = formPreview.querySelectorAll('form');
        forms.forEach(form => {
            form.removeEventListener('submit', handleSubmit);
            form.addEventListener('submit', handleSubmit);
        });
    }

    /* ============================================================
       UI Helpers
    ============================================================ */
    function showResponse(msg, type) {
        responseDiv.innerHTML = msg;
        responseDiv.className = 'response-message show ' + type;
        if (type === 'success') {
            setTimeout(() => responseDiv.classList.remove('show'), 5000);
        }
    }

    function showToast(msg) {
        toast.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2500);
    }

    /* ============================================================
       Initialize - Check for previously verified email
    ============================================================ */
    if (verifiedEmail) {
        recipientEmail.value = verifiedEmail;
        checkEmailVerification(verifiedEmail).then(() => {
            // Update HTML code with verified email
            updateHtmlCodeWithEmail(verifiedEmail);
        });
    }

    // Auto-check when email input loses focus
    recipientEmail.addEventListener('blur', function() {
        const email = this.value.trim();
        if (email && email.includes('@')) {
            checkEmailVerification(email);
        }
    });

    // Update the HTML editor default to use the current domain
    const currentDomain = window.location.origin;
    const defaultHtml = `<!-- Paste this anywhere — replace YOUR@EMAIL.COM with your verified email -->
<form action="${currentDomain}/f/YOUR@EMAIL.COM" method="POST" class="preview-form">

    <div class="form-row">
        <div class="col">
            <input type="text" name="name" placeholder="Full Name" required>
        </div>
        <div class="col">
            <input type="email" name="email" placeholder="Email Address" required>
        </div>
    </div>

    <div class="form-group">
        <textarea name="message" placeholder="Your Message" rows="6" required></textarea>
    </div>

    <button type="submit" class="submit-btn">Submit Form</button>

</form>`;
    
    if (htmlEditor.value.includes('{{ config')) {
        htmlEditor.value = defaultHtml;
    }

    // Add a helper to show that email updates in real-time
    const style = document.createElement('style');
    style.textContent = `
        @keyframes highlight {
            0% { background-color: rgba(0, 255, 136, 0.3); }
            100% { background-color: transparent; }
        }
        .email-highlight {
            animation: highlight 1s ease;
        }
    `;
    document.head.appendChild(style);

    console.log('Playground initialized with auto-email update');
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/pages/playground.blade.php ENDPATH**/ ?>