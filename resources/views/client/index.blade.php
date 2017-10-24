@extends('layouts.client')


@section('content')
	
	<div class="jumbotron sherna-jumbotron">
		<img class="img-reponsive" src="{{asset('assets_client/img/sherna_dash.jpg')}}" alt="Banner image">
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				{!! $page->pageText()->ofLang(Config::get('app.locale'))->first()->content !!}
			</div>
		</div>
	</div>

@endsection
