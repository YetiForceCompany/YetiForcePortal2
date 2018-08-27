{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="userDetailsContainer">
		<div class="col-xs-2 noPadding">
			<img src="{\App\Config::get('logo')}" class="img-responsive logo" alt="Logo" title="Logo">
		</div>
		<div class="col-xs-10 userDetails">
			<div class="userName">
				<span class="name">{$USER->get('name')}</span>
			</div>
			<div class="companyName">
				<span class="name">{$USER->get('parentName')}</span>
				{if $USER->getCompanies()}
					<div class="pull-right">
						<button type="button" class="btn btn-info btn-xs selectCompanies" data-toggle="modal">
							<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
						</button>
					</div>
				{/if}
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

