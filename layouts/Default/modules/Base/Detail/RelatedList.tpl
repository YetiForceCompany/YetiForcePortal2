{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Detail-RelatedList -->
	<form class="js-form-container row" data-js="container">
		<input type="hidden" name="module" value="{$MODULE_NAME}">
		<input type="hidden" name="action" value="RelatedListView">
		<input type="hidden" name="record" value="{$RECORD->getId()}">
		<input type="hidden" name="relationId" value="{$RELATION_MODEL->getRelation('relationId')}">
		<input type="hidden" name="relatedModuleName" value="{$RELATION_MODEL->getRelatedModuleName()}">
		{if $ACTIONS}
			<div class="col-sm-6 my-1">
				{foreach item=ACTION from=$ACTIONS}
					{\App\Layout\Action::getButton($ACTION)}
				{/foreach}
			</div>
		{/if}
		<div class="table-responsive col-sm-12">
			<table class="table listViewEntries js-list-view-table" data-js="dataTable">
				<thead>
					<tr class="listViewHeaders">
						<th></th>
						{foreach item=HEADER_LABEL key=HEADER_NAME from=$HEADERS}
							<th data-name="{$HEADER_NAME}" data-orderable="1" class="text-nowrap">{$HEADER_LABEL}</th>
						{/foreach}
					</tr>
					<tr class="listViewSearch">
						<td class="p-0 text-center">
							<button type="button" class="btn btn-light btn-sm mr-1 js-search-records" data-js="click"><span class="fas fa-search"></span></button>
							<button type="button" class="btn btn-light btn-sm js-clear-search" data-js="click"><span class="fas fa-times"></button>
						</td>
						{foreach item=HEADER_LABEL key=HEADER_NAME from=$HEADERS}
							<td>
								<input type="text" name="filters[{$HEADER_NAME}]" class="form-control js-filter-field">
							</td>
						{/foreach}
					</tr>
				</thead>
			</table>
		</div>
	</form>
	<!-- /tpl-Base-Detail-RelatedList -->
{/strip}
