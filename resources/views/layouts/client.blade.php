<!DOCTYPE html>
<html lang="{{ config('app.locale')!='cz'?:'cs' }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="robots" content="index, follow">
	<meta name="author" content="Lukáš Figura, SHerna">
	<meta name="rights" content="SHerna">
	<meta name="application-name" content="SHerna">
	
	<title>Život je jen hra | SHerna</title>
	<meta property="og:title" content="Život je jen hra | SHerna"/>
	<meta name="twitter:title" content="Život je jen hra | SHerna"/>
	
	<meta name="keywords" content="silicon hill sherna virtual reality VR xbox playstation PS4 esport league gaming game film fun">
	
	<meta name="description" content="SHerna je projekt pod klubem Silicon Hill určený k trávení volného času od hraní na konzolích, přes sledování filmů, až po společenské akce.">
	<meta property="og:description" content="SHerna je projekt pod klubem Silicon Hill určený k trávení volného času od hraní na konzolích, přes sledování filmů, až po společenské akce."/>
	<meta name="twitter:description" content="SHerna je projekt pod klubem Silicon Hill určený k trávení volného času od hraní na konzolích, přes sledování filmů, až po společenské akce."/>
	
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://sherna.siliconhill.cz">
	<meta property="og:image" content="{{asset('favicon/ms-icon-144x144.png')}}" />
	
	<!-- Styles -->
	<link href="{{mix('css/client.css')}}" rel="stylesheet">
	
	<link rel="apple-touch-icon" sizes="57x57" href="{{asset('favicon/apple-icon-57x57.png')}}">
	<link rel="apple-touch-icon" sizes="60x60" href="{{asset('favicon/apple-icon-60x60.png')}}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{asset('favicon/apple-icon-72x72.png')}}">
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('favicon/apple-icon-76x76.png')}}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{asset('favicon/apple-icon-114x114.png')}}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{asset('favicon/apple-icon-120x120.png')}}">
	<link rel="apple-touch-icon" sizes="144x144" href="{{asset('favicon/apple-icon-144x144.png')}}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{asset('favicon/apple-icon-152x152.png')}}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-icon-180x180.png')}}">
	<link rel="icon" type="image/png" sizes="192x192" href="{{asset('favicon/android-icon-192x192.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('favicon/favicon-96x96.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
	<link rel="manifest" href="{{asset('manifest.json')}}">
	<link rel="alternate" hreflang="x-default" href="https://sherna.siliconhill.cz/">
	<link rel="canonical" href="https://sherna.siliconhill.cz">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="{{asset('favicon/ms-icon-144x144.png')}}">
	<meta name="theme-color" content="#ffffff">
	
	@yield('styles')
	@if(config('app.env')!='local')
		<script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments)
			};
			gtag('js', new Date());
			gtag('config', 'UA-109514102-1');
		</script>
	@endif
</head>
<body>

<div id="body-container">
	<div id="flashes">
		@include('client.partials.flash')
	</div>
	<div id="js-flashes"></div>
	
	@include('client.partials.navbar')
	
	<div class="content-wrapper">
		@yield('content')
	</div>
</div>

@include('client.partials.footer')


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

<script type="text/javascript" src="{{asset('js/app.js')}}" charset="UTF-8"></script>
@include('client.partials.cookies')

@yield('scripts')
</body>
</html>
