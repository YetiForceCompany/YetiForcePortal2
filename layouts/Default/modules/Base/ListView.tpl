{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Base-ListView contentsDiv">
		<input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage" value="{\App\Json::encode(\App\Config::$listEntriesPerPage)}">
		<div class="widget_header row py-1">
			<div class="col-sm-8">
				<div class="pull-left">
					{include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
				</div>
			</div>
			<div class="col-sm-4 listViewAction">
				<div class="float-right">
						{assign var=IS_CREATEVIEW value=\YF\Modules\Base\Model\Module::isPermitted($MODULE_NAME, 'CreateView')}
						{if $IS_CREATEVIEW}
							<a href="index.php?module={$MODULE_NAME}&view=EditView" class="btn btn-outline-success btn-sm mb-0">
								<span class="fas fa-plus"></span>
								&nbsp;
								<strong>{\App\Language::translate('LBL_ADD_RECORD', $MODULE_NAME)}</strong>
							</a>
						{/if}
				</div>
			</div>
		</div>
		<div class="row listViewContents">
			<div class="table-responsive col-sm-12">
				<table class="table listViewEntries d-none">
					<thead>
					<tr class="listViewHeaders">
						<th></th>
						{foreach item=HEADER from=$HEADERS}
							<th>{$HEADER}</th>
						{/foreach}
					</tr>
					</thead>
					<tbody>
					{foreach item=RECORD key=ID from=$RECORDS}
						<tr data-record="{$ID}" data-name="{\App\Purifier::encodeHtml($RECORD->getName())}">
							<td class="leftRecordActions">
								{include file=\App\Resources::templatePath("ListViewActions.tpl", $MODULE_NAME)}
							</td>
							{foreach item=HEADER key=FIELD_NAME from=$HEADERS}
								<td>{$RECORD->getDisplayValue($FIELD_NAME)}</td>
							{/foreach}
						</tr>
					{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
	{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
{/strip}
