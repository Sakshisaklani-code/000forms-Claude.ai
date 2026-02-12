@extends('layouts.app')

@section('title', 'Authenticating... - 000form')

@section('content')
<div class="auth-page">
    <div class="auth-container text-center">
        <div class="auth-logo mb-3">
            <span>000</span>form
        </div>
        <p class="text-muted">Completing authentication...</p>
        <div class="mt-3 animate-pulse">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin: 0 auto; color: var(--accent);">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 6v6l4 2"/>
            </svg>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Extract tokens from URL hash (Supabase returns them in the fragment)
const hash = window.location.hash.substring(1);
const params = new URLSearchParams(hash);

const accessToken = params.get('access_token');
const refreshToken = params.get('refresh_token');

if (accessToken && refreshToken) {
    // Send tokens to server
    fetch('{{ route("auth.tokens") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            access_token: accessToken,
            refresh_token: refreshToken
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            window.location.href = '{{ route("login") }}?error=auth_failed';
        }
    })
    .catch(error => {
        console.error('Auth error:', error);
        window.location.href = '{{ route("login") }}?error=auth_failed';
    });
} else {
    // Check for error in URL
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error_description') || urlParams.get('error');
    
    if (error) {
        window.location.href = '{{ route("login") }}?error=' + encodeURIComponent(error);
    } else {
        // No tokens and no error, redirect to login
        window.location.href = '{{ route("login") }}';
    }
}
</script>
@endpush
@endsection
