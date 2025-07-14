<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
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
        #calendar {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 24px rgba(102,126,234,0.10);
            margin-bottom: 2.5rem;
            padding: 1.5rem;
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
                            <i class="bi bi-calendar-plus text-primary me-2"></i>
                            Create New Booking
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

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="bi bi-pencil-square text-primary me-1"></i>
                                Booking Title
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
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
                            <input type="text" 
                                   class="form-control form-control-lg @error('date') is-invalid @enderror" 
                                   id="date" 
                                   name="date" 
                                   value="{{ old('date') }}" 
                                   placeholder="Select a date from the calendar below" 
                                   readonly required>
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
                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>
                                Create Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 500,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                selectable: true,
                select: function(info) {
                    document.getElementById('date').value = info.startStr;
                },
                dateClick: function(info) {
                    document.getElementById('date').value = info.dateStr;
                },
                events: [
                    @foreach(\App\Models\Booking::all() as $booking)
                        {
                            title: @json($booking->title),
                            start: @json($booking->date),
                            color: @if($booking->status == 'Confirmed') '#38c172' @elseif($booking->status == 'Pending') '#f6c23e' @else '#e3342f' @endif
                        },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
</body>
</html> 