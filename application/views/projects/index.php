<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Projects_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="col-md-12 md-p-0 md-mb-10 hidden-xs">
			<div class="btn-group">
				<button type="button" class="active pbtn btn btn-xl btn-default" id="all"><img height="28" ng-src="{{IMAGESURL}}all_projects.png">  <?php echo lang('showall'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default" id="notstarted"><img height="28" ng-src="{{IMAGESURL}}notstarted.png">  <?php echo lang('notstarted'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default" id="started"><img height="28" ng-src="{{IMAGESURL}}started.png">  <?php echo lang('started'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default" id="percentage"><img height="28" ng-src="{{IMAGESURL}}percentage.png">  <?php echo lang('percentage'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default" id="cancelled"><img height="28" ng-src="{{IMAGESURL}}cancelled.png">  <?php echo lang('cancelled'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default text-success" id="complete"><img height="28" src="{{IMAGESURL}}complete.png">  <?php echo lang('complete'); ?></button>
			</div>
			<md-button ng-click="Create()" class="md-icon-button pull-right" aria-label="New">
				<md-tooltip md-direction="left"><?php echo lang('create') ?></md-tooltip>
				<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
			</md-button>
		</div>
		<div class="row">
			<div id="ciuisprojectcard" style="padding-left: 15px;padding-right: 5px;">
				<div ng-repeat="project in projects | pagination : currentPage*itemsPerPage | limitTo: 6" class="col-md-4 {{project.status_class}}" style="padding-left: 0px;padding-right: 10px;">
					<div id="project-card" class="ciuis-project-card">
						<div class="ciuis-project-content">
							<div class="ciuis-content-header">
								<div class="pull-left">
									<p class="md-m-0" style="font-size: 14px;font-weight: 900">
										<a href="<?php echo base_url('/projects/project/') ?>{{project.id}}" ng-bind="project.name"></a>
									</p>
									<small ng-bind="project.customer"></small>
								</div>
								<div class="pull-right md-pr-10">
									<i ng-click='CheckPinned($index)' data-toggle="tooltip" data-placement="bottom" data-container="body" title="" data-original-title="Pin Project" class="ciuis-project-badge pull-right ion-pin"></i>
									<img data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="{{project.status}}" class="pull-right md-mr-5" height="32" ng-src="{{IMAGESURL}}{{project.status_icon}}">
								</div>
							</div>
							<div class="ciuis-project-dates">
								<div class="ciuis-project-start text-uppercase"><strong><?php echo lang('start'); ?></strong><b ng-bind="project.startdate"></b></div>
								<div class="ciuis-project-end text-uppercase"><strong><?php echo lang('deadline'); ?></strong><b ng-bind="project.leftdays"></b></div>
							</div>
							<div class="ciuis-project-stat col-md-12">
								<div class="col-md-6 bottom-left">
									<div class="progress-widget">
										<div class="progress-data text-left"><span class="progress-value" ng-bind="project.progress+'%'"></span>
										<span class="name" ng-bind="project.status"></span>
										</div>
										<div class="progress" style="height: 7px">
											<div style="width: {{project.progress}}%;" class="progress-bar progress-bar-primary"></div>
										</div>
									</div>
								</div>
								<div class="col-md-6 md-p-0 bottom-right text-right">
									<ul class="more-avatar">
										<li ng-repeat="member in project.members" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="{{member.staffname}}">
											<div style=" background: lightgray url({{UPIMGURL}}{{member.staffavatar}}) no-repeat center / cover;"></div>
										</li>
										<div class="assigned-more-pro hidden"><i class="ion-plus-round"></i>2</div>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<md-content ng-show="!projects.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
		</div>
		<div>
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
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
		<div class="projects-graph">
			<div class="col-md-12" style="padding: 0px;">
				<div class="panel-default">
					<div class="panel-heading panel-heading-divider xs-pb-15 text-center text-bold" style="margin: 0px;"><?php echo lang('completions'); ?></div>
					<div class="panel-body" style="padding: 0px;">
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.not_started_percent+'%'"></span>
								<span class="project-name"><?php echo lang('notstarted'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.not_started_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.started_percent+'%'"></span>
								<span class="project-name"><?php echo lang('started'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.started_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.percentage_percent+'%'"></span>
								<span class="project-name"><?php echo lang('percentage'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.percentage_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.cancelled_percent+'%'"></span>
								<span class="project-name"><?php echo lang('cancelled'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.cancelled_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.complete_percent+'%'"></span>
								<span class="project-name"><?php echo lang('complete'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.complete_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 pinnedprojects">
			<div class="panel-default">
				<div class="pinned-projects-header">
					<span><i class="ion-pin"></i> <?php echo lang('pinnedprojects'); ?></span>
					<span class="pull-right hide-pinned-projects"><a data-toggle="collapse" data-parent="#pinned-projects" href="#pinned-projects"><i class="icon mdi ion-minus-circled"></i></a></span>
				</div>
				<div id="pinned-projects" class="panel-collapse collapse in">
					<div class="pinned-projects">
						<div ng-repeat="project_pinned in pinnedprojects | filter: { pinned: '1' }" class="pinned-project-widget">
							<div class="pinned-project-body pull-left">
								<div class="project-progress-data">
									<span class="project-progress-value pull-right" ng-bind="project_pinned.progress+'%'"></span>
									<span class="project-name" ng-bind="project_pinned.name"></span>
								</div>
								<div class="progress" style="height: 5px">
									<div style="width:{{project_pinned.progress}}%;" class="progress-bar progress-bar-info"></div>
								</div>
							</div>
							<a ng-click='UnPinned($index)' class="pinned-project-action pull-right"><i class="ion-close-round"></i></a>
							<a href="<?php echo base_url('projects/project/')?>{{project_pinned.id}}" class="pinned-project-action pull-right"><i class="ion-android-open"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('create') ?></md-truncate>
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
			<md-select required placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="project.customer" name="customer" style="min-width: 200px;">
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
			  <md-button ng-click="CreateNew()" class="md-raised md-primary pull-right"><?php echo lang('create');?></md-button>
		</section>
	</md-content>
 </md-content>
</md-sidenav>
</div>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>