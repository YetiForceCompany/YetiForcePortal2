{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	{assign var="FIELD_INFO" value=\YF\Core\Json::encode($FIELD_MODEL->getFieldInfo())}
	{assign var=PICKLIST_VALUES_GROUP value=$FIELD_MODEL->getPicklistValues()}
	{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
	<select class="chzn-select form-control" title="{$FIELD_MODEL->get('label')}" name="{$FIELD_MODEL->getName()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required{/if}]" data-fieldinfo='{$FIELD_INFO|escape}' {if !empty($SPECIAL_VALIDATOR)}data-validator='{\YF\Core\Json::encode($SPECIAL_VALIDATOR)}'{/if} data-selected-value='{$FIELD_MODEL->get('fieldvalue')}' {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}>
		{foreach item=PICKLIST_VALUES key=PICKLIST_GROUP from=$PICKLIST_VALUES_GROUP}
			<optgroup label="{$PICKLIST_GROUP}">
				{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$PICKLIST_VALUES}
					<option value="{\YF\Core\Functions::toSafeHTML($PICKLIST_NAME)}" title="{$PICKLIST_VALUE}" {if trim($FIELD_MODEL->get('fieldvalue')) eq trim($PICKLIST_NAME)} selected {/if}>{$PICKLIST_VALUE}</option>
				{/foreach}
			</optgroup>
		{/foreach}
	</select>
{/strip}
