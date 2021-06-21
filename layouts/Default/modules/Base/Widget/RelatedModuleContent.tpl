{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Widget-RelatedModuleContent -->
	<table class="table table-bordered">
		<thead class="thead-light">
			{foreach from=$WIDGET->getFields() item=HEADER_NAME}
				<th>{\App\Purifier::encodeHTML($HEADER_NAME)}</th>
			{/foreach}
		</thead>
		<tbody>
			{foreach from=$WIDGET->getEntries() item=RECORD_MODEL}
				<tr class="js-row" data-url="{$RECORD_MODEL->getDetailViewUrl()}">
					{foreach from=$WIDGET->getFields() item=HEADER_FIELD_NAME}
						<td>{$RECORD_MODEL->getDisplayValue($HEADER_FIELD_NAME)}</td>
					{/foreach}
				</tr>
			{/foreach}
		</tbody>
	</table>
<!-- /tpl-Base-Widget-RelatedModuleContent -->
{/strip}
