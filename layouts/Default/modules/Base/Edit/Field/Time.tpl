{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Edit-Field-Time -->
{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($FIELD_MODEL->get('fieldvalue'),$RECORD)}
{assign var=TIME_FORMAT value=\App\User::getUser()->getPreferences('hour_format')}
{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
<div class="input-group time">
	<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}" tabindex="{$FIELD_MODEL->getTabIndex()}" type="text" data-format="{$TIME_FORMAT}" class="clockPicker timefieldinput form-control" value="{$FIELD_VALUE}" title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}" name="{$FIELD_NAME}"
		    data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"   {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}'{/if} data-fieldinfo='{$FIELD_INFO}' {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if} autocomplete="off"/>
	<div class="input-group-append">
		<span class="input-group-text u-cursor-pointer js-clock__btn" data-js="click">
			<span class="far fa-clock"></span>
		</span>
	</div>
</div>
<!-- /tpl-Base-Edit-Field-Time -->
{/strip}
