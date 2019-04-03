{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="searchMenu visible-phone">
		<div class="input-group">
			<span class="input-group-btn">
				<select class="chzn-select form-control col-md-5"
						title="{\App\Language::translate('LBL_SEARCH_MODULE', $MODULE_NAME)}"
						id="basicSearchModulesList">
					<option value=""
							class="globalSearch_module_All">{\App\Language::translate('LBL_ALL_RECORDS', $MODULE_NAME)}</option>
				</select>
			</span>
		</div>
		<div class="input-group">
			<input type="text" class="form-control"
				   title="{\App\Language::translate('LBL_GLOBAL_SEARCH',$MODULE_NAME)}"
				   id="globalMobileSearchValue"
				   placeholder="{\App\Language::translate('LBL_GLOBAL_SEARCH',$MODULE_NAME)}" results="10"/>
			<div class="input-group-btn">
				<div class="float-right">
					<button class="btn btn-default" id="searchMobileIcon" type="button">
						<span class="fas fa-search"></span>
					</button>
				</div>
			</div>
		</div>
		<div class="float-left">
			<button class="btn btn-default" id="globalSearch"
					title="{\App\Language::translate('LBL_ADVANCE_SEARCH',$MODULE_NAME)}" type="button">
				<span class="fas fa-th-large"></span>
			</button>
		</div>
	</div>
{/strip}
