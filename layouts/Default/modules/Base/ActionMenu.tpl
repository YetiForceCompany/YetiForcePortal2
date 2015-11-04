{strip}
<div class="actionMenu" aria-hidden="true">
	<div class="row noMargin">
		<div class="dropdown quickAction historyBtn">
			<div class="labelContainer pull-left">
				{FN::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}
			</div>						
			<div class="iconContainer pull-right">
				<a data-placement="left" data-toggle="dropdown" class="btn btn-default btn-sm showHistoryBtn" aria-expanded="false" href="#">
					<img class='alignMiddle popoverTooltip dropdown-toggle' src="{FN::fileTemplate("history.png",$MODULE_NAME)}" alt="{FN::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}" data-content="{FN::translate('LBL_PAGES_HISTORY',$MODULE_NAME)}" />
				</a>
			</div>
		</div>
	</div>
	<div class="row noMargin">
		<div class="remindersNotice quickAction">
			<div class="labelContainer pull-left">
				{FN::translate('LBL_CHAT',$MODULE_NAME)}
			</div>	
			<div class="iconContainer pull-right">
				<a class="btn btn-default" title="{FN::translate('LBL_CHAT',$MODULE_NAME)}" href="#">
					<span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
					<span class="badge hide">0</span>
				</a>
			</div>
		</div>
	</div>
	<div class="row noMargin">
		<div class="headerLinksAJAXChat quickAction">
			<div class="labelContainer pull-left">
				{FN::translate('LBL_CHAT',$MODULE_NAME)}
			</div>
			<div class="iconContainer pull-right">
				<a class="btn btn-default ChatIcon" title="{FN::translate('LBL_CHAT',$MODULE_NAME)}" href="#">
					<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
				</a>
			</div>
		</div>
	</div>
	{if !empty($announcement)}
		<div class="row noMargin">
			<div class="quickAction">
				<div class="labelContainer pull-left">
					{FN::translate('LBL_ANNOUNCEMENT',$MODULE_NAME)}
				</div>
				<div class='iconContainer pull-right'>
					<a class="btn btn-default" href="#">
						<img class='alignMiddle imgAnnouncement' src="{*vimage_path('btnAnnounceOff.png')*}" alt="{FN::translate('LBL_ANNOUNCEMENT',$MODULE_NAME)}" title="{FN::translate('LBL_ANNOUNCEMENT',$MODULE_NAME)}" id="announcementBtn" />
					</a>
				</div>
			</div>
		</div>
	{/if}
	<div class='row noMargin'>
		<div class="dropdown quickAction">
			<div class='labelContainer pull-left'>
				{FN::translate('LBL_QUICK_CREATE',$MODULE_NAME)}
			</div>
			<div class='iconContainer pull-right'>
				<a id="mobile_menubar_quickCreate" class="dropdown-toggle btn btn-default" data-toggle="dropdown" title="{FN::translate('LBL_QUICK_CREATE',$MODULE_NAME)}" href="#">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				</a>
				<ul class="dropdown-menu dropdown-menu-right commonActionsButtonDropDown">
					<li id="quickCreateModules">
						<div class="panel-default">
							<div class="panel-heading">
								<h4 class="panel-title"><strong>{FN::translate('LBL_QUICK_CREATE',$MODULE_NAME)}</strong></h4>
							</div>
							<div class="panel-body paddingLRZero">
								{assign var='count' value=0}
								{*foreach key=NAME item=MODULEMODEL from=Vtiger_Module_Model::getQuickCreateModules(true)}
									{assign var='quickCreateModule' value=$MODULEMODEL->isQuickCreateSupported()}
									{assign var='singularLabel' value=$MODULEMODEL->getSingularLabelKey()}
									{if $singularLabel == 'SINGLE_Calendar'}
										{assign var='singularLabel' value='LBL_EVENT_OR_TASK'}
									{/if}	
									{if $quickCreateModule == '1'}
										{if $count % 3 == 0}
											<div class="rows">
											{/if}
											<div class="col-xs-4{if $count % 3 != 2} paddingRightZero{/if}">
												<a class="quickCreateModule list-group-item" data-name="{$NAME}" data-url="{$MODULEMODEL->getQuickCreateUrl()}" href="javascript:void(0)" title="{vtranslate($singularLabel,$NAME)}">
												    <span>{vtranslate($singularLabel,$NAME)}</span>
												</a>
											</div>
											{if $count % 3 == 2}
											</div>
										{/if}
										{assign var='count' value=$count+1}
									{/if}
								{/foreach*}
								{*if $count % 3 == 2}
									</div>
								{/if*}
							</div>
						</div>
					</li>
				</ul>
			</div>						
		</div>
	</div>
</div>
{/strip}
