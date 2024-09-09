<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Bangladesh Railway">
        </div>
        <ul>
            <li><a href="{{ '/' }}">Home</a></li>
            <li><a href="#">Train Information</a></li>
            <li><a href="#">Contact Us</a></li>
            
            @auth
            <!-- Logged In User Dropdown -->
            <li class="dropdown">
                <a href="#" class="text">
                    {{ auth()->user()->name }}
                </a>
                <div class="dropdown-menu">
                    <h1 class="dropdown-header text-success ">{{ auth()->user()->name }}</h1>             
                    <a class="btn btn-sm" href="{{ url('logout') }}"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a>
                </div>
            </li>
            @else
            <!-- Login and Registration Links -->
            <li><a href="{{ url('login') }}">Login</a></li>
            <li><a href="{{ url('register') }}">Register</a></li>
            @endauth
        </ul>
    </nav>
    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
