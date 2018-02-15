@extends('layouts.admin')

@section('content')
	
	<form action="{{action('Admin\BadgesController@update',$badge->id)}}" class="form-horizontal" method="post">
		{!! csrf_field() !!}
		<div class="row">
			<div class="col-md-12">
				@include('admin.partials.form_errors')
				
				<div class="x_panel">
					<div class="x_title">
						<h2>Edit badge</h2>
						<div class="pull-right">
							<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
							<a href="{{action('Admin\BadgesController@index')}}" class="btn btn-danger"><i
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
											   value="{{old('name',$badge->name)}}">
									</div>
								</div>
								<div class="form-group">
									<div class="checkbox col-sm-offset-2">
										<label>
											<input type="hidden" name="system" value="0">
											<input type="checkbox" name="system"
												   {{!old('system',$badge->system) ?:'checked'}}
												   value="1"> System badge
										</label>
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
