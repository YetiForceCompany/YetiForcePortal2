{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="checkbox">
		<label>
			<input type="hidden" name="{$FIELD_MODEL->getName()}" value="0"/>
			<input title="{$FIELD_MODEL->getLabel()}" id="{$MODULE_NAME}_editView_fieldName_{$FIELD_MODEL->getName()}"
				   type="checkbox" name="{$FIELD_MODEL->getName()}" value="1"
				   data-validation-engine="validate[{if $FIELD_MODEL->isMandatory()}required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"
				   {if $FIELD_MODEL->isEditableReadOnly()}readonly {/if}
				   data-fieldinfo="{$FIELD_MODEL->getFieldInfo(true)}" {if $FIELD_MODEL->isChecked()}checked {/if} />
		</label>
	</div>
{/strip}
