{strip}
	<form action="index.php?module=Install&view=Install" method="POST" name="step1">
		<input type="hidden" name="mode" value="Step2" />
		<div class="row">
			<div class="col-md-9">
				<h4>{translate('LBL_WELCOME', $MODULE_NAME)}</h4>
			</div>
			<div class="col-md-3">
				<select name="lang" class="chzn-select form-control" style="width: 250px;">
					{foreach key=key item=item from=Config::get('languages')}
						<option value="{$key}" {if $LANGUAGE eq $key}selected{/if}>{$item}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-5 welcome-image">
				<img src="{fileTemplate('wizard.jpg',$MODULE_NAME)}" alt="Wizard"/>
			</div>
			<div class="col-md-7">
				<div class="welcome-div">
					<h3>{translate('LBL_WELCOME_TO_SETUP_WIZARD', $MODULE_NAME)}</h3>
					<p>{translate('LBL_SETUP_WIZARD_DESCRIPTION',$MODULE_NAME)}</p>
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="button-container pull-right">
				<button class="btn btn-sm btn-primary" type="submit">{translate('LBL_INSTALL_BUTTON', $MODULE_NAME)}</button>
			</div>
		</div>
	</form>
{/strip}
