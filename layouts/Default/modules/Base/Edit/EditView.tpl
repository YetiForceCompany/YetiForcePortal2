{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-EditView -->
	<div class="contentsDiv">
		<form class="form-horizontal recordEditView" id="EditView" name="EditView" method="post" action="index.php"
			  enctype="multipart/form-data">
			<div class="widget_header u-remove-main-padding">
				<div class="d-flex justify-content-between u-add-main-padding">
					<div class="">
						{include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
					</div>
					<div class="contentHeader">
						<button class="btn btn-success btn-sm mr-1" type="submit">
							<span class="fas fa-check mr-2"></span>
							{\App\Language::translate('BTN_SAVE', $MODULE_NAME)}
						</button>
						<button class="btn btn-warning btn-sm js-history-back" type="reset">
							<span class="fas fa-times mr-2"></span>
							{\App\Language::translate('BTN_CANCEL', $MODULE_NAME)}
						</button>
					</div>
				</div>
			</div>
			<input type="hidden" value="DetailView" name="view">
			<input type="hidden" name="module" value="{$MODULE_NAME}">
			<input type="hidden" name="action" value="Save">
			<input type="hidden" name="record" id="recordId" value="{$RECORD->getId()}">
			{assign var=ITERATION value=0}
			{foreach item=BLOCK from=$BLOCKS}
				{if isset($FIELDS[$BLOCK['id']])}
					{if $BLOCK['display_status'] eq 0}
						{assign var=IS_HIDDEN value=true}
					{else}
						{assign var=IS_HIDDEN value=false}
					{/if}
					<div class="c-card card my-3 blockContainer">
						<div class="c-card__header card-header p-2 {if $IS_HIDDEN}collapsed{/if}" data-toggle="collapse" data-target="#block_{$BLOCK['id']}" aria-expanded="true">
							<span class="fas fa-angle-right mr-2 c-card__icon-right {if !$IS_HIDDEN}d-none{/if}"></span>
							<span class="fas fa-angle-down mr-2 c-card__icon-down {if $IS_HIDDEN}d-none{/if}"></span>
							<h5>{if !empty($BLOCK['icon'])}<span class="{$BLOCK['icon']} mr-2"></span>{/if}{$BLOCK['name']}</h5>
						</div>
						<div class="c-card__body card-body blockContent row m-0 {if $IS_HIDDEN}d-none{else}show{/if}" id="block_{$BLOCK['id']}">
							{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
								<div class="editFields {if $FIELD->getUIType() eq '300'}col-lg-12{else}col-sm-12 col-md-6{/if} row m-0 d-flex align-items-center {if !$FIELD->isEditable()}d-none{/if}">
									<div class="{if $FIELD->getUIType() eq '300'}col-lg-12 text-left{else}col-xl-3 col-lg-4 col-md-12{/if} fieldLabel paddingLeft5px font-weight-bold">
										<label class="muted mb-0 pt-0">
											{if $FIELD->isMandatory()}<span class="redColor">*</span>{/if}
											{$FIELD->getLabel()}
										</label>
									</div>
									<div class="fieldValue {if $FIELD->getUIType() eq '300'}col-lg-12{else}col-xl-9 col-lg-8 col-md-12{/if}  px-1">
										{assign var=FIELD value=$FIELD->set('fieldvalue', $RECORD->getRawValue($FIELD->getName()))}
										{include file=\App\Resources::templatePath($FIELD->getTemplatePath('Edit'), $MODULE_NAME) FIELD_MODEL=$FIELD}
									</div>
								</div>
							{/foreach}
						</div>
					</div>
					{assign var=ITERATION value=$ITERATION+1}
				{/if}
			{/foreach}
		</form>
	</div>
	{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
	<!-- /tpl-Base-EditView -->
{/strip}
