@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Consoles</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{action('Admin\ConsolesController@create')}}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($consoles as $console)
                            <tr>
                                <td>
                                    {{$console->name}}
                                </td>
                                <td>
                                    {{$console->type->name}}
                                </td>
                                <td>
                                    {{$console->location->name}}
                                </td>
                                <td>
                                    <form action="{{action('Admin\ConsolesController@delete',$console->id)}}" class="inline" method="post">
                                        {!! csrf_field() !!}
                                        <a class="btn btn-warning" href="{{action('Admin\ConsolesController@edit',$console->id)}}"><i
                                                    class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$consoles->render()}}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Consoles types</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{action('Admin\ConsolesController@createConsoleType')}}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($consolesTypes as $consolesType)
                            <tr>
                                <td>{{$consolesType->name}}</td>
                                <td>
                                    <a class="btn btn-warning" href="{{action('Admin\ConsolesController@editConsoleType',$consolesType->id)}}"><i
                                                class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection