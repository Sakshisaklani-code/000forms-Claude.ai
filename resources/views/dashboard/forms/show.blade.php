@extends('layouts.dashboard')

@section('title', $form->name)

@section('content')
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
    .tab-pill.valid { background: rgba(34,197,94,0.15);  color: #22c55e; }
    .tab-pill.spam  { background: rgba(245,158,11,0.15); color: #f59e0b; }

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
    .spam-row td { opacity: 0.65; }
    .spam-row:hover td { opacity: 1; transition: opacity 0.15s; }
    .submissions-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
    }
    .submissions-section-header { padding: 1rem 1.25rem 0; }

    /* ── Improved Pagination footer ── */
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

    .pagination-info svg {
        opacity: 0.6;
    }

    .pagination-info strong {
        color: var(--text);
        font-weight: 600;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-pages {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

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

    .pagination-link svg {
        stroke: currentColor;
    }

    .pagination-link:not(.disabled):not(.active):hover {
        background: var(--bg-tertiary);
        color: var(--text);
        border-color: var(--border-color);
    }

    .pagination-link.active {
        background: #414265;
        color: white;
        border-color: #414265;
    }

    .pagination-link.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .charts-grid { grid-template-columns: 1fr !important; }
        .search-input { width: 180px; }
        .search-input:focus { width: 220px; }
    }
    
    @media (max-width: 640px) {
        .pagination-footer {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }
        
        .pagination-info {
            justify-content: center;
        }
        
        .pagination-controls {
            justify-content: center;
        }
        
        .pagination-link span:not(.pagination-link svg + span) {
            display: none;
        }
        
        .pagination-link svg + span,
        .pagination-link span + svg {
            display: none;
        }
        
        .pagination-link {
            padding: 0.5rem;
        }
    }
</style>

{{-- ══════════════════════════════
     PAGE HEADER
══════════════════════════════ --}}
<div class="page-header">
    <div>
        <a href="{{ route('dashboard') }}" class="text-muted"
           style="font-size:0.875rem;display:inline-flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Back to Dashboard
        </a>
        <h1 class="page-title">{{ $form->name }}</h1>
    </div>
    <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
        <a href="{{ route('dashboard.forms.export', $form->id) }}" class="btn btn-secondary btn-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Export CSV
        </a>
        <a href="{{ route('dashboard.forms.edit', $form->id) }}" class="btn btn-secondary btn-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Settings
        </a>
    </div>
</div>

{{-- Email verification alert --}}
@if(!$form->email_verified)
    <div class="alert alert-warning">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <div style="flex:1;">
            <strong>Email verification required.</strong>
            Please check {{ $form->recipient_email }} and click the verification link.
        </div>
        <form method="POST" action="{{ route('dashboard.forms.resend-verification', $form->id) }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn btn-sm btn-secondary">Resend Email</button>
        </form>
    </div>
@endif

{{-- ══════════════════════════════
     ENDPOINT STRIP
══════════════════════════════ --}}
<div class="card mb-3" style="padding:1rem 1.25rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <div style="display:flex;align-items:center;gap:0.75rem;flex:1;min-width:0;">
            <span class="endpoint-method">POST</span>
            <span class="endpoint-url"
                  style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;font-size:0.85rem;">
                {{ $form->endpoint_url }}
            </span>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;flex-shrink:0;">
            <span class="badge {{ $form->status === 'active' && $form->email_verified ? 'badge-success' : 'badge-warning' }}">
                <span class="badge-dot"></span>
                {{ $form->email_verified ? ucfirst($form->status) : 'Pending Verification' }}
            </span>
            <button class="btn btn-ghost btn-sm" onclick="copyEndpoint('{{ $form->slug }}')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                </svg>
                Copy URL
            </button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════
     STATS STRIP (always visible)
══════════════════════════════ --}}
<div class="stats-grid mb-3">
    <div class="card stat-card">
        <div class="stat-label">Valid Submissions</div>
        <div class="stat-value">{{ number_format($validCount) }}</div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Spam Blocked</div>
        <div class="stat-value">{{ number_format($spamCount) }}</div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Last Submission</div>
        <div class="stat-value" style="font-size:1.1rem;">
            {{ $form->last_submission_at ? $form->last_submission_at->diffForHumans() : 'Never' }}
        </div>
    </div>
</div>

{{-- ══════════════════════════════
     MAIN PAGE TABS
══════════════════════════════ --}}
@php $panel = request('panel', 'submissions'); @endphp

<nav class="page-tabs-bar">
    <a href="{{ request()->fullUrlWithQuery(['panel' => 'submissions', 'page' => 1]) }}"
       class="page-tab {{ $panel === 'submissions' ? 'active' : '' }}">
        <i class="bi bi-ui-checks"></i>
        Submissions
        @php $total = $validCount + $spamCount; @endphp
        @if($total > 0)
            <span class="tab-pill valid">{{ number_format($total) }}</span>
        @endif
    </a>

    <a href="{{ request()->fullUrlWithQuery(['panel' => 'statistics']) }}"
       class="page-tab {{ $panel === 'statistics' ? 'active' : '' }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
        Statistics
    </a>

    <a href="{{ request()->fullUrlWithQuery(['panel' => 'code']) }}"
       class="page-tab {{ $panel === 'code' ? 'active' : '' }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="16 18 22 12 16 6"/>
            <polyline points="8 6 2 12 8 18"/>
        </svg>
        Integration Code
    </a>
</nav>

{{-- ══════════════════════════════
     PANEL: SUBMISSIONS
══════════════════════════════ --}}
<div class="page-panel {{ $panel === 'submissions' ? 'active' : '' }}">
    <div class="submissions-section">
        <div class="submissions-section-header">

            {{-- Sub-tabs + Search --}}
            <div class="submission-tabs-bar" style="padding-bottom:0;">
                <div class="submission-tabs">
                    <a href="{{ request()->fullUrlWithQuery(['panel' => 'submissions', 'tab' => 'valid', 'search' => $search, 'page' => 1]) }}"
                       class="submission-tab {{ $tab === 'valid' ? 'active' : '' }}">
                        Inbox
                        <span class="tab-pill valid">{{ number_format($validCount) }}</span>
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['panel' => 'submissions', 'tab' => 'spam', 'search' => $search, 'page' => 1]) }}"
                       class="submission-tab {{ $tab === 'spam' ? 'active' : '' }}">
                        Spam
                        <span class="tab-pill spam">{{ number_format($spamCount) }}</span>
                    </a>
                </div>

                {{-- Live search input --}}
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
                           value="{{ $search }}"
                           autocomplete="off">
                    @if($search)
                        <a href="{{ request()->fullUrlWithQuery(['search' => '', 'page' => 1]) }}"
                           class="search-clear" title="Clear">✕</a>
                    @else
                        <span class="search-clear" id="clearBtn" style="display:none;" title="Clear">✕</span>
                    @endif
                </div>
            </div>

            {{-- Results info --}}
            @if($search)
                <p class="results-info">
                    @if($submissions->total() > 0)
                        <strong>{{ $submissions->total() }}</strong>
                        result{{ $submissions->total() !== 1 ? 's' : '' }}
                        for "<strong>{{ $search }}</strong>"
                        in <strong>{{ $tab === 'spam' ? 'Spam' : 'Inbox' }}</strong>
                    @else
                        No results for "<strong>{{ $search }}</strong>"
                        in <strong>{{ $tab === 'spam' ? 'Spam' : 'Inbox' }}</strong>
                    @endif
                </p>
            @endif
        </div>

        {{-- Table --}}
        @if($submissions->count() > 0)
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
                        @foreach($submissions as $submission)
                            <tr class="{{ $submission->is_spam ? 'spam-row' : '' }}">
                                <td>
                                    <a href="{{ route('dashboard.submissions.show', [$form->id, $submission->id]) }}"
                                       class="table-link">
                                        {{ Str::limit($submission->summary, 60) }}
                                    </a>
                                    @if(!$submission->is_read && !$submission->is_spam)
                                        <span class="badge badge-success" style="margin-left:0.5rem;">New</span>
                                    @endif
                                    @if($submission->is_spam)
                                        <span style="margin-left:0.5rem;background:rgba(245,158,11,0.15);color:#f59e0b;font-size:0.68rem;padding:0.15rem 0.45rem;border-radius:999px;display:inline;">
                                            Spam
                                        </span>
                                    @endif
                                    @if($submission->spam_reason)
                                        <span style="font-size:0.72rem;color:var(--text-muted);margin-left:0.35rem;">
                                            · {{ $submission->spam_reason }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted" style="white-space:nowrap;">
                                    {{ $submission->created_at->format('M j, Y g:i A') }}
                                </td>
                                <td>
                                    @if($submission->is_spam)
                                        <span style="font-size:0.8rem;color:#f59e0b;">Blocked</span>
                                    @elseif($submission->email_sent)
                                        <span class="text-muted" style="font-size:0.8rem;">Email sent</span>
                                    @else
                                        <span class="text-muted" style="font-size:0.8rem;">Stored</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('dashboard.submissions.show', [$form->id, $submission->id]) }}"
                                       class="btn btn-ghost btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ═════════════════════════════════════════════
                 IMPROVED PAGINATION FOOTER
            ═════════════════════════════════════════════ --}}
            @if($submissions->hasPages() || $submissions->total() > 0)
                <div class="pagination-footer">
                    <div class="pagination-info">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>
                            Showing <strong>{{ $submissions->firstItem() }}</strong> to <strong>{{ $submissions->lastItem() }}</strong>
                            of <strong>{{ $submissions->total() }}</strong> results
                        </span>
                    </div>
                    
                    <div class="pagination-controls">
                        {{-- Previous Page Link --}}
                        @if($submissions->onFirstPage())
                            <span class="pagination-link disabled" aria-disabled="true">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                                <span>Previous</span>
                            </span>
                        @else
                            <a href="{{ $submissions->previousPageUrl() }}" class="pagination-link">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                                <span>Previous</span>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        <div class="pagination-pages">
                            @foreach($submissions->getUrlRange(max(1, $submissions->currentPage() - 2), min($submissions->lastPage(), $submissions->currentPage() + 2)) as $page => $url)
                                @if($page == $submissions->currentPage())
                                    <span class="pagination-link active" aria-current="page">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next Page Link --}}
                        @if($submissions->hasMorePages())
                            <a href="{{ $submissions->nextPageUrl() }}" class="pagination-link">
                                <span>Next</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </a>
                        @else
                            <span class="pagination-link disabled" aria-disabled="true">
                                <span>Next</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            @endif

        @else
            {{-- Empty states --}}
            <div class="empty-state" style="padding:3rem 1.5rem;">
                @if($search)
                    <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <h3 class="empty-title">No results found</h3>
                    <p class="empty-description">
                        Nothing matched "<strong>{{ $search }}</strong>".
                        <a href="{{ request()->fullUrlWithQuery(['search' => '', 'page' => 1]) }}"
                           style="color:#414265;">Clear search</a>
                    </p>
                @elseif($tab === 'spam')
                    <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <h3 class="empty-title">No spam detected</h3>
                    <p class="empty-description">Your spam folder is clean.</p>
                @else
                    <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="empty-title">No submissions yet</h3>
                    <p class="empty-description">Submissions will appear here once your form starts receiving data.</p>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════
     PANEL: STATISTICS
══════════════════════════════ --}}
<div class="page-panel {{ $panel === 'statistics' ? 'active' : '' }}">

    {{-- Charts: 2fr line + 1fr bar --}}
    <div class="charts-grid"
         style="display:grid;grid-template-columns:2fr 1fr;gap:1.25rem;align-items:start;">

        {{-- Line Chart --}}
        <div class="card" style="padding:1.25rem;">
            <div style="margin-bottom:1rem;">
                <h4 style="margin:0;font-size:0.875rem;font-weight:600;">
                    Submissions — Last 7 Days
                </h4>
                <p class="text-muted" style="margin:0.2rem 0 0;font-size:0.75rem;">
                    Valid submissions per day
                </p>
            </div>
            <div style="position:relative;height:220px;">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="card" style="padding:1.25rem;">
            <div style="margin-bottom:1rem;">
                <h4 style="margin:0;font-size:0.875rem;font-weight:600;">Valid vs Spam</h4>
                <p class="text-muted" style="margin:0.2rem 0 0;font-size:0.75rem;">
                    All-time breakdown
                </p>
            </div>
            <div style="position:relative;height:220px;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════
     PANEL: CODE
══════════════════════════════ --}}
<div class="page-panel {{ $panel === 'code' ? 'active' : '' }}">
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

            {{-- Plain HTML --}}
            <div id="code-html" class="code-block active">
                <div class="code-header">
                    <span class="code-lang">HTML</span>
                    <button class="code-copy" onclick="copyCode('html-code')">Copy</button>
                </div>
                <div class="code-content" id="html-code">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"{{ $form->endpoint_url }}"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span>  <span class="attr">name</span>=<span class="string">"name"</span>    <span class="attr">placeholder</span>=<span class="string">"Your name"</span>    <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span>   <span class="attr">placeholder</span>=<span class="string">"Your email"</span>   <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  @if($form->honeypot_enabled)
  <span class="comment">&lt;!-- Honeypot (spam protection) --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"{{ $form->honeypot_field }}"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span>
  @endif
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
                </div>
            </div>

            {{-- AJAX --}}
            <div id="code-ajax" class="code-block">
                <div class="code-header">
                    <span class="code-lang">HTML + JavaScript</span>
                    <button class="code-copy" onclick="copyCode('ajax-code')">Copy</button>
                </div>
                <div class="code-content" id="ajax-code">
<pre><span class="tag">&lt;form</span> <span class="attr">id</span>=<span class="string">"form-{{ $form->slug }}"</span> <span class="attr">action</span>=<span class="string">"{{ $form->endpoint_url }}"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span>  <span class="attr">name</span>=<span class="string">"name"</span>    <span class="attr">placeholder</span>=<span class="string">"Your name"</span>    <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span>   <span class="attr">placeholder</span>=<span class="string">"Your email"</span>   <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  @if($form->honeypot_enabled)
  <span class="comment">&lt;!-- Honeypot (spam protection) --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"{{ $form->honeypot_field }}"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span>
  @endif
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span>
<span class="tag">&lt;div</span> <span class="attr">id</span>=<span class="string">"form-response-{{ $form->slug }}"</span> <span class="attr">style</span>=<span class="string">"margin-top:15px"</span><span class="tag">&gt;&lt;/div&gt;</span>
<span class="tag">&lt;script&gt;</span>
<span class="keyword">document</span>.getElementById(<span class="string">'form-{{ $form->slug }}'</span>).addEventListener(<span class="string">'submit'</span>, <span class="keyword">async function</span>(e) {
    e.preventDefault();
    <span class="keyword">const</span> form = <span class="keyword">this</span>, box = <span class="keyword">document</span>.getElementById(<span class="string">'form-response-{{ $form->slug }}'</span>);
    <span class="keyword">const</span> btn = form.querySelector(<span class="string">'button[type="submit"]'</span>);
    btn.disabled = <span class="keyword">true</span>; btn.textContent = <span class="string">'Sending...'</span>;
    <span class="keyword">try</span> {
        <span class="keyword">const</span> res  = <span class="keyword">await</span> fetch(form.action, { method:<span class="string">'POST'</span>, body:<span class="keyword">new</span> FormData(form), headers:{<span class="string">'Accept'</span>:<span class="string">'application/json'</span>} });
        <span class="keyword">const</span> data = <span class="keyword">await</span> res.json();
        <span class="keyword">if</span> (res.ok &amp;&amp; data.success) { box.innerHTML = <span class="string">'&lt;span style="color:#22c55e"&gt;✓ {{ $form->success_message ?? "Thank you!" }}&lt;/span&gt;'</span>; form.reset(); }
        <span class="keyword">else throw new</span> Error(data.error || <span class="string">'Something went wrong'</span>);
    } <span class="keyword">catch</span>(err) { box.innerHTML = <span class="string">'&lt;span style="color:#ef4444"&gt;✗ '</span> + err.message + <span class="string">'&lt;/span&gt;'</span>; }
    <span class="keyword">finally</span> { btn.disabled = <span class="keyword">false</span>; btn.textContent = <span class="string">'Send Message'</span>; }
});
<span class="tag">&lt;/script&gt;</span></pre>
                </div>
            </div>

            {{-- File Upload --}}
            <div id="code-fileupload" class="code-block">
                <div class="code-header">
                    <span class="code-lang">HTML (File Upload)</span>
                    <button class="code-copy" onclick="copyCode('fileupload-code')">Copy</button>
                </div>
                <div class="code-content" id="fileupload-code">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"{{ $form->endpoint_url }}"</span> <span class="attr">method</span>=<span class="string">"POST"</span> <span class="attr">enctype</span>=<span class="string">"multipart/form-data"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span>  <span class="attr">name</span>=<span class="string">"name"</span>    <span class="attr">placeholder</span>=<span class="string">"Your name"</span>    <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span>   <span class="attr">placeholder</span>=<span class="string">"Your email"</span>   <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span> <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  <span class="comment">&lt;!-- Single file --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"file"</span> <span class="attr">name</span>=<span class="string">"upload"</span><span class="tag">&gt;</span>
  <span class="comment">&lt;!-- OR multiple files --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"file"</span> <span class="attr">name</span>=<span class="string">"upload[]"</span> <span class="attr">multiple</span><span class="tag">&gt;</span>
  @if($form->honeypot_enabled)
  <span class="comment">&lt;!-- Honeypot (spam protection) --&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"{{ $form->honeypot_field }}"</span> <span class="attr">style</span>=<span class="string">"display:none"</span><span class="tag">&gt;</span>
  @endif
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send Message<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════
     SCRIPTS
══════════════════════════════ --}}
<script>
const primaryColor = '#414265';
const successColor = '#22c55e';
const warningColor = '#f59e0b';
const mutedColor   = '#94a3b8';

// ── Charts (only when canvas present = statistics panel active) ──
if (document.getElementById('lineChart')) {
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: @json($lineLabels),
            datasets: [{
                label: 'Submissions',
                data: @json($lineData),
                borderColor: primaryColor,
                backgroundColor: 'rgba(65,66,101,0.08)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: primaryColor,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#94a3b8',
                    bodyColor: '#f1f5f9',
                    padding: 10,
                    cornerRadius: 6,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: mutedColor, font: { size: 11 } },
                    border: { display: false }
                },
                y: {
                    ticks: {
                        color: mutedColor,
                        font: { size: 11 },
                        callback: val => Number.isInteger(val) ? val : null,
                        stepSize: 1,
                    },
                    grid: { color: 'rgba(148,163,184,0.08)' },
                    border: { display: false },
                    beginAtZero: true,
                }
            }
        }
    });

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Valid', 'Spam'],
            datasets: [{
                data: [{{ $validCount }}, {{ $spamCount }}],
                backgroundColor: [
                    'rgba(34,197,94,0.85)',
                    'rgba(245,158,11,0.85)'
                ],
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 48,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#94a3b8',
                    bodyColor: '#f1f5f9',
                    padding: 10,
                    cornerRadius: 6,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: mutedColor, font: { size: 12 } },
                    border: { display: false }
                },
                y: {
                    ticks: {
                        color: mutedColor,
                        font: { size: 11 },
                        callback: val => Number.isInteger(val) ? val : null,
                        stepSize: 1,
                    },
                    grid: { color: 'rgba(148,163,184,0.08)' },
                    border: { display: false },
                    beginAtZero: true,
                }
            }
        }
    });
}

// ── Copy endpoint URL ──
function copyEndpoint(slug) {
    navigator.clipboard.writeText(`{{ url('/f') }}/${slug}`);
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

// ── Live search with 350ms debounce ──
(function () {
    const input    = document.getElementById('liveSearchInput');
    const clearBtn = document.getElementById('clearBtn');
    if (!input) return;

    const baseUrl  = "{{ route('dashboard.forms.show', $form->id) }}";
    const curTab   = "{{ $tab }}";
    const curPanel = "{{ $panel }}";
    let timer;

    input.addEventListener('input', function () {
        clearTimeout(timer);
        const val = input.value.trim();

        // Show/hide inline clear button
        if (clearBtn) clearBtn.style.display = val ? 'flex' : 'none';

        timer = setTimeout(() => {
            const params = new URLSearchParams({
                panel:  curPanel,
                tab:    curTab,
                search: val,
                page:   1
            });
            window.location.href = baseUrl + '?' + params.toString();
        }, 350);
    });

    // Inline clear button click
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            const params = new URLSearchParams({
                panel:  curPanel,
                tab:    curTab,
                search: '',
                page:   1
            });
            window.location.href = baseUrl + '?' + params.toString();
        });
    }
})();
</script>

@endsection