<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Leads_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
		<div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0 lead-left-bar">
			<div class="panel-default panel-table borderten lead-manager-head">
				<div class="col-md-4 col-xs-4 border-right" style="margin-bottom: 10px;border-bottom: 2px dashed #cecece;padding-bottom: 20px;">
					<div class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number"><?php echo $tcl ?></span><span class="task-stat-all"> / <?php echo $tlh ?> <?php echo lang('lead') ?></span></h3>
						<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: 40%;"></span> </span>
					</div>
					<span style="color:#989898"><?php echo lang('converted') ?></span>
				</div>
				<div class="col-md-4 col-xs-4 border-right" style="margin-bottom: 10px;border-bottom: 2px dashed #cecece;padding-bottom: 20px;">
					<div class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number"><?php echo $tll ?></span><span class="task-stat-all"> / <?php echo $tlh ?> <?php echo lang('lead') ?></span></h3>
						<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: 40%;"></span> </span>
					</div>
					<span style="color:#989898"><?php echo lang('junk') ?></span>
				</div>
				<div class="col-md-4 col-xs-4 border-right" style="margin-bottom: 10px;border-bottom: 2px dashed #cecece;padding-bottom: 20px;">
					<div class="tasks-status-stat">
						<h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number"><?php echo $tjl ?></span><span class="task-stat-all"> / <?php echo $tlh ?> <?php echo lang('lead') ?></span></h3>
						<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: 40%;"></span> </span>
					</div>
					<span style="color:#989898"><?php echo lang('lost') ?></span>
				</div>
				<div class="widget-chart-container" style="border-bottom: 2px dashed #e8e8e8; margin-bottom: 20px; padding-bottom: 20px;">
					<div class="widget-counter-group widget-counter-group-right">
						<div style="width: auto" class="pull-left">
							<i style="font-size: 38px;color: #bfc2c6;margin-right: 10px" class="ion-stats-bars pull-left"></i>
							<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
								<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('leadsbyleadsource') ?></b></h4>
								<small><?php echo lang('leadstatsbysource') ?></small>
							</div>
						</div>
					</div>
					<div class="my-2">
						<div class="chart-wrapper">
							<canvas id="leads_by_leadsource"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0 lead-table">
			<md-toolbar class="toolbar-trans">
			  <div class="md-toolbar-tools">
				<h2 flex md-truncate class="text-bold"><?php echo lang('leads'); ?><br><small flex md-truncate><?php echo lang('leaddesc'); ?></small></h2>
				<div class="ciuis-external-search-in-table">
					<input ng-model="search.name" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
					<md-button class="md-icon-button" aria-label="Search">
						<md-icon><i class="ion-search text-muted"></i></md-icon>
					</md-button>
				</div>
				<md-button ng-click="LeadSettings()"class="md-icon-button" aria-label="Settings">
					<md-tooltip md-direction="bottom"><?php echo lang('settings') ?></md-tooltip>
					<md-icon><i class="ion-ios-gear text-muted"></i></md-icon>
				</md-button>
				<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter">
					<md-tooltip md-direction="bottom"><?php echo lang('filter') ?></md-tooltip>
					<md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
				</md-button>
				<md-button ng-click="Create()" class="md-icon-button" aria-label="New">
					<md-tooltip md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
					<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
				</md-button>
				<md-menu md-position-mode="target-right target" ng-hide="ONLYADMIN != 'true'">
				  <md-button aria-label="Open demo menu" class="md-icon-button" ng-click="$mdMenu.open($event)">
					<md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
				  </md-button>
				  <md-menu-content width="4">
					<md-menu-item>
					 	 <md-button ng-click="Import()">
						  <div layout="row" flex>
							<p flex><?php echo lang('importleads') ?></p>
							<md-icon md-menu-align-target class="ion-upload" style="margin: auto 3px auto 0;"></md-icon>
						  </div>
					 	 </md-button>
					</md-menu-item>
					<md-menu-item>
					 	 <md-button ng-click="RemoveConverted()">
						  <div layout="row" flex>
							<p flex><?php echo lang('deleteconvertedleads') ?></p>
							<md-icon md-menu-align-target class="ion-android-remove-circle" style="margin: auto 3px auto 0;"></md-icon>
						  </div>
					 	 </md-button>
					</md-menu-item>
				  </md-menu-content>
				</md-menu>
			  </div>
			</md-toolbar>
			<md-content layout-padding class="md-pt-0">
				<ul class="custom-ciuis-list-body" style="padding: 0px;">
					<li ng-repeat="lead in leads | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="ciuis-custom-list-item ciuis-special-list-item">
						<ul class="list-item-for-custom-list">
							<li class="ciuis-custom-list-item-item col-md-12">
								<div data-toggle="tooltip" data-placement="bottom" data-container="body" title="" data-original-title="Assigned: {{lead.assigned}}" class="assigned-staff-for-this-lead user-avatar"><img src="<?php echo base_url('uploads/images/{{lead.avatar}}')?>" alt="{{lead.assigned}}">
								</div>
								<div class="pull-left col-md-6"><a ng-href="<?php echo base_url('leads/lead/')?>{{lead.id}}"><strong ng-bind="lead.name"></strong></a><br>
								<small ng-bind="lead.company"></small>
								</div>
								<div class="col-md-6">
									<div class="col-md-5"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('phone') ?> <i class="ion-ios-stopwatch-outline"></i></small><br><strong ng-bind="lead.phone"></strong></span>
									</div>
									<div class="col-md-4"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('status') ?> <i class="ion-ios-circle-filled"></i></small><br><strong><span class="badge" style="border-color: #fff;background-color: {{lead.color}};" ng-bind="lead.statusname"></span></strong></span>
									</div>
									<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('source') ?> <i class="ion-ios-circle-filled"></i></small><br><strong><span class="badge" ng-bind="lead.sourcename"></span></strong></span>
									</div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
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
				<md-content ng-show="!leads.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
			</md-content>
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
				<label><?php echo lang('title'); ?></label>
				<input ng-model="lead.title">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('name'); ?></label>
				<md-icon md-svg-src="<?php echo base_url('assets/img/icons/individual.svg') ?>"></md-icon>
				<input name="name" ng-model="lead.name">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('company'); ?></label>
				<md-icon md-svg-src="<?php echo base_url('assets/img/icons/company.svg') ?>"></md-icon>
				<input ng-model="lead.company">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('assigned'); ?></label>
				<md-select placeholder="<?php echo lang('choosestaff'); ?>" ng-model="lead.assigned_id" style="min-width: 200px;">
					<md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
				</md-select>
			</md-input-container>
			<br>
			<md-input-container class="md-block">
				<label><?php echo lang('status'); ?></label>
				<md-select placeholder="<?php echo lang('status'); ?>" ng-model="lead.status_id" style="min-width: 200px;">
					<md-option ng-value="status.id" ng-repeat="status in leadstatuses">{{status.name}}</md-option>
				</md-select>
			</md-input-container>
			<br>
			<md-input-container class="md-block">
				<label><?php echo lang('source'); ?></label>
				<md-select placeholder="<?php echo lang('source'); ?>" ng-model="lead.source_id" style="min-width: 200px;">
					<md-option ng-value="source.id" ng-repeat="source in leadssources">{{source.name}}</md-option>
				</md-select>
			</md-input-container>
			<br>
			<md-input-container class="md-block">
				<label><?php echo lang('phone'); ?></label>
				<input ng-model="lead.phone">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('email'); ?></label>
				<input ng-model="lead.email">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('web'); ?></label>
				<input ng-model="lead.website">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('country'); ?></label>
				<md-select placeholder="<?php echo lang('country'); ?>" ng-model="lead.country_id" style="min-width: 200px;">
					<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
				</md-select>
			</md-input-container>
			<br>
			<md-input-container class="md-block">
				<label><?php echo lang('state'); ?></label>
				<input ng-model="lead.state">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('city'); ?></label>
				<input ng-model="lead.city">
			</md-input-container>
			<md-input-container class="md-block">
				<label><?php echo lang('zip'); ?></label>
				<input ng-model="lead.zip">
			</md-input-container>
			<md-input-container class="md-block">
			  <label><?php echo lang('address') ?></label>
			  <textarea ng-model="lead.address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
			</md-input-container>
			<md-input-container class="md-block">
			  <label><?php echo lang('description') ?></label>
			  <textarea ng-model="lead.description" md-maxlength="500" rows="3" md-select-on-focus></textarea>
			</md-input-container>
			<md-input-container class="md-block pull-left">
				<md-checkbox ng-model="lead.public"><?php echo lang('public') ?></md-checkbox>
			</md-input-container>
			<md-input-container class="md-block pull-left">
				<md-checkbox ng-model="lead.type"><?php echo lang('individual') ?></md-checkbox>
			</md-input-container>
			<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button ng-click="AddLead()" class="md-raised md-primary pull-right"><?php echo lang('create');?></md-button>
			</section>		
		</md-content>
	 </md-content>
	</md-sidenav>	
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
		<div ng-repeat="(prop, ignoredValue) in leads[0]" ng-init="filter[prop]={}" ng-if="prop != 'name' && prop != 'id' && prop != 'company' && prop != 'phone' && prop != 'color' && prop != 'status' && prop != 'source' && prop != 'assigned' && prop != 'avatar' && prop != 'staff' && prop != 'createddate' && prop != 'statusname' && prop != 'sourcename'">
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
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="LeadsSettings">
	  <md-toolbar class="toolbar-white" style="background:#262626">
	  <div class="md-toolbar-tools">
		<md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
		<md-truncate><?php echo lang('settings') ?></md-truncate>
	  </div>
	  </md-toolbar>
	  <md-content>
	  <md-toolbar class="toolbar-white" style="background:#262626">
	  <div class="md-toolbar-tools">
			<h4 class="text-bold text-muted" flex><?php echo lang('leadsstatuses') ?></h4>
		<md-button aria-label="Converted Lead Status" class="md-icon-button" ng-click="ConvertedStatus()">
			<md-tooltip md-direction="bottom"><?php echo lang('converted_lead_status') ?></md-tooltip>
			<md-icon><i class="mdi mdi-refresh-sync text-success"></i></md-icon>
		</md-button>
		<md-button aria-label="Add Status" class="md-icon-button" ng-click="NewStatus()">
			<md-tooltip md-direction="bottom"><?php echo lang('addstatus') ?></md-tooltip>
			<md-icon><i class="ion-plus-round text-success"></i></md-icon>
		</md-button> 
	  </div>
	  </md-toolbar>
	  <md-list-item ng-repeat="status in leadstatuses" class="noright" ng-click="EditStatus(status.id,status.name, $event)" aria-label="Edit Status">
		<strong ng-bind="status.name"></strong>
		<md-icon ng-click='DeleteLeadStatus($index)' aria-label="Remove Status" class="md-secondary md-hue-3 ion-trash-b" ></md-icon>
	  </md-list-item>
	  <md-toolbar class="toolbar-white" style="background:#262626">
	  <div class="md-toolbar-tools">
		<h4 class="text-bold text-muted" flex><?php echo lang('leadssources') ?></h4>
		  <md-button aria-label="Add Source" class="md-icon-button" ng-click="NewSource()">
			<md-tooltip md-direction="bottom"><?php echo lang('addsource') ?></md-tooltip>
			<md-icon><i class="ion-plus-round text-success"></i></md-icon>
		  </md-button> 
	  </div>
	  </md-toolbar>
	  <md-list-item ng-repeat="source in leadssources" class="noright" ng-click="EditSource(source.id,source.name, $event)" aria-label="Edit Source" >
		<strong ng-bind="source.name"></strong>
		<md-icon ng-click='DeleteLeadSource($index)' aria-label="Remove Source" class="md-secondary md-hue-3 ion-trash-b" ></md-icon>
	  </md-list-item>
	  </md-content>
	</md-sidenav>
	<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Import">
	  <md-toolbar class="md-theme-light" style="background:#262626">
	  <div class="md-toolbar-tools">
		<md-button ng-click="close()" class="md-icon-button" aria-label="Close"><i class="ion-android-arrow-forward"></i></md-button>
		<md-truncate><?php echo lang('importleads') ?></md-truncate>
	  </div>
	  </md-toolbar>
	 <md-content>
		<?php echo form_open_multipart('leads/import'); ?>
			<div class="modal-body">
				<div class="form-group">
					<label for="name">
						<?php echo lang('choosecsvfile'); ?>
					</label>
					<div class="file-upload">
						<div class="file-select">
							<div class="file-select-button" id="fileName"><span class="mdi mdi-accounts-list-alt"></span>
								<?php echo lang('attachment')?>
							</div>
							<div class="file-select-name" id="noFile">
								<?php echo lang('notchoise')?>
							</div>
							<input type="file" name="userfile" id="chooseFile">
						</div>
					</div>
				</div>
				<br>
				<md-input-container class="md-block">
					<label><?php echo lang('assigned'); ?></label>
					<md-select placeholder="<?php echo lang('choosestaff'); ?>" name="importassigned" ng-model="importassigned" style="min-width: 200px;">
						<md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<md-input-container class="md-block">
					<label><?php echo lang('status'); ?></label>
					<md-select placeholder="<?php echo lang('status'); ?>" name="importstatus" ng-model="importstatus" style="min-width: 200px;">
						<md-option ng-value="status.id" ng-repeat="status in leadstatuses">{{status.name}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<md-input-container class="md-block">
					<label><?php echo lang('source'); ?></label>
					<md-select placeholder="<?php echo lang('source'); ?>" name="importsource" ng-model="importsource" style="min-width: 200px;">
						<md-option ng-value="source.id" ng-repeat="source in leadssources">{{source.name}}</md-option>
					</md-select>
				</md-input-container>
				<br>
				<div class="well well-sm"><?php echo lang('importcustomerinfo'); ?></div>
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url('uploads/samples/leadimport.csv')?>" class="btn btn-success pull-left"><?php echo lang('downloadsample'); ?></a>
				<button type="submit" class="btn btn-default"><?php echo lang('save'); ?></button>
			</div>
		<?php echo form_close(); ?>	
	 </md-content>
	</md-sidenav>
<script type="text/ng-template" id="converted-status-template.html">
  <md-dialog aria-label="options dialog">
	<md-dialog-content layout-padding>
	  <h2 class="md-title"><?php echo lang('converted_lead_status'); ?></h2>
		<md-select required ng-model="ConvertedLeadStatus" style="min-width: 200px;" aria-label="AddMember">
			<md-option ng-value="status.id" ng-repeat="status in leadstatuses">{{status.name}}</md-option>
		</md-select>
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
	  <md-button ng-click="MakeConvertedLedStatus()"><?php echo lang('update') ?>!</md-button>
	</md-dialog-actions>
  </md-dialog>
</script>
</div>
<script>var MSG_TITLE = '<?php echo lang('attention') ?>',MSG_REMOVE = '<?php echo lang('converted_lead_remove_msg') ?>',MSG_CANCEL = '<?php echo lang('cancel') ?>',MSG_OK = '<?php echo lang('yes') ?>'</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>