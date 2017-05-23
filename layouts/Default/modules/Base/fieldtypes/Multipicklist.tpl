{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	<input type="hidden" name="{$FIELD_MODEL->getName()}" value="" />
	<select id="{$MODULE_NAME}_{$VIEW}_fieldName_{$FIELD_MODEL->getName()}" title="{$FIELD_MODEL->getLabel()}" multiple class="chzn-select form-control col-md-12 {if !empty($FIELD_MODEL->getNotDisplayValuesList())} hideSelected{/if}" name="{$FIELD_MODEL->getName()}[]" data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}" {if $FIELD_MODEL->isMandatory()} data-validation-engine="validate[required]" {/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly {/if}>
		{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$FIELD_MODEL->getPicklistValues()}
			<option value="{\YF\Core\Functions::toSafeHTML($PICKLIST_NAME)}" {if in_array(\YF\Core\Functions::toSafeHTML($PICKLIST_NAME), $FIELD_MODEL->getFieldValuesList())} selected {/if}{if array_key_exists($PICKLIST_NAME, $FIELD_MODEL->getNotDisplayValuesList())} class="hide" {/if}>{$PICKLIST_VALUE}</option>
		{/foreach}
		{foreach from=$FIELD_MODEL->getNotDisplayValuesList() key=PICKLIST_NAME item=ITERATION}
			<option value="{\YF\Core\Functions::toSafeHTML($PICKLIST_NAME)}" {if in_array(\YF\Core\Functions::toSafeHTML($PICKLIST_NAME), $FIELD_MODEL->getPicklistValues())} selected {/if} class="hide">{$PICKLIST_NAME}</option>
		{/foreach} 
	</select>
{/strip}
