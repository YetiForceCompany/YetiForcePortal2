{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
    <div class="bodyHeader">
		<div class="leftSide col-xs-3">
		</div>
		<div class="rightSide">
			<div class="pull-right rightHeaderBtn hidden-phone">
				<div class="dropdown quickAction historyBtn">
					<a href="index.php?module=Users&action=Logout" class="loadPage btn btn-danger">
						<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
					</a>
				</div>
			</div>
			<div class="pull-right rightHeaderBtn hidden-phone">
				<div class="dropdown quickAction historyBtn">
					<a data-placement="left" data-toggle="dropdown" class="btn btn-default btn-sm showHistoryBtn" aria-expanded="false" href="#">
						<img src="{\YF\Core\Functions::fileTemplate("history.png",$MODULE_NAME)}" class="userIcon" title="{\YF\Core\Functions::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}" alt="{\YF\Core\Functions::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}">
					</a>
				</div>
			</div>
			<div class="pull-right rightHeaderBtn hidden-phone">
				{*<div class="dropdown quickAction">
				<a id="menubar_quickCreate" class="dropdown-toggle btn btn-default btn-sm" data-toggle="dropdown" title="{\YF\Core\Functions::translate('LBL_QUICK_CREATE',$MODULE_NAME)}" href="#">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				</a>
				<ul class="dropdown-menu dropdown-menu-right commonActionsButtonDropDown">
				<li id="quickCreateModules">
				<div class="panel-default">
				<div class="panel-heading">
				<h4 class="panel-title"><strong>{\YF\Core\Functions::translate('LBL_QUICK_CREATE',$MODULE_NAME)}</strong></h4>
				</div>
				<div class="panel-body paddingLRZero">

				</div>
				</div>
				</li>
				</ul>
				</div>*}
			</div>
		</div>
    </div>
{/strip}
