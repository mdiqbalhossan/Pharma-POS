<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ setting('site_name') }} - @yield('title')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ photo_url(setting('favicon')) }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @yield('styles')
</head>

<body class="error-page">
    <div id="global-loader">
        <div class="whirly-loader"></div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        @yield('content')
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/theme-script.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    @yield('scripts')
</body>

</html>
