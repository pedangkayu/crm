<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Customer_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<h2 class="md-pl-10" flex md-truncate ng-show="customer.type =='0'" ng-bind="customer.company"></h2>					
				<h2 class="md-pl-10" flex md-truncate ng-show="customer.type =='1'" ng-bind="customer.namesurname"></h2>
				<md-button ng-click="Update()" class="md-icon-button md-primary" aria-label="Actions">
					<md-icon class="mdi mdi-edit"></md-icon>
				</md-button>
				<md-button ng-click="Delete()" class="md-icon-button md-primary" aria-label="Actions">
					<md-icon class="ion-trash-b"></md-icon>
				</md-button>					
			</div>
		</md-toolbar>
		<section layout="row" flex>
		<md-sidenav class="md-sidenav-left" md-component-id="left" md-is-locked-open="$mdMedia('gt-md')" style="z-index:0">
		<md-subheader class="md-primary" style="background-color: white; border-bottom: 1px #e0e0e0 solid; padding-bottom: 2px; border-right: 1px #f3f3f3 solid;">
			<?php echo lang('informations');?>
		</md-subheader>
		<md-content class="bg-white" style="border-right:1px solid #e0e0e0;">
			<md-list flex class="md-p-0 sm-p-0 lg-p-0">
				<md-list-item>
					<md-icon class="ion-android-call"></md-icon>
					<p ng-bind="customer.phone"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi mdi-http"></md-icon>
					<p ng-bind="customer.web"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="ion-android-mail"></md-icon>
					<p ng-bind="customer.email"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="ion-earth"></md-icon>
					<p ng-bind="customer.country"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi mdi-map"></md-icon>
					<p ng-bind="customer.state"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi mdi-city"></md-icon>
					<p ng-bind="customer.city"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi mdi-city-alt"></md-icon>
					<p ng-bind="customer.town"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="ion-ios-home"></md-icon>
					<p ng-bind="customer.address"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi mdi-markunread-mailbox"></md-icon>
					<p ng-bind="customer.zipcode"></p>
				</md-list-item>
			</md-list>
		</md-content>
		</md-sidenav>
		<md-content class="bg-white" flex>
			<md-tabs md-dynamic-height md-border-bottom>
			  <md-tab label="<?php echo lang('summary');?>">
				<md-content class="md-padding bg-white">
					<div style="border-right: 1px solid rgb(234, 234, 234);" class="col-md-4 hidden-xs xs-pt-20 lg-pt-0">
						<div class='customer-42525'>
							<div class='customer-42525__inner'>
								<h2><?php echo lang('riskstatus');?></h2>
								<small><?php echo lang('customerrisksubtext');?></small>
								<div ng-hide="customer.risk != '0'" class="stat">
								<span style="color:#eaeaea;"><i class="text-success mdi mdi-shield-check"></i> <?php echo lang('norisk') ?></span>
								</div>
								<div ng-show="customer.risk > '50'" class="stat"><span ng-bind="customer.risk+'%'"></span></div>
								<div ng-show="customer.risk > '50'" class="progress"><div style="width:{{customer.risk}}%" class="progress-bar progress-bar-danger"></div></div>
								<div ng-show="customer.risk > '0' && customer.risk < 50" class="stat"><span ng-bind="customer.risk+'%'"></span></div>
								<div ng-show="customer.risk > '0' && customer.risk < 50" class="progress"><div style="width:{{customer.risk}}%" class="progress-bar progress-bar-primary"></div></div>
								<p><?php echo lang('customerrisksubtext');?></p>
							</div>
						</div>
					</div>
					<div style="border-right: 1px solid rgb(234, 234, 234);" class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
						<div class='customer-42525'>
						  <div class='customer-42525__inner'>
								<h2><?php echo lang('netrevenue');?></h2>
								<small><?php echo lang('netrevenuedetail');?></small>
								<div class='stat'>
									<span ng-show="customer.netrevenue" ng-bind-html="customer.netrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
									<span class="text-success font-10" ng-show="!customer.netrevenue"><?php echo lang('nosalesyet') ?></span>
								</div>
								<p><?php echo lang('netrevenuedescription');?></p>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-xs-6 xs-pt-20 lg-pt-0">
						<div class='customer-42525'>
							<div class='customer-42525__inner'>
								<h2><?php echo lang('grossrevenue');?></h2>
								<small><?php echo lang('grossrevenuedetail');?></small>
								<div class='stat'>
									<span ng-show="customer.grossrevenue" ng-bind-html="customer.grossrevenue | currencyFormat:cur_code:null:true:cur_lct"></span>
									<span ng-show="!customer.grossrevenue"><?php echo lang('nosalesyet') ?></span>
								</div>
								<p><?php echo lang('grossrevenuedescription');?></p>
							</div>
						</div>
					</div>
					<hr style="margin-bottom: 10px;">
					<div class="my-2">
						<div class="chart-wrapper" style="height:210">
							<canvas id="customer_annual_sales_chart" height="300px"></canvas>
						</div>
					</div>
				</md-content>
			  </md-tab>
			  <md-tab label="<?php echo lang('invoices');?>">
				<md-content class="bg-white">
					<md-list flex class="md-p-0 sm-p-0 lg-p-0">
						<md-list-item ng-repeat="invoice in invoices" ng-click="GoInvoice($index)" aria-label="Invoice">
							<md-icon class="ico-ciuis-invoices"></md-icon>
							<p><strong ng-bind="invoice.prefix+'-'+invoice.longid"></strong></p>
							<h4><strong ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
						<md-divider></md-divider>
						</md-list-item>
					</md-list>
					<md-content ng-show="!invoices.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
				</md-content>
			  </md-tab>
			  <md-tab label="<?php echo lang('proposals');?>">
				<md-content class="bg-white">
					<md-list flex class="md-p-0 sm-p-0 lg-p-0">
						<md-list-item ng-repeat="proposal in proposals" ng-click="GoProposal($index)" aria-label="Proposal">
							<md-icon class="ico-ciuis-proposals"></md-icon>
							<p><strong ng-bind="proposal.prefix+'-'+proposal.longid"></strong></p>
							<h4><strong ng-bind-html="proposal.total | currencyFormat:cur_code:null:true:cur_lct"></strong></h4>
						<md-divider></md-divider>
						</md-list-item>
					</md-list>
					<md-content ng-show="!proposals.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
				</md-content>
			  </md-tab>
			  <md-tab label="<?php echo lang('projects');?>">
				<md-content class="bg-white">
					<md-list flex class="md-p-0 sm-p-0 lg-p-0">
						<md-list-item ng-repeat="project in projects" ng-click="GoProject($index)" aria-label="Project">
							<md-icon class="ico-ciuis-projects"></md-icon>
							<p><strong ng-bind="project.name"></strong></p>
							<h4><strong ng-bind="project.status"></strong></h4>
						<md-divider></md-divider>
						</md-list-item>
					</md-list>
					<md-content ng-show="!projects.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
				</md-content>
			  </md-tab>
			  <md-tab label="<?php echo lang('tickets');?>">
				<md-content class="bg-white">
					<md-list flex class="md-p-0 sm-p-0 lg-p-0">
						<md-list-item ng-repeat="ticket in tickets" ng-click="GoTicket($index)" aria-label="Ticket">
							<md-icon class="ico-ciuis-supports"></md-icon>
							<p><strong ng-bind="ticket.subject"></strong></p>
							<p><strong ng-bind="ticket.contactname"></strong></p>
							<h4><strong ng-bind="ticket.priority"></strong></h4>
						<md-divider></md-divider>
						</md-list-item>
					</md-list>
					<md-content ng-show="!tickets.length" class="md-padding bg-white no-item-data"><?php echo lang('notdata') ?></md-content>
				</md-content>
			  </md-tab>
			  <md-tab label="<?php echo lang('notes');?>">
				<md-content class="md-padding bg-white">
					<section class="ciuis-notes show-notes">
						<article ng-repeat="note in notes" class="ciuis-note-detail">
							<div class="ciuis-note-detail-img">
								<img src="<?php echo base_url('assets/img/note.png') ?>" alt="" width="50" height="50" />
							</div>
							<div class="ciuis-note-detail-body">
								<div class="text">
								  <p>
								  <span ng-bind="note.description"></span>
								  <a ng-click='DeleteNote($index)' style="cursor: pointer;" class="mdi ion-trash-b pull-right delete-note-button"></a>
								  </p>
								</div>
								<p class="attribution">
								by <strong><a href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}" ng-bind="note.staff"></a></strong> at <span ng-bind="note.date"></span>
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
			  <md-tab label="<?php echo lang('reminders');?>">
				<md-list ng-cloak>
				  <md-toolbar class="toolbar-white">
					<div class="md-toolbar-tools">
					  <h2><?php echo lang('reminders') ?></h2>
					  <span flex></span>
					  <md-button ng-click="ReminderForm()" class="md-icon-button test-tooltip" aria-label="Add Reminder">
						<md-tooltip md-direction="left"><?php echo lang('addreminder') ?></md-tooltip>
						<md-icon><i class="ion-plus-round text-success"></i></md-icon>
					  </md-button>
					</div>
				  </md-toolbar>
				  <md-list-item ng-repeat="reminder in in_reminders" ng-click="goToPerson(person.name, $event)" class="noright">
					<img alt="{{ reminder.staff }}" ng-src="{{ reminder.avatar }}" class="md-avatar" />
					<p>{{ reminder.description }}</p>
					<md-icon ng-click="" aria-label="Send Email" class="md-secondary md-hue-3" >
					<md-tooltip md-direction="left">{{reminder.date}}</md-tooltip>
					<i class="ion-ios-calendar-outline"></i>
					</md-icon>
					<md-icon ng-click="DeleteReminder($index)" aria-label="Send Email" class="md-secondary md-hue-3" >
					<md-tooltip md-direction="left"><?php echo lang('delete') ?></md-tooltip>
					<i class="ion-ios-trash-outline"></i>
					</md-icon>
				  </md-list-item>
				</md-list>
			  </md-tab>
			  <md-tab label="<?php echo lang('customeractivities');?>">
				<md-content class="md-padding bg-white">
					<ul class="user-timeline">					
						<li ng-repeat="log in logs | filter: { customer_id: '<?php echo $customers['id'];?>' }">
							<div class="user-timeline-title" ng-bind="log.date"></div>
							<div class="user-timeline-description" ng-bind-html="log.detail|trustAsHtml"></div>
						</li>					
					</ul>
				</md-content>
			  </md-tab>
			</md-tabs>
		</md-content>
		</section>
	</div>
	<div class="main-content container-fluid col-md-3 md-pl-0">
		<md-toolbar class="toolbar-white">
		<div class="md-toolbar-tools">
			<h2 flex md-truncate class="pull-left" ><strong><?php echo lang('customercontacts')?></strong></h2>
			<md-button ng-click="NewContact()" class="md-icon-button md-primary" aria-label="Add contact">
				<md-icon class="ion-person-add"></md-icon>
			</md-button>
		</div>
		</md-toolbar>
		<md-content class="bg-white">
		  <md-list flex>
			<md-list-item class="md-2-line" ng-repeat="contact in contacts" ng-click="ContactDetail($index)" aria-label="Contact Detail">
			  <div  data-letter-avatar="MN" class="ticket-area-av-im2 md-avatar"></div>
			  <div class="md-list-item-text" ng-class="{'md-offset': phone.options.offset }">
				<h3 ng-bind="contact.name+' '+contact.surname"></h3>
				<p ng-bind="contact.email"></p>
			  </div>
			<md-divider></md-divider>
			</md-list-item>
		  </md-list>
		</md-content>
	</div>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="NewContact">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('newcontacttitle') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('contactname') ?></label>
			<input type="text" ng-model="newcontact.name" required>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('contactsurname') ?></label>
			<input type="text" ng-model="newcontact.surname" required>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('contactemail') ?></label>
			<input type="text" ng-model="newcontact.email" required>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('contactposition') ?></label>
			<input type="text" ng-model="newcontact.position">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('contactphone') ?></label>
			<input type="text" ng-model="newcontact.phone">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('extension') ?></label>
			<input type="text" ng-model="newcontact.extension">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('contactmobile') ?></label>
			<input type="text" ng-model="newcontact.mobile">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('contactskype') ?></label>
			<input type="text" ng-model="newcontact.skype">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('contactlinkedin') ?></label>
			<input type="text" ng-model="newcontact.linkedin">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('address') ?></label>
			<input type="text" ng-model="newcontact.address">
		</md-input-container>
		<md-input-container class="md-block password-input" ng-show="isPrimary">
			<label><?php echo lang('password') ?></label>
			<input type="text" ng-model="passwordNew" rel="gp" data-size="9" id="nc" data-character-set="a-z,A-Z,0-9,#">
			<md-icon ng-click="getNewPass()" class="ion-refresh" style="display:inline-block;"></md-icon>
		</md-input-container>
		<md-input-container class="md-block pull-left">
			<md-checkbox ng-model="isPrimary"><?php echo lang('primarycontact') ?></md-checkbox>
		</md-input-container>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
		  <md-button ng-click="AddContact()" class="md-raised md-primary pull-right"><?php echo lang('save');?></md-button>
		</section>		
	</md-content>
 </md-content>
</md-sidenav>
<div style="visibility: hidden">
<div ng-repeat="contact in contacts" class="md-dialog-container" id="ContactModal-{{contact.id}}">
  <md-dialog aria-label="Mango (Fruit)">
  <form>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2>{{contact.name}} {{contact.surname}}</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="CloseModal()">
          <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-dialog-content style="max-width:800px;max-height:810px; ">
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="<?php echo lang('contact') ?>">
          <md-content class="md-padding bg-white">
           <md-list flex>
				<md-list-item>
					<md-icon class="mdi mdi-case"></md-icon>
					<p><?php echo lang('contactposition')?></p>
					<p class="md-secondary" ng-bind="contact.position"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi mdi-phone"></md-icon>
					<p><?php echo lang('contactphone')?></p>
					<p class="md-secondary" ng-bind="contact.phone + '-' + contact.extension"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi ion-iphone"></md-icon>
					<p><?php echo lang('contactmobile')?></p>
					<p class="md-secondary" ng-bind="contact.mobile"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi mdi-pin"></md-icon>
					<p><?php echo lang('contactaddress')?></p>
					<p class="md-secondary" ng-bind="contact.address"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi mdi-skype"></md-icon>
					<p><?php echo lang('contactskype')?></p>
					<p class="md-secondary" ng-bind="contact.skype"></p>
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item>
					<md-icon class="mdi mdi-linkedin"></md-icon>
					<p><?php echo lang('contactlinkedin')?></p>
					<p class="md-secondary" ng-bind="contact.linkedin"></p>
				</md-list-item>
			</md-list>
          </md-content>
        </md-tab>
        <md-tab label="<?php echo lang('update') ?>">
          <md-content class="md-padding bg-white">
            <div class="col-md-12 nopadding">
					<md-input-container flex-gt-sm class="col-md-4">
					  <label><?php echo lang('contactname');?></label>
					  <input ng-model="contact.name">
					</md-input-container>
					<md-input-container flex-gt-sm class="col-md-4">
					  <label><?php echo lang('contactsurname');?></label>
					  <input ng-model="contact.surname">
					</md-input-container>
					<md-input-container flex-gt-sm class="col-md-4">
					  <label><?php echo lang('contactposition');?></label>
					  <input ng-model="contact.position">
					</md-input-container>
				</div>
				<div class="col-md-12 nopadding">
					<md-input-container class="col-md-4">
					  <label><?php echo lang('contactphone');?></label>
					  <input ng-model="contact.phone">
					</md-input-container>
					<md-input-container class="col-md-4">
					  <label><?php echo lang('extension');?></label>
					  <input ng-model="contact.extension">
					</md-input-container>
					<md-input-container class="col-md-4">
					  <label><?php echo lang('contactmobile');?></label>
					  <input ng-model="contact.mobile">
					</md-input-container>
				</div>
				<div class="col-md-12 nopadding">
					<md-input-container class="col-md-4">
					  <label><?php echo lang('contactemail');?></label>
					  <input ng-model="contact.email">
					</md-input-container>
					<md-input-container class="col-md-4">
					  <label><?php echo lang('contactskype');?></label>
					  <input ng-model="contact.skype">
					</md-input-container>
					<md-input-container class="col-md-4">
					  <label><?php echo lang('contactlinkedin');?></label>
					  <input ng-model="contact.linkedin">
					</md-input-container>
				</div>
				<div class="col-md-12 nopadding">
					<md-input-container class="col-md-12">
					  <label><?php echo lang('contactaddress');?></label>
					  <input ng-model="contact.address">
					</md-input-container>
				</div>
          </md-content>
        </md-tab>
      </md-tabs>
    </md-dialog-content>
    <md-dialog-actions layout="row">
      <md-button ng-click='ChangePassword(contact.id, contact.password)' md-autofocus>
       	<?php echo lang('changepassword')?>
      </md-button>
      <span flex></span>
      <md-button ng-click='RemoveContact(contact.id)' ng-click="answer('not useful')" >
        <?php echo lang('delete')?>
      </md-button>
      <md-button ng-click="UpdateContact($index)" ng-click="answer('useful')" style="margin-right:20px;" >
        <?php echo lang('update')?>
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>
</div>
</div>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ReminderForm">
  <md-toolbar class="md-theme-light" style="background:#262626">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('addreminder') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container class="md-block">
			<label><?php echo lang('datetobenotified') ?></label>
			<input mdc-datetime-picker="" date="true" time="true" type="text" id="datetime" placeholder="<?php echo lang('chooseadate') ?>" show-todays-date="" minutes="true" min-date="date" show-icon="true" ng-model="reminder_date" class=" dtp-no-msclear dtp-input md-input">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('setreminderto'); ?></label>
			<md-select placeholder="<?php echo lang('setreminderto'); ?>" ng-model="reminder_staff" name="country_id" style="min-width: 200px;">
				<md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
			</md-select>
		</md-input-container>
		<br>
		<md-input-container class="md-block">
			<label><?php echo lang('description') ?></label>
			<textarea required name="description" ng-model="reminder_description" placeholder="Type something" class="form-control note-description"></textarea>
		</md-input-container>
		<div class="form-group pull-right">
			<button ng-click="AddReminder()" type="button" class="btn btn-warning btn-xl ion-ios-paperplane" type="submit"> <?php echo lang('addreminder')?></button>
		</div>
	</md-content>
 </md-content>
</md-sidenav>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Update">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('update') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container ng-show="customer.type == '0'" class="md-block">
			<label><?php echo lang('company'); ?></label>
			<md-icon md-svg-src="<?php echo base_url('assets/img/icons/company.svg') ?>"></md-icon>
			<input name="company" ng-model="customer.company">
		</md-input-container>
		<md-input-container ng-show="customer.type == '1'" class="md-block">
			<label><?php echo lang('namesurname'); ?></label>
			<md-icon md-svg-src="<?php echo base_url('assets/img/icons/individual.svg') ?>"></md-icon>
			<input name="namesurname" ng-model="customer.namesurname">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('taxofficeedit'); ?></label>
			<input name="taxoffice" ng-model="customer.taxoffice">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('taxnumberedit'); ?></label>
			<input name="taxnumber" ng-model="customer.taxnumber">
		</md-input-container>
		<md-input-container ng-show="customer.type == '1'" class="md-block">
			<label><?php echo lang('ssn'); ?></label>
			<input name="ssn" ng-model="customer.ssn" ng-pattern="/^[0-9]{3}-[0-9]{2}-[0-9]{4}$/" />
			<div class="hint" ng-if="showHints">###-##-####</div>
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('executiveupdate'); ?></label>
			<input name="executive" ng-model="customer.executive">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('phone'); ?></label>
			<input name="phone" ng-model="customer.phone">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('fax'); ?></label>
			<input name="fax" ng-model="customer.fax">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('email'); ?></label>
			<input name="email" ng-model="customer.email" required minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/" />
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('customerweb'); ?></label>
			<input name="web" ng-model="customer.web">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('country'); ?></label>
			<md-select placeholder="<?php echo lang('country'); ?>" ng-model="customer.country_id" name="country_id" style="min-width: 200px;">
				<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
			</md-select>
		</md-input-container>
		<br>
		<md-input-container class="md-block">
			<label><?php echo lang('state'); ?></label>
			<input name="state" ng-model="customer.state">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('city'); ?></label>
			<input name="city" ng-model="customer.city">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('town'); ?></label>
			<input name="town" ng-model="customer.town">
		</md-input-container>
		<md-input-container class="md-block">
			<label><?php echo lang('zipcode'); ?></label>
			<input name="zipcode" ng-model="customer.zipcode">
		</md-input-container>
		<md-input-container class="md-block">
		  <label><?php echo lang('address') ?></label>
		  <textarea ng-model="customer.address" name="address" md-maxlength="500" rows="3" md-select-on-focus></textarea>
		</md-input-container>
		<md-slider-container>
		  <span><?php echo lang('riskstatus');?></span>
		  <md-slider flex min="0" max="100" ng-model="customer.risk" aria-label="red" id="red-slider">
		  </md-slider>
		  <md-input-container>
			<input name="risk" flex type="number" ng-model="customer.risk" aria-label="red" aria-controls="red-slider">
		  </md-input-container>
		</md-slider-container>
		<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
		  <md-button ng-click="UpdateCustomer()" class="md-raised md-primary pull-right"><?php echo lang('update');?></md-button>
		</section>		
	</md-content>
 </md-content>
</md-sidenav>
</div>
<script>
	var CUSTOMERID = "<?php echo $customers['id'];?>";
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>