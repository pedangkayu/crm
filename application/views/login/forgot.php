<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo-fav.png">
	<title>
		<?php echo lang('loginsystem')?>
	</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/jquery.gritter/css/jquery.gritter.css"/>
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ciuis.css" type="text/css"/>

</head>
<?php
$arr = $this->session->flashdata();
if ( !empty( $arr[ 'ntf1' ] ) ) {
	$html = '<div class="bg-warning container flash-message">';
	$html .= $arr[ 'ntf1' ];
	$html .= '</div>';
	echo $html;
}
?>
<div class="col-lg-4 col-lg-offset-4">
	<h2><?php echo lang('forgotpassword')?></h2>
	<p><?php echo lang('forgotpasswordsub')?></p>
	<?php $fattr = array('class' => 'form-signin');
         echo form_open(site_url().'login/forgot/', $fattr); ?>
	<div class="form-group">
		<?php echo form_input(array(
          'name'=>'email', 
          'id'=> 'email', 
          'placeholder'=>'Email', 
          'class'=>'form-control', 
          'value'=> set_value('email'))); ?>


	</div>
	
	<?php echo form_error('email') ?>
	<?php echo form_submit(array('value'=>'Submit', 'class'=>'btn btn-lg btn-warning btn-block')); ?>
	<?php echo form_close(); ?>
</div>
<script src="<?php echo base_url(); ?>assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/main.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/app-dashboard.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/lib/jquery.gritter/js/jquery.gritter.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/app-ui-notifications.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/lib/select2/js/select2.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$( document ).ready( function () {
		//initialize the javascript
		App.init();
		App.dashboard();
	} );
</script>
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