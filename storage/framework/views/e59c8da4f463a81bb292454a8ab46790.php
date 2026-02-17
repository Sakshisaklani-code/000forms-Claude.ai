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
        .analytics-grid { grid-template-columns: 1fr; }
    }

    /* Code tabs */
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
    .code-tab:hover { background: #f1f5f9; color: #181818; }
    .code-tab.active { background: #414265; color: white; }
    .code-block { display: none; }
    .code-block.active { display: block; }
    .code-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1rem;
        background: #1e293b;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .code-lang { color: #94a3b8; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
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
    .code-copy:hover { background: #475569; }
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

    /* ── Submission Tabs ── */
    .submission-tabs-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        border-bottom: 2px solid var(--border-color);
        margin-bottom: 0;
    }
    .submission-tabs {
        display: flex;
        gap: 0;
    }
    .submission-tab {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.65rem 1.25rem;
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-muted);
        cursor: pointer;
        text-decoration: none;
        transition: color 0.2s, border-color 0.2s, background 0.15s;
        border-radius: 6px 6px 0 0;
    }
    .submission-tab:hover {
        color: var(--text);
        background: var(--bg-tertiary);
    }
    .submission-tab.active {
        color: var(--text);
        border-bottom-color: #414265;
        font-weight: 600;
    }
    .tab-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 1.4rem;
        height: 1.4rem;
        padding: 0 0.4rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 700;
        line-height: 1;
    }
    .tab-pill.valid { background: rgba(34,197,94,0.15); color: #22c55e; }
    .tab-pill.spam  { background: rgba(245,158,11,0.15); color: #f59e0b; }

    /* ── Search ── */
    .search-form {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.25rem;
    }
    .search-wrapper {
        position: relative;
    }
    .search-wrapper svg.search-icon {
        position: absolute;
        left: 0.7rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
    }
    .search-input {
        width: 260px;
        padding: 0.45rem 2.25rem 0.45rem 2.1rem;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        color: var(--text);
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s, width 0.3s;
        box-sizing: border-box;
    }
    .search-input:focus {
        border-color: #414265;
        width: 300px;
    }
    .search-input::placeholder { color: var(--text-muted); }
    .search-clear {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 1rem;
        line-height: 1;
        padding: 0.1rem 0.25rem;
        border-radius: 3px;
        display: flex;
        align-items: center;
    }
    .search-clear:hover { color: var(--text); }
    .results-info {
        font-size: 0.78rem;
        color: var(--text-muted);
        white-space: nowrap;
        padding-bottom: 0.25rem;
    }

    /* ── Table row tweaks ── */
    .spam-row td { opacity: 0.65; }
    .spam-row:hover td { opacity: 1; transition: opacity 0.15s; }

    /* ── Empty state inside card ── */
    .submissions-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
    }
    .submissions-section-header {
        padding: 1rem 1.25rem 0;
    }
</style>

<div class="page-header">
    <div>
        <a href="<?php echo e(route('dashboard')); ?>" class="text-muted" style="font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
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
        <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 1rem;">Choose your integration method:</p>

        <div class="code-tabs">
            <button class="code-tab active" onclick="switchCodeTab('html', event)">Plain HTML</button>
            <button class="code-tab" onclick="switchCodeTab('ajax', event)">HTML + AJAX</button>
            <button class="code-tab" onclick="switchCodeTab('fileupload', event)">File Upload (HTML)</button>
        </div>

        <!-- Plain HTML -->
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

        <!-- AJAX -->
        <div id="code-ajax" class="code-block">
            <div class="code-header">
                <span class="code-lang">HTML + JavaScript</span>
                <button class="code-copy" onclick="copyCode('ajax-code')">Copy</button>
            </div>
            <div class="code-content" id="ajax-code">
<pre><span class="tag">&lt;form</span> <span class="attr">id</span>=<span class="string">"form-<?php echo e($form->slug); ?>"</span> <span class="attr">action</span>=<span class="string">"<?php echo e($form->endpoint_url); ?>"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span> <span class="attr">placeholder</span>=<span class="string">"Your email"</span> <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  <?php if($form->honeypot_enabled): ?>
  <span class="comment">&lt;!-- Honeypot (spam protection) --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"<?php echo e($form->honeypot_field); ?>"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span>
  <?php endif; ?>
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span>
<span class="tag">&lt;div</span> <span class="attr">id</span>=<span class="string">"form-response-<?php echo e($form->slug); ?>"</span> <span class="attr">style</span>=<span class="string">"margin-top:15px"</span><span class="tag">&gt;&lt;/div&gt;</span>
<span class="tag">&lt;script&gt;</span>
<span class="keyword">document</span>.getElementById(<span class="string">'form-<?php echo e($form->slug); ?>'</span>).addEventListener(<span class="string">'submit'</span>, <span class="keyword">async function</span>(e) {
    e.preventDefault();
    <span class="keyword">const</span> form = <span class="keyword">this</span>, responseBox = <span class="keyword">document</span>.getElementById(<span class="string">'form-response-<?php echo e($form->slug); ?>'</span>);
    <span class="keyword">const</span> btn = form.querySelector(<span class="string">'button[type="submit"]'</span>);
    btn.disabled = <span class="keyword">true</span>; btn.textContent = <span class="string">'Sending...'</span>;
    <span class="keyword">try</span> {
        <span class="keyword">const</span> res  = <span class="keyword">await</span> fetch(form.action, { method:<span class="string">'POST'</span>, body:<span class="keyword">new</span> FormData(form), headers:{<span class="string">'Accept'</span>:<span class="string">'application/json'</span>} });
        <span class="keyword">const</span> data = <span class="keyword">await</span> res.json();
        <span class="keyword">if</span> (res.ok &amp;&amp; data.success) { responseBox.innerHTML = <span class="string">'&lt;span style="color:#22c55e"&gt;✓ <?php echo e($form->success_message ?? 'Thank you!'); ?>&lt;/span&gt;'</span>; form.reset(); }
        <span class="keyword">else throw new</span> Error(data.error || <span class="string">'Something went wrong'</span>);
    } <span class="keyword">catch</span>(err) { responseBox.innerHTML = <span class="string">'&lt;span style="color:#ef4444"&gt;✗ '</span> + err.message + <span class="string">'&lt;/span&gt;'</span>; }
    <span class="keyword">finally</span> { btn.disabled = <span class="keyword">false</span>; btn.textContent = <span class="string">'Send Message'</span>; }
});
<span class="tag">&lt;/script&gt;</span></pre>
            </div>
        </div>

        <!-- File Upload -->
        <div id="code-fileupload" class="code-block">
            <div class="code-header">
                <span class="code-lang">HTML (File Upload)</span>
                <button class="code-copy" onclick="copyCode('fileupload-code')">Copy</button>
            </div>
            <div class="code-content" id="fileupload-code">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"<?php echo e($form->endpoint_url); ?>"</span> <span class="attr">method</span>=<span class="string">"POST"</span> <span class="attr">enctype</span>=<span class="string">"multipart/form-data"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span> <span class="attr">placeholder</span>=<span class="string">"Your email"</span> <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  <span class="comment">&lt;!-- Single file --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"file"</span> <span class="attr">name</span>=<span class="string">"upload"</span><span class="tag">&gt;</span>
  <span class="comment">&lt;!-- OR multiple files --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"file"</span> <span class="attr">name</span>=<span class="string">"upload[]"</span> <span class="attr">multiple</span><span class="tag">&gt;</span>
  <?php if($form->honeypot_enabled): ?>
  <span class="comment">&lt;!-- Honeypot (spam protection) --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"<?php echo e($form->honeypot_field); ?>"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span>
  <?php endif; ?>
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="card stat-card">
        <div class="stat-label">Valid Submissions</div>
        <div class="stat-value"><?php echo e(number_format($form->submission_count)); ?></div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Spam Blocked</div>
        <div class="stat-value"><?php echo e(number_format($form->spam_count)); ?></div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Last Submission</div>
        <div class="stat-value" style="font-size: 1.25rem;">
            <?php echo e($form->last_submission_at ? $form->last_submission_at->diffForHumans() : 'Never'); ?>

        </div>
    </div>
</div>

<!-- Graphs -->
<div class="card mb-3">
    <div class="card-header">
        <h4 class="card-title">Submission Analytics</h4>
    </div>
    <div class="analytics-grid">
        <div class="chart-container"><canvas id="lineChart"></canvas></div>
        <div class="chart-container"><canvas id="barChart"></canvas></div>
    </div>
</div>

<!-- ══════════════════════════════════════════
     Submissions Section with Tabs + Search
     ══════════════════════════════════════════ -->
<div class="submissions-section">
    <div class="submissions-section-header">

        
        <div class="submission-tabs-bar">

            
            <div class="submission-tabs">
                <a href="<?php echo e(route('dashboard.forms.show', $form->id)); ?>?tab=valid&search=<?php echo e(urlencode($search)); ?>"
                   class="submission-tab <?php echo e($tab === 'valid' ? 'active' : ''); ?>">
                    Inbox
                    <span class="tab-pill valid"><?php echo e(number_format($validCount)); ?></span>
                </a>
                <a href="<?php echo e(route('dashboard.forms.show', $form->id)); ?>?tab=spam&search=<?php echo e(urlencode($search)); ?>"
                   class="submission-tab <?php echo e($tab === 'spam' ? 'active' : ''); ?>">
                    Spam
                    <span class="tab-pill spam"><?php echo e(number_format($spamCount)); ?></span>
                </a>
            </div>

            
            <form method="GET"
                  action="<?php echo e(route('dashboard.forms.show', $form->id)); ?>"
                  class="search-form"
                  id="searchForm">
                <input type="hidden" name="tab" value="<?php echo e($tab); ?>">
                <div class="search-wrapper">
                    <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text"
                           name="search"
                           id="searchInput"
                           class="search-input"
                           placeholder="Search submissions…"
                           value="<?php echo e($search); ?>"
                           autocomplete="off">
                    <?php if($search): ?>
                        <a href="<?php echo e(route('dashboard.forms.show', $form->id)); ?>?tab=<?php echo e($tab); ?>"
                           class="search-clear"
                           title="Clear search">✕</a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            </form>
        </div>

        
        <?php if($search): ?>
            <p class="results-info" style="padding: 0.5rem 0 0.25rem;">
                <?php if($submissions->total() > 0): ?>
                    Showing <strong><?php echo e($submissions->total()); ?></strong> result<?php echo e($submissions->total() !== 1 ? 's' : ''); ?> for "<strong><?php echo e($search); ?></strong>"
                    in <strong><?php echo e($tab === 'spam' ? 'Spam' : 'Inbox'); ?></strong>
                <?php else: ?>
                    No results for "<strong><?php echo e($search); ?></strong>" in <strong><?php echo e($tab === 'spam' ? 'Spam' : 'Inbox'); ?></strong>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>

    
    <?php if($submissions->count() > 0): ?>
        <div class="table-wrapper" style="margin-top: 0.5rem;">
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
                        <tr class="<?php echo e($submission->is_spam ? 'spam-row' : ''); ?>">
                            <td>
                                <a href="<?php echo e(route('dashboard.submissions.show', [$form->id, $submission->id])); ?>" class="table-link">
                                    <?php echo e(Str::limit($submission->summary, 60)); ?>

                                </a>
                                <?php if(!$submission->is_read && !$submission->is_spam): ?>
                                    <span class="badge badge-success" style="margin-left: 0.5rem;">New</span>
                                <?php endif; ?>
                                <?php if($submission->is_spam): ?>
                                    <span class="badge" style="margin-left: 0.5rem; background: rgba(245,158,11,0.15); color: #f59e0b; font-size: 0.68rem; padding: 0.15rem 0.45rem; border-radius: 999px;">
                                        Spam
                                    </span>
                                <?php endif; ?>
                                <?php if($submission->spam_reason): ?>
                                    <span style="font-size: 0.72rem; color: var(--text-muted); margin-left: 0.35rem;">
                                        · <?php echo e($submission->spam_reason); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted"><?php echo e($submission->created_at->format('M j, Y g:i A')); ?></td>
                            <td>
                                <?php if($submission->is_spam): ?>
                                    <span style="font-size: 0.8rem; color: #f59e0b;">Blocked</span>
                                <?php elseif($submission->email_sent): ?>
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

        <?php if($submissions->hasPages()): ?>
            <div style="padding: 1.25rem; display: flex; justify-content: center;">
                <?php echo e($submissions->links()); ?>

            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="empty-state" style="padding: 3rem 1.5rem;">
            <?php if($search): ?>
                <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <h3 class="empty-title">No results found</h3>
                <p class="empty-description">
                    Nothing matched "<strong><?php echo e($search); ?></strong>".
                    <a href="<?php echo e(route('dashboard.forms.show', $form->id)); ?>?tab=<?php echo e($tab); ?>" style="color: #414265;">Clear search</a>
                </p>
            <?php elseif($tab === 'spam'): ?>
                <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <h3 class="empty-title">No spam detected</h3>
                <p class="empty-description">Your spam folder is clean.</p>
            <?php else: ?>
                <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="empty-title">No submissions yet</h3>
                <p class="empty-description">Submissions will appear here once your form starts receiving data.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
const primaryColor = '#414265';
const successColor = '#22c55e';
const warningColor = '#f59e0b';
const mutedColor   = '#94a3b8';

// Line Chart
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($lineLabels, 15, 512) ?>,
        datasets: [{
            label: 'Submissions (Last 7 Days)',
            data: <?php echo json_encode($lineData, 15, 512) ?>,
            borderColor: primaryColor,
            backgroundColor: 'rgba(99,102,241,0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: primaryColor
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { color: mutedColor } },
            y: { ticks: { color: mutedColor }, beginAtZero: true }
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
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: mutedColor } },
            y: { beginAtZero: true, ticks: { color: mutedColor } }
        }
    }
});

// Copy endpoint URL
function copyEndpoint(slug) {
    navigator.clipboard.writeText(`<?php echo e(url('/f')); ?>/${slug}`);
    const btn = event.currentTarget;
    const orig = btn.innerHTML;
    btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Copied!';
    setTimeout(() => btn.innerHTML = orig, 2000);
}

// Code tabs
function switchCodeTab(tab, e) {
    document.querySelectorAll('.code-tab').forEach(b => b.classList.remove('active'));
    (e?.currentTarget ?? event.currentTarget).classList.add('active');
    document.querySelectorAll('.code-block').forEach(b => b.classList.remove('active'));
    document.getElementById(`code-${tab}`).classList.add('active');
}

// Copy code
function copyCode(elementId) {
    navigator.clipboard.writeText(document.getElementById(elementId).innerText);
    const btn = event.currentTarget;
    const orig = btn.textContent;
    btn.textContent = 'Copied!';
    setTimeout(() => btn.textContent = orig, 2000);
}

// Submit search on Enter, debounce optional
document.getElementById('searchInput')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') document.getElementById('searchForm').submit();
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\dashboard\forms\show.blade.php ENDPATH**/ ?>