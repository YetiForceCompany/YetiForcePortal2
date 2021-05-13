{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-List-ListView -->
<form class="js-form-container" data-js="container">
	<input type="hidden" name="module" value="{$MODULE_NAME}">
	<input type="hidden" name="action" value="{$VIEW}">
	<input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage" value="{\App\Json::encode(\App\Config::$listEntriesPerPage)}">
	<div class="widget_header row py-1">
		<div class="col-sm-8 col-6">
			<div class="pull-left">
				{include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
			</div>
		</div>
		<div class="col-sm-4 col-6 listViewAction">
			<div class="float-right">
				{assign var=IS_CREATEVIEW value=\YF\Modules\Base\Model\Module::isPermitted($MODULE_NAME, 'CreateView')}
				{if $IS_CREATEVIEW}
					<a href="index.php?module={$MODULE_NAME}&view=EditView" class="btn btn-success btn-sm mb-0">
						<span class="fas fa-plus mr-2"></span>
						<strong>{\App\Language::translate('LBL_ADD_RECORD', $MODULE_NAME)}</strong>
					</a>
				{/if}
			</div>
		</div>
	</div>
	<div class="row mt-2">
		<div class="table-responsive col-sm-12">
			<table class="table listViewEntries js-list-view-table" data-js="dataTable">
				<thead>
					<tr class="listViewHeaders">
						<th></th>
						{foreach item=HEADER_LABEL key=HEADER_NAME from=$HEADERS}
							<th data-name="{$HEADER_NAME}" data-orderable="1" class="text-nowrap">{$HEADER_LABEL}</th>
						{/foreach}
					</tr>
					<tr>
						<td></td>
						{foreach item=HEADER_LABEL key=HEADER_NAME from=$HEADERS}
							<td>
								<input type="text" name="filters[{$HEADER_NAME}]" class="form-control">
							</td>
						{/foreach}
					</tr>
				</thead>
			</table>
		</div>
	</div>
</form>
{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
<!-- /tpl-Base-List-ListView -->
{/strip}
