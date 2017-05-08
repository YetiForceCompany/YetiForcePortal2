{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	<div id="js_strings" class="hide noprint">{\YF\Core\Json::encode(\YF\Core\Language::export($MODULE_NAME, 'jsLang'))}</div>
	<div id="pjaxContainer" class="hide noprint"></div>
	<div class="mainPage">
		{include file=\YF\Core\Functions::templatePath("SearchMenu.tpl",$MODULE_NAME)}
		{include file=\YF\Core\Functions::templatePath("ActionMenu.tpl",$MODULE_NAME)}
		<div class="mobileLeftPanel noPadding visible-phone">
			{include file=\YF\Core\Functions::templatePath("BodyLeft.tpl",$MODULE_NAME)}
		</div>
		<div class="leftPanel noPadding hidden-phone">
			{include file=\YF\Core\Functions::templatePath("BodyLeft.tpl",$MODULE_NAME)}
		</div>
		<div class="mainBody">
			{include file=\YF\Core\Functions::templatePath("BodyHeader.tpl",$MODULE_NAME)}
			{include file=\YF\Core\Functions::templatePath("BodyContent.tpl",$MODULE_NAME)}
		{/strip}
