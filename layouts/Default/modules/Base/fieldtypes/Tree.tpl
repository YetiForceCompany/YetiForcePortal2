{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Base-fieldtypes-Tree js-tree-content">
			{assign var=FIELD_NAME value=$FIELD_MODEL->getName()}
			<input type="hidden" class="js-tree-value" name="{$FIELD_NAME}" value="{$FIELD_MODEL->getEditViewDisplayValue()}" data-js="val"/>
			<div class="input-group">
				<input type="text"
					title="{$FIELD_MODEL->getDisplayValue()}"
					class="form-control js-tree-text pl-1" data-js="val"
					value="{$FIELD_MODEL->getDisplayValue()}" readonly="readonly"
					data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required{/if}]">
				<div class="input-group-append">
					<button class="btn btn-light js-tree-clear" type="button" data-js="click">
						<span id="{$MODULE_NAME}_editView_fieldName_{$FIELD_NAME}_clear" class="fas fa-times-circle"
							title="{\App\Language::translate('LBL_CLEAR', $MODULE_NAME)}"></span>
					</button>
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
						{assign var=FIELD_INFO value=$FIELD_MODEL->getFieldInfo()}
						<div class="js-tree-jstree" data-js="jstree">
							<input type="hidden" class="js-tree-data" value="{\App\Purifier::encodeHtml(App\Json::encode($FIELD_INFO['treeValues']))}" data-js="val">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger mr-2" data-dismiss="modal">{App\Language::translate('BTN_CANCEL')}</button>
						<button type="button" class="btn btn-success js-tree-modal-select">{App\Language::translate('PLL_SELECT_OPTION')}</button>
					</div>
					</div>
				</div>
			</div>
	</div>
{/strip}
