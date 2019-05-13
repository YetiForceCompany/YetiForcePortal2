{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	{if App\Config::getBool('debugConsole')}
		<div id="CoreLog" class="c-card card  col-sm-12 px-0 blockContainer mt-4">
			<div class="card-header c-card__header collapsed" id="headingCoreLog"  data-toggle="collapse" data-target="#coreLog" aria-expanded="true" aria-controls="coreLog">
				<span class="fas fa-angle-right mr-2 c-card__icon-right"></span>
				<span class="fas fa-angle-down mr-2 c-card__icon-down"></span>
				<span class="font-weight-bold">{\App\Language::translate('LBL_CORE_LOG')}</span>
			</div>
			<div id="coreLog" class="collapse" aria-labelledby="headingCoreLog">
				<div class="col-md-12 px-0 card-body">
					<ol id="CoreLogList">

					</ol>
				</div>
			</div>
		</div>
	{/if}
{/strip}
