{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Products-Tree-Tree js-products-container" data-search="{\App\Purifier::encodeHtml(\App\Json::encode($SEARCH))}" data-js="container">
		<div class="row mb-4">
			<div class="row">
				{foreach item=RECORD key=CRM_ID from=$RECORDS}
					{include file=\App\Resources::templatePath("Tree/Product.tpl", $MODULE_NAME)}
				{/foreach}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="float-right">
					{include file=\App\Resources::templatePath("Pagination.tpl", $MODULE_NAME)}
				</div>
			</div>
		</div>
	</div>
{/strip}
