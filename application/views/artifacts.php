<?php foreach ($categories as $category) { 
	if($category['mapper']) {
		continue;
	}
?>
<i style="font-size: 18px;"><?php echo $category['category']; ?></i><hr style="height: 1px; margin-top: 1px; background-color: black;">

<?php
	$subset = array ();
	foreach ( $artifacts as $artifact ) {
		if ($artifact ['category'] == $category ['id']) {
			array_push ( $subset, $artifact );
		}
	}
	
	for($i = 0; $i < count ( $subset ); $i ++) { 
		if ($i % 6 == 0) {
			if($i != 0) {
				echo '</div>';
			} 
			echo '<div class="row" style="margin: 0px;">';
		}
		?>
	
	<div class="col-xs-4 col-md-2">
    <a href="#" class="thumbnail" data-info='<?php echo json_encode($subset[$i]); ?>'>
      <img src="<?php echo $subset[$i]['picture']; ?>" alt="...">
    </a>
  	</div>
	
<?php }

	if(count($subset) % 6 != 0) { ?>
	<div class="col-xs-4 col-md-2">
    <a href="#" class="thumbnail" data-desc="launchModal" data-catinfo='<?php echo json_encode($category); ?>' >
      <img src="images/add.png" alt="...">
    </a>
  	</div>
	<?php
	echo '</div><br/>';	
	} else {
		echo '<div class="row">';
 		?>
		<div class="col-xs-4 col-md-2">
	    <a href="#" class="thumbnail" data-desc="launchModal" data-catinfo='<?php echo json_encode($category); ?>' >
	      <img src="images/add.png" alt="...">
	    </a>
	  	</div>	
		<?php 
		echo '</div><br/>';
	}
}?> 

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
      	<form id='upload_form' enctype="multipart/form-data" method="post" action="<?php echo base_url('welcome/save_artifact'); ?>">
      		<input type="hidden" id="art_category" name="art_category" />
      		<input type="file" name="file" id="img_file" value="Upload picture" />
			<div class="input-group" style="margin-top: 5px;">
				<span class="input-group-addon">Name</span> 
				<input type="text" class="form-control" placeholder="i.e. Komita" name="art_name" id="art_name">
			</div>
			<div class="input-group" style="margin-top: 5px;">
				<span class="input-group-addon">Description</span> 
				<input type="text" class="form-control" placeholder="i.e. The Ilinden Uprising" name="art_desc" id="art_desc">
			</div>
			<div class="input-group" style="margin-top: 5px; margin-bottom: 5px">
				<span class="input-group-addon">Difficulty</span> 
				<input type="number" class="form-control" placeholder="i.e. Number bigger than 0 (the bigger the more difficult)" name="art_diff" id="art_diff">
			</div>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="upload_form">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="det-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button id="exit-det-modal" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Artifact</h4>
      </div>
      <div class="modal-body">
      	<div class="col-sm-6 col-md-4" style="float: left;">
		    <div class="thumbnail">
		      <img id="det-img" src="" alt="...">
		    </div>
		  </div>
      	<div style="float: left" id="det-container">
      		<input type="hidden" id="det-id" />
      		
			<label>name&nbsp;</label>
			<span class="descriptor" id="det-name"></span><br>
			
			<label>description&nbsp;</label>
			<span class="descriptor" id="det-desc"></span><br>
			
			<label>location&nbsp;</label>
			<span class="descriptor" id="det-loc"></span>
			<button style="display: none;" id="det-remove-location" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Remove Location</button>
			<br>
			
			<label>difficulty&nbsp;</label>
			<span class="descriptor" id="det-diff"></span><br>
			
			<div class="input-group" style="margin-top: 5px; display: none;">
				<span class="input-group-addon">name</span> 
				<input type="text" class="form-control" placeholder="i.e. Komita" id="det-name-edit">
			</div>
			<div class="input-group" style="margin-top: 5px; display: none;">
				<span class="input-group-addon">description</span> 
				<input type="text" class="form-control" placeholder="i.e. The Ilinden Uprising" id="det-desc-edit">
			</div>
			<div class="input-group" style="margin-top: 5px; margin-bottom: 5px; display: none;">
				<span class="input-group-addon">difficulty</span> 
				<input type="number" class="form-control" placeholder="i.e. Number bigger than 0 (the bigger the more difficult)" id="det-diff-edit">
			</div>
			
      	</div>
      	<br style="clear: both"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="det-edit"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
        <button type="button" class="btn btn-success" style="display: none;"  id="det-save"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
        <button style="display: none" type="button" class="btn btn-danger" id="det-cancel"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
		<button type="button" class="btn btn-danger" id="det-delete"><span class="glyphicon glyphicon-trash"></span> Delete</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo  base_url(); ?>js/app-jss/artifacts.js"></script>