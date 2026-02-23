@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="auth-container">

        {{-- Header --}}
        <div class="auth-header">
            <div class="auth-logo">000<span>form</span></div>
        </div>

        {{-- Error state (expired/invalid token) --}}
        <div class="auth-card" id="token-error" style="display:none; text-align:center;">
            <div style="width:48px;height:48px;background:rgba(255,68,68,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--error)" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <h2 style="font-size:1.25rem;margin-bottom:0.5rem;">Link expired</h2>
            <p id="error-message" style="margin-bottom:1.5rem;font-size:0.9rem;">
                This reset link is invalid or has expired. Please request a new one.
            </p>
            <a href="{{ route('password.request') }}" class="btn btn-primary" style="width:100%;">
                Request new link
            </a>
        </div>

        {{-- Reset form --}}
        <div class="auth-card" id="reset-form-wrapper">
            <div style="margin-bottom:1.5rem;">
                <h2 style="font-size:1.25rem;margin-bottom:0.35rem;">Set new password</h2>
                <p style="font-size:0.875rem;color:var(--text-muted);">Must be at least 8 characters.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom:1.25rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" id="reset-form">
                @csrf
                <input type="hidden" name="access_token" id="access_token">

                <div class="form-group">
                    <label class="form-label" for="password">New password</label>
                    <input type="password" id="password" name="password"
                           class="form-input" placeholder="••••••••"
                           required minlength="8" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-input" placeholder="••••••••"
                           required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;" id="submit-btn">
                    Reset password
                </button>
            </form>
        </div>

        <div class="auth-footer">
            <a href="{{ route('login') }}">← Back to login</a>
        </div>

    </div>
</div>

<script>
    const hash      = window.location.hash.substring(1);
    const params    = new URLSearchParams(hash);
    const token     = params.get('access_token');
    const type      = params.get('type');
    const error     = params.get('error');
    const errorDesc = params.get('error_description');

    if (error || !token || type !== 'recovery') {
        document.getElementById('reset-form-wrapper').style.display = 'none';
        document.getElementById('token-error').style.display = 'block';
        if (errorDesc) {
            document.getElementById('error-message').textContent =
                decodeURIComponent(errorDesc.replace(/\+/g, ' '));
        }
    } else {
        document.getElementById('access_token').value = token;
    }
</script>
@endsection