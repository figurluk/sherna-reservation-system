@extends('layouts.admin')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Users</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					
					<table class="table">
						<thead>
						<tr>
							<th>UID</th>
							<th>Name</th>
							<th>Surname</th>
							<th>Email</th>
							<th width="30%">Badges</th>
							@if(Auth::user()->isSuperAdmin())
								<th>Level</th>
							@endif
							<th></th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td></td>
							<td>
								<form class="form-inline" method="post"
									  action="{{action('Admin\UsersController@filterName')}}">
									{!! csrf_field() !!}
									<div class="input-group input-group-xs">
										<input name="name" type="text" class="form-control input-xs"
											   value="{{($name==null) ? "" : $name}}">
										<span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i
														class="fa fa-search"></i>
                                            </button>
                                        </span>
									</div>
								</form>
							</td>
							<td>
								<form class="form-inline" method="post"
									  action="{{action('Admin\UsersController@filterSurname')}}">
									{!! csrf_field() !!}
									<div class="input-group input-group-xs">
										<input name="surname" type="text" class="form-control input-xs"
											   value="{{($surname==null) ? "" : $surname}}">
										<span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i
														class="fa fa-search"></i>
                                            </button>
                                        </span>
									</div>
								</form>
							</td>
							<td>
								<form class="form-inline" method="post"
									  action="{{action('Admin\UsersController@filterEmail')}}">
									{!! csrf_field() !!}
									<div class="input-group input-group-xs">
										<input name="email" type="text" class="form-control input-xs"
											   value="{{($email==null) ? "" : $email}}">
										<span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i
														class="fa fa-search"></i>
                                            </button>
                                        </span>
									</div>
								</form>
							</td>
							<td></td>
							<td></td>
						</tr>
						@foreach($users as $user)
							<tr>
								<td><a target="_blank" rel="noopener"
									   href="https://is.sh.cvut.cz/users/{{$user->uid}}">{{$user->uid}}</a></td>
								<td>{{$user->name}}</td>
								<td>{{$user->surname}}</td>
								<td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
								<td>
									@foreach($user->badges as $badge)
										<span class="label label-primary">{{$badge->name}}</span>&nbsp;
									@endforeach
								</td>
								@if(Auth::user()->isSuperAdmin())
									<td>
										<form action="{{action('Admin\AdminsController@store')}}" class="form-inline"
											  method="post">
											{!! csrf_field() !!}
											<input type="hidden" name="uid" value="{{$user->uid}}">
											<input type="hidden" name="redirect" value="users">
											
											<div class="form-group">
												<select name="role" class="form-control user_roles">
													<option value="uzivatel" {{$user->role()=='uzivatel'?'selected':''}}>
														User
													</option>
													<option value="admin" {{$user->role()=='admin'?'selected':''}}>
														Admin
													</option>
													<option value="super_admin" {{$user->role()=='super_admin'?'selected':''}}>
														Super admin
													</option>
												</select>
											</div>
										</form>
									</td>
								@endif
								<td>
									<a class="btn btn-primary"
									   href="{{action('Admin\UsersController@editBadges',$user->id)}}"><i
												class="fa fa-id-badge"></i></a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					{{$users->render()}}
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	
	<script type="text/javascript">

		$(document).on('change', '.user_roles', function (ev) {
			$(ev.target).closest('form').submit();
		});
	
	</script>

@endsection