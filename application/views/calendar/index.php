<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Calendar_Controller">
	<md-content class="main-content container-fluid col-md-12">
		<md-content class="bg-white">
			<md-content id="calendar" class="bg-white col-md-9" layout-padding></md-content>
			<md-content class="bg-white col-md-3">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate ><strong><?php echo lang('events') ?></strong></h2>
					<md-button ng-click="EventForm()" class="md-icon-button" aria-label="Create">
						<md-tooltip md-direction="bottom"><?php echo lang('addevent') ?></md-tooltip>
						<md-icon><i class="mdi mdi-plus-circle-o text-muted"></i></md-icon>
					</md-button>
				</div>
			</md-toolbar>
			<md-content class="events events_xs calendar-events" style="margin-top: 0px">
				<md-subheader class="md-no-sticky event-subheader"><i class="mdi mdi-calendar-alt"></i> <?php echo lang('today_events') ?></md-subheader>
				<ul style="padding: 0px 20px 0px 20px;">
					<li ng-repeat="event in today_events" class="{{event.status}}">
						<label class="date"> <span class="weekday" ng-bind="event.day"></span><span class="day" ng-bind="event.aday"></span> </label>
						<h3 ng-bind="event.title"></h3>
						<p>
							<span class='duration' ng-bind="event.start_iso_date | date : 'MMM d, y h:mm:ss a'"></span>
							<span class='location' ng-bind="event.staff"></span>
						</p>
					</li>
				</ul>
				<md-content ng-show="!today_events.length" class="text-center bg-white">
				<h1 class="text-success"><i class="mdi mdi-calendar-check"></i></h1>
				<span class="text-muted"><?php echo lang('no_event_today') ?></span>
				</md-content>
			</md-content>
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<h2 flex md-truncate ><strong><?php echo lang('appointments') ?></strong></h2>
				</div>
			</md-toolbar>
			<md-content class="appointments appointments_xs calendar-appointments" style="margin-top: 0px">
				<md-subheader class="md-no-sticky event-subheader"><i class="mdi mdi-calendar-alt"></i> <?php echo lang('requested_appointments') ?></md-subheader>
				<ul style="padding: 0px 20px 0px 20px;">
					<li ng-repeat="appointment in requested_appointments" class="{{appointment.status_class}}" ng-click="ShowAppointment($index)">
						<label class="date"> <span class="weekday" ng-bind="appointment.day"></span><span class="day" ng-bind="appointment.aday"></span> </label>
						<h3 ng-bind="appointment.title"></h3>
						<p>
							<span class='duration' ng-bind="appointment.start_iso_date | date : 'MMM d, y h:mm:ss a'"></span>
							<span class='location' ng-bind="appointment.staff"></span>
						</p>
					</li>
				</ul>
				<md-content ng-show="!requested_appointments.length" class="text-center bg-white">
				<h1 class="text-success"><i class="mdi mdi-calendar-note"></i></h1>
				<span class="text-muted"><?php echo lang('no_requested_appointment') ?></span>
				</md-content>
			</md-content>
			<md-content class="appointments appointments_xs calendar-appointments" style="margin-top: 0px">
				<md-subheader class="md-no-sticky event-subheader"><i class="mdi mdi-calendar-alt"></i> <?php echo lang('today_appointments') ?></md-subheader>
				<ul style="padding: 0px 20px 0px 20px;">
					<li ng-repeat="appointment in today_appointments" class="{{appointment.status_class}}" ng-click="ShowAppointment($index)">
						<label class="date"> <span class="weekday" ng-bind="appointment.day"></span><span class="day" ng-bind="appointment.aday"></span> </label>
						<h3 ng-bind="appointment.title"></h3>
						<p>
							<span class='duration' ng-bind="appointment.start_iso_date | date : 'MMM d, y h:mm:ss a'"></span>
							<span class='location' ng-bind="appointment.staff"></span>
						</p>
					</li>
				</ul>
				<md-content ng-show="!today_appointments.length" class="text-center bg-white">
				<h1 class="text-success"><i class="mdi mdi-calendar-note"></i></h1>
				<span class="text-muted"><?php echo lang('no_appointment_today') ?></span>
				</md-content>
			</md-content>
			</md-content>
		</md-content>
	</md-content>
	<div id="fullCalModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only"><?php echo lang('close')?></span></button>
					<h4 id="modalTitle" class="modal-title text-bold"></h4>
				</div>
				<div id="modalBody" class="modal-body">
					<p id="eventdetail"></p>
					<div class="pull-right">
					
					</div>
				</div>
				<div class="modal-footer">
					<div class="ticket-data user-avatar pull-left">
						<b id="staffname"></b>
						<span id="startdate"></span>
						<span id="enddate"></span>
					</div>
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<?php echo lang('close')?>
					</button>
					<button class="btn btn-default"><a id="eventUrl" target="_blank"><?php echo lang('delete')?></a></button>
				</div>
			</div>
		</div>
	</div>
<div style="visibility: hidden">
<div ng-repeat="appointment in appointments" class="md-dialog-container" id="Appointment-{{appointment.id}}">
<md-dialog aria-label="Appointment Detail">
  <form>
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <h2>{{appointment.title}}</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="close()">
          <md-icon class="ion-close-round" aria-label="Close dialog" style="color:black"></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-dialog-content style="max-width:800px;max-height:810px; ">
       <md-content class="bg-white">
      	<md-list flex>
			<md-list-item>
				<md-icon class="ion-person"></md-icon>
				<p ng-bind="appointment.contact"></p>
			</md-list-item>
			<md-divider></md-divider>
			<md-content layout-padding>
      	<h3 class="md-mt-0" ng-bind="appointment.start_iso_date | date : 'MMM d, y h:mm:ss a'"></h3>
      	<span ng-bind="appointment.detail"></span>
      </md-content>
			<md-list-item>
				<md-icon class="ion-flag"></md-icon>
				<p ng-if="appointment.status == '0'"><strong class="text-warning"><?php echo lang('requested') ?></strong></p>
				<p ng-if="appointment.status == '1'"><strong class="text-success"><?php echo lang('confirmed') ?></strong></p>
				<p ng-if="appointment.status == '2'"><strong class="text-danger"><?php echo lang('declined') ?></strong></p>
				<p ng-if="appointment.status == '3'"><strong class="text-success"><?php echo lang('done') ?></strong></p>
			</md-list-item>
		</md-list>
      </md-content>     
    </md-dialog-content>
    <md-dialog-actions layout="row">
      <md-button ng-click='MarkAsDoneAppointment(appointment.id)' aria-label="Done">
       	<?php echo lang('mark_as_done')?>
      </md-button>
      <span flex></span>
      <md-button ng-click='DeclineAppointment(appointment.id)' aria-label="Decline">
        <?php echo lang('decline')?> <i class="ion-close-round"></i>
      </md-button>
      <md-button ng-click="ConfirmAppointment(appointment.id)" style="margin-right:20px;" aria-label="Confirm">
        <?php echo lang('confirm')?> <i class="ion-checkmark-round"></i>
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>
</div>
</div>
</div>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<script src='<?php echo base_url('assets/lib/jquery.fullcalendar/fullcalendar.min.js'); ?>'></script>
<script src='<?php echo base_url('assets/lib/jquery.fullcalendar/locale-all.js'); ?>'></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/jquery.fullcalendar/fullcalendar.min.css'); ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/jquery.fullcalendar/ciuis_calendar.css'); ?>"/>
<script type="text/javascript">
	$( document ).ready( function () {
		//initialize the javascript
		App.init();
		App.pageCalendar();
	} );
</script>
<script>
	var App = ( function () {
		'use strict';
		App.pageCalendar = function () {
			$( '#external-events .fc-event' ).each( function () {
				// store data so the calendar knows to render an event upon drop
				$( this ).data( 'event', {
					title: $.trim( $( this ).text() ), // use the element's text as the event title
					stick: true // maintain when user navigates (see docs on the renderEvent method)
				} );
				// make the event draggable using jQuery UI
				$( this ).draggable( {
					zIndex: 999,
					revert: true, // will cause the event to go back to its
					revertDuration: 0 //  original position after the drag
				} );
			} );
			
			
			locale: '<?php echo lang('initial_locale_code'); ?>',
			
			$('#calendar').fullCalendar({
				locale: initialLocaleCode,
				editable: false,
				header: {
					left: "prev,next today",
					center: "title",
					right: "month,agendaWeek,agendaDay,listWeek"
				},
				eventClick: function ( event, jsEvent, view ) {
					$( '#modalTitle' ).html( event.title );
					$( '#eventdetail' ).html( event.detail );
					$( '#staffname' ).html( event.staff );
					$( '#startdate' ).html( event.start_date );
					$( '#enddate' ).html( event.end_date );
					$( '#eventUrl' ).attr( 'href', '<?php echo base_url('calendar/remove/')?>' + event.id );
					$( '#fullCalModal' ).modal();
				},
				eventSources: [
					{
						url: '<?php echo base_url('api/events');?>', 
						color: 'white',   
						textColor: 'black'  
						
					},
					{
						url: '<?php echo base_url('api/confirmed_appointments');?>',
						color: '#ffe291',   
						textColor: '#ffffff' 
						
					}
				]
			});
		};
		return App;
	} )( App || {} );
</script> 
</body> 
</html>