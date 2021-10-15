{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
	{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
	{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($RECORD)}
	{assign var=UNIQUE_ID value=10|mt_rand:20}
	<div>
		{if $FIELD_MODEL->getUIType() eq '19' || $FIELD_MODEL->getUIType() eq '20' || $FIELD_MODEL->getUIType() eq '300' }
			{assign var=PARAMS value=$FIELD_MODEL->getFieldParams()}
			<textarea name="{$FIELD_NAME}" tabindex="{$FIELD_MODEL->getTabIndex()}"
				id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}_{$UNIQUE_ID}{if $FIELD_MODEL->getUIType() eq '300' && !empty($VIEW) && $VIEW eq 'QuickCreateAjax'}_qc{/if}"
				class="col-md-12 form-control {if $FIELD_MODEL->getUIType() eq '300'}js-editor{/if} {if !empty($PARAMS['class'])}{$PARAMS['class']}{/if}"
				title="{\App\Language::translate($FIELD_MODEL->getFieldLabel())}"
				data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true}required,{/if}{if $FIELD_MODEL->get('maximumlength')}funcCall[Base_MaxSizeInByte_Validator_Js.invokeValidation]{else}funcCall[Base_Validator_Js.invokeValidation]]{/if}"
				data-fieldinfo='{$FIELD_INFO}' {if $FIELD_MODEL->getUIType() eq '300'}data-emoji-enabled="true" data-mentions-enabled="true" data-js="ckEditor" {/if}
				{if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}' {/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly" {/if}>
												{$FIELD_VALUE}
											</textarea>
		{else}
			<textarea name="{$FIELD_NAME}" id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}"
				class="form-control" tabindex="{$FIELD_MODEL->getTabIndex()}" title="{\App\Language::translate($FIELD_MODEL->getFieldLabel())}"
				data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true}required,{/if}{if $FIELD_MODEL->get('maximumlength')}funcCall[Base_MaxSizeInByte_Validator_Js.invokeValidation]{else}funcCall[Base_Validator_Js.invokeValidation]]{/if}]]"
				data-fieldinfo='{$FIELD_INFO}'
				{if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}' {/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly" {/if}>
											{$FIELD_VALUE}
											</textarea>
		{/if}
	</div>
{/strip}
