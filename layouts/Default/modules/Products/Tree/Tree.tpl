{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Products-Tree-Tree contentsDiv">
		<input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage" value="{\App\Json::encode(\App\Config::$listEntriesPerPage)}">
		<div class="widget_header row">
			<div class="col-sm-8">
				<div class="pull-left">
					{include file=\App\Resources::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
			</div>
			<div class="col-sm-4 listViewAction">
				<div class="float-right">
					<div class="btn-group">
						{assign var=IS_CREATEVIEW value=\YF\Modules\Base\Model\Module::isPermitted($MODULE_NAME, 'CreateView')}
						{if $IS_CREATEVIEW}
							<a href="index.php?module={$MODULE_NAME}&view=EditView" class="btn btn-success">
								<span class="fas fa-plus"></span>
								&nbsp;
								<strong>{\App\Language::translate('LBL_ADD_RECORD', $MODULE_NAME)}</strong>
							</a>
						{/if}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-4">
				{include file=\App\Resources::templatePath("Tree/Category.tpl", $MODULE_NAME)}
			</div>
			<div class="col-8">
				<div class="row listViewContents">
					{foreach item=RECORD key=ID from=$RECORDS}
						{include file=\App\Resources::templatePath("Tree/Product.tpl", $MODULE_NAME)}
					{/foreach}
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
