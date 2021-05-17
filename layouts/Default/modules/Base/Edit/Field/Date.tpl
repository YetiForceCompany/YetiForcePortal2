{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}

{strip}
<!-- tpl-Base-Edit-Field-Date -->
{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
{assign var=DATE_FORMAT value=\App\User::getUser()->getPreferences('date_format')}
{assign var=PARAMS value=$FIELD_MODEL->getFieldParams()}
<div class="input-group date">
	{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
	<input name="{$FIELD_NAME}" class="{if !$FIELD_MODEL->isEditableReadOnly()}dateField datepicker{/if} form-control"
		   title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}" id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}" type="text"
		   {if $PARAMS && $PARAMS['onChangeCopyValue']}data-copy-to-field="{$PARAMS['onChangeCopyValue']}"{/if} data-date-format="{$DATE_FORMAT}"
		   value="{$FIELD_MODEL->getEditViewDisplayValue($FIELD_MODEL->get('fieldvalue'),$RECORD)}" tabindex="{$FIELD_MODEL->getTabIndex()}"
		   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"
		   {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}'{/if} data-fieldinfo='{$FIELD_INFO}'
		   {if !empty($MODE) && $MODE eq 'edit' && $FIELD_NAME eq 'due_date'} data-user-changed-time="true" {/if} {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if} autocomplete="off"/>
	<div class="input-group-append">
		<span class="input-group-text u-cursor-pointer js-date__btn" data-js="click">
			<span class="fas fa-calendar-alt"></span>
		</span>
	</div>
</div>
<!-- /tpl-Base-Edit-Field-Date -->
{/strip}
