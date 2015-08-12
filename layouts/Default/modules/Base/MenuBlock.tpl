{strip}
	<ul class="nav nav-pills nav-stacked">
		{foreach item=MODULE key=KEY from=$USER->getModulesList()}
			<li role="presentation" class="active"><a data-module="{$MODULE}" data-view="ListView" href="#">{$MODULE}</a></li>
		{/foreach}
	</ul>
{/strip}

