@extends('layouts.app')

@section('title', 'Pricing - 000form')

@section('content')
    <nav class="nav">
        <div class="nav-inner">
            <a href="/" class="nav-logo"><span>000</span>form</a>
            <ul class="nav-links">
                <li><a href="/#features">Features</a></li>
                <li><a href="{{ route('docs') }}">Docs</a></li>
                <li><a href="{{ route('pricing') }}" style="color: var(--accent);">Pricing</a></li>
            </ul>
            <div class="nav-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
                    <a href="{{ route('signup') }}" class="btn btn-primary">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-inner">
                <div class="nav-logo">
                    <span>000</span>form
                </div>
                
                <ul class="footer-links">
                    <li><a href="{{ route('docs') }}">Documentation</a></li>
                    <li><a href="{{ route('pricing') }}">Pricing</a></li>
                    <li><a href="mailto:support@000form.com">Support</a></li>
                    <li><a href="/privacy">Privacy</a></li>
                    <li><a href="/library">Library</a></li>
                </ul>
                
                <p class="footer-copy">&copy; {{ date('Y') }} 000form. All rights reserved.</p>
            </div>
        </div>
    </footer>
@endsection