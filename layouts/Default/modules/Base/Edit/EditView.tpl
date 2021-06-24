{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Edit-EditView -->
<div class="contentsDiv">
	<div class="widget_header u-remove-main-padding">
		<div class="d-flex justify-content-between u-add-main-padding">
			<div class="">
				{include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
			</div>
			<div class="contentHeader">
				<button class="btn btn-success btn-sm mr-2 js-form-submit" type="submit" data-js="click">
					<span class="fas fa-check mr-2"></span>
					{\App\Language::translate('BTN_SAVE', $MODULE_NAME)}
				</button>
				<button class="btn btn-danger btn-sm js-history-back" type="reset" data-js="click">
					<span class="fas fa-times mr-2"></span>
					{\App\Language::translate('BTN_CANCEL', $MODULE_NAME)}
				</button>
			</div>
		</div>
	</div>
	{include file=\App\Resources::templatePath("Edit/Form.tpl", $MODULE_NAME)}
</div>
{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
<!-- /tpl-Base-Edit-EditView -->
{/strip}
