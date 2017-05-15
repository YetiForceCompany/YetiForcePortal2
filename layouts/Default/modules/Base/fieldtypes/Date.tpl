{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}

{strip}
	<div class="input-group dateField">
		<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}" type="text" title="{$FIELD_MODEL->get('label')}" class="form-control dateFieldInput" name="{$FIELD_MODEL->getName()}" data-validation-engine="validate[custom[date]{if $FIELD_MODEL->isMandatory()},required{/if}]" {if $FIELD_MODEL->isEditableReadOnly()}readonly {/if} data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}" value="{$FIELD_MODEL->getEditViewDisplayValue()}"  />
		<span class="input-group-addon dateFieldButton"><span class="glyphicon glyphicon-calendar"></span></span>
	</div>
{/strip}