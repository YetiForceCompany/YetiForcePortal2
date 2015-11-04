{strip}
	{include file=FN::templatePath("BodyRight.tpl",$MODULE_NAME)}
</div>
</div>
</div>
</div>
</div>
<footer class="footerContainer navbar-default navbar-fixed-bottom noprint">
	<div class="vtFooter">
		<p>{sprintf(FN::translate('LBL_FOOTER_CONTENT',$MODULE_NAME), '[0.00 s.]', 'open source project' )}</p>
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
