{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Edit-Field-String -->
	{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
	{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
	{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($RECORD)}
	{assign var=PARAMS value=$FIELD_MODEL->getFieldParams()}
	<input name="{$FIELD_NAME}" type="text" value="{$FIELD_VALUE}" class="form-control" title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}" tabindex="{$FIELD_MODEL->getTabIndex()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true}required,{/if}{if $FIELD_MODEL->get('maximumlength')}maxSize[{$FIELD_MODEL->get('maximumlength')}],{/if}funcCall[Base_InputMask_Validator_Js.invokeValidation]]" {if $FIELD_MODEL->getUIType() eq '3' || $FIELD_MODEL->getUIType() eq '4' || $FIELD_MODEL->isEditableReadOnly()} readonly="readonly" {/if} data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator="{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}" {/if} {if isset($PARAMS['mask'])}data-inputmask="'mask': {\App\Purifier::encodeHtml(\App\Json::encode($PARAMS['mask']))}" {/if} />
	<!-- /tpl-Base-Edit-Field-String -->
{/strip}
