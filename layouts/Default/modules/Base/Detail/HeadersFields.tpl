{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Detail-HeaderProgress -->
{if isset($FIELDS_HEADER['value']) || isset($FIELDS_HEADER['highlights'])}
<div class="row">
	<div class="col-sm-8">
		{if isset($FIELDS_HEADER['value'])}
			{foreach from=$FIELDS_HEADER['value'] key=NAME item=FIELD_HEADER}
				{assign var=FIELD_MODEL value=$FIELDS[$NAME]}
				{assign var=VALUE value=$RECORD->getDisplayValue($FIELD_MODEL->getName())}
				<div class="js-popover-tooltip--ellipsis-icon d-flex flex-nowrap align-items-center" data-content="{\App\Purifier::encodeHtml($VALUE)}" data-toggle="popover" data-js="popover | mouseenter">
					<span class="mr-1 text-muted u-white-space-nowrap">
						{$FIELD_HEADER['label']}:
					</span>
					<span class="js-popover-text" data-js="clone">{$VALUE}</span>
					<span class="fas fa-info-circle fa-sm js-popover-icon d-none" data-js="class: d-none"></span>
				</div>
			{/foreach}
		{/if}
	</div>
	<div class="col-sm-4">
		{if isset($FIELDS_HEADER['highlights'])}
			{foreach from=$FIELDS_HEADER['highlights'] key=NAME item=FIELD_HEADER}
				{assign var=FIELD_MODEL value=$FIELDS[$NAME]}
				{assign var=VALUE value=$RECORD->getDisplayValue($FIELD_MODEL->getName())}
				<div class="badge {if isset($FIELD_HEADER['class'])}{$FIELD_HEADER['class']}{else}badge-info{/if} d-flex flex-nowrap align-items-center justify-content-center mt-1 js-popover-tooltip--ellipsis" data-content="{\App\Purifier::encodeHtml(\App\Language::translate($FIELD_MODEL->get('label'), $MODULE_NAME))}: <string>{\App\Purifier::encodeHtml($VALUE)}</string>" data-toggle="popover" data-js="popover | mouseenter">
					<div class="c-popover-text">
						<span class="mr-1">
							{\App\Language::translate($FIELD_MODEL->get('label'), $MODULE_NAME)}:
						</span>
						{$VALUE}
					</div>
					<span class="fas fa-info-circle fa-sm js-popover-icon d-none" data-js="class: d-none"></span>
				</div>
			{/foreach}
		{/if}
	</div>
</div>
{/if}
{if isset($FIELDS_HEADER['progress'])}
<div class="row">
	<div class="col-sm-12">
		{foreach from=$FIELDS_HEADER['progress'] key=NAME item=FIELD_HEADER}
			<div class="c-progress w-100">
				<ul class="c-progress__container js-header-progress-bar list-inline my-0 py-1 js-scrollbar c-scrollbar-x--small" data-picklist-name="{$NAME}" data-js="container">
					{assign var=ARROW_CLASS value="before"}
					{assign var=ICON_CLASS value="fas fa-check"}
					{foreach from=$FIELD_HEADER['values'] key=FIELD_HEADER_KEY item=FIELD_HEADER_VALUE name=fieldHeaderValues}
						<li class="c-progress__item list-inline-item mx-0 {if $smarty.foreach.fieldHeaderValues.first}first{/if} {if $FIELD_HEADER_VALUE['isActive']}active{assign var=ARROW_CLASS value="after"}{else}{$ARROW_CLASS}{/if} {if $FIELD_HEADER_VALUE['isEditable']}u-cursor-pointer2{/if}" data-value="{$FIELD_HEADER_KEY}">
							<div class="c-progress__icon__container">
								<span class="
							 {if $FIELD_HEADER_VALUE['isLocked']}
								fas fa-lock
							{elseif $FIELD_HEADER_VALUE['isActive']}
								far fa-dot-circle
							{else}
								{$ICON_CLASS}
							{/if}
							{if $FIELD_HEADER_VALUE['isActive']}
								{assign var=ICON_CLASS value="c-progress__icon__dot"}
							{/if}
								{' '}c-progress__icon"></span>
							</div>
							<div class="c-progress__link">
								{if !empty($FIELD_HEADER_VALUE['description'])}
									<span class="c-progress__icon-info js-popover-tooltip" data-js="popover" data-trigger="hover focus" data-content="{\App\Purifier::encodeHtml($FIELD_HEADER_VALUE['description'])}">
										<span class="fas fa-info-circle"></span>
									</span>
								{/if}
								<span class=" js-popover-tooltip--ellipsis" data-toggle="popover" data-content="{$FIELD_HEADER_VALUE['label']}" data-js="popover">
									<span class="c-progress__text">{$FIELD_HEADER_VALUE['label']}</span>
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
