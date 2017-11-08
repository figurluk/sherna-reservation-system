@extends('layouts.client')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>{{trans('reservations.your_badges')}}</h2>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 col-xs-12">
				@foreach(Auth::user()->badges as $badge)
					<h3><span class="label label-primary">{{$badge->name}}</span></h3>
				@endforeach
			</div>
		</div>
	</div>


@endsection

