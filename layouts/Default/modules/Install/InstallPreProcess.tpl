{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!DOCTYPE html>
<html lang="{$LANG}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="robots" content="noindex"/>
	<title>{$PAGETITLE}</title>
	<link rel="icon" href="{\App\Resources::resourcePath("favicon.ico", $MODULE_NAME)}">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="public_html/libraries/html5shiv/html5shiv.js"></script>
	<script type="text/javascript" src="public_html/libraries/respond.js/dist/respond.min.js"></script>
	<![endif]-->
	{foreach item=SCRIPT from=$STYLES}
		<link rel="{$SCRIPT->getRel()}" href="{$SCRIPT->getSrc()}"/>
	{/foreach}
</head>
<body data-language="{$LANGUAGE}" class="bodyContainer {$MODULE_NAME}_{$ACTION_NAME}">

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
			{/strip}
