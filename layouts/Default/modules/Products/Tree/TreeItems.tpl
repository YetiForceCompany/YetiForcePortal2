{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Products-Tree-TreeItems contentsDiv js-products-container" data-search="{\App\Purifier::encodeHtml(\App\Json::encode($SEARCH))}" data-js="container">
		<input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage" value="{\App\Purifier::encodeHtml(\App\Json::encode(\App\Config::$listEntriesPerPage))}">
		<div class="widget_header row">
			<div class="col-sm-8">
				<div class="pull-left">
					{include file=\App\Resources::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
			</div>
			<div class="col-sm-4 listViewAction">
				<div class="float-right">

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="float-right">
					{include file=\App\Resources::templatePath("Pagination.tpl", $MODULE_NAME)}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				{include file=\App\Resources::templatePath("Tree/Category.tpl", $MODULE_NAME)}
			</div>
			<div class="col-9">
				<div class="row">
					{foreach item=RECORD key=CRM_ID from=$RECORDS}
						{include file=\App\Resources::templatePath("Tree/Product.tpl", $MODULE_NAME)}
					{/foreach}
				</div>
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
	{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
{/strip}
