<?php include_once(APPPATH . 'views/area/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Invoices_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-trans">
			<div class="md-toolbar-tools">
				<h2 flex md-truncate class="text-bold"><?php echo lang('invoices'); ?><br><small flex md-truncate><?php echo lang('organizeyourinvoices'); ?></small></h2>
			</div>
		</md-toolbar>
		<md-content>
			<ul class="custom-ciuis-list-body" style="padding: 0px;">
				<li ng-repeat="invoice in invoices | filter: FilteredData |  filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="ciuis-custom-list-item ciuis-special-list-item">
					<ul class="list-item-for-custom-list">
						<li class="ciuis-custom-list-item-item col-md-12">
						<div class="assigned-staff-for-this-lead user-avatar"><i class="ico-ciuis-invoices" style="font-size: 32px"></i></div>
							<div class="pull-left col-md-3">
							<strong>
							<a class="ciuis_expense_receipt_number" href="<?php echo base_url('area/invoice/{{invoice.token}}'); ?>"><span ng-bind="invoice.prefix + '-' + invoice.longid"></span></a>
							</strong><br><small ng-bind="invoice.customer"></small>
							</div>
							<div class="col-md-9">
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('billeddate'); ?></small><br><strong><span class="badge" ng-bind="invoice.created"></span></strong></span>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('invoiceduedate'); ?></small><br><strong><span class="badge" ng-bind="invoice.duedate"></span></strong></span>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('status'); ?></small><br><strong class="text-uppercase text-{{invoice.color}}" ng-bind="invoice.status"></strong>
								</div>
								<div class="col-md-3 text-right">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('amount'); ?></small><br><strong ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></strong></span>
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
			<md-content ng-show="!invoices.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>	
		</md-content>
	</div>
</div>
<?php include_once(APPPATH . 'views/area/inc/sidebar.php');?>
<?php include_once(APPPATH . 'views/area/inc/footer.php');?>
