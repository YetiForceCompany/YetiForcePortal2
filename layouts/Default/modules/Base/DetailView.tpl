{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	<div class="contentsDiv" id="detailView">
		<div class="widget_header row">
			<div class="col-sm-12">
				<div class="pull-left">
					{include file=FN::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
				<div class="contentHeader">
						<span class="pull-right">
							<a href="{$RECORD->getEditViewUrl()}" class="btn btn-sm btn-primary" title="{FN::translate('BTN_EDIT')}"><span class="glyphicon glyphicon-pencil"></span></a>
						</span>
						<div class="clearfix"></div>
					</div>
			</div>
		</div>
		{foreach item=BLOCK from=$BLOCKS}
			{if isset($FIELDS[$BLOCK['id']])}
				{assign var=COUNTER value=0}
				{assign var=COUNT value=0}
				<div class="panel panel-default col-xs-12 paddingLRZero blockContainer">
					<div class="panel-heading">{$BLOCK['name']}</div>
					<div class="col-md-12 paddingLRZero panel-body blockContent">
						<div class="col-xs-12 paddingLRZero fieldRow">
							{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
								{if $COUNTER eq 2}
								</div><div class="col-xs-12 paddingLRZero fieldRow">
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
										{$RECORD->get($FIELD->getName())}
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
	</div>
{/strip}

