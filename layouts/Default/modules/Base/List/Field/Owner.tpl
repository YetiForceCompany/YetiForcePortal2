{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-List-Field-Owner -->
	<select name="filters[{$FIELD_MODEL->getName()}]" class="select2 form-control js-filter-field" title="{$FIELD_MODEL->getFieldLabel()}" multiple="multiple" data-allow-clear="true" data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}'>
		{foreach item=PICKLIST_VALUES key=PICKLIST_GROUP from=$FIELD_MODEL->getPicklistValues()}
			<optgroup label="{$PICKLIST_GROUP}">
				{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$PICKLIST_VALUES}
					<option value="{\App\Purifier::encodeHtml($PICKLIST_NAME)}" title="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
				{/foreach}
			</optgroup>
		{/foreach}
	</select>
	<!-- /tpl-Base-List-Field-Owner -->
{/strip}
