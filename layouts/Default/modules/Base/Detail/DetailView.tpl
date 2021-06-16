{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Detail-DetailView -->
	<div class="widget_header row">
		<div class="col-sm-12">
			<div class="float-left">
				{include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
			</div>
			<div class="contentHeader">
				<span class="float-right">
					{foreach from=$DETAIL_LINKS item=DETAIL_LINK}
						{\App\Layout\Action::getButton($DETAIL_LINK)}
					{/foreach}
				</span>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	{if !empty($FIELDS_HEADER)}
		{include file=\App\Resources::templatePath("Detail/Headers.tpl", $MODULE_NAME)}
	{/if}
	<div class="row">
		<div class="{if !empty($INVENTORY_FIELDS) && $SHOW_INVENTORY_RIGHT_COLUMN}col-4{else}col-12{/if}">
			{assign var=ITERATION value=0}
			{foreach item=BLOCK from=$BLOCKS}
				{if isset($FIELDS[$BLOCK['id']])}
					{if $BLOCK['display_status'] eq 0}
						{assign var=IS_HIDDEN value=true}
					{else}
						{assign var=IS_HIDDEN value=false}
					{/if}
					{assign var=COUNTER value=0}
					{assign var=COUNT value=0}
					<div class="c-card card col-sm-12 px-0 blockContainer my-3">
						<div class="blockHeader c-card__header card-header p-2 {if $IS_HIDDEN}collapsed{/if}" data-toggle="collapse" data-target="#block_{$BLOCK['id']}" aria-expanded="true">
							<span class="fas fa-angle-right mr-2 c-card__icon-right {if !$IS_HIDDEN}d-none{/if}"></span>
							<span class="fas fa-angle-down mr-2 c-card__icon-down {if $IS_HIDDEN}d-none{/if}"></span>
							<h5>{if !empty($BLOCK['icon'])}<span class="{$BLOCK['icon']} mr-2"></span>{/if}{$BLOCK['name']}</h5>
						</div>
						<div class="c-card__body card-body col-md-12 {if $IS_HIDDEN}d-none{else}show{/if}" id="block_{$BLOCK['id']}">
							<div class="c-card__row form-row border-bottom ">
								{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
								{if $COUNTER eq 2}
							</div>
							<div class="c-card__row form-row border-bottom">
								{assign var=COUNTER value=0}
								{/if}
								<div class="col-sm border-left {if $FIELD->getUIType() eq '300'} col-lg-12 border-bottom {/if}" data-name="{$FIELD->getName()}" data-type="{$FIELD->get('type')}"  data-uitype="{$FIELD->getUIType()}">
									<div class="form-row align-items-start">
									<div class="fieldLabel c-card__label text-lg-right text-md-left py-2 px-1 {if empty($FIELD->getDisplayValue())}border-right{/if} {if $FIELD->getUIType() eq '300'} col-lg-3 {else} col-lg-6 {/if}">
										<label class="col-form-label font-weight-bold p-0">
											{if $FIELD->isMandatory() eq true}<span class="redColor">*</span>{/if}
											{$FIELD->get('label')}
										</label>
									</div>
									<div class="fieldValue justify-content-between c-card__value {if !empty($FIELD->getDisplayValue())}border-left{/if}  {if $FIELD->getUIType() eq '300'}col-lg-9{else}col-lg-6{/if} py-2 px-1">
										{$FIELD->getDisplayValue()}
									</div>
									{assign var=COUNTER value=$COUNTER+1}
								</div>
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
					{assign var=ITERATION value=$ITERATION+1}
				{/if}
			{/foreach}
		</div>
		<div class="{if $SHOW_INVENTORY_RIGHT_COLUMN} col-8 {else} col-12 {/if}">
			{include file=\App\Resources::templatePath("Detail/Inventory.tpl", $MODULE_NAME)}
		</div>
	</div>
	{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}

<!-- /tpl-Base-Detail-DetailView -->
{/strip}
