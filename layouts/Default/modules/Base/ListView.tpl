{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	<div class="widget_header">
		<div class="row marginLRZero">
			<div class="col-xs-12 paddingLRZero">
				<div class="pull-left">
					{include file=FN::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="container-fluid paddingLRZero">
		<div class="listViewAction row marginLRZero">
			<div class="col-md-4 paddingLRZero pull-left">
				<div class="btn-group">
					<a href="index.php?module={$MODULE_NAME}&view=EditView" class="btn btn-default">
						<span class="glyphicon glyphicon-plus"></span>
						&nbsp;
						<strong>{FN::translate('LBL_ADD_RECORD', $MODULE_NAME)}</strong>
					</a>
				</div>
			</div>
			<div class="col-md-4 row paginationDiv pull-right">				
				{include file=FN::templatePath("Pagination.tpl",$MODULE_NAME)}
			</div>		
		</div>
		<div class="row marginLRZero">
			<div class="table-responsive">
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