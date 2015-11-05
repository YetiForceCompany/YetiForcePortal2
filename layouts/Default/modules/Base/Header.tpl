{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	<!DOCTYPE html>
	<html lang="{$LANG}">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<meta name="robots" content="noindex" />	
			<title>{FN::translate($PAGETITLE, $MODULE_NAME)}</title>
			<link rel="icon" href="{FN::fileTemplate("favicon.ico",$MODULE_NAME)}">

			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
			<!--[if lt IE 9]>
			  <script src="libraries/Scripts/html5shiv/html5shiv.min.js"></script>
			  <script src="libraries/Scripts/respond/respond.min.js"></script>
			<![endif]-->

			{foreach item=SCRIPT from=$STYLES}
				<link rel="{$SCRIPT->getRel()}" href="{$SCRIPT->getSrc()}" />
			{/foreach}
			{foreach item=SCRIPT from=$HEADER_SCRIPTS}
				<script src="{$SCRIPT->getSrc()}"></script>
			{/foreach}
		</head>
		<body data-language="{$LANGUAGE}" class="bodyContainer {$MODULE_NAME}_{$ACTION_NAME}">
			{include file=FN::templatePath("Body.tpl",$MODULE_NAME)}
		{/strip}

