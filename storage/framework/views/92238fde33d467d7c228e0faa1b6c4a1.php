

<?php $__env->startSection('title', $form->name); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ── Main Page Tabs ── */
    .page-tabs-bar {
        display: flex;
        gap: 0;
        border-bottom: 2px solid var(--border-color);
        margin-bottom: 1.75rem;
    }
    .page-tab {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.75rem 1.4rem;
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-muted);
        cursor: pointer;
        text-decoration: none;
        transition: color 0.2s, border-color 0.2s;
        border-radius: 6px 6px 0 0;
        white-space: nowrap;
    }
    .page-tab:hover  { color: var(--text); background: var(--bg-tertiary); }
    .page-tab.active { color: var(--text); border-bottom-color: #414265; font-weight: 600; }
    .page-tab svg    { opacity: 0.65; }
    .page-tab.active svg { opacity: 1; }
    .page-panel         { display: none; }
    .page-panel.active  { display: block; }

    /* ── Submission Sub-Tabs ── */
    .submission-tabs-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        border-bottom: 2px solid var(--border-color);
    }
    .submission-tabs { display: flex; }
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
        text-decoration: none;
        transition: color 0.2s, border-color 0.2s, background 0.15s;
        border-radius: 6px 6px 0 0;
    }
    .submission-tab:hover  { color: var(--text); background: var(--bg-tertiary); }
    .submission-tab.active { color: var(--text); border-bottom-color: #414265; font-weight: 600; }
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
    }
    .tab-pill.valid   { background: rgba(34,197,94,0.15);   color: #22c55e; }
    .tab-pill.spam    { background: rgba(245,158,11,0.15);  color: #f59e0b; }
    .tab-pill.archive { background: rgba(99,102,241,0.15);  color: #6366f1; }

    /* ── Archive toggle banner ── */
    .archive-toggle-banner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
        padding: 0.85rem 1.25rem;
        background: rgba(99,102,241,0.06);
        border-bottom: 1px solid var(--border-color);
    }
    .archive-toggle-info {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }
    .archive-toggle-info svg { color: #6366f1; flex-shrink: 0; }
    .archive-toggle-info p   { margin: 0; font-size: 0.82rem; color: var(--text-muted); }
    .archive-toggle-info strong { color: var(--text); font-size: 0.875rem; }

    /* Toggle switch */
    .toggle-switch {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        cursor: pointer;
        user-select: none;
    }
    .toggle-switch input { position: absolute; opacity: 0; width: 0; height: 0; }
    .toggle-track {
        width: 40px; height: 22px;
        background: var(--border-color);
        border-radius: 999px;
        transition: background 0.2s;
        position: relative;
        flex-shrink: 0;
    }
    .toggle-switch input:checked + .toggle-track { background: #6366f1; }
    .toggle-track::after {
        content: '';
        position: absolute;
        top: 3px; left: 3px;
        width: 16px; height: 16px;
        background: white;
        border-radius: 50%;
        transition: transform 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .toggle-switch input:checked + .toggle-track::after { transform: translateX(18px); }
    .toggle-label { font-size: 0.82rem; font-weight: 500; color: var(--text); }

    /* ── Search ── */
    .search-wrapper { position: relative; }
    .search-wrapper svg.search-icon {
        position: absolute; left: 0.7rem; top: 50%;
        transform: translateY(-50%); color: var(--text-muted); pointer-events: none;
    }
    .search-input {
        width: 240px;
        padding: 0.45rem 2rem 0.45rem 2.1rem;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        color: var(--text);
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s, width 0.3s;
        box-sizing: border-box;
    }
    .search-input:focus  { border-color: #414265; width: 280px; }
    .search-input::placeholder { color: var(--text-muted); }
    .search-clear {
        position: absolute; right: 0.5rem; top: 50%;
        transform: translateY(-50%);
        background: none; border: none;
        color: var(--text-muted); cursor: pointer;
        font-size: 0.95rem; line-height: 1;
        display: flex; align-items: center;
        padding: 0.15rem 0.25rem; border-radius: 3px;
    }
    .search-clear:hover { color: var(--text); }
    .results-info {
        font-size: 0.78rem; color: var(--text-muted);
        padding: 0.5rem 0 0.1rem;
    }

    /* ── Code tabs ── */
    .code-tabs {
        display: flex; gap: 0.5rem; flex-wrap: wrap;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 0.5rem;
    }
    .code-tab {
        padding: 0.5rem 1rem; background: none; border: none;
        border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500;
        color: #64748b; cursor: pointer; transition: all 0.2s;
    }
    .code-tab:hover  { background: #f1f5f9; color: #181818; }
    .code-tab.active { background: #414265; color: white; }
    .code-block        { display: none; }
    .code-block.active { display: block; }
    .code-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 0.5rem 1rem; background: #1e293b;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .code-lang { color: #94a3b8; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
    .code-copy {
        background: #334155; color: white; border: none;
        padding: 0.25rem 0.75rem; border-radius: 0.25rem;
        font-size: 0.75rem; cursor: pointer; transition: background 0.2s;
    }
    .code-copy:hover { background: #475569; }
    .code-content {
        background: #181818; padding: 1.25rem;
        border-radius: 0 0 0.5rem 0.5rem; overflow-x: auto;
    }
    .code-content pre {
        margin: 0; color: #e2e8f0;
        font-family: 'Fira Code', 'Courier New', monospace;
        font-size: 0.875rem; line-height: 1.5;
    }
    .tag     { color: #ff79c6; }
    .attr    { color: #8be9fd; }
    .string  { color: #f1fa8c; }
    .comment { color: #6272a4; }
    .keyword { color: #ff79c6; }
    .function { color: #50fa7b; }
    .variable { color: #bd93f9; }

    /* ── Table ── */
    .spam-row td    { opacity: 0.65; }
    .spam-row:hover td { opacity: 1; transition: opacity 0.15s; }
    .archive-row td { opacity: 0.75; }
    .archive-row:hover td { opacity: 1; transition: opacity 0.15s; }
    .submissions-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
    }
    .submissions-section-header { padding: 1rem 1.25rem 0; }

    /* ── Pagination footer ── */
    .pagination-footer {
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border-color);
        background: var(--bg-secondary);
        flex-wrap: wrap;
        gap: 1rem;
    }
    .pagination-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        font-size: 0.85rem;
    }
    .pagination-info svg   { opacity: 0.6; }
    .pagination-info strong { color: var(--text); font-weight: 600; }
    .pagination-controls { display: flex; align-items: center; gap: 0.5rem; }
    .pagination-pages    { display: flex; align-items: center; gap: 0.25rem; }
    .pagination-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-muted);
        background: transparent;
        border: 1px solid transparent;
        text-decoration: none;
        transition: all 0.15s ease;
        cursor: pointer;
    }
    .pagination-link svg { stroke: currentColor; }
    .pagination-link:not(.disabled):not(.active):hover {
        background: var(--bg-tertiary);
        color: var(--text);
        border-color: var(--border-color);
    }
    .pagination-link.active   { background: #414265; color: white; border-color: #414265; }
    .pagination-link.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .charts-grid { grid-template-columns: 1fr !important; }
        .search-input { width: 180px; }
        .search-input:focus { width: 220px; }
    }
    @media (max-width: 640px) {
        .pagination-footer { flex-direction: column; align-items: stretch; text-align: center; }
        .pagination-info   { justify-content: center; }
        .pagination-controls { justify-content: center; }
        .pagination-link { padding: 0.5rem; }
    }
</style>


<div class="page-header">
    <div>
        <a href="<?php echo e(route('dashboard')); ?>" class="text-muted"
           style="font-size:0.875rem;display:inline-flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Back to Dashboard
        </a>
        <h1 class="page-title"><?php echo e($form->name); ?></h1>
    </div>
    <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
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
        <div style="flex:1;">
            <strong>Email verification required.</strong>
            Please check <?php echo e($form->recipient_email); ?> and click the verification link.
        </div>
        <form method="POST" action="<?php echo e(route('dashboard.forms.resend-verification', $form->id)); ?>" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-secondary">Resend Email</button>
        </form>
    </div>
<?php endif; ?>


<div class="card mb-3" style="padding:1rem 1.25rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <div style="display:flex;align-items:center;gap:0.75rem;flex:1;min-width:0;">
            <span class="endpoint-method">POST</span>
            <span class="endpoint-url"
                  style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;font-size:0.85rem;">
                <?php echo e($form->endpoint_url); ?>

            </span>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;flex-shrink:0;">
            <span class="badge <?php echo e($form->status === 'active' && $form->email_verified ? 'badge-success' : 'badge-warning'); ?>">
                <span class="badge-dot"></span>
                <?php echo e($form->email_verified ? ucfirst($form->status) : 'Pending Verification'); ?>

            </span>
            <button class="btn btn-ghost btn-sm" onclick="copyEndpoint('<?php echo e($form->slug); ?>')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                </svg>
                Copy URL
            </button>
        </div>
    </div>
</div>


<div class="stats-grid mb-3" style="grid-template-columns: repeat(4, 1fr);">
    <div class="card stat-card">
        <div class="stat-label">Valid Submissions</div>
        <div class="stat-value"><?php echo e(number_format($validCount)); ?></div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Spam Blocked</div>
        <div class="stat-value"><?php echo e(number_format($spamCount)); ?></div>
    </div>
    <div class="card stat-card">
        
        <div class="stat-label" style="display:flex;align-items:center;gap:0.4rem;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                <polyline points="21 8 21 21 3 21 3 8"/>
                <rect x="1" y="3" width="22" height="5"/>
                <line x1="10" y1="12" x2="14" y2="12"/>
            </svg>
            Archived
        </div>
        <div class="stat-value" style="color:#6366f1;"><?php echo e(number_format($archiveCount)); ?></div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Last Submission</div>
        <div class="stat-value" style="font-size:1.1rem;">
            <?php echo e($form->last_submission_at ? $form->last_submission_at->diffForHumans() : 'Never'); ?>

        </div>
    </div>
</div>


<?php $panel = request('panel', 'submissions'); ?>

<nav class="page-tabs-bar">
    <a href="<?php echo e(request()->fullUrlWithQuery(['panel' => 'submissions', 'page' => 1])); ?>"
       class="page-tab <?php echo e($panel === 'submissions' ? 'active' : ''); ?>">
        <i class="bi bi-ui-checks"></i>
        Submissions
        <?php $total = $validCount + $spamCount; ?>
        <?php if($total > 0): ?>
            <span class="tab-pill valid"><?php echo e(number_format($total)); ?></span>
        <?php endif; ?>
    </a>

    <a href="<?php echo e(request()->fullUrlWithQuery(['panel' => 'statistics'])); ?>"
       class="page-tab <?php echo e($panel === 'statistics' ? 'active' : ''); ?>">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
        Statistics
    </a>

    <a href="<?php echo e(request()->fullUrlWithQuery(['panel' => 'code'])); ?>"
       class="page-tab <?php echo e($panel === 'code' ? 'active' : ''); ?>">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="16 18 22 12 16 6"/>
            <polyline points="8 6 2 12 8 18"/>
        </svg>
        Integration Code
    </a>
</nav>


<?php $tab = request('tab', 'valid'); ?>

<div class="page-panel <?php echo e($panel === 'submissions' ? 'active' : ''); ?>">
    <div class="submissions-section">
        <div class="submissions-section-header">

            
            <div class="submission-tabs-bar" style="padding-bottom:0;">
                <div class="submission-tabs">

                    
                    <a href="<?php echo e(request()->fullUrlWithQuery(['panel' => 'submissions', 'tab' => 'valid', 'search' => $search, 'page' => 1])); ?>"
                       class="submission-tab <?php echo e($tab === 'valid' ? 'active' : ''); ?>">
                        Inbox
                        <span class="tab-pill valid"><?php echo e(number_format($validCount)); ?></span>
                    </a>

                    
                    <a href="<?php echo e(request()->fullUrlWithQuery(['panel' => 'submissions', 'tab' => 'spam', 'search' => $search, 'page' => 1])); ?>"
                       class="submission-tab <?php echo e($tab === 'spam' ? 'active' : ''); ?>">
                        Spam
                        <span class="tab-pill spam"><?php echo e(number_format($spamCount)); ?></span>
                    </a>

                    
                    <a href="<?php echo e(request()->fullUrlWithQuery(['panel' => 'submissions', 'tab' => 'archive', 'search' => $search, 'page' => 1])); ?>"
                       class="submission-tab <?php echo e($tab === 'archive' ? 'active' : ''); ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="21 8 21 21 3 21 3 8"/>
                            <rect x="1" y="3" width="22" height="5"/>
                            <line x1="10" y1="12" x2="14" y2="12"/>
                        </svg>
                        Archive
                        <?php if(isset($archiveCount) && $archiveCount > 0): ?>
                            <span class="tab-pill archive"><?php echo e(number_format($archiveCount)); ?></span>
                        <?php endif; ?>
                    </a>
                </div>

                
                <?php if($tab !== 'archive'): ?>
                    <div class="search-wrapper" style="padding-bottom:0.5rem;">
                        <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text"
                               id="liveSearchInput"
                               class="search-input"
                               placeholder="Search by name, email…"
                               value="<?php echo e($search); ?>"
                               autocomplete="off">
                        <?php if($search): ?>
                            <a href="<?php echo e(request()->fullUrlWithQuery(['search' => '', 'page' => 1])); ?>"
                               class="search-clear" title="Clear">✕</a>
                        <?php else: ?>
                            <span class="search-clear" id="clearBtn" style="display:none;" title="Clear">✕</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            
            <?php if($search && $tab !== 'archive'): ?>
                <p class="results-info">
                    <?php if($submissions->total() > 0): ?>
                        <strong><?php echo e($submissions->total()); ?></strong>
                        result<?php echo e($submissions->total() !== 1 ? 's' : ''); ?>

                        for "<strong><?php echo e($search); ?></strong>"
                        in <strong><?php echo e($tab === 'spam' ? 'Spam' : 'Inbox'); ?></strong>
                    <?php else: ?>
                        No results for "<strong><?php echo e($search); ?></strong>"
                        in <strong><?php echo e($tab === 'spam' ? 'Spam' : 'Inbox'); ?></strong>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        </div>

        
        <?php if($tab === 'archive'): ?>
            <div class="archive-toggle-banner">
                <div class="archive-toggle-info">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="21 8 21 21 3 21 3 8"/>
                        <rect x="1" y="3" width="22" height="5"/>
                        <line x1="10" y1="12" x2="14" y2="12"/>
                    </svg>
                    <div>
                        <strong>Archive paused submissions</strong>
                        <p>When enabled, submissions received while the form is paused are stored here instead of being rejected.</p>
                    </div>
                </div>

                <form method="POST"
                      action="<?php echo e(route('dashboard.forms.toggle-archive', $form->id)); ?>"
                      id="archiveToggleForm"
                      style="margin:0;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <label class="toggle-switch" title="<?php echo e(($form->archive_when_paused ?? true) ? 'Disable archiving' : 'Enable archiving'); ?>">
                        <input type="checkbox"
                               id="archiveToggle"
                               name="archive_when_paused"
                               value="1"
                               <?php echo e(($form->archive_when_paused ?? true) ? 'checked' : ''); ?>

                               onchange="document.getElementById('archiveToggleForm').submit()">
                        <span class="toggle-track"></span>
                        <span class="toggle-label" id="toggleLabel">
                            <?php echo e(($form->archive_when_paused ?? true) ? 'On' : 'Off'); ?>

                        </span>
                    </label>
                </form>
            </div>

            
            <?php if(!($form->archive_when_paused ?? true)): ?>
                <div style="padding:0.75rem 1.25rem;background:rgba(245,158,11,0.06);border-bottom:1px solid var(--border-color);display:flex;align-items:center;gap:0.6rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p style="margin:0;font-size:0.82rem;color:var(--text-muted);">
                        Archiving is <strong style="color:#f59e0b;">disabled</strong>.
                        New submissions while paused will be rejected with a public error message.
                    </p>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        
        <?php if($submissions->count() > 0): ?>
            <div class="table-wrapper" style="margin-top:0.5rem;">
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
                            <tr class="<?php echo e($submission->is_spam ? 'spam-row' : ($submission->is_archived ? 'archive-row' : '')); ?>">
                                <td>
                                    <a href="<?php echo e(route('dashboard.submissions.show', [$form->id, $submission->id])); ?>"
                                       class="table-link">
                                        <?php echo e(Str::limit($submission->summary, 60)); ?>

                                    </a>

                                    <?php if(!$submission->is_read && !$submission->is_spam && !$submission->is_archived): ?>
                                        <span class="badge badge-success" style="margin-left:0.5rem;">New</span>
                                    <?php endif; ?>

                                    <?php if($submission->is_spam): ?>
                                        <span style="margin-left:0.5rem;background:rgba(245,158,11,0.15);color:#f59e0b;font-size:0.68rem;padding:0.15rem 0.45rem;border-radius:999px;display:inline;">
                                            Spam
                                        </span>
                                    <?php endif; ?>

                                    <?php if($submission->is_archived): ?>
                                        <span style="margin-left:0.5rem;background:rgba(99,102,241,0.15);color:#6366f1;font-size:0.68rem;padding:0.15rem 0.45rem;border-radius:999px;display:inline;">
                                            Archived
                                        </span>
                                        <?php if(isset($submission->metadata['archived_reason']) && $submission->metadata['archived_reason'] === 'form_paused'): ?>
                                            <span style="font-size:0.72rem;color:var(--text-muted);margin-left:0.35rem;">
                                                · received while paused
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if($submission->spam_reason): ?>
                                        <span style="font-size:0.72rem;color:var(--text-muted);margin-left:0.35rem;">
                                            · <?php echo e($submission->spam_reason); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted" style="white-space:nowrap;">
                                    <?php echo e($submission->created_at->format('M j, Y g:i A')); ?>

                                </td>
                                <td>
                                    <?php if($submission->is_archived): ?>
                                        <span style="font-size:0.8rem;color:#6366f1;">Archived</span>
                                    <?php elseif($submission->is_spam): ?>
                                        <span style="font-size:0.8rem;color:#f59e0b;">Blocked</span>
                                    <?php elseif($submission->email_sent): ?>
                                        <span class="text-muted" style="font-size:0.8rem;">Email sent</span>
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size:0.8rem;">Stored</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <a href="<?php echo e(route('dashboard.submissions.show', [$form->id, $submission->id])); ?>"
                                       class="btn btn-ghost btn-sm">View</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($submissions->hasPages() || $submissions->total() > 0): ?>
                <div class="pagination-footer">
                    <div class="pagination-info">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8"  y1="2" x2="8"  y2="6"/>
                            <line x1="3"  y1="10" x2="21" y2="10"/>
                        </svg>
                        <span>
                            Showing <strong><?php echo e($submissions->firstItem()); ?></strong> to <strong><?php echo e($submissions->lastItem()); ?></strong>
                            of <strong><?php echo e($submissions->total()); ?></strong> results
                        </span>
                    </div>

                    <div class="pagination-controls">
                        <?php if($submissions->onFirstPage()): ?>
                            <span class="pagination-link disabled">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                                <span>Previous</span>
                            </span>
                        <?php else: ?>
                            <a href="<?php echo e($submissions->previousPageUrl()); ?>" class="pagination-link">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                                <span>Previous</span>
                            </a>
                        <?php endif; ?>

                        <div class="pagination-pages">
                            <?php $__currentLoopData = $submissions->getUrlRange(max(1, $submissions->currentPage() - 2), min($submissions->lastPage(), $submissions->currentPage() + 2)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $submissions->currentPage()): ?>
                                    <span class="pagination-link active"><?php echo e($page); ?></span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" class="pagination-link"><?php echo e($page); ?></a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <?php if($submissions->hasMorePages()): ?>
                            <a href="<?php echo e($submissions->nextPageUrl()); ?>" class="pagination-link">
                                <span>Next</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        <?php else: ?>
                            <span class="pagination-link disabled">
                                <span>Next</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            
            <div class="empty-state" style="padding:3rem 1.5rem;">
                <?php if($tab === 'archive'): ?>
                    <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <polyline points="21 8 21 21 3 21 3 8"/>
                        <rect x="1" y="3" width="22" height="5"/>
                        <line x1="10" y1="12" x2="14" y2="12"/>
                    </svg>
                    <h3 class="empty-title">Archive is empty</h3>
                    <p class="empty-description">
                        Submissions received while the form is paused will appear here
                        (as long as archiving is enabled above).
                    </p>
                <?php elseif($search): ?>
                    <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <h3 class="empty-title">No results found</h3>
                    <p class="empty-description">
                        Nothing matched "<strong><?php echo e($search); ?></strong>".
                        <a href="<?php echo e(request()->fullUrlWithQuery(['search' => '', 'page' => 1])); ?>"
                           style="color:#414265;">Clear search</a>
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
</div>


<div class="page-panel <?php echo e($panel === 'statistics' ? 'active' : ''); ?>">

    
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.25rem;">
        <div class="card" style="padding:1rem 1.25rem;">
            <p style="margin:0 0 0.25rem;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);">Valid</p>
            <p style="margin:0;font-size:1.6rem;font-weight:700;color:#22c55e;"><?php echo e(number_format($validCount)); ?></p>
        </div>
        <div class="card" style="padding:1rem 1.25rem;">
            <p style="margin:0 0 0.25rem;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);">Spam</p>
            <p style="margin:0;font-size:1.6rem;font-weight:700;color:#f59e0b;"><?php echo e(number_format($spamCount)); ?></p>
        </div>
        <div class="card" style="padding:1rem 1.25rem;">
            <p style="margin:0 0 0.25rem;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);">Archived</p>
            <p style="margin:0;font-size:1.6rem;font-weight:700;color:#6366f1;"><?php echo e(number_format($archiveCount)); ?></p>
        </div>
    </div>

    
    <div class="charts-grid"
         style="display:grid;grid-template-columns:2fr 1fr;gap:1.25rem;align-items:start;">

        
        <div class="card" style="padding:1.25rem;">
            <div style="margin-bottom:1rem;">
                <h4 style="margin:0;font-size:0.875rem;font-weight:600;">Submissions — Last 7 Days</h4>
                <p class="text-muted" style="margin:0.2rem 0 0;font-size:0.75rem;">Valid submissions per day</p>
            </div>
            <div style="position:relative;height:220px;">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        
        <div class="card" style="padding:1.25rem;">
            <div style="margin-bottom:1rem;">
                <h4 style="margin:0;font-size:0.875rem;font-weight:600;">All-time Breakdown</h4>
                <p class="text-muted" style="margin:0.2rem 0 0;font-size:0.75rem;">Valid · Spam · Archived</p>
            </div>
            <div style="position:relative;height:220px;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    

</div>


<div class="page-panel <?php echo e($panel === 'code' ? 'active' : ''); ?>">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Integration Code</h4>
            <p class="text-muted" style="font-size:0.875rem;margin:0.25rem 0 0;">
                Copy and paste one of these snippets into your website.
            </p>
        </div>
        <div style="padding:1.25rem;">
            <div class="code-tabs">
                <button class="code-tab active" onclick="switchCodeTab('html', event)">Plain HTML</button>
                <button class="code-tab" onclick="switchCodeTab('ajax', event)">HTML + AJAX</button>
                <button class="code-tab" onclick="switchCodeTab('fileupload', event)">File Upload</button>
            </div>

            
            <div id="code-html" class="code-block active">
                <div class="code-header">
                    <span class="code-lang">HTML</span>
                    <button class="code-copy" onclick="copyCode('html-code')">Copy</button>
                </div>
                <div class="code-content" id="html-code">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"<?php echo e($form->endpoint_url); ?>"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span>  <span class="attr">name</span>=<span class="string">"name"</span>    <span class="attr">placeholder</span>=<span class="string">"Your name"</span>    <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span>   <span class="attr">placeholder</span>=<span class="string">"Your email"</span>   <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  <?php if($form->honeypot_enabled): ?>
  <span class="comment">&lt;!-- Honeypot (spam protection) --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"<?php echo e($form->honeypot_field); ?>"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span>
  <?php endif; ?>
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
                </div>
            </div>

            
            <div id="code-ajax" class="code-block">
                <div class="code-header">
                    <span class="code-lang">HTML + JavaScript</span>
                    <button class="code-copy" onclick="copyCode('ajax-code')">Copy</button>
                </div>
                <div class="code-content" id="ajax-code">
<pre><span class="tag">&lt;form</span> <span class="attr">id</span>=<span class="string">"form-<?php echo e($form->slug); ?>"</span> <span class="attr">action</span>=<span class="string">"<?php echo e($form->endpoint_url); ?>"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span>  <span class="attr">name</span>=<span class="string">"name"</span>    <span class="attr">placeholder</span>=<span class="string">"Your name"</span>    <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span>   <span class="attr">placeholder</span>=<span class="string">"Your email"</span>   <span class="attr">required</span><span class="tag">&gt;</span>
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
    <span class="keyword">const</span> form = <span class="keyword">this</span>, box = <span class="keyword">document</span>.getElementById(<span class="string">'form-response-<?php echo e($form->slug); ?>'</span>);
    <span class="keyword">const</span> btn = form.querySelector(<span class="string">'button[type="submit"]'</span>);
    btn.disabled = <span class="keyword">true</span>; btn.textContent = <span class="string">'Sending...'</span>;
    <span class="keyword">try</span> {
        <span class="keyword">const</span> res  = <span class="keyword">await</span> fetch(form.action, { method:<span class="string">'POST'</span>, body:<span class="keyword">new</span> FormData(form), headers:{<span class="string">'Accept'</span>:<span class="string">'application/json'</span>} });
        <span class="keyword">const</span> data = <span class="keyword">await</span> res.json();
        <span class="keyword">if</span> (res.ok &amp;&amp; data.success) { box.innerHTML = <span class="string">'&lt;span style="color:#22c55e"&gt;✓ <?php echo e($form->success_message ?? "Thank you!"); ?>&lt;/span&gt;'</span>; form.reset(); }
        <span class="keyword">else throw new</span> Error(data.error || <span class="string">'Something went wrong'</span>);
    } <span class="keyword">catch</span>(err) { box.innerHTML = <span class="string">'&lt;span style="color:#ef4444"&gt;✗ '</span> + err.message + <span class="string">'&lt;/span&gt;'</span>; }
    <span class="keyword">finally</span> { btn.disabled = <span class="keyword">false</span>; btn.textContent = <span class="string">'Send Message'</span>; }
});
<span class="tag">&lt;/script&gt;</span></pre>
                </div>
            </div>

            
            <div id="code-fileupload" class="code-block">
                <div class="code-header">
                    <span class="code-lang">HTML (File Upload)</span>
                    <button class="code-copy" onclick="copyCode('fileupload-code')">Copy</button>
                </div>
                <div class="code-content" id="fileupload-code">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"<?php echo e($form->endpoint_url); ?>"</span> <span class="attr">method</span>=<span class="string">"POST"</span> <span class="attr">enctype</span>=<span class="string">"multipart/form-data"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span>  <span class="attr">name</span>=<span class="string">"name"</span>    <span class="attr">placeholder</span>=<span class="string">"Your name"</span>    <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span>   <span class="attr">placeholder</span>=<span class="string">"Your email"</span>   <span class="attr">required</span><span class="tag">&gt;</span>
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
</div>


<script>
const primaryColor  = '#414265';
const successColor  = '#22c55e';
const warningColor  = '#f59e0b';
const archiveColor  = '#6366f1';
const mutedColor    = '#94a3b8';

// ── Charts (only rendered when canvas is present = statistics panel) ──
if (document.getElementById('lineChart')) {

    // Line chart — valid submissions last 7 days
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($lineLabels, 15, 512) ?>,
            datasets: [{
                label: 'Submissions',
                data: <?php echo json_encode($lineData, 15, 512) ?>,
                borderColor: primaryColor,
                backgroundColor: 'rgba(65,66,101,0.08)',
                tension: 0.4, fill: true,
                pointRadius: 4, pointHoverRadius: 6,
                pointBackgroundColor: primaryColor, borderWidth: 2,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', titleColor: '#94a3b8', bodyColor: '#f1f5f9', padding: 10, cornerRadius: 6 } },
            scales: {
                x: { grid: { display: false }, ticks: { color: mutedColor, font: { size: 11 } }, border: { display: false } },
                y: { ticks: { color: mutedColor, font: { size: 11 }, callback: val => Number.isInteger(val) ? val : null, stepSize: 1 }, grid: { color: 'rgba(148,163,184,0.08)' }, border: { display: false }, beginAtZero: true }
            }
        }
    });

    // Bar chart — valid vs spam vs archived (all-time)
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Valid', 'Spam', 'Archived'],
            datasets: [{
                data: [<?php echo e($validCount); ?>, <?php echo e($spamCount); ?>, <?php echo e($archiveCount); ?>],
                backgroundColor: [
                    'rgba(34,197,94,0.85)',
                    'rgba(245,158,11,0.85)',
                    'rgba(99,102,241,0.85)',  // ← archive bar
                ],
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 40,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', titleColor: '#94a3b8', bodyColor: '#f1f5f9', padding: 10, cornerRadius: 6 } },
            scales: {
                x: { grid: { display: false }, ticks: { color: mutedColor, font: { size: 12 } }, border: { display: false } },
                y: { ticks: { color: mutedColor, font: { size: 11 }, callback: val => Number.isInteger(val) ? val : null, stepSize: 1 }, grid: { color: 'rgba(148,163,184,0.08)' }, border: { display: false }, beginAtZero: true }
            }
        }
    });

    // Archive trend line — last 7 days (only rendered if canvas exists)
    const archiveCanvas = document.getElementById('archiveLineChart');
    if (archiveCanvas) {
        new Chart(archiveCanvas, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($lineLabels, 15, 512) ?>,
                datasets: [{
                    label: 'Archived',
                    data: <?php echo json_encode($archiveLineData, 15, 512) ?>,
                    borderColor: archiveColor,
                    backgroundColor: 'rgba(99,102,241,0.08)',
                    tension: 0.4, fill: true,
                    pointRadius: 4, pointHoverRadius: 6,
                    pointBackgroundColor: archiveColor, borderWidth: 2,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', titleColor: '#94a3b8', bodyColor: '#f1f5f9', padding: 10, cornerRadius: 6 } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: mutedColor, font: { size: 11 } }, border: { display: false } },
                    y: { ticks: { color: mutedColor, font: { size: 11 }, callback: val => Number.isInteger(val) ? val : null, stepSize: 1 }, grid: { color: 'rgba(148,163,184,0.08)' }, border: { display: false }, beginAtZero: true }
                }
            }
        });
    }
}

// ── Copy endpoint URL ──
function copyEndpoint(slug) {
    navigator.clipboard.writeText(`<?php echo e(url('/f')); ?>/${slug}`);
    const btn = event.currentTarget, orig = btn.innerHTML;
    btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Copied!';
    setTimeout(() => btn.innerHTML = orig, 2000);
}

// ── Code tabs ──
function switchCodeTab(tab, e) {
    document.querySelectorAll('.code-tab').forEach(b => b.classList.remove('active'));
    (e?.currentTarget ?? event.currentTarget).classList.add('active');
    document.querySelectorAll('.code-block').forEach(b => b.classList.remove('active'));
    document.getElementById(`code-${tab}`).classList.add('active');
}

// ── Copy code block ──
function copyCode(id) {
    navigator.clipboard.writeText(document.getElementById(id).innerText);
    const btn = event.currentTarget, orig = btn.textContent;
    btn.textContent = 'Copied!';
    setTimeout(() => btn.textContent = orig, 2000);
}

// ── Live search ──
(function () {
    const input    = document.getElementById('liveSearchInput');
    const clearBtn = document.getElementById('clearBtn');
    if (!input) return;

    const baseUrl  = "<?php echo e(route('dashboard.forms.show', $form->id)); ?>";
    const curTab   = "<?php echo e($tab); ?>";
    const curPanel = "<?php echo e($panel); ?>";
    let timer;

    input.addEventListener('input', function () {
        clearTimeout(timer);
        const val = input.value.trim();
        if (clearBtn) clearBtn.style.display = val ? 'flex' : 'none';
        timer = setTimeout(() => {
            const params = new URLSearchParams({ panel: curPanel, tab: curTab, search: val, page: 1 });
            window.location.href = baseUrl + '?' + params.toString();
        }, 350);
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            const params = new URLSearchParams({ panel: curPanel, tab: curTab, search: '', page: 1 });
            window.location.href = baseUrl + '?' + params.toString();
        });
    }
})();

// ── Archive toggle label ──
(function () {
    const toggle = document.getElementById('archiveToggle');
    const label  = document.getElementById('toggleLabel');
    if (!toggle || !label) return;
    toggle.addEventListener('change', function () {
        label.textContent = this.checked ? 'On' : 'Off';
    });
})();
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/dashboard/forms/show.blade.php ENDPATH**/ ?>