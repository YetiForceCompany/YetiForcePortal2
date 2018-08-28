{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="contentsDiv">
		<input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage"
			   value='{\App\Json::encode(\App\Config::get('listEntriesPerPage'))}'>
		<div class="widget_header row">
			<div class="col-sm-8">
				<div class="pull-left">
					{include file=\App\Functions::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
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
								<strong>{\App\Functions::translate('LBL_ADD_RECORD', $MODULE_NAME)}</strong>
							</a>
						{/if}
					</div>
				</div>
			</div>
		</div>
		<div class="row listViewContents">
			<div class="table-responsive col-xs-12">
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
						<tr data-record="{$ID}" data-name="{\App\Functions::toSafeHTML($RECORD->getName())}">
							<td class="leftRecordActions">
								{include file=\App\Functions::templatePath("ListViewActions.tpl",$MODULE_NAME)}
							</td>
							{foreach item=HEADER key=FIELD_NAME from=$HEADERS}
								<td>{$RECORD->get($FIELD_NAME)}</td>
							{/foreach}
						</tr>
					{/foreach}
					</tbody>
				</table>
			</div>
		</div>
		<div id="CoreLog" class="panel panel-primary col-xs-12 px-0 blockContainer">
			<div class="card-header">{\App\Functions::translate('LBL_CORE_LOG')}</div>
			<div class="col-md-12 px-0 card-body">
				<ol id="CoreLogList">

				</ol>
			</div>
		</div>
	</div>
{/strip}
