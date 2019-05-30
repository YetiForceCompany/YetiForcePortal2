{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<header class="tpl-Base-BodyHeader bodyHeader d-flex justify-content-end align-items-center js-body-header c-header" data-js="container">
		<div class="rightHeaderBtnMenu d-none">
			<a class="btn btn-outline-light btn-sm mr-2 c-header__btn ml-0 js-sidebar-btn" role="button" href="#" data-js="click"
					 aria-haspopup="true" aria-expanded="false">
				<span class="fas fa-bars fa-fw" title="{\App\Language::translate('LBL_MENU')}"></span>
			</a>
		</div>
		<div class="text-white mr-2">
			{assign var="COMPANY_DETAILS" value=$USER->get('companyDetails')}
			{if !empty($COMPANY_DETAILS['sum_open_orders'])}
				<i class="fas fa-file-alt mr-2"></i><span class="u-fs-12px">{\App\Language::translate('LBL_SUM_OPEN_ORDERS')}: {App\Fields\Currency::formatToDisplay($COMPANY_DETAILS['sum_open_orders'])}</span>
			{/if}
			{if !empty($COMPANY_DETAILS['creditlimit'])}
				<br><i class="fas fa-wallet mr-2"></i><span class="u-fs-12px">{\App\Language::translate('LBL_CREDIT_LIMIT')}: {App\Fields\Currency::formatToDisplay($COMPANY_DETAILS['creditlimit'])}</span>
			{/if}
		</div>
		<div class="dropdown js-shopping-cart">
			<a class="btn btn-outline-light active btn-sm mr-2" href="index.php?module=Products&view=ShoppingCart" role="button" data-placement="left">
				<span class="fas fa-shopping-cart"></span>
				<span class="badge badge-danger js-badge">{\YF\Modules\Products\Model\Cart::getCount()}</span>
			</a>
		</div>
		<div class="dropdown historyBtn">
			<a class="btn btn-outline-light active btn-sm showHistoryBtn mr-2" role="button" href="#" data-placement="left"
			   data-toggle="dropdown"
			   aria-expanded="false">
				<span class="fas fa-history"></span>
			</a>
		</div>
		{if $USER->getCompanies()}
			<a class="btn btn-outline-info active btn-sm mr-2" role="button" href="#" data-toggle="modal"
				data-target="#modalSelectCompanies">
				<span class="fas fa-exchange-alt"></span>
			</a>
		{/if}
		<div class="dropdown quickAction historyBtn">
			<form class="noSpaces" method="POST" action="index.php?module=Users&action=Logout">
				<button type="submit" class="loadPage btn btn-outline-light active btn-sm mr-2" role="button">
					<span class="fas fa-power-off" aria-hidden="true"></span>
				</button>
			</form>
		</div>
	</header>
{/strip}
