<aside class="page-aside hidden-md hidden-sm hidden-xs ciuis-sag-sidebar-xs">
	<div id="events">
		<div class="ciuis-1 col-xs-12 nopadding">
			<div class="col-xs-6 nopadding date-and-time-ciuis">
				<i class="ion-ios-clock-outline"></i>
				<span id="time-ciuis" ng-bind="date | date:'HH:mm'"></span>
			</div>
			<div class="col-xs-6 date-a" ng-bind="date | date:'dd, MMMM yyyy EEEE'"></div>
		</div>
		<div class="row">
			<div class="ciuis-activity-line col-md-12">
				<ul class="ciuis-activity-timeline" style="margin-top: 60px;">
					<li ng-repeat="log in logs | limitTo: LogLimit"class="ciuis-activity-detail">
						<div class="ciuis-activity-title" ng-bind="log.date"></div>
						<div class="ciuis-activity-detail-body">
							<div ng-bind-html="log.detail|trustAsHtml"></div>
							<div style="margin-right: 15px; border-radius: 3px; background: transparent; color: #2f3239; font-weight: 400;" class="pull-right label label-default">
								<small class="log-date"><i class="ion-android-time"></i> <span ng-bind="log.logdate"></span></small>
							</div>
						</div>
					</li>
					<load-more></load-more>
				</ul>
			</div>
		</div>
	</div>
</aside>