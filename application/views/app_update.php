<?php 
	$uploadsExists = true;
	if(empty($updatedata)) {
		$uploadsExists = false;
	}
?>
<table class="table">
	<thead>
		<tr>
			<th>Current Version</th>
			<th>Status</th>
			<th>Created on</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?php 
					if(!$uploadsExists) {
						echo 'no previous versions';
					} else {
						echo $updatedata['version'];
					}
				?>
			</td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" id="status" data-toggle="dropdown">
				  <?php 
				  	if(!$uploadsExists) {
						echo 'Select status';
					} else {
						echo $updatedata['status'];;
						} 
					?>
				  <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a data-status="0" href="#"><?php echo(Welcome::STATUS_OK); ?></a></li>
						<li><a data-status="1" href="#"><?php echo(Welcome::STATUS_MUST_UPDATE_APK); ?></a></li>
					</ul>
				</div>
			</td>
			<td>
				 <?php 
				  	if(!$uploadsExists) {
						echo 'no previous versions';
					} else {
						echo $updatedata['date'];;
						} 
					?>
			</td>
			<td>
				<button class="btn btn-primary" id="create-zip">
					<span class="glyphicon glyphicon-compressed"></span>Update version
					(create zip)
				</button>
			</td>
		</tr>
	</tbody>
</table>
<button class="btn btn-success" id="download">
	<span class="glyphicon glyphicon-cloud-download"></span> Download
	latest update
</button>

<script src="<?php echo base_url()?>js/app-jss/app-update.js"></script>