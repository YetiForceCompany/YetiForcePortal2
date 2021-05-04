{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-YetiForce-LibraryLicense -->
<div class="modal-body col-md-12">
	{if $FILE_EXIST}
		{nl2br($FILE_CONTENT)}
	{else}
		<div class="alert alert-danger" role="alert">
			{\App\Language::translate('LBL_MISSING_LICENSE_FILE', $QUALIFIED_MODULE)}
		</div>
	{/if}
</div>
<!-- /tpl-YetiForce-LibraryLicense -->
{/strip}
