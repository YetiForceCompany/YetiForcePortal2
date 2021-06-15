{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Detail-HeaderProgress -->
<div class="row">
	<div class="col-sm-12">
	{foreach from=$PROGRESS_FIELDS key=NAME item=FIELD_MODEL}
		<div class="c-progress px-3 w-100">
			<ul class="c-progress__container js-header-progress-bar list-inline my-0 py-1 js-scrollbar c-scrollbar-x--small" data-picklist-name="{$NAME}" data-js="container">
				{assign var=ARROW_CLASS value="before"}
				{foreach from=$FIELD_MODEL->get('picklistvalues') key=PICKLIST_VALUE item=PICKLIST_LABEL name=picklistValues}
					{assign var=IS_ACTIVE value=$PICKLIST_VALUE eq $RECORD->get($NAME)}
					<li class="c-progress__item list-inline-item mx-0 {if $smarty.foreach.picklistValues.first}first{/if} {if $IS_ACTIVE}active{assign var=ARROW_CLASS value="after"}{else}{$ARROW_CLASS}{/if}">
						{$PICKLIST_LABEL}
					</li>
				{/foreach}
			</ul>
		</div>
	{/foreach}
	</div>
</div>
<!-- /tpl-Base-Detail-HeaderProgress -->
{/strip}
