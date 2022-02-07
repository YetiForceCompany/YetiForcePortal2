{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!DOCTYPE html>
	<!-- tpl-Base-Exception -->
	<html>

	<head>
		<title>YetiForce Portal: {\App\Language::translate('LBL_EXCEPTION')} {\App\Purifier::encodeHtml($CODE)}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		{foreach item=SCRIPT from=$CSS_FILE}
			<link rel="stylesheet" href="{$SCRIPT}">
		{/foreach}
		{foreach item=SCRIPT from=$JS_FILE}
			<script src="{$SCRIPT}"></script>
		{/foreach}
	</head>

	<body class="h-100 c-exception">
		<div class="container pt-5 u-word-break">
			<div class="card mx-auto shadow" role="alert">
				<div class="card-header c-exception__card-header d-flex justify-content-center flex-wrap">
					<h1 class="align-items-center justify-content-center m-0">
						<span class="fas fa-exclamation-triangle fa-lg float-left mr-5"></span>
						<span class="fas fa-exclamation-triangle fa-lg float-right ml-5"></span>
						<strong>{\App\Language::translate('LBL_ERROR_CODE')} {$CODE}</strong>
					</h1>
				</div>
				<div class="card-body c-exception__card-body">
					{if !empty($MESSAGE)}
						<h4 class="card-text">
							{\App\Language::translate('LBL_MESSAGE')}: {\App\Purifier::encodeHtml($MESSAGE)}
						</h4>
					{/if}
					{if !empty($BACKTRACE)}
						<hr>
						<p class="card-text">
							<strong>{\App\Language::translate('LBL_BACKTRACE')}</strong>:<br> {nl2br(\App\Purifier::encodeHtml($BACKTRACE))}
						</p>
					{/if}
					{if !empty($PREVIOUS_MESSAGE)}
						<hr>
						<h5 class="card-text">
							{\App\Language::translate('LBL_PREVIOUS')}: {\App\Purifier::encodeHtml($PREVIOUS_MESSAGE)}
						</h5>
					{/if}
					{if !empty($PREVIOUS_BACKTRACE)}
						<hr>
						<p class="card-text">
							<strong>{\App\Language::translate('LBL_PREVIOUS')}</strong>:<br> {nl2br(\App\Purifier::encodeHtml($PREVIOUS_BACKTRACE))}
						</p>
					{/if}
				</div>
				<div class="card-footer c-exception__card-footer d-flex flex-wrap flex-sm-nowrap">
					<a class="btn btn-lg mr-sm-2 mb-1 mb-sm-0 w-100" role="button" href="javascript:window.history.back();">
						<span class="fas fa-chevron-left mr-2"></span>{\App\Language::translate('LBL_STEP_BACK')}
					</a>
					<a class="btn btn-lg w-100 m-0" role="button" href="index.php">
						<span class="fas fa-home mr-2"></span>{\App\Language::translate('LBL_HOME')}
					</a>
				</div>
			</div>
			{if isset($SESSION) && $SESSION}
				<div class="card mx-auto shadow mt-4" role="alert">
					<div class="card-header text-white bg-secondary u-cursor-default d-flex justify-content-center flex-wrap">
						<h3 class="card-title d-flex align-items-center justify-content-center m-0">
							<strong>SESSION</strong>
						</h3>
					</div>
					<div class="card-body c-exception__card-body p-2">
						<pre>{\App\Purifier::encodeHtml(print_r($SESSION, true))}</pre>
					</div>
				</div>
				{if App\Config::getBool('debugConsole')}
					<div class="card mx-auto shadow mt-4" role="alert">
						<div class="card-header text-white bg-info u-cursor-default d-flex justify-content-center flex-wrap">
							<h3 class="card-title d-flex align-items-center justify-content-center m-0">
								<strong>{\App\Language::translate('LBL_CORE_LOG')}</strong>
							</h3>
						</div>
						<div class="card-body c-exception__card-body p-2">
							{foreach item=MESSAGES from=\App\Log::display()}
								{foreach item=MESSAGE from=$MESSAGES}
									<p>{$MESSAGE}</p>
								{/foreach}
							{/foreach}
						</div>
					</div>
				{/if}
			{/if}
		</div>
	</body>

	</html>
	<!-- /tpl-Base-Exception -->
{/strip}
