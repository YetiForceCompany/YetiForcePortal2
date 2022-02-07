{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Products-Tree-Category o-category">
		{include file=\App\Resources::templatePath("Tree/Search.tpl", $MODULE_NAME)}
		<div class="product-border p-2">
			{include file=\App\Resources::templatePath("Tree.tpl", $MODULE_NAME)}
		</div>
		{foreach from=$FILTER_FIELDS item=FIELD_MODEL}
			<div class="mt-1 js-advance-filter product-border p-2" data-js="container">
				<b>{$FIELD_MODEL->getLabel()}:</b>
				{include file=\App\Resources::templatePath($FIELD_MODEL->getTemplatePath('Edit'), $MODULE_NAME)}
			</div>
		{/foreach}
	</div>
{/strip}
