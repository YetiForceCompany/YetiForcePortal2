{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
Code: {$CODE}<br>
Message: {App\Purifier::encodeHTML($MESSAGE)}<br>
Backtrace: {App\Purifier::encodeHTML($BACKTRACE)}<br>
SESSION: <pre>{App\Purifier::encodeHTML(print_r($SESSION, true))}</pre>
{/strip}
