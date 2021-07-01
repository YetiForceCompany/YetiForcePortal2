{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Edit-Field-Owner -->
<select class="select2 form-control" title="{$FIELD_MODEL->getLabel()}" name="{$FIELD_MODEL->getName()}"
		data-validation-engine="validate[{if $FIELD_MODEL->isMandatory()}required{/if},funcCall[Base_Validator_Js.invokeValidation]]"
		data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}"
		data-selected-value="{$FIELD_MODEL->getEditViewDisplayValue($RECORD)}"
		{if $FIELD_MODEL->isEditableReadOnly()}readonly {/if}>
	{foreach item=PICKLIST_VALUES key=PICKLIST_GROUP from=$FIELD_MODEL->getPicklistValues()}
		<optgroup label="{$PICKLIST_GROUP}">
			{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$PICKLIST_VALUES}
				<option value="{\App\Purifier::encodeHtml($PICKLIST_NAME)}"
						title="{$PICKLIST_VALUE}" {if trim($FIELD_MODEL->getEditViewDisplayValue($RECORD)) eq trim($PICKLIST_NAME)} selected {/if}>{$PICKLIST_VALUE}</option>
			{/foreach}
		</optgroup>
	{/foreach}
</select>
<!-- /tpl-Base-Edit-Field-Owner -->
{/strip}
