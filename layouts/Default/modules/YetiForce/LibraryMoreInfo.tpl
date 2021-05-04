{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-YetiForce-LibraryLicense -->
<div class="modal fade" id="modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<span class="fab fa-wpforms mt-3 mr-2" data-fa-transform="grow-10"></span>
				<h5 class="modal-title">{\App\Language::translate('LBL_LICENSE', $QUALIFIED_MODULE)}</h5>
				<button type="button" class="close" data-dismiss="modal"
						aria-label="{\App\Language::translate('LBL_CLOSE')}">
					<span aria-hidden="true" title="{\App\Language::translate('LBL_CLOSE')}">&times;</span>
				</button>
			</div>
			<div class="modal-body col-md-12">
				{if $FILE_EXIST}
					{nl2br($FILE_CONTENT)}
				{else}
					<div class="alert alert-danger" role="alert">
						{\App\Language::translate('LBL_MISSING_LICENSE_FILE', $QUALIFIED_MODULE)}
					</div>
				{/if}
			</div>
		</div>
	</div>
</div>
<!-- /tpl-YetiForce-LibraryLicense -->
{/strip}
