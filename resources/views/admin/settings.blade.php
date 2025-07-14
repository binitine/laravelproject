<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Settings') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 240px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, width 0.3s ease;
            transform: translateX(-100%);
        }
        .sidebar.show {
            transform: translateX(0);
        }
        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            padding: 2rem 1.5rem 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar .nav {
            flex: 1;
            padding: 0 1rem;
        }
        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            border-radius: 0.75rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .sidebar .user-section {
            padding: 1.5rem 1rem;
            border-top: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: #fff;
        }
        .main-content {
            margin-left: 0;
            padding: 2rem 1rem 1rem 1rem;
            transition: margin-left 0.3s ease;
        }
        .main-content.with-sidebar {
            margin-left: 240px;
        }
        .settings-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .form-switch .form-check-input {
            width: 3rem;
            height: 1.5rem;
        }
        .sidebar-toggle {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.75rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: block;
        }
        .sidebar-toggle:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }
        .sidebar-toggle:active {
            transform: translateY(0);
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding-top: 4rem;
            }
            .overlay.active {
                display: block;
            }
        }
        @media (min-width: 769px) {
            .sidebar {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 240px;
            }
            .sidebar-toggle {
                display: none;
            }
        }
    </style>
    
    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list fs-4"></i>
    </button>
    
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>
    
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <i class="bi bi-shield-check"></i>
            <span>Admin Panel</span>
        </div>
        <nav class="nav flex-column my-2">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.bookings') ? 'active' : '' }}" href="{{ route('admin.bookings') }}">
                <i class="bi bi-calendar-check"></i> <span>All Bookings</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i> <span>Manage Users</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                <i class="bi bi-graph-up"></i> <span>Reports</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                <i class="bi bi-gear"></i> <span>Settings</span>
            </a>
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-arrow-left"></i> <span>Back to Main</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link" style="border:none;background:none;width:100%;text-align:left;">
                    <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                </button>
            </form>
        </nav>
        <div class="user-section mt-auto">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=2c3e50&color=fff" class="user-avatar" alt="Admin">
            <div class="user-info">
                <div style="font-weight:600;color:#fff;">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div style="font-size:0.95em;color:#bdc3c7;">Administrator</div>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Header -->
                <div class="settings-card p-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">System Settings</h2>
                            <p class="text-muted mb-0">Configure your booking system preferences and security settings.</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-primary me-2">
                                <i class="bi bi-save me-1"></i>Save Changes
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- General Settings -->
                    <div class="col-md-6 mb-4">
                        <div class="settings-card p-4">
                            <h5 class="mb-3">
                                <i class="bi bi-gear me-2"></i>General Settings
                            </h5>
                            
                            <div class="mb-3">
                                <label class="form-label">System Name</label>
                                <input type="text" class="form-control" value="Book It Now" placeholder="Enter system name">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Admin Email</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="Admin email">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Time Zone</label>
                                <select class="form-control">
                                    <option>UTC</option>
                                    <option>America/New_York</option>
                                    <option>Europe/London</option>
                                    <option>Asia/Tokyo</option>
                                    <option>Australia/Sydney</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Date Format</label>
                                <select class="form-control">
                                    <option>MM/DD/YYYY</option>
                                    <option>DD/MM/YYYY</option>
                                    <option>YYYY-MM-DD</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Language</label>
                                <select class="form-control">
                                    <option>English</option>
                                    <option>Spanish</option>
                                    <option>French</option>
                                    <option>German</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Settings -->
                    <div class="col-md-6 mb-4">
                        <div class="settings-card p-4">
                            <h5 class="mb-3">
                                <i class="bi bi-calendar-check me-2"></i>Booking Settings
                            </h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Default Booking Status</label>
                                <select class="form-control">
                                    <option>Pending</option>
                                    <option>Confirmed</option>
                                    <option>Cancelled</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Booking Time Slots</label>
                                <input type="text" class="form-control" value="09:00,10:00,11:00,14:00,15:00,16:00" placeholder="Time slots (comma separated)">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Maximum Bookings Per Day</label>
                                <input type="number" class="form-control" value="20" min="1" max="100">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Advance Booking Days</label>
                                <input type="number" class="form-control" value="30" min="1" max="365">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Auto-cancel Pending (hours)</label>
                                <input type="number" class="form-control" value="24" min="1" max="168">
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div class="col-md-6 mb-4">
                        <div class="settings-card p-4">
                            <h5 class="mb-3">
                                <i class="bi bi-bell me-2"></i>Notification Settings
                            </h5>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                    <label class="form-check-label" for="emailNotifications">
                                        Email Notifications
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="smsNotifications">
                                    <label class="form-check-label" for="smsNotifications">
                                        SMS Notifications
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="adminNotifications" checked>
                                    <label class="form-check-label" for="adminNotifications">
                                        Admin Notifications
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="reminderNotifications" checked>
                                    <label class="form-check-label" for="reminderNotifications">
                                        Booking Reminders
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Reminder Time (hours before)</label>
                                <input type="number" class="form-control" value="2" min="1" max="24">
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="col-md-6 mb-4">
                        <div class="settings-card p-4">
                            <h5 class="mb-3">
                                <i class="bi bi-shield-lock me-2"></i>Security Settings
                            </h5>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                                    <label class="form-check-label" for="twoFactorAuth">
                                        Two-Factor Authentication
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="sessionTimeout" checked>
                                    <label class="form-check-label" for="sessionTimeout">
                                        Session Timeout
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Session Timeout (minutes)</label>
                                <input type="number" class="form-control" value="30" min="5" max="480">
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="loginAttempts" checked>
                                    <label class="form-check-label" for="loginAttempts">
                                        Limit Login Attempts
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Max Login Attempts</label>
                                <input type="number" class="form-control" value="5" min="3" max="10">
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auditLog" checked>
                                    <label class="form-check-label" for="auditLog">
                                        Audit Logging
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Maintenance -->
                    <div class="col-md-6 mb-4">
                        <div class="settings-card p-4">
                            <h5 class="mb-3">
                                <i class="bi bi-tools me-2"></i>System Maintenance
                            </h5>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                    <label class="form-check-label" for="maintenanceMode">
                                        Maintenance Mode
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Maintenance Message</label>
                                <textarea class="form-control" rows="3" placeholder="System is under maintenance...">System is under maintenance. Please try again later.</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="autoBackup" checked>
                                    <label class="form-check-label" for="autoBackup">
                                        Automatic Backups
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Backup Frequency</label>
                                <select class="form-control">
                                    <option>Daily</option>
                                    <option>Weekly</option>
                                    <option>Monthly</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <button class="btn btn-warning me-2">
                                    <i class="bi bi-download me-1"></i>Create Backup
                                </button>
                                <button class="btn btn-info">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Clear Cache
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- API Settings -->
                    <div class="col-md-6 mb-4">
                        <div class="settings-card p-4">
                            <h5 class="mb-3">
                                <i class="bi bi-code-slash me-2"></i>API Settings
                            </h5>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="apiEnabled" checked>
                                    <label class="form-check-label" for="apiEnabled">
                                        Enable API Access
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">API Rate Limit (requests per minute)</label>
                                <input type="number" class="form-control" value="60" min="10" max="1000">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">API Key</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="sk_live_1234567890abcdef" readonly>
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <button class="btn btn-outline-primary me-2">
                                    <i class="bi bi-key me-1"></i>Generate New Key
                                </button>
                                <button class="btn btn-outline-danger">
                                    <i class="bi bi-trash me-1"></i>Revoke Key
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary btn-lg me-3">
                        <i class="bi bi-save me-2"></i>Save All Settings
                    </button>
                    <button class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset to Defaults
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Burger Sidebar Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('overlay');
            const mainContent = document.querySelector('.main-content');
            
            // Check if we're on mobile
            function isMobile() {
                return window.innerWidth <= 768;
            }
            
            // Initialize sidebar state
            function initializeSidebar() {
                if (isMobile()) {
                    // On mobile: sidebar is hidden by default
                    sidebar.classList.remove('show');
                    mainContent.classList.remove('with-sidebar');
                } else {
                    // On desktop: sidebar is visible by default
                    sidebar.classList.add('show');
                    mainContent.classList.add('with-sidebar');
                }
            }
            
            // Toggle sidebar visibility
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                mainContent.classList.toggle('with-sidebar');
                overlay.classList.toggle('active');
            }
            
            // Sidebar toggle click handler
            sidebarToggle.addEventListener('click', function() {
                toggleSidebar();
            });
            
            // Overlay click handler (close sidebar)
            overlay.addEventListener('click', function() {
                if (sidebar.classList.contains('show')) {
                    toggleSidebar();
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (isMobile()) {
                    // On mobile: hide sidebar and remove margin
                    sidebar.classList.remove('show');
                    mainContent.classList.remove('with-sidebar');
                    overlay.classList.remove('active');
                } else {
                    // On desktop: show sidebar and add margin
                    sidebar.classList.add('show');
                    mainContent.classList.add('with-sidebar');
                    overlay.classList.remove('active');
                }
            });
            
            // Close sidebar when clicking outside (mobile only)
            document.addEventListener('click', function(event) {
                if (isMobile() && sidebar.classList.contains('show')) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnToggle = sidebarToggle.contains(event.target);
                    
                    if (!isClickInsideSidebar && !isClickOnToggle) {
                        toggleSidebar();
                    }
                }
            });
            
            // Initialize on page load
            initializeSidebar();
            
            // Add smooth animations
            sidebar.addEventListener('transitionend', function() {
                if (!sidebar.classList.contains('show') && !isMobile()) {
                    sidebar.style.visibility = 'hidden';
                } else {
                    sidebar.style.visibility = 'visible';
                }
            });
        });
    </script>
</x-app-layout> 