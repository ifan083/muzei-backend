<?php 
	$segmentedArray = array();
	foreach ($floors as $f) {
		if($f['isdefault']) {
			echo '<input type="hidden" id="default-id" value=\''.json_encode($f).'\'>';
		}
		$segmentedArray[$f['id']] = array();		
	}
	foreach ($locations as $l) {
		array_push($segmentedArray[$l['floor']], $l);
	}
	foreach ($segmentedArray as $key => $value) {
		echo '<input type="hidden" value="floor-vertexes" data-id="'.$key.'"  data-array=\''.json_encode($value).'\'>';
	}
?>

<form style="display: none" id='upload_form' enctype="multipart/form-data" method="post" action="<?php echo base_url('welcome/save_floor'); ?>">
	<button type="submit" class="btn btn-success" id="save-floor"><span class="glyphicon glyphicon-ok"></span></button>
	<button type="button" class="btn btn-danger" id="cancel-floor"><span class="glyphicon glyphicon-remove"></span></button>
	
	<br><br>
	
	<input type="file" name="file" id="img_file" value="Upload picture" />
	<div class="input-group" style="margin-top: 5px;">
		<span class="input-group-addon">Level</span> 
		<input type="number" class="form-control" placeholder="i.e. -1, 0, 1, ..." name="level" id="level">
	</div>
	<div class="input-group" style="margin-top: 5px;">
		<span class="input-group-addon">Name</span> 
		<input type="text" class="form-control" placeholder="i.e. Mezanine" name="name" id="name">
	</div>
</form>

<br><br>
<div class="row" style="margin-left: 0">
	<button type="button" class="btn btn-primary" id="add-floor"><span class="glyphicon glyphicon-plus"></span> Add floor</button>
	<button type="button" class="btn btn-success" id="default-floor"><span class="glyphicon glyphicon-star"></span> Make default</button>
	<div class="btn-group">
	  <div class="btn-group">
	    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
	      <span class="glyphicon glyphicon-tasks"></span>
	      Select Floor
	      <span class="caret"></span>
	    </button>
	    <ul class="dropdown-menu" role="menu">
	    	<?php foreach($floors as $floor) { ?>
	    		<li><a href="#" data-obj='<?php echo json_encode($floor); ?>'><?php echo $floor['name']; ?></a></li>
	    	<?php }?>
	    </ul>
	  </div>
	  <input type="hidden" id="selected-floor">
	  <button type="button" id="add-pin" class="btn btn-primary"><span class="glyphicon glyphicon-pushpin"></span> Add Pin</button>
	  <button type="button" id="remove-floor" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Remove Floor</button>
	</div>

	<button type="button" id="lock-position" style="display: none" data-toggle="modal" data-target="#myModal" class="btn btn-primary">
		<span class="glyphicon glyphicon-lock"></span> Lock position
	</button>
</div>


<br><br>

<div>
	<canvas id="blueprint_map"></canvas>
	<input type="hidden" id="coordinates" >
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Find artifact and assign location</h4>
      </div>
      <div class="modal-body">
        <input type="text" id="artifact-autocomplete" class="form-control" placeholder="Artifact name">
        <br>
        <ul id="autocomplete-results">
        </ul>
        <input type="hidden" id="selected-artifact">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close-dialog" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="location-assign">Assign</button>
      </div>
    </div>
  </div>
</div>

<div id="tooltip" class="panel panel-default" style="position:absolute; display:none;">
  <div class="panel-heading" id="artifact-name">Panel heading without title</div>
  <div class="panel-body">
      <div class="col-sm-6 col-md-4 thumbnail" style="float: left; margin-right: 5px;">
	  	<img id="artifact-image" src="" alt="...">
	  </div>
	  <div style="float: left;">
	  	<b>Description</b><br>
	  	<span id="artifact-desc"></span><br>
	  	
	  	<b>Difficulty</b><br>
	  	<span id="artifact-diff"></span><br>
	  	
	  	<b>Category</b><br>
	  	<span id="artifact-cat"></span><br>
	  </div>
	  <br style="clear: both;">
  </div>
</div>

<script src="<?php echo  base_url(); ?>js/app-jss/maps.js"></script>
