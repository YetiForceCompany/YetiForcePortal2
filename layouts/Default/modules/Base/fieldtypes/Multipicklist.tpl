{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<input type="hidden" name="{$FIELD_MODEL->getName()}" value=""/>
	<select id="{$MODULE_NAME}_{$VIEW}_fieldName_{$FIELD_MODEL->getName()}" title="{$FIELD_MODEL->getLabel()}" multiple
			class="chzn-select form-control col-md-12 {if !empty($FIELD_MODEL->getNotDisplayValuesList())} hideSelected{/if}"
			name="{$FIELD_MODEL->getName()}[]"
			data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}" {if $FIELD_MODEL->isMandatory()} data-validation-engine="validate[required]" {/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly {/if}>
		{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$FIELD_MODEL->getPicklistValues()}
			<option value="{\App\Functions::toSafeHTML($PICKLIST_NAME)}" {if in_array(\App\Functions::toSafeHTML($PICKLIST_NAME), $FIELD_MODEL->getFieldValuesList())} selected {/if}{if array_key_exists($PICKLIST_NAME, $FIELD_MODEL->getNotDisplayValuesList())} class="d-none" {/if}>{$PICKLIST_VALUE}</option>
		{/foreach}
		{foreach from=$FIELD_MODEL->getNotDisplayValuesList() key=PICKLIST_NAME item=ITERATION}
			<option value="{\App\Functions::toSafeHTML($PICKLIST_NAME)}" {if in_array(\App\Functions::toSafeHTML($PICKLIST_NAME), $FIELD_MODEL->getPicklistValues())} selected {/if}
					class="d-none">{$PICKLIST_NAME}</option>
		{/foreach}
	</select>
{/strip}
