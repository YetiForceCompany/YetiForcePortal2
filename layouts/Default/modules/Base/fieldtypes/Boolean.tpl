{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
<div class="checkbox">
	<label class="d-flex m-0">
		{if !$FIELD_MODEL->isEditableReadOnly()}
			<input type="hidden" name="{$FIELD_NAME}" value="0"/>
		{/if}
		<input name="{$FIELD_NAME}" {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{' '}
			   disabled="disabled" {/if} tabindex="{$FIELD_MODEL->getTabIndex()}"
			   title="{\App\Language::translate($FIELD_NAME, $MODULE_NAME)}"{' '}
			   id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}" type="checkbox"{' '}
			   data-validation-engine="validate[funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"{' '}
			   {if $FIELD_MODEL->getEditViewDisplayValue($FIELD_MODEL->get('fieldvalue'),$RECORD)}checked="checked" {/if}
			   value="1" data-fieldinfo='{$FIELD_INFO}'{' '}
			   {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}'{/if}/>
	</label>
</div>
{/strip}
