{strip}
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

