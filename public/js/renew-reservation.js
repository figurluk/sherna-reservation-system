/**
 * Created by lukas on 30/03/2017.
 */

var actualUser = null;


$('#createReservationModal').on('shown.bs.modal', function (e) {
	var targetBTN = $(e.relatedTarget);
	
	$.ajax({
		method: 'post',
		url   : eventDataUrl,
		data  : {
			reservationID: targetBTN.attr('data-reservation-id'),
		}
	}).success(function (data) {
		var selectedEventData = {};
		
		getActualUser(null, null, null);
		
		selectedEventData.relatedBTN    = targetBTN;
		selectedEventData.reservationID = targetBTN.attr('data-reservation-id');
		
		data = JSON.parse(data);
		
		var toDate = $(".to_datetime").datetimepicker({
			language      : pickerLocale,
			format        : "dd.mm.yyyy - hh:ii",
			autoclose     : true,
			startDate     : moment(data.end, 'YYYY-MM-DD HH:mm:ss').add(15, 'm').format('YYYY-MM-DD HH:mm'),
			endDate       : moment(data.end, 'YYYY-MM-DD HH:mm:ss').add(maxeventduration, 'h').format('YYYY-MM-DD HH:mm'),
			todayBtn      : false,
			todayHighlight: false,
			pickerPosition: "bottom-right",
			minuteStep    : 15
		});
		
		toDate.on('changeDate', function (ev) {
			selectedEventData.end = moment($(".to_datetime").val() + ':00', 'DD.MM.YYYY - HH:mm');
		});
		
		updateReservation(selectedEventData);
		
	}).error(function (msg) {
		App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'));
	})
});

function getActualUser(param1, param2, callback) {
	$.ajax({
		method: 'POST',
		url   : userUrl,
	}).success(function (data) {
		data = JSON.parse(data);
		
		actualUser = new User(data['uid'], data['name'], data['surname']);
		
		if (callback != null) {
			callback(param1, param2);
		}
	}).error(function (msg) {
		App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'));
		$('#calendar').fullCalendar('unselect');
	});
}

function updateReservation(selectedEventData) {
	
	$('#saveReservation').unbind();
	$('#saveReservation').bind('click', function (ev) {
		ev.preventDefault();
		
		var valid = true;
		if (selectedEventData.end == null) {
			App.helpers.alert.info(App.trans('not-filled'), App.trans('fill-to-date'));
			valid = false;
		}
		if (!valid) {
			return;
		}
		
		$.ajax({
			method: 'POST',
			url   : updateEventUrl,
			data  : {
				reservationID: selectedEventData.reservationID,
				end          : selectedEventData.end.format("YYYY/MM/DD HH:mm:ss"),
			}
		}).success(function (data) {
			$('#createReservationModal').modal('hide');
			$(".to_datetime").val(null);
			
			selectedEventData.relatedBTN.closest('ul').find('.end-date').text(data['end']);
			$('tr[data-reservation-id="' + selectedEventData.reservationID + '"]').find('.end-date').text(data['end']);
			selectedEventData.relatedBTN.remove();
			
			App.helpers.flash.create('success', App.trans('flashes.success_renew'));
		}).error(function (msg) {
			App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'));
			$('#createReservationModal').modal('hide');
		})
	});
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