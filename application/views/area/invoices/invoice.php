<!DOCTYPE html>
<html lang="<?php echo lang('lang_code'); ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo-fav.png">
	<title><?php echo $title; ?></title>
	<script src="<?php echo base_url('assets/lib/angular/angular.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/angular-animate.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/angular-aria.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/i18n/angular-locale_en-us.js'); ?>"></script>
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ciuis.css" type="text/css"/>
</head>
<body ng-controller>
	<md-toolbar class="toolbar-white">
	  <div class="md-toolbar-tools">
		<md-button class="md-icon-button" aria-label="Settings" ng-disabled="true">
		  <md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
		</md-button>
		<h2 flex md-truncate><?php echo lang( 'invoiceprefix' ),'-',str_pad( $invoice[ 'id' ], 6, '0', STR_PAD_LEFT );?></h2>
		<div class="btn-group btn-space pull-right  md-mr-20 <?php if($settings['paypalenable'] != 1){echo 'hide';} ?>" style="right: 0px; position: absolute;"> 
		<a href="<?php echo base_url('share/pdf/'.$invoice['token'].'') ?>" class="btn btn-default"><?php echo lang('download') ?></a>
		<a href="<?php echo base_url('share/pdf/'.$invoice['token'].'') ?>" class="btn btn-default"><?php echo lang('print') ?></a>
		<button type="button" class="btn btn-color btn-social btn-dropbox"><i class="icon mdi mdi-paypal-alt"></i></button> 
		<a href="<?php echo site_url('pay/invoice/'.$invoice['id']); ?>" type="button" class="btn btn-default"><?php echo lang('paynow'); ?></a>
		</div>
	  </div>
	</md-toolbar>
	<md-content class="bg-white invoice" style="height: 100%;">
		<div class="invoice-header col-md-12">
			<div class="invoice-from col-md-4 col-xs-12">
				<small><?php echo  lang('from'); ?></small>
				<address class="m-t-5 m-b-5">
					<strong><?php echo $settings['company'] ?></strong><br>
					<?php echo $settings['address'] ?><br>
					<?php echo lang('phone')?>:</b> <?php echo $settings['phone'] ?><br>
				</address>
			</div>
			<div class="invoice-to col-md-4 col-xs-12">
				<small><?php echo  lang('to'); ?></small>
				<address class="m-t-5 m-b-5">
					<strong><?php if($invoice['customercompany']===NULL){echo $invoice['namesurname'];} else echo $invoice['customercompany']; ?></strong><br>
					<?php echo $invoice['customeraddress']; ?><br>
					<?php echo lang('phone') ?>: <?php echo $invoice['phone'] ?><br>
				</address>
			</div>
			<div class="invoice-date col-md-4 col-xs-12">
				<div class="date m-t-5"><?php echo _adate($invoice['created']) ?></div>
				<div class="invoice-detail">
					<?php echo $invoice['serie'] ?>#<?php echo $invoice['no'] ?><br>
				</div>
			</div>
		</div>
		<div class="invoice-content col-md-12 md-p-0 xs-p-0 sm-p-0 lg-p-0">
			<div class="table-responsive">
				<table class="table table-invoice">
					<thead>
						<tr>
							<th><?php echo lang('product') ?></th>
							<th><?php echo lang('quantity') ?></th>
							<th><?php echo lang('price') ?></th>
							<th><?php echo lang('tax') ?></th>
							<th><?php echo lang('discount') ?></th>
							<th><?php echo lang('total') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($items as $item){?>
						<tr ng-repeat="item in invoice.items">
							<td><span><?php echo $item['name'] ?></span><br><small><?php echo $item['description'] ?></small></td>
							<td><?php echo $item['quantity'] ?></td>
							<td><?php echo number_format($item['price'], 2, ',', '.'),' ',currency ?></td>
							<td><?php echo $item['tax'] ?>%</td>
							<td><?php echo $item['discount'] ?>%</td>
							<td><?php echo number_format($item['total'], 2, ',', '.'),' ',currency ?></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>
			<div class="invoice-price" style="bottom: 0px; position: fixed;">
				<div class="invoice-price-left">
					<div class="invoice-price-row">
						<div class="sub-price">
							<small><?php echo lang('subtotal') ?></small>
							<span><?php echo number_format($invoice['sub_total'], 2, ',', '.'),' ',currency ?></span>
						</div>
						<div class="sub-price">
							<i class="ion-plus-round"></i>
						</div>
						<div class="sub-price">
							<small><?php echo lang('tax') ?></small>
							<span><?php echo number_format($invoice['total_tax'], 2, ',', '.'),' ',currency ?></span>
						</div>
						<div class="sub-price">
							<i class="ion-minus-round"></i>
						</div>
						<div class="sub-price">
							<small><?php echo lang('discount') ?></small>
							<span><?php echo number_format($invoice['total_discount'], 2, ',', '.'),' ',currency ?></span>
						</div>
					</div>
				</div>
				<div class="invoice-price-right">
					<small><?php echo lang('total') ?></small>
					<span><?php echo number_format($invoice['total'], 2, ',', '.'),' ',currency ?></span>
				</div>
			</div>
		</div>
	</md-content>
</body>
</html>