{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-List-Field-Date -->
<input name="filters[{$FIELD_MODEL->getName()}]" type="text" class="form-control dateRangeField datepicker js-filter-field" data-date-format="{$USER->getPreferences('date_format')}" title="{$FIELD_MODEL->getFieldLabel()}" data-calendar-type="range" data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}' autocomplete="off"/>
<!-- /tpl-Base-List-Field-Date -->
{/strip}
