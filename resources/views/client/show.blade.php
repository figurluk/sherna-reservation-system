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

    @endif

@endsection


@section('scripts')

    <script src="{{secure_asset('gentellela/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.js')}}"></script>
    <script src="{{secure_asset('gentellela/vendors/fullcalendar/dist/locale-all.js')}}"></script>

    <script>

		$(document).ready(function () {

			$('#calendar').fullCalendar({
				header      : {
					left  : 'prev,next today',
					center: 'title',
					right : 'agendaWeek,agendaDay'
				},
				views       : {
					agendaWeek: { // name of view
					}
				},
				firstDay    : 1,
				columnFormat: 'ddd D.M.',
				defaultDate : moment(new Date()).format('YYYY-MM-DD'),
				defaultView : 'agendaWeek',
				locale      : '{{Session::get('lang') =='cz' ?'cs':Session::get('lang')}}',
				titleFormat : 'D. MMMM YYYY',
				navLinks    : true, // can click day/week names to navigate views
				selectable  : true,
				selectHelper: true,
				select      : function (start, end) {
					var title = prompt('Event Title:');
					var eventData;
					if (title) {
						eventData = {
							title: title,
							start: start,
							end  : end
						};
						$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
					}
					$('#calendar').fullCalendar('unselect');
				},
				editable    : true,
				eventLimit  : true, // allow "more" link when too many events
				eventOverlap: false,
				events      : [
					{
						title: 'All Day Event',
						start: '2017-02-01'
					},
					{
						title: 'Long Event',
						start: '2017-02-07',
						end  : '2017-02-10'
					},
					{
						id   : 999,
						title: 'Repeating Event',
						start: '2017-02-09T16:00:00'
					},
					{
						id   : 999,
						title: 'Repeating Event',
						start: '2017-02-16T16:00:00'
					},
					{
						title: 'Conference',
						start: '2017-02-11',
						end  : '2017-02-13'
					},
					{
						title: 'Meeting',
						start: '2017-02-12T10:30:00',
						end  : '2017-02-12T12:30:00'
					},
					{
						title: 'Lunch',
						start: '2017-02-12T12:00:00'
					},
					{
						title: 'Meeting',
						start: '2017-02-12T14:30:00'
					},
					{
						title: 'Happy Hour',
						start: '2017-02-12T17:30:00'
					},
					{
						title: 'Dinner',
						start: '2017-02-12T20:00:00'
					},
					{
						title: 'Birthday Party',
						start: '2017-02-13T07:00:00'
					},
					{
						title: 'Click for Google',
						url  : 'http://google.com/',
						start: '2017-02-28'
					}
				]
			});
		});

    </script>
@endsection