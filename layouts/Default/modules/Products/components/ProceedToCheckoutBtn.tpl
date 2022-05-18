{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<button class="btn btn-raised btn-warning m-auto" type="button" onclick="window.history.back()" data-js="click">
		<i class="fas fa-chevron-left mr-2"></i> {\App\Language::translate('LBL_STEP_BACK')}
	</button>
	<button class="btn btn-raised btn-success m-auto js-buy" type="button" data-js="click">
		<i class="fas fa-cart-arrow-down mr-2"></i> {\App\Language::translate('LBL_BUY', $MODULE_NAME)}
	</button>
{/strip}
