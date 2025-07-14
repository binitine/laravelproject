<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .booking-form {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="booking-form p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">
                            <i class="bi bi-pencil-square text-primary me-2"></i>
                            Edit Booking
                        </h2>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="bi bi-pencil-square text-primary me-1"></i>
                                Booking Title
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $booking->title) }}" 
                                   placeholder="Enter booking title..."
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date" class="form-label fw-bold">
                                <i class="bi bi-calendar-event text-primary me-1"></i>
                                Booking Date
                            </label>
                            <input type="date" 
                                   class="form-control form-control-lg @error('date') is-invalid @enderror" 
                                   id="date" 
                                   name="date" 
                                   value="{{ old('date', $booking->date) }}" 
                                   required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">
                                <i class="bi bi-flag text-primary me-1"></i>
                                Status
                            </label>
                            <select class="form-select form-select-lg @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">Select status...</option>
                                <option value="Pending" {{ old('status', $booking->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Confirmed" {{ old('status', $booking->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="Cancelled" {{ old('status', $booking->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>
                                Update Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 