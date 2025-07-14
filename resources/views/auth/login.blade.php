<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #6a11cb 0%, #2575fc 50%, #43e97b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255,255,255,0.97);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            padding: 2.5rem 2.5rem 2rem 2.5rem;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .login-card .icon {
            width: 60px;
            margin-bottom: 1rem;
        }
        .login-card h2 {
            color: #2575fc;
            font-weight: 700;
            margin-bottom: 1.2rem;
        }
        .form-label {
            font-weight: 600;
            color: #2575fc;
        }
        .form-control {
            border-radius: 1rem;
            box-shadow: 0 1px 4px #2575fc11;
        }
        .btn-primary {
            border-radius: 2rem;
            font-weight: 600;
            padding-left: 2rem;
            padding-right: 2rem;
        }
        .remember-label {
            color: #555;
            font-size: 0.97rem;
        }
        .forgot-link {
            color: #2575fc;
            font-size: 0.97rem;
        }
        @media (max-width: 500px) {
            .login-card {
                padding: 1.2rem 0.5rem 1rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card mx-auto">
        <img src="https://img.icons8.com/color/96/calendar--v1.png" alt="Booking Icon" class="icon">
        <h2>Welcome!</h2>
        <p class="mb-4" style="color:#444;">Log in to manage your bookings and appointments.</p>
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-3">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Address -->
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <!-- Password -->
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <!-- Remember Me -->
            <div class="form-check mb-3 text-start">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label remember-label">Remember me</label>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">Forgot your password?</a>
                @endif
                <button type="submit" class="btn btn-primary ms-2">Log in</button>
            </div>
        </form>
        <a href="/" class="btn btn-outline-secondary mt-3 w-100" style="border-radius:3rem;font-weight:500;">
            Back
        </a>
    </div>
</body>
</html>
