<?php $this->view('header'); ?>
<div class="container">
	<div id="main-container" class="mini-layout fluid">
		<div id="sidebar">
			<?php $this->view('navigation');?>
		</div>
		<div id="panel-body">
			<div class="well">
				<div class="jumbotron">
					<h1>
						Welcome to the <i>Muzei</i> backend!
					</h1>
				</div>
			</div>
		</div>
		<br style="clear: both;" />
	</div>
</div>
<?php $this->view('footer'); ?>
