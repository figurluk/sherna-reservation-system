<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{mix('css/client.css')}}" rel="stylesheet">

    @yield('styles')
</head>
<body>

@include('client.partials.navbar')

@yield('content')

<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>

@yield('scripts')
</body>
</html>
