{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Widget-RelatedModule -->
	<div class="js-widget-container card mt-2" data-js="container" data-type="{$WIDGET->getType()}" data-url="{$WIDGET->getUrl()}">
		<div class="card-header p-2"><b>{\App\Purifier::encodeHTML($WIDGET->getTitle())}</b></div>
		<div class="js-widget-container_content card-body p-1" data-js="container"></div>
	</div>
	{foreach item=SCRIPT from=$WIDGET->scripts}
		<script src="{$SCRIPT->getSrc()}"></script>
	{/foreach}
	<!-- /tpl-Base-Widget-RelatedModule -->
{/strip}
