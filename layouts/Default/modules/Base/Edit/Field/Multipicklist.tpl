{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
<!-- tpl-Base-Edit-Field-Multipicklist -->
{strip}
{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var=PICKLIST_VALUES value=$FIELD_MODEL->getPicklistValues()}
{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
{assign var=FIELD_VALUE value=$FIELD_MODEL->getFieldValuesList()}
{assign var=NOT_DISPLAY_LIST_VALUES value=$FIELD_MODEL->getNotDisplayValuesList()}
<div class="w-100">
	<input type="hidden" name="{$FIELD_MODEL->getName()}" value="" />
	<select id="{$MODULE_NAME}_{$VIEW}_fieldName_{$FIELD_MODEL->getName()}" tabindex="{$FIELD_MODEL->getTabIndex()}" title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}" multiple class="select2 form-control {if !empty($NOT_DISPLAY_LIST_VALUES)} hideSelected{/if}" name="{$FIELD_MODEL->getName()}[]" data-fieldinfo='{$FIELD_INFO}' {if $FIELD_MODEL->isMandatory() eq true} data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}'{/if} {/if} {if $FIELD_MODEL->isEditableReadOnly()} readonly="readonly" {/if}>
		{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$PICKLIST_VALUES}
			<option value="{\App\Purifier::encodeHtml($PICKLIST_NAME)}" {if in_array(\App\Purifier::encodeHtml($PICKLIST_NAME), $FIELD_VALUE)} selected {/if} {if $NOT_DISPLAY_LIST_VALUES && array_key_exists($PICKLIST_NAME, $NOT_DISPLAY_LIST_VALUES)} class="d-none" {/if}>{$PICKLIST_VALUE} </option>
		{/foreach}
		{foreach from=$NOT_DISPLAY_LIST_VALUES key=PICKLIST_NAME item=ITERATION}
			<option value="{\App\Purifier::encodeHtml($PICKLIST_NAME)}" {if in_array(\App\Purifier::encodeHtml($PICKLIST_NAME), $FIELD_VALUE)} selected {/if} class="d-none">{$PICKLIST_NAME}</option>
		{/foreach}
	</select>
</div>
<!-- /tpl-Base-Edit-Field-Multipicklist -->
{/strip}
