{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="actionMenu" aria-hidden="true">
		<div class="row noMargin">
			<div class="dropdown quickAction historyBtn">
				<div class="labelContainer pull-left">
					{\YF\Core\Functions::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}
				</div>
				<div class="iconContainer pull-right">
					<a data-placement="left" data-toggle="dropdown" class="btn btn-default btn-sm showHistoryBtn" aria-expanded="false" href="#">
						<img class='alignMiddle popoverTooltip dropdown-toggle' src="{\YF\Core\Functions::fileTemplate("history.png",$MODULE_NAME)}" alt="{\YF\Core\Functions::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}" data-content="{\YF\Core\Functions::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}" />
					</a>
				</div>
			</div>
		</div>
		<div class='row noMargin'>
			<div class="dropdown quickAction">
				<div class='labelContainer pull-left'>
					{\YF\Core\Functions::translate('LBL_QUICK_CREATE',$MODULE_NAME)}
				</div>
				<div class='iconContainer pull-right'>
					<a id="mobile_menubar_quickCreate" class="dropdown-toggle btn btn-default" data-toggle="dropdown" title="{\YF\Core\Functions::translate('LBL_QUICK_CREATE',$MODULE_NAME)}" href="#">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right commonActionsButtonDropDown">
						<li>
							<div class="panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><strong>{\YF\Core\Functions::translate('LBL_QUICK_CREATE',$MODULE_NAME)}</strong></h4>
								</div>
								<div class="panel-body paddingLRZero">
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
{/strip}
