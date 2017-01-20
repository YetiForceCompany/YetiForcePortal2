{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	<div class="userDetailsContainer">
		<div class="col-xs-2 noPadding">
			<img src="{Config::get('logo')}" class="img-responsive logo" alt="Logo" title="Logo">
		</div>
		<div class="col-xs-10 userDetails">
			<p>{$USER->get('firstName')}</p>
			<p>{$USER->get('lastName')}</p>
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
								<span class="moduleIcon-{$KEY}"></span>
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

