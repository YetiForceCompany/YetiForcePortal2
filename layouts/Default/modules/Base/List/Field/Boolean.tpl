{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-List-Field-Boolean -->
<select name="filters[{$FIELD_MODEL->getName()}]" class="form-control js-filter-field" title="{$FIELD_MODEL->getFieldLabel()}" data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}'>
	<option value="">{\App\Language::translate('LBL_SELECT_OPTION','Vtiger')}</option>
	<option value="1">{\App\Language::translate('LBL_YES', $MODULE_NAME)}</option>
	<option value="0">{\App\Language::translate('LBL_NO', $MODULE_NAME)}</option>
</select>
<!-- /tpl-Base-List-Field-Boolean -->
{/strip}
