{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	{assign var="FIELD_INFO" value=\YF\Core\Functions::toSafeHTML(\YF\Core\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var=PICKLIST_VALUES value=$FIELD_MODEL->getPicklistValues()}
	{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
	{assign var="FIELD_NAME" value=$FIELD_MODEL->get('name')}
	{if $RECORD->getRawValue($FIELD_NAME)}
		{assign var="FIELD_VALUE_LIST" value=explode(' |##| ',$RECORD->getRawValue($FIELD_NAME))}
		{assign var=NOT_DISPLAY_LIST_VALUES value=array_diff_key(array_flip($FIELD_VALUE_LIST), $PICKLIST_VALUES)}
	{else}
		{assign var="FIELD_VALUE_LIST" value=[]}
		{assign var=NOT_DISPLAY_LIST_VALUES value=[]}
	{/if}

	<input type="hidden" name="{$FIELD_NAME}" value="" />
	<select id="{$MODULE_NAME}_{$VIEW}_fieldName_{$FIELD_NAME}" title="{$FIELD_MODEL->get('label')}" multiple class="chzn-select form-control col-md-12 {if !empty($NOT_DISPLAY_LIST_VALUES)} hideSelected{/if}" name="{$FIELD_NAME}[]" data-fieldinfo='{$FIELD_INFO}' {if $FIELD_MODEL->isMandatory() eq true} data-validation-engine="validate[required]" {if !empty($SPECIAL_VALIDATOR)}data-validator='{\YF\Core\Json::encode($SPECIAL_VALIDATOR)}'{/if} {/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}>
		{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$PICKLIST_VALUES}
			<option value="{\YF\Core\Functions::toSafeHTML($PICKLIST_NAME)}" {if in_array(\YF\Core\Functions::toSafeHTML($PICKLIST_NAME), $FIELD_VALUE_LIST)} selected {/if}{if $NOT_DISPLAY_LIST_VALUES && array_key_exists($PICKLIST_NAME, $NOT_DISPLAY_LIST_VALUES)} class="hide" {/if}>{$PICKLIST_VALUE}</option>
		{/foreach}
		{foreach from=$NOT_DISPLAY_LIST_VALUES key=PICKLIST_NAME item=ITERATION}
			<option value="{\YF\Core\Functions::toSafeHTML($PICKLIST_NAME)}" {if in_array(\YF\Core\Functions::toSafeHTML($PICKLIST_NAME), $FIELD_VALUE_LIST)} selected {/if} class="hide">{$PICKLIST_NAME}</option>
		{/foreach}
	</select>
{/strip}
