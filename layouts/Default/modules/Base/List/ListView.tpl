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
		<div class="col-sm-4 col-6">
			{if \YF\Modules\Base\Model\Module::isPermitted($MODULE_NAME, 'CreateView')}
				<div class="float-right">
				<a href="index.php?module={$MODULE_NAME}&view=EditView" class="btn btn-success btn-sm mb-0">
					<span class="fas fa-plus mr-2"></span>
					<strong>{\App\Language::translate('LBL_ADD_RECORD', $MODULE_NAME)}</strong>
				</a>
				</div>
			{/if}
			{if count($CUSTOM_VIEWS) > 1}
				<div class="col-8 float-right">
					<select name="cvId" id="customFilter" class="form-control form-control-sm js-cv-list">
						{foreach key=CV_ID item=CUSTOM_VIEW from=$CUSTOM_VIEWS}
							<option	value="{$CV_ID}" {if $CV_ID === $VIEW_ID} selected="selected" {/if}>
								{App\Purifier::decodeHtml($CUSTOM_VIEW.viewname)}
							</option>
						{/foreach}
					</select>
				</div>
			{elseif $VIEW_ID}
				<input type="hidden" name="cvId" id="customFilter" value="{$VIEW_ID}">
			{/if}
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
						<td class="p-0">
							<button type="button" class="btn btn-light btn-sm mr-1 js-search-records" data-js="click"><span class="fas fa-search"></span></button>
							<button type="button" class="btn btn-light btn-sm js-clear-search" data-js="click"><span class="fas fa-times"></button>
						</td>
						{foreach item=HEADER_LABEL key=HEADER_NAME from=$HEADERS}
							<td>
								<input type="text" name="filters[{$HEADER_NAME}]" class="form-control js-filter-field">
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
