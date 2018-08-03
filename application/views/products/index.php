
<div class="ciuis-body-content" ng-controller="Products_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
		<md-toolbar class="toolbar-trans">
		  <div class="md-toolbar-tools">
			<h2 flex md-truncate class="text-bold"><?php echo lang('products'); ?><br><small flex md-truncate><?php echo lang('productsdescription'); ?></small></h2>
			<div class="ciuis-external-search-in-table">
				<input ng-model="search.name" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
				<md-button class="md-icon-button" aria-label="Search">
					<md-icon><i class="ion-search text-muted"></i></md-icon>
				</md-button>
			</div>
			<md-button ng-click="Create()" class="md-icon-button" aria-label="New">
				<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
			</md-button>
		  </div>
		</md-toolbar>
		<md-content layout-padding class="md-pt-0">
			<ul class="custom-ciuis-list-body" style="padding: 0px;">
				<li ng-repeat="product in products | pagination : currentPage*itemsPerPage | limitTo: 5"i class="ciuis-custom-list-item ciuis-special-list-item">
				<ul class="list-item-for-custom-list">
					<li class="ciuis-custom-list-item-item col-md-12">
					<div class="assigned-staff-for-this-lead user-avatar"><i class="ico-ciuis-products" style="font-size: 32px"></i></div>
						<div class="pull-left col-md-5">
							<a href="<?php echo base_url('products/product/') ?>{{product.product_id}}"><strong ng-bind="product.name"></strong></a><br>
							<small ng-bind="product.description| limitTo:35"></small>
							</div>
						<div class="col-md-7">
							<div class="col-md-4">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('salesprice'); ?></small><br>
								<strong ng-bind-html="product.price | currencyFormat:cur_code:null:true:cur_lct"></strong>
								</span>
							</div>
							<div class="col-md-4">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('tax'); ?></small><br>
								<strong ng-bind="product.tax+'%'"></strong>
							</div>
							<div class="col-md-4 text-right">
								<md-button ng-href="<?php echo base_url('products/product/') ?>{{product.product_id}}" class="md-icon-button" aria-label="View">
									<md-tooltip md-direction="left"><?php echo lang('view') ?></md-tooltip>
									<md-icon><i class="ion-eye text-muted"></i></md-icon>
								</md-button>
								<md-button ng-href="<?php echo base_url('products/remove/') ?>{{product.product_id}}" class="md-icon-button" aria-label="Delete">
									<md-tooltip md-direction="left"><?php echo lang('delete') ?></md-tooltip>
									<md-icon><i class="ion-trash-b text-muted"></i></md-icon>
								</md-button>
							</div>
						</div>
					</li>
				</ul>
			</li>
			</ul>
			<md-content ng-show="!products.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
			<div class="pagination-div text-center">
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
		</md-content>
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('addproduct') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('productname') ?></label>
			<input required type="text" ng-model="product.productname" class="form-control" id="name" placeholder="<?php echo lang('productname'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('purchaseprice') ?></label>
			<input required type="text" ng-model="product.purchase_price" class="form-control" id="amount" placeholder="0.00"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('salesprice') ?></label>
			<input required type="text" ng-model="product.sale_price" class="form-control" id="amount" placeholder="0.00"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('productcode') ?></label>
			<input  type="text" ng-model="product.code" class="form-control" id="productcode" placeholder="<?php echo lang('productcode'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('tax') ?></label>
			<input  type="text" ng-model="product.vat" class="form-control" id="tax" placeholder="<?php echo lang('tax'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('instock') ?></label>
			<input  type="text" ng-model="product.stock" class="form-control" id="stock" placeholder="<?php echo lang('instock'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required name="description" ng-model="product.description" placeholder="Type something" class="form-control"></textarea>
		</md-input-container>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="AddProduct()" class="md-raised md-primary pull-right"><?php echo lang('add');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
</div>
