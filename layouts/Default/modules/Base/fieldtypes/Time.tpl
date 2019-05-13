{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="input-group timeField">
		<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}" type="text"
			   title="{$FIELD_MODEL->get('label')}" class="form-control timeFieldInput clockPicker" name="{$FIELD_MODEL->getName()}"
			   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory()},required{/if},funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"
			   {if $FIELD_MODEL->isEditableReadOnly()}readonly {/if} data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}"
			   value="{$FIELD_MODEL->getEditViewDisplayValue()}"/>
		<span class="input-group-append timeFieldButton border border-dark px-3">
			<span class="input-group-text py-1">
				<span class="far fa-clock"></span>
			</span>
		</span>
	</div>
{/strip}
