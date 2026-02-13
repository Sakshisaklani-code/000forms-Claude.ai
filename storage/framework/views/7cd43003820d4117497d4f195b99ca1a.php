<?php $__env->startSection('title', 'Documentation - 000form'); ?>

<?php $__env->startSection('content'); ?>


<div style="padding: 8rem 0 4rem;">
    <div class="container container-md">
        <h1 style="margin-bottom: 0.5rem;">Documentation</h1>
        <p class="text-muted" style="margin-bottom: 3rem;">Everything you need to integrate 000form into your website.</p>
        
        <!-- Quick Start -->
        <section class="card mb-3">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Quick Start</h2>
            <p class="text-muted mb-3">Get forms working in under 2 minutes:</p>
            
            <ol style="color: var(--text-secondary); padding-left: 1.5rem; line-height: 2;">
                <li><a href="<?php echo e(route('signup')); ?>">Create an account</a> (free, no credit card)</li>
                <li>Create a new form and note your endpoint URL</li>
                <li>Point your HTML form's <code>action</code> attribute to your endpoint</li>
                <li>That's it! Submissions go to your email and dashboard</li>
            </ol>
        </section>
        
        <!-- Basic Usage -->
        <section class="card mb-3">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Basic HTML Form</h2>
            <p class="text-muted mb-3">The simplest integration:</p>
            
            <div class="code-block">
                <div class="code-header">
                    <span class="code-lang">HTML</span>
                    <button class="code-copy">Copy</button>
                </div>
                <div class="code-content">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"https://000form.com/f/YOUR_FORM_ID"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;label&gt;</span>
    Email
    <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span> <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;/label&gt;</span>
  
  <span class="tag">&lt;label&gt;</span>
    Message
    <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  <span class="tag">&lt;/label&gt;</span>
  
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
                </div>
            </div>
        </section>
        
        <!-- Special Fields -->
        <section class="card mb-3">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Special Fields</h2>
            <p class="text-muted mb-3">Use these special field names for extra functionality:</p>
            
            <table class="table" style="margin: 0 -1.5rem; width: calc(100% + 3rem);">
                <thead>
                    <tr>
                        <th>Field Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>email</code></td>
                        <td>Sender's email - enables reply-to in notification emails</td>
                    </tr>
                    <tr>
                        <td><code>_replyto</code></td>
                        <td>Alternative way to set reply-to email</td>
                    </tr>
                    <tr>
                        <td><code>_subject</code></td>
                        <td>Custom email subject line</td>
                    </tr>
                    <tr>
                        <td><code>_next</code></td>
                        <td>URL to redirect after successful submission</td>
                    </tr>
                    <tr>
                        <td><code>_gotcha</code></td>
                        <td>Honeypot field - leave hidden, spam bots fill it</td>
                    </tr>
                </tbody>
            </table>
        </section>
        
        <!-- Spam Protection -->
        <section class="card mb-3">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Spam Protection</h2>
            <p class="text-muted mb-3">Add a honeypot field to catch spam bots:</p>
            
            <div class="code-block">
                <div class="code-header">
                    <span class="code-lang">HTML</span>
                    <button class="code-copy">Copy</button>
                </div>
                <div class="code-content">
<pre><span class="comment">&lt;!-- Add this hidden field to your form --&gt;</span>
<span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"_gotcha"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span></pre>
                </div>
            </div>
            
            <p class="text-muted mt-3">Bots will fill this field, humans won't see it. Any submission with this field filled is marked as spam.</p>
        </section>
        
        <!-- AJAX Submissions -->
        <section class="card mb-3">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">AJAX / JavaScript</h2>
            <p class="text-muted mb-3">Submit forms without page reload:</p>
            
            <div class="code-block">
                <div class="code-header">
                    <span class="code-lang">JavaScript</span>
                    <button class="code-copy">Copy</button>
                </div>
                <div class="code-content">
<pre>document.getElementById('YOUR-FORM-ID').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = this;
    const responseBox = document.getElementById('form-response');
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Disable button and show loading state
    submitButton.disabled = true;
    submitButton.textContent = 'Sending...';
    responseBox.innerHTML = '<span style="color: #64748b;"> Sending your message...</span>';
    
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            responseBox.innerHTML = '<span style="color: #22c55e;"> Thank you for your submission!</span>';
            form.reset();
        } else {
            throw new Error(data.error || 'Something went wrong');
        }
    } catch (error) {
        responseBox.innerHTML = '<span style="color: #ef4444;"> ' + error.message + '. Please try again.</span>';
    } finally {
        // Re-enable button
        submitButton.disabled = false;
        submitButton.textContent = 'Send Message';
    }
});</pre>
                </div>
            </div>
            
            <p class="text-muted mt-3">
                Include this in your form: 
                <strong style="color: #d4d7db;">&lt;div id="form-response" style="margin-top: 15px;"&gt;&lt;/div&gt;</strong>
                </p>

        </section>
        
        <!-- Custom Redirects -->
        <section class="card mb-3">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Custom Redirects</h2>
            <p class="text-muted mb-3">Redirect users to your own thank-you page:</p>
            
            <div class="code-block">
                <div class="code-header">
                    <span class="code-lang">HTML</span>
                    <button class="code-copy">Copy</button>
                </div>
                <div class="code-content">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"https://000form.com/f/YOUR_FORM_ID"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="comment">&lt;!-- Your form fields --&gt;</span>
  
  <span class="comment">&lt;!-- Hidden redirect field --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_next"</span> <span class="attr">value</span>=<span class="string">"https://yoursite.com/thank-you"</span><span class="tag">&gt;</span>
  
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
                </div>
            </div>
            
            <p class="text-muted mt-3">Or set a default redirect URL in your form settings.</p>
        </section>
        
        <!-- Rate Limits -->
        <section class="card">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Limits</h2>
            <p class="text-muted mb-3">Our free tier includes:</p>
            
            <ul style="color: var(--text-secondary); padding-left: 1.5rem; line-height: 2;">
                <li>Unlimited forms</li>
                <li>Unlimited submissions</li>
                <li>100 submissions per hour per IP (rate limit)</li>
                <li>Email notifications</li>
                <li>Submission storage & export</li>
            </ul>
        </section>
        
        <div class="text-center mt-4">
            <p class="text-muted mb-3">Ready to get started?</p>
            <a href="<?php echo e(route('signup')); ?>" class="btn btn-primary btn-lg">Create Free Account</a>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/pages/docs.blade.php ENDPATH**/ ?>