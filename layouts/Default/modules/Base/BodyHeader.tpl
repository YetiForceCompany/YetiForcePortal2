{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<header class="tpl-Base-BodyHeader bodyHeader d-flex justify-content-end align-items-center js-body-header" data-js="container">
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
