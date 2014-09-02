<table class="table">
 <thead>
  <tr>
   <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
   <th>image</th>
   <th>character name</th>
   <th>category</th>
   <th>mapper</th>
  </tr>
 </thead>
 <tbody>
 	<?php foreach ($data as $d) { ?>
 		<tr>
 			<td>
 				<button class="btn btn-info" id="edit-row" data-id="<?php echo $d['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></button>
 				<button class="btn btn-danger" id="delete-row" data-id="<?php echo $d['id']; ?>"><span class="glyphicon glyphicon-trash"></span></button>
 				<button class="btn btn-success" style="display: none" id="save-row" data-id="<?php echo $d['id']; ?>"><span class="glyphicon glyphicon-floppy-disk"></span></button>
 				<button class="btn btn-danger" style="display: none" id="cancel-row" data-id="<?php echo $d['id']; ?>"><span class="glyphicon glyphicon-remove"></span></button>
 			</td>
 			<td class="col-xs-4 col-md-2">
 				<div id="row-pic" data-id="<?php echo $d['id']; ?>"> 
				    <a href="#" class="thumbnail">
				      <img src="<?php echo $d['picture_filename']; ?>" alt="...">
				    </a>
				    <div style="clear: both"></div>
				</div>
 			</td>
 			<td>
 				<span id="row-name" data-id="<?php echo $d['id']; ?>"><?php echo $d['name']; ?></span>
 				<input type="text" class="form-control" data-id="<?php echo $d['id']?>" id="edit-name" value="<?php echo $d['name']; ?>" style="display: none">
 			</td>
 			<td>
 				<span id="row-category" data-id="<?php echo $d['id']; ?>"><?php echo $d['category']; ?></span>
 				<input type="text" class="form-control" data-id="<?php echo $d['id']?>" id="edit-category" value="<?php echo $d['category']; ?>" style="display: none">
 				
 			</td>
 			<td>
 				<span id="row-mapper" data-id="<?php echo $d['id']; ?>"><?php echo (int)$d['mapper'] ? 'true' : 'false'; ?></span>
 				<input type="checkbox" data-id="<?php echo $d['id']?>" id="edit-mapper" <?php echo (int)$d['mapper'] ? 'checked' : '';?> style="display: none">
 			</td>
 		</tr>
 	<?php }?>
 </tbody>
</table>

<button type="button" id="add_char" class="btn btn-primary">
<span class="glyphicon glyphicon-plus"></span> Add new character
</button>

<form id='upload_form' enctype="multipart/form-data" method="post" action="<?php echo base_url('welcome/save_character'); ?>">
	<button type="submit" id="save_char" class="btn btn-success" style="display: none"><span class="glyphicon glyphicon-floppy-disk"></span></button>
	<button type="button" id="cancel_char" class="btn btn-danger" style="display: none"><span class="glyphicon glyphicon-remove"></span></button>
	<div id="input_character" style="display: none">
		<input style="float: left; width: 40%;" type="file" name="file" id="img_file" value="Upload picture" />
		<div style="float: left; width: 55%;">
			<div class="input-group">
				<span class="input-group-addon">Character</span> 
				<input type="text" class="form-control" placeholder="i.e. Komita" name="char_name" id="char_name">
			</div>
			<div class="input-group" style="margin-top: 5px;">
				<span class="input-group-addon">Category</span> 
				<input type="text" class="form-control" placeholder="i.e. The Ilinden Uprising" name="char_category" id="char_category">
			</div>
			<input type="checkbox" id="mapper" name="mapper" ><label> is mapper? </label>
		</div>
		<br style="clear: both;" />
	</div>
</form>

<br id="form_footer" />
<br />

<script src="<?php echo  base_url(); ?>js/app-jss/characters.js"></script>