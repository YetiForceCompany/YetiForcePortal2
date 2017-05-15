{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	<input 
		id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}" 
		type="text" 
		title="{$FIELD_MODEL->getLabel()}" 
		class="form-control" 
		data-validation-engine="validate[custom[phone]{if $FIELD_MODEL->isMandatory()},required{/if}]" 
		name="{$FIELD_MODEL->getName()}" 
		value="{$FIELD_MODEL->getEditViewDisplayValue()}"
		data-fieldinfo="{$FIELD_MODEL->getSafeFieldInfo()}" 
		{if $FIELD_MODEL->isEditableReadOnly()}readonly {/if}
		{if $FIELD_MODEL->getFieldParams() != ''}data-inputmask="'mask': '{$FIELD_MODEL->getFieldParams()}'" {/if}
	/>
{/strip}
