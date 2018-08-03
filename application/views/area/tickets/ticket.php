
<div class="ciuis-body-content" ng-controller="Ticket_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
	<md-toolbar class="toolbar-white">
		  <div class="md-toolbar-tools">
			<md-button class="md-icon-button" aria-label="Settings" ng-disabled="true">
			  <md-icon><i class="ico-ciuis-supports text-muted"></i></md-icon>
			</md-button>
			<h2 flex md-truncate ng-bind="ticket.subject"></h2>
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
										<div class="ticket-data"><strong ng-bind="ticket.customer"></strong></div>
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
								<?php echo form_open_multipart('area/reply/'.$ticket['id'].''); ?>
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
<?php include_once(APPPATH . 'views/area/inc/sidebar.php'); ?>

</div>
<script>var TICKETID = "<?php echo $ticket['id'];?>";</script>
