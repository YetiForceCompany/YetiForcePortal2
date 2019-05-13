{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	{assign var=LINKS value=$RECORD->getRecordListViewActions()}
	{if count($LINKS) > 0}
		{assign var=ONLY_ONE value=count($LINKS) eq 1}
		<div class="actions p-1">
			<div class="{if !$ONLY_ONE}actionImages d-none{/if}">
				{foreach from=$LINKS item=LINK}
					{include file=\App\Resources::templatePath("ButtonLink.tpl",$MODULE_NAME) BUTTON_VIEW='listViewBasic'}
				{/foreach}
			</div>
			{if !$ONLY_ONE}
				<button type="button" class="btn btn-sm btn-outline-info toolsAction mb-0">
					<span class="fas fa-wrench"></span>
				</button>
			{/if}
		</div>
	{/if}
{/strip}
