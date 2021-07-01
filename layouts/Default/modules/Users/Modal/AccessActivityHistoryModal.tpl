{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Users-Modal-AccessActivityHistoryModal -->
<div class="modal-body">
	<table class="table table-bordered u-fs-13px">
		<thead>
			<tr class="listViewEntries">
				{foreach item=LISTVIEW_ENTRY_COLUMN from=$TABLE_COLUMNS}
					<th class="noWrap">
						{\App\Language::translate($LISTVIEW_ENTRY_COLUMN)}
					</th>
				{/foreach}
			</tr>
		</thead>
		<tbody>
			{foreach item=LISTVIEW_ENTRY from=$ACTIVITY_HISTORY}
				<tr class="listViewEntries">
					{foreach key=LISTVIEW_ENTRY_COLUMN_NAME item=LISTVIEW_ENTRY_COLUMN from=$TABLE_COLUMNS}
						<td class="noWrap">
							{if isset($LISTVIEW_ENTRY[$LISTVIEW_ENTRY_COLUMN_NAME]) && !empty($LISTVIEW_ENTRY[$LISTVIEW_ENTRY_COLUMN_NAME])}
								{$LISTVIEW_ENTRY[$LISTVIEW_ENTRY_COLUMN_NAME]}
							{else}
								--
							{/if}
						</td>
					{/foreach}
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>
<!-- /tpl-Users-Modal-AccessActivityHistoryModal -->
{/strip}
