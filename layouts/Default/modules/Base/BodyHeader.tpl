{*
<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-BodyHeader -->
	<div class="bodyHeader">
		<header class="float-right mt-2 d-flex align-items-center px-2 js-body-header c-header" data-js="container">
			<a class="btn btn-light btn-sm mr-2 c-header__btn c-header__btn--sidebar mb-0 js-sidebar-btn" role="button" href="#" data-js="click" aria-haspopup="true" aria-expanded="false">
				<span class="fas fa-bars fa-fw" title="{\App\Language::translate('LBL_MENU')}"></span>
			</a>
			{if !empty(\Conf\Config::$headerAlertMessage)}
				<div class="alert {if empty(\Conf\Config::$headerAlertType)}alert-danger{else}{\Conf\Config::$headerAlertType}{/if} mr-2 mb-0 px-3 py-1 text-center u-font-size-19px text-nowrap"
					role="alert">
					<i class="{if empty(\Conf\Config::$headerAlertIcon)}fas fa-exclamation-triangle{else}{\Conf\Config::$headerAlertIcon}{/if}"></i>
					<span class="font-weight-bold mx-3">{\Conf\Config::$headerAlertMessage}</span>
					<i class="{if empty(\Conf\Config::$headerAlertIcon)}fas fa-exclamation-triangle{else}{\Conf\Config::$headerAlertIcon}{/if}"></i>
				</div>
			{/if}
			{if \Conf\Modules\Products::$shoppingMode}
				{assign var="COMPANY_DETAILS" value=$USER->get('companyDetails')}
				{if !empty($COMPANY_DETAILS['sum_open_orders']) || !empty($COMPANY_DETAILS['creditlimit'])}
					<div class="badge badge-light mr-2 p-2 text-truncate text-black">
						{if !empty($COMPANY_DETAILS['sum_open_orders'])}
							<i class="fas fa-file-alt mr-2"></i>
							<span class="u-font-size-19px">
								{\App\Language::translate('LBL_SUM_OPEN_ORDERS')}: {App\Fields\Currency::formatToDisplay($COMPANY_DETAILS['sum_open_orders'])}
							</span>
						{/if}
						{if !empty($COMPANY_DETAILS['creditlimit'])}
							<br>
							<i class="fas fa-wallet mr-2"></i>
							<span class="u-font-size-19px">
								{\App\Language::translate('LBL_CREDIT_LIMIT')}: {App\Fields\Currency::formatToDisplay($COMPANY_DETAILS['creditlimit'])}
							</span>
						{/if}
					</div>
				{/if}
			{/if}
			<div class="dropdown historyBtn js-popover-tooltip" data-content="{\App\Language::translate('LBL_PAGES_HISTORY')}" data-js="popover">
				<a class="btn btn-light showHistoryBtn mr-2 mb-0 py-1" role="button" href="#" data-placement="left" data-toggle="dropdown" aria-expanded="false">
					<span class="fas fa-history"></span>
				</a>
			</div>
			<nav class="actionMenu" aria-label="{\App\Language::translate('QUICK_ACCESS_MENU')}">
				<div class="o-action-menu__container d-flex flex-md-nowrap flex-column flex-md-row" id="o-action-menu__container">
					{if \Conf\Modules\Products::$shoppingMode}
						<div class="o-action-menu__item">
							<a class=" p-1 js-shopping-cart btn btn-light mr-2 mb-0 js-popover-tooltip" href="index.php?module=Products&view=ShoppingCart" role="button" data-placement="left" data-content="{\App\Language::translate('LBL_SHOPPING_CART','Products')}" data-js="popover">
								<span class="fas fa-shopping-cart"></span>
								<span class="badge badge-danger js-badge">{\YF\Modules\Products\Model\Cart::getCount()}</span>
							</a>
						</div>
					{/if}
					<div class="o-action-menu__item">
						<div class="dropdown">
							<a class="c-header__btn btn dropdown-toggle js-popover-tooltip dropdownMenu p-1 btn-light"
								id="showUserQuickMenuBtn" data-js="popover" data-toggle="dropdown" data-boundary="window"
								data-content="{\App\Language::translate('LBL_MY_PREFERENCES')}" href="#" role="button">
								<span class="fas fa-user fa-fw" title="{\App\Language::translate('LBL_MY_PREFERENCES')}"></span>
							</a>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" role="list"
								data-js="perfectscrollbar">
								<div class="user-info-body container-fluid m-0 pl-2 pr-2 pt-2">
									<div class="user-info row w-100 m-0 p-0">
										<div class="col-12 p-1">
											<div class="user-photo mr-2 float-left">
												<span class="o-detail__icon yfm-Users"></span>
											</div>
											<div class="user-detail">
												<h6 class="mb-0 pb-0 u-text-ellipsis">{$USER->get('name')}</h6>
												<span class="u-fs-xs text-gray">{$USER->get('parentName')}</span>
											</div>
										</div>
									</div>
								</div>
								<div class="user-links container-fluid d-block mt-2 p-0 u-max-w-xsm-100">
									<div class="user-menu-element row p-0 m-0">
										<div class="col-12 pt-1 pb-1 bg-light border text-center border-light">
											<span class="text-uppercase font-weight-bold text-dark u-fs-sm">{\App\Language::translate('LBL_ACCOUNT_SETTINGS', 'Users')}</span>
										</div>
									</div>
									{if $USER->getCompanies()}
										<div class="user-menu-element row px-2 m-2">
											<a class="text-decoration-none u-fs-sm text-secondary d-block active" role="button"
												href="#" data-toggle="modal" data-target="#modalSelectCompanies">
												<span class="fas fa-exchange-alt" title="{\App\Language::translate('LBL_SWITCH_USERS', 'Users')}"></span>
												<span class="ml-2">{\App\Language::translate('LBL_SWITCH_USERS', 'Users')}</span>
											</a>
										</div>
										<div class="dropdown-divider d-none d-sm-none d-md-block"></div>
									{/if}
									{foreach item=ITEM_MENU from=$USER_QUICK_MENU}
										<div class="user-menu-element row px-2 m-2">
											{\App\Layout\Action::getButton($ITEM_MENU)}
										</div>
									{/foreach}
									<div class="dropdown-divider d-none d-sm-none d-md-block"></div>
									<div class="user-menu-element row px-2 m-2">
										<a class="loadPage text-decoration-none u-fs-sm text-secondary" role="button" href="index.php?module=Users&action=Logout">
											<span class="fas fa-power-off" aria-hidden="true"></span>
											<span class="ml-2">{\App\Language::translate('LBL_SIGN_OUT', 'Users')}</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</header>
	</div>
	<!-- /tpl-Base-BodyHeader -->
{/strip}
