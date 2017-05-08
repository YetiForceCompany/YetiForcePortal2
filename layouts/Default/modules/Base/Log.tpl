{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} --!>*}

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