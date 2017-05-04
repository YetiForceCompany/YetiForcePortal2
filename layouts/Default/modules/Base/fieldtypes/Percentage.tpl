{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	{assign var="FIELD_INFO" value=\YF\Core\Functions::toSafeHTML(\YF\Core\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
	{assign var="FIELD_NAME" value=$FIELD_MODEL->get('name')}
	<div class="input-group">
		<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}" type="number" title="{$FIELD_MODEL->get('label')}" class="form-control" min="0" max="100"
			   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true}required{/if}]" name="{$FIELD_NAME}" value="{\YF\Core\Functions::toSafeHTML($FIELD_MODEL->get('fieldvalue'))}"
			   data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator={\YF\Core\Json::encode($SPECIAL_VALIDATOR)}{/if}
			   {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}/>
		<span class="input-group-addon">%</span>
	</div>
{/strip}



