@extends('layouts.admin')

@section('content')
	
	<form action="{{action('Admin\InventoryController@store')}}" class="form-horizontal" method="post">
		{!! csrf_field() !!}
		<div class="row">
			<div class="col-md-12">
				@include('admin.partials.form_errors')
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Create inventory item</h2>
						<div class="pull-right">
							<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
							<a href="{{action('Admin\InventoryController@index')}}" class="btn btn-danger"><i
										class="fa fa-times"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group">
									<label for="input1" class="col-sm-4 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="input1" name="name"
											   value="{{old('name')}}">
									</div>
								</div>
								<div class="form-group">
									<label for="input1" class="col-sm-4 control-label">Invetory number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="input1" name="inventory_id"
											   value="{{old('inventory_id')}}">
									</div>
								</div>
								<div class="form-group">
									<label for="input1" class="col-sm-4 control-label">Serial number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="input1" name="serial_id"
											   value="{{old('serial_id')}}">
									</div>
								</div>
								<div class="form-group">
									<label for="input2" class="col-sm-4 control-label">Location</label>
									<div class="col-sm-8">
										<select name="location_id" id="input2" class="form-control">
											@foreach(\App\Models\Location::get() as $location)
												<option value="{{$location->id}}">{{$location->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<label for="note" class="col-sm-2 control-label">Note</label>
									<div class="col-sm-10">
										<textarea name="note" id="note" class="form-control"
												  rows="3">{{old('note')}}</textarea>
									</div>
								</div>
							
								<div class="form-group">
									<label for="inventory_category_id" class="col-sm-2 control-label">Category</label>
									<div class="col-sm-10">
										<select name="inventory_category_id" id="inventory_category_id"
												class="form-control">
											@foreach(\App\Models\InventoryCategory::get() as $category)
												<option value="{{$category->id}}">{{$category->texts()->ofLang('en')->first()->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								
								<div class="form-group"
									 id="games-options">
									
									<div class="form-group">
										<label for="console_id" class="col-sm-2 control-label">Console</label>
										<div class="col-sm-10">
											<select name="console_id" id="console_id"
													class="form-control">
												@foreach(\App\Models\Console::get() as $console)
													<option value="{{$console->id}}">{{$console->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<div class="checkbox col-sm-offset-2">
											<label>
												<input type="hidden" name="console" value="0">
												<input type="checkbox" name="console"
													   value="1"> Console
											</label>
										</div>
									</div>
									
									<div class="form-group">
										<div class="checkbox col-sm-offset-2">
											<label>
												<input type="hidden" name="vr" value="0">
												<input type="checkbox" name="vr"
													   value="1"> VR
											</label>
										</div>
									</div>
									
									<div class="form-group">
										<div class="checkbox col-sm-offset-2">
											<label>
												<input type="hidden" name="kinect" value="0">
												<input type="checkbox" name="kinect"
													   value="1"> Kinect
											</label>
										</div>
									</div>
									
									
									<div class="form-group">
										<div class="checkbox col-sm-offset-2">
											<label>
												<input type="hidden" name="game_pad" value="0">
												<input type="checkbox" name="game_pad"
													   value="1"> Game pad
											</label>
										</div>
									</div>
									
									
									<div class="form-group">
										<div class="checkbox col-sm-offset-2">
											<label>
												<input type="hidden" name="move" value="0">
												<input type="checkbox" name="move"
													   value="1"> Move/Aim
											</label>
										</div>
									</div>
									
									<div class="form-group">
										<div class="checkbox col-sm-offset-2">
											<label>
												<input type="hidden" name="guitar" value="0">
												<input type="checkbox" name="guitar"
													   value="1"> Guitar
												
											</label>
										</div>
									</div>
									
									<div class="form-group">
										<label for="players" class="col-sm-2 control-label">Players</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="players" name="players"
												   value="1">
										</div>
									</div>
								</div>
							</div>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

@endsection


@section('scripts')
	
	<script>
		$('#inventory_category_id').change(function (ev) {
			if ($('#inventory_category_id').val() == 1) {
				$('#games-options').removeClass('hidden');
			} else {
				$('#games-options').addClass('hidden');
			}
		})
	</script>

@endsection
