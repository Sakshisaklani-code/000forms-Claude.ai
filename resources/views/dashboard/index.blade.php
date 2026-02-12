@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <a href="{{ route('dashboard.forms.create') }}" class="btn btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Form
    </a>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="card stat-card">
        <div class="stat-label">Total Forms</div>
        <div class="stat-value">{{ $stats['total_forms'] }}</div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Total Submissions</div>
        <div class="stat-value">{{ number_format($stats['total_submissions']) }}</div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">Unread</div>
        <div class="stat-value accent">{{ $stats['total_unread'] }}</div>
    </div>
    <div class="card stat-card">
        <div class="stat-label">This Month</div>
        <div class="stat-value">{{ $stats['forms_this_month'] }} new</div>
    </div>
</div>

<!-- Forms List -->
@if($forms->count() > 0)
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Form Name</th>
                    <th>Endpoint</th>
                    <th>Submissions</th>
                    <th>Status</th>
                    <th>Last Submission</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($forms as $form)
                    <tr>
                        <td>
                            <a href="{{ route('dashboard.forms.show', $form->id) }}" class="table-link">
                                {{ $form->name }}
                            </a>
                            @if($form->unread_count > 0)
                                <span class="badge badge-success" style="margin-left: 0.5rem;">
                                    {{ $form->unread_count }} new
                                </span>
                            @endif
                        </td>
                        <td>
                            <code class="mono" style="font-size: 0.85rem; color: var(--text-muted);">
                                /f/{{ $form->slug }}
                            </code>
                        </td>
                        <td>{{ number_format($form->submission_count) }}</td>
                        <td>
                            @if(!$form->email_verified)
                                <span class="badge badge-warning">
                                    <span class="badge-dot"></span>
                                    Pending Verification
                                </span>
                            @elseif($form->status === 'active')
                                <span class="badge badge-success">
                                    <span class="badge-dot"></span>
                                    Active
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    <span class="badge-dot"></span>
                                    Paused
                                </span>
                            @endif
                        </td>
                        <td class="text-muted">
                            {{ $form->last_submission_at ? $form->last_submission_at->diffForHumans() : 'Never' }}
                        </td>
                        <td class="text-right">
                            <a href="{{ route('dashboard.forms.show', $form->id) }}" class="btn btn-ghost btn-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="card">
        <div class="empty-state">
            <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="empty-title">No forms yet</h3>
            <p class="empty-description">Create your first form endpoint to start collecting submissions.</p>
            <a href="{{ route('dashboard.forms.create') }}" class="btn btn-primary">
                Create Your First Form
            </a>
        </div>
    </div>
@endif

@endsection