<?php include_once(APPPATH . 'views/area/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Project_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-content class="bg-white">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<md-progress-circular md-mode="determinate" value="{{project.progress}}" class="md-hue-2" md-diameter="20px"></md-progress-circular>
					<h2 class="md-pl-10" flex md-truncate ng-bind="project.name"></h2>
				</div>
			</md-toolbar>
			<md-content class="bg-white">
				<div id="project-details" class="on-schedule">
					<div id="top-details" class="has-due-date">
						<div>
							<h5><?php echo lang('deadline') ?></h5>
							<h3 ng-bind="project.deadline"></h3>
						</div>
						<div>
							<h5><?php echo lang('status') ?> <span class="status-indicator on-schedule"></span></h5>
							<h3 class="on-schedule" ng-bind="project.status"></h3>
						</div>
						<div>
							<h5><?php echo lang('totaltime') ?></h5>
							<h3 ng-bind="getTotal() | time:'mm':'hhh mmm':false"></h3>
						</div>
						<div>
							<h5><?php echo lang('billed') ?></h5>
							<h3><span ng-bind="project.billed"></span> 
							<a ng-hide="project.billed != '<?php echo lang( 'yes' ) ?>'" class="label label-success" href="<?php echo base_url('invoices/invoice/'.$projects['invoice_id'].'')?>"><?php echo lang('invoiceprefix'),'-',str_pad($projects['invoice_id'], 6, '0', STR_PAD_LEFT) ?></a></h3>
						</div>
						<div>
							<h5><?php echo lang('amount') ?></h5>
							<h3><span ng-bind-html="ProjectTotalAmount() | currencyFormat:cur_code:null:true:cur_lct"></span></h3>
						</div>
						<div>
							<h5><?php echo lang('opentasks') ?></h5>
							<h3 ng-bind="project.opentasks"></h3>
						</div>
					</div>
				</div>
			</md-content>
			<md-tabs md-dynamic-height md-border-bottom>
				<md-tab label="<?php echo lang('summary') ?>">
					<h4 layout-padding class="m-xs text-success text-bold" ng-bind="project.customer"></h4>
					<md-divider></md-divider>
					<md-content class="md-padding bg-white">
						<div class="col-md-2 col-xs-4">
							<div class="left-days">
								<h4><strong ng-bind="project.ldt"></strong> <i class="ion-ios-stopwatch-outline"></i></h4>
								<small class="stat-label text-muted">
									<?php echo lang('daysleft') ?>
								</small>
							</div>
						</div>
						<div class="col-md-2 col-xs-4">
							<h4><span><span ng-bind="project.progress+'%'"></span></span></h4>
							<small class="stat-label">
								<?php echo lang('progresscompleted') ?>
							</small>
						</div>
						<div class="col-md-2 col-xs-4">
							<h4><span><span ng-bind="100 - project.progress+'%'"></span></span> <i class="ion-ios-copy text-success"></i></h4>
							<small class="stat-label">
								<?php echo lang('progressuncompleted') ?>
							</small>
						</div>
						<div class="col-md-2 col-xs-4">
							<h4><span><span ng-bind-html="TotalExpenses() | currencyFormat:cur_code:null:true:cur_lct"></span></span></h4>
							<small class="stat-label">
								<?php echo lang('totalexpenses') ?>
							</small>
						</div>
						<div class="col-md-2 col-xs-4">
							<h4><span><span ng-bind-html="BilledExpensesTotal() | currencyFormat:cur_code:null:true:cur_lct"></span></span> <i class="ion-ios-copy text-success"></i></h4>
							<small class="stat-label">
								<?php echo lang('billedexpenses') ?>
							</small>
						</div>
						<div class="col-md-2 col-xs-4">
							<h4><span><span ng-bind-html="UnBilledExpensesTotal() | currencyFormat:cur_code:null:true:cur_lct"></span></span> <i class="ion-alert text-danger"></i></h4>
							<small class="stat-label">
								<?php echo lang('unbilledexpenses') ?>
							</small>
						</div>				  
					</md-content>
					<md-content class="md-padding bg-white">
				  	<md-divider></md-divider>
						<h2><?php echo lang('description') ?></h2>
						<p ng-bind="project.description"></p>
				  	</md-content>
				</md-tab>
				<md-tab label="<?php echo lang('timelogs') ?>">
					<md-content class="md-padding bg-white">
						<article class="time-log-project">
							<div class="panel panel-default panel-table">
								<div class="panel-body" style="overflow: scroll;height: 410px;">
									<table id="table2" class="table table-striped table-hover table-fw-widget">
										<thead>
											<tr>
												<th>
													<?php echo lang('id') ?> </th>
												<th>
													<?php echo lang('start') ?> </th>
												<th>
													<?php echo lang('end') ?> </th>
												<th>
													<?php echo lang('staff') ?> </th>
												<th>
													<?php echo lang('timed') ?> </th>
												<th>
													<?php echo lang('amount') ?> </th>
											</tr>
										</thead>
										<tr ng-repeat="timelog in timelogs">
											<td ng-bind="timelog.id"></td>
											<td ng-bind="timelog.start"></td>
											<td ng-bind="timelog.end"></td>
											<td ng-bind="timelog.staff"></td>
											<td ng-bind="timelog.timed | time:'mm':'hhh mmm':false"></td>
											<td><span><span ng-bind-html="timelog.amount | currencyFormat:cur_code:null:true:cur_lct"></span></span>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</article>
					</md-content>
				</md-tab>
				<md-tab label="<?php echo lang('projectactivities') ?>">
					<md-content class="md-padding bg-white">
						<ul class="user-timeline">
							<li ng-repeat="log_project in project.project_logs">
								<div class="user-timeline-title" ng-bind="log_project.date"></div>
								<div class="user-timeline-description" ng-bind="log_project.detail|trustAsHtml"></div>
							</li>
						</ul>
					</md-content>
				</md-tab>
			</md-tabs>
		</md-content>
	</div>
<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 project-sidebar">
	<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<md-button class="md-icon-button" aria-label="Member" ng-disabled="true">
			  <md-icon><i class="ion-ios-people text-muted"></i></md-icon>
			</md-button>
			<h2 flex md-truncate><?php echo lang('peopleonthisprojects') ?></h2>					
		</div>
	</md-toolbar>
	<div class="project-assignee">
		<div id="ciuis-customer-contact-detail">
			<div data-linkid="{{member.id}}" ng-repeat="member in project.members" class="ciuis-customer-contacts">
				<div data-toggle="modal" data-target="#contactmodal1">
					<img width="40" height="40" src="{{UPIMGURL}}{{member.staffavatar}}" alt="">
					<div style="padding: 16px;position: initial;">
						<strong ng-bind="member.staffname"></strong>
						<br>
						<span ng-bind="member.email"></span>
					</div>
					<div ng-show="project.authorization === 'true'" ng-click='UnlinkMember($index)' class="unlink">
					<i class="ion-ios-close-outline"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script> var PROJECTID = "<?php echo $projects['id'];?>"; </script>
<?php include_once(APPPATH . 'views/area/inc/footer.php'); ?>