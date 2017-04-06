@extends('layouts.client')

@section('styles')
    <link href="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
    <link href="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet" media="print">
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

    @if($page->code=='rezervace')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group" data-toggle="buttons">
                        @foreach(\App\Models\Location::get() as $location)
                            <label class="btn btn-lg btn-primary {{!$location->status->opened ? 'disabled':''}}">
                                <input type="radio" name="location" value="{{$location->id}}"
                                       autocomplete="off" {{!$location->status->opened ? 'disabled':''}}> {{$location->name}}
                            </label>
                        @endforeach
                    </div>
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
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection


@section('scripts')

    @if($page->code=='rezervace')
        <script type="text/javascript">
			var locale = "{{Session::get('lang')}}";
			var userUrl = "{{action('Client\ClientController@postUserData')}}";
			var createEventUrl = "{{action('Client\ClientController@postCreateEvent')}}";
			var eventsUrl = "{{action('Client\ClientController@postEvents')}}";
        </script>

        <script src="{{secure_asset('gentellela/vendors/moment/min/moment.min.js')}}"></script>
        <script src="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.js')}}"></script>
        <script src="{{secure_asset('gentellela/vendors/fullcalendar/dist/locale-all.js')}}"></script>
        <script src="{{secure_asset('js/reservation.js')}}"></script>
    @endif

@endsection