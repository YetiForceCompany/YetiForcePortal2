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
		<div class="panel panel-default col-xs-12 paddingLRZero">
			<div class="panel-heading">{$BLOCK}</div>
				{foreach item=FIELD key=NAME from=$FIELDS}
					<div class='col-sm-12 col-md-6 paddingLRZero'>
						<div class='fieldName col-sm-6 col-md-6'>{$NAME}</div>
						<div class='fieldValue col-sm-6 col-md-6'>
							<input class='form-control' type='text' name='{$NAME}' value='{$FIELD}'>
						</div>
					</div>
				{/foreach}
		</div>
	{/foreach}
{/strip}

