{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Edit-Field-Country -->
{assign var=FIELD_INFO value=\App\Json::encode($FIELD_MODEL->getFieldInfo())}
{assign var=PICKLIST_VALUES value=$FIELD_MODEL->getPicklistValues()}
{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($FIELD_MODEL->get('fieldvalue'),$RECORD)}
{assign var=PLACE_HOLDER value=($FIELD_MODEL->isEmptyPicklistOptionAllowed() && !($FIELD_MODEL->isMandatory() eq true && $FIELD_VALUE neq ''))}
{assign var=IS_LAZY value=count($PICKLIST_VALUES) > \App\Config::$picklistLimit}
<div>
	<select name="{$FIELD_MODEL->getName()}" class="select2 form-control" tabindex="{$FIELD_MODEL->getTabIndex()}"
			{if $IS_LAZY} data-select-lazy="true"{/if}
			title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}"
			data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"
			{if $PLACE_HOLDER}data-select="allowClear" data-placeholder="{\App\Language::translate('LBL_SELECT_OPTION')}"{/if} data-fieldinfo='{$FIELD_INFO|escape}'
			{if !empty($SPECIAL_VALIDATOR)}data-validator="{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}"{/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}>
		{if $PLACE_HOLDER}
			<optgroup class="p-0">
				<option value="">{\App\Language::translate('LBL_SELECT_OPTION')}</option>
			</optgroup>
		{/if}
		{if $FIELD_VALUE && empty($PICKLIST_VALUES[$FIELD_VALUE])}
			{assign var=FIELD_VALUE value=\App\Purifier::encodeHtml($FIELD_VALUE)}
			<optgroup label="{\App\Language::translate('LBL_VALUE_NOT_FOUND')}">
				<option value="{$FIELD_VALUE}" title="{$FIELD_VALUE}" selected>{$FIELD_VALUE}</option>
			</optgroup>
		{/if}
		<optgroup label="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}">
			{foreach item=VALUE key=KEY from=$PICKLIST_VALUES}
				<option value="{\App\Purifier::encodeHtml($KEY)}"
					title="{\App\Purifier::encodeHtml($VALUE)}"
					{if trim($FIELD_VALUE) eq trim($KEY)} selected{/if}>
					{\App\Purifier::encodeHtml($VALUE)}
				</option>
			{/foreach}
		</optgroup>
	</select>
</div>
<!-- /tpl-Base-Edit-Field-Country -->
{/strip}
