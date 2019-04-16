{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Menu-Module -->
	<li role="presentation" class="active">
		<a href="{$ITEM_MENU['link']}">
			<div class="iconContainer">
				<div class="iconImage">
					<span class="{$ITEM_MENU['icon']}"></span>
				</div>
			</div>
			<div class="labelContainer">
				<div class="labelValue">
					{$ITEM_MENU['name']}
				</div>
			</div>
		</a>
		{include file=\App\Resources::templatePath('Menu/SubMenu.tpl', $MODULE_NAME)}
	</li>
	<!-- /tpl-Base-Menu-Module -->
{/strip}
