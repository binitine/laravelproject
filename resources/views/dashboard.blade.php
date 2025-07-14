<x-app-layout>
    <x-slot name="header">
        <div class="dashboard-header" style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 0.7rem 2rem; background: #fff;">
            <div class="dashboard-header-left" style="display: flex; align-items: center; gap: 0.7rem;">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0" style="margin: 0;">
                    {{ __('Dashboard') }}
                </h2>
            </div>
            <div class="user-dropdown-header" style="display: flex; align-items: center; gap: 0.7rem;">
                <!-- Notification Dropdown -->
                <div class="dropdown" style="position: relative;">
                    <button class="notification-btn" id="notificationDropdownBtn" style="background: none; border: none; position: relative; padding: 0; margin-right: 0.5rem; cursor: pointer;">
                        <i class="bi bi-bell" style="font-size: 1.4rem; color: #333;"></i>
                        <span style="position: absolute; top: -4px; right: -4px; background: #f43f5e; color: #fff; border-radius: 50%; font-size: 0.7rem; padding: 2px 5px; min-width: 18px; text-align: center;">
                            {{ $notifications->count() }}
                        </span>
                    </button>
                    <div id="notificationDropdown" style="display: none; position: absolute; right: 0; top: 120%; background: #fff; min-width: 250px; box-shadow: 0 4px 16px rgba(0,0,0,0.10); border-radius: 0.5rem; z-index: 1000;">
                        <div style="padding: 1rem; border-bottom: 1px solid #eee; font-weight: 600;">Notifications</div>
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            @forelse($notifications as $notification)
                                <li style="padding: 0.7rem 1rem; border-bottom: 1px solid #f3f4f6;">
                                    {{ $notification->data['message'] ?? 'You have a new notification.' }}<br>
                                    <small style="color: #888;">{{ $notification->created_at->diffForHumans() }}</small>
                                </li>
                            @empty
                                <li style="padding: 0.7rem 1rem; color: #888;">No new notifications.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-2 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150" style="gap: 0.5rem;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}" alt="Avatar" style="width:32px; height:32px; border-radius:50%;">
                            <span style="font-weight: 500;">{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #a18cd1 0%, #fbc2eb 30%, #fad0c4 60%, #8fd3f4 85%, #667eea 100%);
            background-attachment: fixed;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 240px;
            background: linear-gradient(135deg, #5f5fc4 0%, #6a82fb 60%, #fc5c7d 100%);
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            box-shadow: 2px 0 8px #e5e7eb33;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(.4,2,.6,1);
        }
        .sidebar-open .sidebar {
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
            border-top: 1px solidhsla(0, 0.00%, 100.00%, 0.20);
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
            margin-left: 240px;
            padding: 2rem 1rem 1rem 1rem;
            transition: filter 0.3s;
        }
        .sidebar-open .main-content {
            filter: blur(2px);
        }
        @media (max-width: 900px) {
            .sidebar { width: 70px; }
            .sidebar .logo span, .sidebar .nav-link span, .sidebar .user-section .user-info { display: none; }
            .main-content { margin-left: 70px; }
            .sidebar .logo { justify-content: center; padding: 2rem 0 1rem 0; }
            .sidebar .nav-link { justify-content: center; padding: 0.75rem 0; }
        }
        .sidebar-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #f3f4f6;
            border: none;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }
        .sidebar-toggle:hover {
            background: #e0e7ef;
            box-shadow: 0 4px 12px rgba(0,0,0,0.10);
        }
        .sidebar-toggle i {
            font-size: 1.5rem;
            color: #333;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.3);
            z-index: 999;
            transition: opacity 0.3s;
            opacity: 0;
        }
        .sidebar-open .sidebar-overlay {
            display: block;
            opacity: 1;
        }
        .user-dropdown-header {
            margin-left: 0;
        }
        .notification-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: #f3f4f6;
            border-radius: 50%;
            transition: background 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .notification-btn:hover {
            background: #e0e7ef;
        }
    </style>
    <!-- Burger Button (always visible) -->

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar (hidden by default, slides in when open) -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <span>Book It Now</span>
        </div>
        <nav class="nav flex-column my-2">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('bookings.create') ? 'active' : '' }}" href="{{ route('bookings.create') }}">
                <i class="bi bi-plus-circle"></i> <span>Create Booking</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.bookings') ? 'active' : '' }}" href="{{ route('admin.bookings') }}">
                <i class="bi bi-people"></i> <span>View Booking</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="bi bi-person-gear"></i> <span>Manage Users</span>
            </a>
         
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                <i class="bi bi-person"></i> <span>Profile</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link" style="border:none;background:none;width:100%;text-align:left;">
                    <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                </button>
            </form>
        </nav>
        <div class="user-section mt-auto">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=2575fc&color=fff" class="user-avatar" alt="User">
            <div class="user-info">
                <div style="font-weight:600;">{{ Auth::user()->name ?? 'User' }}</div>
                <div style="font-size:0.95em;color:#000;">{{ Auth::user()->email ?? '' }}</div>
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

                <!-- Statistics Cards -->
                 
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white h-100">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="card-title mb-0">{{ \App\Models\User::count() }}</h3>
                                        <p class="card-text">Users</p>
                                    </div>
                                    <i class="bi bi-people fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="card-title mb-0">{{ \App\Models\Booking::count() }}</h3>
                                        <p class="card-text">Total Booking</p>
                                    </div>
                                    <i class="bi bi-calendar-check fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="card-title mb-0">{{ \App\Models\Booking::where('status', 'Confirmed')->count() }}</h3>
                                        <p class="card-text">Confirmed</p>
                                    </div>
                                    <i class="bi bi-check-circle fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-danger text-white h-100">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="card-title mb-0">{{ \App\Models\Booking::where('status', 'Cancelled')->count() }}</h3>
                                        <p class="card-text">Cancelled</p>
                                    </div>
                                    <i class="bi bi-x-circle fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings Table -->
                <div class="card">
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
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $bookings = \App\Models\Booking::latest()->take(10)->get();
                                    @endphp
                                    @forelse($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->title }}</td>
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
                                        <td>
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No bookings found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                        <!-- Add Booking Modal -->
                        <div class="modal fade" id="addBookingModal" tabindex="-1" aria-labelledby="addBookingModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="addBookingModalLabel">Add Booking</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form action="{{ route('bookings.store') }}" method="POST">
                                  @csrf
                                  <div class="mb-3 text-start">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" required>
                                  </div>
                                  <div class="mb-3 text-start">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control" required>
                                  </div>
                                  <div class="mb-3 text-start">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control" required>
                                      <option value="Pending">Pending</option>
                                      <option value="Confirmed">Confirmed</option>
                                      <option value="Cancelled">Cancelled</option>
                                    </select>
                                  </div>
                                  <button type="submit" class="btn btn-primary">Add Booking</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const body = document.body;

        function openSidebar() {
            body.classList.add('sidebar-open');
        }
        function closeSidebar() {
            body.classList.remove('sidebar-open');
        }

        sidebarToggle.addEventListener('click', openSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Optional: close sidebar on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closeSidebar();
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('notificationDropdownBtn');
    const dropdown = document.getElementById('notificationDropdown');
    document.addEventListener('click', function(e) {
        if (btn && btn.contains(e.target)) {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        } else if (dropdown && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
});
</script>
</x-app-layout>
