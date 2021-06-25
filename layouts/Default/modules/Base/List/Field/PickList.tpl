{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-List-Field-Picklist -->
	{assign var=FIELD_INFO value=\App\Json::encode($FIELD_MODEL->getFieldInfo())}
	{assign var=PICKLIST_VALUES value=$FIELD_MODEL->getPicklistValues()}
	<div class="input-group">
		<select class="select2 form-control js-filter-field" name="filters[{$FIELD_MODEL->getName()}]" multiple="multiple" title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $FIELD_MODEL->getName())}"
			data-fieldinfo='{$FIELD_INFO|escape}'>
			{foreach item=PICKLIST_LABEL key=PICKLIST_KEY from=$PICKLIST_VALUES}
				<option value="{\App\Purifier::encodeHtml($PICKLIST_KEY)}">{$PICKLIST_LABEL}</option>
			{/foreach}
		</select>
	</div>
	<!-- /tpl-Base-List-Field-PickList -->
{/strip}
