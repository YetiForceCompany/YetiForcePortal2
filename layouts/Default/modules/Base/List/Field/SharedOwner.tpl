{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-List-Field-SharedOwner -->
<select name="filters[{$FIELD_MODEL->getName()}]" class="select2 form-control js-filter-field" title="{$FIELD_MODEL->getFieldLabel()}" data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}' multiple="multiple" {if $FIELD_MODEL->isEditableReadOnly()}readonly{/if}>
	{foreach item=PICKLIST_VALUES key=PICKLIST_GROUP from=$FIELD_MODEL->getPicklistValues()}
		<optgroup label="{$PICKLIST_GROUP}">
			{foreach item=PICKLIST_NAME key=PICKLIST_VALUE from=$PICKLIST_VALUES}
				<option value="{\App\Purifier::encodeHtml($PICKLIST_VALUE)}" title="{$PICKLIST_NAME}">
					{$PICKLIST_NAME}
				</option>
			{/foreach}
		</optgroup>
	{/foreach}
</select>
<!-- /tpl-Base-Edit-List-SharedOwner -->
{/strip}
