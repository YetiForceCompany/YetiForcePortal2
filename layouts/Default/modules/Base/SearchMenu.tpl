{strip}
	<div class="searchMenu visible-phone">
		<div class="input-group">
			<span class="input-group-btn">
				<select class="chzn-select form-control col-md-5" title="{\YF\Core\Functions::translate('LBL_SEARCH_MODULE', $MODULE_NAME)}" id="basicSearchModulesList" >
					<option value="" class="globalSearch_module_All">{\YF\Core\Functions::translate('LBL_ALL_RECORDS', $MODULE_NAME)}</option>
				</select>
			</span>
		</div>
		<div class="input-group">
			<input type="text" class="form-control" title="{\YF\Core\Functions::translate('LBL_GLOBAL_SEARCH',$MODULE_NAME)}" id="globalMobileSearchValue" placeholder="{\YF\Core\Functions::translate('LBL_GLOBAL_SEARCH',$MODULE_NAME)}" results="10" />
			<div class="input-group-btn">
				<div class="pull-right">
					<button class="btn btn-default" id="searchMobileIcon" type="button">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>
			</div>
		</div>
		<div class="pull-left">
			<button class="btn btn-default" id="globalSearch" title="{\YF\Core\Functions::translate('LBL_ADVANCE_SEARCH',$MODULE_NAME)}" type="button">
				<span class="glyphicon glyphicon-th-large"></span>
			</button>
		</div>
	</div>
{/strip}
