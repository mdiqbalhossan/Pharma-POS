<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ setting('site_name') }} - @yield('title')</title>

    <!-- Base URL -->
    <meta name="base-url" content="{{ url('/') }}" id="base-url">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ photo_url(setting('favicon')) }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <!-- animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <!-- Notify CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/simple-notify.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    @stack('plugin')

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @stack('css')
</head>

<body>
    <input type="hidden" id="currency" value="{{ setting('currency_symbol') }}">
    <input type="hidden" id="low_stock_product" value="{{ low_stock_product()->count() }}">
    <input type="hidden" id="near_expired_product" value="{{ near_expired_product()->count() }}">
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('layouts.partials.header')
        <!-- /Header -->
        @if (route('pos.index') != request()->url())
            @include('layouts.partials.sidebar')
        @endif

        @if (route('pos.index') == request()->url())
            <div class="page-wrapper pos-pg-wrapper ms-0">
                <div class="content pos-design p-0">
                    @yield('content')
                </div>
            </div>
        @else
            <div class="page-wrapper">
                <div class="content">
                    @yield('content')
                </div>
            </div>
        @endif

    </div>

    @include('layouts.partials._low_stock_modal')
    <!-- /Main Wrapper -->
    @if (Session::has('success'))
        <input type="hidden" name="type" class="notification_type" value="success">
        <input type="hidden" name="success" class="notification_message" value="{{ session('success') }}">
    @endif

    @if (Session::has('error'))
        <input type="hidden" name="type" class="notification_type" value="error">
        <input type="hidden" name="error" class="notification_message" value="{{ session('error') }}">
    @endif

    @if (Session::has('info'))
        <input type="hidden" name="type" class="notification_type" value="info">
        <input type="hidden" name="info" class="notification_message" value="{{ session('info') }}">
    @endif

    @if (Session::has('warning'))
        <input type="hidden" name="type" class="notification_type" value="warning">
        <input type="hidden" name="warning" class="notification_message" value="{{ session('warning') }}">
    @endif

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

    <!-- Sweetalert 2 -->
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Notify JS -->
    <script src="{{ asset('assets/js/simple-notify.min.js') }}"></script>

    @stack('script')

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/theme-script.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    @stack('js')
</body>

</html>
