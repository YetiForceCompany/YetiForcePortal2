{strip}
</div>
</div>
</div>
</div>
<footer class="noprint">
	<div>

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
