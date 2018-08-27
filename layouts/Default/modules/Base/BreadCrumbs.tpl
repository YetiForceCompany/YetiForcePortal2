{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="breadCrumbs">
		{if isset($BREADCRUMB_TITLE)}
			{assign var="BREADCRUMBS" value=\App\Menu::getBreadcrumbs($BREADCRUMB_TITLE)}
		{else}
			{assign var="BREADCRUMBS" value=\App\Menu::getBreadcrumbs()}
		{/if}

		{assign var=HOMEICON value='userIcon-Home'}
		{if !empty($BREADCRUMBS)}
			<div class="breadcrumbsContainer">
				<h2 class="breadcrumbsLinks textOverflowEllipsis">
					<a href='{\App\Config::get('portalPath')}'>
						<span class="{$HOMEICON}"></span>
					</a>
					&nbsp;|&nbsp;
					{foreach key=key item=item from=$BREADCRUMBS name=breadcrumbs}
						{if $key != 0 && $ITEM_PREV}
							<span class="separator">&nbsp;>&nbsp;</span>
						{/if}
						{if isset($item['url'])}
							<a href="{$item['url']}">
								<span>{$item['name']}</span>
							</a>
						{else}
							<span>{$item['name']}</span>
						{/if}
						{assign var="ITEM_PREV" value=$item['name']}
					{/foreach}
				</h2>
			</div>
		{/if}
	</div>
{/strip}
