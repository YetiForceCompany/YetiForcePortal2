{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Detail-Header -->
<input type="hidden" id="recordId" value="{$RECORD->getId()}">
<input type="hidden" id="mode" value="{$MODE}">
<div class="widget_header row">
	<div class="col-sm-12">
		<div class="float-left">
			{include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
		</div>
		<div class="contentHeader">
			<span class="float-right">
				{foreach from=$DETAIL_LINKS item=DETAIL_LINK}
					{\App\Layout\Action::getButton($DETAIL_LINK)}
				{/foreach}
			</span>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
{if !empty($FIELDS_HEADER)}
	{include file=\App\Resources::templatePath("Detail/HeadersFields.tpl", $MODULE_NAME)}
{/if}
<div class="pt-3 detail-tabs">
	<ul class="nav nav-pills js-tabdrop" data-js="container">
		{foreach item=TABS key=TYPE from=$TABS_GROUP}
			{foreach item=TAB from=$TABS}
				<li class="nav-item {if $TYPE eq 'related'}c-tab--gray d-none{/if} mr-1">
					<a href="{$TAB['url']}" class="nav-link {if $MENU_ID === $TAB['tabId']}active{/if}">
						{if $TAB['icon']}
							<span class="{$TAB['icon']} mr-2"></span>
						{/if}
						<span class="">{$TAB['label']}</span>
					</a>
				</li>
			{/foreach}
		{/foreach}
	</ul>
</div>
<!-- /tpl-Base-Detail-Header -->
{/strip}
