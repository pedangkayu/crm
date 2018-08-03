<!DOCTYPE html>
<html ng-app="Ciuis" lang="<?php echo lang('lang_code'); ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="With Ciuis CRM you can easily manage your customer relationships and save time on your business.">
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/logo-fav.png'); ?>">
	<title><?php echo $title; ?></title>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url('assets/lib/angular/angular.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/angular-animate.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/angular-aria.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/i18n/angular-locale_en-us.js'); ?>"></script>
   	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ciuis.css'); ?>" type="text/css"/>
	<script>
      var BASE_URL = "<?php echo base_url(); ?>";
      var ACTIVESTAFF = "<?php echo $_SESSION[ 'logged_in' ] ?>";
	  var HAS_MENU_PERMISSION = "false";
	  var SHOW_ONLY_ADMIN = "false";
    </script>
</head>
<?php $settings = $this->Settings_Model->get_settings_ciuis(); ?>
<?php $newnotification = $this->Area_Model->newnotification(); ?>
<body ng-controller="Area_Controller">
<div id="ciuisloaderl"></div>
<md-toolbar class="toolbar-ciuis-top">
	<div class="md-toolbar-tools">
		<!-- CRM NAME -->
		<div md-truncate class="crm-name"><span ng-bind="settings.crm_name"></span></div>
		<md-button ng-click="OpenMenu()" class="md-icon-button hidden-lg hidden-md" aria-label="Menu">
			<md-tooltip md-direction="left"><?php echo lang('menu') ?></md-tooltip>
			<md-icon><i class="ion-navicon-round text-muted"></i></md-icon>
		</md-button>
		<!-- CRM NAME -->
		<!-- NAVBAR MENU -->
		<ul flex class="ciuis-v3-menu hidden-xs">
		<li ng-repeat="nav in areamenu"><a href="{{nav.url}}" ng-bind="nav.title"></a></li>
		</ul>
		<md-button ng-click="Appointment()" class="md-icon-button" aria-label="Appointment">
			<md-tooltip md-direction="left"><?php echo lang('new_appointment') ?></md-tooltip>
			<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
		</md-button>
		<md-button ng-click="Notifications()" class="md-icon-button" aria-label="Notifications">
			<md-tooltip md-direction="left"><?php echo lang('notifications') ?></md-tooltip>
			<div ng-show="stats.newnotification == true" class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
			<md-icon><i class="ion-ios-bell text-muted"></i></md-icon>
		</md-button>
		<md-button ng-click="Profile()" class="md-icon-button avatar-button-ciuis" aria-label="User Profile">
			<img height="100%" ng-src="<?php echo base_url('assets/img/customer_avatar.png'); ?>" class="md-avatar"/>
		</md-button>
		<div ng-click="Profile()" md-truncate class="user-informations hidden-xs">
			<span class="user-name-in"><?php echo $_SESSION[ 'name' ] ?> <?php echo $_SESSION[ 'surname' ] ?></span><br>
			<span class="user-email-in"><?php echo $this->session->userdata('email'); ?></span>
		</div>
	</div>
</md-toolbar>
<md-content class="ciuis-body-left-sidebar">
	<md-content class="vertical-nav-new-ciuis narrow hover">
	<div class="branding">
		   <div class="symbol">
			<a id="ciuis-logo-donder" href="{{appurl}}area"><img width="34px" height="34px" src="<?php echo base_url('uploads/ciuis_settings/') ?>{{settings.logo}}" alt=""></a>
		  </div>
		  <div class="text ciuis-ver-menu-brand" ng-bind="settings.crm_name"></div>
		</div>
		<div class="primary-nav">
			<div class="slide one navigation">
				<div class="nav-top">   
					<div class="nav-list">
						<a ng-repeat="menu in areamenu" href="{{menu.url}}" class="nav-item">
							<div class="icon">
								<i class="material-icons {{menu.icon}}"></i>
							</div>
							<div class="text" ng-bind="menu.title"></div>
						</a> 
					</div>
				</div>
			</div>
			<div class="slide two apps inactive">
			</div>
		</div>
	</md-content>
</md-content>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Notifications">
	<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
			<md-truncate><?php echo lang('notifications')?></md-truncate>
			<md-button class="md-mini" aria-label="Undread Notifications"><span ng-bind="notifications.length"></span></md-button>
		  </div>
	</md-toolbar>
	<md-content>
	<md-list flex>
		<md-list-item class="md-3-line" ng-repeat="ntf in notifications" ng-click="NotificationRead($index)" ng-class="{new_notification: ntf.read == true}" aria-label="Read" ng-href="{{ntf.target}}">
			<img ng-src="<?php echo base_url('assets/img/reminder.png')?>" class="md-avatar" alt="NTF" />
			<div class="md-list-item-text" layout="column">
				<h4 ng-bind="ntf.detail"></h4>
				<p ng-bind="ntf.date"></p>
			</div>
		</md-list-item>
	</md-list>
	</md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Profile">
	<md-content class="text-center">
		<md-content layout-padding class="md-mt-20" style="line-height: 0px;">
			<img style="border-radius: 50%; box-shadow: 0 0 20px 0px #00000014;" height="100px" width="auto" ng-src="<?php echo base_url('assets/img/customer_avatar.png'); ?>" class="md-avatar"/>
			<h3><strong><?php echo $_SESSION[ 'name' ] ?> <?php echo $_SESSION[ 'surname' ] ?></strong></h3><br>
			<span><?php echo $this->session->userdata('email'); ?></span>
		</md-content>
		<md-content class="md-mt-30">
      		<md-button ng-href="<?php echo base_url('area/logout');?>" class="md-raised"><?php echo lang('logout')?></md-button>
		</md-content>
	</md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Appointment">
	<md-toolbar class="md-theme-light" style="background:#262626">
		  <div class="md-toolbar-tools">
			<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
				 <i class="ion-android-arrow-forward"></i>
			</md-button>
			<md-truncate><?php echo lang('new_appointment')?></md-truncate>
		  </div>
		</md-toolbar>
	<md-content layout-padding="">
		<md-content layout-padding ng-show="available_staff.length">
			<md-input-container class="md-block">
				<label><?php echo lang('date'); ?></label>
				<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="appointment.date" class=" dtp-no-msclear dtp-input md-input">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('note') ?></label>
				<textarea name="detail" ng-model="appointment.note" placeholder="Type something" class="form-control note-description"></textarea>
			</md-input-container>
			<md-input-container class="md-block" flex-gt-xs>
				<label><?php echo lang('staff'); ?></label>
				<md-select required ng-model="appointment.staff" name="staff" style="min-width: 200px;">
					<md-option ng-value="staff.id" ng-repeat="staff in available_staff">{{staff.name}}</md-option>
				</md-select>
			</md-input-container>
			<div class="pull-right">
				 <md-button ng-click="ConfirmAppointment()"> <?php echo lang('confirm')?></md-button>
			</div>
		</md-content>
		<md-content ng-hide="available_staff.length" class="md-padding text-center">
		<h1 style="font-size: 6em" class="ion-sad-outline text-danger"></h1>
		<span><?php echo lang('no_available_staff') ?></span>
		</md-content>
	 </md-content>
</md-sidenav>
<md-content class="ciuis-body-wrapper ciuis-body-fixed-sidebar" ciuis-ready>