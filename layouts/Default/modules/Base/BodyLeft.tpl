{strip}
	<div class="userDetailsContainer">
		<div class="col-xs-2 noPadding">
			<img src="{Config::get('logo')}" class="img-responsive logo" alt="Logo" title="Logo">
		</div>
		<div class="col-xs-10 userDetails">
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
	<div class="menuContainer">
		<ul class="moduleList" style="padding-left:1px;">
			{foreach item=MODULE key=KEY from=$USER->getModulesList()}
				<li role="presentation" class="active">
					<a href="index.php?module={$KEY}&view=ListView">
						<div class="iconContainer">
							<div class="iconImage">
								<span class="{Core\Menu::getIcon($MODULE)}"></span>
							</div>
						</div>
						<div class="labelContainer">
							<div class="labelValue">
								{$MODULE}
							</div>
						</div>
					</a>
				</li>
			{/foreach}
		</ul>
	</div>
{/strip}

