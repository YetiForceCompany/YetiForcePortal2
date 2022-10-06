{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Footer -->
	{include file=\App\Resources::templatePath("BodyRight.tpl", $MODULE_NAME)}
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div>
	</div>
	{if $SHOW_FOOTER_BAR}
		<footer class="footerContainer d-print-none w-100">
			<div class="footer">
				{assign var=SCRIPT_TIME value=round(microtime(true) - \App\Process::$startTime, 3)}
				Copyright &copy; YetiForce.com All rights reserved. [{\App\Language::translate('LBL_WEB_LOAD_TIME')}: {$SCRIPT_TIME}s.]<br />
				{assign var=FOOTOSP value='<em><a class="u-text-underline text-info" href="index.php?module=YetiForce&view=Credits">open source project</a></em>'}
				{if 'Install' eq $MODULE_NAME}
					{assign var=FOOTOSP value='open source project'}
				{/if}
				<p>{\App\Language::translateArgs('LBL_FOOTER_CONTENT', 'Basic', $FOOTOSP)}</p>
			</div>
		</footer>
	{/if}
	<input type="hidden" id="processEvents" value="{\App\Purifier::encodeHtml(\App\Json::encode(App\Process::getEvents()))}" />
	<div class="d-print-none">
		{foreach item=SCRIPT from=$JS_FILE}
			<script src="{$SCRIPT->getSrc()}"></script>
		{/foreach}
	</div>
	</body>

	</html>
	<!-- /tpl-Base-Footer -->
{/strip}
