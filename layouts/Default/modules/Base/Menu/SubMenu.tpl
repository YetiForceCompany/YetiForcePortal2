{strip}
	{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
	<!-- tpl-Base-Menu-SubMenu -->
	{if isset($ITEM_MENU['childs']) && $ITEM_MENU['childs']|@count neq 0}
		{assign var=MENUS value=$ITEM_MENU['childs']}
		<div id="submenu-{$ITEM_MENU['id']}" class="c-submenu collapse" data-parent="#submenu-{if isset($ITEM_MENU['parent'])}{$ITEM_MENU['parent']}{else}0{/if}">
			<ul class="nav flex-column">
				{foreach key=KEY item=ITEM_MENU from=$MENUS}
					{include file=\App\Resources::templatePath('Menu/'|cat:$ITEM_MENU.type|cat:'.tpl', $MODULE_NAME)}
				{/foreach}
			</ul>
		</div>
	{/if}
	<!-- tpl-Base-Menu-SubMenu -->
{/strip}
