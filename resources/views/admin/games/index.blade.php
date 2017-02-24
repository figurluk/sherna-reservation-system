@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Games</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{action('Admin\GamesController@create')}}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Max possible players</th>
                            <th>Console type</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($games as $game)
                            <tr>
                                <td>{{$game->name}}</td>
                                <td>{{$game->possible_players}}</td>
                                <td>{{$game->consoleType->name}}</td>
                                <td>
                                    <form action="{{action('Admin\GamesController@delete',$game->id)}}" class="inline" method="post">
                                        {!! csrf_field() !!}
                                        <a class="btn btn-warning" href="{{action('Admin\GamesController@edit',$game->id)}}"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$games->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection