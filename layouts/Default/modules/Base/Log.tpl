{if !\YF\Core\Log::isEmpty() && \YF\Core\Config::getBoolean('debugConsole')}
	<script>
		{foreach item=MESSAGE from=\YF\Core\Log::display()}
		$('#CoreLogList').append('<li>{$MESSAGE.message}</li>');
		{/foreach}
		$('#CoreLog').show();
	</script>
{else}
	<script>
		$('#CoreLog').hide();
	</script>
{/if}