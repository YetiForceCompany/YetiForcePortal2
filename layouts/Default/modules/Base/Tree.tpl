{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <!-- tpl-Base-Tree -->
    <b>{\App\Language::translate('LBL_CATEGORIES', $MODULE_NAME)}:</b>
    <div class="js-tree-container" data-js="jstree">
        <input class="js-tree-data" type="hidden" value="{\App\Purifier::encodeHtml(\App\Json::encode($TREE))}" data-js="val">
    </div>
    <!-- /tpl-Base-Tree -->
{/strip}
