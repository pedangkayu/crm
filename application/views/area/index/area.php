<div class="ciuis-body-content">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-content class="bg-white ciuis-home-summary-top">
			<div class="col-md-3 col-sm-3 col-lg-3 nopadding">
			<md-toolbar class="toolbar-white" style="border-right:1px solid #e0e0e0">
				<div class="md-toolbar-tools">
					<h4 class="text-muted" flex md-truncate ><strong><?php echo lang('panelsummary'); ?></strong></h4>					
					<md-button class="md-icon-button" aria-label="Actions">
						<md-icon><span class="ion-flag text-muted"></span></md-icon>
					</md-button>
				</div>
			</md-toolbar>
				<md-content class="bg-white ciuis-summary-two">
					<div class="ciuis-dashboard-box-b1-xs-ca-body">
							<div class="ciuis-dashboard-box-stats ciuis-dashboard-box-stats-main text-center">
								<div class="ciuis-dashboard-box-stats-amount" style="font-size: 24px;padding-top: 10px" ng-bind-html="stats.customer_debt | currencyFormat:cur_code:null:true:cur_lct"></div>
								<div class="ciuis-dashboard-box-stats-caption">
								<?php echo lang('currentdebt') ?>
								</div>
							</div>
							<div class="col-md-12 nopadding">
								<div class="hpanel stats">
									<div style="padding-top: 0px;line-height: 0.99;" class="panel-body h-200 xs-p-0">
										<div class="col-md-12 xs-mb-20 nopadding">
											<?php $time = date( "H" );$timezone = date( "e" );if ( $time < "12" ) 
{echo '<div class="col-md-12 text-center"><p><img src="'.base_url('assets/img/morning.png').'" alt=""></p><p><h4>'.lang('goodmorning').'</h4><span>'.$_SESSION[ 'name' ].'</span></p></div>';} else if ( $time >= "12" && $time < "17" ) 
{echo '<div class="col-md-12 text-center"><p><img src="'.base_url('assets/img/afternoon.png').'" alt=""></p><p><h4>'.lang('goodafternoon').'</h4><span>'.$this->session->userdata('name').'</span></p></div>';} else if ( $time >= "17" && $time < "19" ) 
{echo '<div class="col-md-12 text-center"><p><img src="'.base_url('assets/img/evening.png').'" alt=""></p><p><h4>'.lang('goodevening').'</h4><span>'.$this->session->userdata('name').'</span></p></div>';} else if ( $time >= "19" ) 
{echo '<div class="col-md-12 text-center"><p><img src="'.base_url('assets/img/night.png').'" alt=""></p><p><h4>'.lang('goodnight').'</h4><span>'.$this->session->userdata('name').'</span></p></div>';}?>
										<div class="col-md-12  md-pt-10 xs-pt-20 text-center" style="border-top: 1px solid #e0e0e0;"><?php echo lang('haveaniceday') ?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
				</md-content>
			</div>
			<div class="col-sm-9 xs-p-0">
			<md-toolbar class="toolbar-white">
				<div class="md-toolbar-tools">
					<h4 class="text-muted" flex md-truncate ><strong><?php echo lang('welcome') ?></strong></h4>					
				</div>
			</md-toolbar>
				<md-content layout-padding class="bg-white ciuis-summary-two">
					<div class="widget widget-fullwidth ciuis-body-loading">
						<div class="widget-chart-container">
							<div class="widget-counter-group widget-counter-group-right">
								<div class="pull-left">
									<div class="pull-left text-left">
										<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('salesgraphtitle'); ?></b></h4>
										<small><?php echo lang('weeklygraphdetailtext'); ?></small>
									</div>
								</div>
							</div>
							<div class="my-2">
								<div class="chart-wrapper" style="height:300px;">
									<canvas id="customer_annual_sales_chart" height="300px"></canvas>
								</div>
							</div>
						</div>
						<div class="ciuis-body-spinner">
							<svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
								<circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
							</svg>
						</div>
					</div>
				</md-content>
			</div>
		<?php include(APPPATH . 'views/inc/widgets/panel_bottom_summary_customer.php'); ?>
		</md-content>
	</div>

</div>
<?php include_once(APPPATH . 'views/area/inc/sidebar.php'); ?>
<?php include_once( APPPATH . 'views/area/inc/footer.php' );?>