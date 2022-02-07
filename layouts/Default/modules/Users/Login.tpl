{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Users-Login -->
	<div class="container loginContainer">
		<input type="hidden" id="view" value="{$VIEW}" />
		<form action="index.php?module=Users&action=Login" method="POST">
			<input name="fingerprint" type="hidden" id="fingerPrint" />
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
			{if !empty(\Conf\Config::$loginPageAlertMessage)}
				<div class="alert {if empty(\Conf\Config::$loginPageAlertType)}alert-danger{else}{\Conf\Config::$loginPageAlertType}{/if} mb-2 px-3 py-2 text-center" role="alert">
					<i class="{if empty(\Conf\Config::$loginPageAlertIcon)}fas fa-exclamation-triangle{else}{\Conf\Config::$loginPageAlertIcon}{/if}"></i>
					<span class="font-weight-bold mx-2">{\Conf\Config::$loginPageAlertMessage}</span>
					<i class="{if empty(\Conf\Config::$loginPageAlertIcon)}fas fa-exclamation-triangle{else}{\Conf\Config::$loginPageAlertIcon}{/if}"></i>
				</div>
			{/if}
			<label for="inputEmail" class="sr-only">{\App\Language::translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}</label>
			<div class="input-group mb-2 first-group">
				<input name="email" type="text" id="inputEmail" class="form-control" placeholder="{\App\Language::translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}" required="" autofocus="" />
				<div class="input-group-append">
					<div class="input-group-text"><span class="fas fa-user"></span></div>
				</div>
			</div>
			<label for="inputPassword" class="sr-only">{\App\Language::translate('LBL_PASSWORD', $MODULE_NAME)}</label>
			<div class="input-group mb-2 first-group">
				<input name="password" type="password" id="inputPassword" class="form-control" placeholder="{\App\Language::translate('LBL_PASSWORD', $MODULE_NAME)}" required="">
				<div class="input-group-append">
					<div class="input-group-text"><span class="fas fa-briefcase"></span></div>
				</div>
			</div>
			{if \App\Config::getBool('allowLanguageSelection')}
				<label for="inputPassword" class="sr-only">{\App\Language::translate('LBL_PASSWORD', $MODULE_NAME)}</label>
				<div class="input-group mb-2 form-group first-group">
					<select name="language" class="form-control">
						{foreach item=LANG key=PREFIX from=\App\Language::getAllLanguages()}
							<option value="{$PREFIX}" {if $LANGUAGE eq $PREFIX}selected{/if}>{$LANG}</option>
						{/foreach}
					</select>
					<div class="input-group-append">
						<div class="input-group-text"><span class="fas fa-language"></span></div>
					</div>
				</div>
			{else}
				<input type="hidden" name="language" value="{\App\Config::get('language')}" />
			{/if}
			<button class="btn btn-lg btn-info btn-block" type="submit">
				{\App\Language::translate('LBL_SINGN_IN', $MODULE_NAME)} <strong><span class="fas fa-chevron-right ml-2"></span></strong>
			</button>
			<div class="form-group">
				<div class="mt-2">
					<a href="index.php?module=Users&view=LoginPassReset" class="btn btn-lg btn-outline-warning btn-block">
						{\App\Language::translate('LBL_FORGOT_PASSWORD_PAGE',$MODULE_NAME)}
						<span class="fas fa-lock-open ml-2"></span>
					</a>
				</div>
			</div>
		</form>
	</div>
	{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
	<!-- /tpl-Users-Login -->
{/strip}
