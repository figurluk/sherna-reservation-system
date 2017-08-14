@extends('layouts.client')


@section('content')

    <div class="jumbotron">
        <div class="container">
            <h1>{{trans('general.banner.title')}}</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                @if(count($activeReservations)>0)
                    <h2>Active reservations</h2>
                    <div class="row">

                        @foreach(\App\Models\Location::get() as $location)
                            @php
                                $activeReservation = $activeReservations->where('location_id',$location->id)->first();
                            @endphp
                            <div class="col-md-6">
                                <div class="twPc-div">
                                    <a class="twPc-bg twPc-block"></a>

                                    <div>
                                        <a title="{{$activeReservation->owner->name}} {{$activeReservation->owner->surname}}" target="_blank" rel="noopener"
                                           href="https://is.sh.cvut.cz/users/{{$activeReservation->owner->uid}}" class="twPc-avatarLink">
                                            <img alt="{{$activeReservation->owner->name}} {{$activeReservation->owner->surname}}"
                                                 src="{{$activeReservation->owner->image}}"
                                                 class="twPc-avatarImg">
                                        </a>

                                        <div class="twPc-divUser">
                                            <div class="twPc-divName">
                                                <a href="https://is.sh.cvut.cz/users/{{$activeReservation->owner->uid}}" target="_blank"
                                                   rel="noopener">{{$activeReservation->owner->name}} {{$activeReservation->owner->surname}}</a>
                                            </div>
                                            <span>
                                            <a href="mailto:{{$activeReservation->owner->email}}"><span>{{$activeReservation->owner->email}}</span></a>
                                        </span>
                                        </div>

                                        <div class="twPc-divStats">
                                            <ul class="twPc-Arrange">
                                                <li class="twPc-ArrangeSizeFit">
                                                    <a href="#" title="{{$activeReservation->location->name}}">
                                                        <span class="twPc-StatLabel twPc-block">Location</span>
                                                        <span class="twPc-StatValue">{{$activeReservation->location->name}}</span>
                                                    </a>
                                                </li>
                                                <li class="twPc-ArrangeSizeFit">
                                                    <a href="#" title="{{date('d.m.Y H:i',strtotime($activeReservation->start))}}">
                                                        <span class="twPc-StatLabel twPc-block">Start</span>
                                                        <span class="twPc-StatValue">{{date('d.m.Y H:i',strtotime($activeReservation->start))}}</span>
                                                    </a>
                                                </li>
                                                <li class="twPc-ArrangeSizeFit">
                                                    <a href="#" title="{{date('d.m.Y H:i',strtotime($activeReservation->end))}}">
                                                        <span class="twPc-StatLabel twPc-block">End</span>
                                                        <span class="twPc-StatValue">{{date('d.m.Y H:i',strtotime($activeReservation->end))}}</span>
                                                    </a>
                                                </li>
                                                @if($activeReservation->end >= date('Y-m-d H:i:s') &&  date('Y-m-d H:i:s',strtotime('-'.config('calendar.renew_reservation').' minutes',strtotime($activeReservation->end))) <= date('Y-m-d H:i:s'))
                                                    <li class="twPc-ArrangeSizeFit">
                                                        <a class="btn btn-primary" href="#" title="{{date('d.m.Y H:i',strtotime($activeReservation->end))}}">
                                                            Predlzit
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                @endif


                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Start</th>
                            <th>End</th>
                            <th>Location</th>
                            <th>Canceled</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>{{date('d.m.Y H:i',strtotime($reservation->start))}}</td>
                                <td>{{date('d.m.Y H:i',strtotime($reservation->end))}}</td>
                                <td>{{$reservation->location->name}}</td>
                                <td>{{$reservation->canceled_at == null ? '-' : date('d.m.Y H:i',strtotime($reservation->canceled_at))}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $reservations->render() !!}
            </div>
        </div>
    </div>

@endsection
