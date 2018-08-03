
<div class="ciuis-body-content" ng-controller="Staffs_Controller">
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
	<div class="row">
	  <div class="col-md-4" ng-repeat="member in staff">
		<div class="user-display">
		  <div class="user-display-bg"><img src="<?php echo base_url('assets/img/staffmember_bg.png'); ?>" alt="Avatar"></div>
		  <div class="user-display-bottom">
			<div class="user-display-avatar"><img src="<?php echo base_url('uploads/images/{{member.avatar}}'); ?>" alt="Avatar"></div>
			<div class="user-display-info">
			  <div class="name"><a href="<?php echo site_url('staff/staffmember/{{member.id}}'); ?>" ng-bind="member.name"></a></div>
			  <div class="nick"><span class="mdi mdi-accounts-list-alt"></span> <span ng-bind="member.department"></span></div>
			</div>
		  </div>
		</div>
	  </div>          
	</div>		
</div>
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
	<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
		<h2 class="md-pl-10" flex md-truncate><?php echo lang('departments') ?></h2>
		<md-button ng-click="NewDepartment()" class="md-icon-button" aria-label="Department">
			<md-tooltip md-direction="bottom"><?php echo lang('adddepartment') ?></md-tooltip>
			<md-icon><i class="ion-android-add text-muted"></i></md-icon>
		</md-button>
		<md-button ng-click="Create()" class="md-icon-button" aria-label="Create">
			<md-tooltip md-direction="bottom"><?php echo lang('addstaff') ?></md-tooltip>
			<md-icon><i class="ion-person-add text-muted"></i></md-icon>
		</md-button>
		</div>
  	</md-toolbar>
  	<md-content class="bg-white">
		<md-list flex class="md-p-0 sm-p-0 lg-p-0">
			<md-list-item ng-repeat="department in departments" ng-click="EditDepartment($index)" aria-label="Project">
				<p><strong ng-bind="department.name"></strong></p>
				<md-button ng-click="DeleteDepartment($index)" class="md-icon-button" aria-label="Create">
					<md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
					<md-icon><i class="ion-trash-b text-muted"></i></md-icon>
				</md-button>
			<md-divider></md-divider>
			</md-list-item>
		</md-list>
		<md-content ng-show="!departments.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
	</md-content>
</div>		
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	 <h2 flex md-truncate><?php echo lang('create') ?></h2>
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
		<md-input-container class="md-block password-input">
			<label><?php echo lang('password') ?></label>
			<input type="text" ng-model="passwordNew" rel="gp" data-size="9" id="nc" data-character-set="a-z,A-Z,0-9,#">
			<md-icon ng-click="getNewPass()" class="ion-refresh" style="display:inline-block;"></md-icon>
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
			  <md-button ng-click="AddStaff()" class="md-raised md-primary pull-right"><?php echo lang('add');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
</div>