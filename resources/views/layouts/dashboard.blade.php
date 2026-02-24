<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title', 'Dashboard') - 000form</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon/file-text-fill.svg') }}" type="image/svg+xml">
    <!-- Canonical Tag --> 
    <link rel="canonical" href="https://000form.com/" />
    <!-- Keywords --> 
    <meta name="keywords" content="forms, laravel forms, php form builder, contact forms, form submissions, 000Form">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <!-- Open Graph Tags --> 
    <meta property="og:title" content="000Forms - Smart Form Submissions" /> 
    <meta property="og:description" content="Easily create and manage forms with 000Forms, a Laravel-powered solution." /> 
    <meta property="og:type" content="website" /> 
    <meta property="og:url" content="https://000form.com/" /> 
    <meta property="og:image" content="{{ asset('images/og-image/og-image.jpg') }}" /> 
    <meta property="og:site_name" content="000Forms" />
    <!-- Index and follow for SEO -->
    <meta name="robots" content="index, follow">
    <!-- Schema.org JSON-LD --> 
    <script type="application/ld+json"> 
       { 
            "@context": "https://schema.org", 
            "@type": "Organization", 
            "name": "000Forms", 
            "alternateName": "000Forms", 
            "url": "{{ url('/') }}", 
        }
    </script>
    @stack('styles')
    <style>
        /* Mobile dashboard styles */
        :root {
            --sidebar-width: 280px;
            --sidebar-mobile-width: 85%;
            --header-height: 60px;
        }

        /* Mobile header */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            padding: 0 1rem;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .mobile-header .logo {
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            color: var(--text-primary);
        }

        .mobile-header .logo span {
            color: var(--primary-color);
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 6px;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .mobile-menu-btn:hover {
            background-color: var(--bg-hover);
        }

        .mobile-menu-btn span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--text-primary);
            transition: 0.3s;
            border-radius: 2px;
        }

        .mobile-menu-btn.active span:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .mobile-menu-btn.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* Sidebar overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
            pointer-events: auto;
        }

        /* Dashboard layout */
        .dashboard {
            display: flex;
            min-height: 100vh;
            background: var(--bg-secondary);
        }

        /* Sidebar - Desktop */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-primary);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 999;
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
        }

        .sidebar-logo {
            padding: 1.5rem 1.5rem 1rem;
            font-size: 1.8rem;
            font-weight: 700;
            text-decoration: none;
            color: var(--text-primary);
            display: block;
        }

        .sidebar-logo span {
            color: var(--primary-color);
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav li {
            margin: 0.25rem 0.75rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .sidebar-nav a:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
        }

        .sidebar-nav a.active {
            background: var(--primary-color);
            color: white;
        }

        .sidebar-nav a.active svg {
            stroke: white;
        }

        .sidebar-nav a svg {
            flex-shrink: 0;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 1.5rem 1rem 2rem;
            border-top: 1px solid var(--border-color);
        }

        /* Main content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            background: var(--bg-secondary);
            width: calc(100% - var(--sidebar-width));
            transition: margin-left 0.3s ease;
        }

        /* Alert styles */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: white;
            border-left: 4px solid;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .alert-success {
            border-left-color: #10b981;
            color: #065f46;
        }

        .alert-error {
            border-left-color: #ef4444;
            color: #991b1b;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
            }

            .dashboard {
                padding-top: var(--header-height);
            }

            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-mobile-width);
                max-width: 320px;
                box-shadow: 2px 0 20px rgba(0,0,0,0.15);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-logo {
                display: none; /* Logo is in mobile header */
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }

            /* Adjust sidebar nav for mobile */
            .sidebar-nav a {
                padding: 1rem 1.25rem;
                font-size: 1.1rem;
            }

            .sidebar-footer {
                padding-bottom: 1.5rem;
            }

            /* Improve touch targets */
            .btn, 
            .sidebar-nav a,
            .mobile-menu-btn {
                min-height: 44px;
                min-width: 44px;
            }

            /* Card adjustments for mobile */
            .card {
                padding: 1.25rem;
                margin-bottom: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            /* Table responsiveness */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                margin: 1rem -1rem;
                padding: 0 1rem;
            }

            table {
                min-width: 600px;
            }

            /* Form adjustments */
            .form-group {
                margin-bottom: 1.25rem;
            }

            .form-input,
            .form-select,
            .btn {
                font-size: 16px; /* Prevents zoom on iOS */
                padding: 0.875rem 1rem;
            }

            /* Button groups */
            .btn-group {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn-group .btn {
                width: 100%;
            }

            /* Modal adjustments for mobile */
            .modal-content {
                width: 90%;
                margin: 1rem;
                max-height: 90vh;
                overflow-y: auto;
            }
        }

        /* Small phones */
        @media (max-width: 480px) {
            .main-content {
                padding: 0.75rem;
            }

            .card {
                padding: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            h2 {
                font-size: 1.25rem;
            }

            .stats-card {
                padding: 1rem;
            }

            .stats-card .value {
                font-size: 1.75rem;
            }

            /* Stack action buttons */
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-buttons .btn {
                width: 100%;
            }

            /* Adjust spacing */
            .mb-3 {
                margin-bottom: 1rem;
            }

            .mt-3 {
                margin-top: 1rem;
            }
        }

        /* Landscape mode */
        @media (max-width: 896px) and (orientation: landscape) {
            .sidebar {
                width: 280px;
            }

            .sidebar-nav a {
                padding: 0.75rem 1rem;
            }

            .main-content {
                padding: 1rem;
            }

            /* Adjust modal for landscape */
            .modal-content {
                max-height: 85vh;
            }
        }

        /* Tablet styles */
        @media (min-width: 769px) and (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-left: 240px;
                width: calc(100% - 240px);
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Smooth scrolling for iOS */
        .sidebar,
        .main-content {
            -webkit-overflow-scrolling: touch;
        }

        /* Prevent body scroll when sidebar is open on mobile */
        body.sidebar-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
        }

        /* Logout button styles */
        .logout-btn {
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            color: var(--text-secondary);
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s ease;
            text-align: left;
        }

        .logout-btn:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header">
        <a href="{{ route('dashboard') }}" class="logo">
            <span>000</span>form
        </a>
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <span>000</span>form
            </a>
            
            <nav>
                <ul class="sidebar-nav">
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.forms.*') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"/>
                                <rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.forms.create') }}" class="{{ request()->routeIs('dashboard.forms.create') ? 'active' : '' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="16"/>
                                <line x1="8" y1="12" x2="16" y2="12"/>
                            </svg>
                            New Form
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <ul class="sidebar-nav">
                    <li>
                        <a href="{{ route('docs') }}" target="_blank">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                            Documentation
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <polyline points="16 17 21 12 16 7"/>
                                    <line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                                Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            @if(session('message'))
                <div class="alert alert-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('message') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
    
    <script src="/js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const body = document.body;

            function openSidebar() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
                body.classList.add('sidebar-open');
                menuBtn.classList.add('active');
            }

            function closeSidebar() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                body.classList.remove('sidebar-open');
                menuBtn.classList.remove('active');
            }

            function toggleSidebar() {
                if (sidebar.classList.contains('active')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }

            if (menuBtn && sidebar && overlay) {
                // Toggle sidebar on menu button click
                menuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });

                // Close sidebar when clicking overlay
                overlay.addEventListener('click', closeSidebar);

                // Close sidebar when clicking a link (for mobile)
                sidebar.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Don't close if it's the logout form button
                        if (!this.closest('form')) {
                            closeSidebar();
                        }
                    });
                });

                // Close sidebar on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                        closeSidebar();
                    }
                });

                // Handle window resize
                let resizeTimer;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        if (window.innerWidth > 768) {
                            closeSidebar();
                        }
                    }, 250);
                });

                // Swipe to close on mobile
                let touchStartX = 0;
                let touchEndX = 0;
                
                sidebar.addEventListener('touchstart', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });
                
                sidebar.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].screenX;
                    if (touchStartX - touchEndX > 50) { // Swipe left
                        closeSidebar();
                    }
                }, { passive: true });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>