{strip}
	<div class="container-fluid userDetailsContainer">
		<div class="row">
			<div class="col-md-2 noPadding">
				<img src="{Config::get('logo')}" class="img-responsive logo" alt="Logo"title="Logo">
			</div>
			<div class="col-md-10 userDetails">
				<div class="pull-right">
					<a href="index.php?module=Users&action=Logout" class="loadPage">
						<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
					</a>
				</div>
				<p>{$USER->get('firstname')}</p>
				<p>{$USER->get('lastname')}</p>
				<p class="companyName">{$USER->get('company')}</p>
			</div>
		</div>
	</div>
	<div class="menuContainer">
		<ul class="nav nav-pills nav-stacked">
			{foreach item=MODULE key=KEY from=$USER->getModulesList()}
				<li role="presentation" class="active">
					<a href="index.php?module={$KEY}&view=ListView">
						<img src="{FN::fileTemplate($KEY|cat:"48.png",$MODULE_NAME)}" class="moduleIcon" title="{$MODULE}" alt="{$MODULE}">
						<spna>{$MODULE}</spna>
					</a>
				</li>
			{/foreach}
		</ul>
	</div>
{/strip}

