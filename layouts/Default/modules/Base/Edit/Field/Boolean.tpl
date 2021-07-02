{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Edit-Field-Boolean -->
{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
<div class="checkbox">
	<label class="d-flex m-0">
		{if !$FIELD_MODEL->isEditableReadOnly()}
			<input type="hidden" name="{$FIELD_NAME}" value="0"/>
		{/if}
		<input name="{$FIELD_NAME}" type="checkbox" value="1" {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly" disabled="disabled"{/if} title="{\App\Language::translate($FIELD_NAME, $MODULE_NAME)}" data-validation-engine="validate[funcCall[Base_Validator_Js.invokeValidation]]" data-fieldinfo='{$FIELD_INFO}'{' '} tabindex="{$FIELD_MODEL->getTabIndex()}"
		{if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}'{/if}  {if $FIELD_MODEL->getEditViewDisplayValue($RECORD)}checked="checked"{/if}/>
	</label>
</div>
<!-- /tpl-Base-Edit-Field-Boolean -->
{/strip}
