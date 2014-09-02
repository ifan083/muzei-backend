var pageContentDescription = 'characters';

$('#add_char').click(function() {
	toggleInput();
});

$('#cancel_char').click(function() {
	toggleInput();
	
	//clear old input
	$('#error').remove();
	
	$('#char_name').val('');
	$('#char_category').val('');
	
	resetFileElement($('#img_file'));
});

$('#delete-row').click(function() {
	var shouldDelete = confirm('Are you sure you want to delete the item?');
	if (shouldDelete) {
		var url = $('#base_url').val() + "welcome/delete_character";
		$.get(url, {
			'id' : $(this).attr('data-id')
		}, function(data) {
			replaceMainContent(pageContentDescription);
		});
	}
});

$('#edit-row').click(function() {
	var id = $(this).attr('data-id');
	toggleRow(id);
});

$('#cancel-row').click(function() {
	toggleRow($(this).attr('data-id'));
});

function toggleRow(id) {
	$('input[id^="edit-"][data-id="'+id+'"]').toggle();
	$('span[id^="row-"][data-id="'+id+'"]').toggle();
	
	$('button[id="edit-row"][data-id="'+id+'"]').toggle();
	$('button[id="delete-row"][data-id="'+id+'"]').toggle();
	$('button[id="save-row"][data-id="'+id+'"]').toggle();
	$('button[id="cancel-row"][data-id="'+id+'"]').toggle();
}

$('#save-row').click(function() {
	var url = $('#base_url').val() + "welcome/update_character";
	var id = $(this).attr('data-id');
	
	var params = {'id' : id, 
			'name' : $('input[id="edit-name"][data-id="'+id+'"]').val(), 
			'category' : $('input[id="edit-category"][data-id="'+id+'"]').val(),
			'mapper' : $('input[id="edit-mapper"][data-id="'+id+'"]').prop('checked')};
	$.post( url, params, function( data ) {
		replaceMainContent(pageContentDescription);
	});
	
});

function toggleInput() {
	$('#input_character').toggle();
	$('#add_char').toggle();
	$('#save_char').toggle();
	$('#cancel_char').toggle();
}

function isValid() {
	var message = "";
	
	var character = $('#char_name').val();
	if (character == null || character == "") {
		message += "Character name is missing <br/>";
	}
	
	var category = $('#char_category').val();
	if (category == null || category == "") {
		message += "Category is missing <br/>";
	}

	var picture = $('#img_file')[0].files[0];
	if (picture == null) {
		message += "No image is selected for uploading <br/>";
	}

	return message;
}

$("form").submit(function (e) {
    e.preventDefault(); //prevent default form submit
    var message = isValid();
    if(message == "") {
    	$("form").unbind('submit').submit();
    	$("form").bind('ajax:complete', function() {
    		replaceMainContent(pageContentDescription);
      });
    } else {
    	$('#error').remove();
		$('#form_footer').after(createErrorMessage(message));
    }
});
