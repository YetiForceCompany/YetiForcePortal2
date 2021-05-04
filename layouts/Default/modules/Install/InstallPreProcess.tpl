{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Install-InstallPreProcess -->
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
	{foreach item=SCRIPT from=$STYLES}
		<link rel="{$SCRIPT->getRel()}" href="{$SCRIPT->getSrc()}"/>
	{/foreach}
</head>
<body data-language="{$LANGUAGE}" class="bodyContainer {$MODULE_NAME}_{$ACTION_NAME} p-4">
	<input type="hidden" id="view" value="{$VIEW}">
	<input type="hidden" id="module" value="{$MODULE_NAME}">
	<div class="">
		<div class="row main-container">
			<div class="container-fluid">
<!-- /tpl-Install-InstallPreProcess -->
{/strip}
