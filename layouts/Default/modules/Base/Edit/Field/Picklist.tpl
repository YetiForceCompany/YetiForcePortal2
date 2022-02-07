{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}

{strip}
	<!-- tpl-Base-Edit-Field-Picklist -->
	{assign var=FIELD_INFO value=\App\Json::encode($FIELD_MODEL->getFieldInfo())}
	{assign var=PICKLIST_VALUES value=$FIELD_MODEL->getPicklistValues($RECORD)}
	{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
	{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($RECORD)}
	{assign var=PLACE_HOLDER value=($FIELD_MODEL->isEmptyPicklistOptionAllowed() && !($FIELD_MODEL->isMandatory() eq true && $FIELD_VALUE neq ''))}
	{assign var=IS_LAZY value=count($PICKLIST_VALUES) > \App\Config::$picklistLimit}
	<div class="w-100">
		<select name="{$FIELD_MODEL->getName()}" class="select2 form-control" data-fieldinfo='{$FIELD_INFO|escape}' tabindex="{$FIELD_MODEL->getTabIndex()}"
			title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}"
			data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Base_Validator_Js.invokeValidation]]"
			{if $IS_LAZY} data-select-lazy="true" {/if}
			{if !empty($PLACE_HOLDER)}
				data-select="allowClear"
				data-placeholder="{\App\Language::translate('LBL_SELECT_OPTION')}"
			{/if}
			{if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}' {/if}
			data-selected-value="{\App\Purifier::encodeHtml($FIELD_VALUE)}" {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly" {/if}>
			{if !empty($PLACE_HOLDER)}
				<optgroup class="p-0">
					<option value="">{\App\Language::translate('LBL_SELECT_OPTION')}</option>
				</optgroup>
			{/if}
			{if !$IS_LAZY}
				{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$PICKLIST_VALUES}
					<option value="{\App\Purifier::encodeHtml($PICKLIST_NAME)}" title="{\App\Purifier::encodeHtml($PICKLIST_VALUE)}" {if trim($FIELD_VALUE) eq trim($PICKLIST_NAME)}selected{/if}>
						{\App\Purifier::encodeHtml($PICKLIST_VALUE)}
					</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<!-- /tpl-Base-Edit-Field-Picklist -->
{/strip}
