<!DOCTYPE html>
<html ng-app="Ciuis" lang="<?php echo lang('lang_code');?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="With TInatar CRM you can easily manage your customer relationships and save time on your business.">
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/logo-fav.png'); ?>">
	<title><?php echo $title; ?></title>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url('assets/lib/angular/angular.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/angular-animate.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/angular-aria.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/i18n/angular-locale_'.lang('lang_code_dash').'.js'); ?>"></script>
   	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ciuis.css'); ?>" type="text/css"/>
	<script>var BASE_URL = "<?php echo base_url(); ?>",ACTIVESTAFF = "<?php echo $this->session->userdata('usr_id'); ?>",SHOW_ONLY_ADMIN = "<?php if (!if_admin) {echo 'true';} else echo 'false';?>",CURRENCY = "<?php echo currency ?>",LOCATE_SELECTED = "<?php echo lang('lang_code');?>",UPIMGURL = "<?php echo base_url('uploads/images/'); ?>",IMAGESURL = "<?php echo base_url('assets/img/'); ?>",SETFILEURL = "<?php echo base_url('uploads/ciuis_settings/') ?>",NTFTITLE = "<?php echo lang('notification')?>",EVENTADDEDMSG = "<?php echo lang('eventadded')?>",TODOADDEDMSG = "<?php echo lang('todoadded')?>",TODODONEMSG = "<?php echo lang('tododone')?>",REMINDERREAD = "<?php echo lang('remindermarkasread')?>",INVMARKCACELLED = "<?php echo lang('invoicecancelled')?>",TICKSTATUSCHANGE = "<?php echo lang('ticketstatuschanced')?>",LEADMARKEDAS = "<?php echo lang('leadmarkedas')?>",LEADUNMARKEDAS = "<?php echo lang('leadunmarkedas')?>",TODAYDATE = "<?php echo date('Y.m.d ')?>",LOGGEDINSTAFFID = "<?php echo $this->session->userdata('usr_id'); ?>",LOGGEDINSTAFFNAME = "<?php echo $this->session->userdata('staffname'); ?>",LOGGEDINSTAFFAVATAR = "<?php echo $this->session->userdata('staffavatar'); ?>",VOICENOTIFICATIONLANG = "<?php echo lang('lang_code_dash');?>",initialLocaleCode = "<?php echo lang('initial_locale_code');?>";</script>
</head>
<?php $settings = $this->Settings_Model->get_settings_ciuis(); ?>
<body ng-controller="Ciuis_Controller">
<div id="ciuisloader"></div>
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
		<li ng-repeat="nav in navbar  | orderBy:'order_id'"><a href="{{nav.url}}" ng-bind="nav.name"></a>
		  <ul ng-show="nav.sub_menu.length">
			<li ng-repeat="submenu in nav.sub_menu | orderBy:'order_id'">
			  <a ng-href="{{submenu.url}}">
			  <i class="icon {{submenu.icon}}"></i>
			  <span class="title" ng-bind="submenu.name"></span>
			  <span class="descr" ng-bind="submenu.description"></span>
			  </a>
			</li>
		  </ul>
		</li>
		</ul>
		<!-- NAVBAR MENU -->
		<md-button ng-hide="ONLYADMIN != 'true'" class="md-icon-button" ng-href="<?php echo base_url('settings') ?>" aria-label="Settings">
			<md-tooltip md-direction="left"><?php echo lang('settings') ?></md-tooltip>
			<md-icon><i class="ion-gear-a text-muted"></i></md-icon>
		</md-button>
		<md-button ng-click="Todo()" class="md-icon-button" aria-label="Todo">
			<md-tooltip md-direction="left"><?php echo lang('todo') ?></md-tooltip>
			<md-icon><i class="ion-clipboard text-muted"></i></md-icon>
		</md-button>
		<md-button ng-click="Notifications()" class="md-icon-button" aria-label="Notifications">
			<md-tooltip md-direction="left"><?php echo lang('notifications') ?></md-tooltip>
			<div ng-show="stats.newnotification == true" class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
			<md-icon><i class="ion-ios-bell text-muted"></i></md-icon>
		</md-button>
		<md-button ng-click="Profile()" class="md-icon-button avatar-button-ciuis" aria-label="User Profile">
			<img height="100%" ng-src="<?php echo base_url('uploads/images/{{user.avatar}}')?>" class="md-avatar" alt="{{user.name}}" />
		</md-button>
		<div ng-click="Profile()" md-truncate class="user-informations hidden-xs">
			<span class="user-name-in" ng-bind="user.name"></span><br>
			<span class="user-email-in"><?php echo $this->session->userdata('email'); ?></span>
		</div>
	</div>
</md-toolbar>
<md-content id="mobile-menu" class="" style="left: 0px; opacity: 1; display: none">
	<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<div flex md-truncate class="crm-name"><span ng-bind="settings.crm_name"></span></div>
			<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
				<md-icon><i class="ion-close-circled text-muted"></i></md-icon>
			</md-button>
		</div>
	</md-toolbar>
	<md-content class="mobile-menu-box bg-white">
		<div class="mobile-menu-wrapper-inner">
			<div class="mobile-menu-wrapper">
				<div class="mobile-menu-slider" style="left: 0px;">
					<div class="mobile-menu">
						<ul>
							<li ng-repeat="menu in menu" class="nav-item" ng-if="menu.show_staff == '0'">
							<div class="mobile-menu-item"><a href="{{menu.url}}" ng-bind="menu.title"></a></div>
							</li>
						</ul>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</md-content>
</md-content>
<md-content class="ciuis-body-left-sidebar hidden-xs hidden-sm">
	<md-content class="vertical-nav-new-ciuis narrow hover">
	<div class="branding">
	  <div class="symbol">
		<a id="ciuis-logo-donder" href="{{appurl}}panel"><img width="34px" height="34px" ng-src="<?php echo base_url('uploads/ciuis_settings/{{applogo}}')?>" on-error-src="<?php echo base_url('assets/img/placeholder.png')?>"></a>
	  </div>
	  <div class="text ciuis-ver-menu-brand" ng-bind="settings.crm_name"></div>
	</div>
	<div class="primary-nav">
		<div class="slide one navigation">
			<div class="nav-top">   
				<div class="nav-list">
					<a ng-repeat="menu in menu" href="{{menu.url}}" class="nav-item">
						<div class="icon"><i class="material-icons {{menu.icon}}"></i></div>
						<div class="text" ng-bind="menu.title"></div>
					</a> 
				</div>
			</div>
			<div class="nav-bottom">
				<div class="nav-list">
					<a href="{{appurl}}tasks" class="nav-item active">
						<div class="icon"><i class="material-icons ico-ciuis-tasks"></i></div>
						<div class="text text-uppercase"><?php echo lang('tasks');?></div>
					</a> 
				</div>
				<div ng-repeat="pinned in projects | limitTo:1" class="profile-util">
					<div class="chart">
					 <div class="donut">
						<desc><progress max="100" value="{{pinned.progress}}"></progress></desc>
					 </div>
					</div>
					<div class="text"><a href="<?php echo base_url('projects/project/{{pinned.id}}')?>" ng-bind="pinned.name"></a></div>
				 </div>
			</div>
		</div>
		<div class="slide two apps inactive">
		</div>
	</div>
	</md-content>
</md-content>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="EventForm">
	<md-toolbar class="md-theme-light" style="background:#262626">
		  <div class="md-toolbar-tools">
			<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
				 <i class="ion-android-arrow-forward"></i>
			</md-button>
			<md-truncate><?php echo lang('addevent')?></md-truncate>
		  </div>
		</md-toolbar>
	<md-content layout-padding="">
		<md-content layout-padding>
			<md-input-container class="md-block">
				<label><?php echo lang('title'); ?></label>
				<input ng-model="event_title">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('start'); ?></label>
				<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="event_start" class=" dtp-no-msclear dtp-input md-input">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('end') ?></label>
				<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="event_end" class=" dtp-no-msclear dtp-input md-input">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('description') ?></label>
				<textarea required name="detail" ng-model="event_detail" placeholder="Type something" class="form-control note-description"></textarea>
			</md-input-container>
			<div class="ciuis-body-checkbox has-primary pull-left">
				<input ng-model="event_public" name="public" class="ci-public-check" id="public" type="checkbox" value="1">
				<label for="public"><?php echo lang('publicevent');?></label>
			</div>
			<div class="pull-right">
				 <md-button ng-click="AddEvent()"> <?php echo lang('addevent')?></md-button>
			</div>
		</md-content>
	 </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Todo">
	<md-content layout-padding="">
		<md-content layout-padding="">
		<md-input-container class="md-icon-float md-icon-right md-block">
		  	<input ng-model="tododetail" placeholder="Type an to do!" class="tododetail">
			<md-icon ng-click="AddTodo()" class="ion-ios-checkmark"></md-icon>
		</md-input-container>
			<h4 md-truncate class=" text-muted text-uppercase"><strong><?php echo lang('new') ?></strong></h4>
			<md-content layout-padding="">
			<md-divider></md-divider>
				<ul class="todo-item">
					<li ng-repeat="todo in todos" class="todo-alt-item todo">
						<div class="todo-c" style="display: grid;margin-top: 10px;">
							<div class="todo-item-header">
								<div class="btn-group-sm btn-space pull-right">
									<button data-id='{{todo.id}}' ng-click='TodoAsDone($index)' class="btn btn-default btn-sm ion-checkmark"></button>
									<button data-id='{{todo.id}}' ng-click='DeleteTodo($index)' class="btn btn-default btn-sm ion-trash-a"></button>
								</div>
								<span style="padding:5px;" class="pull-left label label-default" ng-bind="todo.date | date : 'MMM d, y h:mm:ss a'"></span>
							</div>
							<label ng-bind="todo.description"></label>
						</div>
					</li>
				</ul>
			</md-content>
			<h4 md-truncate class=" text-success"><strong><?php echo lang('donetodo') ?></strong></h4>
			<md-content layout-padding="">
			<md-divider></md-divider>
				<ul class="todo-item-done">
					<li ng-class="{ 'donetodo-x' : todo.done }" ng-repeat="done in tododone" class="todo-alt-item-done todo">
						<div class="todo-c" style="display: grid;margin-top: 10px;">
							<div class="todo-item-header">
								<div class="btn-group-sm btn-space pull-right">
									<button data-id='{{todo.id}}' ng-click='TodoAsUnDone($index)' class="btn btn-default btn-sm ion-refresh"></button>
								</div>
								<span style="padding:5px;" class="pull-left label label-success" ng-bind="done.date | date : 'MMM d, y h:mm:ss a'"></span>
							</div>
							<label ng-bind="done.description"></label>
						</div>
					</li>
				</ul>
			</md-content>
		</md-content>
	 </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Notifications">
	<md-toolbar class="toolbar-white">
		  <div class="md-toolbar-tools">
			<md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
			<md-truncate><?php echo lang('notifications')?></md-truncate>
			<md-button class="md-mini" aria-label="Undread Notifications"><span ng-bind="stats.tbs"></span></md-button>
		  </div>
		</md-toolbar>
	<md-content>
	<md-list flex>
		<md-list-item class="md-3-line" ng-repeat="ntf in notifications" ng-click="NotificationRead($index)" ng-class="{new_notification: ntf.read == true}" aria-label="Read">
			<img ng-src="<?php echo base_url('uploads/images/{{ntf.avatar}}')?>" class="md-avatar" alt="NTF" />
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
			<img style="border-radius: 50%; box-shadow: 0 0 20px 0px #00000014;" height="100px" width="auto" ng-src="<?php echo base_url('uploads/images/{{user.avatar}}')?>" class="md-avatar" alt="{{user.name}}" />
			<h3><strong ng-bind="user.name"></strong></h3><br>
			<span ng-bind="user.email"></span>
		</md-content>
		<md-content class="md-mt-30">
			<md-button ng-href="<?php echo base_url('staff/staffmember/{{activestaff}}'); ?>" class="md-raised"><?php echo lang('profile')?></md-button>
      		<md-button ng-href="<?php echo base_url('login/logout');?>" class="md-raised"><?php echo lang('logout')?></md-button>
		</md-content>
		<md-content layout-padding>
			<md-switch ng-model="appointment_availability" ng-change="ChangeAppointmentAvailability(user.id,appointment_availability)" aria-label="Status"><strong class="text-muted"><?php echo lang('appointment_availability') ?></strong></md-switch>
		</md-content>
	</md-content>
</md-sidenav>
<md-content class="ciuis-body-wrapper ciuis-body-fixed-sidebar" ciuis-ready>