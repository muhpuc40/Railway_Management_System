<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/icon type">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Bangladesh Railway">
        </div>

            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('registration') }}">Register</a></li>
                <li><a href="#">Train Information</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
    </nav>
    <main>
        @yield('content')
    </main>

</body>
</html>
