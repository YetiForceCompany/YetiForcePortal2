{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="container loginContainer">
		<form action="index.php?module=Users&action=Login" method="POST">
			<img src="{\App\Config::get('logo')}" class="img-responsive logo" alt="Logo" title="Logo">
			{if isset($ERRORS)}
				<br/>
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
				<label for="inputEmail"
					   class="sr-only">{\App\Functions::translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}</label>
				<input name="email" type="email" id="inputEmail" class="form-control"
					   placeholder="{\App\Functions::translate('LBL_EMAIL_ADDRESS', $MODULE_NAME)}"
					   value="demo@yetiforce.com" required="" autofocus="">
			</div>
			<div class="form-group">
				<label for="inputPassword"
					   class="sr-only">{\App\Functions::translate('LBL_PASSWORD', $MODULE_NAME)}</label>
				<input name="password" type="password" id="inputPassword" class="form-control"
					   placeholder="{\App\Functions::translate('LBL_PASSWORD', $MODULE_NAME)}" value="demo"
					   required="">
			</div>
			<div class="form-group">
				<label for="inputPassword"
					   class="sr-only">{\App\Functions::translate('LBL_PASSWORD', $MODULE_NAME)}</label>
				<select name="language" class="form-control">
					{foreach item=LANG key=PREFIX from=\App\Language::getAllLanguages()}
						<option value="{$PREFIX}">{$LANG}</option>
					{/foreach}
				</select>
			</div>
			<button class="btn btn-lg btn-primary btn-block"
					type="submit">{\App\Functions::translate('LBL_SINGN_IN', $MODULE_NAME)}</button>
		</form>
	</div>
	<div id="CoreLog" class="panel panel-primary col-xs-12 paddingLRZero blockContainer">
		<div class="card-header">{\App\Functions::translate('LBL_CORE_LOG')}</div>
		<div class="col-md-12 paddingLRZero panel-body">
			<ol id="CoreLogList">

			</ol>
		</div>
	</div>
{/strip}
