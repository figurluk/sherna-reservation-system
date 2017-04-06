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
                            <th>Level</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->uid}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->surname}}</td>
                                <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                <td>
                                    @if(Auth::user()->isSuperAdmin())
                                        <form action="{{action('Admin\AdminsController@store')}}" class="form-inline" method="post">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="uid" value="{{$user->uid}}">
                                            <input type="hidden" name="redirect" value="users">

                                            <div class="form-group">
                                                <select name="role" class="form-control user_roles">
                                                    <option value="uzivatel" {{$user->role()=='uzivatel'?'selected':''}}>User</option>
                                                    <option value="admin" {{$user->role()=='admin'?'selected':''}}>Admin</option>
                                                    <option value="super_admin" {{$user->role()=='super_admin'?'selected':''}}>Super admin</option>
                                                </select>
                                            </div>
                                        </form>
                                    @else
                                        {{$user->role()}}
                                    @endif
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