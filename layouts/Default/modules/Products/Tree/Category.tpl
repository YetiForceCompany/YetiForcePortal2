{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="mb-3">
        {include file=\App\Resources::templatePath("Tree/Search.tpl", $MODULE_NAME)}
    </div>
    <div class="tpl-Products-Tree-Category border border-secondary rounded p-2">
        {include file=\App\Resources::templatePath("Tree.tpl", $MODULE_NAME) ON_SELECT_NODE='window.Products_Tree_Js.onSelectNode'}
    </div>
{/strip}
