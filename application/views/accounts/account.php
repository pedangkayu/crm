<div class="ciuis-body-content" ng-controller="Account_Controller">
	<md-content class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
	<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<h2 class="md-pl-10" flex md-truncate ng-bind="account.name"></h2>
			<md-button ng-click="Update()" class="md-icon-button md-primary" aria-label="Actions">
					<md-icon class="mdi mdi-edit"></md-icon>
			</md-button>
			<md-button ng-click="Delete()" class="md-icon-button md-primary" aria-label="Actions">
				<md-icon class="ion-trash-b"></md-icon>
			</md-button>
		</div>
	</md-toolbar>
	<md-content class="ciuis9876578d bg-white">
		<img src="<?php echo base_url()?>assets/img/accountbg.png" style="width: 125px;" alt="" class="pull-right">
		<h4 class="text-bold money-area"><strong ng-bind-html="account.account_total | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
		<p>
			<strong><?php echo lang('accountstatus'); ?>: <span ng-show="account.status == true" class="text-success"><?php echo lang( 'active' ) ?></span><span ng-show="account.status == false" class="text-danger"><?php echo lang( 'inactive' ) ?></span></strong>
		</p>
		<div class="bar" ng-show="account.type == '1'">
			<div class="complete" ng-bind="account.bankname+' / '+account.branchbank"></div>
			<div class="complete"><strong><?php echo lang('account') ?>: </strong><span ng-bind="account.account"></span></div>
			<div class="complete"><strong><?php echo lang('iban') ?>: </strong><span ng-bind="account.iban"></span></div>
		</div>
	</md-content>
	<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<h2 class="md-pl-10" flex md-truncate><?php echo lang('accountactivity'); ?></h2>					
		</div>
	</md-toolbar>
	<md-content class="bg-white">
		<md-list flex class="md-p-0 sm-p-0 lg-p-0">
			<md-list-item ng-repeat="transaction in account.payments" ng-click="Detail($index)" aria-label="Proposal">
				<md-button ng-show="transaction.transactiontype =='0'" class="md-icon-button" aria-label="Actions">
					<md-tooltip md-direction="bottom"><?php echo lang('incomings') ?></md-tooltip>
					<md-icon class="ion-arrow-down-a text-success"></md-icon>
				</md-button>
				<md-button ng-show="transaction.transactiontype !='0'" class="md-icon-button" aria-label="Actions">
					<md-tooltip md-direction="bottom"><?php echo lang('outgoings') ?></md-tooltip>
					<md-icon class="ion-arrow-up-a text-danger"></md-icon>
				</md-button>
				<p flex md-truncate><strong ng-bind="transaction.date | date : 'MMM d, y h:mm:ss a'"></strong></p>
				<h4 class="md-secondary"><strong ng-bind-html="transaction.amount | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
			<md-divider></md-divider>
			</md-list-item>
		</md-list>
		<md-content ng-show="!account.payments.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
	</md-content>
	</md-content>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('update') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('name') ?></label>
			<input required type="text" ng-model="account.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
		</md-input-container>
		<md-input-container ng-show="account.type == '1'" class="md-block">
			<label><?php echo lang('bankname') ?></label>
			<input required type="text" ng-model="account.bankname" class="form-control" id="title" placeholder="<?php echo lang('bankname'); ?>"/>
		</md-input-container>
		<md-input-container ng-show="account.type == '1'" class="md-block">
			<label><?php echo lang('branchbank') ?></label>
			<input required type="text" ng-model="account.branchbank" class="form-control" id="title" placeholder="<?php echo lang('branchbank'); ?>"/>
		</md-input-container>
		<md-input-container ng-show="account.type == '1'" class="md-block">
			<label><?php echo lang('account') ?></label>
			<input required type="text" ng-model="account.account" class="form-control" id="title" placeholder="<?php echo lang('account'); ?>"/>
		</md-input-container>
		<md-input-container ng-show="account.type == '1'" class="md-block">
			<label><?php echo lang('iban') ?></label>
			<input required type="text" ng-model="account.iban" class="form-control" id="title" placeholder="<?php echo lang('iban'); ?>"/>
		</md-input-container>
		<md-switch class="pull-left" ng-model="account.status" aria-label="Status"><strong class="text-muted"><?php echo lang('active') ?></strong></md-switch>
		<section layout="row" layout-sm="column" class="pull-right" layout-wrap>
			  <md-button ng-click="UpdateAccount()" class="md-raised md-primary"><?php echo lang('update');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
</div>
<script> var ACCOUNTID = "<?php echo $account['id'] ?>"</script>
