<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Reports_Controller">
	<md-content class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
	<md-toolbar class="toolbar-white">
	  <div class="md-toolbar-tools">
		<md-button class="md-icon-button" aria-label="Settings" ng-disabled="true">
		  <md-icon><i class="ico-ciuis-leads text-warning"></i></md-icon>
		</md-button>
		<h2 flex md-truncate><?php echo lang('reports') ?></h2>
	  </div>
	</md-toolbar>
	<md-content class="bg-white">
		<md-tabs md-dynamic-height md-border-bottom>
		  <md-tab label="<?php echo lang('financialsummary') ?>">
			<md-content class="md-padding bg-white">
				<md-content class="widget widget-fullwidth ciuis-body-loading">
					<div class="widget-chart-container">
						<div class="widget-counter-group widget-counter-group-right">
							<div style="width: auto;" class="pull-left">
								<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
								<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
									<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('incomingsvsoutgoings');?></b></h4>
									<small><?php echo lang('currentyearstats');?></small>
								</div>
							</div>
						</div>
						<div class="my-2">
							<div class="chart-wrapper" style="height:auto">
								<canvas style="padding-top: 25px;" id="incomingsvsoutgoins"></canvas>
							</div>
						</div>
					</div>
					<div class="ciuis-body-spinner">
						<svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
							<circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
						</svg>
					</div>
				</md-content>
				<md-content class="widget widget-fullwidth ciuis-body-loading">
					<div class="widget-chart-container">
						<div class="widget-counter-group widget-counter-group-right">
							<div style="width: auto;" class="pull-left">
								<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
								<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
									<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('incomingsvsoutgoings');?></b></h4>
									<small><?php echo lang('currentyearstats');?></small>
								</div>
							</div>
						</div>
						<div class="my-2">
							<div class="chart-wrapper" style="height:auto">
								<canvas style="padding-top: 25px;" id="expensesbycategories"></canvas>
							</div>
						</div>
					</div>
					<div class="ciuis-body-spinner">
						<svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
							<circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
						</svg>
					</div>
				</md-content>
				<md-content class="widget widget-fullwidth ciuis-body-loading">
					<div class="widget-chart-container">
						<div class="widget-counter-group widget-counter-group-right">
							<div style="width: auto;" class="pull-left">
								<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
								<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
									<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('staffbasedgraphics');?></b></h4>
									<small><?php echo lang('currentweekstats');?></small>
								</div>
							</div>
						</div>
						<div class="my-2">
							<div class="chart-wrapper" style="height:auto">
								<canvas style="padding-top: 25px;" id="top_selling_staff_chart"></canvas>
							</div>
						</div>
					</div>
					<div class="ciuis-body-spinner">
						<svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
							<circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
						</svg>
					</div>
				</md-content>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('invoicessummary') ?>">
			<md-content class="md-padding bg-white">
				<div class="widget-counter-group widget-counter-group-right">
					<div style="width: auto" class="pull-left">
						<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
						<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
							<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('invoicesbystatuses');?></b></h4>
							<small><?php echo lang('billsbystatus');?></small>
						</div>
					</div>
				</div>
				<div class="my-2">
					<div class="chart-wrapper">
						<canvas id="invoice_chart_by_status"></canvas>
					</div>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('customersummary') ?>">
			<md-content class="md-padding bg-white">
				<div layout="row" layout-align="start" flex>
					<md-input-container flex="50">
						<?php
						echo '<md-select ng-model="CustomerReportMonth" placeholder="Select a state" ng-change="CustomerMonthChanged()">' . PHP_EOL;
						for ( $m = 1; $m <= 12; $m++ ) {
							$_selected = '';
							if ( $m == date( 'm' ) ) {
								$_selected = ' selected';
							}
							echo '<md-option ng-value="' . $m . '"' . $_selected . '>' . ( date( 'F', mktime( 0, 0, 0, $m, 1 ) ) ) . '</md-option>' . PHP_EOL;
						}
						echo '</md-select>' . PHP_EOL;
						?>
					</md-input-container>
				</div>
				<canvas class="customergraph_ciuis-xe chart mtop20" id="customergraph_ciuis-xe" height="100"></canvas>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('lead') ?>">
			<md-content class="md-padding bg-white">
				<div layout="row" layout-align="start" flex>
					<md-input-container flex="50">
						<?php
						echo '<md-select ng-model="LeadReportMonth" placeholder="Select a state" ng-change="LeadMonthChanged()">' . PHP_EOL;
						for ( $m = 1; $m <= 12; $m++ ) {
							$_selected = '';
							if ( $m == date( 'm' ) ) {
								$_selected = ' selected';
							}
							echo '<md-option ng-value="' . $m . '"' . $_selected . '>' . ( date( 'F', mktime( 0, 0, 0, $m, 1 ) ) ) . '</md-option>' . PHP_EOL;
						}
						echo '</md-select>' . PHP_EOL;
						?>
					</md-input-container>
				</div>
				<canvas class="lead_graph chart mtop20" id="lead_graph" height="100"></canvas>
				<div class="col-md-12" style="background: #f5f5f5; border-radius: 0px;padding: 10px">
					<div class="col-md-6" style="border-right: 2px solid #fdfdfd;">
					<div class="widget-chart-container">
					<div class="widget-counter-group widget-counter-group-right">
						<div style="width: auto" class="pull-left">
							<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
							<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
								<h4 style="padding: 0px;margin: 0px;"><b>Leads by Leadsource</b></h4>
								<small>Bills by status.</small>
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
					<div class="col-md-6">
					<div class="widget-chart-container">
					<div class="widget-counter-group widget-counter-group-right">
						<div style="width: auto" class="pull-left">
							<i style="font-size: 38px;color: #eaeaea;margin-right: 10px" class="ion-stats-bars pull-left"></i>
							<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
								<h4 style="padding: 0px;margin: 0px;"><b>Leads To Win by Leadsource</b></h4>
								<small>Bills by status.</small>
							</div>
						</div>
					</div>
					<div class="my-2">
						<div class="chart-wrapper">
							<canvas id="leads_to_win_by_leadsource"></canvas>
						</div>
					</div>
					</div>
					</div>
				</div>
			</md-content>
		  </md-tab>
		</md-tabs>
	  </md-content>		
	</md-content>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
	
</div>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>