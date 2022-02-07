{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Dashboard-PreDashboard">
		<ul class="nav nav-tabs mt-1">
			{foreach from=$DASHBOARD_TYPE item=DASHBOARD}
				<li class="nav-item js-select-dashboard" data-id="{$DASHBOARD['id']}" data-js="data-id">
					<a class="nav-link  {if $SELECTED_DASHBOARD eq $DASHBOARD['id'] || ($SELECTED_DASHBOARD eq 0 && $DASHBOARD['system'] eq 1)}active{/if}" href="#" data-toggle="tab">
						<strong>{$DASHBOARD['name']}</strong>
					</a>
				</li>
			{/foreach}
		</ul>
{/strip}
