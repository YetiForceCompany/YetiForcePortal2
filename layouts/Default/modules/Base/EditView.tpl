{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="contentsDiv">
		<form class="form-horizontal recordEditView" id="EditView" name="EditView" method="post" action="index.php"
			  enctype="multipart/form-data">
			<div class="widget_header u-remove-main-padding">
				<div class="d-flex justify-content-between u-add-main-padding">
					<div class="">
						{include file=\App\Functions::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
					</div>
					<div class="contentHeader">
						<button class="btn btn-success mr-1" type="submit">
							<span class="fas fa-check mr-1"></span>
							{\App\Functions::translate('BTN_SAVE', $MODULE_NAME)}
						</button>
						<button class="btn btn-warning" type="reset"
								onclick="javascript:window.history.back();">
							<span class="fas fa-times mr-1"></span>
							{\App\Functions::translate('BTN_CANCEL', $MODULE_NAME)}
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
					<div class="card col-sm-12 px-0 blockContainer">
						<div class="card-header">{$BLOCK['name']}</div>
						<div class="col-md-12 px-0 card-body blockContent">
							{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
								<div class="editFields col-sm-12 col-md-6 px-0">
									<div class="col-md-3 fieldLabel paddingLeft5px">
										<label class="muted">
											{if $FIELD->isMandatory()}<span class="redColor">*</span>{/if}
											{$FIELD->getLabel()}
										</label>
									</div>
									<div class="fieldValue col-md-9">
										{assign var=FIELD value=$FIELD->set('fieldvalue',$RECORD->getRawValue($FIELD->getName()))}
										{include file=\App\Functions::templatePath($FIELD->getTemplate(),$MODULE_NAME) FIELD_MODEL=$FIELD}
									</div>
								</div>
							{/foreach}
						</div>
					</div>
				{/if}
			{/foreach}
		</form>
		<div id="CoreLog" class="panel panel-primary col-sm-12 px-0 blockContainer">
			<div class="card-header">{\App\Functions::translate('LBL_CORE_LOG')}</div>
			<div class="col-md-12 px-0 card-body">
				<ol id="CoreLogList">

				</ol>
			</div>
		</div>
	</div>
{/strip}

