{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Detail-Header -->
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
<!-- /tpl-Base-Detail-Header -->
{/strip}
