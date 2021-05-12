{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Modal-Pdf -->
<form id="pdfExportModal" class="tpl-Modal-Pdf mb-0" action="index.php?module={$MODULE_NAME}&action=Pdf&mode=generate" target="_blank" method="POST">
	<div class="modal-body js-pdf-container">
		<div class="card">
			<div class="card-body">
				<input name="record" value="{$RECORD_ID}" type="hidden">
				<input type="hidden" name="templates" value="[]" />
				{foreach from=$TEMPLATES item=TEMPLATE}
					<div class="form-group row">
						<label class="col-sm-11 col-form-label text-left pt-0" for="pdfTpl{$TEMPLATE['id']}">
							{$TEMPLATE['name']}
							{if $TEMPLATE['second_name']}
								<span class="secondaryName ml-2">[{$TEMPLATE['second_name']}]</span>
							{/if}
						</label>
						<div class="col-sm-1">
							<input type="checkbox" id="pdfTpl{$TEMPLATE['id']}" class="checkbox js-template" value="{$TEMPLATE['id']}"
							{if $TEMPLATE['default']}checked="checked"{/if} />
						</div>
					</div>
				{/foreach}
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button id="generatePdf" type="submit" class="btn btn-success">
			<span class="fas fa-file-pdf mr-1"></span>{\App\Language::translate('BTN_GENERATE_PDF', $MODULE_NAME)}
		</button>
		<button class="btn btn-danger" type="reset" data-dismiss="modal"><span class="fas fa-times mr-1"></span>{\App\Language::translate('BTN_CANCEL', $MODULE_NAME)}</button>
	</div>
</form>
<!-- /tpl-Base-Modal-Pdf -->
{/strip}
