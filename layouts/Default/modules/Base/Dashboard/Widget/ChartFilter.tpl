{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Base-Dashboard-Widget-ChartFilter o-chartfilter-container">
		<input type="hidden" name="typeChart" value="{$WIDGET_MODEL->get('typeChart')}">
		<input type="hidden" name="stacked" value="{$WIDGET_MODEL->get('stacked')}">
		<input type="hidden" name="colorsFromDividingField" value="{$WIDGET_MODEL->get('colorsFromDividingField')}">
		<input type="hidden" name="colorsFromFilters" value="{$WIDGET_MODEL->get('colorsFromFilters')}">
		<input type="hidden" name="filterIds" value="{App\Purifier::encodeHTML(App\Json::encode($WIDGET_MODEL->get('filterIds')))}">
		<input type="hidden" name="widgetData" value="{App\Purifier::encodeHTML(App\Json::encode($WIDGET_MODEL->get('widgetData')))}">
		<canvas></canvas>
	</div>
{/strip}
