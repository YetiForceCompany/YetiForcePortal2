{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Dashboard-Dashboard js-dashboard-container">
		<ul class="o-dashboard-container">
			{foreach from=$WIDGETS item=WIDGET_MODEL}
				<li class="o-dashboard-widget js-widget" data-type="{$WIDGET_MODEL->get('type')}">
					<div class="o-dashboard-widget-header">
						{include file=\App\Resources::templatePath($WIDGET_MODEL->getPreProcessTemplate(), $MODULE_NAME)}
					</div>
					<div class="o-dashboard-widget-content">
						{include file=\App\Resources::templatePath($WIDGET_MODEL->getProcessTemplate(), $MODULE_NAME)}
					</div>
				</li>
			{/foreach}
		</ul>
	</div>
	{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
{/strip}
