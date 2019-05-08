{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	{assign var=FIELD_NAME value=$FIELD_MODEL->get('name')}
	{assign var="REFERENCE_LIST" value=$FIELD_MODEL->getReferenceList()}
	{assign var="REFERENCE_LIST_COUNT" value=count($REFERENCE_LIST)}
	{assign var="FIELD_INFO" value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
	{if {$REFERENCE_LIST_COUNT} eq 1}
		{assign var="REFERENCED_MODULE_NAME" value=reset($REFERENCE_LIST)}
		<input name="popupReferenceModule" type="hidden" data-multi-reference="0" title="{$REFERENCED_MODULE_NAME}"
			   value="{$REFERENCED_MODULE_NAME}"/>
	{/if}
	{assign var="DISPLAYID" value=$RECORD->getRawValue($FIELD_NAME)}
	{if $REFERENCE_LIST_COUNT gt 1}
		{assign var="REFERENCED_MODULE_NAME" value=$RECORD->getRawValue($FIELD_NAME|cat:'_module')}
		{if in_array($REFERENCED_MODULE_NAME, $REFERENCE_LIST)}
			<input name="popupReferenceModule" type="hidden" data-multi-reference="1"
				   value="{$REFERENCED_MODULE_NAME}"/>
		{else}
			{assign var="REFERENCED_MODULE_NAME" value=$REFERENCE_LIST[0]}
			<input name="popupReferenceModule" type="hidden" data-multi-reference="1" value="{$REFERENCE_LIST[0]}"/>
		{/if}
	{/if}
	<input name="{$FIELD_NAME}" type="hidden" value="{$RECORD->getRawValue($FIELD_NAME)}"
		   title="{$RECORD->getDisplayValue($FIELD_NAME)}" class="sourceField"
		   data-fieldtype="{$FIELD_MODEL->get('type')}" data-field-label="{$FIELD_MODEL->get('label')}"
		   data-displayvalue="{$RECORD->getDisplayValue($FIELD_NAME)}"
		   data-fieldinfo='{$FIELD_INFO}' {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}>
	<div class="input-group referenceGroup">
		{if $REFERENCE_LIST_COUNT > 1}
			<div class="input-group-prepend referenceModulesListGroup">
				<select id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}_dropDown"
						class="referenceModulesList select2"
						title="{\App\Language::translate('LBL_RELATED_MODULE_TYPE')}" required="required">
					{foreach key=index item=REFERENCE from=$REFERENCE_LIST}
						{assign var="REFERENCED_MODULE_TRANSLATE" value=\App\Language::translateModule($REFERENCE)}
						<option value="{$REFERENCE}"
								title="{$REFERENCED_MODULE_TRANSLATE}" {if $REFERENCE eq $REFERENCED_MODULE_NAME} selected {/if}>{$REFERENCED_MODULE_TRANSLATE}</option>
					{/foreach}
				</select>
			</div>
		{/if}
		<input id="{$FIELD_NAME}_display" name="{$FIELD_NAME}_display" type="text"
			   title="{$FIELD_MODEL->getDisplayValue()}"
			   class="marginLeftZero form-control autoComplete" {if !empty($DISPLAYID)}readonly="true"{/if}
			   value="{$FIELD_MODEL->getDisplayValue()}"
			   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required{/if}]"
			   data-fieldinfo='{$FIELD_INFO}' {if $FIELD_MODEL->isEditable()}placeholder="{\App\Language::translate('LBL_TYPE_SEARCH',$MODULE_NAME)}"{/if} {if $REFERENCED_MODULE_NAME == false}disabled{/if}
				{if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Json::encode($SPECIAL_VALIDATOR)}'{/if} {if $FIELD_MODEL->isEditableReadOnly() || !$FIELD_MODEL->get('fieldvalue')}readonly="readonly"{/if}>
		<div class="input-group-append">
			<button class="btn btn-secondary clearReferenceSelection" type="button"
					{if $REFERENCED_MODULE_NAME == false || $FIELD_MODEL->isEditableReadOnly()}disabled{/if}>
				<span id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}_clear" class="fas fa-times-circle"
					  title="{\App\Language::translate('LBL_CLEAR', $MODULE_NAME)}"></span>
			</button>
			<button class="btn btn-secondary relatedPopup" type="button"
					{if $REFERENCED_MODULE_NAME == false || $FIELD_MODEL->isEditableReadOnly()}disabled{/if}>
				<span id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}_select" class="fas fa-search"
					  title="{\App\Language::translate('LBL_SELECT', $MODULE_NAME)}"></span>
			</button>
		</div>
	</div>
{/strip}
