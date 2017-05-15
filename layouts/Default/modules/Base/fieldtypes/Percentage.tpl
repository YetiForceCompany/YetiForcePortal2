{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	<div class="input-group">
		<input 
			id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}" 
			type="text" 
			title="{$FIELD_MODEL->getLabel()}" 
			class="form-control" 
			name="{$FIELD_MODEL->getName()}" 
			value="{$FIELD_MODEL->getEditViewDisplayValue()}"
			data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}" 
			data-validation-engine="validate[custom[number],min[0],max[100]{if $FIELD_MODEL->isMandatory()},required{/if}]" 
			{if $FIELD_MODEL->isEditableReadOnly()}readonly {/if}
		/>
		<span class="input-group-addon">%</span>
	</div>
{/strip}



