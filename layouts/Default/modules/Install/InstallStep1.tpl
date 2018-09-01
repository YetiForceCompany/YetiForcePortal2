{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<form action="index.php?module=Install&view=Install" method="POST" name="step1">
		<input type="hidden" name="mode" value="Step2"/>
		<div class="row">
			<div class="col-md-9">
				<h4>{\App\Functions::translate('LBL_WELCOME', $MODULE_NAME)}</h4>
			</div>
			<div class="col-md-3">
				<select name="lang" class="select2" style="width: 250px;">
					{foreach key=key item=item from=\App\Config::$languages}
						<option value="{$key}" {if $LANGUAGE eq $key}selected{/if}>{$item}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-5 welcome-image">
				<img src="{\App\Functions::fileTemplate('wizard.jpg',$MODULE_NAME)}" alt="Wizard"/>
			</div>
			<div class="col-md-7">
				<div class="welcome-div">
					<h3>{\App\Functions::translate('LBL_WELCOME_TO_SETUP_WIZARD', $MODULE_NAME)}</h3>
					<p>{\App\Functions::translate('LBL_SETUP_WIZARD_DESCRIPTION',$MODULE_NAME)}</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="button-container float-right">
				<button class="btn btn-sm btn-primary"
						type="submit">{\App\Functions::translate('LBL_INSTALL_BUTTON', $MODULE_NAME)}</button>
			</div>
		</div>
	</form>
{/strip}
