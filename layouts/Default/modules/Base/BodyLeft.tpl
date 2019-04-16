{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-BodyLeft -->
	<div class="userDetailsContainer d-flex">
		<div class="col-sm-2 p-0">
			<img src="{\App\Config::$logo}" class="img-responsive logo" alt="Logo" title="Logo">
		</div>
		<div class="col-sm-10 userDetails">
			<div class="userName">
				<span class="name">{$USER->get('name')}</span>
			</div>
			<div class="companyName">
				<span class="name">{$USER->get('parentName')}</span>
			</div>
		</div>
	</div>
	<div class="menuContainer">
		<ul class="moduleList" style="padding-left:1px;">
			{foreach item=ITEM_MENU key=KEY from=YF\Modules\Base\Model\Menu::getInstance($MODULE_NAME)->getMenu()}
				{include file=\App\Resources::templatePath('Menu/'|cat:$ITEM_MENU.type|cat:'.tpl', $MODULE_NAME)}
			{/foreach}
		</ul>
	</div>
	<!-- /tpl-Base-BodyLeft -->
{/strip}
