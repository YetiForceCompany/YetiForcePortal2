{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="modal-body tpl-RecordList-RecordList">
		<input type="hidden" class="listEntriesPerPage" id="listEntriesPerPage"
			   value="{\App\Purifier::encodeHTML(\App\Json::encode(\App\Config::$listEntriesPerPage))}"">
		<div class="row listViewContents">
			<div class="table-responsive col-sm-12">
				<table class="table listViewEntries">
					<thead>
						<tr class="listViewHeaders">
							{foreach item=HEADER from=$HEADERS}
								<th class="text-nowrap">{$HEADER}</th>
							{/foreach}
						</tr>
					</thead>
					<tbody>
						{foreach item=RECORD key=ID from=$RECORDS}
							<tr data-record="{$ID}" data-name="{\App\Purifier::encodeHtml($RECORD->getName())}">
								{foreach item=HEADER key=FIELD_NAME from=$HEADERS}
									<td>{$RECORD->get($FIELD_NAME)}</td>
								{/foreach}
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
{/strip}
