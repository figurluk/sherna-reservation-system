@extends('layouts.client')


@section('content')
	
	<div class="jumbotron sherna-jumbotron">
		<img class="img-reponsive" src="{{asset('assets_client/img/sherna_dash.png')}}" alt="Banner image">
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				{!! $page->pageText()->ofLang(Config::get('app.locale'))->first()->content !!}
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h2>{{trans('general.partners')}}</h2>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-2 col-xs-12">
				<div class="partner-logo">
					<a href="https://siliconhill.cz" target="_blank" rel="noopener">
						<img class="img-responsive" src="{{asset('assets_client/img/sh_logo.png')}}" alt="SH logo">
					</a>
				</div>
				<div class="partner-logo">
					<a href="https://avrar.cz" target="_blank" rel="noopener">
						<img class="img-responsive" src="{{asset('assets_client/img/avrv_logo.png')}}" alt="AVRV logo">
					</a>
				</div>
				<div class="partner-logo">
					<a href="http://avc.siliconhill.cz/" target="_blank" rel="noopener">
						<img class="img-responsive" src="{{asset('assets_client/img/avc_logo.png')}}" alt="AVC logo">
					</a>
				</div>
			</div>
			<div class="col-md-3 col-md-offset-2 col-xs-12">
				<div class="partner-logo">
					<a href="https://czechvrfest.com" target="_blank" rel="noopener">
						<img class="img-responsive" src="{{asset('assets_client/img/czvr_logo.png')}}" alt="CZVR logo">
					</a>
				</div>
			</div>
		</div>
	</div>

@endsection
