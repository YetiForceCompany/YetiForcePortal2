{strip}
	{include file=FN::templatePath("BodyRight.tpl",$MODULE_NAME)}
</div>
</div>
</div>
</div>
</div>
</div>
<footer class="footerContainer navbar-default navbar-fixed-bottom noprint">
	<div class="vtFooter">
		<p>Copyright 2014 YetiForce.com All rights reserved. [ver. 2.2.177] [Czas ładowania strony: 1.216s.]<br>
			Creating YetiForce software was possible thanks to the open source project called Vtiger CRM and other programs that have open source codes.</p>
			{*{if vglobal('isVisibleLogoInFooter') == 'true'}
			<div class='pull-right'>
			{assign var=ADDRESS value='http://www.yetiforce.com'}
			<a href='{$ADDRESS}'>
			<img class='logoFooter' src="{$COMPANY_LOGO->get('imagepath')}" title="{$COMPANY_LOGO->get('title')}" alt="{$COMPANY_LOGO->get('alt')}"/>
			</a>
			</div>
			{/if}*}
		{*assign var=SCRIPT_TIME value=round(microtime(true) - vglobal('Start_time'), 3)*}
		{*if $USER_MODEL->is_admin == 'on'}
		{assign var=FOOTVR value= '[ver. '|cat:$YETIFORCE_VERSION|cat:'] ['|cat:vtranslate('WEBLOADTIME')|cat:': '|cat:$SCRIPT_TIME|cat:'s.]'}
		{assign var=FOOTVRM value= '['|cat:$SCRIPT_TIME|cat:'s.]'}
		{assign var=FOOTOSP value= '<u><a href="index.php?module=Home&view=Credits&parent=Settings">open source project</a></u>'}
		<p class='mobileOff'>{sprintf( vtranslate('LBL_FOOTER_CONTENT') , $FOOTVR ,$FOOTOSP)}</p>
		<p class='mobileOn'>{sprintf( vtranslate('LBL_FOOTER_CONTENT') , $FOOTVRM ,$FOOTOSP)}</p>
		{else}
		<p>{sprintf( vtranslate('LBL_FOOTER_CONTENT') , '['|cat:vtranslate('WEBLOADTIME')|cat:': '|cat:$SCRIPT_TIME|cat:'s.]', 'open source project' )}</p>
		{/if*}
	</div>
</footer>
<div class="noprint">
	{foreach item=SCRIPT from=$FOOTER_SCRIPTS}
		<script src="{$SCRIPT->getSrc()}"></script>
	{/foreach}
</div>
</body>
</html>
{/strip}
