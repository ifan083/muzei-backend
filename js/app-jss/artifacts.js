var pageContentDescription = 'artifacts';
$('a[data-desc="launchModal"]').click(function() {
	//set modal title
	var category = JSON.parse($(this).attr('data-catinfo'));
	$('#myModalLabel').html('Add new artifact in <i>' + category.category + '</i>');
	
	//set category
	$('#art_category').val(category.id);
	
	//clear fields
	clearForm();
	
	$('#myModal').modal('toggle');
});

$('form').submit(function (e) {
    e.preventDefault(); //prevent default form submit
    var message = isValid();
    if(message == "") {
    	$("form").unbind('submit').submit();
    } else {
    	$('#error').remove();
		$('form').after(createErrorMessage(message));
    }
});

function clearForm() {
	$('#error').remove();
	resetFileElement($('#img_file'));
	
	$('#art_desc').val('');
	$('#art_diff').val('');
	$('#art_name').val('');
}

function isValid() {
	var message = "";
	
	var character = $('#art_name').val();
	if (character == null || character == "") {
		message += "Artifact name is missing <br/>";
	}
	
	var description = $('#art_desc').val();
	if (description == null || description == "") {
		message += "Description is missing <br/>";
	}
	
	var difficulty = $('#art_diff').val();
	if(difficulty == null || difficulty == "") {
		message += "Difficulty is missing <br/>";
	}
	
	var picture = $('#img_file')[0].files[0];
	if (picture == null) {
		message += "No image is selected for uploading <br/>";
	}

	return message;
}

$('.thumbnail:not([data-catinfo])').click(function() {
	var obj = JSON.parse($(this).attr('data-info'));

	$('#det-img').attr('src', obj.picture);
	
	$('#det-name').html(obj.name);
	$('#det-desc').html(obj.description);
	$('#det-diff').html(obj.difficulty);
	
	var locationMessage = obj.location;
	if(locationMessage == null || locationMessage == "") {
		locationMessage = "NOT SET!!!";
		$('#det-remove-location').hide();
	} else {
		$('#det-remove-location').show();
	}
	$('#det-loc').html(locationMessage);
	
	$('#det-name-edit').val(obj.name);
	$('#det-desc-edit').val(obj.description);
	$('#det-diff-edit').val(obj.difficulty);
	
	//set delete id
	$('#det-id').val(obj.id);
	
	$('#det-dialog').modal('toggle');
});

$('#det-edit').click(function() {
	toggleModalButtons();
});

$('#det-cancel').click(function() {
	toggleModalButtons();
});

function toggleModalButtons() {
	$('#det-container').children().toggle();
	$('#det-save').toggle();
	$('#det-cancel').toggle();
	$('#det-edit').toggle();
	$('#det-delete').toggle();
}

$('#det-delete').click(function() {
	$('#det-dialog').modal('toggle');
	var shouldDelete = confirm('Are you sure you want to delete the item?');
	if (shouldDelete) {
		var url = $('#base_url').val() + "welcome/delete_artifact";
		$.get(url, {
			'id' : $('#det-id').val()
		}, function(data) {
			replaceMainContent(pageContentDescription);
		});
	}
});

$('#det-save').click(function() {
	$('#det-dialog').modal('toggle');
	var url = $('#base_url').val() + "welcome/update_artifact";
	
	var id = $('#det-id').val();
	var name = $('#det-name-edit').val();
	var description = $('#det-desc-edit').val();
	var difficulty = $('#det-diff-edit').val();
	
	var params = {'id' : id, 
			'name' : name, 
			'description' : description,
			'difficulty' : difficulty};
	
	$.post( url, params, function( data ) {
		replaceMainContent(pageContentDescription);
	});
});

$('#det-remove-location').click(function() {
	$('#det-dialog').modal('toggle');
	var id = $('#det-id').val();
	var location = $('#det-loc').html();
	var url = $('#base_url').val() + "welcome/remove_location";
	$.get(url, { 'id' : id, 'location' : location }, function(data) {
		replaceMainContent(pageContentDescription);
		$('.modal-backdrop').remove();
	});
});