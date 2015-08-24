{strip}
	<div class="container-fluid">
		<div class="row">
			{foreach item=FIELDS key=BLOCK from=$DETAIL}
				<div class="panel panel-default">
					<div class="panel-heading">{$BLOCK}</div>
					<table class="table">
						{foreach item=FIELD key=NAME from=$FIELDS}
							<tr>
								<td>{$NAME}</td>
								<td>{$FIELD}</td>
							</tr>
						{/foreach}
					</table>
				</div>
			{/foreach}
		</div>
	</div>
{/strip}

