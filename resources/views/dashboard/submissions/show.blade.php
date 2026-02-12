@extends('layouts.dashboard')

@section('title', 'Submission Details')

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('dashboard.forms.show', $form->id) }}" class="text-muted" style="font-size: 0.875rem;">
            ← Back to {{ $form->name }}
        </a>
        <h1 class="page-title">Submission Details</h1>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        @if($submission->reply_to)
            <a href="mailto:{{ $submission->reply_to }}" class="btn btn-primary btn-sm">
                Reply via Email
            </a>
        @endif
        <form method="POST" action="{{ route('dashboard.submissions.spam', [$form->id, $submission->id]) }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm">Mark as Spam</button>
        </form>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; align-items: start;">
    <!-- Submission Data -->
    <div class="card">
        <h4 style="margin-bottom: 1.5rem;">Form Data</h4>
        
        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            @foreach($submission->data as $key => $value)
                @if(!str_starts_with($key, '_'))
                    <div>
                        <div class="form-label" style="margin-bottom: 0.25rem;">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                        <div style="padding: 0.75rem 1rem; background: var(--bg-tertiary); border-radius: 6px; word-break: break-word;">
                            
                            @if(is_array($value))
                                {{-- Handle file upload metadata --}}
                                @if(isset($value['name']) && isset($value['size']) && isset($value['path']))
                                    @php
                                        $extension = strtolower($value['extension'] ?? pathinfo($value['name'], PATHINFO_EXTENSION));
                                        $isImage = strpos($value['type'] ?? '', 'image/') === 0;
                                        $absolutePath = $value['absolute_path'] ?? null;
                                        $fileExists = $absolutePath && file_exists($absolutePath);
                                    @endphp
                                    
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        {{-- File icon based on type --}}
                                        <span style="font-size: 1.5rem;">
                                            @if($isImage)
                                                <i class="bi bi-card-image"></i>
                                            @elseif(in_array($extension, ['pdf']))
                                                <i class="bi bi-file-pdf"></i>
                                            @elseif(in_array($extension, ['doc', 'docx']))
                                                <i class="bi bi-file-earmark-word"></i>
                                            @elseif(in_array($extension, ['xls', 'xlsx', 'csv']))
                                                <i class="bi bi-file-earmark"></i>
                                            @else
                                                <i class="bi bi-paperclip"></i>
                                            @endif
                                        </span>
                                        
                                        <div style="flex: 1;">
                                            <div style="font-weight: 500; color: var(--text);">
                                                {{ $value['name'] }}
                                            </div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.15rem;">
                                                {{ round($value['size'] / 1024, 2) }} KB
                                                @if(isset($value['type']))
                                                    • {{ $value['type'] }}
                                                @endif
                                            </div>
                                            @if(!$fileExists)
                                                <div style="font-size: 0.75rem; color: var(--error); margin-top: 0.25rem;">
                                                    File not found on server
                                                </div>
                                            @endif
                                        </div>
                                        
                                        {{-- Download button using direct download route --}}
                                        <form method="POST" action="{{ route('dashboard.submissions.download', [$form->id, $submission->id]) }}" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="field_name" value="{{ $key }}">
                                            <button type="submit" 
                                                    style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.75rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 4px; color: var(--text); text-decoration: none; font-size: 0.8rem; cursor: pointer;"
                                                    @if(!$fileExists) disabled @endif>
                                                <span><i class="bi bi-download"></i></span>
                                                Download
                                            </button>
                                        </form>
                                    </div>
                                    
                                @else
                                    {{-- Fallback for other arrays --}}
                                    <pre style="margin: 0; font-family: monospace; font-size: 0.85rem;">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                @endif
                                
                            @elseif(filter_var($value, FILTER_VALIDATE_EMAIL))
                                <a href="mailto:{{ $value }}">{{ $value }}</a>
                                
                            @elseif(filter_var($value, FILTER_VALIDATE_URL))
                                <a href="{{ $value }}" target="_blank" rel="noopener noreferrer">{{ $value }}</a>
                                
                            @else
                                {{-- Regular text --}}
                                {!! nl2br(e($value)) !!}
                            @endif
                            
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    
    <!-- Metadata -->
    <div>
        <div class="card mb-3">
            <h4 style="margin-bottom: 1rem;">Details</h4>
            
            <div style="font-size: 0.875rem;">
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                    <span class="text-muted">Submitted</span>
                    <span>{{ $submission->created_at->format('M j, Y g:i A') }}</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                    <span class="text-muted">IP Address</span>
                    <span class="mono">{{ $submission->ip_address ?? 'Unknown' }}</span>
                </div>
                
                @if($submission->referrer)
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                        <span class="text-muted">Referrer</span>
                        <span style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ parse_url($submission->referrer, PHP_URL_HOST) }}
                        </span>
                    </div>
                @endif
                
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                    <span class="text-muted">Email Sent</span>
                    <span>{{ $submission->email_sent ? 'Yes' : 'No' }}</span>
                </div>
                
                {{-- File attachment summary in metadata --}}
                @if($submission->metadata && isset($submission->metadata['has_attachment']) && $submission->metadata['has_attachment'])
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                        <span class="text-muted">Attachment</span>
                        <span style="color: var(--success);">Yes</span>
                    </div>
                    @if(isset($submission->metadata['attachment_name']))
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                            <span class="text-muted">File Name</span>
                            <span style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $submission->metadata['attachment_name'] }}
                            </span>
                        </div>
                    @endif
                    @if(isset($submission->metadata['attachment_size']))
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                            <span class="text-muted">File Size</span>
                            <span>{{ round($submission->metadata['attachment_size'] / 1024, 2) }} KB</span>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        
        <!-- Delete -->
        <div class="card" style="border-color: rgba(255,68,68,0.3);">
            <h4 style="color: var(--error); margin-bottom: 0.75rem; font-size: 0.9rem;">Delete Submission</h4>
            <p class="text-muted" style="font-size: 0.8rem; margin-bottom: 1rem;">This cannot be undone.</p>
            <form id="delete-submission-{{ $submission->id }}" method="POST" action="{{ route('dashboard.submissions.destroy', [$form->id, $submission->id]) }}">
                @csrf
                @method('DELETE')
            </form>
            <button type="button" class="btn btn-danger btn-sm" style="width: 100%;" onclick="deleteSubmission('{{ $form->id }}', '{{ $submission->id }}')">
                Delete
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteSubmission(formId, submissionId) {
    if (confirm('Are you sure you want to delete this submission? This action cannot be undone.')) {
        document.getElementById(`delete-submission-${submissionId}`).submit();
    }
}
</script>
@endpush

@endsection