<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Surveyor</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('css')
</head>

<body>
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('home') }}"><i class="bi bi-chevron-left"></i></a>
        </div>
    </nav>


    <div class="container">
        @yield('content')
    </div>

    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    @stack('scripts')
</body>

</html>
