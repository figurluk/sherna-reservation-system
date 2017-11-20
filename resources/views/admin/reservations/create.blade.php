@extends('layouts.admin')

@section('styles')
	<link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endsection

@section('content')
	
	<form action="{{action('Admin\ReservationsController@store')}}" class="" method="post">
		{{csrf_field()}}
		<div class="row">
			<div class="col-md-12">
				
				@include('admin.partials.form_errors')
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Create reservation</h2>
						<div class="pull-right">
							<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
							<a href="{{action('Admin\ReservationsController@index')}}" class="btn btn-primary"><i
										class="fa fa-arrow-left"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					
					
					<div class="row">
						<div class="col-md-12">
							@if(Auth::user()->isSuperAdmin())
								<div class="form-group">
									<label for="tenant_uid"
										   class="control-label">User UID</label>
									<input type="text" class="form-control" name="tenant_uid"
										   id="tenant_uid" value="{{old('tenant_uid',Auth::user()->uid)}}">
								</div>
							@endif
							
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="from_date"
											   class="control-label">From<span
													class="text-danger">*</span></label>
										<input name="from_date" class="form-control form_datetime" id="from_date"
											   type="text" value="{{old('from_date')}}">
									</div>
									<div class="col-md-6">
										<label for="to_date"
											   class="control-label">To<span
													class="text-danger">*</span></label>
										<input name="to_date" class="form-control to_datetime" id="to_date"
											   type="text" value="{{old('to_date')}}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="visitors_count"
									   class="control-label">Location</label>
								<select name="location" id="" class="form-control">
									@foreach(\App\Models\Location::get() as $location)
										<option value="{{$location->id}}" {{old('location')==$location->id ? 'selected':''}}>{{$location->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="visitors_count"
									   class="control-label">Count of visitors</label>
								<input type="number" class="form-control" name="visitors_count"
									   id="visitors_count" value="{{old('visitors_count')}}">
							</div>
							
							<div class="form-group">
								<label for="note"
									   class="control-label">Note</label>
								<textarea class="form-control" id="note" name="note" rows="3">{{old('note')}}</textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

@endsection

@section('scripts')
	
	<script src="{{asset('assets_admin/js/datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
	
	<script type="text/javascript">
		var formDate = $(".form_datetime").datetimepicker({
			language      : pickerLocale,
			format        : "dd.mm.yyyy hh:ii:ss",
			autoclose     : true,
			startDate     : moment().add(durationforedit, 'm').format('YYYY-MM-DD HH:mm'),
			endDate       : moment().add(reservationarea, 'd').format('YYYY-MM-DD HH:mm'),
			todayBtn      : true,
			todayHighlight: false,
			pickerPosition: "bottom-left",
			minuteStep    : 15
		});


		var toDate = $(".to_datetime").datetimepicker({
			language      : pickerLocale,
			format        : "dd.mm.yyyy hh:ii:ss",
			autoclose     : true,
			startDate     : moment().add(durationforedit * 2, 'm').format('YYYY-MM-DD HH:mm'),
			todayBtn      : true,
			todayHighlight: false,
			pickerPosition: "bottom-right",
			minuteStep    : 15
		});
	</script>

@endsection