{strip}
	<div class="widget_header">
		<div class="row">
			<div class="col-xs-12">
				<div class="pull-left">
					{include file=FN::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
			</div>
		</div>
	</div>
	<hr>
	{foreach item=FIELDS key=BLOCK from=$DETAIL}
		<div class="panel panel-default col-xs-12 paddingLRZero">
			<div class="panel-heading">{$BLOCK}</div>
				{foreach item=FIELD key=NAME from=$FIELDS}
					<div class='editFields col-sm-12 col-md-6 paddingLRZero'>
						<div class='editFieldName col-sm-6 col-md-6'>{$NAME}</div>
						<div class='editFieldValue col-sm-6 col-md-6'>
							<input class='form-control' type='text' name='{$NAME}' value='{$FIELD}'>
						</div>
					</div>
				{/foreach}
		</div>
	{/foreach}
{/strip}

