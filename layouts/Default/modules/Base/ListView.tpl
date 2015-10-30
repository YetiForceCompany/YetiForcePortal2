{strip}
	<div class="widget_header">
		<div class="row">
			<div class="col-xs-12">
				<div class="pull-left">
					<img src="{FN::fileTemplate($MODULE_NAME|cat:"48.png",$MODULE_NAME)}" class="moduleIcon" title="{FN::getTranslatedModuleName($MODULE_NAME)}" alt="{FN::getTranslatedModuleName($MODULE_NAME)}">
				</div>
				<h4>{FN::getTranslatedModuleName($MODULE_NAME)}</h4>
			</div>
		</div>
	</div>
	<hr>
	<div class="container-fluid">
		<div class="row">
			<table class="table listViewEntries">
				<thead>
					<tr>
						{foreach item=HEADER from=$HEADERS}
							<th>{$HEADER}</th>
						{/foreach}
					</tr>
				</thead>
				<tbody>
					{foreach item=RECORD key=ID from=$RECORDS}
						<tr data-record="{$ID}">
							{foreach item=COLUMN from=$RECORD}
								<th>{$COLUMN}</th>
							{/foreach}
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{/strip}

