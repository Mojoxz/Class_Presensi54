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
                <svg class="admin-nav-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                </svg>
                <span class="admin-nav-text">Dashboard</span>
                <span class="admin-nav-tooltip">Dashboard</span>
            </a>

            <!-- Kelola Kelas -->
            <a href="{{ route('admin.kelas.index') }}" class="admin-nav-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                </svg>
                <span class="admin-nav-text">Kelola Kelas</span>
                <span class="admin-nav-tooltip">Kelola Kelas</span>
            </a>

            <!-- Kelola Murid -->
            <a href="{{ route('admin.murid.index') }}" class="admin-nav-item {{ request()->routeIs('admin.murid.*') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
                <span class="admin-nav-text">Kelola Murid</span>
                <span class="admin-nav-tooltip">Kelola Murid</span>
            </a>

            <!-- Approval Presensi - DIPERBAIKI: route exact match -->
            <a href="{{ route('admin.presensi.approval') }}" class="admin-nav-item {{ request()->routeIs('admin.presensi.approval') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
                <span class="admin-nav-text">Approval Presensi</span>
                <span class="admin-nav-tooltip">Approval Presensi</span>
                @php
                    $pendingCount = \App\Models\Presensi::whereIn('status', ['izin', 'sakit'])->pendingApproval()->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="notification-badge">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            <!-- Rekap Presensi - DIPERBAIKI: exclude approval route -->
            <a href="{{ route('admin.presensi.index') }}" class="admin-nav-item {{ request()->routeIs('admin.presensi.index') || (request()->routeIs('admin.presensi.*') && !request()->routeIs('admin.presensi.approval')) ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                </svg>
                <span class="admin-nav-text">Rekap Presensi</span>
                <span class="admin-nav-tooltip">Rekap Presensi</span>
            </a>

            <!-- Kelola Berita -->
            <a href="{{ route('admin.berita.index') }}" class="admin-nav-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 14H6v-2h2v2zm0-3H6V9h2v2zm0-3H6V6h2v2zm7 6h-5v-2h5v2zm3-3h-8V9h8v2zm0-3h-8V6h8v2z"/>
                </svg>
                <span class="admin-nav-text">Kelola Berita</span>
                <span class="admin-nav-tooltip">Kelola Berita</span>
            </a>


            <a href="{{ route('admin.kontak.index') }}" class="admin-nav-item {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">
                <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="admin-nav-text">Pesan Kontak</span>
                <span class="admin-nav-tooltip">Pesan Kontak</span>
                @php
                    $unreadKontak = \App\Models\Kontak::where('is_read', false)->count();
                @endphp
                @if($unreadKontak > 0)
                    <span class="absolute top-2 right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                        {{ $unreadKontak }}
                    </span>
                @endif
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
