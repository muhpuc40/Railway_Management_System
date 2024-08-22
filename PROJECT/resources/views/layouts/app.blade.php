<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
        <style>
.login-header {
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    align-items: center; /* Center align elements horizontally */
    padding: 20px; /* Adjust padding as needed */
    background-color: #ffff; /* Optional: Set a background color */
    border-radius: 10px; /* Optional: Add rounded corners */
}

.login-header img {
    max-width: 100%; /* Ensure the image scales down responsively */
    height: auto; /* Maintain aspect ratio */
    max-height: 200px; /* Set a maximum height for the image */
    object-fit: contain; /* Ensure the image fits within its container */
    margin-bottom: 10px; /* Add space between image and text */
}

.login-header h2 {
    margin-top: auto; /* Push the text to the bottom */
    font-size: 1.5rem; /* Adjust text size */
    color: #333; /* Set text color */
    margin: 0; /* Remove default margins */
    padding: 10px 0 0; /* Optional: Adjust padding at the top */
}

.register-header {
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    align-items: center; /* Center align elements horizontally */
    padding: 20px; /* Adjust padding as needed */
    background-color: #ffff; /* Optional: Set a background color */
    border-radius: 10px; /* Optional: Add rounded corners */
}

.register-header img {
    max-width: 60%; /* Ensure the image scales down responsively */
    height: auto; /* Maintain aspect ratio */
    max-height: 100px; /* Set a maximum height for the image */
    object-fit: contain; /* Ensure the image fits within its container */
    margin-bottom: 10px; /* Add space between image and text */
}

</style>
</body>

</html>