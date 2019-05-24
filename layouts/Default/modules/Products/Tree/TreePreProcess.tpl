{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <!-- tpl-Products-Tree-TreePreProcess -->
    {include file=\App\Resources::templatePath("Header.tpl", $MODULE_NAME)}
    <div>
        <input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage" value="{\App\Purifier::encodeHtml(\App\Json::encode(\App\Config::$listEntriesPerPage))}">
        <div class="widget_header row">
			<div class="col-sm-8">
				<div class="pull-left">
					{include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
				</div>
			</div>
		</div>
        <div class="row">
            {assign var="COL_WIDTH" value=12}
            {if !empty($LEFT_SIDE_TEMPLATE)}
                {assign var="COL_WIDTH" value=9}
                <div class="col-xl-3 col-md-12 pr-xl-2 pr-md-3 product-category">
                    {include file=\App\Resources::templatePath($LEFT_SIDE_TEMPLATE, $MODULE_NAME)}
                </div>
            {/if}
	        <div class="col-xl-{$COL_WIDTH} col-md-12 c-main-container js-main-container" data-js="container">
    <!-- /tpl-Products-Tree-TreePreProcess -->
{/strip}
