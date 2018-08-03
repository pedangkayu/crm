<?php 
$ReqCheck = $Requirement->check([ 
    '../application/config/database.php',
    '../application/config/config.php',
    './app/templates/codeigniter_2x_&_3x.php',
]);
?>
<div class="content">
    <div class="row">
	    <div class="col-sm-12">
		    <!-- BEGIN DIRECTORY & FILE PERMISSION -->
			<table>
				<thead>
					<tr><td>Directory/File Permission</td><td width="100">Writable</td></tr>
				</thead>
				<tbody>
					<?php foreach ($ReqCheck['permissions'] as $key => $value) { ?>
					<tr><td><?php echo $key; ?></td><td><?php echo $value ?></td></tr>
					<?php } ?> 
				</tbody> 
			</table>
			<!-- ENDS DIRECTORY & FILE PERMISSION -->

			<!-- BEGIN CHECK EXTENSION -->
			<table>
				<thead>
					<tr><td>Load Extensions</td><td width="100">Status</td></tr>
				</thead>
				<tbody>
					<?php foreach ($ReqCheck['extensions'] as $key => $value) { ?>
					<tr><td><?php echo $key; ?></td><td><?php echo $value ?></td></tr>
					<?php } ?> 
				</tbody> 
			</table>
			<!-- ENDS EXTENSION -->

			<!-- BEGIN REQUIRE VERSION  -->
			<table>
				<thead>
					<tr><td>Load Version</td><td>Status</td></tr>
				</thead>
				<tbody>
					<?php foreach ($ReqCheck['versions'] as $key => $value) { ?>
					<tr><td><?php echo $key; ?></td><td><?php echo $value ?></td></tr>
					<?php } ?> 
				</tbody> 
			</table>
			<!-- ENDS REQUIRE VERSION -->
			 
			<div class="divider"></div>
			<a href="?step=installation" class="btn btn-default pull-right">Next <i class="fa fa-forward"></i></a>
		</div>
	</div>
</div>
