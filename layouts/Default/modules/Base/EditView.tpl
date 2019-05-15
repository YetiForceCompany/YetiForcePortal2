{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="contentsDiv">
		<form class="form-horizontal recordEditView" id="EditView" name="EditView" method="post" action="index.php"
			  enctype="multipart/form-data">
			<div class="widget_header u-remove-main-padding">
				<div class="d-flex justify-content-between u-add-main-padding">
					<div class="">
						{include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
					</div>
					<div class="contentHeader">
						<button class="btn btn-outline-success btn-sm mr-1" type="submit">
							<span class="fas fa-check mr-1"></span>
							{\App\Language::translate('BTN_SAVE', $MODULE_NAME)}
						</button>
						<button class="btn btn-outline-warning btn-sm" type="reset"
								onclick="javascript:window.history.back();">
							<span class="fas fa-times mr-1"></span>
							{\App\Language::translate('BTN_CANCEL', $MODULE_NAME)}
						</button>
					</div>
				</div>
			</div>
			<input type="hidden" value="DetailView" name="view">
			<input type="hidden" name="module" value="{$MODULE_NAME}">
			<input type="hidden" name="action" value="Save">
			<input type="hidden" name="record" id="recordId" value="{$RECORD->getId()}">
			{foreach item=BLOCK from=$BLOCKS}
				{if isset($FIELDS[$BLOCK['id']])}
					<div class="c-card card card my-3 blockContainer">
						<div class="card-header c-card__header collapsed" id="{$BLOCK['id']}" data-toggle="collapse" data-target="#{strtolower($BLOCK['name'])}" aria-expanded="true">
							<span class="fas fa-angle-right mr-2 c-card__icon-right"></span>
							<span class="fas fa-angle-down mr-2 c-card__icon-down"></span>
							{$BLOCK['name']}
						</div>
						<div class="card-body blockContent row collapse hideBlock" id="{strtolower($BLOCK['name'])}" aria-labelledby="{$BLOCK['id']}">
							{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
								<div class="editFields col-sm-12 col-md-6 row">
									<div class="col-md-3 fieldLabel paddingLeft5px font-weight-bold d-flex align-items-center justify-content-end">
										<label class="muted mb-0 pt-0">
											{if $FIELD->isMandatory()}<span class="redColor">*</span>{/if}
											{$FIELD->getLabel()}
										</label>
									</div>
									<div class="fieldValue col-md-9">
										{assign var=FIELD value=$FIELD->set('fieldvalue',$RECORD->getRawValue($FIELD->getName()))}
										{include file=\App\Resources::templatePath($FIELD->getTemplate(), $MODULE_NAME) FIELD_MODEL=$FIELD}
									</div>
								</div>
							{/foreach}
						</div>
					</div>
				{/if}
			{/foreach}
		</form>
	</div>
	{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
{/strip}
