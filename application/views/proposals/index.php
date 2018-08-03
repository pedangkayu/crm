<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Proposals_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 hidden-xs">
	<div class="panel-heading">
	<strong><?php echo lang('proposalsituation') ?></strong>
	<span class="panel-subtitle"><?php echo lang('proposalsituationsdesc') ?></span>
	</div>
	<div class="row" style="padding: 0px 20px 0px 20px;">
		<div class="col-md-6 col-xs-6 border-right">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'1'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposalprefix') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'1'}).length * 100 / proposals.length }}%;"></span>
				</span>
			</div>
			<span class="text-uppercase" style="color:#989898"><?php echo lang('draft')?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'2'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposalprefix') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'2'}).length * 100 / proposals.length }}%;"></span>
				</span>
			</div>
			<span class="text-uppercase" style="color:#989898"><?php echo lang('sent')?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'3'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposalprefix') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'3'}).length * 100 / proposals.length }}%;"></span>
				</span>
			</div>
			<span class="text-uppercase" style="color:#989898"><?php echo lang('open')?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'4'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposalprefix') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'4'}).length * 100 / proposals.length }}%;"></span>
				</span>
			</div>
			<span class="text-uppercase" style="color:#989898"><?php echo lang('revised')?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'5'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposalprefix') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'5'}).length * 100 / proposals.length }}%;"></span>
				</span>
			</div>
			<span class="text-uppercase" style="color:#989898"><?php echo lang('declined')?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(proposals | filter:{status_id:'6'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+proposals.length+' '+'<?php echo lang('proposalprefix') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(proposals | filter:{status_id:'6'}).length * 100 / proposals.length }}%;"></span>
				</span>
			</div>
			<span class="text-uppercase" style="color:#989898"><?php echo lang('accepted')?></span>
		</div>
	</div>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9">
		<md-toolbar class="toolbar-trans">
		  <div class="md-toolbar-tools">
			<h2 flex md-truncate class="text-bold"><?php echo lang('proposals'); ?><br><small flex md-truncate><?php echo lang('organizeyourproposals'); ?></small></h2>
			<div class="ciuis-external-search-in-table">
				<input ng-model="search.subject" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
				<md-button class="md-icon-button" aria-label="Search">
					<md-icon><i class="ion-search text-muted"></i></md-icon>
				</md-button>
			</div>
			<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter">
				<md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
			</md-button>
			<md-button ng-href="<?php echo base_url('proposals/create') ?>" class="md-icon-button" aria-label="New">
				<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
			</md-button>
		  </div>
		</md-toolbar>
		<md-content layout-padding class="md-pt-0">
			<ul class="custom-ciuis-list-body" style="padding: 0px;">
				<li ng-repeat="proposal in proposals | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="ciuis-custom-list-item ciuis-special-list-item lead-name">
					<ul class="list-item-for-custom-list">
						<li class="ciuis-custom-list-item-item col-md-12">
						<div class="assigned-staff-for-this-lead user-avatar"><i class="ico-ciuis-proposals" style="font-size: 32px"></i></div>
							<div class="pull-left col-md-3">
							<a href="<?php echo base_url('proposals/proposal/'); ?>{{proposal.id}}"><strong ng-bind="proposal.subject"></strong></a><br>
							<small ng-bind="proposal.customer"></small>
							</div>
							<div class="col-md-9">
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('date')?></small><br><strong><span class="badge" ng-bind="proposal.date"></span></strong></span>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('opentill'); ?></small><br><strong><span class="badge" ng-bind="proposal.opentill"></span></strong></span>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('status'); ?></small><br><span class="label {{proposal.class}} label-default" ng-bind="proposal.status"></span>
								</div>
								<div class="col-md-2 text-right">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('amount'); ?></small><br><strong ng-bind-html="proposal.total | currencyFormat:cur_code:null:true:cur_lct"></strong></span>
								</div>
								<div class="col-md-1">
								<div style="margin-top: 5px;" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="Created by: {{proposal.staff}}" class="assigned-staff-for-this-lead user-avatar"><img ng-src="<?php echo base_url('uploads/images/{{proposal.staffavatar}}')?>" alt="{{proposal.staff}}"></div>
								</div>
							</div>
						</li>
					</ul>
				</li>
			</ul>
			<md-content ng-show="!proposals.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
			<div class="pagination-div text-center">
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
	 <div ng-repeat="(prop, ignoredValue) in proposals[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'assigned' && prop != 'subject' && prop != 'customer' && prop != 'date' && prop != 'opentill' && prop != 'status' && prop != 'staff' && prop != 'staffavatar' && prop != 'total' && prop != 'class' && prop != 'relation' && prop != 'status_id' && prop != 'prefix' && prop != 'longid' && prop != 'relation_type'" >
	  <div class="filter col-md-12">
		<h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
		<hr>
		<div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycustomer') ?>' && prop!='<?php echo lang('filterbyassigned') ?>'">
			<md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
		</div>
		<div ng-if="prop=='<?php echo lang('filterbycustomer') ?>'">
			<md-select aria-label="Filter" ng-model="filter_select" ng-init="filter_select='all'" ng-change="updateDropdown(prop)">
				<md-option value="all"><?php echo lang('all') ?></md-option>
				<md-option ng-repeat="opt in getOptionsFor(prop) | orderBy:'':true" value="{{opt}}">{{opt}}</md-option>
			</md-select>
		</div>
		<div ng-if="prop=='<?php echo lang('filterbyassigned') ?>'">
			<md-select aria-label="Filter" ng-model="filter_select" ng-init="filter_select='all'" ng-change="updateDropdown(prop)">
				<md-option value="all"><?php echo lang('all') ?></md-option>
				<md-option ng-repeat="opt in getOptionsFor(prop) | orderBy:'':true" value="{{opt}}">{{opt}}</md-option>
			</md-select>
		</div>
	  </div>
	</div>
  </md-content>
</md-sidenav>
</div>
<?php include_once(APPPATH . 'views/inc/footer.php');?>