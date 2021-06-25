{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Widget-CommentsContent -->
	{foreach from=$WIDGET->getEntries() item=COMMENT name=commentLoop}
		{include file=\App\Resources::templatePath('Detail/CommentsPost.tpl', $WIDGET->getRelatedModuleName()) MODULE_NAME=$WIDGET->getRelatedModuleName() SUB_COMMENT=false SOURCE_MODULE=$MODULE_NAME}
	{/foreach}
	<div>
		{if $WIDGET->isMorePages() || $PAGE > 1}
		<div class="row no-margin p-1">
			{assign var="NEXT_PAGE" value=$PAGE + 1}
			{assign var="PREVIOUS_PAGE" value=$PAGE - 1}
			<div class="float-right col-12">
				<button type="button" class="btn btn-sm btn-secondary js-change-page" {if !$PREVIOUS_PAGE} disabled {/if} data-page="{$PREVIOUS_PAGE}">
					{\App\Language::translate('LBL_PREVIOUS', $MODULE_NAME)}
				</button>
				<button type="button" class="btn btn-sm btn-secondary ml-1 js-change-page" {if !$WIDGET->isMorePages()} disabled {/if} data-page="{$NEXT_PAGE}">
					{\App\Language::translate('LBL_NEXT', $MODULE_NAME)}
				</button>
			</div>
		</div>
		{/if}
	</div>
<!-- /tpl-Base-Widget-CommentsContent -->
{/strip}
