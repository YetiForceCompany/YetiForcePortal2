{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	{assign var=PICKLIST_VALUES value=$FIELD_MODEL->getPicklistValues()}
	<select class="select2 form-control" title="{$FIELD_MODEL->getLabel()}" name="{$FIELD_MODEL->getName()}"
			data-validation-engine="validate[{if $FIELD_MODEL->isMandatory()}required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"
			data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}"
			data-selected-value="{$FIELD_MODEL->getEditViewDisplayValue()}"
			{if $FIELD_MODEL->isEditableReadOnly()} readonly="readonly" disabled="disabled" {/if}>
		{if $FIELD_MODEL->isEmptyPicklistOptionAllowed() && !($FIELD_MODEL->isMandatory() && $FIELD_MODEL->getEditViewDisplayValue() neq '')}
			<optgroup>
				<option value="">{\App\Language::translate('PLL_SELECT_OPTION', $MODULE_NAME)}</option>
			</optgroup>
		{/if}
		{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$PICKLIST_VALUES}
			<option value="{\App\Purifier::encodeHtml($PICKLIST_NAME)}"
					title="{$PICKLIST_VALUE}" {if trim($FIELD_MODEL->getEditViewDisplayValue()) eq trim($PICKLIST_NAME)} selected {/if}>{$PICKLIST_VALUE}</option>
		{/foreach}
	</select>
{/strip}
