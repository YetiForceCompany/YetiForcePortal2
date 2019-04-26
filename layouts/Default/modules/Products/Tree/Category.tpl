{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-Tree-Category o-category">
        {include file=\App\Resources::templatePath("Tree/Search.tpl", $MODULE_NAME)}
        <div class="product-border p-2">
            {include file=\App\Resources::templatePath("Tree.tpl", $MODULE_NAME)}
        </div>
    </div>
{/strip}
