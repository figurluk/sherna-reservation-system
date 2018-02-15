/**
 * Created by lukas on 30/03/2017.
 */

var actualUser = null;


function initDatePickers() {
	var formDate = $(".form_datetime").datetimepicker({
		language      : pickerLocale,
		format        : "dd.mm.yyyy - hh:ii",
		autoclose     : true,
		startDate     : moment().add(durationforedit, 'm').format('YYYY-MM-DD HH:mm'),
		endDate       : moment().add(reservationarea, 'd').format('YYYY-MM-DD HH:mm'),
		todayBtn      : true,
		todayHighlight: false,
		pickerPosition: "bottom-left",
		minuteStep    : 15
	});


	var toDate = $(".to_datetime").datetimepicker({
		language      : pickerLocale,
		format        : "dd.mm.yyyy - hh:ii",
		autoclose     : true,
		startDate     : moment().add(durationforedit * 2, 'm').format('YYYY-MM-DD HH:mm'),
		todayBtn      : true,
		todayHighlight: false,
		pickerPosition: "bottom-right",
		minuteStep    : 15
	});

	return [formDate, toDate];
}

$('#createReservationModal').on('shown.bs.modal', function (e) {
	$.ajax({
		method: 'post',
		url   : consolesURL,
		data  : {
			location: $('[name="location"]:checked').val()
		}
	}).success(function (data) {
		var selectedEventData = {};

		getActualUser(null, null, function () {
			selectedEventData.title = App.trans('reservation-title') + actualUser.name + ' ' + actualUser.surname;
			selectedEventData.uid   = actualUser.uid
		});

		var pickers  = initDatePickers();
		var formDate = pickers[0];
		var toDate   = pickers[1];

		formDate.on('changeDate', function (ev) {
			var value    = moment($(".form_datetime").val() + ':00', 'DD.MM.YYYY - HH:mm').add(15, 'm');
			var maxValue = moment(value.format('YYYY-MM-DD HH:mm')).add(maxeventduration, 'h').subtract(15, 'm');

			toDate.datetimepicker('setStartDate', value.format('YYYY-MM-DD HH:mm'));
			toDate.datetimepicker('setEndDate', maxValue.format('YYYY-MM-DD HH:mm'));
			toDate.val(null);
			selectedEventData.start = moment($(".form_datetime").val() + ':00', 'DD.MM.YYYY - HH:mm');
		});


		toDate.on('changeDate', function (ev) {
			selectedEventData.end = moment($(".to_datetime").val() + ':00', 'DD.MM.YYYY - HH:mm');
		});

		saveReservation(selectedEventData);

	}).error(function (msg) {
		App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'), 'danger');
		$('#console_id').parent('div').addClass('hidden');
	})
});

$(document).ready(function () {

	$('#calendar').fullCalendar({
		header         : {
			left  : 'prev,next',
			center: 'title',
			right : ''
		},
		views          : {
			agendaWeek: {
				slotDuration: '00:15:00'
			}
		},
		firstDay       : 1,
		editable       : false,
		nowIndicator   : true,
		allDaySlot     : false,
		timeFormat     : 'H:mm',
		slotLabelFormat: "H:mm",
		columnFormat   : 'ddd D.M.',
		defaultDate    : moment(new Date()).format('YYYY-MM-DD'),
		defaultView    : 'agendaWeek',
		locale         : (locale == 'cz') ? 'cs' : locale,
		titleFormat    : 'D. MMMM YYYY',
		navLinks       : true, // can click day/week names to navigate views
		selectable     : false,
		selectHelper   : false,
		select         : function (start, end) {

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
		eventLimit     : true, // allow "more" link when too many events
		eventOverlap   : false,
		eventSources   : [
			{
				url    : eventsUrl,
				type   : 'POST',
				data   : function () { // a function that returns an object
					return {
						location: $('[name="location"]:checked').val()
					};
				},
				error  : function () {
					App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'));
				},
				overlap: false
			}
		],
		eventClick     : function (event) {
			$('#showReservationModal').modal('show');
			$('#showReservationModal').on('shown.bs.modal', function (e) {
				$('#showReservationModalLabel').text(event.title);
				$('#start').text(event.start.format("DD.MM.YYYY HH:mm"));
				$('#end').text(event.end.format("DD.MM.YYYY HH:mm"));

				if (event.editable) {
					$('#deleteReservation').removeClass('hidden');
					$('#deleteReservation').unbind();
					$('#deleteReservation').bind('click', function (ev) {
						App.helpers.alert.confirm(App.trans('sure-delete'), App.trans('sure-delete-text'), 'warning', function () {
							$.ajax({
								method : 'POST',
								url    : deleteEventUrl,
								data   : {
									reservation_id: event.id
								},
								success: function (data) {
									$('#showReservationModal').modal('hide');
									$('#calendar').fullCalendar('removeEvents', [event.id]);
									App.helpers.flash.create('success', App.trans('flashes.success_deleted'));
								}
							});
						})
					});
				}
			});
			return true;
		},
		eventResize    : function (event, delta, revertFunc) {
			updateEvent(event, revertFunc);
		},
		eventDrop      : function (event, delta, revertFunc) {
			updateEvent(event, revertFunc);
		},
		eventAllow     : function (dropLocation, draggedEvent) {
			var now               = moment();
			var future_date_today = moment(now).add(durationforedit, 'm');
			var future_date       = moment(now).add(reservationarea, 'days');

			//gmt fix
			var dropStart = dropLocation.start;
			dropStart     = dropStart.subtract(2, 'h');

			return dropStart.isAfter(future_date_today.format('YYYY-MM-DD HH:mm')) && dropStart.isBefore(future_date.format('YYYY-MM-DD'));
		}
	});

	$('.fc-button').addClass('btn btn-primary').removeClass('fc-button').removeClass('fc-button fc-state-default');
	$('.fc-button-group').addClass('btn-group').removeClass('fc-button-group').attr('data-toggle', 'buttons');
});

function reRenderCallendar() {
	$('#calendar-loader').removeClass('hidden');
	// $('#calendar').addClass('hidden');
	$('#calendar').fullCalendar('removeEvents');
	$('#calendar').fullCalendar('refetchEvents');
	setTimeout(function () {
		$('#calendar-loader').addClass('hidden');
		// $('#calendar').removeClass('hidden');
	},1000);
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
			App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'));
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

		actualUser = createUser(data);

		if (callback != null) {
			callback(param1, param2);
		}
	}).error(function (msg) {
		App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'));
		$('#calendar').fullCalendar('unselect');
	});
}

function createEventAjax(start, end) {

	var selectedEventData = {
		title: App.trans('reservation-title') + actualUser.name + ' ' + actualUser.surname,
		start: start,
		end  : end,
		uid  : actualUser.uid
	};

	$('#createReservationModal').on('shown.bs.modal', function (e) {
		saveReservation(selectedEventData);
	});
}

function createEvent(start, end) {
	if (actualUser == null) {
		getActualUser(start, end, createEventAjax)
	}
	else {
		createEventAjax(start, end);
	}
}

function saveReservation(selectedEventData) {

	$('#saveReservation').unbind();
	$('#saveReservation').bind('click', function (ev) {
		ev.preventDefault();

		var valid = true;
		if (selectedEventData.start == null) {
			App.helpers.alert.info(App.trans('not-filled'), App.trans('fill-start-date'), 'danger');
			valid = false;
		}
		else if (selectedEventData.end == null) {
			App.helpers.alert.info(App.trans('not-filled'), App.trans('fill-to-date'), 'danger');
			valid = false;
		}
		if (!valid) {
			return;
		}

		var $radios = $('[name="location"]');
		$radios.filter('[value=' + $('[name="location_id"]').val() + ']').prop('checked', true);

		$.ajax({
			method: 'POST',
			url   : createEventUrl,
			data  : {
				userUID : actualUser.uid,
				start   : selectedEventData.start.format("YYYY/MM/DD HH:mm:ss"),
				end     : selectedEventData.end.format("YYYY/MM/DD HH:mm:ss"),
				location: $('[name="location_id"]').val(),
				visitors: $('#visitors_count').val(),
				note    : $('#note').val()
			}
		}).success(function (data) {
			selectedEventData.id              = data['id'];
			selectedEventData.editable        = data['editable'];
			selectedEventData.textColor       = myReservationColor;
			selectedEventData.borderColor     = myReservationBorderColor;
			selectedEventData.backgroundColor = myReservationBackgroundColor;
			$('#calendar').fullCalendar('renderEvent', selectedEventData);
			$('#createReservationModal').modal('hide');
			$(".to_datetime").val(null);
			$(".form_datetime").val(null);

			App.helpers.flash.create('success', App.trans('flashes.success_created'));
		}).error(function (msg) {
			if (msg.responseJSON.state != null && msg.responseJSON.state == 'failed') {
				App.helpers.alert.info(msg.responseJSON.title, msg.responseJSON.text, 'danger');
			} else {
				App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'), 'danger');
			}
			$('#calendar').fullCalendar('unselect');
			reRenderCallendar();
		})
	});
}

$(document).on('change', '[name="location"]', function (ev) {
	reRenderCallendar();
});

function createUser(data) {
	return {
		uid    : data['uid'],
		name   : data['name'],
		surname: data['surname']
	}
}
