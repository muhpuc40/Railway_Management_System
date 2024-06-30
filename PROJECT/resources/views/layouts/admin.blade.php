<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/admin.js'])
    @vite(['resources/sass/app.scss', 'resources/css/admin.css'])
</head>

<body>

    <body id="body-pd">
        <header class="header" id="header">
            <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
            <h4><b>Bangladesh Railway</b></h4>

            <div class="header_img"> <img src="{{ asset('images/logo.png') }}" class="img-fluid custom-img-size"
                    alt="Promotional Image"> </div>
        </header>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div> <a href="#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span
                            class="nav_logo-name">Mr. Admin</span> </a>
                    <div class="nav_list"> <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i>
                            <span class="nav_name">Dashboard</span> </a> <a href="#" class="nav_link"> <i
                                class='bx bx-user nav_icon'></i> <span class="nav_name">Users</span> </a> <a href="#"
                            class="nav_link"> <i class='bx bx-message-square-detail nav_icon'></i> <span
                                class="nav_name">Messages</span> </a> <a href="#" class="nav_link"> <i
                                class='bx bx-bookmark nav_icon'></i> <span class="nav_name">Bookmark</span> </a> <a
                            href="#" class="nav_link"> <i class='bx bx-folder nav_icon'></i> <span
                                class="nav_name">Files</span> </a> <a href="#" class="nav_link"> <i
                                class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Stats</span> </a>
                    </div>
                </div> 
                <a href="#" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> 
                <span class="nav_name">SignOut</span> </a>
            </nav>
        </div>
        <!--Container Main start-->
        <main class="py-4">
            @yield('content')
        </main>
        <!--Container Main end-->
    </body>

</html>