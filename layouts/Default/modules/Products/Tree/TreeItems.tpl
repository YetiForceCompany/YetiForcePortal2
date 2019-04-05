{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Products-Tree-Tree contentsDiv js-products-container" data-js="container">
		<input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage" value="{\App\Json::encode(\App\Config::$listEntriesPerPage)}">
		<div class="widget_header row">
			<div class="col-sm-8">
				<div class="pull-left">
					{include file=\App\Resources::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
			</div>
			<div class="col-sm-4 listViewAction">
				<div class="float-right">
					<div class="input-group js-search-group" data-js="change|keyup">
						<div class="input-group-prepend">
							<span class="input-group-text bg-white hide js-search-cancel border-bottom">
								<span class="u-cursor-pointer" data-js="click" aria-hidden="true">&times;</span>
							</span>
						</div>
						<input type="text" class="form-control u-font-size-13px js-search border-bottom rounded-0 o-chat__form-control"{' '}
							autocomplete="off"{' '}
							placeholder="{\App\Language::translate('LBL_SEARCH_PRODUCT', $MODULE_NAME)}"
							data-js="keydown"/>
						<div class="input-group-append">
							<span class="input-group-text bg-white border-bottom u-cursor-pointer js-icon-search-message">
								<span class="fas fa-search"></span>
							</span>
						</div>
					</div>
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
				<div class="row listViewContents">
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

		<div id="CoreLog" class="panel panel-primary col-sm-12 px-0 blockContainer">
			<div class="card-header">{\App\Language::translate('LBL_CORE_LOG')}</div>
			<div class="col-md-12 px-0 card-body">
				<ol id="CoreLogList">

				</ol>
			</div>
		</div>

	</div>
{/strip}
