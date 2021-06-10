{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Users-LoginPassReset -->
<div class="container loginContainer">
	<form action="index.php?module=Users&action=LoginPassReset" method="POST">
		<div class="text-center">
			<img src="{PUBLIC_DIRECTORY}{\App\Config::$logoLoginPage}" class="img-responsive logo" alt="Logo" title="Logo">
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
		<label for="inputEmail" class="sr-only">{\App\Language::translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}</label>
		<div class="input-group mb-2 first-group">
			<div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-envelope"></i></div></div>
			<input name="email" type="text" id="inputEmail" class="form-control" placeholder="{\App\Language::translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}" value="" required="" autofocus="" />
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">
			<span class="fas fa-exchange-alt mr-2"></span>{\App\Language::translate('BTN_FORGOT_PASSWORD_PAGE', $MODULE_NAME)}
		</button>
		<div class="form-group">
			<div class="mt-2">
				<a href="index.php?module=Users&view=Login" class="btn btn-lg btn-outline-secondary btn-block">
				{\App\Language::translate('LBL_LOGIN_PAGE',$MODULE_NAME)}
				</a>
			</div>
		</div>
	</form>
</div>
{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
<!-- /tpl-Users-LoginPassReset -->
{/strip}
