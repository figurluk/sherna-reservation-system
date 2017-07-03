@extends('layouts.admin')

@section('content')
    <div class="row">
        @foreach(\App\Models\Location::get() as $location)
            <div class="col-md-4">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Actual reservation: {{$location->name}}</h2>
                        <div class="pull-right">
                            <span class="label label-{{$location->status->opened ? 'success':'danger'}}">{{$location->status->name}}</span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <?php

                        $actualReservation = App\Models\Reservation::where('location_id', $location->id)
                            ->where('day', date('Y-m-d'))
                            ->where('start', '<=', date('H:i:s'))
                            ->where('end', '>=', date('H:i:s'))->first();
                        ?>

                        @if($actualReservation!=null)

                            <div class="twPc-div">
                                <a class="twPc-bg twPc-block"></a>

                                <div>

                                    <a title="Mert Salih Kaplan" href="https://twitter.com/mertskaplan" class="twPc-avatarLink">
                                        <img alt="Mert Salih Kaplan"
                                             src="{{$actualReservation->owner->image}}"
                                             class="twPc-avatarImg">
                                    </a>

                                    <div class="twPc-divUser">
                                        <div class="twPc-divName">
                                            <a href="https://twitter.com/mertskaplan">{{$actualReservation->owner->name}} {{$actualReservation->owner->surname}}</a>
                                        </div>
                                        <span>
                                            <a href="mailto:{{$actualReservation->owner->email}}">@<span>{{$actualReservation->owner->email}}</span></a>
                                        </span>
                                    </div>

                                    <div class="twPc-divStats">
                                        <ul class="twPc-Arrange">
                                            <li class="twPc-ArrangeSizeFit">
                                                <a href="#" title="{{date('H:i',strtotime($actualReservation->start))}}">
                                                    <span class="twPc-StatLabel twPc-block">Start</span>
                                                    <span class="twPc-StatValue">{{date('H:i',strtotime($actualReservation->start))}}</span>
                                                </a>
                                            </li>
                                            <li class="twPc-ArrangeSizeFit">
                                                <a href="#" title="{{date('H:i',strtotime($actualReservation->end))}}">
                                                    <span class="twPc-StatLabel twPc-block">End</span>
                                                    <span class="twPc-StatValue">{{date('H:i',strtotime($actualReservation->end))}}</span>
                                                </a>
                                            </li>
                                            <li class="twPc-ArrangeSizeFit">
                                                <a href="#" title="{{date('d.m.Y',strtotime($actualReservation->day))}}">
                                                    <span class="twPc-StatLabel twPc-block">Date</span>
                                                    <span class="twPc-StatValue">{{date('d.m.Y',strtotime($actualReservation->day))}}</span>
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