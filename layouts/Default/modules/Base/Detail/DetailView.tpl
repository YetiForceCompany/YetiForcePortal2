{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Base-Detail-DetailView contentsDiv" id="detailView">
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
		<div class="row">
			<div class="{if !empty($INVENTORY_FIELDS)}col-4{else}col-12{/if}">
				{foreach item=BLOCK from=$BLOCKS}
					{if isset($FIELDS[$BLOCK['id']])}
						{assign var=COUNTER value=0}
						{assign var=COUNT value=0}
						<div class="card c-card col-sm-12 px-0 blockContainer my-3">
							<div class="card-header c-card__header collapsed" data-toggle="collapse" data-target="#block_{$BLOCK['id']}" aria-expanded="true">
								<span class="fas fa-angle-right mr-2 c-card__icon-right"></span>
								<span class="fas fa-angle-down mr-2 c-card__icon-down"></span>
								{$BLOCK['name']}
							</div>
							<div class="col-md-12 px-0 card-body py-0 blockContent collapse {if $BLOCK['display_status'] === 1}show{/if}" id="block_{$BLOCK['id']}">
								<div class="col-sm-12 px-0 row m-0">
									{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
									{if $COUNTER eq 2}
								</div>
								<div class="col-sm-12 px-0 row m-0">
									{assign var=COUNTER value=0}
									{/if}
									<div class="col-sm-12 {if empty($INVENTORY_FIELDS)}col-md-6{/if} px-0 borderTop row m-0">
										<div class="col-xl-3  col-lg-4 col-md-12 fieldLabel pl-2 form-control-plaintext text-xl-right text-md-left">
											<label class="col-form-label font-weight-bold">
												{if $FIELD->isMandatory() eq true}<span class="redColor">*</span>{/if}
												{$FIELD->get('label')}
											</label>
										</div>
										<div class="fieldValue col-xl-8 col-lg-9 col-md-12 form-control-plaintext d-flex align-items-center">
											{$FIELD->getDisplayValue()}
										</div>
										{assign var=COUNTER value=$COUNTER+1}
									</div>
									{assign var=COUNT value=$COUNT+1}
									{/foreach}
									{if $COUNT % 2 == 1}
										<div class="col-sm-12 col-md-12 px-0 borderTop row m-0">
											<div class="col-xl-3 col-lg-4 col-md-12 fieldLabel pl-2 text-xl-right text-md-left"></div>
											<div class="fieldValue col-xl-8 col-lg-9 col-md-12 form-control-plaintext"></div>
										</div>
									{/if}
								</div>
							</div>
						</div>
					{/if}
				{/foreach}
			</div>
			<div class="col-8">
				{include file=\App\Resources::templatePath("Detail\Inventory.tpl", $MODULE_NAME)}
			</div>
		</div>
		{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
	</div>
{/strip}
