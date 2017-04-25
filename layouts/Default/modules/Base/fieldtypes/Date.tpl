{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	{assign var="FIELD_INFO" value=FN::toSafeHTML(\Core\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
	{assign var="FIELD_NAME" value=$FIELD_MODEL->get('name')}
	<div class="input-group dateField">
		<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}" type="text" title="{$FIELD_MODEL->get('label')}" class="form-control dateFieldInput" 
			   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true}required{/if}]" name="{$FIELD_NAME}" {if FN::toSafeHTML($FIELD_MODEL->get('fieldvalue'))}value="{FN::toSafeHTML($FIELD_MODEL->get('fieldvalue'))}"{/if}
			   data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator={\Core\Json::encode($SPECIAL_VALIDATOR)}{/if} 
			   {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}/>
		<span class="input-group-addon dateFieldButton"><span class="glyphicon glyphicon-calendar"></span></span>
	</div>
{/strip}

