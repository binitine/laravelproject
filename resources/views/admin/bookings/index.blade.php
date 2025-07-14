<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">View Booking</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">Back to Dashboard</a>
        </div>
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->title }}</td>
                    <td>{{ $booking->date }}</td>
                    <td>{{ $booking->status }}</td>
                    <td>
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html> 