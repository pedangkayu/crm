<div class="ciuis-body-content" ng-controller="Expense_Controller">
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
	<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<h2 class="md-pl-10" flex md-truncate ng-bind="expense.prefix+'-'+expense.longid"></h2>
			<md-button ng-hide="expense.invoice_id" ng-if="expense.customer != 0" ng-click="Convert()" class="md-icon-button" aria-label="Convert">
		  		<md-tooltip md-direction="bottom"><?php echo lang('convert') ?></md-tooltip>
			  	<md-icon><i class="ion-loop text-success"></i></md-icon>
			</md-button>
			<md-button ng-if="expense.invoice_id" ng-href="<?php echo base_url('invoices/invoice/{{expense.invoice_id}}')?>" class="md-icon-button">
				<md-tooltip md-direction="bottom"><?php echo lang('invoice') ?></md-tooltip>
			  	<md-icon><i class="ion-document-text text-success"></i></md-icon>
			</md-button>
			<md-button ng-click="Update()" class="md-icon-button" aria-label="Update">
				<md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
				<md-icon><i class="ion-compose	text-muted"></i></md-icon>
			</md-button>
			<md-button ng-click="Delete()" class="md-icon-button" aria-label="Delete">
				<md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
				<md-icon><i class="ion-trash-b	text-muted"></i></md-icon>
			</md-button>
		</div>
	</md-toolbar>
	<md-content class="ciuis-expenses-receipt-detail bg-white" layout-padding>
		<div class="ciuis-expenses-receipt-xs-colum">
			<h4 md-truncate><strong ng-bind="expense.title"></strong></h4>
			<span ng-bind="expense.description"></span>
		</div>
		<div class="ciuis-expenses-receipt-xs-colum"> <i class="mdi mdi-balance-wallet" aria-hidden="true"></i>
			<p>
			<span><?php echo lang('amount')?>:</span></br>
			<span style="font-size: 26px;font-weight: 900;" ng-bind-html="expense.amount | currencyFormat:cur_code:null:true:cur_lct"></span><br>
			<small><?php echo lang('paidvia')?> <strong ng-bind="expense.account_name"></strong></small>
			</p>
		</div>
		<div class="ciuis-expenses-receipt-xs-colum">
			<p><?php echo lang('date')?>:</br><span><strong ng-bind="expense.date | date:'dd, MMMM yyyy EEEE'"></strong></span></p>
		</div>
		<div class="ciuis-expenses-receipt-xs-colum"
			<p><?php echo lang('staff')?>:</br><span><strong ng-bind="expense.staff_name"></strong></span></p>
		</div>
		<div class="ciuis-expenses-receipt-xs-colum">
			<p><?php echo lang('category')?>:</br><span><strong ng-bind="expense.category_name"></strong></span></p>
		</div>
	</md-content>
</div>
<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('addexpense') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('title') ?></label>
			<input required type="text" ng-model="expense.title" class="form-control" id="title" placeholder="<?php echo lang('title'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('amount') ?></label>
			<input required type="text" ng-model="expense.amount" class="form-control" id="amount" placeholder="0.00"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('date') ?></label>
			<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="expense.date" class=" dtp-no-msclear dtp-input md-input">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('category'); ?></label>
			<md-select required ng-model="expense.category" name="category" style="min-width: 200px;">
				<md-option ng-value="category.id" ng-repeat="category in expensescategories">{{category.name}}</md-option>
			</md-select>
        </md-input-container>
        <br>
        <md-input-container ng-show="expense.customer != 0" class="md-block" flex-gt-xs>
            <label><?php echo lang('customer'); ?></label>
			<md-select placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="expense.customer" name="customer" style="min-width: 200px;">
				<md-option ng-value="customer.id" ng-repeat="customer in all_customers">{{customer.name}}</md-option>
			</md-select>
        </md-input-container>
        <br ng-show="expense.customer != 0">
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('account'); ?></label>
			<md-select required ng-model="expense.account" name="account" style="min-width: 200px;">
				<md-option ng-value="account.id" ng-repeat="account in accounts">{{account.name}}</md-option>
			</md-select>
        </md-input-container>
        <br>
		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required name="description" ng-model="expense.description" placeholder="Type something" class="form-control"></textarea>
		</md-input-container>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="UpdateExpense()" class="md-raised md-primary pull-right"><?php echo lang('update');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
</div>
<script> var EXPENSEID = "<?php echo $expenses['id'] ?>"</script>