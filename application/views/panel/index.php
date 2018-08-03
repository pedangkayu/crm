
<div class="ciuis-body-content">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9 hidden-sm hidden-md hidden-lg" ng-hide="ONLYADMIN != 'true'">
		<?php include(APPPATH . 'views/inc/widgets/panel_bottom_summary.php'); ?>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9 hidden-sm hidden-md hidden-lg" ng-hide="ONLYADMIN != 'false'">
		<?php include(APPPATH . 'views/inc/widgets/panel_bottom_summary_staff.php'); ?>
		
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-content class="bg-white ciuis-home-summary-top">
			<div class="col-md-3 col-sm-3 col-lg-3 nopadding">
			<md-toolbar class="toolbar-white" style="border-right:1px solid #e0e0e0">
				<div class="md-toolbar-tools">
					<h4 class="text-muted" flex md-truncate ><strong><?php echo lang('panelsummary'); ?></strong></h4>					
					<md-button class="md-icon-button" aria-label="Actions">
						<md-icon><span class="ion-flag text-muted"></span></md-icon>
					</md-button>
				</div>
			</md-toolbar>
				<md-content class="bg-white ciuis-summary-two">
					<div class="ciuis-dashboard-box-b1-xs-ca-body">
							<div class="ciuis-dashboard-box-stats ciuis-dashboard-box-stats-main">
								<div class="ciuis-dashboard-box-stats-amount" ng-bind="stats.otc"></div>
								<div class="ciuis-dashboard-box-stats-caption" ng-bind="stats.newticketmsg"></div>
								<div class="ciuis-dashboard-box-stats-change">
									<div class="ciuis-dashboard-box-stats-value ciuis-dashboard-box-stats-value--positive" ng-bind="'+' + stats.twt">+</div>
									<div class="ciuis-dashboard-box-stats-period"><?php echo lang('thisweek'); ?></div>
								</div>
							</div>
							<div class="ciuis-dashboard-box-stats">
								<div class="ciuis-dashboard-box-stats-amount" ng-bind="stats.yms"></div>
								<div class="ciuis-dashboard-box-stats-caption" ng-bind="stats.newcustomermsg"></div>
								<div class="ciuis-dashboard-box-stats-change">
									<div class="ciuis-dashboard-box-stats-value ciuis-dashboard-box-stats-value-negative ion-refresh"></div>
								</div>
							</div>
						</div>
					<div class="hidden-xs" ng-hide="ONLYADMIN != 'true'" ng-controller="Chart_Controller">
						<h4 class="text-center"><?php echo lang('monthlyexpenses'); ?></h4>
					<div id="monthlyexpenses" style="height: 145px;display: block;bottom: 14px;position: absolute;width: 100%;border-bottom-left-radius: 5px;"></div>
					</div>
				</md-content>
			</div>
			<div class="col-sm-9 xs-p-0">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<h4 class="text-muted" flex md-truncate ><strong><?php echo lang('welcome') ?></strong></h4>
					<md-button ng-click="EventForm()" class="md-icon-button" aria-label="Event">
						<md-tooltip md-direction="bottom"><?php echo lang('addevent') ?></md-tooltip>
						<md-icon><i class="mdi mdi-calendar-note	text-muted"></i></md-icon>
					</md-button>					
				</div>
			</md-toolbar>
				<md-content layout-padding class="bg-white ciuis-summary-two">
					<div class="brr-5 trr-5" ng-hide="ONLYADMIN != 'true'">
						<div class="col-sm-4 nopadding">
							<div class="col-md-12 nopadding">
								<div class="hpanel stats">
									<div style="padding-top: 0px;line-height: 0.99;margin-right: 10px;" class="panel-body h-200 xs-p-0">
										<div class="col-md-12 xs-mb-20 md-pl-0">
											<h3 style="font-size:27px;line-height: 0.8;font-weight: 500;" class="no-margins font-extra-bold text-warning">
											<span  ng-bind-html="stats.bkt | currencyFormat:cur_code:null:true:cur_lct"></span>
											</h3>
											<small><strong><?php echo lang('todayssales'); ?></strong></small>
											<div class="pull-right text-{{stats.todaysalescolor}}"><strong ng-bind="stats.todayrate+'%'"><i class="{{stats.todayicon}}"></i></strong></div>
										</div>
										<div class="col-md-12 nopadding md-pt-10 xs-pt-20" style="border-top: 1px solid #e0e0e0;">
										<div class="stats-title"><h4 style="font-weight: 500;color: #c7cbd5;"><?php echo lang('netcashflow'); ?></h4></div>
											<h3 style="font-weight: 500;" class="m-b-xs"><span  ng-bind-html="stats.netcashflow | currencyFormat:cur_code:null:true:cur_lct"></span></h3>
											<div style="height: 10px" class="progress">
											  <div style="font-size: 7px;line-height: 10px;width:{{stats.inp}}%" class="progress-bar progress-bar-success progress-bar-striped" ng-bind="stats.inp+'%'"> <?php echo lang('incomings'); ?><span class="sr-only"><?php echo lang('incomings'); ?></span></div>
											  <div style="font-size: 7px;line-height: 10px;width:{{stats.ogp}}%" class="progress-bar progress-bar-danger progress-bar-striped" ng-bind="stats.ogp+'%'"> <?php echo lang('outgoings'); ?><span class="sr-only"><?php echo lang('outgoings'); ?></span></div>
											</div>
											<div class="row">
												<div class="col-xs-6">
													<small class="stats-label text-uppercase text-bold text-success"><?php echo lang('incomings'); ?></small>
													<h4  ng-bind-html="stats.pay | currencyFormat:cur_code:null:true:cur_lct"></h4>
												</div>

												<div class="col-xs-6">
													<small class="stats-label text-uppercase text-bold text-danger"><?php echo lang('outgoings'); ?></small>
													<h4  ng-bind-html="stats.exp | currencyFormat:cur_code:null:true:cur_lct"></h4>
												</div>
											</div>
											<?php echo lang('cashflowdetail'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr class="hidden-sm hidden-md hidden-lg">
						<div class="col-sm-8 nopadding">
							<div class="widget widget-fullwidth ciuis-body-loading">
								<div class="widget-chart-container">
									<div class="widget-counter-group widget-counter-group-right">
										<div class="pull-left">
											<div class="pull-left text-left">
												<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('weeklygraphtitle'); ?></b></h4>
												<small><?php echo lang('weeklygraphdetailtext'); ?></small>
											</div>
										</div>
										<div class="counter counter-big">
											<div class="text-warning value">
											<span  ng-bind-html="stats.bht | currencyFormat:cur_code:null:true:cur_lct"></span>
											</div>
											<div class="desc"><?php echo lang('thisweek'); ?></div>
										</div>
										<div class="counter counter-big">
											<div class="value"><span class="text-{{stats.weekstat}}" ng-bind="stats.weekrate+'%'"></span></div>
											<div class="desc" ng-bind="stats.weekratestatus"></div>
										</div>
									</div>
									<div class="my-2" ng-controller="Chart_Controller">
										<div class="chart-wrapper" style="height:235px;">
											<canvas id="main-chart" height="235px"></canvas>
										</div>
									</div>
								</div>
								<div class="ciuis-body-spinner">
									<svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
										<circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
									</svg>
								</div>
							</div>
						</div>
					</div>
					<div class="brr-5 trr-5" ng-hide="ONLYADMIN != 'false'">
						<div class="col-sm-4 nopadding">
							<div class="col-md-12 nopadding">
								<div class="hpanel stats">
									<div style="padding-top: 0px;line-height: 0.99;margin-right: 10px;" class="panel-body h-200 xs-p-0">
										<div class="col-md-12 xs-mb-20 md-pl-0" style="line-height: 28px;">
										<div class="col-md-12 text-center">
										<p><img ng-src="<?php echo base_url('assets/img/{{stats.dayimage}}')?>" on-error-src="<?php echo base_url('assets/img/placeholder.png')?>"></p>
										<h4 ng-bind="stats.daymessage"></h4>
										<span ng-bind="user.staffname"></span>
										</div>
										<div class="col-md-12  md-pt-10 xs-pt-20 text-center" style="border-top: 1px solid #e0e0e0;"><?php echo lang('haveaniceday') ?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr class="hidden-sm hidden-md hidden-lg">
						<div class="col-sm-8 nopadding">
							<div class="panel panel-default">
							<div class="panel-body" style="height: 400px; overflow: scroll; zoom: 0.8; margin-top: 25px; box-shadow: inset 0px 17px 50px 10px #ffffff; overflow-y: scroll;">
								<ul class="user-timeline user-timeline-compact">
									<li ng-repeat="todo in todos" class="latest">
										<div class="user-timeline-title" ng-bind="todo.date"></div>
										<div class="user-timeline-description" ng-bind="todo.description"></div>
									</li>
								</ul>
							</div>
						</div>
						</div>
					</div>
				</md-content>
			</div>
		</md-content>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9 hidden-xs" ng-hide="ONLYADMIN != 'true'">
	<?php include(APPPATH . 'views/inc/widgets/panel_bottom_summary.php'); ?>
		
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9 hidden-xs" ng-hide="ONLYADMIN != 'false'">
	<?php include(APPPATH . 'views/inc/widgets/panel_bottom_summary_staff.php'); ?>
		
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
	
</div>
