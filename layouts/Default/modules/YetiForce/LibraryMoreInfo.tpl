{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-YetiForce-LibraryMoreInfo -->
<div class="modal-body col-md-12">
	{if $RESULT}
		<code>
			<pre>{$FILE_CONTENT}</pre>
		</code>
	{else}
		<div class="alert alert-danger" role="alert">
			{\App\Language::translate('LBL_MISSING_FILE', $QUALIFIED_MODULE)}
		</div>
	{/if}
</div>
<!-- /tpl-YetiForce-LibraryMoreInfo -->
{/strip}
