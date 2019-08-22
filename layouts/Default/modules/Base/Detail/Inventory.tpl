{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	{if !empty($INVENTORY_FIELDS)}
		<table class="table table-bordered">
			<thead>
				<tr>
					{foreach from=$INVENTORY_FIELDS item=INVENTORY_FIELD_MODEL}
						<th>{$INVENTORY_FIELD_MODEL->getLabel()}</th>
					{/foreach}
				</tr>
			</thead>
			<tbody>
				{foreach from=$RECORD->getInventoryData() item=INVENTORY_ITEMS}
					<tr>
						{foreach from=$INVENTORY_FIELDS item=INVENTORY_FIELD_MODEL}
							<td>{$INVENTORY_FIELD_MODEL->getDisplayValue($INVENTORY_ITEMS[$INVENTORY_FIELD_MODEL->get('columnname')])}</td>
						{/foreach}
					</tr>
				{/foreach}
			</tbody>
			<tfoot>
				<tr>
					{foreach from=$INVENTORY_FIELDS item=INVENTORY_FIELD_MODEL}
						<td>
							{if $INVENTORY_FIELD_MODEL->get('isSummary')}
								{$INVENTORY_FIELD_MODEL->getDisplayValue($SUMMARY_INVENTORY[$INVENTORY_FIELD_MODEL->get('columnname')])}
							{/if}
						</td>
					{/foreach}
				</tr>
			</tfoot>
		</table>
	{/if}
{/strip}
