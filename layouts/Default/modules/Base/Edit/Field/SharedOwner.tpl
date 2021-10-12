{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Edit-Field-SharedOwner -->
	<select class="select2 form-control" title="{$FIELD_MODEL->getFieldLabel()}" name="{$FIELD_MODEL->getName()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory()}required{/if},funcCall[Base_Validator_Js.invokeValidation]]" data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}' multiple="multiple" {if $FIELD_MODEL->isEditableReadOnly()}readonly{/if}>
		{foreach item=PICKLIST_VALUES key=PICKLIST_GROUP from=$FIELD_MODEL->getPicklistValues()}
			<optgroup label="{$PICKLIST_GROUP}">
				{foreach item=PICKLIST_NAME key=PICKLIST_VALUE from=$PICKLIST_VALUES}
					<option value="{\App\Purifier::encodeHtml($PICKLIST_VALUE)}" title="{$PICKLIST_NAME}" {if in_array(\App\Purifier::encodeHtml($PICKLIST_VALUE), $FIELD_MODEL->getFieldValuesList($RECORD))}selected{/if}>
						{$PICKLIST_NAME}
					</option>
				{/foreach}
			</optgroup>
		{/foreach}
	</select>
	<!-- /tpl-Base-Edit-Field-SharedOwner -->
{/strip}
