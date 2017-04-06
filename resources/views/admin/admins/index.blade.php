@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Admins</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{action('Admin\AdminsController@create')}}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>UID</th>
                            <th>level</th>
                            @if(Auth::user()->isSuperAdmin())
                                <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($admins as $admin)
                            <tr>
                                <td>{{$admin->uid}} {{$admin->user!=null ? '('.$admin->user->surname.' '.$admin->user->name.')' : ''}}</td>
                                <td>{{$admin->role}}</td>
                                @if(Auth::user()->isSuperAdmin())
                                    <td>
                                        <form action="{{action('Admin\AdminsController@delete',$admin->id)}}" class="inline" method="post">
                                            {!! csrf_field() !!}
                                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$admins->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection