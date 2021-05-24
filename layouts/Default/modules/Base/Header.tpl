{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Header -->
<!DOCTYPE html>
<html lang="{$LANG}">
	<head>
		<title>{$PAGE_TITLE}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="robots" content="noindex"/>
		<link rel="icon" href="{\App\Resources::resourcePath("favicon.ico", $MODULE_NAME)}">
		{foreach item=SCRIPT from=$CSS_FILE}
			<link rel="{$SCRIPT->getRel()}" href="{$SCRIPT->getSrc()}"/>
		{/foreach}
	</head>
	<script type="text/javascript">
		let CONFIG = {\App\Config::getJsEnv()};
	</script>
	<body data-language="{$LANGUAGE}" class="bodyContainer {$MODULE_NAME}_{$ACTION_NAME}">
	{include file=\App\Resources::templatePath("Body.tpl", $MODULE_NAME)}
<!-- /tpl-Base-Header -->
{/strip}
