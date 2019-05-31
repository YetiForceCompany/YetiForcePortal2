{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
<!DOCTYPE html>
{strip}
<html>
	<head>
		<title>Yetiforce:  {\App\Language::translate('LBL_ERROR_CODE')} {\App\Purifier::encodeHtml($CODE)}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        {foreach item=SCRIPT from=$CSS_FILE}
             <link rel="stylesheet" href="{$SCRIPT}">
        {/foreach}
	</head>
    <body class="h-100 bodyContainer">
        <div class="container pt-5 u-word-break">
            <div class="text-center">
                <img src="{\App\Config::$logo}">
            </div>
            <div class="text-center text-muted my-3" style="font-size: 30px;">
                 <i class="fas fa-exclamation-triangle mr-3 "></i> ERROR :( Code: {$CODE}
            </div>
            <a class="btn btn-lg btn-raised btn-info w-100 my-2" role="button" href="javascript:window.history.back();">
                <i class="fas fa-chevron-left mr-2"></i>{\App\Language::translate('LBL_STEP_BACK')}
            </a>
        </div>
        <script type="text/javascript" src="{YF_ROOT_WWW}libraries/@fortawesome/fontawesome/index.js"></script>
        <script type="text/javascript" src="{YF_ROOT_WWW}libraries/@fortawesome/fontawesome-free-solid/index.js"></script>
    </body>
</html>
{/strip}
