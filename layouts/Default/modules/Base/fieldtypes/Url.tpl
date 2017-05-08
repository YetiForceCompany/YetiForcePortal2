{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	{assign var="FIELD_INFO" value=\YF\Core\Functions::toSafeHTML(\YF\Core\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
	{assign var=FIELD_NAME value=$FIELD_MODEL->get('name')}
	<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->get('name')}" type="text" title="{$FIELD_MODEL->get('label')}" class="form-control" name="{$FIELD_NAME}" data-validation-engine="validate[custom[url]{if $FIELD_MODEL->isMandatory() eq true},required{/if}]"
		   value="{$RECORD->getRawValue($FIELD_NAME)}" data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator={\YF\Core\Json::encode($SPECIAL_VALIDATOR)}{/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if} />
{/strip}
