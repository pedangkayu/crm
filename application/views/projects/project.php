<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Project_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-content class="bg-white">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<md-progress-circular md-mode="determinate" value="{{project.progress}}" class="md-hue-2" md-diameter="20px"></md-progress-circular>
					<h2 class="md-pl-10" flex md-truncate ng-bind="project.name"></h2>
					<md-button ng-show="project.authorization === 'true'" ng-click="Convert()" class="md-icon-button" aria-label="Convert">
						<md-tooltip md-direction="bottom"><?php echo lang('convertinvoice') ?></md-tooltip>
						<md-icon><i class="ion-loop text-success"></i></md-icon>
					</md-button>
					<md-button ng-show="project.authorization === 'true'" ng-click="Delete()" class="md-icon-button" aria-label="Delete">
						<md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
						<md-icon><i class="ion-trash-b text-muted"></i></md-icon>
					</md-button>
					<md-button ng-show="project.authorization === 'true'" ng-click="NewTask()" class="md-icon-button" aria-label="Task">
						<md-tooltip md-direction="bottom"><?php echo lang('addtask') ?></md-tooltip>
						<md-icon><i class="mdi mdi-collection-plus	 text-muted"></i></md-icon>
					</md-button>													
					<div class="project-actions pull-right">
						<div ng-show="project.authorization === 'true'" class="btn-group pull-right">
							<md-button class="md-icon-button dropdown-toggle md-primary" aria-label="Actions" data-toggle="dropdown" aria-expanded="false">
								<md-icon class="ion-android-more-vertical action-button-ciuis"></md-icon>
							</md-button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#" ng-click="Update()"><?php echo lang('updateproject');?></a></li>
								<li><a href="#" ng-click="NewMilestone()"><?php echo lang('addmilestone'); ?></a></li>
								<li><a href="#" ng-click="NewExpense()"><?php echo lang('newexpense') ?></a></li>
								<li class="divider"></li>
								<li data-sname="<?php echo lang('notstarted') ?>" data-status="1" data-project="{{project.id}}">
									<a class="mark-as-p" href="#"><?php echo lang('markasprojectnotstarted') ?></a>
								</li>
								<li data-sname="<?php echo lang('started') ?>" data-status="2" data-project="{{project.id}}">
									<a class="mark-as-p" href="#"><?php echo lang('markasprojectstarted') ?></a>
								</li>
								<li data-sname="<?php echo lang('percentage') ?>" data-status="3" data-project="{{project.id}}">
									<a class="mark-as-p" href="#"><?php echo lang('markasprojectpercentage') ?></a>
								</li>
								<li data-sname="<?php echo lang('cancelled') ?>" data-status="4" data-project="{{project.id}}">
									<a class="mark-as-p" href="#"><?php echo lang('markasprojectcancelled') ?></a>
								</li>
								<li data-sname="<?php echo lang('complete') ?>" data-status="5" data-project="{{project.id}}">
									<a class="mark-as-p" href="#"><?php echo lang('markasprojectcomplete') ?></a>
								</li>
							</ul>
						</div>
					</div>
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
				<md-tab label="<?php echo lang('milestones') ?>">
					<md-content class="md-padding bg-white">
						<article class="project_milestone_detail">
							<ul class="milestone_project">
								<li ng-repeat="milestone in milestones" class="milestone_project-milestone {{milestone.status}}">
									<div class="milestone_project-action is-expandable expanded">
										<div ng-click="ShowMilestone($index)" class="edit-milestone ion-ios-compose"></div>
										<div ng-click='RemoveMilestone($index)' class="remove-milestone ion-trash-b"></div>
										<h2 class="milestonetitle" ng-bind="milestone.name"></h2>
										<span class="milestonedate" ng-bind="milestone.duedate"></span>
										<div class="content">
											<div ng-repeat="task in milestone.tasks" class="milestone-todos-list">
												<ul class="all-milestone-todos">
													<li ng-class="{'done' : task.status == 4}" class="milestone-todos-list-item col-md-12">
														<span class="pull-left col-md-5"><strong ng-bind="task.name"></strong><br><small ng-bind="task.name"></small></span>
														<div class="col-md-7">
															<div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('startdate') ?> <i class="ion-ios-stopwatch-outline"></i></small><br><strong ng-bind="task.startdate"></strong></span>
															</div>
															<div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('duedate') ?> <i class="ion-ios-timer-outline"></i></small><br><strong ng-bind="task.duedate"></strong></span>
															</div>
															<div class="col-md-4">
															<span class="date-start-task">
															<small class="text-muted"><?php echo lang('status') ?> <i class="ion-ios-flag"></i></small><br>
															<strong ng-if="task.status_id == '1' "><?php echo lang('open') ?></strong>
															<strong ng-if="task.status_id == '2' "><?php echo lang('inprogress') ?></strong>
															<strong ng-if="task.status_id == '3' "><?php echo lang('waiting') ?></strong>
															<strong ng-if="task.status_id == '4' "><?php echo lang('complete') ?></strong>
															</span>
															</div>
															<div class="col-md-2">
																<a ng-href="<?php echo base_url('/tasks/task/')?>{{task.id}}" class="edit-task pull-left"><i class="ion-android-open"></i></a>
															</div>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</article>
					</md-content>
				</md-tab>
				<md-tab label="<?php echo lang('tasks') ?>">
					<md-content class="md-padding bg-white">
						<div class="col-md-3 col-xs-6 border-right">
							<div class="tasks-status-stat">
								<h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number" ng-bind="(project.tasks | filter:{status_id:'1'}).length"></span>
							 <span class="task-stat-all text-uppercase" ng-bind="'/'+' '+project.tasks.length+' '+'<?php echo lang('task') ?>'"></span></h3>
								<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(project.tasks | filter:{status_id:'1'}).length * 100 / project.tasks.length }}%;"></span> </span>
							</div>
							<span class="text-uppercase" style="color:#989898">
								<?php echo lang('open') ?>
							</span>
						</div>
						<div class="col-md-3 col-xs-6 border-right">
							<div class="tasks-status-stat">
								<h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number" ng-bind="(project.tasks | filter:{status_id:'2'}).length"></span>
							  <span class="task-stat-all text-uppercase" ng-bind="'/'+' '+project.tasks.length+' '+'<?php echo lang('task') ?>'"></span></h3>
								<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(project.tasks | filter:{status_id:'2'}).length * 100 / project.tasks.length }}%;"></span> </span>
							</div>
							<span class="text-uppercase" style="color:#989898">
								<?php echo lang('inprogress') ?>
							</span>
						</div>
						<div class="col-md-3 col-xs-6 border-right">
							<div class="tasks-status-stat">
								<h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number" ng-bind="(project.tasks | filter:{status_id:'3'}).length"></span><span class="task-stat-all text-uppercase" ng-bind="'/'+' '+project.tasks.length+' '+'<?php echo lang('task') ?>'"></span></h3>
								<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(project.tasks | filter:{status_id:'3'}).length * 100 / project.tasks.length }}%;"></span> </span>
							</div>
							<span class="text-uppercase" style="color:#989898">
								<?php echo lang('waiting') ?>
							</span>
						</div>
						<div class="col-md-3 col-xs-6 border-right">
							<div class="tasks-status-stat">
								<h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number" ng-bind="(project.tasks | filter:{status_id:'4'}).length"></span><span class="task-stat-all text-uppercase" ng-bind="'/'+' '+project.tasks.length+' '+'<?php echo lang('task') ?>'"></span></h3>
								<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(project.tasks | filter:{status_id:'4'}).length * 100 / project.tasks.length }}%;"></span> </span>
							</div>
							<span class="text-uppercase" style="color:#989898">
								<?php echo lang('complete') ?>
							</span>
						</div>
						<hr ng-show="!project.tasks.length">
						<md-content ng-show="!project.tasks.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
						<div class="col-md-12">
						<div ng-repeat="projecttask in project.tasks" class="milestone-todos-list">
						  <ul class="all-milestone-todos">
							<li class="milestone-todos-list-item col-md-12 {{projecttask.done}}">
							<span class="pull-left col-md-5"><strong ng-bind="projecttask.name"></strong><br><small ng-bind="projecttask.name"></small></span>
								<div class="col-md-7">
								<div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('startdate') ?> <i class="ion-ios-stopwatch-outline"></i></small><br><strong ng-bind="projecttask.startdate"></strong></span></div>
								<div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('duedate') ?> <i class="ion-ios-timer-outline"></i></small><br><strong ng-bind="projecttask.duedate"></strong></span></div>
								<div class="col-md-4"><span class="date-start-task">
								<small class="text-muted"><?php echo lang('status') ?> <i class="ion-ios-flag"></i></small><br>
								<strong ng-bind="projecttask.status"></strong>
								</span>
								</div>
								<div class="col-md-2">
								<a ng-href="<?php echo base_url('/tasks/task/')?>{{projecttask.id}}" class="edit-task pull-left"><i class="ion-android-open"></i></a>
								</div>
								</div>
							</li>
						 </ul>
						</div>
						</div>
					</md-content>
				</md-tab>
				<md-tab label=" <?php echo lang('notes') ?>">
					<md-content class="md-padding bg-white">
						<section class="ciuis-notes show-notes">
							<article ng-repeat="note in notes" class="ciuis-note-detail">
								<div class="ciuis-note-detail-img">
									<img src="<?php echo base_url('assets/img/note.png') ?>" alt="" width="50" height="50"/>
								</div>
								<div class="ciuis-note-detail-body">
									<div class="text">
										<p>
											<span ng-bind="note.description"></span>
											<a ng-click='DeleteNote($index)' style="cursor: pointer;" class="mdi ion-trash-b pull-right delete-note-button"></a>
										</p>

									</div>
									<p class="attribution">
										<?php echo lang('addedby') ?> <strong><a href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}" ng-bind="note.staff"></a></strong>
										<?php echo lang('at') ?> <span ng-bind="note.date"></span>
									</p>
								</div>
							</article>
						</section>
						<section class="md-pb-30">
							<md-input-container class="md-block">
							<label><?php echo lang('description') ?></label>
							<textarea required name="description" ng-model="note" placeholder="Type something" class="form-control note-description"></textarea>
							</md-input-container>
							<div class="form-group pull-right">
								<button ng-click="AddNote()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane" type="submit"> <?php echo lang('addnote')?></button>
							</div>
						</section>
					</md-content>
				</md-tab>
				<md-tab label="<?php echo lang('timelogs') ?>">
					<md-content ng-show="!timelogs.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
					<md-content class="bg-white">
						<ul class="timelog-list">
						  <li class="timelog-list-item" ng-repeat="timelog in timelogs" ng-class="{ 'timelog-list-item--active' : timelog.status == 0 }">
							<div class="timelog-list-item__clock">
							  <div class="timelog-list-item__bar"></div>
							  <i class="ion-android-time"></i>
							  <span ng-show="timelog.status != '0'"><strong ng-bind="timelog.timed | time:'mm':'hhh mmm':false"></strong></span>
							  <span ng-show="timelog.status != '1'"><strong>N/A</strong></span>
							</div>
							<div class="timelog-list-item__info">
							  <h3 class="timelog-list-item__description"><strong ng-bind="timelog.staff"></strong></h3>
							  <span class="timelog-list-item__details"><strong class="text-uppercase text-black"><?php echo lang('start') ?>: <span class="text-muted" ng-bind="timelog.start"></span></strong> | <strong class="text-uppercase text-black"><?php echo lang('end') ?>: <span class="text-muted" ng-bind="timelog.end"></strong></span></span>
							  <span ng-show="timelog.status != '0'" class="timelog-list-item__chargeable-status"><strong ng-bind-html="timelog.amount | currencyFormat:cur_code:null:true:cur_lct"></strong></span>
							  <span ng-show="timelog.status != '1'" class="timelog-list-item__chargeable-status"><strong ng-bind-html="0| currencyFormat:cur_code:null:true:cur_lct"></strong></span>
							</div>
						  </li>
						</ul>
					</md-content>
				</md-tab>
				<md-tab label="<?php echo lang('expenses') ?>">
					<md-content class="md-padding bg-white">
						<article class="expenses-project">
							<ul class="custom-ciuis-list-body" style="padding: 0px;">
								<li ng-repeat="expense in expenses" i class="ciuis-custom-list-item ciuis-special-list-item lead-name">
									<ul class="list-item-for-custom-list">
										<li class="ciuis-custom-list-item-item col-md-12">
											<div data-toggle="tooltip" data-placement="bottom" data-container="body" title="" data-original-title="<?php echo lang('addedby'); ?> {{expense.staff}}" class="assigned-staff-for-this-lead user-avatar"><i class="ion-document" style="font-size: 32px"></i>
											</div>
											<div class="pull-left col-md-4">
												<a class="ciuis_expense_receipt_number" href="<?php echo base_url('expenses/receipt/') ?>{{expense.id}}"><strong ng-bind="expense.prefix + '-' + expense.longid"></strong></a><br>
												<small ng-bind="expense.title"></small>
											</div>
											<div class="col-md-8">
												<div class="col-md-5">
													<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('amount'); ?></small><br><strong ng-bind-html="expense.amount | currencyFormat:cur_code:null:true:cur_lct"><span>
											<span ng-show="expense.billable != 'false'" class="label label-{{expense.color}}" ng-bind="expense.billstatus"></span>
													</span>
													</strong>
													</span>
												</div>
												<div class="col-md-4">
													<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('category'); ?></small><br><strong ng-bind="expense.category"></strong>
											</div>
											<div class="col-md-3">
											<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('date'); ?></small><br><strong><span class="badge" ng-bind="expense.date"></span>
													</strong>
													</span>
												</div>
											</div>
										</li>
									</ul>
								</li>
							</ul>
						</article>
					</md-content>
					<md-content ng-show="!expenses.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
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
			<md-button ng-click="InsertMember()" ng-show="project.authorization === 'true'" class="md-icon-button md-primary" aria-label="Add Member">
				<md-icon class="ion-person-add"></md-icon>
			</md-button>
		</div>
	</md-toolbar>
	<div class="project-assignee">
		<div id="ciuis-customer-contact-detail">
			<div ng-if="project.authorization === 'false'" role="alert" class="alert alert-warning alert-icon alert-dismissible">
				<div class="icon"><span class="mdi mdi-block-alt"></span></div>
				<div class="message">
				<button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button><?php echo lang('notauthorized') ?>
				</div>
			</div>
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
	<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<md-button class="md-icon-button" aria-label="Invoice" ng-disabled="true">
			  <md-icon><i class="ion-document text-muted"></i></md-icon>
			</md-button>
			<h2 flex md-truncate><?php echo lang('files') ?></h2>					
			<md-button ng-click="UploadFile()" ng-show="project.authorization === 'true'" class="md-icon-button md-primary" aria-label="Add File">
				<md-icon class="ion-plus-round add-file"></md-icon>
			</md-button>
		</div>
	</md-toolbar>
	<md-content class="bg-white">
	<md-list flex>
	<md-list-item class="md-2-line" ng-repeat="file in files">
	  <div class="md-list-item-text">
		<h3 ng-bind="file.name"></h3>
		<p ng-bind-html="file.amount | currencyFormat:cur_code:null:true:cur_lct"></p>
	  </div>
	  <md-button ng-href="<?php echo base_url('uploads/files/{{file.name}}');?>" class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click="doSecondaryAction($event)" aria-label="call">
		<md-icon class="ion-android-download"></md-icon>
	  </md-button>
	   <md-button class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click='DeleteFile($index)' aria-label="call">
		<md-icon class="ion-trash-b"></md-icon>
	  </md-button>
	  <md-divider></md-divider>
	</md-list-item>
	<div ng-show="!files.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
	</md-list>
	</md-content>
</div>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update">
  <md-toolbar class="md-theme-light" style="background:#262626">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('updateprojectinformations') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('name') ?></label>
			<input required type="text" ng-model="project.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('customer'); ?></label>
			<md-select required placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="project.customer_id" name="customer" style="min-width: 200px;">
				<md-option ng-value="customer.id" ng-repeat="customer in all_customers">{{customer.name}}</md-option>
			</md-select>
        </md-input-container>
		<md-input-container>
            <label><?php echo lang('startdate') ?></label>
            <md-datepicker name="start" ng-model="project.start"></md-datepicker>
        </md-input-container>
        <md-input-container>
            <label><?php echo lang('deadline') ?></label>
            <md-datepicker name="deadline" ng-model="project.deadline"></md-datepicker>
        </md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required name="description" ng-model="project.description" placeholder="Type something" class="form-control"></textarea>
		</md-input-container>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="UpdateProject()" class="md-raised md-primary pull-right"><?php echo lang('update');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewMilestone">
  <md-toolbar class="md-theme-light" style="background:#262626">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('addmilestone') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('name') ?></label>
			<input required type="text" ng-model="milestone.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('duedate') ?></label>
			<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="milestone.duedate" class=" dtp-no-msclear dtp-input md-input">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required name="description" ng-model="milestone.description" placeholder="Type something" class="form-control"></textarea>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('milestoneorder') ?></label>
			<input required type="text" ng-model="milestone.order" class="form-control" id="title" placeholder="0"/>
		</md-input-container>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="AddMilestone()" class="md-raised md-primary pull-right"><?php echo lang('add');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewTask">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('addtask') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('name') ?></label>
			<input required type="text" ng-model="newtask.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('hourlyrate') ?></label>
			<input type="text" ng-model="newtask.hourlyrate" class="form-control" id="title" placeholder="0.00"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('startdate') ?></label>
			<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="newtask.startdate" class=" dtp-no-msclear dtp-input md-input">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('duedate') ?></label>
			<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="newtask.duedate" class=" dtp-no-msclear dtp-input md-input">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('assigned'); ?></label>
			<md-select required ng-model="newtask.assigned" name="assigned" style="min-width: 200px;">
				<md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
			</md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('priority'); ?></label>
			<md-select ng-init="priorities = [{id: 1,name: '<?php echo lang('low'); ?>'}, {id: 2,name: '<?php echo lang('medium'); ?>'}, {id: 3,name: '<?php echo lang('high'); ?>'}];" required placeholder="<?php echo lang('priority'); ?>" ng-model="newtask.priority" name="priority" style="min-width: 200px;">
				<md-option ng-value="priority.id" ng-repeat="priority in priorities"><span class="text-uppercase">{{priority.name}}</span></md-option>
			</md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('milestone'); ?></label>
			<md-select ng-model="newtask.milestone" name="assigned" style="min-width: 200px;">
				<md-option ng-value="milestone.id" ng-repeat="milestone in project.milestones">{{milestone.name}}</md-option>
			</md-select>
        </md-input-container>
        <br>
		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required name="description" ng-model="newtask.description" placeholder="Type something" class="form-control"></textarea>
		</md-input-container>
		<md-switch ng-model="isPublic" aria-label="Type"><strong class="text-muted"><?php echo lang('public') ?></strong></md-switch>
		<md-switch ng-model="isBillable" aria-label="Type"><strong class="text-muted"><?php echo lang('billable') ?></strong></md-switch>
		<md-switch ng-model="isVisible" aria-label="Type"><strong class="text-muted"><?php echo lang('visiblecustomer') ?></strong></md-switch>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="AddTask()" class="md-raised md-primary pull-right"><?php echo lang('add');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewExpense">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('addexpense') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('title') ?></label>
			<input required type="text" ng-model="newexpense.title" class="form-control" id="title" placeholder="<?php echo lang('title'); ?>"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('amount') ?></label>
			<input required type="text" ng-model="newexpense.amount" class="form-control" id="amount" placeholder="0.00"/>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('date') ?></label>
			<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="newexpense.date" class=" dtp-no-msclear dtp-input md-input">
		</md-input-container>
		<md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('category'); ?></label>
			<md-select required ng-model="newexpense.category" name="category" style="min-width: 200px;">
				<md-option ng-value="category.id" ng-repeat="category in expensescategories">{{category.name}}</md-option>
			</md-select>
        </md-input-container>
        <br>
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('account'); ?></label>
			<md-select required ng-model="newexpense.account" name="account" style="min-width: 200px;">
				<md-option ng-value="account.id" ng-repeat="account in accounts">{{account.name}}</md-option>
			</md-select>
        </md-input-container>
        <br>
		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required name="description" ng-model="newexpense.description" placeholder="Type something" class="form-control"></textarea>
		</md-input-container>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="AddExpense()" class="md-raised md-primary pull-right"><?php echo lang('add');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
<script type="text/ng-template" id="insert-member-template.html">
  <md-dialog aria-label="options dialog">
	<md-dialog-content layout-padding>
	  <h2 class="md-title"><?php echo lang('assigned'); ?></h2>
		<md-select required ng-model="insertedStaff" style="min-width: 200px;" aria-label="AddMember">
			<md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
		</md-select>
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
	  <md-button ng-click="AddProjectMember()"><?php echo lang('add') ?>!</md-button>
	</md-dialog-actions>
  </md-dialog>
</script>
<script type="text/ng-template" id="addfile-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('projects/add_file/'.$projects['id'].'',array("class"=>"form-horizontal")); ?>
	<md-dialog-content layout-padding>
		<h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
		<input type="file" name="file_name">
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
	  <md-button type="submit"><?php echo lang('add') ?>!</md-button>
	</md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<div style="visibility: hidden">
<div ng-repeat="milestone in milestones" class="md-dialog-container" id="ShowMilestone-{{milestone.id}}">
<md-dialog aria-label="Milestone Detail">
  <form>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2><?php echo lang('update') ?> {{milestone.name}}</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="close()">
          <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-dialog-content style="max-width:800px;max-height:810px; ">
    	<md-content class="bg-white" layout-padding>
    	<md-input-container class="md-block">
			<label><?php echo lang('name') ?></label>
			<input required type="text" ng-model="milestone.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
		</md-input-container>
   		<md-input-container class="md-block">
			<label><?php echo lang('duedate') ?></label>
			<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="milestone.duedate" class=" dtp-no-msclear dtp-input md-input">
		</md-input-container>
   		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required ng-model="milestone.description" placeholder="Type something" class="form-control note-description"></textarea>
		</md-input-container>
   		<md-input-container class="md-block">
			<label><?php echo lang('milestone_order') ?></label>
			<input required type="text" ng-model="milestone.order" class="form-control" id="title" placeholder="<?php echo lang('order'); ?>"/>
		</md-input-container>
    	</md-content>     
    </md-dialog-content>
    <md-dialog-actions layout="row">
      <md-button ng-click="UpdateMilestone($index)" style="margin-right:20px;" aria-label="Update">
        <?php echo lang('update')?> <i class="ion-checkmark-round"></i>
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>
</div>
</div>



</div>
<script> var PROJECTID = "<?php echo $projects['id'];?>"; </script>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>