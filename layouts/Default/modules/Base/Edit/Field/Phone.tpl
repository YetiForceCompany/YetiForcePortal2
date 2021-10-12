{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Edit-Field-Phone -->
	{assign var=TABINDEX value=$FIELD_MODEL->getTabIndex()}
	{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
	{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
	{assign var=PARAMS value=$FIELD_MODEL->getFieldParams()}
	{assign var=NUMBER value=$FIELD_MODEL->get('fieldvalue')}
	<div>
		{assign var=FIELD_NAME_EXTRA value=$FIELD_NAME|cat:'_extra'}
		{if isset($FIELDS[$FIELD_NAME_EXTRA])}
			{assign var=FIELD_MODEL_EXTRA value=$FIELDS[$FIELD_NAME_EXTRA]}
		{/if}
		{assign var=ACTIVE_EXTRA_FIELD value=!empty($VIEW) && ($VIEW eq 'EditView') && isset($FIELD_MODEL_EXTRA)}
		<div class="form-row">
			<div class="{if $ACTIVE_EXTRA_FIELD}col-md-8{else}col-md-12{/if}">
				<div class="input-group phoneGroup mb-1">
					<input name="{$FIELD_NAME}" class="form-control" value="{$NUMBER}" id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}"
						title="" placeholder="" type="text" tabindex="{$TABINDEX}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Base_Validator_Js.invokeValidation]]" data-advanced-verification="1" data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}' {/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly" {/if} {if isset($PARAMS['mask'])}data-inputmask="'mask': {\App\Purifier::encodeHtml(\App\Json::encode($PARAMS['mask']))}" {/if} />
				</div>
			</div>
			{if $ACTIVE_EXTRA_FIELD}
				{assign var=PARAMS_EXTRA value=$FIELD_MODEL->getFieldParams()}
				<div class="col-md-4">
					{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL_EXTRA->getFieldInfo()))}
					{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL_EXTRA->getValidator()}
					<input name="{$FIELD_NAME_EXTRA}" class="form-control" title="{\App\Language::translate($FIELD_MODEL_EXTRA->getFieldLabel(), $MODULE_NAME)}" tabindex="{$TABINDEX}"
						placeholder="{\App\Language::translate($FIELD_MODEL_EXTRA->getFieldLabel(), $MODULE_NAME)}" value="{if $RECORD}{$FIELD_MODEL_EXTRA->getEditViewDisplayValue($RECORD)}{/if}" id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME_EXTRA}" type="text" data-validation-engine="validate[{if $FIELD_MODEL_EXTRA->isMandatory() eq true} required,{/if}{if $FIELD_MODEL->get('maximumlength')}maxSize[{$FIELD_MODEL->get('maximumlength')}],{/if}funcCall[Base_Validator_Js.invokeValidation]]" data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}' {/if} {if $FIELD_MODEL_EXTRA->isEditableReadOnly()}readonly="readonly" {/if} {if isset($PARAMS_EXTRA['mask'])}data-inputmask="'mask': {\App\Purifier::encodeHtml(\App\Json::encode($PARAMS_EXTRA['mask']))}" {/if} />
				</div>
			{/if}
		</div>
	</div>
	<!-- /tpl-Base-Edit-Field-Phone -->
{/strip}
