{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}
{strip}
	<div class="contentsDiv">
		<input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage" value='{\YF\Core\Json::encode(\YF\Core\Config::get('listEntriesPerPage'))}'>
		<div class="widget_header row">
			<div class="col-sm-8">
				<div class="pull-left">
					{include file=\YF\Core\Functions::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
			</div>
			<div class="col-sm-4 listViewAction">
				<div class="pull-right">
					<div class="btn-group">
						{assign var=IS_CREATEVIEW value=\YF\Modules\Base\Model\Module::isPermitted($MODULE_NAME, 'CreateView')}
						{if $IS_CREATEVIEW}
							<a href="index.php?module={$MODULE_NAME}&view=EditView" class="btn btn-success">
								<span class="glyphicon glyphicon-plus"></span>
								&nbsp;
								<strong>{\YF\Core\Functions::translate('LBL_ADD_RECORD', $MODULE_NAME)}</strong>
							</a>
						{/if}
					</div>
				</div>
			</div>
		</div>
		<div class="row listViewContents">
			<div class="table-responsive col-xs-12">
				<table class="table listViewEntries hide">
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
							<tr data-record="{$ID}" data-name="{\YF\Core\Functions::toSafeHTML($RECORD->getName())}">
								<td class="leftRecordActions">
									{include file=\YF\Core\Functions::templatePath("ListViewActions.tpl",$MODULE_NAME)}
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
		<div id="CoreLog" class="panel panel-primary col-xs-12 paddingLRZero blockContainer">
			<div class="panel-heading">{\YF\Core\Functions::translate('LBL_CORE_LOG')}</div>
			<div class="col-md-12 paddingLRZero panel-body">
				<ol id="CoreLogList">

				</ol>
			</div>
		</div>
	</div>
{/strip}
