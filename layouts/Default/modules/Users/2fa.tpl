{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Users-2fa -->
	<div class="container loginContainer">
		<form action="index.php?module=Users&action=Login&mode=2fa" method="POST">
			<div class="text-center">
				<img src="{PUBLIC_DIRECTORY}{\App\Config::$logoLoginPage}" class="img-responsive logo" alt="Logo" title="Logo">
			</div>
			<label for="inputToken" class="sr-only">{\App\Language::translate('LBL_2FA_TOKEN', $MODULE_NAME)}</label>
			<div class="input-group mb-2 first-group">
				<input name="token" type="token" id="inputToken" class="form-control" placeholder="{\App\Language::translate('LBL_2FA_TOKEN', $MODULE_NAME)}" value="" required="">
				<div class="input-group-append">
					<div class="input-group-text"><span class="fas fa-briefcase"></span></div>
				</div>
			</div>
			<button class="btn btn-lg btn-info btn-block" type="submit">{\App\Language::translate('LBL_SINGN_IN', $MODULE_NAME)} <strong><span class="fas fa-chevron-right ml-2"></span></strong></button>
		</form>
	</div>
	<!-- /tpl-Users-2fa -->
{/strip}
