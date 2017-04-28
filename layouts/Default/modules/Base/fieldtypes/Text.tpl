{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	{assign var="FIELD_INFO" value=FN::toSafeHTML(\YF\Core\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
	{assign var="FIELD_NAME" value=$FIELD_MODEL->get('name')}
	{assign var=UNIQUE_ID value=10|mt_rand:20}
	{*	{$FIELD_MODEL->get('label')}*}
    <textarea id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}" class="form-control" title="{$FIELD_MODEL->get('label')} " name="{$FIELD_NAME}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true}required{/if}]" data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator={\YF\Core\Json::encode($SPECIAL_VALIDATOR)}{/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}>
		{$FIELD_MODEL->get('fieldvalue')}</textarea>
	{/strip}
