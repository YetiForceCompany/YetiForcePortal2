{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div id="js_strings" class="d-none d-print-none">{\App\Json::encode(\App\Language::export($MODULE_NAME, 'js'))}</div>
	<input type="hidden" id="module" value="Install">
	<input type="hidden" id="view" value="Install">
	<form action="index.php?module=Install&action=Install" method="POST">
		<input type="hidden" name="mode" value="Step3"/>
		<input type="hidden" name="lang" value="{$LANGUAGE}"/>
		<div class="row">
			<div class="col-md-12">
				<h4>{\App\Language::translate('LBL_WELCOME', $MODULE_NAME)}</h4>
			</div>
		</div>
		<hr>
		<div class="form-horizontal">
			<div class="col-6">
				<div class="form-group row">
					<label for="inputEmail3"
						   class="col-4 col-form-label">{\App\Language::translate('LBL_CRM_PATH', $MODULE_NAME)}</label>
					<div class="col-8">
						<input type="url" name="crmUrl" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3"
						   class="col-4 col-form-label">{\App\Language::translate('LBL_API_KEY', $MODULE_NAME)}</label>
					<div class="col-8">
						<input type="password" name="apiKey" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3"
						   class="col-4 col-form-label">{\App\Language::translate('LBL_SERVER_NAME', $MODULE_NAME)}</label>
					<div class="col-8">
						<input type="text" name="serverName" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3"
						   class="col-4 col-form-label">{\App\Language::translate('LBL_SERVER_PASS', $MODULE_NAME)}</label>
					<div class="col-8">
						<input type="password" name="serverPass" class="form-control">
					</div>
				</div>
				<div class="button-container float-right">
					<button class="btn btn-sm btn-outline-primary js-install" type="button" data-js="click">{\App\Language::translate('LBL_INSTALL_BUTTON', $MODULE_NAME)}</button>
				</div>
			</div>
			<div class="col-md-6">

			</div>
		</div>
	</form>
{/strip}
