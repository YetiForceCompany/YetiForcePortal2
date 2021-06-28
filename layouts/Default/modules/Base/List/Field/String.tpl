{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-List-Field-String -->
<input type="text" name="filters[{$FIELD_MODEL->getName()}]" class="form-control js-filter-field" title='{$FIELD_MODEL->getFieldLabel()}' data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}' />
<!-- /tpl-Base-List-Field-String -->
{/strip}
