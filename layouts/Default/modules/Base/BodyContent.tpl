{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<div class="container-fluid bodyContent">
	<div class="mainContent">
		<div id="page">
			<input type="hidden" id="start_day" value="{$USER->getPreferences('dayoftheweek')}"/>
			<input type="hidden" id="row_type" value="{$USER->getPreferences('rowheight')}"/>
			<input type="hidden" id="current_user_id" value="{$USER->getPreferences('id')}"/>
			<input type="hidden" id="userDateFormat" value="{$USER->getPreferences('date_format')}"/>
			<input type="hidden" id="userTimeFormat" value="{$USER->getPreferences('hour_format')}"/>
			<input type="hidden" id="numberOfCurrencyDecimal"
				   value="{$USER->getPreferences('no_of_currency_decimals')}"/>
			<input type="hidden" id="currencyGroupingSeparator"
				   value="{$USER->getPreferences('currency_grouping_separator')}"/>
			<input type="hidden" id="currencyDecimalSeparator"
				   value="{$USER->getPreferences('currency_decimal_separator')}"/>
			<input type="hidden" id="currencyGroupingPattern"
				   value="{$USER->getPreferences('currency_grouping_pattern')}"/>
			<input type="hidden" id="truncateTrailingZeros" value="{$USER->getPreferences('truncate_trailing_zeros')}"/>
			<input type="hidden" id="view" value="{$VIEW}">
			<input type="hidden" id="module" value="{$MODULE_NAME}">
			{/strip}
