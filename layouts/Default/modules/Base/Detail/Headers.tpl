{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Detail-HeaderProgress -->
{if isset($FIELDS_HEADER['value']) || isset($FIELDS_HEADER['highlights'])}
<div class="row">
	<div class="col-sm-8">
		{if isset($FIELDS_HEADER['value'])}
			{foreach from=$FIELDS_HEADER['value'] key=NAME item=FIELD_MODEL}
				{if !$RECORD->isEmpty($NAME)}
					{assign var=VALUE value=$FIELD_MODEL->getDisplayValue()}
					<div class="js-popover-tooltip--ellipsis-icon d-flex flex-nowrap align-items-center" data-content="{\App\Purifier::encodeHtml($VALUE)}" data-toggle="popover" data-js="popover | mouseenter">
						<span class="mr-1 text-muted u-white-space-nowrap">
							{\App\Language::translate($FIELD_MODEL->getFieldLabel(), $MODULE_NAME)}:
						</span>
						<span class="js-popover-text" data-js="clone">{$VALUE}</span>
						<span class="fas fa-info-circle fa-sm js-popover-icon d-none" data-js="class: d-none"></span>
					</div>
				{/if}
			{/foreach}
		{/if}
	</div>
	<div class="col-sm-4">
		{if isset($FIELDS_HEADER['highlights'])}
			{foreach from=$FIELDS_HEADER['highlights'] key=NAME item=FIELD_MODEL}
				{if !$RECORD->isEmpty($NAME)}
					{assign var=HEADER_VALUE value=$FIELD_MODEL->getHeaderValue()}
					{assign var=VALUE value=$FIELD_MODEL->getDisplayValue()}
					<div class="badge {if isset($HEADER_VALUE['class'])}{$HEADER_VALUE['class']}{else}badge-info{/if} d-flex flex-nowrap align-items-center justify-content-center mt-1 js-popover-tooltip--ellipsis" data-content="{\App\Purifier::encodeHtml(\App\Language::translate($FIELD_MODEL->get('label'), $MODULE_NAME))}: <string>{\App\Purifier::encodeHtml($VALUE)}</string>" data-toggle="popover" data-js="popover | mouseenter">
						<div class="c-popover-text">
							<span class="mr-1">
								{\App\Language::translate($FIELD_MODEL->get('label'), $MODULE_NAME)}:
							</span>
							{$VALUE}
						</div>
						<span class="fas fa-info-circle fa-sm js-popover-icon d-none" data-js="class: d-none"></span>
					</div>
				{/if}
			{/foreach}
		{/if}
	</div>
</div>
{/if}
{if isset($FIELDS_HEADER['progress'])}
<div class="row">
	<div class="col-sm-12">
		{foreach from=$FIELDS_HEADER['progress'] key=NAME item=FIELD_MODEL}
			<div class="c-progress px-3 w-100">
				<ul class="c-progress__container js-header-progress-bar list-inline my-0 py-1 js-scrollbar c-scrollbar-x--small" data-picklist-name="{$NAME}" data-js="container">
					{assign var=ARROW_CLASS value="before"}
					{assign var=ICON_CLASS value="fas fa-check"}
					{foreach from=$FIELD_MODEL->get('picklistvalues') key=PICKLIST_VALUE item=PICKLIST_LABEL name=picklistValues}
						{assign var=IS_ACTIVE value=$PICKLIST_VALUE eq $RECORD->get($NAME)}
						<li class="c-progress__item list-inline-item mx-0 {if $smarty.foreach.picklistValues.first}first{/if} {if $IS_ACTIVE}active{assign var=ARROW_CLASS value="after"}{else}{$ARROW_CLASS}{/if}">
							<div class="c-progress__icon__container">
								<span class="
							 {if $IS_ACTIVE}
								far fa-dot-circle
							{else}
								{$ICON_CLASS}
							{/if}
							{if $IS_ACTIVE}
								{assign var=ICON_CLASS value="c-progress__icon__dot"}
							{/if}
								{' '}c-progress__icon"></span>
							</div>
							<div class="c-progress__link">
								{if !empty($VALUE_DATA['description'])}
									<span class="c-progress__icon-info js-popover-tooltip" data-js="popover" data-trigger="hover focus" data-content="{\App\Purifier::encodeHtml($VALUE_DATA['description'])}">
										<span class="fas fa-info-circle"></span>
									</span>
								{/if}
								<span class=" js-popover-tooltip--ellipsis" data-toggle="popover" data-content="{$PICKLIST_LABEL}" data-js="popover">
									<span class="c-progress__text">{$PICKLIST_LABEL}</span>
								</span>
							</div>
						</li>
					{/foreach}
				</ul>
			</div>
		{/foreach}
	</div>
</div>
{/if}
<!-- /tpl-Base-Detail-HeaderProgress -->
{/strip}
