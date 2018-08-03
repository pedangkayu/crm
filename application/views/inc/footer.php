</md-content>
<script src="<?php echo base_url('assets/lib/jquery/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/hoverIntent/hoverIntent.js')?>"></script>
<script src="<?php echo base_url('assets/js/Ciuis.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/moment.js/min/moment.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/bootstrap/dist/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/jquery.gritter/js/jquery.gritter.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/angular-datepicker/src/js/angular-datepicker.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/select2/js/select2.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/select2/js/select2.full.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/chartjs/dist/Chart.bundle.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('assets/lib/material/angular-material.min.js')?>"></script>
<script src="<?php echo base_url('assets/lib/currency-format/currency-format.min.js')?>"></script>
<script src="<?php echo base_url('assets/lib/angular-datetimepicker/angular-material-datetimepicker.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/CiuisAngular.js'); ?>"></script>
<script type="text/javascript">
	<?php $newreminder = $this->Report_Model->newreminder();?>
	<?php $openticket = $this->Report_Model->otc();?>
	<?php $settings = $this->Settings_Model->get_settings_ciuis(); ?>
	
	function speak(CiuisVoiceNotification) {
	  var s = new SpeechSynthesisUtterance();
		s.volume = 0.5;
		s.rate = 1;
		s.pitch = 1; 
		s.lang = VOICENOTIFICATIONLANG;
		s.text = CiuisVoiceNotification;
		  window.speechSynthesis.speak(s);
	}
	var voice = document.querySelectorAll('body');
	var reminder = '<?php echo $message = sprintf( lang( 'reminder_voice' ), $newreminder)  ?>';
	var oepnticket = '<?php echo $message = sprintf( lang( 'open_ticket_voice' ), $openticket)  ?>';
	<?php if ( $this->session->flashdata('ntf1')) {?>
	$.gritter.add( {
		title: '<b><?php echo lang('notification')?></b>',
		text: '<?php echo $this->session->flashdata('ntf1'); ?>',
		class_name: 'color success'
	} );
	<?php }?>
	<?php if ( $this->session->flashdata('ntf2')) {?>
	$.gritter.add( {
		title: '<b><?php echo lang('notification')?></b>',
		text: '<?php echo $this->session->flashdata('ntf2'); ?>',
		class_name: 'color primary'
	} );
	<?php }?>
	<?php if ( $this->session->flashdata('ntf3')) {?>
	$.gritter.add( {
		title: '<b><?php echo lang('notification')?></b>',
		text: '<?php echo $this->session->flashdata('ntf3'); ?>',
		class_name: 'color warning'
	} );
	<?php }?>
	<?php if ( $this->session->flashdata('ntf4')) {?>
	$.gritter.add( {
		title: '<b><?php echo lang('notification')?></b>',
		text: '<?php echo $this->session->flashdata('ntf4'); ?>',
		class_name: 'color danger'
	} );
	<?php }?>
	<?php  if ($this->session->flashdata('login_notification')) {if ($this->session->userdata('admin')) {?>
	$.gritter.add({
		title: 'Vuuv! <?php echo $this->session->userdata('staffname'); ?>',
		text: '<?php echo $this->session->userdata('admin_notification'); ?>',
		image: App.conf.assetsPath + '/' +  App.conf.imgPath + '/root_avatar.gif',
		class_name: 'img-rounded',
		time: '',
	});
	<?php } ?>
	$.gritter.add({
		title: '<?php echo lang('crmwelcome');?>',
		text: "<?php echo lang('welcomemessage');?>",
		image: '<?php echo base_url(); ?>uploads/images/<?php echo $this->session->userdata('staffavatar'); ?>',
		time: '',
		class_name: 'img-rounded'
	});
	var staffname = "<?php echo $message = sprintf( lang( 'welcome_once_message' ), $this->session->userdata('staffname'))?> ";
	<?php if($settings['voicenotification'] == 1){echo 'speak(staffname);';}?>
	<?php if($newreminder > 0 && $settings['voicenotification'] == 1){echo 'speak(reminder);';}?>
	<?php if($openticket > 0 && $settings['voicenotification'] == 1){echo 'speak(oepnticket);';}?>
	<?php } ?>
	
</script>
</body>
</html>
