{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	{assign var="FIELD_INFO" value=FN::toSafeHTML(\Core\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
	{assign var="FIELD_NAME" value=$FIELD_MODEL->get('name')}
	<div class="checkbox">
		<label>
			<input type="hidden" name="{$FIELD_NAME}" value=0 />
			<input {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if} title="{$FIELD_MODEL->get('label')}" id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}" type="checkbox" name="{$FIELD_NAME}" data-validation-engine="validate[funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"
														  {if $FIELD_MODEL->get('fieldvalue') eq true} checked
														  {/if} data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator={\Core\Json::encode($SPECIAL_VALIDATOR)}{/if} />
		</label>
	</div>
{/strip}
