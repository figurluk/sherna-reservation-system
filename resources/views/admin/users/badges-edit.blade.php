@extends('layouts.admin')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>User badges</h2>
					<div class="pull-right">
						<a class="btn btn-primary" href="{{action('Admin\UsersController@index')}}"><i
									class="fa fa-arrow-left"></i></a>
					</div>
					<div class="clearfix"></div><div class="clearfix"></div>
				</div>
				<div class="x_content">
					
					<table class="table">
						<thead>
						<tr>
							<th>Badge</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@foreach($user->badges as $badge)
							<tr>
								<td>{{$badge->name}}</td>
								<td>
									<a class="btn btn-danger" href="{{action('Admin\UsersController@removeBadge',[$badge->id,$user->id])}}"><i
												class="fa fa-trash"></i></a>
								</td>
							</tr>
						@endforeach
						</tbody>
						
					</table>
					
					<form action="{{action('Admin\UsersController@storeBadge',$user->id)}}" method="post">
						{{csrf_field()}}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<select name="badge_id" id="badge_id" class="form-control">
										@foreach(App\Models\Badge::get() as $badge)
											<option value="{{$badge->id}}">{{$badge->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<button class="btn btn-success" type="submit"><i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
