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
<body data-language="{$LANGUAGE}" class="bodyContainer {$MODULE_NAME}_{$ACTION_NAME} p-2">
	<div class="">
		<div class="d-flex py-2">
			<div class="col-md-6">
				<div class="logoContainer">
					<img src="{\App\Config::$logo}" class="img-responsive logo" alt="Logo" title="Logo">
				</div>
			</div>
			<div class="col-md-6">
				<div class="head float-right">
					<h3>{\App\Language::translate('LBL_INSTALLATION_WIZARD', $MODULE_NAME)}</h3>
				</div>
			</div>
		</div>
		<div class="row main-container">
			<div class="container-fluid">
<!-- /tpl-Install-InstallPreProcess -->
{/strip}
