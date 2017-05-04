{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	<form action="index.php?module=Install&action=Install" method="POST">
		<input type="hidden" name="mode" value="Step3" />
		<input type="hidden" name="lang" value="{$LANGUAGE}" />
		<div class="row">
			<div class="col-md-12">
				<h4>{\YF\Core\Functions::translate('LBL_WELCOME', $MODULE_NAME)}</h4>
			</div>
		</div>
		<hr>
		<div class="row form-horizontal">
			<div class="col-md-6">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 control-label">{\YF\Core\Functions::translate('LBL_CRM_PATH', $MODULE_NAME)}</label>
					<div class="col-sm-8">
						<input type="url" name="crmPath" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 control-label">{\YF\Core\Functions::translate('LBL_API_KEY', $MODULE_NAME)}</label>
					<div class="col-sm-8">
						<input type="text" name="apiKey" class="form-control">
					</div>
				</div>
			</div>
			<div class="col-md-6">

			</div>
		</div>
		<div class="row">
			<div class="button-container pull-right">
				<button class="btn btn-sm btn-primary" type="submit">{\YF\Core\Functions::translate('LBL_INSTALL_BUTTON', $MODULE_NAME)}</button>
			</div>
		</div>
	</form>
{/strip}
