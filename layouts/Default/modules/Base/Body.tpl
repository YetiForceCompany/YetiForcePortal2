{strip}
	<div id="js_strings" class="hide noprint">{\Core\Json::encode(\Core\Language::export($MODULE_NAME, 'jsLang'))}</div>
	<div class="hide">
		<input type="hidden" value="{$MODULE_NAME}" id="module" name="module">
		<input type="hidden" value="{$ACTION_NAME}" id="view" name="view">
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2">
				{include file=FN::templatePath("MenuBlock.tpl",$MODULE_NAME)}
			</div>
			<div class="col-md-10">
				<div id="page">
					<!-- container which holds data temporarly for pjax calls -->
					<div id="pjaxContainer" class="hide noprint"></div>
				{/strip}
