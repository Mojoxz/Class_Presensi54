<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student - SMP 54 Surabaya')</title>
    @vite(['resources/css/app.css', 'resources/css/student.css', 'resources/js/app.js', 'resources/js/student.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="flex h-screen overflow-hidden" id="app">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <!-- Sidebar Header -->
            <div class="sidebar-header">
                <div class="sidebar-header-content">
                    <div id="sidebarProfile" class="sidebar-profile">
                        <div class="profile-avatar-wrapper">
                            @if(auth()->user()->foto_profil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}"
                                     alt="Profile"
                                     class="profile-avatar">
                            @else
                                <div class="profile-avatar-placeholder">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="profile-status"></div>
                        </div>
                        <div class="profile-info">
                            <h2 class="profile-name">{{ auth()->user()->name }}</h2>
                            <p class="profile-class">{{ auth()->user()->kelas->nama_kelas ?? '-' }}</p>
                        </div>
                    </div>
                    <button onclick="sidebarController.toggle()" class="sidebar-toggle-btn" aria-label="Toggle Sidebar">
                        <svg id="sidebarIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <a href="{{ route('student.home') }}"
                   class="nav-item {{ request()->routeIs('student.home') ? 'active' : '' }}"
                   data-page="home">
                    <div class="nav-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span class="nav-text">Home</span>
                    <div class="nav-indicator"></div>
                </a>

                <a href="{{ route('student.dashboard') }}"
                   class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
                   data-page="dashboard">
                    <div class="nav-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="nav-text">Dashboard</span>
                    <div class="nav-indicator"></div>
                </a>

                <a href="{{ route('student.presensi') }}"
                   class="nav-item {{ request()->routeIs('student.presensi') ? 'active' : '' }}"
                   data-page="presensi">
                    <div class="nav-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7l2 2 4-4"></path>
                        </svg>
                    </div>
                    <span class="nav-text">Presensi</span>
                    <div class="nav-indicator"></div>
                </a>

                <a href="{{ route('student.profile') }}"
                   class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}"
                   data-page="profile">
                    <div class="nav-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="nav-text">Profile</span>
                    <div class="nav-indicator"></div>
                </a>
            </nav>

            <!-- Logout Button -->
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <div class="nav-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <span class="nav-text font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-wrapper">
            <!-- Top Header -->
            <header class="main-header">
                <div class="header-content">
                    <div class="header-left">
                        <button onclick="sidebarController.toggle()" class="mobile-menu-btn lg:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div class="header-title-wrapper">
                            <h1 class="header-title">@yield('page-title', 'Dashboard')</h1>
                            <p class="header-datetime" id="datetime"></p>
                        </div>
                    </div>
                    <div class="header-right">
                        <div class="header-user-info">
                            <div class="user-info-text">
                                <p class="user-name">{{ auth()->user()->name }}</p>
                                <p class="user-email">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="user-avatar-small">
                                @if(auth()->user()->foto_profil)
                                    <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}"
                                         alt="Profile"
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-semibold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="main-content">
                <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success">
                        <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="alert-close">×</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="alert-close">×</button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button onclick="this.parentElement.remove()" class="alert-close">×</button>
                    </div>
                @endif

                <div class="content-wrapper">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div id="overlay" class="sidebar-overlay" onclick="sidebarController.toggle()"></div>
</body>
</html>
