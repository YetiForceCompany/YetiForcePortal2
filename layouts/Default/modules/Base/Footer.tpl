{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Footer -->
	{include file=\App\Resources::templatePath("BodyRight.tpl", $MODULE_NAME)}
	</div>
	</div>
	</div>
	</div>
	</div>
	<div>
		{assign var=COMPANIES value=$USER->getCompanies()}
		{if $COMPANIES}
			<div class="modal fade" id="modalSelectCompanies" tabindex="-1" role="dialog"
				 aria-labelledby="selectCompanies">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="myModalLabel">
								<span class="fas fa-exchange-alt mr-1"></span>
								{\App\Language::translate('LBL_CHANGE_COMPANY')}
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
										aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<select class="form-control" id="companyId">
								{foreach item=ITEM key=KEY from=$COMPANIES}
									<option value="{$KEY}">{$ITEM['name']}</option>
								{/foreach}
							</select>
						</div>
						<div class="modal-footer">
							<button type="button"
									class="btn btn-success js-change-company" data-js="click">
								<span class="fas fa-check mr-1"></span>
								{\App\Language::translate('LBL_CHANGE')}
							</button>
							<button type="button" class="btn btn-danger"
									data-dismiss="modal">
								<span class="fas fa-times mr-1"></span>
								{\App\Language::translate('BTN_CANCEL')}
							</button>
						</div>
					</div>
				</div>
			</div>
		{/if}
	</div>
	<footer class="footerContainer d-print-none w-100">
		<div class="footer">
			<p>{sprintf(\App\Language::translate('LBL_FOOTER_CONTENT', $MODULE_NAME), 'open source project' )}</p>
		</div>
	</footer>
	<div class="d-print-none">
		{foreach item=SCRIPT from=$FOOTER_SCRIPTS}
			<script src="{$SCRIPT->getSrc()}"></script>
		{/foreach}
	</div>
	</body>
	</html>
	<!-- /tpl-Base-Footer -->
{/strip}
