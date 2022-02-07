{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Base-Dashboard-Widget-PreMiniList">
		<table class="table table-bordered">
			<thead class="thead-light">
				{foreach from=$WIDGET_MODEL->get('headers') item=HEADER_LABEL}
					<th>{$HEADER_LABEL}</th>
				{/foreach}
			</thead>
			<tbody>
				{foreach from=$WIDGET_MODEL->getRecords() item=RECORD_MODEL}
					<tr class="js-row" data-url="{$RECORD_MODEL->getDetailViewUrl()}">
						{foreach from=$WIDGET_MODEL->get('headers') key=HEADER_FIELD_NAME item=HEADER_LABEL}
							<td>{$RECORD_MODEL->getDisplayValue($HEADER_FIELD_NAME)}</td>
						{/foreach}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{/strip}
