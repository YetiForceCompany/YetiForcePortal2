{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="breadCrumbs">
		{if isset($BREADCRUMB_TITLE)}
			{assign var="BREADCRUMBS" value=\App\Menu::getBreadcrumbs($BREADCRUMB_TITLE)}
		{else}
			{assign var="BREADCRUMBS" value=\App\Menu::getBreadcrumbs()}
		{/if}
		{assign var=HOMEICON value='fas fa-home'}
		{if !empty($BREADCRUMBS)}
			<div class="breadcrumbsContainer">
				<h2 class="breadcrumbsLinks textOverflowEllipsis">
					<a href="{\App\Config::$portalUrl}">
						<span class="{$HOMEICON}"></span>
					</a>
					<span class="separator m-2">/</span>
					{foreach key=key item=item from=$BREADCRUMBS name=breadcrumbs}
						{if $key != 0 && $ITEM_PREV}
							<span class="separator m-2">/</span>
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
