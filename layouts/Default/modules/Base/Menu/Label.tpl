{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Menu-Label -->
	<li role="presentation" class="tpl-menu-Label nav-item c-menu__item menuLabel" data-id="{($ITEM_MENU['id'])}">
		<a class="{if !empty($ITEM_MENU['icon'])} hasIcon {/if} js-submenu-toggler collapsed"
				href="#"
				data-toggle="collapse"
				data-target="#submenu-{$ITEM_MENU['id']}"
				role="button"
				aria-haspopup="true"
				aria-expanded="false"
				aria-controls="submenu-{$ITEM_MENU['id']}">
			<span class="c-menu__item__icon {$ITEM_MENU['icon']}" aria-hidden="true"></span>
			<span class="c-menu__item__text js-menu__item__text" title="{$ITEM_MENU['name']}"> {$ITEM_MENU['name']} </span>
		</a>
		{include file=\App\Resources::templatePath('Menu/SubMenu.tpl', $MODULE_NAME)}
	</li>
	<!-- /tpl-Base-Menu-Label -->
{/strip}
