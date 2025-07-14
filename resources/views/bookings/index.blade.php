<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .booking-card {
            transition: transform 0.2s;
        }
        .booking-card:hover {
            transform: translateY(-2px);
        }
        .status-badge {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-0">
                    <i class="bi bi-calendar-event text-primary me-2"></i>
                    All Bookings
                </h1>
                <p class="text-muted mb-0">Manage and view all your bookings</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('bookings.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i>New Booking
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Statistics Row -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4 class="mb-0">{{ $bookings->count() }}</h4>
                        <small>Total Bookings</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h4 class="mb-0">{{ $bookings->where('status', 'Pending')->count() }}</h4>
                        <small>Pending</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4 class="mb-0">{{ $bookings->where('status', 'Confirmed')->count() }}</h4>
                        <small>Confirmed</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h4 class="mb-0">{{ $bookings->where('status', 'Cancelled')->count() }}</h4>
                        <small>Cancelled</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search by Title</label>
                        <input type="text" name="search" class="form-control" placeholder="Search bookings..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date Range</label>
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>
                                    <strong>{{ $booking->title }}</strong>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge status-badge
                                        @if($booking->status == 'Confirmed') bg-success
                                        @elseif($booking->status == 'Pending') bg-warning
                                        @elseif($booking->status == 'Cancelled') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" 
                                                    onclick="return confirm('Are you sure you want to delete this booking?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                    No bookings found.
                                    <br>
                                    <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm mt-2">
                                        Create Your First Booking
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($bookings->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 