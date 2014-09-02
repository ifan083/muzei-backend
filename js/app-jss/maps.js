var pageContentDescription = 'maps';
var canvas = $('#blueprint_map');
var context = canvas[0].getContext('2d');
var canDrawOnCanvas = false;
var rectSize = 16;
var rectHalf = rectSize / 2;
var image = null;

$(function() {
	// set the default 
	var json = $('#default-id').val();
	var obj = JSON.parse(json);
	changeFloor(obj);
});

$('#add-floor').click(function() {
	toggleForm();
});

$('#cancel-floor').click(function() {
	toggleForm();
	clearForm();
});

function toggleForm() {
	$('form').toggle();
	$('#add-floor').toggle();
}

function clearForm() {
	$('#name').val('');
	$('#level').val('');
	resetFileElement($('#img_file'));
}

$('form').submit(function(e) {
	e.preventDefault(); // prevent default form submit
	var message = isValid();
	if (message == "") {
		$("form").unbind('submit').submit();
	} else {
		$('#error').remove();
		$('form').after('<br/>' + createErrorMessage(message));
	}
});

function isValid() {
	var message = "";

	var name = $('#name').val();
	var level = $('#level').val();
	var picture = $('#img_file')[0].files[0];

	if (picture == null) {
		message += "No image is selected for uploading <br/>";
	}

	if (name == null || name == "") {
		message += "Flooor name is missing <br/>";
	}

	if (level == null || level == "") {
		message += "Floor level is missing <br/>";
	}

	return message;
}

$('li a[data-obj]').click(function() {
	var obj = JSON.parse($(this).attr('data-obj'));
	changeFloor(obj);
});

function changeFloor(obj) {
	// change the name of the dropdown with the name of the floor
	changeDropdownName(obj.name);
	$('#remove-floor').attr('data-floor', obj.id);
	$('#selected-floor').val(obj.id);

	image = new Image();
	image.src = obj.picture;
	image.onload = function() {
		canvas.attr('width', image.width);
		canvas.attr('height', image.height);
		context.drawImage(image, 0, 0);
		redrawOldState();
	}
	
	// manage the default state
	//if it is default, hide the button, else show the button
	if(obj.isdefault == 1) {
		$('#default-floor').hide();
	} else {
		$('#default-floor').show();
	}
}

$('#default-floor').click(function() {
	//change the default floor id
	var floorId = $('#remove-floor').attr('data-floor');
	var url = $('#base_url').val() + 'welcome/change_default_floor';
	$.get(url, { 'id' : floorId}, function(data) {
		replaceMainContent(pageContentDescription);
	});
});

function changeDropdownName(newName) {
	var entry = '<span class="glyphicon glyphicon-tasks"></span> ' + newName
			+ ' <span class="caret"></span>';
	$('button[data-toggle="dropdown"]').html(entry);
}

$('#remove-floor').click(function() {
	var id = $(this).attr('data-floor');

	if (id == null || id == "") {
		alert('id not set');
		return;
	}

	var shouldDelete = confirm('Are you sure you want to delete the floor?');
	if (shouldDelete) {
		var url = $('#base_url').val() + "welcome/delete_floor";
		$.get(url, {
			'id' : id
		}, function(data) {
			replaceMainContent(pageContentDescription);
		});
	}
});

$('#add-pin').click(function() {
	if (canDrawOnCanvas) {
		$(this).html('<span class="glyphicon glyphicon-pushpin"></span> Add Pin');
		canvas.css('border', '');
	} else {
		$(this).html('<span class="glyphicon glyphicon-remove"></span> Cancel Pin');
		canvas.css('border', '1px solid green');
	}
	redrawOldState();
	canDrawOnCanvas = (!canDrawOnCanvas);
	$('#lock-position').toggle();
});

canvas.mouseup(function(e) {
	var x = e.pageX - this.offsetLeft;
	var y = e.pageY - this.offsetTop;

	if (canDrawOnCanvas) {
		// save latest state
		var coords = {
			'x' : x,
			'y' : y
		};
		$('#coordinates').attr('data-coords', JSON.stringify(coords));

		redrawOldState();
		context.strokeRect(x - rectHalf, y - rectHalf, rectSize, rectSize);
	} else {
		var vertex = findClickedVertex(x, y);
		if(vertex != null) {
			var url = $('#base_url').val() + 'welcome/get_artifact_by_location';
			$.get(url, {'id':vertex}, function(data) {
				$('#tooltip').css('left', e.pageX);
				$('#tooltip').css('top', e.pageY);
				populateTooltip(data);
				$('#tooltip').show();
			});
			
		} else {
			$('#tooltip').hide();
		}
	}
});

function populateTooltip(data) {
	var obj = JSON.parse(data);
	
	$('#artifact-name').html(obj.name);
	$('#artifact-image').attr('src', obj.picture);
	$('#artifact-desc').html(obj.description);
	$('#artifact-diff').html(obj.difficulty);
	$('#artifact-cat').html(obj.category);
}

function findClickedVertex(px, py) {
	var floor = $('#selected-floor').val();
	var vertexes = $('input[value="floor-vertexes"][data-id="' + floor + '"]')
			.attr('data-array');
	var array = JSON.parse(vertexes);

	var vertex = null;
	for ( var i in array) {
		// calc correct x & y
		var x = array[i].xpercent * canvas.attr('width');
		var y = array[i].ypercent * canvas.attr('height');

		// round x & y
		x = Math.floor(x);
		y = Math.floor(y);

		if(px >= x-rectHalf && px <= x+rectHalf && py >= y-rectHalf && py <= y+rectHalf) {
			vertex = array[i].id;
		}
	}
	return vertex;
}

function redrawOldState() {
	context.drawImage(image, 0, 0);
	// redraw all pins
	var floor = $('#selected-floor').val();
	var vertexes = $('input[value="floor-vertexes"][data-id="' + floor + '"]')
			.attr('data-array');
	var array = JSON.parse(vertexes);

	for ( var i in array) {

		// calc correct x & y
		var x = array[i].xpercent * canvas.attr('width');
		var y = array[i].ypercent * canvas.attr('height');

		// round x & y
		x = Math.floor(x);
		y = Math.floor(y);

		context.fillRect(x - rectHalf, y - rectHalf, rectSize, rectSize);
	}
}

$('#artifact-autocomplete').keyup(function() {
	var url = $('#base_url').val() + "welcome/get_like_artifacts";
	var value = $(this).val();
	if (value == "") {
		$('#autocomplete-results').empty();
		return;
	}
	$.get(url, {
		'name' : $(this).val()
	}, function(data) {
		populateList(data);
	});
});

function populateList(json) {
	var data = JSON.parse(json);
	$('#autocomplete-results').empty();
	for ( var i in data) {
		var disabledAttr = data[i].location == null ? '' : 'disabled';
		var innerHTML = '<li class="list-group-item" data-id="' + data[i].id
				+ '" ' + disabledAttr + ' >';
		innerHTML += data[i].name;
		if (data[i].location != null) {
			innerHTML += ' (has location)';
		}
		innerHTML += '</li>';
		$('#autocomplete-results').append(innerHTML);
	}
	$('#autocomplete-results li').on('click', function() {
		if ($(this).html().toLowerCase().indexOf("(has location)") >= 0) {
			return;
		}

		$('#autocomplete-results li').removeClass('autocomplete-active');
		$(this).addClass('autocomplete-active');

		$('#selected-artifact').val($(this).attr('data-id'));
	});
}

$('#location-assign').click(function() {
	var id = $('#selected-artifact').val();
	if (id == "") {
		alert('You first need to select an artifact');
		return;
	}
	
	var coordinates = JSON.parse($('#coordinates').attr('data-coords'));
	var x = coordinates.x / canvas.attr('width');
	var y = coordinates.y / canvas.attr('height');
	var like = $('#artifact-autocomplete').val();
	var params = {
		'id' : id,
		'like' : like,
		'floor' : $('#selected-floor').val(),
		'x' : x,
		'y' : y
	};

	var url = $('#base_url').val() + "welcome/add_location";
	$.post(url, params, function(data) {
		replaceMainContent(pageContentDescription);
		$('.modal-backdrop').remove();
	});
});