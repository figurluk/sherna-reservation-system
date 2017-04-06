@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Badges</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{action('Admin\BadgesController@create')}}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($badges as $badge)
                            <tr>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$badges->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection