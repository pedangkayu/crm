<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Invoices_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div ng-hide="ONLYADMIN != 'true'" class="panel-default">
			<div class="ciuis-invoice-summary"></div>
		</div>
		<md-toolbar class="toolbar-white">
			<div class="md-toolbar-tools">
				<h2 flex md-truncate class="text-bold"><?php echo lang('invoices'); ?><br><small flex md-truncate><?php echo lang('organizeyourinvoices'); ?></small></h2>
				<div class="ciuis-external-search-in-table">
					<input ng-model="search.customer" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
					<md-button class="md-icon-button" aria-label="Search">
						<md-icon><i class="ion-search text-muted"></i></md-icon>
					</md-button>
				</div>
				<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter">
					<md-icon><i class="ion-android-funnel text-muted"></i></md-icon>
				</md-button>
				<md-button ng-href="<?php echo base_url('invoices/create') ?>" class="md-icon-button" aria-label="New">
					<md-icon><i class="ion-plus-round text-muted"></i></md-icon>
				</md-button>
			</div>
		</md-toolbar>
		<md-content>
			<ul class="custom-ciuis-list-body" style="padding: 0px;">
				<li ng-repeat="invoice in invoices | filter: FilteredData |  filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="ciuis-custom-list-item ciuis-special-list-item">
					<ul class="list-item-for-custom-list">
						<li class="ciuis-custom-list-item-item col-md-12">
						<div class="assigned-staff-for-this-lead user-avatar"><i class="ico-ciuis-invoices" style="font-size: 32px"></i></div>
							<div class="pull-left col-md-3">
							<strong>
							<a class="ciuis_expense_receipt_number" href="<?php echo base_url('invoices/invoice/'); ?>{{invoice.id}}"><span ng-bind="invoice.prefix + '-' + invoice.longid"></span></a>
							</strong><br><small ng-bind="invoice.customer"></small>
							</div>
							<div class="col-md-9">
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('billeddate'); ?></small><br><strong><span class="badge" ng-bind="invoice.created"></span></strong></span>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('invoiceduedate'); ?></small><br><strong><span class="badge" ng-bind="invoice.duedate"></span></strong></span>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('status'); ?></small><br><strong class="text-uppercase text-{{invoice.color}}" ng-bind="invoice.status"></strong>
								</div>
								<div class="col-md-3 text-right">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('amount'); ?></small><br><strong ng-bind-html="invoice.total | currencyFormat:cur_code:null:true:cur_lct"></strong></span>
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
			<md-content ng-show="!invoices.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>	
		</md-content>
		</div>
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="ContentFilter">
   </md-toolbar>
	<md-toolbar class="md-theme-light" style="background:#262626">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<md-truncate><?php echo lang('filter') ?></md-truncate>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	 <div ng-repeat="(prop, ignoredValue) in invoices[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'prefix' && prop != 'longid' && prop != 'created' && prop != 'duedate' && prop != 'customer' && prop != 'total' && prop != 'status' && prop != 'color' && prop != 'customer_id' && prop != 'staff_id'">
	  <div class="filter col-md-12">
		<h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
		<hr>
		<div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycustomer') ?>'">
			<md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
		</div>
		<div ng-if="prop=='<?php echo lang('filterbycustomer') ?>'">
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
<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

</div>
<?php include_once(APPPATH . 'views/inc/footer.php');?>

<script type="text/javascript">
(function umd(root, name, factory)
	{
	  'use strict';
	  if ('function' === typeof define && define.amd) {
		define(name, ['jquery'], factory);
	  } else {
		root[name] = factory();
	  }
	}
	(this, 'CiuisInvoiceStats', function UMDFactory()
		{
		  'use strict';
		  var ReportOverview = ReportOverviewConstructor;
		  reportCircleGraph();
		  return ReportOverview;
		  function ReportOverviewConstructor(options) {
			var factory = {
				init: init
			  },
			  _elements = {
				$element: options.element
			  };
			init();
			return factory;
			function init() {
			  _elements.$element.append($(getTemplateString()));

			  $('.invoice-percent').percentCircle({
				width: 130,
				trackColor: '#ececec',
				barColor: '#22c39e',
				barWeight: 3,
				endPercent: 0.<?php echo $ofx ?>,
				fps: 60
			  });
			  $('.invoice-percent-2').percentCircle({
				width: 130,
				trackColor: '#ececec',
				barColor: '#ee7a6b',
				barWeight: 3,
				endPercent: 0.<?php echo $ofy ?>,
				fps: 60
			  });

			  $('.invoice-percent-3').percentCircle({
				width: 130,
				trackColor: '#ececec',
				barColor: '#808281',
				barWeight: 3,
				endPercent: 0.<?php echo $vgy ?>,
				fps: 60
			  });
			}
			function getTemplateString()
			{
			  return [
				'<div>',
				'<div class="row">',
				'<div class="col-md-12">',
				'<div style="border-top-left-radius: 10px;" class="ciuis-right-border-b1 ciuis-invoice-summaries-b1">',
				'<div class="box-header"><?php echo lang('totalinvoice'); ?></div>',
				'<div class="box-content">',
				'<div class="sentTotal">{{totalinvoicesayisi}}</div>'.replace(/{{totalinvoicesayisi}}/, options.data.totalinvoicesayisi),
				'</div>',
				'<div class="box-foot">',
				'<div class="sendTime box-foot-left"><?php echo lang('invoiceamount'); ?><br><span class="box-foot-stats"><strong><?php echo currency;?> <?php switch($settings['unitseparator']){case ',': echo number_format($fam, 2, ',', '.');break;case '.': echo number_format($fam, 2, '.', ',');break;}?></strong></span></div>'.replace(/{{date}}/, options.data.date),
				'</div>',
				'</div>',
				'<div class="ciuis-right-border-b1 ciuis-invoice-summaries-b1">',
				'<div class="box-header"><?php echo lang('paid'); ?></div>',
				'<div class="box-content invoice-percent">',
				'<div class="percentage">%<?php echo $ofx ?></div>',
				'</div>',
				'<div class="box-foot">',
				'<span class="arrow arrow-up"></span>',
				'<div class="box-foot-left"><?php echo lang('invoiceamount'); ?><br><span class="box-foot-stats"><strong><?php echo currency;?> <?php switch($settings['unitseparator']){case ',': echo number_format($ofv, 2, ',', '.');break;case '.': echo number_format($ofv, 2, '.', ',');break;}?></strong></span></div>',
				'<span class="arrow arrow-down"></span>',
				'<div class="box-foot-right"><br><span class="box-foot-stats""><strong><?php echo $otf ?></strong> (%<?php echo $ofx ?>)</span></div>',
				'</div>',
				'</div>',
				'<div class="ciuis-right-border-b1 ciuis-invoice-summaries-b1">',
				'<div class="box-header"><?php echo lang('unpaidinvoice'); ?></div>',
				'<div class="box-content invoice-percent-2">',
				'<div class="percentage">%<?php echo $ofy ?></div>',
				'</div>',
				'<div class="box-foot">',
				'<span class="arrow arrow-up"></span>',
				'<div class="box-foot-left"><?php echo lang('invoiceamount'); ?><br><span class="box-foot-stats"><strong><?php echo currency;?> <?php switch($settings['unitseparator']){case ',': echo number_format($oft, 2, ',', '.');break;case '.': echo number_format($oft, 2, '.', ',');break;}?></strong></span></div>'.replace(/{{OdenmeyenInvoicesAmount}}/, options.data.OdenmeyenInvoicesAmount),
				'<span class="arrow arrow-down"></span>',
				'<div class="box-foot-right"><br><span class="box-foot-stats"><strong><?php echo $tef ?></strong> (%<?php echo $ofy ?>)</span></div>',
				'</div>',
				'</div>',
				'<div style="border-top-right-radius: 10px;" class="ciuis-invoice-summaries-b1">',
				'<div class="box-header"><?php echo lang('overdue'); ?></div>',
				'<div class="box-content invoice-percent-3">',
				'<div class="percentage">%<?php echo $vgy ?></div>',
				'</div>',
				'<div class="box-foot">',
				'<span class="arrow arrow-up"></span>',
				'<div class="box-foot-left"><?php echo lang('invoiceamount'); ?><br><span class="box-foot-stats"><strong><?php echo currency;?> <?php switch($settings['unitseparator']){case ',': echo number_format($vgf, 2, ',', '.');break;case '.': echo number_format($vgf, 2, '.', ',');break;}?></strong></span></div>'.replace(/{{VadesiDolanInvoices}}/, options.data.VadesiDolanInvoices),
				'<div class="box-foot-right"><br><span class="box-foot-stats"><strong><?php echo $vdf ?></strong> (%<?php echo $vgy ?>)</span></div>',
				'</div>',
				'</div>'
			  ].join('');
			}
		  }
  		function reportCircleGraph() {
			$.fn.percentCircle = function pie(options) {
				var settings = $.extend({
					width: 130,
					trackColor: '#fff',
					barColor: '#fff',
					barWeight: 3,
					startPercent: 0,
					endPercent: 1,
					fps: 60
				}, options);
				this.css({
					width: settings.width,
					height: settings.width
				});
				var _this = this,
					canvasWidth = settings.width,
					canvasHeight = canvasWidth,
					id = $('canvas').length,
					canvasElement = $('<canvas id="' + id + '" width="' + canvasWidth + '" height="' + canvasHeight + '"></canvas>'),
					canvas = canvasElement.get(0).getContext('2d'),
					centerX = canvasWidth / 2,
					centerY = canvasHeight / 2,
					radius = settings.width / 2 - settings.barWeight / 2,
					counterClockwise = false,
					fps = 500 / settings.fps,
					update = 0.01;
				this.angle = settings.startPercent;
				this.drawInnerArc = function (startAngle, percentFilled, color) {
					var drawingArc = true;
					canvas.beginPath();
					canvas.arc(centerX, centerY, radius, (Math.PI / 180) * (startAngle * 360 - 90), (Math.PI / 180) * (percentFilled * 360 - 90), counterClockwise);
					canvas.strokeStyle = color;
					canvas.lineWidth = settings.barWeight - 2;
					canvas.stroke();
					drawingArc = false;
				};
				this.drawOuterArc = function (startAngle, percentFilled, color) {
					var drawingArc = true;
					canvas.beginPath();
					canvas.arc(centerX, centerY, radius, (Math.PI / 180) * (startAngle * 360 - 90), (Math.PI / 180) * (percentFilled * 360 - 90), counterClockwise);
					canvas.strokeStyle = color;
					canvas.lineWidth = settings.barWeight;
					canvas.lineCap = 'round';
					canvas.stroke();
					drawingArc = false;
				};
				this.fillChart = function (stop) {
					var loop = setInterval(function () {
						canvas.clearRect(0, 0, canvasWidth, canvasHeight);
						_this.drawInnerArc(0, 360, settings.trackColor);
						_this.drawOuterArc(settings.startPercent, _this.angle, settings.barColor);
						_this.angle += update;
						if (_this.angle > stop) {
							clearInterval(loop);
						}
					}, fps);
				};
				this.fillChart(settings.endPercent);
				this.append(canvasElement);
				return this;
			};
		}
		function getMockData() {
			return {
				totalinvoicesayisi: <?php echo $tfa ?>,
			};
		}
	}));
(function activateCiuisInvoiceStats($) {
	'use strict';
	var $el = $('.ciuis-invoice-summary');
	return new CiuisInvoiceStats({
		element: $el,
		data: {
			totalinvoicesayisi: <?php echo $tfa ?>,
		}
	});
}(jQuery));
</script>
