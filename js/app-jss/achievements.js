var pageContentDescription = 'achievements';

$('button[value="add"]').click(function() {
	var id = $(this).attr('data-id');
	$('tr[id^=new-row]').hide();
	$('#new-row' + id).show();

	$('button[value="add"]').show();
	$('button[value="save"]').hide();
	$('button[value="cancel"]').hide();
	toggleRowButtons(id);
})

$('button[value="cancel"]').click(function() {
	var id = $(this).attr('data-id');
	$('#new-row' + id).hide();
	toggleRowButtons(id);
})

function toggleRowButtons(id) {
	$('button[value="add"][data-id="' + id + '"]').toggle();
	$('button[value="save"][data-id="' + id + '"]').toggle();
	$('button[value="cancel"][data-id="' + id + '"]').toggle();
}

function validateNewAchievement(name, criteria, description) {
	var message = "";

	if(name == null || name == "") {
		message += "name is missing<br/>";
	}
	
	if(criteria == null || criteria == "") {
		message += "criteria is missing<br/>";
	}
	
	if(description == null || description == "") {
		message += "description is missing<br/>";
	}
	
	return message;
}

$('li a[data-critid]').click(function() {
	var id = $(this).attr('data-critid');
	var buttonDropdown = $(this).parent().parent().prev();
	
	var string = $(this).html();
	string = jQuery.trim(string).substring(0, 20)
    .split(" ").slice(0, -1).join(" ") + "...";
	
	buttonDropdown.html(string + ' <span class="caret"></span>');
	buttonDropdown.val(id);
})

$('button[value="add-criteria"]').bind('click', addCriteriaBehavior);

function addCriteriaBehavior() {
	$('#add-crit-form').toggle();
	toggleCriteriaButtons();
	// clear prev data
	$('#crit-name').val('');
}

$('button[value="cancel-criteria"]').bind('click', cancelCriteriaBehavior);

function cancelCriteriaBehavior() {
	toggleCriteriaButtons();
	$('#add-crit-form').toggle();
}

function toggleCriteriaButtons() {
	$('button[value="save-criteria"]').toggle();
	$('button[value="cancel-criteria"]').toggle();
	$('button[value="add-criteria"]').toggle();
}

$('button[value="save-criteria"]').bind('click', saveCriteriaBehavior);

function saveCriteriaBehavior() {
	var name = $('#crit-name').val();
	
	if (name == null || name == "") {
		alert('name must be entered');
		return;
	}
	
	var url = $('#base_url').val() + "welcome/add_criteria";
	$.post(url, {
		'name' : name
	}, function(data) {
		refreshCriteriaModelTableContent(data);
	});
}

function refreshCriteriaModelTableContent(data) {
	$('#criteria-table tbody tr').remove();

	var jsonArray = JSON.parse(data);

	for ( var i in jsonArray) {
		var id = jsonArray[i].id;
		var name = jsonArray[i].name;

		var trHtml = '<tr><td> <button type="button" class="btn btn-info" value="edit-crit" data-id="'+ id + '"><span class="glyphicon glyphicon-pencil"></span></button>';
			trHtml += ' <button type="button" class="btn btn-danger" value="delete-crit" data-id="' + id + '"><span class="glyphicon glyphicon-trash"></span></button>';
			
			trHtml += ' <button type="button" class="btn btn-success" value="update-crit" data-id="' + id + '" style="display: none"><span class="glyphicon glyphicon-floppy-disk"></span></button>';
    		trHtml += ' <button type="button" class="btn btn-danger" value="cancel-crit" data-id="' + id + '" style="display: none"><span class="glyphicon glyphicon-remove"></span></button>';
			
			trHtml += '&nbsp;&nbsp;&nbsp;<span data-value="' + id + '">' + name + '</span>';
			trHtml += '<input type="text" style="display: none;" class="form-control inline" id="input-edit' + id + '" value="' + name + '"></td></tr>';
		
		$('#criteria-table tbody').append(trHtml);
	}

	$('#criteria-table tbody tr:last').after(logicTableRows());

	reasignBindings();
}

function reasignBindings() {
	// assign the event listeners for the refreshed contents
	$('button[value="save-criteria"]').bind('click', saveCriteriaBehavior);
	$('button[value="delete-crit"]').bind('click', deleteCriteriaBehavior);
	$('button[value="cancel-criteria"]').bind('click', cancelCriteriaBehavior);
	$('button[value="add-criteria"]').bind('click', addCriteriaBehavior);
	$('button[value="edit-crit"]').bind('click', editCriteriaBehavior);
	$('button[value="cancel-crit"]').bind('click', editCriteriaBehavior);
	$('button[value="update-crit"]').bind('click', updateCriteriaBehavior);
}

function logicTableRows() {
	var htmlLogic = '<tr><td><button type="button" class="btn btn-primary" value="add-criteria"><span class="glyphicon glyphicon-plus"></span></button>';
	htmlLogic += ' <button type="button" class="btn btn-success" value="save-criteria" style="display: none"><span class="glyphicon glyphicon-floppy-disk"></span></button>';
	htmlLogic += ' <button type="button" class="btn btn-danger" value="cancel-criteria" style="display: none"><span class="glyphicon glyphicon-remove"></span></button>';
	htmlLogic += '</td></tr><tr id="add-crit-form" style="display: none;"><td><input type="text" class="form-control" id="crit-name" ></td></tr>';
	return htmlLogic;
}

$('button[value="delete-crit"]').bind('click', deleteCriteriaBehavior);

function deleteCriteriaBehavior() {
	var id = $(this).attr('data-id');
	var url = $('#base_url').val() + "welcome/remove_criteria";
	$.post(url, {
		'id' : id
	}, function(data) {
		refreshCriteriaModelTableContent(data);
	})
}

$('button[value="edit-crit"]').bind('click', editCriteriaBehavior);
$('button[value="cancel-crit"]').bind('click', editCriteriaBehavior);

function editCriteriaBehavior() {
	var id = $(this).attr('data-id');
	toggleCriteriaRowButtons(id);
}

$('button[value="update-crit"]').bind('click', updateCriteriaBehavior);

function updateCriteriaBehavior() {
	var id = $(this).attr('data-id');
	var name = $('#input-edit' + id).val();
	var url = $('#base_url').val() + "welcome/update_criteria";
	$.post(url, {
		'id' : id, 'name' : name
	}, function(data) {
		refreshCriteriaModelTableContent(data);
	});
}

function toggleCriteriaRowButtons(dataid) {
	$('button[value="edit-crit"][data-id="' + dataid + '"]').toggle();
	$('button[value="delete-crit"][data-id="' + dataid + '"]').toggle();
	$('button[value="update-crit"][data-id="' + dataid + '"]').toggle();
	$('button[value="cancel-crit"][data-id="' + dataid + '"]').toggle();
	
	$('span[data-value="' + dataid + '"]').toggle();
	$('#input-edit' + dataid).toggle();
}

$('button[value="save"]').click(function() {
	var id = $(this).attr('data-id'); //category id
	
	var name = $('#name' + id).val();
	var criteria = $('#criteria' + id).val();
	var description = $('#description' + id).val();
	var difficulty = $('#difficulty' + id).val();
	var continuous = $('#continuous' + id).prop('checked');
	
	var message = validateNewAchievement(name, criteria, description);
	
    if(message == "") {
    	var params = new Object();
    	params.name = name;
    	params.criteria = criteria;
    	params.description = description;
    	params.difficulty = difficulty;
    	params.continuous = continuous;
    	
    	if(id != "0") {
    		params.category = id;
    	}
    	
    	var url = $('#base_url').val() + "welcome/save_achievement";
    	
    	$.post(url, params, function(data) {
    		replaceMainContent(pageContentDescription);
    	});
    	
    } else {
    	$('#error').remove();
		$(this).last().after(createErrorMessage(message));
    }
});

$('button[value="delete-ach"]').click(function() {
	var shouldDelete = confirm('Are you sure you want to delete the item?');
	if(shouldDelete) {
		var id = $(this).attr('data-id');
		var url = $('#base_url').val() + "welcome/delete_achievement";
		$.get(url, {'id' : id}, function(data) {
			replaceMainContent(pageContentDescription);
		});
	}
});

$('button[value="edit-ach"]').click(function () {
	var id = $(this).attr('data-id');
	toggleAchievementRow(id);
});

function toggleAchievementRow(id) {
	$('#ach-name' + id).toggle();
	$('#ach-crit' + id).toggle();
	$('#ach-desc' + id).toggle();
	$('#ach-diff' + id).toggle();
	$('#ach-cont' + id).toggle();
	
	$('#edit-ach-name' + id).toggle();
	$('#edit-ach-crit' + id).toggle();
	$('#edit-ach-desc' + id).toggle();
	$('#edit-ach-diff' + id).toggle();
	$('#edit-ach-cont' + id).toggle();
	
	$('button[value="edit-ach"][data-id="' + id + '"]').toggle();
	$('button[value="delete-ach"][data-id="' + id + '"]').toggle();
	$('button[value="cancel-ach"][data-id="' + id + '"]').toggle();
	$('button[value="update-ach"][data-id="' + id + '"]').toggle();
}

$('button[value="cancel-ach"]').click(function() {
	var id = $(this).attr('data-id');
	toggleAchievementRow(id);
});

$('button[value="update-ach"]').click(function() {
	var id = $(this).attr('data-id');
	
	var name = $('#edit-ach-name' + id).val();
	var description = $('#edit-ach-desc' + id).val();
	var criteria = $('#edit-ach-crit' + id + ' :first-child').val();
	var continuous = $('#edit-ach-cont' + id).prop('checked');
	var difficulty = $('#edit-ach-diff' + id).val();
	
	var params = {
			'id' : id,
			'name' : name,
			'description' : description,
			'criteria' : criteria,
			'difficulty' : difficulty,
			'continuous' : continuous
	};
	
	var url = $('#base_url').val() + "welcome/update_achievement";
	$.post(url, params, function(data) {
		replaceMainContent(pageContentDescription);
	});
	
});