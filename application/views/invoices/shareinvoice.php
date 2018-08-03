<!DOCTYPE html>
<html lang="<?php echo lang('lang_code'); ?>">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo-fav.png">
	<title>
		<?php echo $title; ?>
	</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ciuis.css" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
</head>

<body>
	<div class="col-md-12">
	<div class="btn-group btn-space pull-right md-mt-20 md-mr-20 <?php if($settings['paypalenable'] != 1){echo 'hide';} ?>"> <button type="button" class="btn btn-color btn-social btn-dropbox"><i class="icon mdi mdi-paypal-alt"></i></button> <a href="<?php echo site_url('pay/invoice/'.$invoices['id']); ?>" type="button" class="btn btn-default"><?php echo lang('paynow'); ?></a></div>
		<div class="invoice">
			<div class="row invoice-header">
				<div class="col-xs-7">
					<div class="invoice-logo" style="background-image: url(<?php echo base_url('uploads/ciuis_settings/'.$settings['logo'].'') ?>)"></div>
				</div>
				<div class="col-xs-5 invoice-order"><span class="invoice-id"><?php echo lang('invoiceprefix'),'-',str_pad($invoices['id'], 6, '0', STR_PAD_LEFT); ?></span>
					<span class="incoice-date">
						<?php switch($settings['dateformat']){ 
							case 'yy.mm.dd': echo _rdate($invoices['created']);break; 
							case 'dd.mm.yy': echo _udate($invoices['created']); break;
							case 'yy-mm-dd': echo _mdate($invoices['created']); break;
							case 'dd-mm-yy': echo _cdate($invoices['created']); break;
							case 'yy/mm/dd': echo _zdate($invoices['created']); break;
							case 'dd/mm/yy': echo _kdate($invoices['created']); break;
							}?>
					</span>
				</div>
			</div>
			<div class="row invoice-data">
				<div class="col-xs-5 invoice-person">
					<span class="name">
						<?php echo $settings['company'] ?>
					</span>
					<span>
						<?php echo $settings['address'] ?>
					</span>
					<span>
						<?php echo $settings['zipcode'] ?>/
						<?php echo $settings['town'] ?>/
						<?php echo $settings['city'] ?>,
						<?php echo $settings['country_id'] ?>
					</span>
					<span><b><?php echo lang('phone')?>:</b> <?php echo $settings['phone'] ?></span>
					<span><b><?php echo lang('fax')?>:</b> <?php echo $settings['fax'] ?></span>
					<span><b><?php echo lang('contactemail')?>:</b> <?php echo $settings['email'] ?></span>
					<span><b><?php echo $settings['taxoffice'] ?></b></span>
					<span>
						<B>
							<?php echo lang('vatnumber')?>:</B>
						<?php echo $settings['vatnumber'] ?>
					</span>
				</div>
				<div class="col-xs-2 invoice-payment-direction">
					<i class="icon mdi mdi-chevron-right"></i>
				</div>
				<div class="col-xs-5 invoice-person">
					<span class="name">
						<?php if($invoices['customercompany']===NULL){echo $invoices['namesurname'];} else echo $invoices['customercompany']; ?>
					</span>
					<span>
						<?php echo $invoices['email']; ?>
					</span>
					<span>
						<?php echo $invoices['customeraddress']; ?>
					</span>
					<span>
						<?php echo $invoices['phone'] ?>
					</span>
					<span>
						<?php echo $invoices['taxoffice'] ?>
					</span>
					<span>
						<B>
							<?php echo lang('vatnumber')?>:</B>
						<?php echo $invoices['taxnumber'] ?>
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="invoice-details">
						<?php foreach($invoiceitems as $fu){?>
						<tr>
							<th style="width:30%">
								<?php echo lang('invoiceitemdescription')?>
							</th>
							<th style="width:15%" class="amount">
								<?php echo lang('quantity')?>
							</th>
							<th style="width:15%" class="amount">
								<?php echo lang('price')?>
							</th>
							<th style="width:15%" class="amount">
								<?php echo lang('discount')?>
							</th>
							<th style="width:15%" class="amount">
								<?php echo lang('vat')?>
							</th>
							<th style="width:30%" class="amount">
								<?php echo lang('total')?>
							</th>
						</tr>
						<tr>
							<td class="description"><b><?php if($fu['in[product_id]'] = NULL){echo $fu['name'];}else {echo $fu['in[name]'];}?></b><br>(<?php echo $fu['in[description]'];?>)</td>
							<td class="amount">
								<?php switch($settings['unitseparator']){ 
								case ',': echo number_format($fu['in[amount]'], 2, ',', '.');break; 
								case '.': echo number_format($fu['in[amount]'], 2, '.', ',');break;
							}?>
							</td>
							<td class="amount">
								<?php switch($settings['unitseparator']){ 
								case ',': echo number_format($fu['in[price]'], 2, ',', '.');break; 
								case '.': echo number_format($fu['in[price]'], 2, '.', ',');break;
							}?>
							</td>
							<td class="amount">
								<?php echo $fu['in[discount_rate]'];?>
							</td>
							<td class="amount">
								<?php switch($settings['unitseparator']){ 
								case ',': echo number_format($fu['in[vat]'], 2, ',', '.');break; 
								case '.': echo number_format($fu['in[vat]'], 2, '.', ',');break;
							}?>
							</td>
							<td style="width:30%" class="amount">
								<?php switch($settings['unitseparator']){ 
								case ',': echo number_format($fu['in[total]'], 2, ',', '.');break; 
								case '.': echo number_format($fu['in[total]'], 2, '.', ',');break;
							}?>
							</td>
						</tr>
						<?php }?>
					</table>
					<div class="pull-right">
						<table class="invoice-details">
							<tr>
								<td class="summary">
									<?php echo lang('subtotal')?>
								</td>
								<td class="amount">
									<?php switch($settings['unitseparator']){ 
								case ',': echo number_format($invoices['total_sub'], 2, ',', '.'),' '.currency.'';break; 
								case '.': echo number_format($invoices['total_sub'], 2, '.', ','),' '.currency.'';break;
							}?>
								</td>
							</tr>
							<tr>
								<td class="summary">
									<?php echo lang('linediscount')?>
								</td>
								<td class="amount">
									<?php switch($settings['unitseparator']){ 
								case ',': echo number_format($invoices['total_discount'], 2, ',', '.'),' '.currency.'';break; 
								case '.': echo number_format($invoices['total_discount'], 2, '.', ','),' '.currency.'';break;
							}?>
								</td>
							</tr>
							<tr>
								<td class="summary">
									<?php echo lang('grosstotal')?>
								</td>
								<td class="amount">
									<?php $grosstotal = ($invoices['total_sub'] - $invoices['total_discount']);?>
									<?php switch($settings['unitseparator']){ 
								case ',': echo number_format($grosstotal, 2, ',', '.'),' '.currency.'';break; 
								case '.': echo number_format($grosstotal, 2, '.', ','),' '.currency.'';break;
							}?>
								</td>
							</tr>
							<tr>
								<td class="summary">
									<?php echo lang('tax')?>
								</td>
								<td class="amount">
									<?php switch($settings['unitseparator']){ 
								case ',': echo number_format($invoices['total_vat'], 2, ',', '.'),' '.currency.'';break; 
								case '.': echo number_format($invoices['total_vat'], 2, '.', ','),' '.currency.'';break;
							}?>
							</tr>
							<tr>
								<td class="summary total">
									<?php echo lang('total')?>
								</td>
								<td class="amount total-value">
									<?php switch($settings['unitseparator']){ 
								case ',': echo number_format($invoices['total'], 2, ',', '.'),' '.currency.'';break; 
								case '.': echo number_format($invoices['total'], 2, '.', ','),' '.currency.'';break;
							}?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 invoice-message">
					<span class="title">
						<?php echo $invoices['notetitle']; ?>
					</span>
					<p>
						<?php echo $invoices['not']; ?>
					</p>
				</div>
			</div>
			<div class="row invoice-company-info">
				<div class="col-sm-6 col-md-2 invoice-logo" style="background-image: url(<?php echo base_url('uploads/ciuis_settings/'.$settings['logo'].'') ?>)"></div>
				<div class="col-sm-6 col-md-4 summary">
					<span class="title">
						<?php echo $settings['company'] ?>
					</span>
					<p>
						<?php echo $settings['address']; ?>
					</p>
				</div>
				<div class="col-sm-6 col-md-3 phone">
					<ul class="list-unstyled">
						<li>
							<?php echo $settings['phone']; ?>
						</li>
						<li>
							<?php echo $settings['fax']; ?>
						</li>
					</ul>
				</div>
				<div class="col-sm-6 col-md-2 email">
					<ul class="list-unstyled">
						<li>
							<?php echo $settings['email']; ?>
						</li>
					</ul>
				</div>
			</div>
			<div class="row invoice-footer">
				<div class="col-md-12">
					<a href="<?php echo base_url('share/pdf/'.$invoices['id'].'');?>" class="btn btn-lg btn-space btn-default">
						<?php echo lang('savepdf')?>
					</a>
					<a href="<?php echo base_url('share/pdf/'.$invoices['id'].'?print=true');?>" class="btn btn-lg btn-space btn-default">
						<?php echo lang('print')?>
					</a>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>

</html>