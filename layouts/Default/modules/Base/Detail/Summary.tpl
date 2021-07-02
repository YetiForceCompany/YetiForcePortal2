{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Detail-Summary -->
	<div class="o-detail-widgets row no-gutters mx-n1 mt-2">
		{if $DETAIL_VIEW_WIDGETS}
			{assign var=SPAN value=12/count($DETAIL_VIEW_WIDGETS)}
			{foreach item=WIDGETS_ROW from=$DETAIL_VIEW_WIDGETS}
				<div class="col-md-{$SPAN} px-1">
					{foreach key=key item=WIDGET from=$WIDGETS_ROW}
						{include file=\App\Resources::templatePath($WIDGET->getTemplatePath(), $WIDGET->getModuleName())}
					{/foreach}
				</div>
			{/foreach}
		{/if}
	</div>
	{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
<!-- /tpl-Base-Detail-Summary -->
{/strip}
