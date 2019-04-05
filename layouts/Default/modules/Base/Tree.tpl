{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <!-- tpl-Base-Tree -->
    {if !isset($ON_SELECT_NODE)}
        {assign var="ON_SELECT_NODE" value=''}
    {/if}
    <div class="js-tree-container" data-on-select-node="{$ON_SELECT_NODE}" data-js="jstree">
        <input class="js-tree-data" type="hidden" value="{\App\Purifier::encodeHtml(\App\Json::encode($TREE))}" data-js="val">
    </div>
    <!-- /tpl-Base-Tree -->
{/strip}
