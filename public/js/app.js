$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

$(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
		}
	});
});
