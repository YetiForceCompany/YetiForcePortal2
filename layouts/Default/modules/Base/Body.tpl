{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Body -->
	<div id="js_strings" class="d-none d-print-none">{\App\Json::encode(\App\Language::export($MODULE_NAME, 'js'))}</div>
	<div id="pjaxContainer" class="d-none d-print-none"></div>
	<div class="mainPage js-mobile-page js-base-container o-base-container c-menu--animation {if \App\Session::get('menuPin')} c-menu--open {/if}"
		data-js="container">
		<div class="js-sidebar leftPanel c-menu__container p-0  ">
			{include file=\App\Resources::templatePath("BodyLeft.tpl", $MODULE_NAME)}
		</div>
		{include file=\App\Resources::templatePath("BodyHeader.tpl", $MODULE_NAME)}
		<div class="basePanel">
			<div class="mainBody js-mobile-body">
				{include file=\App\Resources::templatePath("BodyContent.tpl", $MODULE_NAME)}
				<!-- /tpl-Base-Body -->
{/strip}
