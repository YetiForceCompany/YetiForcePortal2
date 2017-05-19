{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	<select class="chzn-select form-control" title="{$FIELD_MODEL->getLabel()}" name="{$FIELD_MODEL->getName()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory()} required{/if}]" data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}" data-selected-value="{$FIELD_MODEL->getEditViewDisplayValue()}" {if $FIELD_MODEL->isEditableReadOnly()}readonly {/if}>
		{foreach item=PICKLIST_VALUES key=PICKLIST_GROUP from=$FIELD_MODEL->getPicklistValues()}
			<optgroup label="{$PICKLIST_GROUP}">
				{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$PICKLIST_VALUES}
					<option value="{\YF\Core\Functions::toSafeHTML($PICKLIST_NAME)}" title="{$PICKLIST_VALUE}" {if trim($FIELD_MODEL->getEditViewDisplayValue()) eq trim($PICKLIST_NAME)} selected {/if}>{$PICKLIST_VALUE}</option>
				{/foreach}
			</optgroup>
		{/foreach}
	</select>
{/strip}
