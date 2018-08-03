
<div class="ciuis-body-content" ng-controller="Task_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<h2 class="md-pl-10" flex md-truncate ng-bind="task.name"></h2>	
				<md-button ng-if="task.billable != false" ng-show="task.timer == false && task.relation_type === 'project'" ng-click='startTimerforTask()' class="md-icon-button" aria-label="Task">
					<md-tooltip md-direction="bottom"><?php echo lang('starttimer') ?></md-tooltip>
					<md-icon><i class="mdi mdi-time-countdown text-success"></i></md-icon>
				</md-button>
				<md-button ng-if="task.billable != false" ng-show="task.timer == true" ng-click='stopTimerforTask()' class="md-icon-button" aria-label="Task">
					<md-tooltip md-direction="bottom"><?php echo lang('stoptimer') ?></md-tooltip>
					<md-icon><i class="mdi mdi-timer-off text-danger"></i></md-icon>
				</md-button>
				<md-button ng-click='MarkAsCompleteTask()' class="md-icon-button" aria-label="Task">
					<md-tooltip md-direction="bottom"><?php echo lang('markasprojectcomplete') ?></md-tooltip>
					<md-icon><i class="ion-checkmark-circled	text-muted"></i></md-icon>
				</md-button>
				<md-button ng-click="Update()" class="md-icon-button" aria-label="Task">
					<md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
					<md-icon><i class="ion-compose	text-muted"></i></md-icon>
				</md-button>
				<md-button ng-hide="ONLYADMIN != 'true'" ng-click='MarkAsCancelled()' class="md-icon-button" aria-label="Task">
					<md-tooltip md-direction="bottom"><?php echo lang('markascancelled') ?></md-tooltip>
					<md-icon><i class="ion-close-round	text-muted"></i></md-icon>
				</md-button>
				<md-button ng-hide="ONLYADMIN != 'true'" ng-click="Delete()" class="md-icon-button" aria-label="Task">
					<md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
					<md-icon><i class="ion-trash-b	text-muted"></i></md-icon>
				</md-button>				
			</div>
		</md-toolbar>
		<md-content class="bg-white">
		<md-content class="task-detail bg-white" layout-padding>
			<div class="task-description" style="float: left; width: 100%;">
				<h4><strong><?php echo lang('description') ?></strong></h4>
				<p class="text-muted" ng-bind="task.description"></p>
			</div>
			<div class="clearfix"></div>
		</md-content>
		<md-divider></md-divider>
		<md-content class="ciuis-task-subtask bg-white">
			<div class="todo-checklist-container">
				<div class="ciuis-sub-task">
					<h2 class="mb0">{{title}}: {{subtasks.length + SubTasksComplete.length}} {{subtasks.length + SubTasksComplete.length === 1 ? 'task' : 'subtasks'}}</h2>
				</div>
				<div class="ciuis-sub-task  ciuis-sub-task--small  ciuis-sub-task--highlight">
					<span>{{ SubTasksComplete.length }} of {{ taskLength() }} ({{ taskCompletionTotal(SubTasksComplete.length) }}%) subtasks complete.</span>
				</div>
				<div class="progress">
					<div style="width: {{ taskCompletionTotal(SubTasksComplete.length) }}%" class="progress-bar progress-bar-success progress-bar-striped active" ng-bind="'Complete '+taskCompletionTotal(SubTasksComplete.length)+'%'"></div>
				</div>
				<ul class="subtask-items">
					<li class="subtask-list-item">
						<form name="addTask" ng-submit="createTask()" novalidate>
							<input class="input-ui" type="text" ng-model="newTitle" placeholder="Write a new task and hit enter..." ng-required/>
							<div class="pull-right">
								<button ng-hide="true" class="btn" type="submit" ng-disabled="addTask.$invalid"><?php echo lang('addtask') ?></button>
							</div>
						</form>
					</li>
					<li class="subtask-list-item" ng-repeat="task in subtasks">
						<span ng-bind="task.description"></span>
						<div class="pull-right">
							<div class="sub-task-button" href ng-click="removeTask($index)">
								<span class="ion-trash-b"></span>
							</div>
							<div class="sub-task-button" href ng-click="completeTask($index)">
								<span class="ion-checkmark-round"></span>
							</div>
						</div>
					</li>
					<li class="subtask-list-item" ng-class="{ 'subtask-status subtask-status--done' : task.complete }" ng-repeat="task in SubTasksComplete">
						<span ng-bind="task.description"></span>
						<div class="pull-right">
							<div class="sub-task-button" href ng-click="uncompleteTask($index)">
								<span class="ion-refresh"></span>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</md-content>
		<md-content ng-if="task.billable != false" class="time-log-project bg-white">
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
		</md-content>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0 lead-left-bar">
		<md-toolbar class="toolbar-white">
		  <div class="md-toolbar-tools">
			<md-button class="md-icon-button" aria-label="Task">
				<md-icon><i class="ion-android-clipboard text-muted"></i></md-icon>
			</md-button>
			<md-truncate><?php echo lang('information') ?></md-truncate>
		  </div>
		  </md-toolbar>
		<div class="col-md-12 col-xs-12 md-pr-0 md-pl-0 md-pb-10" style="background: white">
			<div class="col-xs-12 task-sidebar-item">
				<ul class="list-inline task-dates">
					<li class="col-md-6 col-xs-6" ng-show="task.relation_type == 'project'">
						<h5><?php echo lang('related') ?></h5>
						<strong class="text-bold"><a class="label label-info" href="<?php echo base_url('projects/project/{{task.relation}}')?>"><?php echo lang('project') ?> <i class="ion-android-open"></i></a></strong>
					</li>
					<li class="col-md-6 col-xs-6" ng-show="task.relation_type == 'ticket'">
						<h5><?php echo lang('related') ?></h5>
						<strong class="text-bold"><span class="label label-info"><?php echo lang('ticket') ?></span></strong>
					</li>
					<li class="col-md-6 col-xs-6">					
						<h5><?php echo lang('status') ?></h5>
						<strong ng-bind="task.status"></strong>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 task-sidebar-item">
				<ul class="list-inline task-dates">
					<li class="col-md-6 col-xs-6">
						<h5><?php echo lang('startdate') ?></h5>
						<strong ng-bind="task.startdate"></strong>
					</li>
					<li class="col-md-6 col-xs-6">
						<h5><?php echo lang('duedate') ?></h5>
						<strong ng-bind="task.duedate"></strong>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 task-sidebar-item">
				<ul class="list-inline task-dates">
					<li class="col-md-6 col-xs-6">
						<h5><?php echo lang('priority') ?></h5>
						<strong ng-bind="task.priority"></strong>
					</li>
					<li class="col-md-6 col-xs-6">
						<h5><?php echo lang('billable') ?></h5>
						<strong ng-hide="task.billable != true" class="text-bold label label-success"><?php echo lang('billable') ?></strong>
						<strong ng-hide="task.billable != false" class="text-bold label label-danger"><?php echo lang('unbillable') ?></strong>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 task-sidebar-item">
				<ul class="list-inline task-dates">
					<li class="col-md-6 col-xs-6">
						<h5><?php echo lang('assignedby') ?></h5>
						<span class="mdi mdi-assignment-account"></span> <strong ng-bind="task.staff"></strong>
					</li>
					<li class="col-md-6 col-xs-6">
						<h5><?php echo lang('createddate') ?></h5>
						<strong ng-bind="task.created"></strong>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 task-sidebar-item">
				<ul class="list-inline task-dates">
					<li class="col-md-6 col-xs-6">
						<h5><?php echo lang('hourlyrate') ?></h5>
						<strong ng-hide="task.billable != true"><span ng-bind-html="task.hourlyrate | currencyFormat:cur_code:null:true:cur_lct"></span></strong>
						<strong ng-hide="task.billable != false">NONE</strong>
					</li>
					<li class="col-md-6 col-xs-6">
						<h5><?php echo lang('totaltime') ?></h5>
						<strong ng-bind="getTotal() | time:'mm':'hhh mmm':false"></strong>
					</li>
				</ul>
			</div>
		</div>
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<md-button class="md-icon-button" aria-label="Files" ng-disabled="true">
				  <md-icon><i class="ion-document text-muted"></i></md-icon>
				</md-button>
				<h2 flex md-truncate><?php echo lang('files') ?></h2>					
				<md-button ng-click="UploadFile()" class="md-icon-button md-primary" aria-label="Add File">
					<md-icon class="ion-plus-round add-file"></md-icon>
				</md-button>
			</div>
		</md-toolbar>
		<md-content class="bg-white">
		<md-list flex>
		<md-list-item class="md-2-line" ng-repeat="file in files">
		  <div class="md-list-item-text">
			<h3 ng-bind="file.name"></h3>
		  </div>
		  <md-button ng-href="<?php echo base_url('uploads/files/{{file.name}}');?>" target="blank" class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click="doSecondaryAction($event)" aria-label="call">
			<md-icon class="ion-android-download"></md-icon>
		  </md-button>
		   <md-button class="md-secondary md-primary md-fab md-mini md-icon-button" ng-click='DeleteFile($index)' aria-label="call">
			<md-icon class="ion-trash-b"></md-icon>
		  </md-button>
		  <md-divider></md-divider>
		</md-list-item>
		</md-list>
		<md-content ng-show="!files.length" class="text-center bg-white"><img width="50%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></md-content>
		</md-content>
	</div>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update">
	  <md-toolbar class="toolbar-white">
	  <div class="md-toolbar-tools">
		<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
			 <i class="ion-android-arrow-forward"></i>
		</md-button>
		 <h2 flex md-truncate><?php echo lang('update') ?></h2>
		 <md-switch ng-model="task.billable" aria-label="Type"><strong class="text-muted"><?php echo lang('billable') ?></strong></md-switch>
	  </div>
	  </md-toolbar>
	  <md-content layout-padding="">
		<md-content layout-padding>
			<md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('relationtype'); ?></label>
			<md-select ng-init="relation_types = [{value: 'project',name: '<?php echo lang('project'); ?>'}, {value: 'ticket',name: '<?php echo lang('ticket'); ?>'}];" disabled placeholder="<?php echo lang('relationtype'); ?>" ng-model="task.relation_type" name="relationtype" style="min-width: 200px;">
				<md-option ng-value="relation_type.value" ng-repeat="relation_type in relation_types"><span class="text-uppercase">{{relation_type.name}}</span></md-option>
			</md-select><br>
			</md-input-container>
			<md-input-container ng-show="task.relation_type == 'project'" class="md-block" flex-gt-xs>
				<label><?php echo lang('project'); ?></label>
				<md-select  disabled ng-model="task.relation" name="relation" style="min-width: 200px;">
					<md-option ng-value="project.id" ng-repeat="project in projects">{{project.name}}</md-option>
				</md-select><br>
			</md-input-container>
			<md-input-container ng-show="task.milestone != 0" class="md-block" flex-gt-xs>
				<label><?php echo lang('milestone'); ?></label>
				<md-select disabled ng-model="task.milestone" name="relation" style="min-width: 200px;">
					<md-option ng-value="milestone.id" ng-repeat="milestone in task.project_data.milestones">{{milestone.name}}</md-option>
				</md-select><br>
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('name') ?></label>
				<input required type="text" ng-model="task.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
			</md-input-container>
			<md-input-container ng-hide="task.billable == false" class="md-block">
				<label><?php echo lang('hourlyrate') ?></label>
				<input required type="text" ng-model="task.hourlyrate" class="form-control" id="title" placeholder="0.00"/>
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('startdate') ?></label>
				<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="task.startdate" class=" dtp-no-msclear dtp-input md-input">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('duedate') ?></label>
				<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="task.duedate" class=" dtp-no-msclear dtp-input md-input">
			</md-input-container>
			<md-input-container class="md-block" flex-gt-xs>
				<label><?php echo lang('assigned'); ?></label>
				<md-select required ng-model="task.assigned" name="assigned" style="min-width: 200px;">
					<md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
				</md-select>
			</md-input-container>
			<br>
			<md-input-container class="md-block" flex-gt-xs>
				<label><?php echo lang('priority'); ?></label>
				<md-select ng-init="priorities = [{id: 1,name: '<?php echo lang('low'); ?>'}, {id: 2,name: '<?php echo lang('medium'); ?>'}, {id: 3,name: '<?php echo lang('high'); ?>'}];" required placeholder="<?php echo lang('priority'); ?>" ng-model="task.priority_id" name="priority" style="min-width: 200px;">
					<md-option ng-value="priority.id" ng-repeat="priority in priorities"><span class="text-uppercase">{{priority.name}}</span></md-option>
				</md-select>
			</md-input-container>
			<br>
			<md-input-container class="md-block" flex-gt-xs>
				<label><?php echo lang('status'); ?></label>
				<md-select ng-init="statuses = [{id: 1,name: '<?php echo lang('open'); ?>'}, {id: 2,name: '<?php echo lang('inprogress'); ?>'}, {id: 3,name: '<?php echo lang('waiting'); ?>'}, {id: 4,name: '<?php echo lang('complete'); ?>'}];" required placeholder="<?php echo lang('status'); ?>" ng-model="task.status_id" name="priority" style="min-width: 200px;">
					<md-option ng-value="status.id" ng-repeat="status in statuses"><span class="text-uppercase">{{status.name}}</span></md-option>
				</md-select>
			</md-input-container>
			<br>
			<br>
			<md-input-container class="md-block">
				<label><?php echo lang('description') ?></label>
				<textarea required name="description" ng-model="task.description" placeholder="Type something" class="form-control"></textarea>
			</md-input-container>
			<md-switch ng-model="task.public" aria-label="Type"><strong class="text-muted"><?php echo lang('public') ?></strong></md-switch>
			<md-switch ng-model="task.visible" aria-label="Type"><strong class="text-muted"><?php echo lang('visiblecustomer') ?></strong></md-switch>
			<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
				  <md-button ng-click="UpdateTask()" class="md-raised md-primary pull-right"><?php echo lang('update');?></md-button>
			</section>
		</md-content>
	 </md-content>
	</md-sidenav>
	<script type="text/ng-template" id="addfile-template.html">
	  <md-dialog aria-label="options dialog">
	  <?php echo form_open_multipart('tasks/add_file/'.$task['id'].'',array("class"=>"form-horizontal")); ?>
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
</div>
<script>
	var TASKID = "<?php echo $task['id'];?>";
</script>
