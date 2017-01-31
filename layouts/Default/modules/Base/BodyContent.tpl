{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	<div class="container-fluid bodyContent">
		<div class="mainContent">
			<div id="page">
				<input type="hidden" id="start_day" value="{$USER->get('dayoftheweek')}" />
				<input type="hidden" id="row_type" value="{$USER->get('rowheight')}" />
				<input type="hidden" id="current_user_id" value="{$USER->get('id')}" />
				<input type="hidden" id="userDateFormat" value="{$USER->get('date_format')}" />
				<input type="hidden" id="userTimeFormat" value="{$USER->get('hour_format')}" />
				<input type="hidden" id="numberOfCurrencyDecimal" value="{$USER->get('no_of_currency_decimals')}" />
				<input type="hidden" id="currencyGroupingSeparator" value="{$USER->get('currency_grouping_separator')}" />
				<input type="hidden" id="currencyDecimalSeparator" value="{$USER->get('currency_decimal_separator')}" />
				<input type="hidden" id="currencyGroupingPattern" value="{$USER->get('currency_grouping_pattern')}" />
				<input type="hidden" id="truncateTrailingZeros" value="{$USER->get('truncate_trailing_zeros')}" />
				<input type="hidden" id="view" value="{$VIEW}">
				<input type="hidden" id="module" value="{$MODULE_NAME}">
			{/strip}
