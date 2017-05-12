{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	<input 
		id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}" 
		type="text" 
		title="{$FIELD_MODEL->getLabel()}" 
		class="form-control" 
		name="{$FIELD_MODEL->getName()}" 
		value="{$FIELD_MODEL->getSafeRawValue()}"
		data-fieldinfo="{$FIELD_MODEL->getSafeFieldInfo()}" 
		data-validation-engine="validate[custom[url]{if $FIELD_MODEL->isMandatory()},required{/if}]" 
		{if $FIELD_MODEL->isEditableReadOnly()}readonly {/if}
	/>
{/strip}
