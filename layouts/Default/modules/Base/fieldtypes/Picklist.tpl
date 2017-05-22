{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	<select class="chzn-select form-control" title="{$FIELD_MODEL->getLabel()}" name="{$FIELD_MODEL->getName()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory()}required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}" data-selected-value="{$FIELD_MODEL->getEditViewDisplayValue()}" {if $FIELD_MODEL->isEditableReadOnly()}readonly {/if}>
		{if $FIELD_MODEL->isEmptyPicklistOptionAllowed()}<option value="" {if $FIELD_MODEL->isMandatory() && $FIELD_MODEL->getEditViewDisplayValue() neq ''} disabled{/if}>{\YF\Core\Functions::translate('PLL_SELECT_OPTION',$MODULE_NAME)}</option>{/if}
		{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$FIELD_MODEL->getPicklistValues()}
			<option value="{\YF\Core\Functions::toSafeHTML($PICKLIST_NAME)}" title="{$PICKLIST_VALUE}" {if trim($FIELD_MODEL->getEditViewDisplayValue()) eq trim($PICKLIST_NAME)} selected {/if}>{$PICKLIST_VALUE}</option>
		{/foreach}
	</select>
{/strip}
