{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-List-Field-Picklist -->
	<div class="input-group">
		<select name="filters[{$FIELD_MODEL->getName()}]" class="select2 form-control js-filter-field" multiple="multiple" title="{$FIELD_MODEL->getFieldLabel()}" data-allow-clear="true" data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}'>
			{foreach item=PICKLIST_LABEL key=PICKLIST_KEY from=$FIELD_MODEL->getPicklistValues()}
				<option value="{\App\Purifier::encodeHtml($PICKLIST_KEY)}">{$PICKLIST_LABEL}</option>
			{/foreach}
		</select>
	</div>
	<!-- /tpl-Base-List-Field-PickList -->
{/strip}
