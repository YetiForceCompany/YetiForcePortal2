{strip}
    <div class="bodyHeader">
		<div class="leftSide col-xs-3">
			<div class="pull-left selectSearch hidden-phone">
				<div class="input-group globalSearchInput">
					<span class="input-group-btn">
						<select class="chzn-select form-control col-md-5" title="{FN::translate('LBL_SEARCH_MODULE', $MODULE_NAME)}" id="basicSearchModulesList" >
							<option value="" class="globalSearch_module_All" selected>{FN::translate('LBL_ALL_RECORDS', $MODULE_NAME)}</option>
							{foreach item=MODULE key=KEY from=$USER->getModulesList()}
								<option value="{$KEY}" class="globalSearch_module_{$KEY}">{FN::translate($MODULE,$MODULE_NAME)}</option>
							{/foreach}
						</select>
					</span>
					<input type="text" class="form-control" title="{FN::translate('LBL_GLOBAL_SEARCH',$MODULE_NAME)}" id="globalSearchValue" placeholder="{FN::translate('LBL_GLOBAL_SEARCH',$MODULE_NAME)}" results="10" />
					<span class="input-group-btn">
						<button class="btn btn-default" id="searchIcon" type="button">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span>
					<span class="input-group-btn">
						<button class="btn btn-default" id="globalSearch" title="{FN::translate('LBL_ADVANCE_SEARCH',$MODULE_NAME)}" type="button">
							<span class="glyphicon glyphicon-th-large"></span>
						</button>
					</span>
				</div>
			</div>	
		</div>
		<div class="rightSide">
			<div class="pull-right rightHeaderBtn hidden-phone">
				<div class="dropdown quickAction historyBtn">
					<a data-placement="left" data-toggle="dropdown" class="btn btn-default btn-sm showHistoryBtn" aria-expanded="false" href="#">
						<img src="{FN::fileTemplate("history.png",$MODULE_NAME)}" class="moduleIcon" title="{FN::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}" alt="{FN::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}">
					</a>
				</div>
			</div>
			<div class="pull-right rightHeaderBtn hidden-phone">
				<div class="remindersNotice quickAction">
					<a class="btn btn-default btn-sm" title="{FN::translate('LBL_CHAT',$MODULE_NAME)}" href="#">
						<span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
						<span class="badge hide">0</span>
					</a>
				</div>
			</div>
			<div class="pull-right rightHeaderBtn hidden-phone">
				<div class="headerLinksAJAXChat quickAction">
					<a class="btn btn-default btn-sm ChatIcon" title="{FN::translate('LBL_CHAT',$MODULE_NAME)}" href="#">
						<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
					</a>
				</div>
			</div>
			{if !empty($announcement)}
				<div class="pull-right rightHeaderBtn hidden-phone">
					<div class="quickAction">
						<a class="btn btn-default btn-sm" href="#">
							<img class='alignMiddle imgAnnouncement' src="{FN::fileTemplate('btnAnnounceOff.png',$MODULE_NAME)}" alt="{FN::translate('LBL_ANNOUNCEMENT',$MODULE_NAME)}" title="{FN::translate('LBL_ANNOUNCEMENT',$MODULE_NAME)}" id="announcementBtn" />
						</a>
					</div>
				</div>
			{/if}
			<div class="pull-right rightHeaderBtn hidden-phone">
				<div class="dropdown quickAction">
					<a id="menubar_quickCreate" class="dropdown-toggle btn btn-default btn-sm" data-toggle="dropdown" title="{FN::translate('LBL_QUICK_CREATE',$MODULE_NAME)}" href="#">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right commonActionsButtonDropDown">
						<li id="quickCreateModules">
							<div class="panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><strong>{FN::translate('LBL_QUICK_CREATE',$MODULE_NAME)}</strong></h4>
								</div>
								<div class="panel-body paddingLRZero">
									
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="pull-right rightHeaderBtn rightHeaderBtnMenu visible-phone">
				<div class="quickAction">
					<a class="btn btn-default btn-sm" href="#">
						<span aria-hidden="true" class="glyphicon glyphicon-menu-hamburger"></span>
					</a>
				</div>
			</div>
			<div class="pull-right rightHeaderBtn actionMenuBtn visible-phone">
				<div class="quickAction">
					<a class="btn btn-default btn-sm" href="#">
						<span aria-hidden="true" class="glyphicon glyphicon-tasks"></span>
					</a>
				</div>
			</div>
			<div class="pull-left rightHeaderBtn searchMenuBtn visible-phone">
				<div class="quickAction">
					<a class="btn btn-default btn-sm" href="#">
						<span aria-hidden="true" class="glyphicon glyphicon-search"></span>
					</a>
				</div>
			</div>
		</div>	
    </div>
{/strip}
