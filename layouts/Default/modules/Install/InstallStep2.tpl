{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Install-InstallStep2 -->
	<div id="js_strings" class="d-none d-print-none">{\App\Json::encode(\App\Language::export($MODULE_NAME, 'js'))}</div>
	<input type="hidden" id="module" value="Install">
	<input type="hidden" id="view" value="Install">
	<form action="index.php?module=Install&action=Install" method="POST">
		<input type="hidden" name="mode" value="Step3" />
		<input type="hidden" name="lang" value="{$LANGUAGE}" />
		<div class="row">
			<div class="col-md-12">
				<h3>{\App\Language::translate('LBL_INSTALLATION_WIZARD', $MODULE_NAME)}</h3>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-4 welcome-image d-none d-xl-block">
				<img src="{\App\Resources::resourcePath('yetiforce_capterra.png', $MODULE_NAME)}" />
			</div>
			<div class="col-md-7">
				<div class="form-group row">
					<label for="apiUrl" class="col-sm-4 col-form-label">{\App\Language::translate('LBL_API_PATH', $MODULE_NAME)}</label>
					<div class="col-sm-8">
						<input type="url" id="apiUrl" name="apiUrl" class="form-control" placeholder="https://gitdeveloper.yetiforce.com/webservice/" data-validation-engine="validate[required]">
					</div>
				</div>
				<div class="form-group row">
					<label for="apiKey" class="col-sm-4 col-form-label">{\App\Language::translate('LBL_API_KEY', $MODULE_NAME)}</label>
					<div class="col-sm-8">
						<input type="password" id="apiKey" name="apiKey" class="form-control" data-validation-engine="validate[required]">
					</div>
				</div>
				<div class="form-group row">
					<label for="serverName" class="col-sm-4 col-form-label">{\App\Language::translate('LBL_SERVER_NAME', $MODULE_NAME)}</label>
					<div class="col-sm-8">
						<input type="text" id="serverName" name="serverName" class="form-control" data-validation-engine="validate[required]">
					</div>
				</div>
				<div class="form-group row">
					<label for="serverPass" class="col-sm-4 col-form-label">{\App\Language::translate('LBL_SERVER_PASS', $MODULE_NAME)}</label>
					<div class="col-sm-8">
						<input type="password" id="serverPass" name="serverPass" class="form-control" data-validation-engine="validate[required]">
					</div>
				</div>
			</div>
		</div>
		<div class="button-container float-right">
			<button class="btn btn-sm btn-primary js-install" type="button" data-js="click">
				<span class="fas fa-angle-double-right mr-3"></span>
				{\App\Language::translate('LBL_INSTALL_BUTTON', $MODULE_NAME)}
			</button>
		</div>
	</form>
	<!-- /tpl-Install-InstallStep2 -->
{/strip}
