{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="actionMenu" aria-hidden="true">
		<div class="row m-0">
			<div class="dropdown quickAction historyBtn">
				<div class="labelContainer float-left">
					{\App\Language::translate('LBL_PAGES_HISTORY', $MODULE_NAME)}
				</div>
				<div class="iconContainer float-right">
					<a data-placement="left" data-toggle="dropdown" class="btn btn-default btn-sm showHistoryBtn"
					   aria-expanded="false" href="#">
						<img class='alignMiddle popoverTooltip dropdown-toggle'
							 src="{\App\Resources::resourcePath("history.png", $MODULE_NAME)}"
							 alt="{\App\Language::translate('LBL_PAGES_HISTORY', $MODULE_NAME)}"
							 data-content="{\App\Language::translate('LBL_PAGES_HISTORY', $MODULE_NAME)}"/>
					</a>
				</div>
			</div>
		</div>
		<div class='row m-0'>
			<div class="dropdown quickAction">
				<div class="labelContainer float-left">
					{\App\Language::translate('LBL_QUICK_CREATE', $MODULE_NAME)}
				</div>
				<div class="iconContainer float-right">
					<a id="mobile_menubar_quickCreate" class="dropdown-toggle btn btn-default" data-toggle="dropdown"
					   title="{\App\Language::translate('LBL_QUICK_CREATE', $MODULE_NAME)}" href="#">
						<span class="fas fa-plus" aria-hidden="true"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right commonActionsButtonDropDown">
						<li>
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">
										<strong>{\App\Language::translate('LBL_QUICK_CREATE', $MODULE_NAME)}</strong>
									</h4>
								</div>
								<div class="card-body px-0">
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
{/strip}
