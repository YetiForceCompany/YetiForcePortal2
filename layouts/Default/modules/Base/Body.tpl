{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Body -->
<div id="js_strings"
	 class="d-none d-print-none">{\App\Json::encode(\App\Language::export($MODULE_NAME, 'js'))}</div>
<div id="pjaxContainer" class="d-none d-print-none"></div>
<div class="mainPage">
	<div class="leftPanel c-menu__container p-0 hidden-phone ">
		{include file=\App\Resources::templatePath("BodyLeft.tpl", $MODULE_NAME)}
	</div>
	<div class="mainBody">
		{include file=\App\Resources::templatePath("BodyHeader.tpl", $MODULE_NAME)}
		{include file=\App\Resources::templatePath("BodyContent.tpl", $MODULE_NAME)}
		<!-- /tpl-Base-Body -->
		{/strip}
