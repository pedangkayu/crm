<?php include './app/Config.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>CRM | Installation Wizard
		<?= (!empty($title) ? $title : null) ?>
	</title>
	<!-- Favicon -->
	<link rel="icon" href="../assets/img/ciuis-icon.png" type="image/png">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="public/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="public/css/font-awesome.min.css">
	<!-- Custom Style -->
	<link rel="stylesheet" href="public/css/style.css">
<link rel="stylesheet" type="text/css" href="../assets/lib/jquery.gritter/css/jquery.gritter.css"/>
<link rel="stylesheet" type="text/css" href="../assets/lib/select2/css/select2.min.css"/>
<link rel="stylesheet" type="text/css" href="../assets/css/ciuis.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../assets/css/animate.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet" >
<link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-slider/css/bootstrap-slider.css"/>
<style>
	body{
		    background: white;
	}	
</style>
</head>
<body>
	<!-- BACK TO TOP  -->
	<a name="top"></a>
	<!-- BEGIN CONTAINER -->
	<div class="container">
		<!-- BEGIN ROW -->
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
				<!-- MAIN WRAPPER -->
				<div class="main_wrapper">
					<!-- BEGIN HEADER -->

					<!-- ENDS HEADER -->
					<div class="row panel borderten md-p-30">
						<!-- BEGIN LEFT SIDEBAR -->
						<div class="col-sm-3" style="padding: 0">
						  <div class="list-group">
                    <a href="#" class="list-group-item <?= (($title == 'Requirements') ? " active " : null) ?>"><span class="text-warning mdi mdi-fire icon"></span> Requirements</a>
                    <a href="#" class="list-group-item <?= (($title == 'Installation') ? " active " : null) ?>"><span class="text-warning mdi mdi-puzzle-piece icon"></span> Installation</a>
                    <a href="#" class="list-group-item <?= (($title == 'Complete') ? " active " : null) ?>"><span class="text-warning mdi mdi-settings icon"></span>Complete</a>
							
							
							</div>
							
							
							
                  
               
							
							
						</div>
						
						<!-- ENDS LEFT SIDEBAR -->
						<!-- BEGIN CONTENT -->
						<div class="col-sm-9">
							<div class="content">
								<?php include($content) ?>
							</div>
						</div>
						<!-- ENDS CONTENT -->
					</div>
				</div>
				<!-- END MAIN WRAPPER -->
			</div>
		</div>
		<!-- ENDS ROW -->
	</div>
	<!-- ENDS OF CONTAINER -->
	<!-- ALL SCRIPTS/JS -->
	<script src="public/js/jquery.min.js"></script>
	<script src="public/js/script.js"></script>
</body>

</html>