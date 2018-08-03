<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/logo-fav.png'); ?>">
	<title><?php echo lang('loginsystem')?></title>
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/ciuis.css'); ?>" type="text/css"/>
</head>
<body class="ciuis-body-splash-screen">
	<div class="ciuis-body-wrapper ciuis-body-login">
		<div class="ciuis-body-content">
			<div class="col-md-4 login-left">
				<div class="lg-content">
					<h2><?php echo lang('logintitle')?></h2>
					<p class="text-muted"><?php echo lang('loginhelptext')?></p>
					<a href="#" class="btn btn-warning p-l-20 p-r-20"><?php echo lang('loginhelpbutton')?></a>
				</div>
			</div>
			<div style="float: right; margin-top: 5%;" class="main-content container-fluid col-md-8">
				<div class="splash-container">
					<div class="panel panel-default">
						<div class="panel-heading"><img src="<?php echo base_url('assets/img/logo-fav.png'); ?>" alt="logo" class="logo-img"> <?php echo lang('logintitle')?><span class="splash-description"><?php echo lang('logindescription')?></span>
						</div>
						<div class="panel-body">
							<?php echo form_open('login/auth') ?>
							<div class="form-group">
								<input id="email" type="email" placeholder="<?php echo lang('loginemail')?>" name="email" autocomplete="off" class="form-control">
							</div>
							<div class="form-group">
								<input id="password" type="password" name="password" placeholder="<?php echo lang('loginpassword')?>" class="form-control">
							</div>
							<div class="form-group row login-tools">
								<div class="col-xs-6 login-remember">
									<div class="ciuis-body-checkbox">
										<input type="checkbox" id="remember">
										<label for="remember"><?php echo lang('loginremember')?></label>
									</div>
								</div>
								<div class="col-xs-6 login-forgot-password"><a href="<?php echo base_url('login/forgot')?>"><?php echo lang('loginforget')?></a>
								</div>
							</div>
							<div class="form-group login-submit">
								<button type="submit" class="btn btn-ciuis btn-xl"><?php echo lang('loginbutton')?></button>
							</div>
							<?php echo '<label class="text-danger">' . $this->session->flashdata( "error" ) . '</label>';?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script src="<?php echo base_url('assets/lib/jquery/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/Ciuis.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/bootstrap/dist/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/jquery.gritter/js/jquery.gritter.js'); ?>" type="text/javascript"></script>
<?php if ( $this->session->flashdata('ntf1')) {?>
	<script type="text/javascript">
		$.gritter.add( {
			title: '<b><?php echo lang('notification')?></b>',
			text: '<?php echo $this->session->flashdata('ntf1'); ?>',
			class_name: 'color success'
		} );
	</script>
	<?php }?>
	<?php if ( $this->session->flashdata('ntf2')) {?>
	<script type="text/javascript">
		$.gritter.add( {
			title: '<b><?php echo lang('notification')?></b>',
			text: '<?php echo $this->session->flashdata('ntf2'); ?>',
			class_name: 'color primary'
		} );
	</script>
	<?php }?>
	<?php if ( $this->session->flashdata('ntf3')) {?>
	<script type="text/javascript">
		$.gritter.add( {
			title: '<b><?php echo lang('notification')?></b>',
			text: '<?php echo $this->session->flashdata('ntf3'); ?>',
			class_name: 'color warning'
		} );
	</script>
	<?php }?>
	<?php if ( $this->session->flashdata('ntf4')) {?>
	<script type="text/javascript">
		$.gritter.add( {
			title: '<b><?php echo lang('notification')?></b>',
			text: '<?php echo $this->session->flashdata('ntf4'); ?>',
			class_name: 'color danger'
		} );
	</script>
	<?php }?>
</body>
</html>
