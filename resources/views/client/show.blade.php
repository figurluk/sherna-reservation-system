@extends('layouts.client')

@section('styles')
    {{--<link href="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">--}}
    {{--<link href="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet" media="print">--}}
    <link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet" media="print">
    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
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
                {!! $page->pageText()->ofLang(Config::get('app.locale'))->first()->content !!}
            </div>
        </div>
    </div>

    <br>

    @if($page->code=='rezervace' && \App\Models\Location::whereHas('status',function ($q) {$q->where('opened',true);})->count() > 0)
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @foreach(\App\Models\Location::get() as $location)
                        <p class="location_radio">
                            <input id="location{{$location->id}}" type="radio" name="location" value="{{$location->id}}"
                                   autocomplete="off" {{!$location->status->opened ? 'disabled':''}} {{$location->status->opened?'checked="checked"':''}}>
                            <label for="location{{$location->id}}"><i class="fa fa-building"></i> {{$location->name}}</label>
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
        <br>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="createReservationModal" tabindex="-1" role="dialog" aria-labelledby="createReservationModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="createReservationModalLabel">{{trans('reservation-modal.title')}}</h4>
                    </div>
                    <div class="modal-body">

                        <label for="note">{{trans('reservation-modal.note')}}</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('reservation-modal.cancel')}}</button>
                        <button id="saveReservation" type="button" class="btn btn-primary" data-dismiss="modal">{{trans('reservation-modal.save')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="showReservationModal" tabindex="-1" role="dialog" aria-labelledby="showReservationModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="showReservationModalLabel"></h4>
                    </div>
                    <div class="modal-body">

                        <p>
                            <strong>Start:</strong> <span id="start"></span>
                        </p>
                        <p>
                            <strong>End:</strong> <span id="end"></span>
                        </p>

                    </div>
                    <div class="modal-footer">
                        <button id="deleteReservation" type="button" class="btn btn-danger hidden">{{trans('reservation-modal.delete')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('reservation-modal.cancel')}}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection


@section('scripts')

    @if($page->code=='rezervace')
        <script type="text/javascript">
			var locale                       = "{{Session::get('lang')}}";
			var userUrl                      = "{{action('Client\ClientController@postUserData')}}";
			var createEventUrl               = "{{action('Client\ClientController@postCreateEvent')}}";
			var updateEventUrl               = "{{action('Client\ClientController@postUpdateEvent')}}";
			var deleteEventUrl               = "{{action('Client\ClientController@postDeleteEvent')}}";
			var eventsUrl                    = "{{action('Client\ClientController@postEvents')}}";
			var myReservationColor           = '{{config('calendar.my-reservation.color')}}';
			var myReservationBorderColor     = '{{config('calendar.my-reservation.border-color')}}';
			var myReservationBackgroundColor = '{{config('calendar.my-reservation.background-color')}}';
			var reservationarea              = '{{config('calendar.reservation-area')}}';
			var durationforedit              = parseInt('{{config('calendar.duration-for-edit')}}');
        </script>

        {{--<script src="{{secure_asset('gentellela/vendors/moment/min/moment.min.js')}}"></script>--}}
        {{--<script src="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.js')}}"></script>--}}
        {{--<script src="{{secure_asset('gentellela/vendors/fullcalendar/dist/locale-all.js')}}"></script>--}}
        {{--<script src="{{secure_asset('js/reservation.js')}}"></script>--}}
        <script src="{{asset('gentellela/vendors/moment/min/moment.min.js')}}"></script>
        <script src="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.js')}}"></script>
        <script src="{{asset('gentellela/vendors/fullcalendar/dist/locale-all.js')}}"></script>
        <script src="{{asset('js/reservation.js')}}"></script>
    @endif

@endsection