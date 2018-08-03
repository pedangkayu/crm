<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Proposal_Controller">
	<div class="main-content container-fluid col-md-9 borderten">
		<md-toolbar class="toolbar-white">
		  <div class="md-toolbar-tools">
			<md-button class="md-icon-button" aria-label="Settings" ng-disabled="true">
			  <md-icon><i class="ico-ciuis-proposals text-warning"></i></md-icon>
			</md-button>
			<h2 flex md-truncate><?php echo $proposals['subject'];?></h2>
			<md-button ng-href="<?php echo base_url('proposals/share/{{proposal.id}}')?>" class="md-icon-button" aria-label="Email">
		  		<md-tooltip md-direction="bottom"><?php echo lang('send') ?></md-tooltip>
			  	<md-icon><i class="mdi mdi-email text-muted"></i></md-icon>
			</md-button>
			<md-button ng-href="<?php echo base_url('proposals/download/{{proposal.id}}') ?>" class="md-icon-button" aria-label="PDF">
		  		<md-tooltip md-direction="bottom"><?php echo lang('download') ?></md-tooltip>
			  	<md-icon><i class="mdi mdi-collection-pdf text-muted"></i></md-icon>
			</md-button>
			<md-button ng-href="<?php echo base_url('proposals/print_/{{proposal.id}}') ?>" class="md-icon-button" aria-label="Print">
		  		<md-tooltip md-direction="bottom"><?php echo lang('print') ?></md-tooltip>
			  	<md-icon><i class="mdi mdi-print text-muted"></i></md-icon>
			</md-button>
			<div ng-if="!proposal.invoice_id" class="btn-group btn-hspace pull-right">
			<md-button data-toggle="dropdown" class="md-icon-button dropdown-toggle" aria-label="Convert">
		  		<md-tooltip md-direction="bottom"><?php echo lang('convert') ?></md-tooltip>
			  	<md-icon><i class="ion-loop text-success"></i></md-icon>
			</md-button>
			<ul role="menu" class="dropdown-menu">
				<li <?php if($proposals['relation_type'] == 'lead'){echo 'disabled data-toggle="tooltip" data-placement="right" data-container="body" title="'.lang('leadproposalconvertalert').'"';}  ?>><?php if($proposals['relation_type'] == 'customer'){echo '<a href="'.base_url('proposals/convert_invoice/{{proposal.id}}').'">'.lang('invoice').'</a>';}  ?><?php if($proposals['relation_type'] == 'lead'){echo '<a style="cursor: not-allowed;" href="#">'.lang('invoice').'</a>';}  ?></li>
			</ul>
			</div>
			<md-button ng-if="proposal.invoice_id" ng-href="<?php echo base_url('invoices/invoice/{{proposal.invoice_id}}')?>" class="md-icon-button">
				<md-tooltip md-direction="bottom"><?php echo lang('invoice') ?></md-tooltip>
			  	<md-icon><i class="ion-document-text text-success"></i></md-icon>
			</md-button>
			<div class="btn-group btn-hspace pull-right">
			<md-button class="md-icon-button dropdown-toggle" aria-label="Actions" data-toggle="dropdown">
		  		<md-tooltip md-direction="bottom"><?php echo lang('action') ?></md-tooltip>
			  	<md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
			</md-button>
			<ul role="menu" class="dropdown-menu">
				<li><a href="<?php echo base_url('share/proposal/{{proposal.token}}')?>" target="_blank"><?php echo lang('viewproposal') ?></a> </li>
				<li><a href="<?php echo base_url('proposals/expiration/{{proposal.id}}')?>"><?php echo lang('sentexpirationreminder')  ?></a> </li>
				<li data-sname="Draft" data-status="1" data-proposal="{{proposal.id}}"><a class="mark-as-btw" href="#"><?php echo lang('markasdraft') ?></a> </li>
				<li data-sname="Sent" data-status="2" data-proposal="{{proposal.id}}"><a class="mark-as-btw" href="#"><?php echo lang('markassent'); ?></a> </li>
				<li data-sname="Open" data-status="3" data-proposal="{{proposal.id}}"><a class="mark-as-btw" href="#"><?php echo lang('markasopen'); ?></a> </li>
				<li data-sname="Revised" data-status="4" data-proposal="{{proposal.id}}"><a class="mark-as-btw" href="#"><?php echo lang('markasrevised'); ?></a> </li>
				<li data-sname="Declined" data-status="5" data-proposal="{{proposal.id}}"><a class="mark-as-btw" href="#"><?php echo lang('markasdeclined'); ?></a> </li>
				<li data-sname="Accepted" data-status="6" data-proposal="{{proposal.id}}"><a class="mark-as-btw" href="#"><?php echo lang('markasaccepted'); ?></a> </li>
				<li class="divider"> <a href="#"></a> </li>
				<li><a href="<?php echo base_url('proposals/update/{{proposal.id}}')?>"><?php echo lang('edit') ?></a></li>
				<li class="divider"> <a href="#"></a> </li>
				<li><a href="<?php echo base_url('proposals/remove/{{proposal.id}}')?>" class="text-danger"><?php echo lang('delete') ?></a></li>
			</ul>
			</div>
		  </div>
		</md-toolbar>
		<md-content class="bg-white">
		<md-tabs md-dynamic-height md-border-bottom>
		  <md-tab label="<?php echo lang('proposal'); ?>">
			<md-content class="md-padding bg-white">
			<div class="proposal">
				<main>
					<div id="details" class="clearfix">
						<div id="company">
							<h2 class="name"><?php echo $settings['company'] ?></h2>
							<div><?php echo $settings['address'] ?></div>
							<div><?php echo lang('phone')?>:</b><?php echo $settings['phone'] ?></div>
							<div><a href="mailto:<?php echo $settings['email'] ?>"><?php echo $settings['email'] ?></a></div>
						</div>
						<div id="client">
							<div class="to"><span><?php echo lang('proposalto'); ?>:</span></div>
							<h2 class="name"><?php if($proposals['relation_type'] == 'customer'){if($proposals['customercompany']===NULL){echo $proposals['namesurname'];} else echo $proposals['customercompany'];} ?><?php if($proposals['relation_type'] == 'lead'){echo $proposals['leadname'];} ?></h2>
							<div class="address"><?php echo $proposals['toaddress']; ?></div>
							<div class="email"><a href="mailto:<?php echo $proposals['toemail']; ?>"><?php echo $proposals['toemail']; ?></a></div>
						</div>
						<div id="invoice">
							<h1 ng-bind="proposal.long_id"></h1>
							<div class="date"><?php echo lang('dateofissuance')?>: <span ng-bind="proposal.date"></span></div>
							<div class="date text-bold"><?php echo lang('opentill')?>: <span ng-bind="proposal.opentill"></span></div>
							<span class="text-uppercase" ng-bind="proposal.status_name"></span>
						</div>
					</div>
					<table border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th class="desc"><?php echo lang('description') ?></th>
								<th class="qty"><?php echo lang('quantity') ?></th>
								<th class="unit"><?php echo lang('price') ?></th>
								<th class="discount"><?php echo lang('discount') ?></th>
								<th class="tax"><?php echo lang('vat') ?></th>
								<th class="total"><?php echo lang('total') ?></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="item in proposal.items">
								<td class="desc">
									<h3 ng-bind="item.name"><br></h3>
									<span ng-bind="item.description"></span>
								</td>
								<td class="qty" ng-bind="item.quantity"></td>
								<td class="unit"><span ng-bind-html="item.price | currencyFormat:cur_code:null:true:cur_lct"></span></td>
								<td class="discount" ng-bind="item.discount+'%'"></td>
								<td class="tax" ng-bind="item.tax+'%'"></td>
								<td class="total"><span ng-bind-html="item.total | currencyFormat:cur_code:null:true:cur_lct"></span></td>
							</tr>
						</tbody>
					</table>
					<div class="col-md-12 md-pr-0" style="font-weight: 900; font-size: 16px; color: #c7c7c7;">
						<div class="col-md-10">
							<div class="text-right text-uppercase text-muted">Sub Total:</div>
							<div ng-show="linediscount() > 0" class="text-right text-uppercase text-muted">Total Discount:</div>
							<div ng-show="totaltax() > 0"class="text-right text-uppercase text-muted">Total Tax:</div>
							<div class="text-right text-uppercase text-black">Grand Total:</div>
						</div>
						<div class="col-md-2">
							<div class="text-right" ng-bind-html="subtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
							<div ng-show="linediscount() > 0" class="text-right" ng-bind-html="linediscount() | currencyFormat:cur_code:null:true:cur_lct"></div>
							<div ng-show="totaltax() > 0"class="text-right" ng-bind-html="totaltax() | currencyFormat:cur_code:null:true:cur_lct"></div>
							<div class="text-right" ng-bind-html="grandtotal() | currencyFormat:cur_code:null:true:cur_lct"></div>
						</div>
					</div>
				</main>
			</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('notes'); ?>">
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
		  <md-tab label="<?php echo lang('comments'); ?>">
			<md-content class="md-padding bg-white">
			 <section class="ciuis-notes show-notes">
					<article ng-repeat="comment in proposal.comments" class="ciuis-note-detail">
						<div class="ciuis-note-detail-img">
							<img src="<?php echo base_url('assets/img/comment.png') ?>" alt="" width="50" height="50" />
						</div>
						<div class="ciuis-note-detail-body">
							<div class="text"><p ng-bind="comment.content"></p></div>
							<p class="attribution"><strong>Customer Comment</strong> at <span ng-bind="comment.created"></span></p>
						</div>
					</article>
				</section>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('reminders'); ?>">
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
		</md-tabs>
	  </md-content>
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

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
</div>
<script>
	var PROPOSALID = "<?php echo $proposals['id'];?>";
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>