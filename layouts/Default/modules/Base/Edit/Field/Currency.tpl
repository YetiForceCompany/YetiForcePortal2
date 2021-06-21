{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Edit-Field-Currency -->
{function FUN_CURRENCY_SYMBOL CURRENCY_SYMBOL='' CLASS=''}
	<span class="input-group-append {$CLASS}">
		<span class="input-group-text" data-js="text">
			{$CURRENCY_SYMBOL}
		</span>
	</span>
{/function}
<div>
	{assign var=FIELD_INFO value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}
	{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
	{assign var=USER_MODEL value=\App\User::getUser()}
	{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
	{assign var=SYMBOL_PLACEMENT value=$USER_MODEL->getPreferences('currency_symbol_placement')}
	{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($RECORD)}
	{if $FIELD_MODEL->getUIType() eq '71'}
		<div class="input-group" data-uitype="71">
			{if $SYMBOL_PLACEMENT neq '1.0$'}
				{FUN_CURRENCY_SYMBOL CURRENCY_SYMBOL=$USER_MODEL->get('currency_symbol')}
			{/if}
			<input id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}" type="text" tabindex="{$FIELD_MODEL->getTabIndex()}" title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}"
					class="currencyField form-control {if $SYMBOL_PLACEMENT eq '1.0$'} textAlignRight {/if}" name="{$FIELD_NAME}" data-fieldinfo='{$FIELD_INFO}' value="{$FIELD_VALUE}" {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}'{/if}
					data-decimal-separator='{$USER_MODEL->getPreferences('currency_decimal_separator')}'
					data-group-separator='{$USER_MODEL->getPreferences('currency_grouping_separator')}'
					data-number-of-decimal-places='{$USER_MODEL->getPreferences('no_of_currency_decimals')}' {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{else} data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Base_Validator_Js.invokeValidation]]" {/if}/>
			{if $SYMBOL_PLACEMENT eq '1.0$'}
				{FUN_CURRENCY_SYMBOL CURRENCY_SYMBOL=$USER_MODEL->getPreferences('currency_symbol')}
			{/if}
		</div>
	{elseif ($FIELD_MODEL->getUIType() eq '72')}
		 <div class="input-group">
			{assign var=DISPLAY_FIELD_VALUE value=$FIELD_VALUE}
			{if $SYMBOL_PLACEMENT neq '1.0$'}
			{if !empty($RECORD_ID) && !empty($RECORD->get('currency_id')) }
					{assign var=CURRENCY value=\App\Fields\Currency::getById($RECORD->get('currency_id'))}
					{FUN_CURRENCY_SYMBOL CURRENCY_SYMBOL=$CURRENCY['currency_symbol']}
				{else}
					{FUN_CURRENCY_SYMBOL CURRENCY_SYMBOL=$USER_MODEL->getPreferences('currency_symbol')}
				{/if}
			{/if}
			<input name="{$FIELD_NAME}" value="{$DISPLAY_FIELD_VALUE}" type="text" tabindex="{$FIELD_MODEL->getTabIndex()}"
				   class="row-fluid currencyField form-control" data-fieldinfo='{$FIELD_INFO}'
				   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Base_Validator_Js.invokeValidation]]"
				   title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}"
				   {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}'{/if} data-decimal-separator='{$USER_MODEL->getPreferences('currency_decimal_separator')}'
				   data-group-separator='{$USER_MODEL->getPreferences('currency_grouping_separator')}'
				   {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if} />
			{if $SYMBOL_PLACEMENT eq '1.0$'}
				{if !empty($RECORD_ID) && !empty($RECORD->get('currency_id')) }
					{assign var=CURRENCY value=\App\Fields\Currency::getById($RECORD->get('currency_id'))}
					{FUN_CURRENCY_SYMBOL CURRENCY_SYMBOL=$CURRENCY['currency_symbol']}
				{else}
					{FUN_CURRENCY_SYMBOL CURRENCY_SYMBOL=$USER_MODEL->getPreferences('currency_symbol')}
				{/if}
			{/if}
		</div>
	{else}
		<div class="input-group">
			<div class="row">
				<span class="col-md-1 input-group-append">
					<span class="input-group-text row" data-js="text">
						{$USER_MODEL->getPreferences('currency_symbol')}
					</span>
				</span>
				{assign var=DISPLAY_FIELD_VALUE value=$FIELD_VALUE}
				<span class="col-md-7">
					<input name="{$FIELD_NAME}" value="{$DISPLAY_FIELD_VALUE}" type="text" tabindex="{$FIELD_MODEL->getTabIndex()}"
						   class="row-fluid currencyField form-control" data-fieldinfo='{$FIELD_INFO}'
						   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Base_Validator_Js.invokeValidation]]"
						   title="{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}"
						   {if !empty($SPECIAL_VALIDATOR)}data-validator='{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}'{/if} data-decimal-separator='{$USER_MODEL->getPreferences('currency_decimal_separator')}'
						   data-group-separator='{$USER_MODEL->getPreferences('currency_grouping_separator')}'
						   {if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if} />
				</span>
			</div>
		</div>
	 {/if}
</div>
<!-- /tpl-Base-Edit-Field-Currency -->
{/strip}
