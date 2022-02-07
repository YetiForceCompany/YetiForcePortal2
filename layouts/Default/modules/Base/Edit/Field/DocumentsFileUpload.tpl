{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Edit-Field-DocumentsFileUpload -->
	{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
	{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
	{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($RECORD)}
	{assign var=PARAMS value=$FIELD_MODEL->getFieldParams()}
	{assign var=FILE_LOCATION_TYPE_FIELD value=$FIELDS['filelocationtype']}
	{assign var=FILE_LOCATION_TYPE value=$RECORD->getRawValue('filelocationtype')}
	{assign var=IS_INTERNAL_LOCATION_TYPE value=$RECORD->getRawValue('filelocationtype') neq 'E'}
	{assign var=IS_EXTERNAL_LOCATION_TYPE value=$RECORD->getRawValue('filelocationtype') eq 'E'}
	<div class="js-file-upload-container" data-js="container">
		<input name="{$FIELD_NAME}" type="text" value="{$FIELD_VALUE}" class="form-control js-file-upload-external {if $IS_INTERNAL_LOCATION_TYPE}d-none{/if}" title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}" tabindex="{$FIELD_MODEL->getTabIndex()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true}required,{/if}{if $FIELD_MODEL->get('maximumlength')}maxSize[{$FIELD_MODEL->get('maximumlength')}],{/if}funcCall[Base_InputMask_Validator_Js.invokeValidation]]" {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly" {/if} data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator="{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}" {/if} {if $IS_INTERNAL_LOCATION_TYPE}disabled="disabled" {/if} data-js="container" />
		<input name="{$FIELD_NAME}" type="file" value="{$FIELD_VALUE}" class="form-control js-file-upload-internal {if $IS_EXTERNAL_LOCATION_TYPE}d-none{/if}" title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}" tabindex="{$FIELD_MODEL->getTabIndex()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true}required,{/if}funcCall[Base_InputMask_Validator_Js.invokeValidation]]" {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly" {/if} data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator="{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}" {/if} {if $IS_EXTERNAL_LOCATION_TYPE}disabled="disabled" {/if} data-js="container" />
	</div>
	<!-- /tpl-Base-Edit-Field-DocumentsFileUpload -->
{/strip}
