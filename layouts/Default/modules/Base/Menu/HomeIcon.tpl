{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Menu-HomeIcon -->
	{if $ITEM_MENU['name'] == $MODULE_NAME}
		{assign var=ACTIVE value='true'}
	{else}
		{assign var=ACTIVE value='false'}
	{/if}
	{if isset($ITEM_MENU['childs']) && $ITEM_MENU['childs']|@count neq 0}
		{assign var=HASCHILDS value='true'}
	{else}
		{assign var=HASCHILDS value='false'}
	{/if}
	<li role="presentation" class="tpl-menu-HomeIcon c-menu__item nav-item menuHomeIcon" data-id="{$ITEM_MENU['id']}">
		<a class="{if $ACTIVE == 'true'} active {else} collapsed {/if} hasIcon js-submenu-toggler" {if $HASCHILDS == 'true'} data-toggle="collapse" data-target="#submenu-{$ITEM_MENU['id']}" role="button"{/if} href="index.php?module=Home&view=Dashboard" aria-haspopup="true" aria-expanded="{$ACTIVE}" aria-controls="submenu-{$ITEM_MENU['id']}">
			<span class="c-menu__item__icon yfm-Home" aria-hidden="true"></span>
  			<span class="c-menu__item__text" title="{$ITEM_MENU['name']}">
    			{App\Language::translate($ITEM_MENU['name'])}
  			</span>
		</a>
		{include file=\App\Resources::templatePath('Menu/SubMenu.tpl', $MODULE_NAME)}
	</li>
	<!-- /tpl-Base-Menu-HomeIcon -->
{/strip}
