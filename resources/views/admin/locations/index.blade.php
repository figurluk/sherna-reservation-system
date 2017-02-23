@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Locations</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{action('Admin\LocationsController@create')}}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locations as $location)
                            <tr>
                                <td>{{$location->name}}</td>
                                <td>
                                    <span class="label label-{{$location->status->opened ? 'success':'danger'}}">{{$location->status->name}}</span>
                                </td>
                                <td>
                                    <form action="{{action('Admin\LocationsController@delete',$location->id)}}" class="inline" method="post">
                                        {!! csrf_field() !!}
                                        <a class="btn btn-warning" href="{{action('Admin\LocationsController@edit',$location->id)}}"><i
                                                    class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$locations->render()}}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Locations statuses</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{action('Admin\LocationsController@createStatus')}}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Opened</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locationStatuses as $locationStatus)
                            <tr>
                                <td>{{$locationStatus->name}}</td>
                                <td>
                                    <span class="label label-{{$locationStatus->opened ? 'success':'danger'}}">{{$locationStatus->opened ? 'Opened':'Closed'}}</span>
                                </td>
                                <td>
                                    <a class="btn btn-warning" href="{{action('Admin\LocationsController@editStatus',$location->id)}}"><i
                                                class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$locations->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection