{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-List-Field-Country -->
{assign var=PLACE_HOLDER value=($FIELD_MODEL->isEmptyPicklistOptionAllowed() && !($FIELD_MODEL->isMandatory() eq true))}
<select name="filters[{$FIELD_MODEL->getName()}]" class="select2 form-control js-filter-field" title="{$FIELD_MODEL->getFieldLabel()}" data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}' {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}>
	{if $PLACE_HOLDER}
		<optgroup class="p-0">
			<option value="">{\App\Language::translate('LBL_SELECT_OPTION')}</option>
		</optgroup>
	{/if}
	<optgroup label="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}">
		{foreach item=VALUE key=KEY from=$FIELD_MODEL->getPicklistValues()}
			<option value="{\App\Purifier::encodeHtml($KEY)}" title="{\App\Purifier::encodeHtml($VALUE)}">
				{\App\Purifier::encodeHtml($VALUE)}
			</option>
		{/foreach}
	</optgroup>
</select>
<!-- /tpl-Base-List-Field-Country -->
{/strip}
