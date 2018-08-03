<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content">
	<div ng-controller="Proposal_Controller" class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
	<?php echo form_open('proposals/update',array("class"=>"form-horizontal proposalForm")); ?>
	<md-toolbar class="toolbar-white">
	  <div class="md-toolbar-tools">
		<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
		  <md-icon><i class="ico-ciuis-proposals text-muted"></i></md-icon>
		</md-button>
		<h2 flex md-truncate><?php echo lang('updateproposal') ?></h2>
		<md-button ng-href="<?php echo base_url('proposals/proposal/{{proposal.id}}')?>" class="md-icon-button" aria-label="Save">
			<md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
			<md-icon><i class="ion-close-circled text-muted"></i></md-icon>
		</md-button>
		<md-button ng-click="saveAll()" class="md-icon-button" aria-label="Save">
			<md-tooltip md-direction="bottom"><?php echo lang('save') ?></md-tooltip>
			<md-icon><i class="ion-checkmark-circled text-muted"></i></md-icon>
		</md-button>
	  </div>
	</md-toolbar>
	<md-content class="bg-white" layout-padding>
		<div layout-gt-xs="row">
           <md-input-container class="md-block" flex-gt-sm>
            <label><?php echo lang('subject')?></label>
            <input ng-model="proposal.subject" name="subject">
          	</md-input-container>
           <md-input-container ng-show="proposal.proposal_type == false" class="md-block" flex-gt-xs>
            <label><?php echo lang('customer'); ?></label>
			<md-select required placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="proposal.customer" name="customer" style="min-width: 200px;">
				<md-option ng-value="customer.id" ng-repeat="customer in all_customers">{{customer.name}}</md-option>
			</md-select>
        	 <div ng-messages="userForm.customer" role="alert" multiple>
              <div ng-message="required" class="my-message">You must supply a customer.</div>
            </div>
          </md-input-container>
          <md-input-container ng-show="proposal.proposal_type == true" class="md-block" flex-gt-xs>
            <label><?php echo lang('lead'); ?></label>
			<md-select required placeholder="<?php echo lang('choiselead'); ?>" ng-model="proposal.lead" name="lead" style="min-width: 200px;">
				<md-option ng-value="lead.id" ng-repeat="lead in leads">{{lead.name}}</md-option>
			</md-select>
        	 <div ng-messages="userForm.customer" role="alert" multiple>
              <div ng-message="required" class="my-message">You must supply a customer.</div>
            </div>
          </md-input-container>
          <md-input-container>
            <label><?php echo lang('dateofissuance') ?></label>
            <md-datepicker name="created" ng-model="proposal.created"></md-datepicker>
          </md-input-container>
        </div>
        <div layout-gt-xs="row">
          <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('assigned'); ?></label>
			<md-select required placeholder="<?php echo lang('assigned'); ?>" ng-model="proposal.assigned" name="assigned" style="min-width: 200px;">
				<md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
			</md-select>
        	 <div ng-messages="userForm.assigned" role="alert" multiple>
              <div ng-message="required" class="my-message">You must supply a assigner.</div>
            </div>
          </md-input-container>
          <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('status'); ?></label>
			<md-select ng-init="statuses = [{id: 1,name: '<?php echo lang('draft'); ?>'}, {id: 2,name: '<?php echo lang('sent'); ?>'}, {id: 3,name: '<?php echo lang('open'); ?>'}, {id: 4,name: '<?php echo lang('revised'); ?>'}, {id:5,name: '<?php echo lang('declined'); ?>'}, {id: 6,name: '<?php echo lang('accepted'); ?>'}];" required placeholder="<?php echo lang('status'); ?>" ng-model="proposal.status" name="status" style="min-width: 200px;">
				<md-option ng-value="status.id" ng-repeat="status in statuses"><span class="text-uppercase">{{status.name}}</span></md-option>
			</md-select>
        	 <div ng-messages="userForm.status" role="alert" multiple>
              <div ng-message="required" class="my-message">You must select a status.</div>
            </div>
          </md-input-container>
           <md-input-container>
            <label><?php echo lang('opentill') ?></label>
            <md-datepicker name="opentill" ng-model="proposal.opentill"></md-datepicker>
          </md-input-container>
        </div>
        <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
          <label><?php echo lang('detail') ?></label>
          <textarea ng-model="proposal.content" rows="3"></textarea>
        </md-input-container>
		</div>
        <md-checkbox class="pull-right" ng-model="proposal.comment" ng-true-value="true" ng-false-value="false" aria-label="Comment">
        <strong class="text-muted text-uppercase"><?php echo lang('allowcomments');?></strong>
        </md-checkbox>
	</md-content>
	<md-content class="bg-white" layout-padding>
	<md-list-item ng-repeat="item in proposal.items">
		<div layout-gt-sm="row">
  	  	 <md-autocomplete
  	  	 	md-autofocus
  	  	 	md-items="product in GetProduct(item.name)"
		    md-search-text="item.name"
		    md-item-text="product.name"   
		    md-selected-item="selectedProduct"
		    md-no-cache="true"
		    md-min-length="0"
		    md-floating-label="<?php echo lang('productservice'); ?>"
		    placeholder="What is your favorite US state?">
			<md-item-template>
			<span md-highlight-text="item.name">{{product.name}}</span> 
			<strong ng-bind-html="product.price | currencyFormat:cur_code:null:true:cur_lct"></strong>
			</md-item-template>
		</md-autocomplete>
		<md-input-container class="md-block">
			<label><?php echo lang('description'); ?></label>
			<input type="hidden" ng-model="item.name">
			<input type="hidden" ng-model="item.id">
			<bind-expression ng-init="selectedProduct.name = item.name" expression="selectedProduct.name" ng-model="item.name" />
			<input ng-model="item.description">
			<bind-expression ng-init="selectedProduct.description = item.description" expression="selectedProduct.description" ng-model="item.description" />
			<input type="hidden" ng-model="item.product_id">
			<bind-expression ng-init="selectedProduct.product_id = item.product_id" expression="selectedProduct.product_id" ng-model="item.product_id" />
			<input type="hidden" ng-model="item.code" ng-value="selectedProduct.code">
			<bind-expression ng-init="selectedProduct.code = item.code" expression="selectedProduct.code" ng-model="item.code" />
		</md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
			<label><?php echo lang('quantity'); ?></label>
			<input ng-model="item.quantity" >
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
			<label><?php echo lang('unit'); ?></label>
			<input ng-model="item.unit" >
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('price'); ?></label>
			<input ng-model="item.price">
			<bind-expression ng-init="selectedProduct.price = item.price" expression="selectedProduct.price" ng-model="item.price" />
		</md-input-container>
		<md-input-container class="md-block" flex-gt-sm>
			<label><?php echo lang('tax'); ?></label>
			<input ng-model="item.tax">
			<bind-expression ng-init="selectedProduct.tax = item.tax" expression="selectedProduct.tax" ng-model="item.tax" />
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
			<label><?php echo lang('discount'); ?></label>
			<input ng-model="item.discount">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('total'); ?></label>
			<input ng-value="item.quantity * item.price + ((item.tax)/100*item.quantity * item.price) - ((item.discount)/100*item.quantity * item.price)">
		</md-input-container>
		</div>
		<md-icon aria-label="Remove Line" ng-click="remove($index)" class="md-secondary ion-trash-b text-muted"></md-icon>
	</md-list-item>
	<md-content class="bg-white" layout-padding>
		<div class="col-md-6">
		<md-button ng-click="add()" class="md-fab pull-left" ng-disabled="false" aria-label="Add Line">
			<md-icon class="ion-plus-round text-muted"></md-icon>
		</md-button>
		</div>
		<div class="col-md-6 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
			<div class="col-md-7">
				<div class="text-right text-uppercase text-muted">Sub Total:</div>
				<div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted">Total Discount:</div>
				<div ng-show="totaltax() > 0"class="text-right text-uppercase text-muted">Total Tax:</div>
				<div class="text-right text-uppercase text-black">Grand Total:</div>
			</div>
			<div class="col-md-5">
				<div class="text-right" ng-bind-html="subtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
				<div ng-show="linediscount() > 0" class="text-right" ng-bind-html="linediscount() | currencyFormat:cur_code:null:true:cur_lct"></div>
				<div ng-show="totaltax() > 0"class="text-right" ng-bind-html="totaltax() | currencyFormat:cur_code:null:true:cur_lct"></div>
				<div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
			</div>
		</div>
	</md-content>
	</md-content>
	<?php echo form_close(); ?>
	<script>
	var PROPOSALID = <?php echo $proposal['id']; ?>;
	</script>
	</div>
	<?php include_once( APPPATH . 'views/inc/sidebar.php' );?>
	
</div>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/summernote/summernote.css"/>
<script src="<?php echo base_url(); ?>assets/lib/summernote/summernote.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$( document ).ready( function () {
		App.init();
		App.textEditors();
	} );
</script>