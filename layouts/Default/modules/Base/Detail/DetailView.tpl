{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="contentsDiv" id="detailView">
		<div class="widget_header row">
			<div class="col-sm-12">
				<div class="float-left">
					{include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
				</div>
				<div class="contentHeader">
					<span class="float-right">
						{foreach from=$LINKS item=LINK}
							{include file=\App\Resources::templatePath("ButtonLink.tpl", $MODULE_NAME) BUTTON_VIEW='listViewBasic'}
						{/foreach}
					</span>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		{foreach item=BLOCK from=$BLOCKS}
			{if isset($FIELDS[$BLOCK['id']])}
				{assign var=COUNTER value=0}
				{assign var=COUNT value=0}
				<div class="card c-card col-sm-12 px-0 blockContainer my-3">
					<div class="card-header c-card__header collapsed" id="{$BLOCK['id']}" data-toggle="collapse" data-target="#{strtolower($BLOCK['name'])}" aria-expanded="true">
						<span class="fas fa-angle-right mr-2 c-card__icon-right"></span>
						<span class="fas fa-angle-down mr-2 c-card__icon-down"></span>
						{$BLOCK['name']}
					</div>
					<div class="col-md-12 px-0 card-body py-0 blockContent collapse" id="{strtolower($BLOCK['name'])}" aria-labelledby="{$BLOCK['id']}">
						<div class="col-sm-12 px-0 d-flex">
							{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
							{if $COUNTER eq 2}
						</div>
						<div class="col-sm-12 px-0 d-flex">
							{assign var=COUNTER value=0}
							{/if}
							<div class="col-sm-12 col-md-6 px-0 borderTop d-flex">
								<div class="col-md-3 fieldLabel pl-2 form-control-plaintext">
									<label class="col-form-label font-weight-bold">
										{if $FIELD->isMandatory() eq true}<span class="redColor">*</span>{/if}
										{$FIELD->get('label')}
									</label>
								</div>
								<div class="fieldValue col-md-9 form-control-plaintext d-flex align-items-center">
									{$FIELD->getDisplayValue()}
								</div>
								{assign var=COUNTER value=$COUNTER+1}
							</div>
							{assign var=COUNT value=$COUNT+1}
							{/foreach}
							{if $COUNT % 2 == 1}
								<div class="col-sm-12 col-md-6 px-0 borderTop">
									<div class="col-md-3 fieldLabel pl-2"></div>
									<div class="fieldValue col-md-9 form-control-plaintext"></div>
								</div>
							{/if}
						</div>
					</div>
				</div>
			{/if}
		{/foreach}
		{include file=\App\Resources::templatePath("Detail\Inventory.tpl", $MODULE_NAME)}
		{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
	</div>
{/strip}
