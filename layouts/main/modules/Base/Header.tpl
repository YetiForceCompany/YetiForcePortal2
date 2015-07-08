{strip}
	<!DOCTYPE html>
	<html lang="{Core_Language::getShortLanguageName()}">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<meta name="robots" content="noindex" />	
			<title>{Core_Language::translate($PAGETITLE, $MODULE_NAME)}</title>
			<link rel="icon" href="layouts/main/skins/images/favicon.ico">

			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
			<!--[if lt IE 9]>
			  <script src="libraries/Scripts/html5shiv/html5shiv.min.js"></script>
			  <script src="libraries/Scripts/respond/respond.min.js"></script>
			<![endif]-->
			
			{foreach key=index item=script from=$STYLES}
				<link rel="{$script->getRel()}" href="{$script->getHref()}" />
			{/foreach}
			{foreach key=index item=script from=$HEADER_SCRIPTS}
				<script src="{$script->getSrc()}"></script>
			{/foreach}
		</head>
		<body data-language="{$LANGUAGE}">
			<div id="js_strings" class="hide noprint">{Core_Json::encode(Core_Language::export($MODULE_NAME, 'jsLang'))}</div>
			<div id="page">
				<!-- container which holds data temporarly for pjax calls -->
				<div id="pjaxContainer" class="hide noprint"></div>
{/strip}

