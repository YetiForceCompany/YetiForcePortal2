{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="userDetailsContainer">
		<div class="col-sm-2 p-0">
			<img src="{\App\Config::get('logo')}" class="img-responsive logo" alt="Logo" title="Logo">
		</div>
		<div class="col-sm-10 userDetails">
			<div class="userName">
				<span class="name">{$USER->get('name')}</span>
			</div>
			<div class="companyName">
				<span class="name">{$USER->get('parentName')}</span>
			</div>
		</div>
	</div>
	<div class="menuContainer">
		<ul class="moduleList" style="padding-left:1px;">
			{foreach item=MODULE key=KEY from=$USER->getModulesList()}
				<li role="presentation" class="active">
					<a href="index.php?module={$KEY}&view=ListView">
						<div class="iconContainer">
							<div class="iconImage">
								<span class="userIcon-{$KEY}"></span>
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

