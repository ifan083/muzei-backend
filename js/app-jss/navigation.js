$('#nav-list li').on('click', function() {
	$('#nav-list li').removeClass("liactive");
	$(this).addClass("liactive");

	replaceMainContent($(this).attr('data-method'));
});

function replaceMainContent(method) {
	$('.jumbotron').empty();

	var url = $('#base_url').val() + "welcome/" + method;

	$.get(url, function(data) {
		$('.jumbotron').append(data);
	});
}

function resetFileElement(file) {
	file.replaceWith(file.val('').clone(true));
	;
}

function createErrorMessage(message) {
	var error = '<div class="alert alert-danger alert-dismissible" role="alert" id="error">';
	error += '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
	error += '<strong>Validation issues!</strong><br/>';
	error += message;
	error += '</div>';
	return error;
}

$('input[type="number"]').keydown(function(e) {
	// Allow: backspace, delete, tab, escape, enter and .
	if ($.inArray(e.keyCode, [ 46, 8, 9, 27, 13, 110, 190 ]) !== -1 ||
	// Allow: Ctrl+A
	(e.keyCode == 65 && e.ctrlKey === true) ||
	// Allow: home, end, left, right
	(e.keyCode >= 35 && e.keyCode <= 39)) {
		// let it happen, don't do anything
		return;
	}
	// Ensure that it is a number and stop the keypress
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57))
			&& (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
});
