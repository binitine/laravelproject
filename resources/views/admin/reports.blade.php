<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Reports') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .report-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
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
                <!-- Header -->
                <div class="report-card p-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">Analytics & Reports</h2>
                            <p class="text-muted mb-0">Comprehensive insights into your booking system performance.</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-primary me-2">
                                <i class="bi bi-download me-1"></i>Export PDF
                            </button>
                            <button class="btn btn-success">
                                <i class="bi bi-file-earmark-excel me-1"></i>Export Excel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Date Range Filter -->
                <div class="report-card p-4 mb-4">
                    <h5 class="mb-3">Filter Reports</h5>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" value="{{ now()->subDays(30)->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Report Type</label>
                            <select class="form-control">
                                <option>All Reports</option>
                                <option>Booking Analytics</option>
                                <option>User Analytics</option>
                                <option>Revenue Reports</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">&nbsp;</label>
                            <button class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Generate Report
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="chart-container">
                            <h5 class="mb-3">Monthly Booking Trends</h5>
                            <canvas id="monthlyTrendsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="chart-container">
                            <h5 class="mb-3">User Registration Trends</h5>
                            <canvas id="userRegistrationChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Detailed Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="report-card p-4">
                            <h6 class="text-muted mb-2">Top Performing Users</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Bookings</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $topUsers = \App\Models\User::withCount('bookings')
                                                ->orderBy('bookings_count', 'desc')
                                                ->take(5)
                                                ->get();
                                        @endphp
                                        @foreach($topUsers as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td><span class="badge bg-primary">{{ $user->bookings_count }}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="report-card p-4">
                            <h6 class="text-muted mb-2">Booking Status Summary</h6>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Confirmed</span>
                                    <span>{{ \App\Models\Booking::where('status', 'Confirmed')->count() }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ \App\Models\Booking::count() > 0 ? (\App\Models\Booking::where('status', 'Confirmed')->count() / \App\Models\Booking::count()) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Pending</span>
                                    <span>{{ \App\Models\Booking::where('status', 'Pending')->count() }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: {{ \App\Models\Booking::count() > 0 ? (\App\Models\Booking::where('status', 'Pending')->count() / \App\Models\Booking::count()) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Cancelled</span>
                                    <span>{{ \App\Models\Booking::where('status', 'Cancelled')->count() }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger" style="width: {{ \App\Models\Booking::count() > 0 ? (\App\Models\Booking::where('status', 'Cancelled')->count() / \App\Models\Booking::count()) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="report-card p-4">
                            <h6 class="text-muted mb-2">System Metrics</h6>
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="fs-4 text-primary">{{ \App\Models\Booking::where('created_at', '>=', now()->subDays(7))->count() }}</div>
                                    <small class="text-muted">New This Week</small>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="fs-4 text-success">{{ \App\Models\User::where('created_at', '>=', now()->subDays(7))->count() }}</div>
                                    <small class="text-muted">New Users</small>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="fs-4 text-warning">{{ \App\Models\Booking::where('date', '>=', now()->format('Y-m-d'))->count() }}</div>
                                    <small class="text-muted">Upcoming</small>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="fs-4 text-info">{{ round(\App\Models\Booking::count() / max(\App\Models\User::count(), 1), 1) }}</div>
                                    <small class="text-muted">Avg/User</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Reports Table -->
                <div class="report-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detailed Analytics</h5>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-download me-1"></i>Export
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-printer me-1"></i>Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Metric</th>
                                        <th>Current Period</th>
                                        <th>Previous Period</th>
                                        <th>Change</th>
                                        <th>Trend</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Bookings</td>
                                        <td>{{ \App\Models\Booking::where('created_at', '>=', now()->subDays(30))->count() }}</td>
                                        <td>{{ \App\Models\Booking::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count() }}</td>
                                        <td>
                                            @php
                                                $current = \App\Models\Booking::where('created_at', '>=', now()->subDays(30))->count();
                                                $previous = \App\Models\Booking::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
                                                $change = $previous > 0 ? (($current - $previous) / $previous) * 100 : 0;
                                            @endphp
                                            <span class="badge {{ $change >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $change >= 0 ? '+' : '' }}{{ round($change, 1) }}%
                                            </span>
                                        </td>
                                        <td>
                                            <i class="bi bi-arrow-{{ $change >= 0 ? 'up' : 'down' }}-right text-{{ $change >= 0 ? 'success' : 'danger' }}"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>New Users</td>
                                        <td>{{ \App\Models\User::where('created_at', '>=', now()->subDays(30))->count() }}</td>
                                        <td>{{ \App\Models\User::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count() }}</td>
                                        <td>
                                            @php
                                                $current = \App\Models\User::where('created_at', '>=', now()->subDays(30))->count();
                                                $previous = \App\Models\User::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
                                                $change = $previous > 0 ? (($current - $previous) / $previous) * 100 : 0;
                                            @endphp
                                            <span class="badge {{ $change >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $change >= 0 ? '+' : '' }}{{ round($change, 1) }}%
                                            </span>
                                        </td>
                                        <td>
                                            <i class="bi bi-arrow-{{ $change >= 0 ? 'up' : 'down' }}-right text-{{ $change >= 0 ? 'success' : 'danger' }}"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Confirmed Bookings</td>
                                        <td>{{ \App\Models\Booking::where('status', 'Confirmed')->where('created_at', '>=', now()->subDays(30))->count() }}</td>
                                        <td>{{ \App\Models\Booking::where('status', 'Confirmed')->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count() }}</td>
                                        <td>
                                            @php
                                                $current = \App\Models\Booking::where('status', 'Confirmed')->where('created_at', '>=', now()->subDays(30))->count();
                                                $previous = \App\Models\Booking::where('status', 'Confirmed')->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
                                                $change = $previous > 0 ? (($current - $previous) / $previous) * 100 : 0;
                                            @endphp
                                            <span class="badge {{ $change >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $change >= 0 ? '+' : '' }}{{ round($change, 1) }}%
                                            </span>
                                        </td>
                                        <td>
                                            <i class="bi bi-arrow-{{ $change >= 0 ? 'up' : 'down' }}-right text-{{ $change >= 0 ? 'success' : 'danger' }}"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Monthly Booking Trends Chart
        const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
        new Chart(monthlyTrendsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Bookings',
                    data: [12, 19, 15, 25, 22, 30],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // User Registration Chart
        const userRegistrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
        new Chart(userRegistrationCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Users',
                    data: [8, 12, 10, 18, 15, 22],
                    backgroundColor: '#28a745',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

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