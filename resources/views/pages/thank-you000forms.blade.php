@extends('layouts.app')

@section('title', 'Thank You - 000form')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <a href="/" class="auth-logo">
                <span>000</span>form
            </a>
        </div>
        
        <div class="auth-card" style="text-align: center;">
            <!-- Success Icon -->
            <div class="success-icon">
                <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="#10b981" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-width="2" fill="rgba(16, 185, 129, 0.1)"/>
                    <path d="M7 13l3 3 7-7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            
            <h2 class="thank-you-title">Thank You!</h2>
            
            <p class="thank-you-message">
                Your message has been successfully submitted. We've sent a confirmation email to 
                <strong>{{ session('email', 'your provided email address') }}</strong>.
            </p>
            
            <div class="submission-details">
                <div class="detail-card">
                    <h4>Submission Details</h4>
                    <ul class="detail-list">
                        <li>
                            <span class="detail-label">Reference ID:</span>
                            <span class="detail-value">{{ 'FORM-' . strtoupper(uniqid()) }}</span>
                        </li>
                        <li>
                            <span class="detail-label">Submitted:</span>
                            <span class="detail-value">{{ now()->format('F j, Y \a\t g:i A') }}</span>
                        </li>
                        @if(session('category'))
                        <li>
                            <span class="detail-label">Category:</span>
                            <span class="detail-value">{{ ucfirst(session('category')) }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="auth-footer">
            Need immediate help? <a href="/contact">Visit our help center</a> or <a href="tel:+15551234567">call our support line</a>.
        </div>
    </div>
</div>

<style>
    .success-icon {
        margin: 2rem auto;
        animation: scaleIn 0.5s ease-out;
    }
    
    .thank-you-title {
        font-size: 2rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1rem;
    }
    
    .thank-you-message {
        color: #6b7280;
        font-size: 1.125rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .submission-details {
        background-color: #f9fafb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin: 2rem 0;
        border: 1px solid #e5e7eb;
    }
    
    .detail-card h4 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
    }
    
    .detail-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .detail-list li {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .detail-list li:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        color: #6b7280;
        font-weight: 500;
    }
    
    .detail-value {
        color: #111827;
        font-weight: 600;
    }
    
    .whats-next {
        margin: 2rem 0;
        text-align: left;
    }
    
    .whats-next h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    
    .steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .step {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        position: relative;
    }
    
    .step-number {
        position: absolute;
        top: -0.75rem;
        left: -0.75rem;
        width: 2rem;
        height: 2rem;
        background-color: #2563eb;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.875rem;
    }
    
    .step-content h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.5rem;
    }
    
    .step-content p {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .btn-secondary {
        background-color: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }
    
    .btn-secondary:hover {
        background-color: #e5e7eb;
    }
    
    @keyframes scaleIn {
        from {
            transform: scale(0);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    @media (max-width: 640px) {
        .thank-you-title {
            font-size: 1.5rem;
        }
        
        .thank-you-message {
            font-size: 1rem;
        }
        
        .steps {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }
        
        .action-buttons .btn {
            text-align: center;
        }
    }
</style>
@endsection