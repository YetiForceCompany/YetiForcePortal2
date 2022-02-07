{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Tree -->
	<div class="d-flex justify-content-between">
		<b>{\App\Language::translate('LBL_CATEGORIES', $MODULE_NAME)}:</b>
		<button class="btn btn-sm btn-danger js-tree-clear d-none mb-0 py-0" data-js="jstree | class:d-none"><span class="fas fa-times mr-1"></span>{\App\Language::translate('LBL_CLEAR', $MODULE_NAME)}</button>
	</div>
	<div class="js-tree-container" data-js="jstree">
		<input class="js-tree-data" type="hidden" value="{\App\Purifier::encodeHtml(\App\Json::encode($TREE))}" data-js="val">
	</div>
	<!-- /tpl-Base-Tree -->
{/strip}
