{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Users-LoginPassResetToken -->
	<div class="container loginContainer">
		<input type="hidden" id="view" value="{$VIEW}" />
		<form action="index.php?module=Users&action=LoginPassReset&mode=token" method="POST">
			<input name="fingerprint" type="hidden" id="fingerPrint" />
			<div class="text-center">
				<img src="{PUBLIC_DIRECTORY}{\App\Config::$logoLoginPage}" class="img-responsive logo" alt="Logo" title="Logo">
			</div>
			<div class="alert d-none js-alert-confirm-password alert-danger mt-2" role="alert" data-js="container">
				{\App\Language::translate('LBL_PASSWORD_SHOULD_BE_SAME', $MODULE_NAME)}
			</div>
			{if isset($ERRORS)}
				{foreach item=ERROR key=KEY from=$ERRORS}
					<div class="alert alert-danger mt-2" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						{\App\Purifier::encodeHtml($ERROR)}
					</div>
				{/foreach}
			{/if}
			{if empty($TOKEN)}
				<label for="inputEmail" class="sr-only">{\App\Language::translate('LBL_FORGOT_PASSWORD_TOKEN', $MODULE_NAME)}</label>
				<div class="input-group mb-2 first-group">
					<input name="token" type="text" id="inputEmail" class="form-control" placeholder="{\App\Language::translate('LBL_FORGOT_PASSWORD_TOKEN', $MODULE_NAME)}" required="" />
				</div>
			{else}
				<input name="token" type="hidden" value="{$TOKEN}" />
			{/if}
			<label for="password" class="sr-only">{\App\Language::translate('LBL_NEW_PASSWORD', $MODULE_NAME)}</label>
			<div class="input-group mb-2 first-group">
				<input type="password" name="password" id="password" class="form-control" placeholder="{\App\Language::translate('LBL_NEW_PASSWORD', $MODULE_NAME)}" required="" data-validation-engine="validate[required,minSize[4],maxSize[32]]" autocomplete="off" />
			</div>
			<label for="confirm_password" class="sr-only">{\App\Language::translate('LBL_CONFIRM_PASSWORD', $MODULE_NAME)}</label>
			<div class="input-group mb-2 first-group">
				<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="{\App\Language::translate('LBL_CONFIRM_PASSWORD', $MODULE_NAME)}" required="" data-validation-engine="validate[required,minSize[4],maxSize[32],equals[password]]" autocomplete="off" />
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">
				<span class="fas fa-exchange-alt mr-2"></span>{\App\Language::translate('LBL_CHANGE_PASSWORD', $MODULE_NAME)}
			</button>
		</form>
	</div>
	{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
	<!-- /tpl-Users-LoginPassResetToken -->
{/strip}
