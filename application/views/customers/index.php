<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Customers_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class='ciuis-customer-panel-xs'>
			<div class='ciuis-customer-panel-xs-icerik'>
				<header class='header_customer-xs'>
					<div class='main-header_customer-xs'>
						<div class='container-fluid'>
							<div class='top-header_customer-xs'>
								<div class='row'>
									<div class='col-md-6'>
										<ol class='breadcrumb-xs-customer'>
											<button ng-click="Create()" style="margin-right:10px;" type="button" class="pull-left btn btn-warning"><i class="icon icon-left mdi mdi mdi-plus"></i><?php echo lang('newcustomer'); ?></button>
											<li><a href='<?php echo base_url('customers')?>'><?php echo lang('customers'); ?></a></li>
											<li><a href='#'><i class="ion-ios-arrow-right"></i></a></li>
											<li class='active'><a href='#'><?php echo $title ?></a></li>
										</ol>
									</div>
									<div style="padding-right: 20px;" class='col-md-5 hidden-xs'>
										<div class="searchcustomer-container">
											<div class="searchcustomer-box">
												<div class="searchcustomer-icon"><i class="ion-person-stalker"></i>
												</div>
												<input ng-model="search.name" name="q" value="" x-webkit-speech='x-webkit-speech' class="searchcustomer-input" id="searchcustomer" type="text" placeholder="<?php echo lang('searchcustomer'); ?>"/>
												<i style="position: absolute; margin-top: 5px; right: 10px; font-size: 18px;" onclick="startDictation()" class="ion-ios-mic"></i>
												<ul class="searchcustomer-results" id="results"></ul>
											</div>
										</div>
									</div>
									<div class="col-md-1" style="margin-top: 5px;">
									<md-button ng-click="toggleFilter()" class="md-icon-button" aria-label="Filter"><md-icon class="ion-android-funnel"></md-icon></md-button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</header>
			</div>
		</div>
		<ul class="custom-ciuis-list-body" style="padding: 0px;">
			<li ng-repeat="customer in customers | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="ciuis-custom-list-item ciuis-special-list-item lead-name">
				<ul class="list-item-for-custom-list">
					<li class="ciuis-custom-list-item-item col-md-12">
					<div class="assigned-staff-for-this-lead user-avatar"><i class="ico-ciuis-staffdetail" style="font-size: 32px"></i></div>
						<div class="pull-left col-md-4">
						<a href="<?php echo base_url('customers/customer/')?>{{customer.id}}"><strong ng-bind="customer.name"></strong></a><br>
						<a href="mailto:{{customer.email}}"><small ng-bind="customer.email"></small></a>
						</div>
						<div class="col-md-8">
							<div class="col-md-9">
							<span class="date-start-task"><small class="text-muted text-uppercase" ng-bind="customer.address"></small><br>
							<strong ng-bind="customer.phone"></strong></span>
							</div>
							<div class="col-md-3 text-center hidden-xs">
							<div class="hellociuislan">
							<div ng-show="customer.balance !== 0">
								<strong style="font-size: 20px;"><span ng-bind-html="customer.balance | currencyFormat:cur_code:null:true:cur_lct"></span></strong><br><span style="font-size:10px"><?php echo lang( 'currentdebt' ) ?></span>
							</div>
							<div ng-show="customer.balance === 0">
								<strong style="font-size: 22px;"><i class="text-success ion-android-checkmark-circle"></i></strong><br><span class="text-success" style="font-size:10px">No Balance</span>
							</div>
							</div>
							</div>
						</div>
					</li>
				</ul>
			</li>
		</ul>
		<md-content ng-show="!customers.length" class="md-padding no-item-data"><?php echo lang('notdata') ?></md-content>
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
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="Create">
  <md-toolbar class="toolbar-white">
  <div class="md-toolbar-tools">
	<md-button ng-click="close()" class="md-icon-button" aria-label="Close">
		 <i class="ion-android-arrow-forward"></i>
	</md-button>
	<h2 flex md-truncate><?php echo lang('create') ?></h2>
	<md-switch ng-model="isIndividual" aria-label="Type"><strong class="text-muted"><?php echo lang('individual') ?></strong></md-switch>
  </div>
  </md-toolbar>
  <md-content layout-padding="">
	<md-content layout-padding>
		<md-input-container ng-show="isIndividual != true" class="md-block">
			<label><?php echo lang('company'); ?></label>
			<md-icon md-svg-src="<?php echo base_url('assets/img/icons/company.svg') ?>"></md-icon>
			<input name="company" ng-model="customer.company">
		</md-input-container>
		<md-input-container ng-show="isIndividual == true" class="md-block">
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
		<md-input-container ng-show="isIndividual == true" class="md-block">
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
		  <md-button ng-click="AddCustomer()" class="md-raised md-primary pull-right"><?php echo lang('create');?></md-button>
		</section>		
	</md-content>
 </md-content>
</md-sidenav>
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
		 <div ng-repeat="(prop, ignoredValue) in customers[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'name' && prop != 'address' && prop != 'email' && prop != 'phone' && prop != 'balance' && prop != 'customer_id' && prop != 'contacts'">
		  <div class="filter col-md-12">
			<h4 class="text-muted text-uppercase"><strong>{{prop}}</strong></h4>
			<hr>
			<div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycountry') ?>' && prop!='<?php echo lang('filterbyassigned') ?>'">
				<md-checkbox id="{{[opt]}}" ng-model="filter[prop][opt]" aria-label="{{opt}}"><span class="text-uppercase">{{opt}}</span></md-checkbox>
			</div>
			<div ng-if="prop=='<?php echo lang('filterbycountry') ?>'">
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
	<?php include_once( APPPATH . 'views/inc/footer.php' );?>
	
<script>
	( function () {
		var displayResults, findAll, maxResults, names, resultsOutput, searchcustomerInput;
		names = [ 
			<?php foreach($customers as $f){ ?>
			"<a href='<?php echo base_url('customers/customer/'.$f['id'].'');?>'><?php if($f['type']==0){echo $f['company'];}else echo $f['namesurname']; ?></a>", 
			<?php }?>
			""
		];
		findAll = ( function ( _this ) {
			return function ( wordList, collection ) {
				return collection.filter( function ( word ) {
					word = word.toLowerCase();
					return wordList.some( function ( name ) {
						return ~word.indexOf( name );
					} );
				} );
			};
		} )( this );
		displayResults = function ( resultsEl, wordList ) {
			return resultsEl.innerHTML = ( wordList.map( function ( name ) {
				return '<li>' + name + '</li>';
			} ) ).join( '' );
		};
		searchcustomerInput = document.getElementById( 'searchcustomer' );
		resultsOutput = document.getElementById( 'results' );
		maxResults = 20;
		searchcustomerInput.addEventListener( 'keyup', ( function ( _this ) {
			return function ( e ) {
				var suggested, value;
				value = searchcustomerInput.value.toLowerCase().split( ' ' );
				suggested = ( value[ 0 ].length ? findAll( value, names ) : [] );
				return displayResults( resultsOutput, suggested );
			};
		} )( this ) );
	} ).call( this );
	function startDictation() {
		if ( window.hasOwnProperty( 'webkitSpeechRecognition' ) ) {
			var recognition = new webkitSpeechRecognition();
			recognition.continuous = false;
			recognition.interimResults = false;
			recognition.lang = "<?php echo lang('lang_code')?>";
			recognition.start();
			recognition.onresult = function ( e ) {
				document.getElementById( 'searchcustomer' ).value = e.results[ 0 ][ 0 ].transcript;
				recognition.stop();
				$('.searchcustomer-input').value = e.results[ 0 ][ 0 ].transcript;
				$('.searchcustomer-input').focus();
				$('.searchcustomer-input').keyup();

			};
			recognition.onerror = function ( e ) {
				recognition.stop();
			}
		}
	}
</script>