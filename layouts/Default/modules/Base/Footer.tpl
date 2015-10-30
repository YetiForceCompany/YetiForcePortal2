{strip}
{include file=FN::templatePath("BodyRight.tpl",$MODULE_NAME)}
</div>
</div>
</div>
</div>
</div>
<footer class="noprint">
	<div>
		<br/>
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
