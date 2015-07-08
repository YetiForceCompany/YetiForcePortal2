{strip}
	<div class="container loginContainer">
		<form action="index.php?module=Users&action=Login" method="POST">
			<img src="{Config::get('logo')}" class="img-responsive logo" alt="Logo"title="Logo">
			<div class="form-group">
				<label for="inputEmail" class="sr-only">{translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}</label>
				<input name="email" type="email" id="inputEmail" class="form-control" placeholder="{translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}" required="" autofocus="">
			</div>
			<div class="form-group">
				<label for="inputPassword" class="sr-only">{translate('LBL_PASSWORD', $MODULE_NAME)}</label>
				<input name="password" type="password" id="inputPassword" class="form-control" placeholder="{translate('LBL_PASSWORD', $MODULE_NAME)}" required="">
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">{translate('LBL_SINGN_IN', $MODULE_NAME)}</button>
		</form>
	</div>
{/strip}
