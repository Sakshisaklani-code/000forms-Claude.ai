<?php $__env->startSection('title', $form->name); ?>

<?php $__env->startSection('content'); ?>
<style>
    .analytics-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        padding: 1.5rem;
    }

    .chart-container {
        position: relative;
        height: 320px;
        width: 100%;
    }

    .chart-container canvas {
        width: 100% !important;
        height: 100% !important;
    }

    @media (max-width: 900px) {
        .analytics-grid {
            grid-template-columns: 1fr;
        }
    }

    /* New styles for code tabs */
    .code-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.5rem;
        flex-wrap: wrap;
    }

    .code-tab {
        padding: 0.5rem 1rem;
        background: none;
        border: none;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }

    .code-tab:hover {
        background: #f1f5f9;
        color: #181818;
    }

    .code-tab.active {
        background: #414265;
        color: white;
    }

    .code-block {
        display: none;
    }

    .code-block.active {
        display: block;
    }

    .code-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1rem;
        background: #1e293b;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .code-lang {
        color: #94a3b8;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .code-copy {
        background: #334155;
        color: white;
        border: none;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .code-copy:hover {
        background: #475569;
    }

    .code-content {
        background: #181818;
        padding: 1.25rem;
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        overflow-x: auto;
    }

    .code-content pre {
        margin: 0;
        color: #e2e8f0;
        font-family: 'Fira Code', 'Courier New', monospace;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .tag { color: #ff79c6; }
    .attr { color: #8be9fd; }
    .string { color: #f1fa8c; }
    .comment { color: #6272a4; }
    .keyword { color: #ff79c6; }
    .function { color: #50fa7b; }
    .variable { color: #bd93f9; }
    
    .integration-badge {
        display: inline-block;
        background: #414265;
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        margin-left: 0.5rem;
        vertical-align: middle;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="page-header">
    <div>
        <a href="<?php echo e(route('dashboard')); ?>" class="text-muted" style="font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Back to Dashboard
        </a>
        <h1 class="page-title"><?php echo e($form->name); ?></h1>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="<?php echo e(route('dashboard.forms.export', $form->id)); ?>" class="btn btn-secondary btn-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Export CSV
        </a>
        <a href="<?php echo e(route('dashboard.forms.edit', $form->id)); ?>" class="btn btn-secondary btn-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Settings
        </a>
    </div>
</div>

<!-- Status Alert -->
<?php if(!$form->email_verified): ?>
    <div class="alert alert-warning">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <div style="flex: 1;">
            <strong>Email verification required.</strong> Please check <?php echo e($form->recipient_email); ?> and click the verification link.
        </div>
        <form method="POST" action="<?php echo e(route('dashboard.forms.resend-verification', $form->id)); ?>" style="margin: 0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-secondary">Resend Email</button>
        </form>
    </div>
<?php endif; ?>

<!-- Endpoint Info -->
<div class="card mb-3">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <h4 class="card-title">Form Endpoint</h4>
            <span class="badge <?php echo e($form->status === 'active' && $form->email_verified ? 'badge-success' : 'badge-warning'); ?>">
                <span class="badge-dot"></span>
                <?php echo e($form->email_verified ? ucfirst($form->status) : 'Pending Verification'); ?>

            </span>
        </div>
    </div>
    
    <div class="endpoint-display">
        <span class="endpoint-method">POST</span>
        <span class="endpoint-url"><?php echo e($form->endpoint_url); ?></span>
        <button class="btn btn-ghost btn-sm" onclick="copyEndpoint('<?php echo e($form->slug); ?>')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
            </svg>
            Copy URL
        </button>
    </div>
    
    <div class="mt-3">
        <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 1rem;">
            Choose your integration method:
        </p>
        
        <!-- Code Tabs -->
        <div class="code-tabs">
            <button class="code-tab active" onclick="switchCodeTab('html')">Plain HTML</button>
            <button class="code-tab" onclick="switchCodeTab('ajax')">HTML + AJAX</button>
            <button class="code-tab" onclick="switchCodeTab('fileupload')">
                File Upload (HTML)
            </button>
        </div>

        <!-- Plain HTML Code Block -->
        <div id="code-html" class="code-block active">
            <div class="code-header">
                <span class="code-lang">HTML</span>
                <button class="code-copy" onclick="copyCode('html-code')">Copy</button>
            </div>
            <div class="code-content" id="html-code">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"<?php echo e($form->endpoint_url); ?>"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span> <span class="attr">placeholder</span>=<span class="string">"Your email"</span> <span class="attr">required</span><span class="tag">&gt;</span>

  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  
  <?php if($form->honeypot_enabled): ?>
  <span class="comment">&lt;!-- Honeypot (spam protection) --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"<?php echo e($form->honeypot_field); ?>"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span>
  <?php endif; ?>

  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
            </div>
        </div>

        <!-- AJAX Code Block -->
        <div id="code-ajax" class="code-block">
            <div class="code-header">
                <span class="code-lang">HTML + JavaScript</span>
                <button class="code-copy" onclick="copyCode('ajax-code')">Copy</button>
            </div>
            <div class="code-content" id="ajax-code">
<pre><span class="comment">&lt;!-- HTML Form --&gt;</span>
<span class="tag">&lt;form</span> <span class="attr">id</span>=<span class="string">"form-<?php echo e($form->slug); ?>"</span> <span class="attr">action</span>=<span class="string">"<?php echo e($form->endpoint_url); ?>"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span> <span class="attr">placeholder</span>=<span class="string">"Your email"</span> <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  
  <?php if($form->honeypot_enabled): ?>
  <span class="comment">&lt;!-- Honeypot (spam protection) --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"<?php echo e($form->honeypot_field); ?>"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span>
  <?php endif; ?>
  
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span>

<span class="comment">&lt;!-- Response Message Container --&gt;</span>
<span class="tag">&lt;div</span> <span class="attr">id</span>=<span class="string">"form-response-<?php echo e($form->slug); ?>"</span> <span class="attr">style</span>=<span class="string">"margin-top: 15px;"</span><span class="tag">&gt;&lt;/div&gt;</span>

<span class="tag">&lt;script&gt;</span>
<span class="keyword">document</span>.getElementById(<span class="string">'form-<?php echo e($form->slug); ?>'</span>).addEventListener(<span class="string">'submit'</span>, <span class="keyword">async function</span>(e) {
    e.preventDefault();
    
    <span class="keyword">const</span> form = <span class="keyword">this</span>;
    <span class="keyword">const</span> responseBox = <span class="keyword">document</span>.getElementById(<span class="string">'form-response-<?php echo e($form->slug); ?>'</span>);
    <span class="keyword">const</span> formData = <span class="keyword">new</span> FormData(form);
    <span class="keyword">const</span> submitButton = form.querySelector(<span class="string">'button[type="submit"]'</span>);
    
    <span class="comment">// Disable button and show loading state</span>
    submitButton.disabled = <span class="keyword">true</span>;
    submitButton.textContent = <span class="string">'Sending...'</span>;
    responseBox.innerHTML = <span class="string">'&lt;span style="color: #64748b;"&gt; Sending your message...&lt;/span&gt;'</span>;
    
    <span class="keyword">try</span> {
        <span class="keyword">const</span> response = <span class="keyword">await</span> fetch(form.action, {
            method: <span class="string">'POST'</span>,
            body: formData,
            headers: {
                <span class="string">'Accept'</span>: <span class="string">'application/json'</span>
            }
        });
        
        <span class="keyword">const</span> data = <span class="keyword">await</span> response.json();
        
        <span class="keyword">if</span> (response.ok &amp;&amp; data.success) {
            responseBox.innerHTML = <span class="string">'&lt;span style="color: #22c55e;"&gt; <?php echo e($form->success_message ?? 'Thank you! Your message has been sent.'); ?>&lt;/span&gt;'</span>;
            form.reset();
        } <span class="keyword">else</span> {
            <span class="keyword">throw</span> <span class="keyword">new</span> Error(data.error || <span class="string">'Something went wrong'</span>);
        }
    } <span class="keyword">catch</span> (error) {
        responseBox.innerHTML = <span class="string">'&lt;span style="color: #ef4444;"&gt; '</span> + error.message + <span class="string">'. Please try again.&lt;/span&gt;'</span>;
    } <span class="keyword">finally</span> {
        <span class="comment">// Re-enable button</span>
        submitButton.disabled = <span class="keyword">false</span>;
        submitButton.textContent = <span class="string">'Send Message'</span>;
    }
});
<span class="tag">&lt;/script&gt;</span></pre>
            </div>
        </div>

        <!-- File Upload HTML Code Block -->
        <div id="code-fileupload" class="code-block">
            <div class="code-header">
                <span class="code-lang">HTML (File Upload Support)</span>
                <button class="code-copy" onclick="copyCode('fileupload-code')">Copy</button>
            </div>
            <div class="code-content" id="fileupload-code">
<pre><span class="comment">&lt;!-- HTML Form with File Upload Support --&gt;</span>
<span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"<?php echo e($form->endpoint_url); ?>"</span> 
      <span class="attr">method</span>=<span class="string">"POST"</span> 
      <span class="attr">enctype</span>=<span class="string">"multipart/form-data"</span><span class="tag">&gt;</span>
  
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span> <span class="attr">placeholder</span>=<span class="string">"Your email"</span> <span class="attr">required</span><span class="tag">&gt;</span>
  
  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"file"</span> 
         <span class="attr">name</span>=<span class="string">"upload"</span> 
         <!-- <span class="attr">accept</span>=<span class="string">"image/*,.pdf,.doc,.docx,.txt"</span> -->
         <span class="attr">placeholder</span>=<span class="string">"Choose file to upload"</span><span class="tag">&gt;</span>
  
  <?php if($form->honeypot_enabled): ?>
  <span class="comment">&lt;!-- Honeypot (spam protection) --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"<?php echo e($form->honeypot_field); ?>"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span>
  <?php endif; ?>

  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message with File<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span>

            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="card stat-card">
        <div class="stat-label">Total Submissions</div>
        <div class="stat-value"><?php echo e(number_format($form->submission_count)); ?></div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Spam Blocked</div>
        <div class="stat-value"><?php echo e(number_format($form->spam_count)); ?></div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Last Submission</div>
        <div class="stat-value" style="font-size: 1.25rem;"><?php echo e($form->last_submission_at ? $form->last_submission_at->diffForHumans() : 'Never'); ?></div>
    </div>
</div>

<!-- Graphs -->
<div class="card mb-3">
    <div class="card-header">
        <h4 class="card-title">Submission Analytics</h4>
    </div>

    <div class="analytics-grid">
        <div class="chart-container">
            <canvas id="lineChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="barChart"></canvas>
        </div>
    </div>
</div>

<!-- Submissions -->
<div class="card-header" style="border: none; padding: 1.5rem 0 1rem;">
    <h4 class="card-title">Recent Submissions</h4>
</div>

<?php if($submissions->count() > 0): ?>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Summary</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('dashboard.submissions.show', [$form->id, $submission->id])); ?>" class="table-link">
                                <?php echo e(Str::limit($submission->summary, 60)); ?>

                            </a>
                            <?php if(!$submission->is_read): ?>
                                <span class="badge badge-success" style="margin-left: 0.5rem;">New</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted"><?php echo e($submission->created_at->format('M j, Y g:i A')); ?></td>
                        <td>
                            <?php if($submission->email_sent): ?>
                                <span class="text-muted" style="font-size: 0.8rem;">Email sent</span>
                            <?php else: ?>
                                <span class="text-muted" style="font-size: 0.8rem;">Stored</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-right">
                            <a href="<?php echo e(route('dashboard.submissions.show', [$form->id, $submission->id])); ?>" class="btn btn-ghost btn-sm">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if($submissions->hasPages()): ?>
        <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
            <?php echo e($submissions->links()); ?>

        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="card">
        <div class="empty-state">
            <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="empty-title">No submissions yet</h3>
            <p class="empty-description">Submissions will appear here once your form starts receiving data.</p>
        </div>
    </div>
<?php endif; ?>

<script>
const primaryColor = '#414265';
const successColor = '#22c55e';
const warningColor = '#f59e0b';
const mutedColor = '#94a3b8';

// Line Chart
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($lineLabels, 15, 512) ?>,
        datasets: [{
            label: 'Submissions (Last 7 Days)',
            data: <?php echo json_encode($lineData, 15, 512) ?>,
            borderColor: primaryColor,
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: primaryColor
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { color: mutedColor }
            },
            y: {
                ticks: { color: mutedColor },
                beginAtZero: true
            }
        }
    }
});

// Bar Chart
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Valid', 'Spam'],
        datasets: [{
            label: 'Submission Breakdown',
            data: [<?php echo e($validCount); ?>, <?php echo e($spamCount); ?>],
            backgroundColor: [successColor, warningColor],
            borderRadius: 6
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                ticks: { color: mutedColor }
            },
            y: {
                beginAtZero: true,
                ticks: { color: mutedColor }
            }
        }
    }
});

// Copy endpoint URL
function copyEndpoint(slug) {
    const url = `<?php echo e(url('/f')); ?>/${slug}`;
    navigator.clipboard.writeText(url);
    
    // Show feedback
    const button = event.currentTarget;
    const originalText = button.innerHTML;
    button.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Copied!';
    setTimeout(() => {
        button.innerHTML = originalText;
    }, 2000);
}

// Switch between code tabs
function switchCodeTab(tab) {
    // Update tab buttons
    document.querySelectorAll('.code-tab').forEach(btn => {
        btn.classList.remove('active');
    });
    event.currentTarget.classList.add('active');
    
    // Update code blocks
    document.querySelectorAll('.code-block').forEach(block => {
        block.classList.remove('active');
    });
    document.getElementById(`code-${tab}`).classList.add('active');
}

// Copy code to clipboard
function copyCode(elementId) {
    const codeElement = document.getElementById(elementId);
    const codeText = codeElement.innerText;
    
    navigator.clipboard.writeText(codeText);
    
    // Show feedback
    const button = event.currentTarget;
    const originalText = button.textContent;
    button.textContent = 'Copied!';
    setTimeout(() => {
        button.textContent = originalText;
    }, 2000);
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/dashboard/forms/show.blade.php ENDPATH**/ ?>