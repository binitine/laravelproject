<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #6a11cb 0%, #2575fc 50%, #43e97b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            background: rgba(255,255,255,0.97);
            border-radius: 1rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            padding: 2.5rem 3rem 2rem 3rem;
            max-width: 650px;
            width: 100%;
            text-align: center;
        }
        .register-card .icon {
            width: 60px;
            margin-bottom: 1rem;
        }
        .register-card h2 {
            color: #2575fc;
            font-weight: 700;
            margin-bottom: 1.2rem;
            font-size: 2.2rem;
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
        .back-btn {
            border-radius: 3rem;
            font-weight: 500;
            margin-top: 1.2rem;
            width: 100%;
        }
        .login-link {
            color: #2575fc;
            font-size: 0.97rem;
        }
        .register-card p {
            color: #444;
            margin-bottom: 1.5rem;
            font-size: 1.15rem;
            line-height: 1.6;
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
        }
        @media (max-width: 500px) {
            .register-card {
                padding: 1.2rem 0.5rem 1rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-card mx-auto">
        <img src="https://img.icons8.com/color/96/calendar--v1.png" alt="Booking Icon" class="icon">
        <h2>Create Your Account</h2>
        <p class="mb-4" style="color:#444;">Sign up to start booking and managing your appointments.</p>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
            <div class="mb-3 text-start">
                <label for="name" class="form-label">Name</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
        </div>
        <!-- Email Address -->
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
        </div>
        <!-- Password -->
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
        </div>
        <!-- Confirm Password -->
            <div class="mb-3 text-start">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                @error('password_confirmation')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
        </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a class="login-link" href="{{ route('login') }}">Already registered?</a>
                <button type="submit" class="btn btn-primary ms-2">Register</button>
        </div>
    </form>
        <a href="/" class="btn btn-outline-secondary back-btn">Back</a>
    </div>
</body>
</html>
