{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Edit-Field-Image -->
	{assign var=FIELD_INFO_DATA value=$FIELD_MODEL->getFieldInfo()}
	{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_INFO_DATA))}
	{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
	{assign var=IS_MULTIPLE value=$FIELD_INFO_DATA.limit > 1}
	<div class="border rounded px-2 pt-2 clearfix c-multi-image js-multi-image">
		<input name="{$FIELD_MODEL->getName()}_temp{if $IS_MULTIPLE}[]{/if}" type="file" class="js-multi-image__file" tabindex="{$FIELD_MODEL->getTabIndex()}"
			accept="{$FIELD_MODEL->getAcceptFormats()}"
			data-validation-engine="validate[funcCall[Base_Validator_Js.invokeValidation]]" data-fieldinfo='{$FIELD_INFO}'
			data-js="value" {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}' {/if}
			{if $IS_MULTIPLE}multiple="multiple" {/if}>
		<input name="{$FIELD_MODEL->getName()}" type="hidden" id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}" value="{$FIELD_MODEL->getEditViewDisplayValue($RECORD)}"
			data-validation-engine="validate[funcCall[Base_Validator_Js.invokeValidation]]" data-fieldinfo='{$FIELD_INFO}' class="js-multi-image__values"
			data-js="value" {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}' {/if}>
		<div class="js-multi-image__result mt-2" data-js="container" data-name="{$FIELD_MODEL->getName()}"></div>
	</div>
	<!-- /tpl-Base-Edit-Field-Image -->
{/strip}
