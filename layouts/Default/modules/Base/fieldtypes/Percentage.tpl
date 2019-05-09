{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="input-group">
		<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}" type="text"
			   title="{$FIELD_MODEL->getLabel()}" class="input-medium form-control" name="{$FIELD_MODEL->getName()}"
			   value="{$FIELD_MODEL->getEditViewDisplayValue()}" data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}"
			   data-validation-engine="validate[min[0],max[100]{if $FIELD_MODEL->isMandatory()},required{/if},funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"
			   {if $FIELD_MODEL->isEditableReadOnly()}readonly {/if} />
		<span class="input-group-append border border-dark px-3">
			<span class="input-group-text py-1">%</span>
		</span>
	</div>
{/strip}
