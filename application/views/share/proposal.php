<!DOCTYPE html>
<html ng-app="Ciuis" lang="<?php echo lang('lang_code'); ?>">
<head>
	<script src="<?php echo base_url('assets/lib/angular/angular.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-resource.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-route.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-loader.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-sanitize.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/lib/angular/angular-cookies.min.js'); ?>"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo-fav.png">
	<title><?php echo $proposals['subject'] ?></title>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ciuis.css'); ?>" type="text/css"/>
    <style>
		body {
		padding: 0;
		background-color: rgb(255, 255, 255);
		height: 100%;
		font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-weight: 300;
		-webkit-font-smoothing: antialiased;
	}
		.p-s-v{
			padding: 10px;
			width: 100px;
			margin-top: 20px;
		}
	</style>
</head>
<?php $settings = $this->Settings_Model->get_settings_ciuis(); ?>
<body ng-controller="Ciuis_Controller">
	<?php include_once(APPPATH . 'views/inc/widgets/proposal_view_sidebar.php'); ?>
	
	<div class="main-content container-fluid col-md-9 borderten">
		<div class="col-md-12 md-pr-0">
			<div class="proposal panel borderten" style="padding-top: 20px;padding-right: 0px;">
				<main>
					<div id="details" class="clearfix">
						<div id="client">
							<h1><b><?php echo $proposals['subject'] ?></b></h1>
							<div class="date"><?php echo lang('dateofissuance')?>:<?php switch($settings['dateformat']){case 'yy.mm.dd': echo _rdate($proposals['date']);break;case 'dd.mm.yy': echo _udate($proposals['date']); break;case 'yy-mm-dd': echo _mdate($proposals['date']); break;
						case 'dd-mm-yy': echo _cdate($proposals['date']); break;case 'yy/mm/dd': echo _zdate($proposals['date']); break;case 'dd/mm/yy': echo _kdate($proposals['date']); break;}?></div>
							<div class="date text-bold"><?php echo lang('opentill')?>:<?php switch($settings['dateformat']){case 'yy.mm.dd': echo _rdate($proposals['opentill']);break;case 'dd.mm.yy': echo _udate($proposals['opentill']); break;case 'yy-mm-dd': echo _mdate($proposals['opentill']); break;case 'dd-mm-yy': echo _cdate($proposals['opentill']); break;	case 'yy/mm/dd': echo _zdate($proposals['opentill']); break;case 'dd/mm/yy': echo _kdate($proposals['opentill']); break;}?></div>
						</div>
						<div class="pull-right"><?php if($proposals['status_id'] == 1){echo '<span class="label label-default p-s-lab p-s-v pull-left">'.lang('draft').'</span>';}  ?><?php if($proposals['status_id'] == 2){echo '<span class="label label-default p-s-lab p-s-v pull-left">'.lang('sent').'</span>';}  ?><?php if($proposals['status_id'] == 3){echo '<span class="label label-default p-s-lab p-s-v pull-left">'.lang('open').'</span>';}  ?><?php if($proposals['status_id'] == 4){echo '<span class="label label-default p-s-lab p-s-v pull-left">'.lang('revised').'</span>';}  ?><?php if($proposals['status_id'] == 5){echo '<span class="label label-default p-s-lab p-s-v pull-left">'.lang('declined').'</span>';}  ?><?php if($proposals['status_id'] == 6){echo '<span class="label label-default p-s-lab p-s-v pull-left">'.lang('accepted').'</span>';}  ?></div>
					</div>
					<div class="col-md-12"><?php echo $proposals['content'] ?></div>
					<hr>
					<table border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th class="desc"><?php echo lang('description') ?></th>
								<th class="qty"><?php echo lang('quantity') ?></th>
								<th class="unit"><?php echo lang('price') ?></th>
								<th class="discount"><?php echo lang('discount') ?></th>
								<th class="tax"><?php echo lang('vat') ?></th>
								<th class="total"><?php echo lang('total') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($items as $item) {?>
							<tr>
								<td class="desc"><h3><?php echo $item['name']?><br></h3><?php echo $item['description'];?></td>
								<td class="qty"><?php echo $item['quantity'];?></td>
								<td class="unit"><span class="money-area"><?php echo $item['price']?></span></td>
								<td class="discount"><?php echo $item['discount'];?>%</td>
								<td class="tax"><?php echo $item['tax'] ?>%</td>
								<td class="total"><span class="money-area"><?php echo $item['total']?></span></td>
							</tr>
							<?php }?>

						</tbody>
						<tfoot>
							<tr>
								<td></td>
								<td colspan="2"></td>
								<td colspan="2"><?php echo lang('subtotal')?></td>
								<td><span class="money-area"><?php echo $proposals['sub_total']?></span></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"></td>
								<td class="text-uppercase" colspan="2"><?php echo lang('discount') ?></td>
								<td><span class="money-area"><?php echo $proposals['total_discount']?></span></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"></td>
								<td colspan="2"><?php echo lang('tax') ?></td>
								<td><span class="money-area"><?php echo $proposals['total_tax']?></span></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"></td>
								<td colspan="2"><?php echo lang('grandtotal') ?></td>
								<td><span class="money-area"><?php echo $proposals['total']?></span></td>
							</tr>
						</tfoot>
					</table>
				</main>
			</div>
		</div>
	</div>
	<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<script>
$( ".accept-proposal" ).click( function () {
	var base_url = "<?php echo base_url();?>"
	var proposal = $( this ).data( 'proposal' );
	var statusna = "<?php echo lang('accepted') ?>";
	$.ajax( {
		type: "POST",
		url: base_url + "share/markasproposal",
		data: {
			status_id: 6,
			proposal_id: proposal,
		},
		dataType: "text",
		cache: false,
		success: function ( data ) {
			$.gritter.add( {
				title: '<b><?php echo lang('notification')?></b>',
				text: '<b><?php echo lang('markedas')?> '+statusna+'</b>',
				class_name: 'color success'
			} );
			$( ".p-s-lab" ).text(statusna);
		}
	} );
	return false;
});
$( ".decline-proposal" ).click( function () {
var base_url = "<?php echo base_url();?>"
var proposal = $( this ).data( 'proposal' );
var statusna = "<?php echo lang('declined') ?>";
$.ajax( {
	type: "POST",
	url: base_url + "share/markasproposal",
	data: {
		status_id: 5,
		proposal_id: proposal,
	},
	dataType: "text",
	cache: false,
	success: function ( data ) {
		$.gritter.add( {
			title: '<b><?php echo lang('notification')?></b>',
			text: '<b><?php echo lang('markedas')?> '+statusna+'</b>',
			class_name: 'color danger'
		} );
		$( ".p-s-lab" ).text(statusna);
	}
} );
return false;
});
</script>