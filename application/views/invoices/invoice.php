<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Invoice_Controller">
	<div class="main-content container-fluid col-md-9">
	<md-toolbar class="toolbar-white">
	  <div class="md-toolbar-tools">
		<md-button class="md-icon-button" aria-label="Settings" ng-disabled="true">
		  <md-icon><i class="ico-ciuis-invoices text-muted"></i></md-icon>
		</md-button>
		<h2 flex md-truncate ng-bind="invoice.properties.invoice_id"></h2>
		<md-button ng-href="<?php echo base_url('invoices/share/{{invoice.id}}')?>" class="md-icon-button" aria-label="Email">
			<md-tooltip md-direction="bottom"><?php echo lang('send') ?></md-tooltip>
			<md-icon><i class="mdi mdi-email text-muted"></i></md-icon>
		</md-button>
		<md-button ng-href="<?php echo base_url('invoices/download/{{invoice.id}}') ?>" class="md-icon-button" aria-label="PDF">
			<md-tooltip md-direction="bottom"><?php echo lang('download') ?></md-tooltip>
			<md-icon><i class="mdi mdi-collection-pdf text-muted"></i></md-icon>
		</md-button>
		<md-button ng-href="<?php echo base_url('invoices/print_/{{invoice.id}}') ?>" class="md-icon-button" aria-label="Print">
			<md-tooltip md-direction="bottom"><?php echo lang('print') ?></md-tooltip>
			<md-icon><i class="mdi mdi-print text-muted"></i></md-icon>
		</md-button>
		<div class="btn-group btn-hspace pull-right">
		<md-button class="md-icon-button dropdown-toggle" aria-label="Actions" data-toggle="dropdown">
			<md-tooltip md-direction="bottom"><?php echo lang('action') ?></md-tooltip>
			<md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
		</md-button>
		<ul role="menu" class="dropdown-menu">
			<li><a ng-click="MarkAsDraft()" href="#"><?php echo lang('markasdraft') ?></a></li>
			<li><a ng-click="MarkAsCancelled()" href="#"><?php echo lang('markascancelled') ?></a></li>
			<li class="divider"> <a href="#"></a> </li>
			<li><a href="<?php echo base_url('invoices/update/{{invoice.id}}')?>"><?php echo lang('update') ?></a></li>
			<li class="divider"> <a href="#"></a> </li>
			<li ng-init="MSG_TITLE = '<?php echo lang('attention') ?>';MSG_REMOVE = '<?php echo lang('inv_remove_msg') ?>';MSG_CANCEL = '<?php echo lang('cancel') ?>';MSG_OK = '<?php echo lang('yes') ?>'" ng-click="Delete()"><a><?php echo lang('delete') ?></a></li>
		</ul>
		</div>
	  </div>
	</md-toolbar>
	<md-content class="bg-white invoice">
		<div class="invoice-header col-md-12">
			<div class="invoice-from col-md-4 col-xs-12">
				<small><?php echo  lang('from'); ?></small>
				<address class="m-t-5 m-b-5">
					<strong ng-bind="settings.company"></strong><br>
					<span ng-bind="settings.address"></span><br>
					<span ng-bind="settings.phone"></span><br>
				</address>
			</div>
			<div class="invoice-to col-md-4 col-xs-12">
				<small><?php echo  lang('to'); ?></small>
				<address class="m-t-5 m-b-5">
					<strong ng-bind="invoice.properties.customer"></strong><br>
					<span ng-bind="invoice.properties.customer_address"></span><br>
					<span ng-bind="invoice.properties.customer_phone"></span>
				</address>
			</div>
			<div class="invoice-date col-md-4 col-xs-12">
				<div class="date m-t-5" ng-bind="invoice.created | date : 'MMM d, y'"></div>
				<div class="invoice-detail">
					<span ng-bind="invoice.serie + invoice.no"></span><br>
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
						<tr ng-repeat="item in invoice.items">
							<td><span ng-bind="item.name"></span><br><small ng-bind="item.description"></small></td>
							<td ng-bind="item.quantity"></td>
							<td ng-bind-html="item.price | currencyFormat:cur_code:null:true:cur_lct"></td>
							<td ng-bind="item.tax + '%'"></td>
							<td ng-bind="item.discount + '%'"></td>
							<td ng-bind-html="item.total | currencyFormat:cur_code:null:true:cur_lct"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="invoice-price">
				<div class="invoice-price-left">
					<div class="invoice-price-row">
						<div class="sub-price">
							<small><?php echo lang('subtotal') ?></small>
							<span ng-bind-html="invoice.sub_total | currencyFormat:cur_code:null:true:cur_lct"></span>
						</div>
						<div class="sub-price">
							<i class="ion-plus-round"></i>
						</div>
						<div class="sub-price">
							<small><?php echo lang('tax') ?></small>
							<span ng-bind-html="invoice.total_tax | currencyFormat:cur_code:null:true:cur_lct"></span>
						</div>
						<div class="sub-price">
							<i class="ion-minus-round"></i>
						</div>
						<div class="sub-price">
							<small><?php echo lang('discount') ?></small>
							<span ng-bind-html="invoice.total_discount | currencyFormat:cur_code:null:true:cur_lct"></span>
						</div>
					</div>
				</div>
				<div class="invoice-price-right">
					<small><?php echo lang('total') ?></small>
					<span ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></span>
				</div>
			</div>
		</div>
	</md-content>
	</div>
	<div class="main-content container-fluid col-md-3 md-pl-0">
		<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<h2 flex md-truncate class="pull-left" ng-show="invoice.balance != 0"><strong><?php echo lang('balance')?> : <span ng-bind-html="invoice.balance | currencyFormat:cur_code:null:true:cur_lct"></span></strong></h2>
			<h2 flex md-truncate class="pull-left text-success" ng-hide="invoice.balance != 0"><strong><?php echo lang('paidinv') ?></strong></h2>
			<md-button ng-hide="invoice.partial_is != 'true'" class="md-icon-button" aria-label="Partial">
				<md-tooltip md-direction="bottom"><?php echo lang('partial') ?></md-tooltip>
				<md-icon><i class="ion-pie-graph text-muted"></i></md-icon>
			</md-button>
			<md-button ng-hide="invoice.balance != 0" class="md-icon-button" aria-label="Paid" >
				<md-tooltip md-direction="bottom"><?php echo lang('paid') ?></md-tooltip>
				<md-icon><i class="ion-checkmark-circled text-success"></i></md-icon>
			</md-button>
		</div>
		</md-toolbar>
		<md-content class="bg-white" style="border-bottom:1px solid #e0e0e0;">
			<md-list flex>
				<md-list-item>
					<md-icon class="ion-ios-bell"></md-icon>
					<p ng-bind="invoice.duedate_text"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="ion-android-mail"></md-icon>
					<p ng-bind="invoice.mail_status"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="ion-person"></md-icon>
					<p><strong ng-bind="invoice.properties.invoice_staff"></strong></p>
				</md-list-item>
			</md-list>
		</md-content>
		<md-toolbar class="toolbar-white">
		  <div class="md-toolbar-tools">
			<h2 flex md-truncate class="text-bold"><?php echo lang('payments'); ?><br><small flex md-truncate><?php echo lang('paymentsside'); ?></small></h2>
			<md-button ng-show="invoice.balance != 0" ng-click="RecordPayment()" class="md-icon-button" aria-label="Record Payment">
			<md-tooltip md-direction="left"><?php echo lang('recordpayment') ?></md-tooltip>
				<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
			</md-button>
		  </div>
		</md-toolbar>
		<md-content class="bg-white">
		<md-content ng-show="!invoice.payments.length" class="md-padding no-item-payment bg-white"></md-content>
		<md-list flex>
        <md-list-item class="md-2-line" ng-repeat="payment in invoice.payments">
          <md-icon class="ion-arrow-down-a text-muted"></md-icon>
          <div class="md-list-item-text">
            <h3 ng-bind="payment.name"></h3>
            <p ng-bind-html="payment.amount | currencyFormat:cur_code:null:true:cur_lct"></p>
          </div>
          <md-button class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click="doSecondaryAction($event)" aria-label="call">
            <md-icon class="ion-ios-search-strong"></md-icon>
          </md-button>
          <md-divider></md-divider>
        </md-list-item>
      	</md-list>
		</md-content>
	</div>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="RecordPayment">
	  <md-toolbar class="md-theme-light" style="background:#262626">
	  <div class="md-toolbar-tools">
		<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
			 <i class="ion-android-arrow-forward"></i>
		</md-button>
		<md-truncate><?php echo lang('recordpayment') ?></md-truncate>
	  </div>
	  </md-toolbar>
	  <md-content layout-padding="">
		<form name="projectForm">
		<md-content layout-padding>
			<md-input-container class="md-block">
				<label><?php echo lang('datepayment') ?></label>
				<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="date" class=" dtp-no-msclear dtp-input md-input">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('amount') ?></label>
				<input required type="number" name="amount" ng-model="amount" max="{{invoice.balance}}"/>
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('description') ?></label>
				<textarea required name="not" ng-model="not" placeholder="Type something" class="form-control"></textarea>
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('account'); ?></label>
				<md-select placeholder="<?php echo lang('account'); ?>" ng-model="account" name="account" style="min-width: 200px;">
					<md-option ng-value="account.id" ng-repeat="account in accounts">{{account.name}}</md-option>
				</md-select>
			</md-input-container>
			<div class="form-group pull-right">
				<button ng-click="AddPayment()" class="btn btn-warning btn-xl ion-ios-paperplane"> <?php echo lang('save')?></button>
			</div>
		</md-content>
		</form>
	 </md-content>
	</md-sidenav>
<script>
var INVOICEID = <?php echo $invoices['id']; ?>;
var INVOICECUSTOMER = <?php echo $invoices['customer_id']; ?>;
</script>
</div>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>