{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	<div class="contentsDiv">
		<input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage" value='{\Core\Json::encode(\Config::get('listEntriesPerPage'))}'>
		<div class="widget_header row">
			<div class="col-sm-8">
				<div class="pull-left">
					{include file=FN::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
			</div>
			<div class="col-sm-4 listViewAction">
				<div class="pull-right">
					<div class="btn-group">
						<a href="index.php?module={$MODULE_NAME}&view=EditView" class="btn btn-success">
							<span class="glyphicon glyphicon-plus"></span>
							&nbsp;
							<strong>{FN::translate('LBL_ADD_RECORD', $MODULE_NAME)}</strong>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="table-responsive col-xs-12">
				<table class="table listViewEntries">
					<thead>
						<tr class='listViewHeaders'>
							{foreach item=HEADER from=$HEADERS}
								<th>{$HEADER}</th>
								{/foreach}
							<th></th>
						</tr>
					</thead>
					<tbody>
						{foreach item=RECORD key=ID from=$RECORDS}
							<tr data-record="{$ID}">
								{foreach item=COLUMN from=$RECORD}
									<td>{$COLUMN}</td>
								{/foreach}
								<td>
									<div class='actions'>
										<a href="index.php?module={$MODULE_NAME}&view=DetailView&record={$ID}"><span class='glyphicon glyphicon-th-list alignMiddle'></span></a>
										<a href="index.php?module={$MODULE_NAME}&view=EditView&record={$ID}"><span class='glyphicon glyphicon-pencil alignMiddle'></span></a>
									</div>
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>	
			</div>
		</div>
	</div>
{/strip}
