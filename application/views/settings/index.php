
<div class="ciuis-body-content" ng-controller="Settings_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<md-toolbar class="toolbar-white">
		  <div class="md-toolbar-tools">
			<md-button class="md-icon-button" aria-label="Settings" ng-disabled="true">
			  <md-icon><i class="ion-ios-gear text-muted"></i></md-icon>
			</md-button>
			<h2 flex md-truncate><?php echo lang('crmsettings') ?></h2>
			<md-button ng-click="VersionCheck()" class="md-icon-button" aria-label="Update">
				<md-tooltip md-direction="bottom"><?php echo lang('version_check') ?></md-tooltip>
				<md-icon><i class="ion-erlenmeyer-flask text-muted"></i></md-icon>
			</md-button>
			<md-button ng-click="ChangeLogo()" class="md-icon-button" aria-label="Change Logo">
				<md-tooltip md-direction="bottom"><?php echo lang('changelogo') ?></md-tooltip>
				<md-icon><i class="mdi mdi-camera-alt text-muted"></i></md-icon>
			</md-button>
			<md-button ng-click="UpdateSettings()" class="md-icon-button" aria-label="Update">
				<md-tooltip md-direction="bottom"><?php echo lang('update') ?></md-tooltip>
				<md-icon><i class="ion-checkmark-circled text-muted"></i></md-icon>
			</md-button>
		  </div>
		</md-toolbar>
		<md-content class="bg-white">
		<md-tabs md-dynamic-height md-border-bottom>
		  <md-tab label="<?php echo lang('companysettings'); ?>">
			<md-content class="md-padding bg-white">
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('company')?></label>
						<input required name="company" ng-model="settings_detail.company">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('email')?></label>
						<input required name="company" ng-model="settings_detail.email">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('country'); ?></label>
						<md-select placeholder="<?php echo lang('country'); ?>" ng-model="settings_detail.country_id" style="min-width: 200px;">
							<md-option ng-value="country.id" ng-repeat="country in countries">{{country.shortname}}</md-option>
						</md-select><br>
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('state')?></label>
						<input required ng-model="settings_detail.state">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('city')?></label>
						<input required ng-model="settings_detail.city">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('town')?></label>
						<input required ng-model="settings_detail.town">
					</md-input-container>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('crmname')?></label>
						<input required ng-model="settings_detail.crm_name">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('zipcode')?></label>
						<input required ng-model="settings_detail.zipcode">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('phone')?></label>
						<input required ng-model="settings_detail.phone">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('fax')?></label>
						<input required ng-model="settings_detail.fax">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('vatnumber')?></label>
						<input required ng-model="settings_detail.vatnumber">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('taxoffice')?></label>
						<input required ng-model="settings_detail.taxoffice">
					</md-input-container>
				</div>
				<div class="col-md-12">
					<md-input-container class="md-block">
					  <label><?php echo lang('address')?></label>
					  <textarea name="address" class="form-control" ng-model="settings_detail.address"></textarea>
					</md-input-container>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('financialsettings'); ?>">
			<md-content class="md-padding bg-white">
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('currency'); ?></label>
						<md-select placeholder="<?php echo lang('currency'); ?>" ng-model="settings_detail.currencyid" style="min-width: 200px;">
							<md-option ng-value="currency.id" ng-repeat="currency in currencies">{{currency.name}}</md-option>
						</md-select><br>
					</md-input-container>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('termtitle')?></label>
						<input required ng-model="settings_detail.termtitle">
					</md-input-container>
					<md-input-container class="md-block">
					  <label><?php echo lang('termdescription')?></label>
					  <textarea name="address" class="form-control" ng-model="settings_detail.termdescription"></textarea>
					</md-input-container>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('localization'); ?>">
			<md-content class="md-padding bg-white">
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('language'); ?></label>
						<md-select placeholder="<?php echo lang('language'); ?>" ng-model="settings_detail.languageid" style="min-width: 200px;">
							<md-option ng-value="language.foldername" ng-repeat="language in languages">{{language.name}}</md-option>
						</md-select><br>
					</md-input-container>
					<md-input-container  class="md-block">
						<label><?php echo lang('defaulttimezone')?></label>
						<md-select ng-model="settings_detail.default_timezone">
						  <md-optgroup ng-repeat="timezone in timezones" label="{{timezone.group}}">
							<md-option ng-value="zone.value" ng-repeat="zone in timezone.zones">{{zone.name}}</md-option>
						  </md-optgroup>
						</md-select>
					</md-input-container>
				</div>
				<div class="col-md-6">
					 <md-input-container class="md-block" flex-gt-xs>
						<label><?php echo lang('dateformat'); ?></label>
						<md-select 
							ng-init="dateformats = [{value: 'yy.mm.dd',name: 'Y.M.D'}, {value: 'dd.mm.yy',name: 'D.M.Y'}, {value: 'yy-mm-dd',name: 'Y-M-D'}, {value: 'dd-mm-yy',name: 'D-M-Y'}, {value: 'yy/mm/dd',name: 'Y/M/D'}, {value: 'dd/mm/yy',name: 'D/M/Y'}];" 
							required 
							placeholder="<?php echo lang('dateformat'); ?>" 
							ng-model="settings_detail.dateformat" name="dateformat">
							<md-option ng-value="dateformat.value" ng-repeat="dateformat in dateformats"><span class="text-uppercase">{{dateformat.name}}</span></md-option>
						</md-select><br>
					</md-input-container>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('emailsettings'); ?>">
			<md-content class="md-padding bg-white">
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('smtphost')?></label>
						<input required ng-model="settings_detail.smtphost">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('smtpport')?></label>
						<input required ng-model="settings_detail.smtpport">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('emailcharset')?></label>
						<input required ng-model="settings_detail.emailcharset">
					</md-input-container>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('smtpusername')?></label>
						<input required ng-model="settings_detail.smtpusername">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('password')?></label>
						<input required ng-model="settings_detail.smtppassoword">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('email')?></label>
						<input required ng-model="settings_detail.sendermail">
					</md-input-container>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('customization'); ?>">
			<md-content class="md-padding bg-white">
				<div class="col-md-6">
					<div class="col-md-12 md-p-0">
					<md-switch disabled class="pull-left" ng-model="settings_detail.pushState" aria-label="Status"><strong class="text-muted"><?php echo lang('pushstate') ?></strong></md-switch>
					<md-switch class="pull-left" ng-model="settings_detail.voicenotification" aria-label="Status"><strong class="text-muted"><?php echo lang('voicenotifications') ?></strong></md-switch>
					</div>					
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('acceptedfileformats')?></label>
						<input required ng-model="settings_detail.accepted_files_formats">
					</md-input-container>
					<md-input-container class="md-block">
						<label><?php echo lang('allowedipaddereses')?></label>
						<input required ng-model="settings_detail.allowed_ip_adresses">
					</md-input-container>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('security'); ?>">
			<md-content class="md-padding bg-white">
				<div class="col-md-6">
					<div class="col-md-12 md-p-0">
					<h4><strong><?php echo lang('two_factor_authentication') ?></strong></h4>
					<span><?php echo lang('two_factor_authentication_description') ?></span>
					<hr>
					<ul>
						<li><a href="https://www.google.com/landing/2step/" rel="nofollow">Google 2-Step Verification</a></li>
						<li>Google Authenticator mobile app:
						<ul>
						<li><a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" rel="nofollow">Android app</a></li>
						<li><a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" rel="nofollow">iPhone, iPod touch or iPad app</a></li>
						<li><a href="http://m.google.com/authenticator" rel="nofollow">BlackBerry app</a></li>
						</ul>
						</li>
					</ul>
					</div>
					<div class="col-md-12 md-p-0">
					<md-switch class="pull-left" ng-model="settings_detail.two_factor_authentication" aria-label="Status"><strong class="text-muted"><?php echo lang('two_factor_authentication') ?></strong></md-switch>
					</div>
				</div>
				<div class="col-md-6">
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('paymentgateway'); ?>">
			<md-content class="md-padding bg-white">
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('paypalemail')?></label>
						<input required ng-model="settings_detail.paypalemail">
					</md-input-container>
					<md-switch class="pull-left" ng-model="settings_detail.paypalenable" aria-label="Status"><strong class="text-muted"><?php echo lang('paypalenable') ?></strong></md-switch>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block">
						<label><?php echo lang('paypalcurrency')?></label>
						<input required ng-model="settings_detail.paypalcurrency">
					</md-input-container>
					<md-switch class="pull-left" ng-model="settings_detail.paypalsandbox" aria-label="Status"><strong class="text-muted"><?php echo lang('paypalsandbox') ?></strong></md-switch>
				</div>
			</md-content>
		  </md-tab>
		  <md-tab label="<?php echo lang('cron_job'); ?>">
			<md-content class="md-padding bg-white">
                <div class="form-group clearfix">
                    <label class=" col-md-2"><?php echo lang('cron_job_link') ?></label>
                    <div class=" col-md-10"><?php echo base_url('CronJob/run') ?></div>
                </div>  
                <div class="form-group clearfix">
                    <label class=" col-md-2"><?php echo lang('recommended_execution_interval') ?></label>
                    <div class=" col-md-10"><?php echo  lang('every_one_hour'); ?></div>
                </div> 
				<label class=" col-md-2"><?php echo lang('cpanel_cron_job_command') ?></label>
				<div class=" col-md-10">
					<div>
					<pre style="background: rgb(38, 38, 38); color: rgb(255,188,0); border-radius: 5px;">wget <?php echo base_url('CronJob/run') ?></pre></div>
					<hr>
					<div>
					<pre style="background: rgb(38, 38, 38); color: rgb(255,188,0); border-radius: 5px;"><strong class="text-danger"><?php echo lang('or') ?></strong> wget -q -O- <?php echo base_url('CronJob/run') ?></pre></div>
				</div>
			</md-content>
		  </md-tab>
		</md-tabs>
		</md-content>
	</div>
<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

<script type="text/ng-template" id="logo-template.html">
  <md-dialog aria-label="options dialog">
  <?php echo form_open_multipart('settings/change_logo/',array("class"=>"form-horizontal")); ?>
	<md-dialog-content layout-padding>
		<h2 class="md-title"><?php echo lang('choosefile'); ?></h2>
		<span>Recommended size 42 x 42 px.</span>
		<input type="file" name="file_name">
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button ng-click="close()"><?php echo lang('cancel') ?>!</md-button>
	  <md-button type="submit"><?php echo lang('add') ?>!</md-button>
	</md-dialog-actions>
  <?php echo form_close(); ?>
  </md-dialog>
</script>
<script type="text/ng-template" id="version-check-template.html">
  <md-dialog aria-label="options dialog">
	<md-dialog-content layout-padding>
		<h2 class="md-title"><?php echo lang('version_check'); ?></h2>
		<span><?php echo lang('you_are_usign_version');?> <strong>1.1.1</strong></span>
	</md-dialog-content>
	<md-dialog-actions>
	  <span flex></span>
	  <md-button ng-click="close()"><?php echo lang('close') ?>!</md-button>
	</md-dialog-actions>
  </md-dialog>
</script>
</div>
