@extends('layouts.client')

@section('styles')
	{{--<link href="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">--}}
	{{--<link href="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet" media="print">--}}
	<link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
	<link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet"
		  media="print">
	<style>
		#calendar {
			max-width: 900px;
			margin: 0 auto;
		}
	</style>
	
	
	@if($page->code=='rezervace' && \App\Models\Location::whereHas('status',function ($q) {$q->where('opened',true);})->count() > 0)
		<link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
	@endif
@endsection

@section('content')
	
	<div class="container">
		
		
		@if($page->code=='vybaveni')
			<div class="row">
				<div class="col-md-12">
					<h2>
						{{trans('general.content.games')}}
					</h2>
					
					<ul>
						@foreach(\App\Models\Game::orderBy('name','asc')->get() as $game)
							<li>{{$game->name}} ({{$game->consoleType->name}})</li>
						@endforeach
					</ul>
				</div>
			</div>
		@endif
		
		<div class="row">
			<div class="col-md-12 col-xs-12">
				{!! $page->pageText()->ofLang(Config::get('app.locale'))->first()->content !!}
			</div>
		</div>
	</div>
	
	<br>
	
	@if($page->code=='rezervace' && \App\Models\Location::whereHas('status',function ($q) {$q->where('opened',true);})->count() > 0)
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-xs-12">
					<div class="row">
						@foreach(\App\Models\Location::get() as $location)
							<div class="col-md-6 col-xs-6 text-center">
								<p class="location_radio">
									<input id="location{{$location->id}}" type="radio" name="location"
										   value="{{$location->id}}"
										   autocomplete="off" {{!$location->status->opened ? 'disabled':''}} {{$location->status->opened?'checked="checked"':''}}>
									<label for="location{{$location->id}}">
										<i class="location-state {{$location->status->opened ?'opened':'closed'}}">{{$location->status->opened ?trans('general.opened'):trans('general.closed')}}</i>
										<i class="fa fa-building"></i> {{$location->name}}
									</label>
								</p>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					@if(Auth::check())
						<a href="#" data-toggle="modal" data-target="#createReservationModal"
						   class="btn btn-default">{{trans('reservation-modal.title')}}</a>
					@else
						<a href="{{action('Client\ClientController@getAuthorize')}}"
						   class="btn btn-default">{{trans('reservation-modal.title')}}</a>
					@endif
				</div>
			
			</div>
			<hr>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div id="calendar"></div>
				</div>
			</div>
		</div>
		
		
		<!-- Modal -->
		<div class="modal fade" id="createReservationModal" tabindex="-1" role="dialog"
			 aria-labelledby="createReservationModalLabel">
			<div class="modal-dialog" role="document">
				<form action="#" class="" method="post">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
										aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"
								id="createReservationModalLabel">{{trans('reservation-modal.title')}}</h4>
						</div>
						<div class="modal-body">
							
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<label for="from_date"
												   class="control-label">{{trans('reservation-modal.from_date')}}<span
														class="text-danger">*</span></label>
											<input name="from_date" class="form-control form_datetime" id="from_date"
												   type="text">
										</div>
										<div class="col-md-6">
											<label for="to_date"
												   class="control-label">{{trans('reservation-modal.to_date')}}<span
														class="text-danger">*</span></label>
											<input name="to_date" class="form-control to_datetime" id="to_date"
												   type="text">
										</div>
									</div>
									<div class="form-group">
										<label for="visitors_count"
											   class="control-label">{{trans('reservations.location')}}</label>
										<select name="location_id" id="" class="form-control">
											@foreach(\App\Models\Location::opened()->get() as $location)
												<option value="{{$location->id}}" {{old('location')==$location->id ? 'selected':''}}>{{$location->name}}</option>
											@endforeach
										</select>
									</div>
									
									<div class="form-group">
										<label for="visitors_count"
											   class="control-label">{{trans('reservation-modal.visitors_count')}}</label>
										<input type="number" class="form-control" name="visitors_count"
											   id="visitors_count">
									</div>
									
									<div class="form-group">
										<label for="note"
											   class="control-label">{{trans('reservation-modal.note')}}</label>
										<textarea class="form-control" id="note" name="note" rows="3"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-gray"
									data-dismiss="modal">{{trans('reservation-modal.cancel')}}</button>
							<button name="submit" id="saveReservation"
									class="btn btn-default">{{trans('reservation-modal.save')}}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="showReservationModal" tabindex="-1" role="dialog"
			 aria-labelledby="showReservationModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
									aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="showReservationModalLabel"></h4>
					</div>
					<div class="modal-body">
						
						<p>
							<strong>{{trans('reservation-modal.from_date')}}:</strong> <span id="start"></span>
						</p>
						<p>
							<strong>{{trans('reservation-modal.to_date')}}:</strong> <span id="end"></span>
						</p>
					
					</div>
					<div class="modal-footer">
						<button id="deleteReservation" type="button"
								class="btn btn-danger hidden">{{trans('reservation-modal.delete')}}</button>
						<button type="button" class="btn btn-gray"
								data-dismiss="modal">{{trans('reservation-modal.cancel')}}</button>
					</div>
				</div>
			</div>
		</div>
	@endif

@endsection


@section('scripts')


@endsection