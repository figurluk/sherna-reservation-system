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
	<link href="{{asset('gentellela/custom.css')}}" rel="stylesheet">
	
	<!-- Scripts -->
	<script>
		window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
	</script>
	
	@yield('styles')
</head>

<?php
$controller = str_replace('App\\Http\\Controllers\\', '', substr(Route::currentRouteAction(), 0, ( strpos(Route::currentRouteAction(), '@') )));
$controllerMethod = str_replace('App\\Http\\Controllers\\', '', substr(Route::currentRouteAction(), ( strpos(Route::currentRouteAction(), '@') + 1 )));
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

@yield('modals')


<script type="text/javascript">
	var locale                       = "{{Session::get('lang')}}";
	var pickerLocale                 = "{{Config::get('app.locale') =='cz' ? 'cs' : Config::get('app.locale')}}";
	var userUrl                      = "{{action('Client\ClientController@postUserData')}}";
	var createEventUrl               = "{{action('Client\ClientController@postCreateEvent')}}";
	var updateEventUrl               = "{{action('Client\ClientController@postUpdateEvent')}}";
	var deleteEventUrl               = "{{action('Client\ClientController@postDeleteEvent')}}";
	var eventDataUrl                 = "{{action('Client\ClientController@postEvent')}}";
	var eventsUrl                    = "{{action('Client\ClientController@postEvents')}}";
	var myReservationColor           = '{{config('calendar.my-reservation.color')}}';
	var myReservationBorderColor     = '{{config('calendar.my-reservation.border-color')}}';
	var myReservationBackgroundColor = '{{config('calendar.my-reservation.background-color')}}';
	var reservationarea              = '{{config('calendar.reservation-area')}}';
	var durationforedit              = parseInt('{{config('calendar.duration-for-edit')}}');
	var maxeventduration             = parseInt('{{config('calendar.max-duration')}}');
	var consolesURL                  = '{{action('Client\ClientController@postConsoles')}}';
</script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('gentellela/vendors/switchery/dist/switchery.min.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('gentellela/vendors/nprogress/nprogress.js')}}"></script>
<script src="{{asset('gentellela/custom.js')}}"></script>

@yield('scripts')
</body>
</html>
