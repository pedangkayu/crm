
<div class="ciuis-body-content" ng-controller="Staff_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
		<div class="user-profile">
			<div class="row">
				<div class="col-md-4">
					<div class="user-display">
						<div class="user-display-bg"><img ng-src="<?php echo base_url('assets/img/staffmember_bg.png'); ?>"></div>
						<div class="user-display-bottom" >
							<div class="user-display-avatar"><img ng-src="<?php echo base_url('uploads/images/{{staff.avatar}}')?>"></div>
							<div class="user-display-info">
								<div class="name" ng-bind="staff.name"></div>
								<div class="nick"><span class="mdi mdi-account"></span> <span ng-bind="staff.properties.department"></span></div>
							</div>
						</div>
						<md-divider></md-divider>
						<md-content class="bg-white">
						  <md-list flex class="md-p-0 sm-p-0 lg-p-0">
								<md-list-item>
									<md-icon class="mdi mdi-case"></md-icon>
									<p ng-bind="staff.properties.department"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi mdi-cake"></md-icon>
									<p ng-bind="staff.birthday">dd</p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="ion-android-call"></md-icon>
									<p ng-bind="staff.phone"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi ion-location"></md-icon>
									<p ng-bind="staff.address"></p>
								</md-list-item>
								<md-divider></md-divider>
								<md-list-item>
									<md-icon class="mdi ion-android-mail"></md-icon>
									<p ng-bind="staff.email"></p>
								</md-list-item>
							</md-list>
						</md-content>
						<md-divider></md-divider>
						<md-content class="md-padding bg-white">
							<div class="col-xs-4">
								<div class="title"><?php echo lang('sales')?></div>
								<div class="counter"><strong ng-bind-html="staff.properties.sales_total | currencyFormat:cur_code:null:true:cur_lct"></strong></div>
							</div>
							<div class="col-xs-4">
								<div class="title"><?php echo lang('customers')?></div>
								<div class="counter"><strong ng-bind="staff.properties.total_customer"></strong></div>
							</div>
							<div class="col-xs-4">
								<div class="title"><?php echo lang('tickets')?></div>
								<div class="counter"><strong ng-bind="staff.properties.total_ticket"></strong></div>
							</div>
						</md-content>
					</div>
				</div>
				<div class="col-md-8">
				<md-toolbar class="toolbar-white">
					<div class="md-toolbar-tools">
						<h2 class="md-pl-10" flex md-truncate><?php echo lang('staffdetail') ?></h2>
						<md-button ng-hide="ONLYADMIN != 'true'" ng-click="Update()" class="md-icon-button" aria-label="Update">
							<md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
							<md-icon><i class="ion-compose	text-muted"></i></md-icon>
						</md-button>
						<md-button ng-hide="ONLYADMIN != 'true'" ng-click="Privileges()" class="md-icon-button" aria-label="Privileges">
							<md-tooltip md-direction="bottom">Privileges</md-tooltip>
							<md-icon><i class="mdi mdi-run	text-muted"></i></md-icon>
						</md-button>
						<md-menu md-position-mode="target-right target" ng-hide="ONLYADMIN != 'true'">
						  <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
							<md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
						  </md-button>
						  <md-menu-content width="4">
							<md-menu-item>
								 <md-button ng-click="ChangePassword()">
								  <div layout="row" flex>
									<p flex><?php echo lang('changepassword') ?></p>
									<md-icon md-menu-align-target class="ion-locked" style="margin: auto 3px auto 0;"></md-icon>
								  </div>
								 </md-button>
							</md-menu-item>
							<md-menu-item>
								 <md-button ng-click="ChangeAvatar()">
								  <div layout="row" flex>
									<p flex><?php echo lang('changeprofilepicture') ?></p>
									<md-icon md-menu-align-target class="ion-android-camera" style="margin: auto 3px auto 0;"></md-icon>
								  </div>
								 </md-button>
							</md-menu-item>
							<md-menu-item>
								 <md-button ng-click="Delete()">
								  <div layout="row" flex>
									<p flex><?php echo lang('delete') ?></p>
									<md-icon md-menu-align-target class="ion-trash-b" style="margin: auto 3px auto 0;"></md-icon>
								  </div>
								 </md-button>
							</md-menu-item>
						  </md-menu-content>
						</md-menu>						
					</div>
				</md-toolbar>
				<md-content class="bg-white">
					<div ng-hide="ONLYADMIN != 'true'" style="margin-top: 10px;margin-bottom: 30px;" class="col-md-12">
							<div class="widget-chart-container">
								<div class="widget-counter-group widget-counter-group-right">
									<div class="pull-left md-mb-10">
										<div class="pull-left text-left">
											<h4><b><?php echo lang('staffsalesgraphtitle')?></b></h4>
											<small><?php echo lang('staffsalesgraphdescription')?></small>
										</div>
									</div>
									<div class="counter counter-big">
										<div class="text-warning value" ng-bind-html="staff.properties.sales_total | currencyFormat:cur_code:null:true:cur_lct"></div>
										<div class="desc"><?php echo lang('inthisyear')?></div>
									</div>
								</div>
								<div class="md-mb-20">
									<div class="chart-wrapper" style="height:270px">
										<canvas id="staff_sales_chart" height="270px"></canvas>
									</div>
								</div>
							</div>
						</div>
				</md-content>
				<md-divider></md-divider>
				<md-content class="bg-white">
				<md-tabs md-dynamic-height md-border-bottom>
					<md-tab label="<?php echo lang('invoices');?>">
						<md-content class="bg-white">
						<md-list flex class="md-p-0 sm-p-0 lg-p-0">
							<md-list-item ng-repeat="invoice in invoices" ng-click="GoInvoice($index)" aria-label="Invoice">
								<md-icon class="ico-ciuis-invoices"></md-icon>
								<p><strong ng-bind="invoice.prefix+'-'+invoice.longid"></strong></p>
								<h4><strong ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
							<md-divider></md-divider>
							</md-list-item>
						</md-list>
						<md-content ng-show="!invoices.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
					</md-content>
				  	</md-tab>
			  		<md-tab label="<?php echo lang('proposals');?>">
						<md-content class="bg-white">
						<md-list flex class="md-p-0 sm-p-0 lg-p-0">
							<md-list-item ng-repeat="proposal in proposals" ng-click="GoProposal($index)" aria-label="Proposal">
								<md-icon class="ico-ciuis-proposals"></md-icon>
								<p><strong ng-bind="proposal.prefix+'-'+proposal.longid"></strong></p>
								<h4><strong ng-bind-html="proposal.total | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
							<md-divider></md-divider>
							</md-list-item>
						</md-list>
						<md-content ng-show="!proposals.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
					</md-content>
				 	</md-tab>
				 	<md-tab label="<?php echo lang('tickets');?>">
						<md-content class="bg-white">
						<md-list flex class="md-p-0 sm-p-0 lg-p-0">
							<md-list-item ng-repeat="ticket in tickets" ng-click="GoTicket($index)" aria-label="Ticket">
								<md-icon class="ico-ciuis-supports"></md-icon>
								<p><strong ng-bind="ticket.subject"></strong></p>
								<p><strong ng-bind="ticket.contactname"></strong></p>
								<h4><strong ng-bind="ticket.priority"></strong></h4>
							<md-divider></md-divider>
							</md-list-item>
						</md-list>
						<md-content ng-show="!tickets.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
					</md-content>
				 	</md-tab>
				</md-tabs>
				</md-content>
				</div>
			</div>
		</div>
	</div>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	 <h2 flex md-truncate><?php echo lang('update') ?></h2>
	 <md-switch ng-model="staff.active" aria-label="Type"><strong class="text-muted"><?php echo lang('active') ?></strong></md-switch>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('name') ?></label>
			<input required type="text" ng-model="staff.name" class="form-control" id="title"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('email') ?></label>
			<input required type="text" ng-model="staff.email" class="form-control" id="title"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('phone') ?></label>
			<input required type="text" ng-model="staff.phone" class="form-control" id="title"/>
		</md-input-container>
		<md-input-container>
			<label><?php echo lang('staffbirthday') ?></label>
			<md-datepicker ng-model="staff.birthday"></md-datepicker>
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
			<label><?php echo lang('staffdepartment'); ?></label>
			<md-select required ng-model="staff.department_id" name="assigned" style="min-width: 200px;">
				<md-option ng-value="department.id" ng-repeat="department in departments">{{department.name}}</md-option>
			</md-select><br>
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
			<label><?php echo lang('language'); ?></label>
			<md-select required ng-model="staff.language" name="assigned" style="min-width: 200px;">
				<md-option ng-value="language.foldername" ng-repeat="language in languages">{{language.name}}</md-option>
			</md-select><br>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('address') ?></label>
			<textarea required ng-model="staff.address" class="form-control"></textarea>
		</md-input-container>
		<md-switch ng-model="staff.admin" aria-label="Admin"><strong class="text-muted"><?php echo lang('staffadmin') ?></strong></md-switch>
		<md-switch ng-model="staff.staffmember" aria-label="Staff"><strong class="text-muted"><?php echo lang('staff') ?></strong></md-switch>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="UpdateStaff()" class="md-raised md-primary pull-right"><?php echo lang('update');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Privileges">
<form method="POST" action="<?php echo base_url('staff/update_privileges/'.$staff['id'].'')?>">
 	<md-toolbar class="toolbar-white">
 		<div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	 <h2 flex md-truncate><?php echo lang('privileges') ?></h2>
	 <md-button type="submit" class="md-icon-button" aria-label="UpdatePrivileges">
	 	<md-tooltip md-direction="left"><?php echo lang('updateprivileges') ?></md-tooltip>
	 	<md-icon><i class="ion-checkmark-circled text-muted"></i></md-icon>
	</md-button>
  </div>
  	</md-toolbar>
  	<md-content layout-padding="">
		<ul class="settings-list">
		 	<?php $arr = array();$id = $staff['id'];foreach($privileges as $privilege) {if($privilege['staff_id'] == $id) {array_push($arr, $privilege['permission_id']);}}?>
            <?php foreach($permissions as $permission) { ?>
			<li>
				<div class="switch-button switch-button-md switch-button-success">
				  <input type="checkbox" name="permissions[]" value="<?php echo $permission['id']?>"  <?php echo ( array_search($permission['id'], $arr) !== FALSE) ? "checked" : ""  ?> id="<?php echo $permission['id']?>"><span>
					<label for="<?php echo $permission['id']?>"></label></span>
				</div>
				<span class="name"><strong><?php echo lang($permission['permission']) ?></strong></span>
			</li>
		 	<?php } ?>
		</ul>
 	</md-content>
 </form>
</md-sidenav>
<script type="text/ng-template" id="change-avatar-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('staff/change_avatar/'.$staff['id'].'',array("class"=>"form-horizontal")); ?>
	<md-dialog-content layout-padding>
		<h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
		<input type="file" name="file_name">
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
	  <md-button type="submit"><?php echo lang('okay') ?>!</md-button>
	</md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
</div>
<script> var STAFFID = "<?php echo $staff['id'];?>"</script>
