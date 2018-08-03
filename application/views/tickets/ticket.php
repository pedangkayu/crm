<div class="ciuis-body-content" ng-controller="Ticket_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
	<md-toolbar class="toolbar-white">
		  <div class="md-toolbar-tools">
			<md-button class="md-icon-button" aria-label="Settings" ng-disabled="true">
			  <md-icon><i class="ico-ciuis-supports text-muted"></i></md-icon>
			</md-button>
			<h2 flex md-truncate ng-bind="ticket.subject"></h2>
			<md-button ng-hide="ONLYADMIN != 'true'" ng-click="AssigneStaff()" class="md-icon-button md-primary" aria-label="Add Member">
				<md-tooltip md-direction="bottom"><?php echo lang('assignstaff') ?></md-tooltip>
				<md-icon class="ion-person-add"></md-icon>
			</md-button>
			<md-button ng-hide="ONLYADMIN != 'true'" ng-click="Delete()" class="md-icon-button" aria-label="Delete">
				<md-tooltip md-direction="bottom"><?php echo lang('delete') ?></md-tooltip>
				<md-icon><i class="ion-trash-b text-muted"></i></md-icon>
			</md-button>
			<div class="btn-group btn-hspace pull-right">
			<md-button class="md-icon-button dropdown-toggle" aria-label="Actions" data-toggle="dropdown">
		  		<md-tooltip md-direction="bottom"><?php echo lang('action') ?></md-tooltip>
			  	<md-icon><i class="ion-android-more-vertical text-muted"></i></md-icon>
			</md-button>
			<ul class="dropdown-menu" role="menu">
				<li data-sname="<?php echo lang('open') ?>" data-status="1" data-ticket="<?php echo $ticket['id']; ?>"><a class="mark-as-t" href="#"><?php echo lang('markasopen') ?></a></li>
				<li data-sname="<?php echo lang('inprogress') ?>" data-status="2" data-ticket="<?php echo $ticket['id']; ?>"><a class="mark-as-t" href="#"><?php echo lang('markasinprogress') ?></a></li>
				<li data-sname="<?php echo lang('answered') ?>" data-status="3" data-ticket="<?php echo $ticket['id']; ?>"><a class="mark-as-t" href="#"><?php echo lang('markasanswered') ?></a></li>
				<li data-sname="<?php echo lang('closed') ?>" data-status="4" data-ticket="<?php echo $ticket['id']; ?>"><a class="mark-as-t" href="#"><?php echo lang('markasclosed') ?></a></li>
			</ul>
			</div>
		  </div>
		</md-toolbar>
		<div class="ticket-container tab-container">
			<div class="active-view">
				<div class="ciuis-ticket">
					<div class="panel borderten">
						
						<div class="ciuis-ticket-detail full-scroll tab-pane cont" id="ticketdetail">
							<div class="ciuis-ticket-info">
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label"><?php echo lang('assignedstaff')?></div>
										<div class="ticket-data" ng-bind="ticket.assigned_staff_name"></div>
									</div>
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label"><?php echo lang('customer')?></div>
										<div class="ticket-data"><a href="<?php echo base_url('customers/customer/{{ticket.customer_id}}')?>" ng-bind="ticket.customer"></a></div>
									</div>
								</div>
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label"><?php echo lang('contactname')?></div>
										<div class="ticket-data" ng-bind="ticket.contactname"></div>
									</div>
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label"><?php echo lang('department')?></div>
										<div class="ticket-data" ng-bind="ticket.department"></div>
									</div>
								</div>
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('status')?>
										</div>
										<div class="ticket-data label-status" ng-bind="ticket.status"></div>
									</div>
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('priority')?>
										</div>
										<div class="ticket-data" ng-bind="ticket.priority"></div>
									</div>
								</div>
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('datetimeopened')?>
										</div>
										<div class="ticket-data" ng-bind="ticket.opened_date"></div>
									</div>
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('datetimelastreplies')?>
										</div>
										<div class="ticket-data" ng-bind="ticket.last_reply_date"></div>
									</div>
								</div>
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup full">
										<div class="ticket-label"><strong><?php echo lang('message') ?></strong></div>
										<div style="padding: 10px; border-radius: 3px; margin-bottom: 10px; font-weight: 600; background: #f3f3f3;" class="ticket-data">
											<span ng-bind="ticket.message"></span>
											<span ng-show="ticket.attachment" class="label label-default pull-right"><i class="ion-android-attach"></i> <a href="<?php echo base_url('uploads/attachments/{{ticket.attachment}}') ?>" ng-bind="ticket.attachment"></a></span>
										</div>
										
									</div>
								</div>
								<div class="ticket-replies row">
								<div class="col-md-12">
								<section class="ciuis-notes show-notes">
									<article class="ciuis-note-detail" ng-repeat="reply in ticket.replies">
										<div class="ciuis-note-detail-img">
											<img src="<?php echo base_url('assets/img/comment.png') ?>" alt="" width="50" height="50" />
										</div>
										<div class="ciuis-note-detail-body">
											<div class="text">
											  <p>
											  <span ng-bind="reply.message"></span>
											  <span><a class="delete-note-button pull-right" href="<?php echo base_url('uploads/attachments/{{reply.attachment}}') ?>"><i class="ion-android-attach"></i></a></span>
											  </p>
											</div>
											<p class="attribution"><?php echo lang('repliedby') ?> <strong ng-bind="reply.name"></strong> at <span ng-bind="reply.date"></span></p>
										</div>
									</article>
								</section>
								</div>
								<div class="col-md-12">
								<section class="md-pb-30">
								<?php echo form_open_multipart('tickets/reply/'.$ticket['id'].''); ?>
									<md-input-container class="md-block">
									<label><?php echo lang('reply') ?></label>
									<textarea name="message" ng-model="reply.message" placeholder="Type something" class="form-control answer"></textarea>
									</md-input-container>
									<div class="form-group pull-left">
										<div class="file-upload">
											<div class="file-select">
												<div class="file-select-button" id="fileName"><span class="mdi ion-android-attach"></span>
													<?php echo lang('attachment')?>
												</div>
												<div class="file-select-name" id="noFile">
													<?php echo lang('notchoise')?>
												</div>
												<input type="file" name="attachment" id="chooseFile">
											</div>
										</div>
									</div>
									<md-button type="submit" class="md-raised md-primary pull-right"><?php echo lang('reply');?></md-button>
								<?php echo form_close(); ?>
								</section>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

<script type="text/ng-template" id="insert-member-template.html">
  <md-dialog aria-label="options dialog">
	<md-dialog-content layout-padding>
	  <h2 class="md-title"><?php echo lang('assigned'); ?></h2>
		<md-select required ng-model="AssignedStaff" style="min-width: 200px;" aria-label="AddMember">
			<md-option ng-value="staff.id" ng-repeat="staff in staff">{{staff.name}}</md-option>
		</md-select>
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
	  <md-button ng-click="AssignStaff()"><?php echo lang('add') ?>!</md-button>
	</md-dialog-actions>
  </md-dialog>
</script>
</div>
<script>
	var TICKETID = "<?php echo $ticket['id'];?>";
</script>