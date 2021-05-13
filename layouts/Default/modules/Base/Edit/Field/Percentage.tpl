{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Edit-Field-Percentage -->
{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
<div class="input-group">
	<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}" tabindex="{$FIELD_MODEL->getTabIndex()}" title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}" class="input-medium form-control" min="0" max="100"
		   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" name="{$FIELD_MODEL->getName()}"
		   value="{$FIELD_MODEL->getEditViewDisplayValue($FIELD_MODEL->get('fieldvalue'),$RECORD)}" data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}
		   data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}'{/if} step="any" {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}/><span class="input-group-append"><span class="input-group-text">%</span></span>
</div>
<!-- /tpl-Base-Edit-Field-Percentage -->
{/strip}
