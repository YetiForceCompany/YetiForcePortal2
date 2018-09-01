{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}

{if !\App\Log::isEmpty() && \App\Config::$debugConsole}
	<script>
		{foreach item=MESSAGE from=\App\Log::display()}
		$('#CoreLogList').append('<li>{$MESSAGE.message}</li>');
		{/foreach}
		$('#CoreLog').show();
	</script>
{else}
	<script>
		$('#CoreLog').hide();
	</script>
{/if}
