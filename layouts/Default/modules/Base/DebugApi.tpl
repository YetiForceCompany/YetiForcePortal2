{strip}
	<div class="panel panel-primary">
		<div class="panel-heading">{translate('LBL_DEBUG_CONSOLE', $MODULE_NAME)}</div>
		<div class="panel-body">
			{foreach item=ITEM from=$DEBUG_API}
				{$ITEM}
				<hr/>
			{/foreach}
		</div>
	</div>
{/strip}

