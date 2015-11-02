{strip}
	<div class="widget_header">
		<div class="row">
			<div class="col-xs-12">
				<div class="pull-left">
					{*include file=FN::templatePath("BreadCrumbs.tpl",$MODULE_NAME)*}
					<img src="{FN::fileTemplate($MODULE_NAME|cat:"48.png",$MODULE_NAME)}" class="moduleIcon" title="{FN::getTranslatedModuleName($MODULE_NAME)}" alt="{FN::getTranslatedModuleName($MODULE_NAME)}">
				</div>
				<h4>{FN::getTranslatedModuleName($MODULE_NAME)}</h4>
			</div>
		</div>
	</div>
	<hr>
	<div class="container-fluid">
		<div class="listViewAction row">
			<div class="col-md-4 paddingLRZero pull-left">
				<div class="btn-group">
					<a href="" class="btn btn-default">
						<span class="glyphicon glyphicon-plus"></span>
						&nbsp;
						<strong>{FN::translate('LBL_ADD_RECORD', $MODULE_NAME)}</strong>
					</a>
				</div>
			</div>
			<div class="col-md-3 row paginationDiv pull-right">				
				{include file=FN::templatePath("Pagination.tpl",$MODULE_NAME)}
			</div>		
		</div>
		<div class="row">
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
										<a href=''><span class='glyphicon glyphicon-th-list alignMiddle'></span></a>
										<a href=''><span class='glyphicon glyphicon-pencil alignMiddle'></span></a>
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

