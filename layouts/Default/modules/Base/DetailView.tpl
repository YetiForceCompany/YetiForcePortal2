{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="contentsDiv" id="detailView">
		<div class="widget_header row">
			<div class="col-sm-12">
				<div class="float-left">
					{include file=\App\Functions::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
				<div class="contentHeader">
					<span class="float-right">
						<a href="{$RECORD->getEditViewUrl()}" class="btn btn-sm btn-primary"
						   title="{\App\Functions::translate('BTN_EDIT')}"><span
									class="fas fa-pencil-alt"></span> &nbsp; <strong>{\App\Functions::translate('BTN_EDIT', $MODULE_NAME)}</strong> </a>
					</span>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		{foreach item=BLOCK from=$BLOCKS}
			{if isset($FIELDS[$BLOCK['id']])}
				{assign var=COUNTER value=0}
				{assign var=COUNT value=0}
				<div class="card col-xs-12 paddingLRZero blockContainer">
					<div class="card-header">{$BLOCK['name']}</div>
					<div class="col-md-12 paddingLRZero panel-body blockContent">
						<div class="col-xs-12 paddingLRZero fieldRow">
							{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
							{if $COUNTER eq 2}
						</div>
						<div class="col-xs-12 paddingLRZero fieldRow">
							{assign var=COUNTER value=0}
							{/if}
							<div class="col-xs-12 col-md-6 paddingLRZero tableCell borderTop">
								<div class="col-md-3 fieldLabel paddingLeft5px form-control-static">
									<label class="control-label">
										{if $FIELD->isMandatory() eq true}<span class="redColor">*</span>{/if}
										{$FIELD->get('label')}
									</label>
								</div>
								<div class="fieldValue col-md-9 form-control-static">
									{$FIELD->getDisplayValue()}
								</div>
								{assign var=COUNTER value=$COUNTER+1}
							</div>
							{assign var=COUNT value=$COUNT+1}
							{/foreach}
							{if $COUNT % 2 == 1}
								<div class="col-xs-12 col-md-6 paddingLRZero tableCell borderTop">
									<div class="col-md-3 fieldLabel paddingLeft5px"></div>
									<div class="fieldValue col-md-9 form-control-static"></div>
								</div>
							{/if}
						</div>
					</div>
				</div>
			{/if}
		{/foreach}
		<div id="CoreLog" class="panel panel-primary col-xs-12 paddingLRZero blockContainer">
			<div class="card-header">{\App\Functions::translate('LBL_CORE_LOG')}</div>
			<div class="col-md-12 paddingLRZero panel-body">
				<ol id="CoreLogList">

				</ol>
			</div>
		</div>
	</div>
{/strip}

