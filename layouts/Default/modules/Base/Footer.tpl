{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	{include file=\App\Functions::templatePath("BodyRight.tpl",$MODULE_NAME)}
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
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
										aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"
								id="myModalLabel">{\App\Functions::translate('LBL_CHANGE_COMPANY')}</h4>
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
									class="btn btn-primary">{\App\Functions::translate('LBL_CHANGE')}</button>
							<button type="button" class="btn btn-default"
									data-dismiss="modal">{\App\Functions::translate('BTN_CANCEL')}</button>
						</div>
					</div>
				</div>
			</div>
		{/if}
	</div>
	<footer class="footerContainer navbar-default navbar-fixed-bottom d-print-none">
		<div class="footer">
			<p>{sprintf(\App\Functions::translate('LBL_FOOTER_CONTENT',$MODULE_NAME), 'open source project' )}</p>
		</div>
	</footer>
	<div class="d-print-none">
		{foreach item=SCRIPT from=$FOOTER_SCRIPTS}
			<script src="{$SCRIPT->getSrc()}"></script>
		{/foreach}
	</div>
	{include file=\App\Functions::templatePath("Log.tpl",$MODULE_NAME)}
	</body>
	</html>
{/strip}
