{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Products-Tree-Tree js-products-container pl-2 pr-3 mt-3" data-search="{\App\Purifier::encodeHtml(\App\Json::encode($SEARCH))}" data-js="container">
		<div class="col-12 px-0 mb-1">
			<div class="d-flex justify-content-end">
				{include file=\App\Resources::templatePath("Pagination.tpl", $MODULE_NAME)}
			</div>
		</div>
		<div class="border-left border-bottom">
			<div class="col-12 m-0">
				<div class="row">
					{foreach item=RECORD key=CRM_ID from=$RECORDS}
						{include file=\App\Resources::templatePath("Tree/Product.tpl", $MODULE_NAME)}
					{/foreach}
				</div>
			</div>
		</div>
	</div>
{/strip}
