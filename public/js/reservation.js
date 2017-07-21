/**
 * Created by lukas on 30/03/2017.
 */

var actualUser = null;

$(document).ready(function () {
	
	$('#calendar').fullCalendar({
		header      : {
			left  : 'prev,next today',
			center: 'title',
			right : 'agendaWeek,agendaDay'
		},
		views       : {
			agendaWeek: {
				slotDuration: '00:15:00'
			}
		},
		firstDay    : 1,
		editable    : false,
		columnFormat: 'ddd D.M.',
		defaultDate : moment(new Date()).format('YYYY-MM-DD'),
		defaultView : 'agendaWeek',
		locale      : (locale == 'cz') ? 'cs' : locale,
		titleFormat : 'D. MMMM YYYY',
		navLinks    : true, // can click day/week names to navigate views
		selectable  : false,
		selectHelper: false,
		select      : function (start, end) {
			
			var correct = controlEventTimes(start, end);
			if (!correct) {
				return;
			}
			
			var now               = moment();
			var future_date_today = moment(now).add(durationforedit, 'm');
			var future_date       = moment(now).add(reservationarea, 'days');
			
			if (start.isAfter(future_date_today.format('YYYY-MM-DD HH:mm')) && end.isBefore(future_date.format('YYYY-MM-DD'))) {
				createEvent(start, end);
			}
			else {
				$('#calendar').fullCalendar('unselect');
				alert('You cannot reservate here.')
			}
		},
		eventLimit  : true, // allow "more" link when too many events
		eventOverlap: false,
		eventSources: [
			{
				url    : eventsUrl,
				type   : 'POST',
				data   : function () { // a function that returns an object
					return {
						location: $('[name="location"]:checked').val()
					};
				},
				error  : function () {
					alert('There was an error while fetching events! Please ty it later.');
				},
				overlap: false
			}
		],
		eventClick  : function (event) {
			$('#showReservationModal').modal('show');
			$('#showReservationModal').on('shown.bs.modal', function (e) {
				$('#showReservationModalLabel').text(event.title);
				$('#start').text(event.start.format("DD.MM.YYYY HH:mm"));
				$('#end').text(event.end.format("DD.MM.YYYY HH:mm"));
				
				if (event.editable) {
					$('#deleteReservation').removeClass('hidden');
					$('#deleteReservation').unbind();
					$('#deleteReservation').bind('click', function (ev) {
						if (confirm('Do you really want to delete your reservation ?')) {
							$.ajax({
								method : 'POST',
								url    : deleteEventUrl,
								data   : {
									reservation_id: event.id
								},
								success: function (data) {
									$('#showReservationModal').modal('hide');
									$('#calendar').fullCalendar('removeEvents', [event.id]);
								}
							});
						}
					});
				}
			});
			return true;
		},
		eventResize : function (event, delta, revertFunc) {
			updateEvent(event, revertFunc);
		},
		eventDrop   : function (event, delta, revertFunc) {
			updateEvent(event, revertFunc);
		},
		eventAllow  : function (dropLocation, draggedEvent) {
			var now               = moment();
			var future_date_today = moment(now).add(durationforedit, 'm');
			var future_date       = moment(now).add(reservationarea, 'days');
			
			//gmt fix
			var dropStart = dropLocation.start;
			dropStart     = dropStart.subtract(2, 'h');
			
			return dropStart.isAfter(future_date_today.format('YYYY-MM-DD HH:mm')) && dropStart.isBefore(future_date.format('YYYY-MM-DD'));
		}
	});
});

function reRenderCallendar() {
	$('#calendar').fullCalendar('removeEvents');
	$('#calendar').fullCalendar('refetchEvents');
}

function updateEventAjax(event, revertFunc) {
	$.ajax({
		method : 'POST',
		url    : updateEventUrl,
		data   : {
			reservation_id: event.id,
			start         : event.start.format("YYYY/MM/DD HH:mm:ss"),
			end           : event.end.format("YYYY/MM/DD HH:mm:ss"),
		},
		success: function (data) {
			event.id       = data['id'];
			event.editable = data['editable'];
		},
		error  : function (msg) {
			alert(msg.responseText);
			revertFunc();
			reRenderCallendar();
		}
	});
}

function controlEventTimes(start, end) {
	if (Math.abs(start.diff(end, 'days')) !== 0) {
		$('#calendar').fullCalendar('unselect');
		alert('Make 2 separate reservations for this operation.');
		return false;
	}
	if (Math.abs(start.diff(end, 'hours')) > maxeventduration) {
		$('#calendar').fullCalendar('unselect');
		alert('Max duration of reservation can be ' + maxeventduration + ' hours.');
		return false;
	}
	return true;
}

function updateEvent(event, revertFunc) {
	var start = event.start;
	var end   = event.end;
	
	var correct = controlEventTimes(start, end);
	if (!correct) {
		revertFunc();
		return;
	}
	
	if (actualUser == null) {
		getActualUser(event, revertFunc, updateEventAjax)
	}
	else {
		updateEventAjax(event, revertFunc);
	}
}

function getActualUser(param1, param2, callback) {
	$.ajax({
		method: 'POST',
		url   : userUrl,
	}).success(function (data) {
		data = JSON.parse(data);
		
		actualUser = new User(data['uid'], data['name'], data['surname']);
		
		callback(param1, param2);
	}).error(function (msg) {
		alert(msg.responseText);
		$('#calendar').fullCalendar('unselect');
	});
}

$('#createReservationModal').on('shown.bs.modal', function (e) {
	$.ajax({
		method: 'post',
		url   : consolesURL,
		data  : {
			location: $('[name="location"]:checked').val(),
		}
	}).success(function (data) {
		if (data == 0) {
			$('#console_id').parent('div').addClass('hidden');
		}
		else {
			$('#console_id').parent('div').removeClass('hidden');
		}
		
		$('#console_id').empty();
		$('#console_id').append(data);
		
		$(".form_datetime").datetimepicker({
			language:pickerLocale,
			format: "dd.mm.yyyy - hh:ii",
			autoclose: true,
			todayBtn: true,
			pickerPosition: "bottom-left",
			minuteStep: 15
		});
		
		$(".to_datetime").datetimepicker({
			language:pickerLocale,
			format: "dd.mm.yyyy - hh:ii",
			autoclose: true,
			todayBtn: true,
			pickerPosition: "bottom-right",
			minuteStep: 15
		});
		
	}).error(function (msg) {
		$('#console_id').parent('div').addClass('hidden');
	})
});

function createEventAjax(start, end) {
	
	var selectedEventData = {
		title: 'Rezervace pro: ' + actualUser.getName() + ' ' + actualUser.getSurname(),
		start: start,
		end  : end,
		uid  : actualUser.getUID()
	};
	
	$('#createReservationModal').on('shown.bs.modal', function (e) {
		$('#saveReservation').unbind();
		$('#saveReservation').bind('click', function () {
			$.ajax({
				method: 'POST',
				url   : createEventUrl,
				data  : {
					userUID : actualUser.getUID(),
					start   : selectedEventData.start.format("YYYY/MM/DD HH:mm:ss"),
					end     : selectedEventData.end.format("YYYY/MM/DD HH:mm:ss"),
					location: $('[name="location"]:checked').val(),
					note    : $('#note').val()
				}
			}).success(function (data) {
				selectedEventData.id              = data['id'];
				selectedEventData.editable        = data['editable'];
				selectedEventData.textColor       = myReservationColor;
				selectedEventData.borderColor     = myReservationBorderColor;
				selectedEventData.backgroundColor = myReservationBackgroundColor;
				$('#calendar').fullCalendar('renderEvent', selectedEventData);
			}).error(function (msg) {
				alert(msg.responseText);
				$('#calendar').fullCalendar('unselect');
				reRenderCallendar();
			})
		});
	});
}

function createEvent(start, end) {
	if (actualUser == null) {
		console.log('get user');
		getActualUser(start, end, createEventAjax)
	}
	else {
		console.log('create even call ajax');
		createEventAjax(start, end);
	}
}

$(document).on('change', '[name="location"]', function (ev) {
	reRenderCallendar();
});

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