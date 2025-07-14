<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .card { border-radius: 1rem; }
        .badge-status {
            font-size: 1rem;
            padding: 0.5em 1em;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="bi bi-calendar-event text-primary me-2"></i>
                Booking Details
            </h1>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow p-4">
                    <div class="mb-4 text-center">
                        <h2 class="fw-bold mb-1">{{ $booking->title }}</h2>
                        <span class="badge badge-status
                            @if($booking->status == 'Confirmed') bg-success
                            @elseif($booking->status == 'Pending') bg-warning
                            @elseif($booking->status == 'Cancelled') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ $booking->status }}
                        </span>
                    </div>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="bi bi-calendar-date me-2"></i>Date</span>
                            <span>{{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="bi bi-person me-2"></i>Booked By</span>
                            <span>{{ $booking->user->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="bi bi-envelope me-2"></i>Email</span>
                            <span>{{ $booking->user->email ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="bi bi-clock-history me-2"></i>Created At</span>
                            <span>{{ $booking->created_at->format('M d, Y H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="bi bi-clock me-2"></i>Last Updated</span>
                            <span>{{ $booking->updated_at->format('M d, Y H:i') }}</span>
                        </li>
                    </ul>
                    <div class="text-center mt-4">
                        <a href="{{ route('bookings.index') }}" class="btn btn-primary">
                            <i class="bi bi-list-ul me-1"></i>View All Bookings
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-house me-1"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 