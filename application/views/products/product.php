
<div class="ciuis-body-content" ng-controller="Product_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
	<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<h2 class="md-pl-10" flex md-truncate ng-bind="product.productname"></h2>
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
	<md-content class="bg-white">
	<div layout="row">
		<md-content class="bg-white" flex="50" style="border-right:1px solid #e0e0e0;">
			<md-list flex class="md-p-0 sm-p-0 lg-p-0">
			<md-list-item>
				<md-icon class="mdi mdi-label"></md-icon>
				<strong flex md-truncate><?php echo lang('purchaseprice') ?></strong>
				<p class="text-right" flex md-truncate ng-bind-html="product.purchase_price | currencyFormat:cur_code:null:true:cur_lct"></p>
			</md-list-item>
			<md-divider></md-divider>
			<md-list-item>
				<md-icon class="mdi mdi-label-heart"></md-icon>
				<strong flex md-truncate><?php echo lang('salesprice') ?></strong>
				<p class="text-right" flex md-truncate ng-bind-html="product.sale_price | currencyFormat:cur_code:null:true:cur_lct"></p>
			</md-list-item>
			<md-divider></md-divider>
			<md-list-item>
				<md-icon class="mdi mdi-balance"></md-icon>
				<strong flex md-truncate><?php echo lang('vat') ?></strong>
				<p class="text-right" flex md-truncate ng-bind="product.vat+'%'"></p>
			</md-list-item>
			<md-divider></md-divider>
			<md-list-item>
				<md-icon class="mdi mdi-book"></md-icon>
				<strong flex md-truncate><?php echo lang('instock') ?></strong>
				<p class="text-right" flex md-truncate ng-bind="product.stock"></p>
			</md-list-item>
			<md-divider></md-divider>
			<md-list-item>
				<md-icon class="ion-ios-barcode-outline"></md-icon>
				<strong flex md-truncate><?php echo lang('productcode') ?></strong>
				<p class="text-right" flex md-truncate ng-bind="product.code"></p>
			</md-list-item>
			<md-divider></md-divider>
		</md-list>
		</md-content>
		<div class="col-md-6">
			<div class="ciuis-product-summary">
				<h5 class="text-bold text-uppercase"><?php echo lang('netrevenue')?></h5>
				<small><?php echo lang('grossrevenueproductsub') ?></small>
				<h1 class="txt-scale-xs no-margin-top xs-28px figures"><span ng-bind="product.total_sales"></span></h1>							
			</div>
		</div>
		<div class="col-md-6">
			<div class="ciuis-product-summary">
				<h5 class="text-bold text-uppercase text-success"><?php echo lang('netearnings')?></h5>
				<small><?php echo lang('netearningssub')?></small>
				<h1 class="txt-scale-xs no-margin-top xs-28px figures"><span ng-bind-html="product.net_earning | currencyFormat:cur_code:null:true:cur_lct"></span></h1>
				<p class="secondary-text"><strong class="text-muted"><?php echo lang('productnetearnings') ?></strong></p>
			</div>
		</div>
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
	<md-truncate><?php echo lang('update') ?></md-truncate>
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
			  <md-button ng-click="UpdateProduct()" class="md-raised md-primary pull-right"><?php echo lang('update');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
</div>
<script> var PRODUCTID = "<?php echo $product['id'] ?>"</script>
