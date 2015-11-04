{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	<div class="breadCrumbs" >
		
		{assign var="BREADCRUMBS" value=Core\Menu::getBreadcrumbs()}
		{assign var=HOMEICON value='moduleIcon-my-home-page'}
		{if !empty($BREADCRUMBS)}
			<div class="breadcrumbsContainer">
				<h2 class="breadcrumbsLinks">
					<a href='/'>
						<span class="{$HOMEICON}"></span>
					</a>
					&nbsp;|&nbsp;
					
					{foreach key=key item=item from=$BREADCRUMBS name=breadcrumbs}
						{if $key != 0 && $ITEM_PREV}
							<span class="separator">&nbsp;->&nbsp;</span>
						{/if}
						<span>{$item['name']}</span>
						{assign var="ITEM_PREV" value=$item['name']}
					{/foreach}
				</h2>
			</div>
		{/if}			
	</div>
{/strip}
