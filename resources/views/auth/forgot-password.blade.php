@extends('layouts.app')

@section('title', 'Reset Password - 000form')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <a href="/" class="auth-logo">
                <span>000</span>form
            </a>
            <p class="text-muted">Reset your password</p>
        </div>
        
        <div class="auth-card">
            @if(session('message'))
                <div class="alert alert-success mb-3">
                    {{ session('message') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-error mb-3">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <p class="text-muted mb-3">
                Enter your email address and we'll send you a link to reset your password.
            </p>
            
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required 
                        autofocus
                    >
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Send Reset Link
                </button>
            </form>
        </div>
        
        <div class="auth-footer">
            Remember your password? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>
@endsection
