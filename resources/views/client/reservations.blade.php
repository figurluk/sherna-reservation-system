@extends('layouts.client')

@section('styles')
    <link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endsection

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
                    <h2>{{trans('reservations.active_reservations')}}</h2>
                    <div class="row">

                        @foreach(\App\Models\Location::get() as $location)
                            @php
                                $activeReservation = $activeReservations->where('location_id',$location->id)->first();
                            @endphp
                            @if($activeReservation!=null)
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
                                                            <span class="twPc-StatLabel twPc-block">{{trans('reservations.location')}}</span>
                                                            <span class="twPc-StatValue">{{$activeReservation->location->name}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="twPc-ArrangeSizeFit">
                                                        <a href="#" title="{{date('d.m.Y H:i',strtotime($activeReservation->start))}}">
                                                            <span class="twPc-StatLabel twPc-block">{{trans('reservations.from_date')}}</span>
                                                            <span class="twPc-StatValue">{{date('d.m.Y H:i',strtotime($activeReservation->start))}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="twPc-ArrangeSizeFit">
                                                        <a href="#" title="{{date('d.m.Y H:i',strtotime($activeReservation->end))}}">
                                                            <span class="twPc-StatLabel twPc-block">{{trans('reservations.to_date')}}</span>
                                                            <span class="twPc-StatValue end-date">{{date('d.m.Y H:i',strtotime($activeReservation->end))}}</span>
                                                        </a>
                                                    </li>
                                                    @if($activeReservation->end >= date('Y-m-d H:i:s') &&  date('Y-m-d H:i:s',strtotime('-'.config('calendar.renew_reservation').' minutes',strtotime($activeReservation->end))) <= date('Y-m-d H:i:s'))
                                                        <li class="twPc-ArrangeSizeFit">
                                                            <a class="btn btn-primary" href="#"
                                                               data-toggle="modal" data-target="#createReservationModal"
                                                               data-reservation-id="{{$activeReservation->id}}"
                                                               title="{{date('d.m.Y H:i',strtotime($activeReservation->end))}}">
                                                                {{trans('reservation-modal.renew')}}
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <hr>
                @endif


                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{trans('reservations.from_date')}}</th>
                            <th>{{trans('reservations.to_date')}}</th>
                            <th>{{trans('reservations.location')}}</th>
                            <th>{{trans('reservations.canceled')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations as $reservation)
                            <tr data-reservation-id="{{$reservation->id}}">
                                <td>{{date('d.m.Y H:i',strtotime($reservation->start))}}</td>
                                <td class="end-date">{{date('d.m.Y H:i',strtotime($reservation->end))}}</td>
                                <td>{{$reservation->location->name}}</td>
                                <td>{{$reservation->canceled_at == null ? '-' : date('d.m.Y H:i',strtotime($reservation->canceled_at))}}</td>
                                <td>
                                    @if(date('Y-m-d H:i:s',strtotime($reservation->start,strtotime('- '.config('calendar.duration-for-edit').' minutes'))) > date('Y-m-d H:i:s'))
                                        <a class="btn btn-danger btn-delete" href="{{action('Client\ClientController@postDeleteEvent')}}">{{trans('reservation-modal.delete')}}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $reservations->render() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="createReservationModal" tabindex="-1" role="dialog" aria-labelledby="createReservationModalLabel">
        <div class="modal-dialog" role="document">
            <form action="#" class="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="createReservationModalLabel">{{trans('reservation-modal.renew-title')}}</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="to_date" class="control-label">{{trans('reservation-modal.renew-to')}}<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <input name="to_date" class="form-control to_datetime" id="to_date" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal">{{trans('reservation-modal.cancel')}}</button>
                        <button name="submit" id="saveReservation" class="btn btn-primary">{{trans('reservation-modal.renew')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">
		var locale           = "{{Session::get('lang')}}";
		var pickerLocale     = "{{Config::get('app.locale') =='cz' ? 'cs' : Config::get('app.locale')}}";
		var eventDataUrl     = "{{action('Client\ClientController@postEvent')}}";
		var userUrl          = "{{action('Client\ClientController@postUserData')}}";
		var updateEventUrl   = "{{action('Client\ClientController@postUpdateEvent')}}";
		var eventsUrl        = "{{action('Client\ClientController@postEvents')}}";
		var reservationarea  = '{{config('calendar.reservation-area')}}';
		var durationforedit  = parseInt('{{config('calendar.duration-for-edit')}}');
		var maxeventduration = parseInt('{{config('calendar.max-duration')}}');
		var consolesURL      = '{{action('Client\ClientController@postConsoles')}}';
    </script>

    <script src="{{asset('gentellela/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('assets_client/datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('assets_client/datetimepicker/js/locales/bootstrap-datetimepicker.'.(Config::get('app.locale') =='cz'?'cs.js':Config::get('app.locale').'.js'))}}"></script>
    <script src="{{asset('js/renew-reservation.js')}}"></script>

@endsection

