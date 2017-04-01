@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Reservations</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{action('Admin\ReservationsController@create')}}"><i class="fa fa-plus"></i></a>
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
                        @foreach($reservations as $reservation)
                            <tr>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$reservations->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection