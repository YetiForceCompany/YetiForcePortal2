{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Menu-HomeIcon -->
	<li role="presentation" class="active">
		<a class="nav-link" href="index.php?module=Home&view=Dashboard">
			<span class="c-menu__item__icon userIcon-Home"></span>
			<span class="c-menu__item__text" title="{$ITEM_MENU['name']}">
    			{$ITEM_MENU['name']}
			</span>
		</a>
		{include file=\App\Resources::templatePath('Menu/SubMenu.tpl', $MODULE_NAME)}
	</li>
	<!-- /tpl-Base-Menu-HomeIcon -->
{/strip}
