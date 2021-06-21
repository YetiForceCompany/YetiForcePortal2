{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Edit-Field-Tree -->
{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
{assign var=FIELD_INFO value=$FIELD_MODEL->getFieldInfo()}
{assign var=FIELD_INFO_DATA value=\App\Purifier::encodeHtml(\App\Json::encode($FIELD_INFO))}
{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($RECORD)}
{assign var=SPECIAL_VALIDATOR value=$FIELD_MODEL->getValidator()}
{assign var=DISPLAY_VALUE value=$RECORD->getDisplayValue($FIELD_NAME)}
<div class="js-tree-content">
	<input name="{$FIELD_NAME}" type="hidden" value="{$FIELD_VALUE}" class="js-tree-value"
		data-displayvalue='{$DISPLAY_VALUE}' data-fieldinfo='{$FIELD_INFO_DATA}'
		data-multiple="{if $FIELD_MODEL->get('type') !== 'tree'}1{else}0{/if}"
		data-treetemplate="{$FIELD_MODEL->getFieldParams()}" data-modulename="{$MODULE_NAME}" data-js="val">
	<div class="input-group">
		<div class="input-group-prepend u-cursor-pointer">
			<button class="btn btn-light js-tree-clear" type="button" data-js="click">
				<span id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}_clear" class="fas fa-times-circle"
					title="{\App\Language::translate('LBL_CLEAR', $MODULE_NAME)}"></span>
			</button>
		</div>
		{assign var=DISPLAY_ID value=$FIELD_MODEL->get('fieldvalue')}
		<input id="{$FIELD_NAME}_display" name="{$FIELD_NAME}_display" type="text"
			class="ml-0 js-tree-text form-control" {if !empty($DISPLAY_ID)}readonly="true" {/if}
			value="{$DISPLAY_VALUE}" tabindex="{$FIELD_MODEL->getTabIndex()}"
			data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Base_Validator_Js.invokeValidation]]"
			data-fieldinfo='{$FIELD_INFO_DATA}' {if $FIELD_MODEL->get('displaytype') != 10}placeholder="{\App\Language::translate('LBL_TYPE_SEARCH',$MODULE_NAME)}"{/if}
			{if !empty($SPECIAL_VALIDATOR)}data-validator="{\App\Purifier::encodeHtml(\App\Json::encode($SPECIAL_VALIDATOR))}"{/if}
			{if $FIELD_MODEL->isEditableReadOnly()}readonly="readonly"{/if}/>
		<div class="input-group-append">
			<button class="btn btn-light js-tree-select" type="button" data-js="click">
				<span id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}_select" class="fas fa-search"
					title="{\App\Language::translate('LBL_SELECT', $MODULE_NAME)}"></span>
			</button>
		</div>
	</div>
	<div class="js-tree-modal-window modal" tabindex="-1" role="dialog" data-js="modal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{$FIELD_MODEL->getLabel()}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="js-tree-jstree" data-js="jstree">
						<input type="hidden" class="js-tree-data"
							value="{App\Purifier::encodeHtml(App\Json::encode($FIELD_INFO['treeValues']))}"
							data-js="val">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success js-tree-modal-select" data-js="click">
						<span class="fas fa-check mr-1"></span>
						{App\Language::translate('PLL_SELECT_OPTION')}
					</button>
					<button type="button" class="btn btn-danger mr-2" data-dismiss="modal">
						<span class="fas fa-times mr-2"></span>
						{App\Language::translate('BTN_CANCEL')}
					</button>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- /tpl-Base-Edit-Field-Tree -->
{/strip}
