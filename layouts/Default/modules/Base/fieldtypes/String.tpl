{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}" type="text" 
		title="{$FIELD_MODEL->getLabel()}" class="form-control" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory()}required{/if},funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" name="{$FIELD_MODEL->getName()}" value="{$FIELD_MODEL->getEditViewDisplayValue()}" data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}" {if $FIELD_MODEL->isEditableReadOnly()}readonly {/if} {if $FIELD_MODEL->getFieldParams() != ''}data-inputmask="'mask': '{$FIELD_MODEL->getFieldParams()}'" {/if} />
{/strip}
