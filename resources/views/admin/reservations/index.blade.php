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
                            <th>Owner</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>{{$reservation->owner->surname}} {{$reservation->owner->name}}</td>
                                <td><a href="mailto:{{$reservation->owner->email}}">{{$reservation->owner->email}}</a></td>
                                <td>{{$reservation->location->name }}</td>
                                <td>{{date('d.m.Y H:i',strtotime($reservation->day.' '.$reservation->start))}}</td>
                                <td>{{date('d.m.Y H:i',strtotime($reservation->day.' '.$reservation->end))}}</td>
                                <td>{{$reservation->note}}</td>
                                <td>
                                    <a href="{{action('Admin\ReservationsController@edit',$reservation->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                    <a href="{{action('Admin\ReservationsController@delete',$reservation->id)}}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$reservations->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection