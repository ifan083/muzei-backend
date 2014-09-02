var pageContentDescription = 'app_update';

$('li a[data-status]').click(function() {
	var html = $(this).html() + ' <span class="caret"></span>';
	$('#status').html(html);
});

$('#create-zip').click(function() {
	var status = $('#status').html();
	status = status.replace(' <span class="caret"></span>', '');
	alert(status);
	if (status.indexOf("Select status") > -1) {
		alert('You need to select status message first');
	} else {
		var url = $('#base_url').val() + "welcome/prepare_zip";
		$.get(url, {'status' : status}, function(data) {
			alert(data);
			if(data == "ok") {
				replaceMainContent(pageContentDescription);
			}
		});
	}
});

$('#download').click(function() {
	var url = $('#base_url').val() + 'download/update.zip';
	$.ajax({
	    url: url,
	    type: 'POST',
	    success: function() {
	        window.location = 'download/update.zip';
	    }
	});
});