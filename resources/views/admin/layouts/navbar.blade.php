<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom styles for sidebar */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #212529;
            z-index: 1000;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-radius: 0.375rem;
        }

        .nav-link.collapsed .fa-chevron-down {
            transform: rotate(-90deg);
            transition: transform 0.2s ease-in-out;
        }

        .nav-link:not(.collapsed) .fa-chevron-down {
            transform: rotate(0deg);
            transition: transform 0.2s ease-in-out;
        }

        .collapse {
            transition: height 0.35s ease;
        }

        .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
        }

        /* Mobile responsiveness */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: block !important;
            }
        }

        @media (min-width: 992px) {
            .mobile-toggle {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar bg-dark text-white" id="sidebar">
        <div class="p-3">
            <!-- Brand/Logo -->
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    <h4 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Admin Panel
                    </h4>
                </a>
            </div>

            <!-- Navigation Menu -->
            <ul class="nav nav-pills flex-column">
                <!-- Dashboard -->
                <li class="nav-item mb-1">
                    <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>
                       Dashboard
                    </a>
                </li>

                <!-- User Control Dropdown -->
                <li class="nav-item mb-1">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center collapsed" 
                       data-bs-toggle="collapse" 
                       href="#userControlSubmenu" 
                       role="button" 
                       aria-expanded="false" 
                       aria-controls="userControlSubmenu">
                        <span>
                            <i class="fas fa-users me-2"></i>
                            Users
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    
                    <!-- User Control Submenu -->
                    <div class="collapse" id="userControlSubmenu">
                        <ul class="nav nav-pills flex-column ms-3 mt-2">
                            <li class="nav-item">
                                <a class="nav-link text-light py-2" href="{{ route('admin.users') }}">
                                    <i class="fas fa-user me-2"></i>
                                    User Management
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light py-2" href="{{ route('admin.articles') }}">
                                    <i class="fas fa-newspaper me-2"></i>
                                    Article Management
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light py-2" href="{{ route('admin.comments') }}">
                                    <i class="fas fa-comments me-2"></i>
                                    Comment Management
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Content Control Dropdown -->
                <li class="nav-item mb-1">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center collapsed" 
                       data-bs-toggle="collapse" 
                       href="#contentControlSubmenu" 
                       role="button" 
                       aria-expanded="false" 
                       aria-controls="contentControlSubmenu">
                        <span>
                            <i class="fas fa-file-alt me-2"></i>
                            Contents
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    
                    <!-- Content Control Submenu -->
                    <div class="collapse" id="contentControlSubmenu">
                        <ul class="nav nav-pills flex-column ms-3 mt-2">
                            <li class="nav-item">
                                <a class="nav-link text-light py-2" href="{{ route('admin.news.index') }}">
                                    <i class="fas fa-newspaper me-2"></i>
                                    News Management
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

            <!-- User Info and Logout -->
            <div class="position-absolute bottom-0 start-0 w-100 p-3">
                <div class="border-top pt-3">
                    <div class="d-flex flex-column">
                        {{-- <span class="text-light mb-2 small">
                            <i class="fas fa-user-circle me-2"></i>
                            Welcome, {{ Auth::guard('admin')->user()->name }}
                        </span> --}}
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Mobile Toggle Button -->
        <div class="mobile-toggle bg-white border-bottom p-3 d-lg-none">
            <button class="btn btn-outline-secondary" type="button" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <span class="ms-2 fw-bold">Admin Panel</span>
        </div>

        <!-- Page Content -->
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add active state management
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link[href]');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                    
                    // If it's a submenu item, also expand the parent
                    const parentCollapse = link.closest('.collapse');
                    if (parentCollapse) {
                        parentCollapse.classList.add('show');
                        const parentToggle = document.querySelector(`[data-bs-target="#${parentCollapse.id}"]`);
                        if (parentToggle) {
                            parentToggle.classList.remove('collapsed');
                        }
                    }
                }
            });
        });

        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.mobile-toggle button');
            
            if (window.innerWidth <= 991 && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>