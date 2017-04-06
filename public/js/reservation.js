/**
 * Created by lukas on 30/03/2017.
 */


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
		locale      : (locale == 'cz') ? 'cs' : locale,
		titleFormat : 'D. MMMM YYYY',
		navLinks    : true, // can click day/week names to navigate views
		selectable  : true,
		selectHelper: true,
		select      : function (start, end) {
			createEvent(start, end);
		},
		editable    : true,
		eventLimit  : true, // allow "more" link when too many events
		eventOverlap: false,
		events      : getActualEvents()
	});
});

function getActualEvents() {
	$.ajax({
		method: 'POST',
		url   : eventsUrl,
	}).success(function (data) {
	
	}).error(function (msg) {
	
	})
		
		// [
		// {
		// 	title: 'All Day Event',
		// 	start: '2017-02-01'
		// },
		// 	{
		// 		title: 'Long Event',
		// 		start: '2017-02-07',
		// 		end  : '2017-02-10'
		// 	},
		// 	{
		// 		id   : 999,
		// 		title: 'Repeating Event',
		// 		start: '2017-02-09T16:00:00'
		// 	},
		// 	{
		// 		id   : 999,
		// 		title: 'Repeating Event',
		// 		start: '2017-02-16T16:00:00'
		// 	},
		// 	{
		// 		title: 'Conference',
		// 		start: '2017-02-11',
		// 		end  : '2017-02-13'
		// 	},
		// 	{
		// 		title: 'Meeting',
		// 		start: '2017-02-12T10:30:00',
		// 		end  : '2017-02-12T12:30:00'
		// 	},
		// 	{
		// 		title: 'Lunch',
		// 		start: '2017-02-12T12:00:00'
		// 	},
		// 	{
		// 		title: 'Meeting',
		// 		start: '2017-02-12T14:30:00'
		// 	},
		// 	{
		// 		title: 'Happy Hour',
		// 		start: '2017-02-12T17:30:00'
		// 	},
		// 	{
		// 		title: 'Dinner',
		// 		start: '2017-02-12T20:00:00'
		// 	},
		// 	{
		// 		title: 'Birthday Party',
		// 		start: '2017-02-13T07:00:00'
		// 	},
		// 	{
		// 		title: 'Click for Google',
		// 		url  : 'http://google.com/',
		// 		start: '2017-02-28'
		// 	}
		// ]
}

function createEvent(start, end) {
	$.ajax({
		method: 'POST',
		url   : userUrl,
	}).success(function (data) {
		data = JSON.parse(data);
		
		var user = new User(data['uid'], data['name'], data['surname']);
		
		var eventData = {
			title: user.getName() + ' ' + user.getSurname(),
			start: start,
			end  : end,
			uid  : user.getUID()
		};
		
		$('#myModal').modal('show')
		
		$.ajax({
			method   : 'POST',
			url      : createEventUrl,
			data: {
				start: start,
				end  : end,
			}
		}).success(function (data) {
			
			
			$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
		}).error(function (msg) {
			$('#calendar').fullCalendar('unselect');
		})
		
	}).error(function (msg) {
		alert('prihlas sa');
		$('#calendar').fullCalendar('unselect');
	})
}

class User {
	
	constructor(uid, name, surname) {
		this.uid     = uid;
		this.name    = name;
		this.surname = surname;
	}
	
	getName() {
		return this.name;
	}
	
	getSurname() {
		return this.surname;
	}
	
	getUID() {
		return this.uid;
	}
}