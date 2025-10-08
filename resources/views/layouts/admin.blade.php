<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - SMP 54 Surabaya')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js', 'resources/js/admin.js'])
</head>
<body class="bg-gray-50">
    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebarOverlay" class="sidebar-overlay hidden opacity-0"></div>

    <!-- Sidebar -->
    <aside id="adminSidebar" class="admin-sidebar">
        <!-- Header -->
        <div class="admin-sidebar-header">
            <div class="admin-logo-wrapper">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-10 h-10">
                <div class="admin-logo-text">
                    <div class="admin-logo-title">Admin Panel</div>
                    <div class="admin-logo-subtitle">SMP 54 Surabaya</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="admin-nav">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="admin-nav-text">Dashboard</span>
                <span class="admin-nav-tooltip">Dashboard</span>
            </a>

            <!-- Kelola Kelas -->
            <a href="{{ route('admin.kelas.index') }}" class="admin-nav-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="admin-nav-text">Kelola Kelas</span>
                <span class="admin-nav-tooltip">Kelola Kelas</span>
            </a>

            <!-- Kelola Murid -->
            <a href="{{ route('admin.murid.index') }}" class="admin-nav-item {{ request()->routeIs('admin.murid.*') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="admin-nav-text">Kelola Murid</span>
                <span class="admin-nav-tooltip">Kelola Murid</span>
            </a>

            <!-- Approval Presensi - BARU -->
            <a href="{{ route('admin.presensi.approval') }}" class="admin-nav-item {{ request()->routeIs('admin.presensi.approval') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="admin-nav-text">Approval Presensi</span>
                <span class="admin-nav-tooltip">Approval Presensi</span>
                @php
                    $pendingCount = \App\Models\Presensi::whereIn('status', ['izin', 'sakit'])->pendingApproval()->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="absolute top-2 right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>


            <!-- Divider
            <div class="admin-nav-divider"></div> -->

            <!-- Rekap Presensi -->
            <a href="{{ route('admin.presensi.index') }}" class="admin-nav-item {{ request()->routeIs('admin.presensi.*') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span class="admin-nav-text">Rekap Presensi</span>
                <span class="admin-nav-tooltip">Rekap Presensi</span>
            </a>

            <!-- Kelola Berita -->
            <a href="{{ route('admin.berita.index') }}" class="admin-nav-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <span class="admin-nav-text">Kelola Berita</span>
                <span class="admin-nav-tooltip">Kelola Berita</span>
            </a>
        </nav>
    </aside>

    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" class="sidebar-toggle">
        <svg id="toggleIcon" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
        </svg>
    </button>

    <!-- Main Content Wrapper -->
    <div id="mainWrapper" class="admin-main-wrapper">
        <div class="admin-main-content">
            <!-- Header -->
            <header class="admin-header">
                <div class="admin-header-content">
                    <div class="flex items-center space-x-4">
                        <!-- Mobile Menu Button -->
                        <button id="mobileSidebarToggle" class="md:hidden text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <h1 class="admin-header-title">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <div class="admin-header-actions">
                        <div class="admin-user-info">
                            <div class="admin-user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span class="admin-user-name hidden sm:block">{{ auth()->user()->name }}</span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="admin-logout-btn">
                                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="admin-content">
                <!-- Success Alert -->
                @if (session('success'))
                    <div class="admin-alert admin-alert-success">
                        <svg class="admin-alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="admin-alert-content">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- Error Alert -->
                @if (session('error'))
                    <div class="admin-alert admin-alert-error">
                        <svg class="admin-alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="admin-alert-content">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Admin JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const mainWrapper = document.getElementById('mainWrapper');
            const toggleBtn = document.getElementById('sidebarToggle');
            const toggleIcon = document.getElementById('toggleIcon');
            const mobileToggle = document.getElementById('mobileSidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');

            // Load saved state
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                toggleIcon.style.transform = 'rotate(180deg)';
            }

            // Desktop Toggle
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                const collapsed = sidebar.classList.contains('collapsed');

                // Rotate icon
                toggleIcon.style.transform = collapsed ? 'rotate(180deg)' : 'rotate(0deg)';

                // Save state
                localStorage.setItem('sidebarCollapsed', collapsed);
            });

            // Mobile Toggle
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('mobile-open');
                    overlay.classList.toggle('hidden');

                    // Fade in/out overlay
                    setTimeout(() => {
                        overlay.classList.toggle('opacity-0');
                    }, 10);
                });
            }

            // Close on overlay click
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.add('opacity-0');
                    setTimeout(() => {
                        overlay.classList.add('hidden');
                    }, 300);
                });
            }

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.admin-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.animation = 'slideOutUp 0.4s ease-out';
                    setTimeout(() => {
                        alert.remove();
                    }, 400);
                }, 5000);
            });
        });

        // Add slideOutUp animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOutUp {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-20px);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
