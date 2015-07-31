{strip}
	<div class="container loginContainer">
		<form action="index.php?module=Users&action=Login" method="POST">
			<img src="{Config::get('logo')}" class="img-responsive logo" alt="Logo"title="Logo">
			{if isset($ERRORS)}
				<br />
				{foreach item=ERROR key=KEY from=$ERRORS}
					<div class="alert alert-danger" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						{$ERROR['message']}
					</div>
				{/foreach}
			{/if}
			<div class="form-group">
				<label for="inputEmail" class="sr-only">{translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}</label>
				<input name="email" type="email" id="inputEmail" class="form-control" placeholder="{translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}" required="" autofocus="">
			</div>
			<div class="form-group">
				<label for="inputPassword" class="sr-only">{translate('LBL_PASSWORD', $MODULE_NAME)}</label>
				<input name="password" type="password" id="inputPassword" class="form-control" placeholder="{translate('LBL_PASSWORD', $MODULE_NAME)}" required="">
			</div>
			<div class="form-group">
				<label for="inputPassword" class="sr-only">{translate('LBL_PASSWORD', $MODULE_NAME)}</label>
				<select name="language" class="form-control">
					{foreach item=LANG key=PREFIX from=Core\Language::getAllLanguages()}
						<option value="{$PREFIX}">{$LANG}</option>
					{/foreach}
				</select>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">{translate('LBL_SINGN_IN', $MODULE_NAME)}</button>
		</form>
	</div>
{/strip}
