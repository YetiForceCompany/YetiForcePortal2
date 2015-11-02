{strip}
	<div id="js_strings" class="hide noprint">{\Core\Json::encode(\Core\Language::export($MODULE_NAME, 'jsLang'))}</div>
	<div id="pjaxContainer" class="hide noprint"></div>	
	<div class="mainPage">
		<div class="mobileLeftPanel noPadding mobileOn">
			{include file=FN::templatePath("BodyLeft.tpl",$MODULE_NAME)}
		</div>
		<div class="leftPanel noPadding">
			{include file=FN::templatePath("BodyLeft.tpl",$MODULE_NAME)}
		</div>	
		<div class="mainBody">
			{include file=FN::templatePath("BodyHeader.tpl",$MODULE_NAME)}
			{include file=FN::templatePath("BodyContent.tpl",$MODULE_NAME)}
	{/strip}
