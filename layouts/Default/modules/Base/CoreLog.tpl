{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-CoreLog -->
	{if App\Config::getBool('debugConsole')}
		{assign var=LOGS value=\App\Log::display()}
		{if $LOGS}
			<div id="CoreLog" class="c-card card  col-sm-12 px-0 blockContainer mt-4">
				<div class="card-header c-card__header collapsed p-2" id="headingCoreLog" data-toggle="collapse" data-target="#coreLog" aria-expanded="true" aria-controls="coreLog">
					<span class="fas fa-angle-right mr-2 c-card__icon-right"></span>
					<span class="fas fa-angle-down mr-2 c-card__icon-down"></span>
					<span class="font-weight-bold">{\App\Language::translate('LBL_CORE_LOG')}</span>
				</div>
				<div id="coreLog" class="collapse" aria-labelledby="headingCoreLog">
					<div class="col-md-12 px-0 card-body">
						<ol id="CoreLogList">
							{foreach item=MESSAGES key=LOG_TYPE from=$LOGS}
								{foreach item=MESSAGE from=$MESSAGES}
									<li>{$MESSAGE}</li>;
								{/foreach}
							{/foreach}
						</ol>
					</div>
				</div>
			</div>
		{/if}
	{/if}
	<!-- /tpl-Base-CoreLog -->
{/strip}
