@extends('layouts.client')

@section('styles')
    <link href="{{'gentellela/vendors/fullcalendar/dist/fullcalendar.min.css'}}" rel="stylesheet">
    <link href="{{'gentellela/vendors/fullcalendar/dist/fullcalendar.print.css'}}" rel="stylesheet" media="print">
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
            <h1>Vitajte na strankach SHerny</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                {!! $page->pageText()->ofLang(Config::get('app.locale'))->first()->content !!}
            </div>
        </div>
    </div>

    <hr>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{asset('gentellela/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.js')}}"></script>
    <script src="{{asset('gentellela/vendors/fullcalendar/dist/locale-all.js')}}"></script>

    <script>

		$(document).ready(function() {

			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				defaultDate: '2017-02-12',
				locale: 'cs',
				navLinks: true, // can click day/week names to navigate views
				selectable: true,
				selectHelper: true,
				select: function(start, end) {
					var title = prompt('Event Title:');
					var eventData;
					if (title) {
						eventData = {
							title: title,
							start: start,
							end: end
						};
						$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
					}
					$('#calendar').fullCalendar('unselect');
				},
				editable: true,
				eventLimit: true, // allow "more" link when too many events
				events: [
					{
						title: 'All Day Event',
						start: '2017-02-01'
					},
					{
						title: 'Long Event',
						start: '2017-02-07',
						end: '2017-02-10'
					},
					{
						id: 999,
						title: 'Repeating Event',
						start: '2017-02-09T16:00:00'
					},
					{
						id: 999,
						title: 'Repeating Event',
						start: '2017-02-16T16:00:00'
					},
					{
						title: 'Conference',
						start: '2017-02-11',
						end: '2017-02-13'
					},
					{
						title: 'Meeting',
						start: '2017-02-12T10:30:00',
						end: '2017-02-12T12:30:00'
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
						url: 'http://google.com/',
						start: '2017-02-28'
					}
				]
			});
		});

    </script>
@endsection