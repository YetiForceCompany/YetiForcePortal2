{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-List-Field-String -->
{assign var=FIELD_INFO value=\App\Json::encode($FIELD_MODEL->getFieldInfo())}
{assign var=LABEL value=$FIELD_MODEL->getFieldLabel()}
<input type="text" name="filters[{$FIELD_MODEL->getName()}]" class="form-control js-filter-field" title='{$LABEL}' data-fieldinfo='{$FIELD_INFO|escape}' />
<!-- /tpl-Base-List-Field-String -->
{/strip}
