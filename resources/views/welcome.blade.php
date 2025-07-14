<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(120deg, #6a11cb 0%, #2575fc 50%, #43e97b 100%);
        }
        /* Abstract colorful shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.5;
            z-index: 0;
        }
        .shape1 { width: 400px; height: 400px; background: #ffecd2; top: -100px; left: -120px; }
        .shape2 { width: 300px; height: 300px; background: #a1c4fd; bottom: -80px; right: -100px; }
        .shape3 { width: 200px; height: 200px; background: #fcb69f; top: 60%; left: 60%; }
        .shape4 { width: 180px; height: 180px; background: #43e97b; bottom: 10%; left: 10%; }
        .hero {
            background: rgba(255,255,255,0.95);
            border-radius: 1rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            padding: 2.5rem 3rem 2rem 3rem;
            text-align: center;
            max-width: 650px;
            width: 100%;
            z-index: 1;
            position: relative;
        }
        .hero h1 {
            font-weight: 700;
            color: #2575fc;
            margin-bottom: 1.2rem;
            font-size: 2.2rem;
        }
        .hero p {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.15rem;
            line-height: 1.6;
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
        }
        .hero .btn {
            min-width: 120px;
            margin: 0 0.5rem;
        }
        .logo {
            width: 60px;
            margin-bottom: 1rem;
        }
        .footer {
            margin-top: 2.5rem;
            color: #fff;
            font-size: 0.95rem;
            text-align: center;
            opacity: 0.85;
        }
        @media (max-width: 600px) {
            .hero {
                padding: 2rem 1rem 1.5rem 1rem;
            }
        }
            </style>
    </head>
<body>
    <div class="bg-shape shape1"></div>
    <div class="bg-shape shape2"></div>
    <div class="bg-shape shape3"></div>
    <div class="bg-shape shape4"></div>
    <div class="hero mx-auto">
        
        <h1>Welcome to Booking System</h1>
        <p class="lead">Step into a world of seamless scheduling!<br>Book, manage, and enjoy your appointments with ease.<br><span style='color:#2575fc;font-weight:600;'>Your next adventure is just a click away.</span></p>
        <div>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Register</a>
        </div>
        <div class="footer mt-4">&copy; {{ date('Y') }} Booking System. All rights reserved. <span style="font-size:1.2em;"></span></div>
    </div>
    </body>
</html>
