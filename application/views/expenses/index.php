<div class="ciuis-body-content" ng-controller="Expenses_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="col-md-4" style="padding: 0px">
			<md-toolbar class="toolbar-trans">
			  <div class="md-toolbar-tools">
				<h2 flex md-truncate class="text-bold"><?php echo lang('expensescategories'); ?><br><small flex md-truncate><?php echo lang('expensescategoriessub'); ?></small></h2>
				<md-button ng-click="NewCategory()" class="md-icon-button" aria-label="Filter">
					<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
				</md-button>
			  </div>
			</md-toolbar>
			<md-content ng-repeat="category in categories">
				<div class="widget widget-stats red-bg margin-top-0">
				  <div class="stats-icon stats-icon-lg"><i style="margin-right: 10px" ng-click="UpdateCategory($index)" class="ion-ios-gear-outline"></i><a ng-click="Remove($index)" style="color:#a9b1c2" class="ion-ios-trash"></a></div>
				  <div class="stats-title text-uppercase" ng-bind="category.name"></div>
				  <div class="stats-number"><span ng-bind-html="category.amountby | currencyFormat:cur_code:null:true:cur_lct"></span></div>
				  <div class="stats-progress progress">
					<div style="width: {{category.percent}}%;" class="progress-bar"></div>
				  </div>
				  <div class="stats-desc"><?php echo lang('categorypercent') ?> (<span ng-bind="category.percent+'%'"></span>)</div>
				</div>
			</md-content>
		</div>
		<div class="col-md-8" style="padding: 0px">
			<md-toolbar class="toolbar-trans">
			  <div class="md-toolbar-tools">
				<h2 flex md-truncate class="text-bold"><?php echo lang('expenses'); ?><br><small flex md-truncate><?php echo lang('organizeyourexpenses'); ?></small></h2>
				<div class="ciuis-external-search-in-table">
					<input ng-model="search.subject" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
					<md-button class="md-icon-button" aria-label="Search">
						<md-icon><i class="ion-search text-muted"></i></md-icon>
					</md-button>
				</div>
				<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter">
					<md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
				</md-button>
				<md-button  ng-click="NewExpense()" class="md-icon-button" aria-label="New">
					<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
				</md-button>
			  </div>
			</md-toolbar>
			<md-content layout-padding="" style="padding-top: 0px; padding-right: 0px;">
				<ul class="custom-ciuis-list-body" style="padding: 0px;">
				<li ng-repeat="expense in expenses | filter: FilteredData| pagination : currentPage*itemsPerPage | limitTo: 5"i class="ciuis-custom-list-item ciuis-special-list-item lead-name">
					<ul class="list-item-for-custom-list">
						<li class="ciuis-custom-list-item-item col-md-12">
						<div data-toggle="tooltip" data-placement="bottom" data-container="body" title="" data-original-title="<?php echo lang('addedby'); ?> {{expense.staff}}" class="assigned-staff-for-this-lead user-avatar"><i class="ion-document" style="font-size: 32px"></i></div>
							<div class="pull-left col-md-4">
							<a class="ciuis_expense_receipt_number" href="<?php echo base_url('expenses/receipt/') ?>{{expense.id}}"><strong ng-bind="expense.prefix + '-' + expense.longid"></strong></a><br>
							<small ng-bind="expense.title"></small>
							</div>
							<div class="col-md-8">
								<div class="col-md-5">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('amount'); ?></small><br><strong ng-bind-html="expense.amount | currencyFormat:cur_code:null:true:cur_lct"><span>
								<span ng-show="expense.billable != 'false'" class="label label-{{expense.color}}" ng-bind="expense.billstatus"></span>
								</span></strong></span>
								</div>
								<div class="col-md-4">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('category'); ?></small><br><strong ng-bind="expense.category"></strong>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('date'); ?></small><br><strong><span class="badge" ng-bind="expense.date"></span></strong></span>
								</div>
							</div>
						</li>
					</ul>
				</li>
				</ul>
				<div class="pagination-div">
					<ul class="pagination">
						<li ng-class="DisablePrevPage()">
							<a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a>
						</li>
						<li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
							<a href="#" ng-bind="n+1"></a>
						</li>
						<li ng-class="DisableNextPage()">
							<a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a>
						</li>
					</ul>
				</div>
				<md-content ng-show="!expenses.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
			</md-content>
		</div>
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter">
		<md-toolbar class="md-theme-light" style="background:#262626">
	  <div class="md-toolbar-tools">
		<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
			 <i class="ion-android-arrow-forward"></i>
		</md-button>
		<md-truncate><?php echo lang('filter') ?></md-truncate>
	  </div>
	  </md-toolbar>
	  <md-content layout-padding="">
		<div ng-repeat="(prop, ignoredValue) in expenses[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'title' && prop != 'prefix' && prop != 'longid' && prop != 'amount' && prop != 'staff' && prop != 'color' && prop != 'displayinvoice' && prop != 'date' && prop != 'category' && prop != 'billstatus' && prop != 'billable'">
		  <div class="filter col-md-12">
			<h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
			<hr>
			<div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)">
				<md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
			</div>
		  </div>
		</div>
	  </md-content>
	</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewExpense">
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
			<input required type="text" ng-model="newexpense.title" class="form-control" id="title" placeholder="<?php echo lang('title'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('amount') ?></label>
			<input required type="text" ng-model="newexpense.amount" class="form-control" id="amount" placeholder="0.00"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('date') ?></label>
			<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="newexpense.date" class=" dtp-no-msclear dtp-input md-input">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('category'); ?></label>
			<md-select required ng-model="newexpense.category" name="category" style="min-width: 200px;">
				<md-option ng-value="category.id" ng-repeat="category in categories">{{category.name}}</md-option>
			</md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('customer'); ?></label>
			<md-select placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="newexpense.customer" name="customer" style="min-width: 200px;">
				<md-option ng-value="customer.id" ng-repeat="customer in all_customers">{{customer.name}}</md-option>
			</md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('account'); ?></label>
			<md-select required ng-model="newexpense.account" name="account" style="min-width: 200px;">
				<md-option ng-value="account.id" ng-repeat="account in accounts">{{account.name}}</md-option>
			</md-select>
        </md-input-container>
        <br>
		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required name="description" ng-model="newexpense.description" placeholder="Type something" class="form-control"></textarea>
		</md-input-container>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="AddExpense()" class="md-raised md-primary pull-right"><?php echo lang('add');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
</div>
