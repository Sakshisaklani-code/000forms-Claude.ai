@extends('layouts.app')

@section('title', 'Contact Us - 000form')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <a href="/" class="auth-logo">
                <span>000</span>form
            </a>
            <p class="text-muted">Send us a message. We'll get back to you soon.</p>
        </div>
        
        <div class="auth-card">
            @if(session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-error mb-3">
                    Please fix the errors below:
                    <ul class="mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="https://formsubmit.co/tsaklani2drish@gmail.com" method="POST">
                @csrf
                
                <div class="two-column-form">
                    <!-- Left Column -->
                    <div class="form-column">
                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <h4 class="form-section-title">Personal Information</h4>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input 
                                        type="text" 
                                        id="first_name" 
                                        name="first_name" 
                                        class="form-input" 
                                        value="{{ old('first_name') }}"
                                        placeholder="John"
                                        required
                                    >
                                </div>
                                
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input 
                                        type="text" 
                                        id="last_name" 
                                        name="last_name" 
                                        class="form-input" 
                                        value="{{ old('last_name') }}"
                                        placeholder="Doe"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="form-input" 
                                    value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    required
                                >
                            </div>
                            
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    class="form-input" 
                                    value="{{ old('phone') }}"
                                    placeholder="+1 (555) 123-4567"
                                >
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="form-column">
                        <!-- Message Section -->
                        <div class="form-section">
                            <h4 class="form-section-title">Your Message</h4>
                            
                            <div class="form-group">
                                <label for="subject" class="form-label">Subject</label>
                                <input 
                                    type="text" 
                                    id="subject" 
                                    name="subject" 
                                    class="form-input" 
                                    value="{{ old('subject') }}"
                                    placeholder="How can we help you?"
                                    required
                                >
                            </div>
                            
                            <div class="form-group">
                                <label for="message" class="form-label">Message</label>
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    class="form-input form-textarea" 
                                    rows="5"
                                    placeholder="Please provide details about your inquiry..."
                                    required
                                >{{ old('message') }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="category" class="form-label">Category</label>
                                <select id="category" name="category" class="form-input" required>
                                    <option value="" disabled selected>Select a category</option>
                                    <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                    <option value="support" {{ old('category') == 'support' ? 'selected' : '' }}>Technical Support</option>
                                    <option value="billing" {{ old('category') == 'billing' ? 'selected' : '' }}>Billing Question</option>
                                    <option value="feedback" {{ old('category') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="urgency" class="form-label">Urgency Level</label>
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input 
                                            type="radio" 
                                            name="urgency" 
                                            value="low" 
                                            {{ old('urgency') == 'low' ? 'checked' : '' }}
                                            checked
                                        >
                                        <span class="radio-label">Low (General inquiry)</span>
                                    </label>
                                    <label class="radio-option">
                                        <input 
                                            type="radio" 
                                            name="urgency" 
                                            value="medium" 
                                            {{ old('urgency') == 'medium' ? 'checked' : '' }}
                                        >
                                        <span class="radio-label">Medium (Need response within 48h)</span>
                                    </label>
                                    <label class="radio-option">
                                        <input 
                                            type="radio" 
                                            name="urgency" 
                                            value="high" 
                                            {{ old('urgency') == 'high' ? 'checked' : '' }}
                                        >
                                        <span class="radio-label">High (Urgent matter)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_cc" value="tsaklani2@email.com">
                <input type="hidden" name="_autoresponse" value="Thank you for reaching out to us. We have received your message and will get back to you shortly.">
                <!-- Honeypot (spam protection) -->
                <input type="text" name="_gotcha" style="display:none">
                
                <!-- Form Submission -->
                <div class="form-submit">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        submit
                    </button>
                </div>
            </form>
        </div>
        
        <div class="auth-footer">
            Need immediate assistance? <a href="tel:+15551234567">Call us at +1 (555) 123-4567</a>
        </div>
    </div>
</div>

<style>
    .two-column-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    
    .form-column {
        display: flex;
        flex-direction: column;
    }
    
    .form-section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #3b3f49;
        margin-bottom: 1.25rem;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #49505c;
        margin-bottom: 0.5rem;
    }
    
    .form-input {
        width: 100%;
        padding: 0.625rem 0.875rem;
        font-size: 0.875rem;
        color: #111827;
        background-color: white;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    .form-input::placeholder {
        color: #9ca3af;
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }
    
    .radio-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .radio-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .radio-option input[type="radio"] {
        width: 1rem;
        height: 1rem;
    }
    
    .radio-label {
        font-size: 0.875rem;
        color: #374151;
    }
    
    .checkbox-option {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .checkbox-option input[type="checkbox"] {
        width: 1rem;
        height: 1rem;
        margin-top: 0.125rem;
    }
    
    .checkbox-label {
        font-size: 0.875rem;
        color: #374151;
        line-height: 1.4;
    }
    
    .checkbox-label a {
        color: #2563eb;
        text-decoration: underline;
    }
    
    .form-submit {
        margin-top: 2rem;
        grid-column: 1 / -1;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }
    
    .loading-spinner {
        margin-left: 0.5rem;
    }
    
    .spinner {
        animation: rotate 2s linear infinite;
    }
    
    .spinner .path {
        stroke: currentColor;
        stroke-linecap: round;
        animation: dash 1.5s ease-in-out infinite;
    }
    .auth-container {
        max-width: 800px; /* increase as needed */
    }

    @keyframes rotate {
        100% {
            transform: rotate(360deg);
        }
    }
    
    @keyframes dash {
        0% {
            stroke-dasharray: 1, 150;
            stroke-dashoffset: 0;
        }
        50% {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: -35;
        }
        100% {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: -124;
        }
    }
    
    @media (max-width: 768px) {
        .two-column-form {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .auth-container {
            padding: 0 1rem;
        }
    }
    
    @media (max-width: 640px) {
        .auth-container {
            padding: 0 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitButton = form.querySelector('.btn-primary');
        const submitText = submitButton.querySelector('.submit-text');
        const loadingSpinner = submitButton.querySelector('.loading-spinner');
        
        form.addEventListener('submit', function(e) {
            // Show loading state
            if (submitText) submitText.style.display = 'none';
            if (loadingSpinner) loadingSpinner.style.display = 'inline-block';
            submitButton.disabled = true;
        });
    });
</script>
@endsection