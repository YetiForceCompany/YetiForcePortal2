{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Edit-Field-Reference -->
{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
{assign var=REFERENCE_LIST value=$FIELD_MODEL->getReferenceList()}
{assign var=REFERENCE_LIST_COUNT value=count($REFERENCE_LIST)}
{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
{assign var=TABINDEX value=$FIELD_MODEL->getTabIndex()}
{assign var=IS_EDITABLE_READ_ONLY value=$FIELD_MODEL->isEditableReadOnly()}
{assign var=PARAMS value=$FIELD_MODEL->getFieldParams()}
<div class="uitype_{$MODULE_NAME}_{$FIELD_NAME}">
	{if isset($PARAMS['searchParams'])}
		<input name="searchParams" type="hidden" value="{\App\Purifier::encodeHtml($PARAMS['searchParams'])}"/>
	{/if}
	{if isset($PARAMS['modalParams'])}
		<input name="modalParams" type="hidden" value="{\App\Purifier::encodeHtml($PARAMS['modalParams'])}"/>
	{/if}
	{if {$REFERENCE_LIST_COUNT} eq 1}
		<input name="popupReferenceModule" type="hidden" data-multi-reference="0" title="{reset($REFERENCE_LIST)}" value="{reset($REFERENCE_LIST)}"/>
	{/if}
	{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($FIELD_MODEL->get('fieldvalue'),$RECORD)}
	{assign var=VALUE value=$FIELD_MODEL->getEditViewDisplayValue($FIELD_MODEL->get('fieldvalue'),$RECORD)}
	{if $REFERENCE_LIST_COUNT gt 1}
		{assign var=REFERENCED_MODULE_NAME value=$RECORD->getRawValue($FIELD_NAME|cat:'_module')}
		{if in_array($REFERENCED_MODULE_NAME, $REFERENCE_LIST)}
			<input name="popupReferenceModule" type="hidden" data-multi-reference="1" value="{$REFERENCED_MODULE_NAME}"/>
		{else}
			{assign var=REFERENCED_MODULE_NAME value=$REFERENCE_LIST[0]}
			<input name="popupReferenceModule" type="hidden" data-multi-reference="1" value="{$REFERENCE_LIST[0]}"/>
		{/if}
	{/if}
	<input name="{$FIELD_NAME}" type="hidden" value="{$VALUE}" title="{$FIELD_VALUE}" class="sourceField" data-type="entity" data-fieldtype="{$FIELD_MODEL->get('type')}" data-displayvalue="{$FIELD_VALUE}" data-fieldinfo='{$FIELD_INFO}' {if $IS_EDITABLE_READ_ONLY}readonly="readonly"{/if} />
	<div class="input-group referenceGroup">
		{if $REFERENCE_LIST_COUNT > 1}
			<div class="input-group-prepend referenceModulesListGroup">
				<select class="select2 referenceModulesList" tabindex="{$TABINDEX}" title="{\App\Language::translate('LBL_RELATED_MODULE_TYPE')}" required="required" {if $IS_EDITABLE_READ_ONLY}disabled{/if}>
					{foreach key=index item=REFERENCE from=$REFERENCE_LIST}
						<option value="{$REFERENCE}" title="{\App\Language::translate($REFERENCE, $REFERENCE)}" {if $REFERENCE eq $REFERENCED_MODULE_NAME} selected {/if}>{\App\Language::translate($REFERENCE, $REFERENCE)}</option>
					{/foreach}
				</select>
			</div>
		{/if}
		<input id="{$FIELD_NAME}_display" name="{$FIELD_NAME}_display" type="text"  title="{$FIELD_VALUE}" class="marginLeftZero form-control autoComplete"
			   tabindex="{$TABINDEX}" {if !empty($VALUE)}readonly="true"{/if} value="{$FIELD_VALUE}"
			   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Base_Validator_Js.invokeValidation]]"
			   data-fieldinfo='{$FIELD_INFO}' {if $FIELD_MODEL->get('displaytype') != 10}placeholder="{\App\Language::translate('LBL_TYPE_SEARCH',$MODULE_NAME)}"{/if} {if $IS_EDITABLE_READ_ONLY}disabled{/if}
			{if !empty($SPECIAL_VALIDATOR)}data-validator="{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}"{/if} {if $IS_EDITABLE_READ_ONLY}readonly="readonly"{/if}/>
		<div class="input-group-append u-cursor-pointer">
			<button class="btn btn-light clearReferenceSelection" type="button" tabindex="{$TABINDEX}" {if $IS_EDITABLE_READ_ONLY}disabled{/if}>
				<span id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}_clear" class="fas fa-times-circle" title="{\App\Language::translate('LBL_CLEAR', $MODULE_NAME)}"></span>
			</button>
			<button class="btn btn-light relatedPopup" type="button" tabindex="{$TABINDEX}" {if $IS_EDITABLE_READ_ONLY}disabled{/if}>
				<span id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}_select" class="fas fa-search" title="{\App\Language::translate('LBL_SELECT', $MODULE_NAME)}"></span>
			</button>
		</div>
	</div>
</div>
<!-- /tpl-Base-Edit-Field-Reference -->
{/strip}
