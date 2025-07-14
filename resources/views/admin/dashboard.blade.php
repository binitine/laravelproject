<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
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
        .sidebar.collapsed {
            width: 70px;
            transform: translateX(0);
        }
        .sidebar.collapsed .logo span,
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .user-section .user-info {
            display: none;
        }
        .sidebar.collapsed .logo {
            justify-content: center;
            padding: 2rem 0 1rem 0;
        }
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem 0;
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
            text-decoration: none;
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
        .main-content.expanded {
            margin-left: 70px;
        }
        .admin-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
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
        .overlay.active {
            display: block;
        }
        @media (max-width: 768px) {
            .main-content.with-sidebar {
                margin-left: 0;
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
    
    <div class="main-content" id="mainContent">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Welcome Section -->
                <div class="admin-card p-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">Welcome back, {{ Auth::user()->name }}!</h2>
                            <p class="text-muted mb-0">Here's what's happening with your booking system today.</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="me-3">
                                    <small class="text-muted">Last updated</small><br>
                                    <strong>{{ now()->format('M d, Y H:i') }}</strong>
                                </div>
                                <i class="bi bi-clock-history fs-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="stat-card h-100 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-0">{{ \App\Models\User::count() }}</h3>
                                    <p class="mb-0">Total Users</p>
                                    <small class="text-white-50">
                                        @php
                                            $newUsers = \App\Models\User::where('created_at', '>=', now()->subDays(7))->count();
                                        @endphp
                                        +{{ $newUsers }} this week
                                    </small>
                                </div>
                                <i class="bi bi-people fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card h-100 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-0">{{ \App\Models\Booking::count() }}</h3>
                                    <p class="mb-0">Total Bookings</p>
                                    <small class="text-white-50">
                                        @php
                                            $newBookings = \App\Models\Booking::where('created_at', '>=', now()->subDays(7))->count();
                                        @endphp
                                        +{{ $newBookings }} this week
                                    </small>
                                </div>
                                <i class="bi bi-calendar-check fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card h-100 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-0">{{ \App\Models\Booking::where('status', 'Confirmed')->count() }}</h3>
                                    <p class="mb-0">Confirmed</p>
                                    <small class="text-white-50">
                                        @php
                                            $confirmedRate = \App\Models\Booking::count() > 0 ? round((\App\Models\Booking::where('status', 'Confirmed')->count() / \App\Models\Booking::count()) * 100, 1) : 0;
                                        @endphp
                                        {{ $confirmedRate }}% success rate
                                    </small>
                                </div>
                                <i class="bi bi-check-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card h-100 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-0">{{ \App\Models\Booking::where('status', 'Pending')->count() }}</h3>
                                    <p class="mb-0">Pending</p>
                                    <small class="text-white-50">
                                        @php
                                            $pendingRate = \App\Models\Booking::count() > 0 ? round((\App\Models\Booking::where('status', 'Pending')->count() / \App\Models\Booking::count()) * 100, 1) : 0;
                                        @endphp
                                        {{ $pendingRate }}% of total
                                    </small>
                                </div>
                                <i class="bi bi-clock fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="chart-container">
                            <h5 class="mb-3">Booking Status Distribution</h5>
                            <canvas id="bookingStatusChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="chart-container">
                            <h5 class="mb-3">Recent Activity (Last 7 Days)</h5>
                            <canvas id="activityChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="admin-card p-4">
                            <h5 class="mb-3">Quick Actions</h5>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-people me-2"></i>Manage Users
                                    </a>
                                </div>
                                <div class="col-6 mb-2">
                                    <a href="{{ route('admin.bookings') }}" class="btn btn-outline-success w-100">
                                        <i class="bi bi-calendar-check me-2"></i>View Bookings
                                    </a>
                                </div>
                                <div class="col-6 mb-2">
                                    <a href="{{ route('bookings.create') }}" class="btn btn-outline-info w-100">
                                        <i class="bi bi-plus-circle me-2"></i>Create Booking
                                    </a>
                                </div>
                                <div class="col-6 mb-2">
                                    <a href="{{ route('admin.reports') }}" class="btn btn-outline-warning w-100">
                                        <i class="bi bi-graph-up me-2"></i>Generate Reports
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="admin-card p-4">
                            <h5 class="mb-3">System Health</h5>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <div class="text-center">
                                        <div class="fs-4 text-success">{{ \App\Models\User::count() }}</div>
                                        <small class="text-muted">Active Users</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="text-center">
                                        <div class="fs-4 text-primary">{{ \App\Models\Booking::where('date', '>=', now()->format('Y-m-d'))->count() }}</div>
                                        <small class="text-muted">Upcoming Bookings</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="text-center">
                                        <div class="fs-4 text-warning">{{ \App\Models\Booking::where('status', 'Pending')->count() }}</div>
                                        <small class="text-muted">Pending Approval</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="text-center">
                                        <div class="fs-4 text-info">{{ \App\Models\Booking::where('created_at', '>=', now()->subDays(1))->count() }}</div>
                                        <small class="text-muted">New Today</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings Table -->
                <div class="admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Bookings</h5>
                        <a href="{{ route('admin.bookings') }}" class="btn btn-primary">
                            <i class="bi bi-eye me-1"></i>View All
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $bookings = \App\Models\Booking::with('user')->latest()->take(10)->get();
                                    @endphp
                                    @forelse($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->title }}</td>
                                        <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                        <td>{{ $booking->date }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($booking->status == 'Confirmed') bg-success
                                                @elseif($booking->status == 'Pending') bg-warning
                                                @elseif($booking->status == 'Cancelled') bg-danger
                                                @else bg-secondary
                                                @endif">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td>{{ $booking->created_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No bookings found.</td>
                                    </tr>
                                    @endforelse
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
        // Booking Status Chart
        const bookingStatusCtx = document.getElementById('bookingStatusChart').getContext('2d');
        new Chart(bookingStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Confirmed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ \App\Models\Booking::where('status', 'Confirmed')->count() }},
                        {{ \App\Models\Booking::where('status', 'Pending')->count() }},
                        {{ \App\Models\Booking::where('status', 'Cancelled')->count() }}
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Activity Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: @json(collect(range(6, 0))->map(function($day) { return now()->subDays($day)->format('M d'); })),
                datasets: [{
                    label: 'New Bookings',
                    data: @json(collect(range(6, 0))->map(function($day) { return \App\Models\Booking::where('created_at', '>=', now()->subDays($day)->startOfDay())->where('created_at', '<', now()->subDays($day-1)->startOfDay())->count(); })),
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
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Burger Sidebar Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('overlay');
            const mainContent = document.getElementById('mainContent');
            
            // Hide sidebar by default
            sidebar.classList.remove('show');
            mainContent.classList.remove('with-sidebar');

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
            
            // Optional: close sidebar when clicking outside (for desktop UX)
            document.addEventListener('click', function(event) {
                if (sidebar.classList.contains('show')) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnToggle = sidebarToggle.contains(event.target);
                    
                    if (!isClickInsideSidebar && !isClickOnToggle) {
                        toggleSidebar();
                    }
                }
            });
            
            // Add smooth animations
            sidebar.addEventListener('transitionend', function() {
                if (!sidebar.classList.contains('show')) {
                    sidebar.style.visibility = 'hidden';
                } else {
                    sidebar.style.visibility = 'visible';
                }
            });
        });
    </script>
</x-app-layout> 