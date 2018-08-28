{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<div id="js_strings"
	 class="d-none d-print-none">{\App\Json::encode(\App\Language::export($MODULE_NAME, 'jsLang'))}</div>
<div id="pjaxContainer" class="d-none d-print-none"></div>
<div class="mainPage">
	{include file=\App\Functions::templatePath("SearchMenu.tpl",$MODULE_NAME)}
	{include file=\App\Functions::templatePath("ActionMenu.tpl",$MODULE_NAME)}
	<div class="mobileLeftPanel p-0 visible-phone">
		{include file=\App\Functions::templatePath("BodyLeft.tpl",$MODULE_NAME)}
	</div>
	<div class="leftPanel p-0 hidden-phone">
		{include file=\App\Functions::templatePath("BodyLeft.tpl",$MODULE_NAME)}
	</div>
	<div class="mainBody">
		{include file=\App\Functions::templatePath("BodyHeader.tpl",$MODULE_NAME)}
		{include file=\App\Functions::templatePath("BodyContent.tpl",$MODULE_NAME)}
		{/strip}
