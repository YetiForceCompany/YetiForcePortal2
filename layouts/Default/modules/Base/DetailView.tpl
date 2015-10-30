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
{/strip}

