@extends('layouts.admin')

@section('content')
    <div class="row">
        @foreach(\App\Models\Location::get() as $location)
            <div class="col-md-4">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Actual reservation for: <b>{{$location->name}}</b></h2>
                        <div class="pull-right">
                            <span class="label label-{{$location->status->opened ? 'success':'danger'}}">{{$location->status->name}}</span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <?php

                        $actualReservation = App\Models\Reservation::where('location_id', $location->id)
                            ->whereNull('canceled_at')
                            ->where('start', '<=', date('Y-m-d H:i:s'))
                            ->where('end', '>=', date('Y-m-d H:i:s'))->first();
                        ?>

                        @if($actualReservation!=null)

                            <div class="twPc-div">
                                <a class="twPc-bg twPc-block"></a>

                                <div>

                                    <a title="{{$actualReservation->owner->name}} {{$actualReservation->owner->surname}}" target="_blank" rel="noopener"
                                       href="https://is.sh.cvut.cz/users/{{$actualReservation->owner->uid}}" class="twPc-avatarLink">
                                        <img alt="{{$actualReservation->owner->name}} {{$actualReservation->owner->surname}}"
                                             src="{{$actualReservation->owner->image}}"
                                             class="twPc-avatarImg">
                                    </a>

                                    <div class="twPc-divUser">
                                        <div class="twPc-divName">
                                            <a href="https://is.sh.cvut.cz/users/{{$actualReservation->owner->uid}}" target="_blank"
                                               rel="noopener">{{$actualReservation->owner->name}} {{$actualReservation->owner->surname}}</a>
                                        </div>
                                        <span>
                                            <a href="mailto:{{$actualReservation->owner->email}}"><span>{{$actualReservation->owner->email}}</span></a>
                                        </span>
                                    </div>

                                    <div class="twPc-divStats">
                                        <ul class="twPc-Arrange">
                                            <li class="twPc-ArrangeSizeFit">
                                                <a href="#" title="{{date('d.m.Y H:i',strtotime($actualReservation->start))}}">
                                                    <span class="twPc-StatLabel twPc-block">Start</span>
                                                    <span class="twPc-StatValue">{{date('d.m.Y H:i',strtotime($actualReservation->start))}}</span>
                                                </a>
                                            </li>
                                            <li class="twPc-ArrangeSizeFit">
                                                <a href="#" title="{{date('d.m.Y H:i',strtotime($actualReservation->end))}}">
                                                    <span class="twPc-StatLabel twPc-block">End</span>
                                                    <span class="twPc-StatValue">{{date('d.m.Y H:i',strtotime($actualReservation->end))}}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        @else
                            <h3 class="text-success">Free</h3>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection