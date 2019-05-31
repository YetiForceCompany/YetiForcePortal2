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
    <body class="h-100 c-exception">
        <div class="container pt-5 u-word-break">
            <div class="card mx-auto shadow" role="alert">
                <div class="card-header c-exception__card-header d-flex justify-content-center flex-wrap">
                    <i class="fas fa-exclamation-triangle fa-5x mr-3"></i>
                    <h3 class="card-title d-flex align-items-center justify-content-center">
                        <strong> {\App\Language::translate('LBL_ERROR_CODE')} {$CODE}</strong>
                    </h3>
                </div>
                <div class="card-body c-exception__card-body">
                    <p class="card-text">
                        {\App\Language::translate('LBL_MESSAGE')}: <br> {\App\Purifier::encodeHtml($MESSAGE)}<br><br>
                        {\App\Language::translate('LBL_BACKTRACE')}: <br> {\App\Purifier::encodeHtml($BACKTRACE)}<br><br>
                    </p>
                </div>
                <div class="card-footer c-exception__card-footer d-flex flex-wrap flex-sm-nowrap">
                    <a class="btn btn-lg mr-sm-2 mb-1 mb-sm-0 w-100" role="button" href="javascript:window.history.back();">
                        <i class="fas fa-chevron-left mr-2"></i>
                         {\App\Language::translate('LBL_STEP_BACK')}
                    </a>
                    <a class="btn btn-lg w-100 m-0" role="button" href="index.php">
                        <i class="fas fa-home mr-2"></i>
                        {\App\Language::translate('LBL_HOME')}
                    </a>
                </div>
            </div>
            {if $SESSION}
                <div class="card mx-auto shadow mt-4" role="alert">
                    <div class="card-header text-white bg-info u-cursor-default d-flex justify-content-center flex-wrap">
                        <h3 class="card-title d-flex align-items-center justify-content-center m-0">
                            <strong>SESSION</strong>
                        </h3>
                    </div>
                    <div class="card-body c-exception__card-body">
                        <p class="card-text">
                            <pre>{\App\Purifier::encodeHtml(print_r($SESSION, true))}</pre>
                        </p>
                    </div>
                </div>
            {/if}
        </div>
        <script type="text/javascript" src="{YF_ROOT_WWW}libraries/@fortawesome/fontawesome/index.js"></script>
        <script type="text/javascript" src="{YF_ROOT_WWW}libraries/@fortawesome/fontawesome-free-solid/index.js"></script>
    </body>
</html>
{/strip}
