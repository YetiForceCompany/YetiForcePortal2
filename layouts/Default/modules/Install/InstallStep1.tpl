{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Install-InstallStep1 -->
<form action="index.php?module=Install&view=Install" method="POST" name="step1">
	<input type="hidden" name="mode" value="step2"/>
	<div class="row">
		<div class="col-md-9">
			<h3>{\App\Language::translate('LBL_INSTALLATION_WIZARD_TITLE', $MODULE_NAME)}</h3>
		</div>
		<div class="col-md-3">
			<select name="lang" class="select2 form-control ml-auto" style="width: 250px;">
				{foreach key=key item=item from=\App\Language::getAllLanguages()}
					<option value="{$key}" {if $LANGUAGE eq $key}selected{/if}>{$item}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-4 welcome-image">
			<img src="{\App\Resources::resourcePath('yetiforce_capterra.png', $MODULE_NAME)}" alt="Wizard"/>
		</div>
		<div class="col-md-7">
			<div class="welcome-div">
				<h1>{\App\Language::translate('LBL_WELCOME_TO_SETUP_WIZARD', $MODULE_NAME)}</h1>
				<p>{\App\Language::translate('LBL_SETUP_WIZARD_DESCRIPTION', $MODULE_NAME)}</p>
			</div>
		</div>
	</div>
	<div class="button-container float-right">
		<button class="btn btn-sm btn-primary" type="submit">
			<span class="fas fa-angle-double-right mr-3"></span>
			{\App\Language::translate('LBL_INSTALL_BUTTON', $MODULE_NAME)}
		</button>
	</div>
</form>
<!-- /tpl-Install-InstallStep1 -->
{/strip}
