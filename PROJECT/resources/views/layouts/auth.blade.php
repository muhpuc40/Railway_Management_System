<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/icon type">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>

<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Bangladesh Railway">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Train Information</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <script src="{{ asset('js/user.js') }}"></script>
</body>

</html>