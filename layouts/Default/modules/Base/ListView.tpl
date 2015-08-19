{strip}
	<div class="container-fluid">
		<div class="row">
			<table class="table">
				<thead>
					<tr>
						{foreach item=HEADER from=$HEADERS}
							<th>{$HEADER}</th>
						{/foreach}
					</tr>
				</thead>
				<tbody>
					{foreach item=RECORD key=ID from=$RECORDS}
						<tr>
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

