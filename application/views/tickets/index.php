<div class="ciuis-body-content" ng-controller="Tickets_Controller">
<md-divider ></md-divider>
	<md-content class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 lg-pr-0" layout-padding>
		<md-content>
			<md-toolbar class="toolbar-trans" style="padding:0px">
			  <div class="md-toolbar-tools">
				<h2 flex md-truncate class="text-bold"><?php echo lang('browse'); ?><br><small flex md-truncate><?php echo lang('tracktickets'); ?></small></h2>
				<md-button ng-click="Create()" class="md-icon-button" aria-label="Filter">
					<md-tooltip md-direction="left"><?php echo lang('newticket') ?></md-tooltip>
					<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
				</md-button>
			  </div>
			</md-toolbar>
			<div class="ticket-contoller-left">
				<div id="tickets-left-column text-left">
					<div class="col-md-12 ticket-row-left text-left">
					<div class="tickets-vertical-menu">
					  <a ng-click="TicketsFilter = NULL" class="highlight text-uppercase"><i class="fa fa-inbox fa-lg" aria-hidden="true"></i> <?php echo lang('alltickets') ?> <span class="ticket-num" ng-bind="tickets.length"></span></a>
					  <a ng-click="TicketsFilter = {status_id: 1}" class="side-tickets-menu-item"><?php echo lang('open') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'1'}).length"></span></a>
					  <a ng-click="TicketsFilter = {status_id: 2}" class="side-tickets-menu-item"><?php echo lang('inprogress') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'2'}).length"></span></a>
					  <a ng-click="TicketsFilter = {status_id: 3}" class="side-tickets-menu-item"><?php echo lang('answered') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'3'}).length"></span></a>
					  <a ng-click="TicketsFilter = {status_id: 4}" class="side-tickets-menu-item"><?php echo lang('closed') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'4'}).length"></span></a>
					  <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i><?php echo lang('filterbypriority') ?></h5>
					  <a ng-click="TicketsFilter = {priority_id: 1}" class="side-tickets-menu-item"><?php echo lang('low') ?> <span class="ticket-num" ng-bind="(tickets | filter:{priority_id:'1'}).length"></span></a>
					  <a ng-click="TicketsFilter = {priority_id: 2}" class="side-tickets-menu-item"><?php echo lang('medium') ?> <span class="ticket-num" ng-bind="(tickets | filter:{priority_id:'2'}).length"></span></a>
					  <a ng-click="TicketsFilter = {priority_id: 3}" class="side-tickets-menu-item"><?php echo lang('high') ?> <span class="ticket-num" ng-bind="(tickets | filter:{priority_id:'3'}).length"></span></a>
					</div>
					</div>
				 </div>
			</div>
		</md-content>
	</md-content>
	<md-content class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 lg-pl-0" style="border-left: 1px solid #e4e4e4;">
		<md-content class="col-md-4" style="padding: 0px; border: 1px solid #e4e4e4; height: 500px; overflow: scroll;">
		  <md-list flex>
			<md-subheader class="md-no-sticky"><md-icon class="ion-android-alert text-danger"></md-icon><strong><?php echo lang('high') ?></strong></md-subheader>
			<md-divider ></md-divider>
			<md-list-item class="md-2-line" ng-repeat="ticket in tickets | filter:TicketsFilter | filter:search | filter: { priority_id: '3' }" ng-click="GoTicket(ticket.id)">
			  <div class="md-list-item-text">
				<h3> {{ ticket.subject }} </h3>
				<p> {{ ticket.contactname }} </p>
				<p ng-show="ticket.lastreply != NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small ng-bind="ticket.lastreply | date : 'MMM d, y h:mm:ss a'"></small></small></p>
				<p ng-show="ticket.lastreply == NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small>N/A</small></small></p>
			  </div>
			  <md-button ng-hide="ticket.status_id != 4" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('closed') ?></md-tooltip>
				<md-icon class="ion-happy text-success"></md-icon>
			  </md-button>
			  <md-button ng-hide="ticket.status_id != 3" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('answered') ?></md-tooltip>
				<md-icon class="mdi mdi-mail-reply-all text-muted"></md-icon>
			  </md-button>
			  <md-button ng-hide="ticket.status_id != 2" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('inprogress') ?></md-tooltip>
				<md-icon class="mdi mdi-hourglass-alt text-muted"></md-icon>
			  </md-button>
			  <md-button ng-hide="ticket.status_id != 1" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('open') ?></md-tooltip>
				<md-icon class="mdi mdi-flash text-danger"></md-icon>
			  </md-button>
			<md-divider ></md-divider>
			</md-list-item>
		  </md-list>
		</md-content>
		<md-content class="col-md-4" style="padding: 0px; border: 1px solid #e4e4e4; height: 500px; overflow: scroll;">
		  <md-list flex>
			<md-subheader class="md-no-sticky"><md-icon class="ion-android-alert text-warning"></md-icon><strong><?php echo lang('medium') ?></strong></md-subheader>
			<md-divider ></md-divider>
			<md-list-item class="md-2-line" ng-repeat="ticket in tickets | filter:TicketsFilter | filter:search | filter: { priority_id: '2' }" ng-click="GoTicket(ticket.id)">
			  <div class="md-list-item-text">
				<h3> {{ ticket.subject }} </h3>
				<p> {{ ticket.contactname }} </p>
				<p ng-show="ticket.lastreply != NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small ng-bind="ticket.lastreply | date : 'MMM d, y h:mm:ss a'"></small></small></p>
				<p ng-show="ticket.lastreply == NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small>N/A</small></small></p>
			  </div>
			  <md-button ng-hide="ticket.status_id != 4" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('closed') ?></md-tooltip>
				<md-icon class="ion-happy text-success"></md-icon>
			  </md-button>
			  <md-button ng-hide="ticket.status_id != 3" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('answered') ?></md-tooltip>
				<md-icon class="mdi mdi-mail-reply-all text-muted"></md-icon>
			  </md-button>
			  <md-button ng-hide="ticket.status_id != 2" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('inprogress') ?></md-tooltip>
				<md-icon class="mdi mdi-hourglass-alt text-muted"></md-icon>
			  </md-button>
			  <md-button ng-hide="ticket.status_id != 1" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('open') ?></md-tooltip>
				<md-icon class="mdi mdi-flash text-danger"></md-icon>
			  </md-button>
			<md-divider ></md-divider>
			</md-list-item>
		  </md-list>
		</md-content>
		<md-content class="col-md-4" style="padding: 0px; border: 1px solid #e4e4e4; height: 500px; overflow: scroll;">
		  <md-list flex>
			<md-subheader class="md-no-sticky"><md-icon class="ion-android-alert text-success"></md-icon><strong><?php echo lang('low') ?></strong></md-subheader>
			<md-divider ></md-divider>
			<md-list-item class="md-2-line" ng-repeat="ticket in tickets | filter:TicketsFilter | filter:search | filter: { priority_id: '1' }" ng-click="GoTicket(ticket.id)">
			  <div class="md-list-item-text">
				<h3> {{ ticket.subject }} </h3>
				<p> {{ ticket.contactname }} </p>
				<p ng-show="ticket.lastreply != NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small ng-bind="ticket.lastreply | date : 'MMM d, y h:mm:ss a'"></small></small></p>
				<p ng-show="ticket.lastreply == NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small>N/A</small></small></p>
			  </div>
			  <md-button ng-hide="ticket.status_id != 4" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('closed') ?></md-tooltip>
				<md-icon class="ion-happy text-success"></md-icon>
			  </md-button>
			  <md-button ng-hide="ticket.status_id != 3" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('answered') ?></md-tooltip>
				<md-icon class="mdi mdi-mail-reply-all text-muted"></md-icon>
			  </md-button>
			  <md-button ng-hide="ticket.status_id != 2" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('inprogress') ?></md-tooltip>
				<md-icon class="mdi mdi-hourglass-alt text-muted"></md-icon>
			  </md-button>
			  <md-button ng-hide="ticket.status_id != 1" class="md-secondary md-icon-button" aria-label="Closed">
			   	<md-tooltip md-direction="bottom"><?php echo lang('open') ?></md-tooltip>
				<md-icon class="mdi mdi-flash text-danger"></md-icon>
			  </md-button>
			<md-divider ></md-divider>
			</md-list-item>
		  </md-list>
		</md-content>
		<md-content style="margin-top:-30px" layout-padding>
		<div class="col-md-3 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'1'}).length"></span>
				<span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'1'}).length * 100 / tickets.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('open') ?></span>
		</div>
		<div class="col-md-3 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'2'}).length"></span>
				<span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'2'}).length * 100 / tickets.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('inprogress') ?></span>
		</div>
		<div class="col-md-3 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'3'}).length"></span>
				<span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'3'}).length * 100 / tickets.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('answered') ?></span>
		</div>
		<div class="col-md-3 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'4'}).length"></span>
				<span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'4'}).length * 100 / tickets.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('closed') ?></span>
		</div>
		</md-content>
	</md-content>
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
	<?php echo form_open_multipart('tickets/create'); ?>
		<md-input-container class="md-block">
			<label><?php echo lang('subject') ?></label>
			<input required type="text" ng-model="ticket.subject" name="subject" class="form-control">
		</md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('customer'); ?></label>
			<md-select placeholder="<?php echo lang('choisecustomer'); ?>" ng-model="ticket.customer" name="customer">
				<md-option ng-value="customer" ng-repeat="customer in all_customers">{{customer.name}}</md-option>
			</md-select><br>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('contact'); ?></label>
			<md-select required ng-model="ticket.contact" name="contact">
				<md-option ng-value="contact.id" ng-repeat="contact in ticket.customer.contacts">{{contact.name + ' ' + contact.surname}}</md-option>
			</md-select><br>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('department'); ?></label>
			<md-select required ng-model="ticket.department" name="department">
				<md-option ng-value="department.id" ng-repeat="department in departments">{{department.name}}</md-option>
			</md-select><br>
        </md-input-container>
        <md-input-container class="md-block" flex-gt-xs>
            <label><?php echo lang('priority'); ?></label>
			<md-select ng-init="priorities = [{id: 1,name: '<?php echo lang('low'); ?>'}, {id: 2,name: '<?php echo lang('medium'); ?>'}, {id: 3,name: '<?php echo lang('high'); ?>'}];" required placeholder="<?php echo lang('priority'); ?>" ng-model="ticket.priority" name="priority">
				<md-option ng-value="priority.id" ng-repeat="priority in priorities"><span class="text-uppercase">{{priority.name}}</span></md-option>
			</md-select><br>
        </md-input-container>
        <md-input-container class="md-block">
			<label><?php echo lang('message') ?></label>
			<textarea required name="message" ng-model="ticket.message" placeholder="Type something" class="form-control"></textarea>
		</md-input-container>
		<div class="file-upload">
			<div class="file-select">
				<div class="file-select-button" id="fileName"><span class="mdi mdi-accounts-list-alt"></span> <?php echo lang('attachment')?></div>
				<div class="file-select-name" id="noFile"><?php echo lang('nofile')?></div>
				<input type="file" name="attachment" id="chooseFile">
			</div>
		</div>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
			  <md-button type="submit" class="md-raised md-primary pull-right"><?php echo lang('add');?></md-button>
		</section>
	<?php echo form_close(); ?>
	</md-content>
 </md-content>
</md-sidenav>
</div>