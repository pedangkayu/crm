
<div class="ciuis-body-content" ng-controller="Tasks_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3">
	<div class="panel-heading">
	<strong><?php echo lang('tasksituation'); ?></strong>
	<span class="panel-subtitle"><?php echo lang('tasksituationsdesc'); ?></span>
	</div>
	<div class="row" style="padding: 0px 20px 0px 20px;">
		<div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'1'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'1'}).length * 100 / tasks.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('open'); ?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'2'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'2'}).length * 100 / tasks.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('inprogress'); ?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'3'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'3'}).length * 100 / tasks.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('waiting'); ?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'4'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'4'}).length * 100 / tasks.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('complete'); ?></span>
		</div>
	</div>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0">
		<md-toolbar class="toolbar-trans">
		  <div class="md-toolbar-tools">
			<h2 flex md-truncate class="text-bold"><?php echo lang('tasks'); ?><br><small flex md-truncate><?php echo lang('organizeyourtasks'); ?></small></h2>
			<div class="ciuis-external-search-in-table">
				<input ng-model="search.name" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
				<md-button class="md-icon-button" aria-label="Search">
					<md-icon><i class="ion-search text-muted"></i></md-icon>
				</md-button>
			</div>
			<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter">
				<md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
			</md-button>
			<md-button ng-click="Create()" class="md-icon-button" aria-label="New">
				<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
			</md-button>
		  </div>
		</md-toolbar>
		<md-content layout-padding>
			<div layout-padding>
				<ul class="custom-ciuis-list-body" style="padding: 0px;">
					<li ng-repeat="task in tasks | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="milestone-todos-list ciuis-custom-list-item ciuis-special-list-item paginationclass">
						<ul class="all-milestone-todos">
							<li class="milestone-todos-list-item col-md-12  {{task.done}}">
								<span class="pull-left col-md-5"><a href="<?php echo base_url('tasks/task/')?>{{task.id}}"><strong ng-bind="task.name"></strong></a><br><small ng-bind="task.relationtype"></small></span>
								<div class="col-md-7">
									<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('startdate'); ?> <i class="ion-ios-stopwatch-outline"></i></small><br><strong ng-bind="task.startdate"></strong></span>
									</div>
									<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('duedate'); ?> <i class="ion-ios-timer-outline"></i></small><br><strong ng-bind="task.duedate"></strong></span>
									</div>
									<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('status'); ?> <i class="ion-ios-circle-outline"></i></small><br><strong ng-bind="task.status"></strong></span>
									</div>
									<div class="col-md-3 text-right">
										<a ng-href="<?php echo base_url('tasks/task/') ?>{{task.id}}" class="edit-task pull-right"><i class="ion-compose"></i></a>
									</div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
				<md-content ng-show="!tasks.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
				<div class="pagination-div">
					<ul class="pagination">
						<li ng-class="DisablePrevPage()">
							<a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a>
						</li>
						<li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
							<a href="#" ng-bind="n+1"></a>
						</li>
						<li ng-class="DisableNextPage()">
							<a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a>
						</li>
					</ul>
				</div>
			</div>
		</md-content>
	</div>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter">
		<md-toolbar class="md-theme-light" style="background:#262626">
	  <div class="md-toolbar-tools">
		<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
			 <i class="ion-android-arrow-forward"></i>
		</md-button>
		<md-truncate><?php echo lang('filter') ?></md-truncate>
	  </div>
	  </md-toolbar>
	  <md-content layout-padding="">
		<div ng-repeat="(prop, ignoredValue) in tasks[0]" ng-init="filter[prop]={}" ng-if="prop != 'id'  && prop != 'name' && prop != 'relationtype' && prop != 'duedate' && prop != 'startdate' && prop != 'status' && prop != 'done' && prop != 'status_id'">
		  <div class="filter col-md-12">
			<h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
			<hr>
			<div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)">
				<md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
			</div>
		  </div>
		</div>
	  </md-content>
	</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<h2 flex md-truncate><?php echo lang('create') ?></h2>
	<md-switch ng-model="isBillable" aria-label="Type"><strong class="text-muted"><?php echo lang('billable') ?></strong></md-switch>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('relationtype'); ?></label>
			<md-select ng-init="relation_types = [{value: 'project',name: '<?php echo lang('project'); ?>'}, {value: 'ticket',name: '<?php echo lang('ticket'); ?>'}];" disabled placeholder="<?php echo lang('relationtype'); ?>" ng-model="Relation_Type" name="relationtype" style="min-width: 200px;">
				<md-option ng-value="relation_type.value" ng-repeat="relation_type in relation_types"><span class="text-uppercase">{{relation_type.name}}</span></md-option>
			</md-select><br>
        </md-input-container>
        <md-input-container ng-show="Relation_Type == 'project'" class="md-block" flex-gt-xs>
            <label><?php echo lang('project'); ?></label>
			<md-select required ng-model="RelatedProject" name="relation" style="min-width: 200px;">
				<md-option ng-value="project" ng-repeat="project in projects">{{project.name}}</md-option>
			</md-select><br>
        </md-input-container>
        <md-input-container ng-show="Relation_Type == 'project'" class="md-block" flex-gt-xs>
            <label><?php echo lang('milestone'); ?></label>
			<md-select ng-model="SelectedMilestone" name="relation" style="min-width: 200px;">
				<md-option ng-value="milestone.id" ng-repeat="milestone in RelatedProject.milestones">{{milestone.name}}</md-option>
			</md-select><br>
        </md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('name') ?></label>
			<input required type="text" ng-model="task.name" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
		</md-input-container>
		<md-input-container ng-show="isBillable === true" class="md-block">
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
		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required name="description" ng-model="task.description" placeholder="Type something" class="form-control"></textarea>
		</md-input-container>
		<md-switch ng-model="isPublic" aria-label="Type"><strong class="text-muted"><?php echo lang('public') ?></strong></md-switch>
		<md-switch ng-model="isVisible" aria-label="Type"><strong class="text-muted"><?php echo lang('visiblecustomer') ?></strong></md-switch>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="AddTask()" class="md-raised md-primary pull-right"><?php echo lang('create');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
</div>
