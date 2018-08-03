<div class="ciuis-body-content" ng-controller="Accounts_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="account-container-ciuis-65343256347">
			<section class="accounts-information-ciuis-1881-sonuzadek">
				<i class="ion-ios-bookmarks-outline icon"></i>
				<section class="account-information-cover-234">
					<h3 class="information"><?php echo lang('accountswelcome'); ?></h3>
					<a ng-click="Create()" class="reconnect-cta"><b><?php echo lang('newaccount'); ?></b></a>
				</section>
			</section>
			<section class="ciuis-accounts">
				<a ng-repeat="account in accounts" href="<?php echo base_url('accounts/account/{{account.id}}')?>" class="huppur ciuis-account checking">
					<div class="icon {{account.icon}}" width="23px" height="30px"></div>
					<div class="ciuis-account-information">
						<h4 class="ciuis-account-type" ng-bind="account.name"></h4>
						<p class="ciuis-account-detail" ng-bind="account.status"></p>
					</div>
					<label class="ciuis-account-temprorary"><p ng-bind-html="account.amount | currencyFormat:cur_code:null:true:cur_lct"></p></label>
				</a>
				<strong class="pull-right"><p ng-bind-html="stats.total_incomings - stats.total_outgoings | currencyFormat:cur_code:null:true:cur_lct"></p></strong>
			</section>
		</div>
		<div class="ciuis-account-attr"></div>
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('create') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('name') ?></label>
			<input required type="text" ng-model="account.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
		</md-input-container>
		<md-input-container ng-show="isBankType == true" class="md-block">
			<label><?php echo lang('bankname') ?></label>
			<input type="text" ng-model="account.bankname" class="form-control" id="title" placeholder="<?php echo lang('bankname'); ?>"/>
		</md-input-container>
		<md-input-container ng-show="isBankType == true" class="md-block">
			<label><?php echo lang('branchbank') ?></label>
			<input type="text" ng-model="account.branchbank" class="form-control" id="title" placeholder="<?php echo lang('branchbank'); ?>"/>
		</md-input-container>
		<md-input-container ng-show="isBankType == true" class="md-block">
			<label><?php echo lang('account') ?></label>
			<input type="text" ng-model="account.account" class="form-control" id="title" placeholder="<?php echo lang('account'); ?>"/>
		</md-input-container>
		<md-input-container ng-show="isBankType == true" class="md-block">
			<label><?php echo lang('iban') ?></label>
			<input type="text" ng-model="account.iban" class="form-control" id="title" placeholder="<?php echo lang('iban'); ?>"/>
		</md-input-container>
		<md-switch class="pull-left" ng-model="isBankType" aria-label="Type"><strong class="text-muted"><?php echo lang('bank') ?></strong></md-switch>
		<section layout="row" layout-sm="column" class="pull-right" layout-wrap>
			  <md-button ng-click="AddAccount()" class="md-raised md-primary"><?php echo lang('add');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
</div>