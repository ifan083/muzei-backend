<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-cog"></span> Manage criterias</button>
<br/>
<br/>
<div class="panel panel-default">
  <div class="panel-heading"><i>general</i> achievements</div>
  <!-- Table -->
  <table class="table">
  	<thead>
          <tr>
          	<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>name</th>
            <th>criteria</th>
            <th>description</th>
            <th>difficulty</th>
            <th>continuous</th>
    	</tr>
  	</thead>
  	<tbody>
  	<?php 
  		foreach ($achievements as $achievement) { 
			if($achievement['category'] == null || $achievement['category'] == 0) { ?>
  			<tr>
  				<td>
  					<button type="button" class="btn btn-info" value="edit-ach" data-id="<?php echo $achievement['id']?>"><span class="glyphicon glyphicon-pencil"></span></button>
	      			<button type="button" class="btn btn-danger" value="delete-ach" data-id="<?php echo $achievement['id']?>"><span class="glyphicon glyphicon-trash"></span></button>
	      					
	      			<button type="button" class="btn btn-success" value="update-ach" data-id="<?php echo $achievement['id']?>" style="display: none"><span class="glyphicon glyphicon-floppy-disk"></span></button>
			        <button type="button" class="btn btn-danger" value="cancel-ach" data-id="<?php echo $achievement['id']?>" style="display: none"><span class="glyphicon glyphicon-remove"></span></button>
  				</td>
  				<td>
  					<span id="ach-name<?php echo $achievement['id']; ?>"><?php echo $achievement['name']; ?></span>
  					<input style="display: none" type="text" class="form-control" id="edit-ach-name<?php echo $achievement['id']; ?>" value="<?php echo $achievement['name']; ?>" />
  				</td>
  				<td>
  					<span id="ach-crit<?php echo $achievement['id']; ?>"><?php echo $achievement['criteria']; ?></span>
  					<?php 
  						$crit = "";
  						foreach ($criterias as $c) {
  							if($c['id'] == $achievement['criteria']) {
  								$crit = $c['name'];
  								break;
  							}
  						}
  						
  						$crit = substr($crit, 0, 20) . "...";
  					?>
  					<div class="btn-group" style="display: none" id="edit-ach-crit<?php echo $achievement['id']; ?>">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id=""><?php echo $crit; ?> <span class="caret"></span></button>
					  <ul class="dropdown-menu" role="menu">
					  	<?php 
					  		foreach ($criterias as $criteria) {
					  			echo '<li><a href="#" data-critid="'.$criteria['id'].'" >'.$criteria['name'].'</a></li>';
					  		}
					  	?>
					  </ul>
					</div>
  				</td>
  				<td>
  					<span id="ach-desc<?php echo $achievement['id']; ?>"><?php echo $achievement['description']; ?></span>
  					<input type="text" style="display: none" class="form-control" id="edit-ach-desc<?php echo $achievement['id']; ?>" value="<?php echo $achievement['description']; ?>" />
  				</td>
  				<td>
  					<span id="ach-diff<?php echo $achievement['id']; ?>"><?php echo $achievement['difficulty']; ?></span>
  					<input type="number" style="display: none" class="form-control" id="edit-ach-diff<?php echo $achievement['id']; ?>" value="<?php echo $achievement['difficulty']; ?>" />
  				</td>
  				<td>
  					<span id="ach-cont<?php echo $achievement['id']; ?>"><?php echo (int)$achievement['continuous'] ? 'true' : 'false'; ?></span>
  					<input type="checkbox" style="display: none" id="edit-ach-cont<?php echo $achievement['id']; ?>"  <?php echo  (int)$achievement['continuous'] ? 'checked' : ''; ?> />
  				</td>
  			</tr>
			<?php }
		}
  	?>
  	<tr>
  		<td>
  			<button type="button" class="btn btn-primary" value="add" data-id="0"><span class="glyphicon glyphicon-plus"></span></button>
  			<button type="button" class="btn btn-success" value="save" style="display: none" data-id="0"><span class="glyphicon glyphicon-floppy-disk"></span></button>
  			<button type="button" class="btn btn-danger" value="cancel" style="display: none" data-id="0"><span class="glyphicon glyphicon-remove"></span></button>
  		</td>
  	</tr>
  	<tr style="display: none;" id="new-row0">
  		<td><input type="text" class="form-control" id="name0"></td>
  		<td>
  			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="criteria0">Criteria <span class="caret"></span></button>
			  <ul class="dropdown-menu" role="menu">
			  	<?php 
			  		foreach ($criterias as $criteria) {
			  			echo '<li><a href="#" data-critid="'.$criteria['id'].'" >'.$criteria['name'].'</a></li>';
			  		}
			  	?>
			  </ul>
			</div>
		</td>
		<td><input type="text" class="form-control" id="description0"></td>
		<td><input type="number" class="form-control" id="difficulty0"></td>
		<td><input type="checkbox" id="continuous0"></td>
  	</tr>
  	</tbody>
  </table>
</div>

<?php foreach ($categories as $category) { 
	if($category['mapper']) {
		continue;
	}
	?>
<div class="panel panel-default">
  <div class="panel-heading"><i><?php echo $category['category']?></i> achievements</div>
  <!-- Table -->
  <table class="table">
  	<thead>
          <tr>
          	<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>name</th>
            <th>criteria</th>
            <th>description</th>
            <th>difficulty</th>
            <th>continuous</th>
    	</tr>
  	</thead>
  	<tbody>
  		<?php foreach($achievements as $achievement) {
  			if($achievement['category'] == $category['id']) { ?>
  			<tr>
  				<td>
  					<button type="button" class="btn btn-info" value="edit-ach" data-id="<?php echo $achievement['id']?>"><span class="glyphicon glyphicon-pencil"></span></button>
	      			<button type="button" class="btn btn-danger" value="delete-ach" data-id="<?php echo $achievement['id']?>"><span class="glyphicon glyphicon-trash"></span></button>
	      			<button type="button" class="btn btn-success" value="update-ach" data-id="<?php echo $achievement['id']?>" style="display: none"><span class="glyphicon glyphicon-floppy-disk"></span></button>
			        <button type="button" class="btn btn-danger" value="cancel-ach" data-id="<?php echo $achievement['id']?>" style="display: none"><span class="glyphicon glyphicon-remove"></span></button>
  				</td>
  				<td>
  					<span id="ach-name<?php echo $achievement['id']; ?>"><?php echo $achievement['name']; ?></span>
  					<input type="text" style="display: none" class="form-control" id="edit-ach-name<?php echo $achievement['id']; ?>" value="<?php echo $achievement['name']; ?>" />
  				</td>
  				<td>
  					<span id="ach-crit<?php echo $achievement['id']; ?>"><?php echo $achievement['criteria']; ?></span>
  					<?php 
  						$crit = "";
  						foreach ($criterias as $c) {
  							if($c['id'] == $achievement['criteria']) {
  								$crit = $c['name'];
  								break;
  							}
  						}
  						
  						$crit = substr($crit, 0, 20) . "...";
  					?>
  					<div class="btn-group" style="display: none"  id="edit-ach-crit<?php echo $achievement['id']; ?>">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id=""><?php echo $crit; ?> <span class="caret"></span></button>
					  <ul class="dropdown-menu" role="menu">
					  	<?php 
					  		foreach ($criterias as $criteria) {
					  			echo '<li><a href="#" data-critid="'.$criteria['id'].'" >'.$criteria['name'].'</a></li>';
					  		}
					  	?>
					  </ul>
					</div>
  				</td>
  				<td>
  					<span id="ach-desc<?php echo $achievement['id']; ?>"><?php echo $achievement['description']; ?></span>
  					<input type="text" style="display: none" class="form-control" id="edit-ach-desc<?php echo $achievement['id']; ?>" value="<?php echo $achievement['description']; ?>" />
  				</td>
  				<td>
  					<span id="ach-diff<?php echo $achievement['id']; ?>"><?php echo $achievement['difficulty']; ?></span>
  					<input type="number" style="display: none" class="form-control" id="edit-ach-diff<?php echo $achievement['id']; ?>" value="<?php echo $achievement['difficulty']; ?>" />
  				</td>
  				<td>
  					<span id="ach-cont<?php echo $achievement['id']; ?>"><?php echo (int)$achievement['continuous'] ? 'true' : 'false'; ?></span>
  					<input type="checkbox" style="display: none" id="edit-ach-cont<?php echo $achievement['id']; ?>"  <?php echo  (int)$achievement['continuous'] ? 'checked' : ''; ?> />
  				</td>
  			</tr>
  		<?php }} ?>
  		<tr>
  			<td>
  				<button type="button" class="btn btn-primary" value="add" data-id="<?php echo $category['id']?>"><span class="glyphicon glyphicon-plus"></span></button>
  				<button type="button" class="btn btn-success" value="save" style="display: none" data-id="<?php echo $category['id']?>"><span class="glyphicon glyphicon-floppy-disk"></span></button>
  				<button type="button" class="btn btn-danger" value="cancel" style="display: none" data-id="<?php echo $category['id']?>"><span class="glyphicon glyphicon-remove"></span></button>
  			</td>
  		</tr>
		<tr style="display: none;" id="new-row<?php echo $category['id']; ?>">
  		<td><input type="text" class="form-control" id="name<?php echo $category['id']; ?>"></td>
  		<td>
  			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" id="criteria<?php echo $category['id']; ?>" data-toggle="dropdown">Criteria <span class="caret"></span></button>
			  <ul class="dropdown-menu" role="menu">
			  	<?php 
			  		foreach ($criterias as $criteria) {
			  			echo '<li><a href="#" data-critid="'.$criteria['id'].'" >'.$criteria['name'].'</a></li>';
			  		}
			  	?>
			  </ul>
			</div>
		</td>
		<td><input type="text" class="form-control" id="description<?php echo $category['id']; ?>"></td>
		<td><input type="number" class="form-control" id="difficulty<?php echo $category['id']; ?>"></td>
		<td><input type="checkbox" id="continuous<?php echo $category['id']; ?>"></td>
  	</tr>  		
	</tbody>
  </table>
</div>
<?php } ?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Criterias</h4>
      </div>
      <div class="modal-body">
      	<table class="table" id="criteria-table">
      		<thead>
      			<tr>
      				<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;name</th>
      			</tr>
      		</thead>
      		<tbody>
      			<?php foreach ($criterias as $criteria) { ?>
      				<tr>
      					<td>
	      					<button type="button" class="btn btn-info" value="edit-crit" data-id="<?php echo $criteria['id']?>"><span class="glyphicon glyphicon-pencil"></span></button>
	      					<button type="button" class="btn btn-danger" value="delete-crit" data-id="<?php echo $criteria['id']?>"><span class="glyphicon glyphicon-trash"></span></button>
	      					
	      					<button type="button" class="btn btn-success" value="update-crit" data-id="<?php echo $criteria['id']?>" style="display: none"><span class="glyphicon glyphicon-floppy-disk"></span></button>
			        		<button type="button" class="btn btn-danger" value="cancel-crit" data-id="<?php echo $criteria['id']?>" style="display: none"><span class="glyphicon glyphicon-remove"></span></button>
	      					
	      					<span data-value="<?php echo $criteria['id']?>">&nbsp;&nbsp;&nbsp;<?php echo $criteria['name']; ?></span>
	      					<input style="display: none;" type="text" class="form-control inline" id="input-edit<?php echo $criteria['id']?>" value="<?php echo $criteria['name']; ?>">
      					</td>
      				</tr>
      			<?php }?>
      			<tr>
      				<td>
			        	<button type="button" class="btn btn-primary" value="add-criteria"><span class="glyphicon glyphicon-plus"></span></button>
			        	<button type="button" class="btn btn-success" value="save-criteria" style="display: none"><span class="glyphicon glyphicon-floppy-disk"></span></button>
			        	<button type="button" class="btn btn-danger" value="cancel-criteria" style="display: none"><span class="glyphicon glyphicon-remove"></span></button>
			        </td>
      			</tr>
      			<tr id="add-crit-form" style="display: none;">
      				<td>
	      				<input type="text" class="form-control" id="crit-name" >
      				</td>
      			</tr>
      		</tbody>
      	</table>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url()?>js/app-jss/achievements.js"></script>