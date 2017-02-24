<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | Admin</title>

    <!-- Styles -->
    <link href="{{mix('css/admin.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
		window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

<?php
$controller = str_replace('App\\Http\\Controllers\\', '', substr(Route::currentRouteAction(), 0, (strpos(Route::currentRouteAction(), '@'))));
$controllerMethod = str_replace('App\\Http\\Controllers\\', '', substr(Route::currentRouteAction(), (strpos(Route::currentRouteAction(), '@') + 1)));
?>

<body class="nav-md">
<div class="nprogress-mask"></div>
<div class="container body">

    <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
            @include('admin.partials.left_navbar')
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            @include('admin.partials.top_navbar')
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            @include('admin.partials.flash')
            @yield('content')
        </div>
        <!-- footer content -->
        <footer>
            <div class="pull-right">
                © 2017 SHerna team
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>



<!-- Scripts -->
<script src="{{mix('js/app.js')}}"></script>
<script src="{{mix('js/custom.js')}}"></script>

@yield('scripts')
</body>
</html>
