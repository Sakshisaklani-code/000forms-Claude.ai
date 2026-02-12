@extends('layouts.app')

@section('title', 'Thank You - 000form')

@section('content')
<div class="auth-page">
    <div class="auth-container text-center">
        <div style="width: 80px; height: 80px; background: rgba(0, 255, 136, 0.15); border-radius: 50%; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        
        <h1 style="font-size: 2rem; margin-bottom: 1rem;">{{ $message }}</h1>
        
        <p class="text-muted" style="margin-bottom: 2rem;">
            Your submission has been received.
        </p>
        
        @if($referer)
            <a href="{{ $referer }}" class="btn btn-secondary">
                ← Go Back
            </a>
        @endif
        
        <p class="text-muted" style="margin-top: 3rem; font-size: 0.8rem;">
            Powered by <a href="{{ route('home') }}">000form</a>
        </p>
    </div>
</div>
@endsection
