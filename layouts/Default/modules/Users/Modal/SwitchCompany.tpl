{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Users-Modal-SwitchCompany -->
	<div class="modal-body">
		<select class="select2 form-control" id="companyId">
			{foreach item=ITEM key=KEY from=$COMPANIES}
				<option value="{$KEY}" {if $USER->get('companyId') eq $KEY}selected{/if}>{$ITEM['name']}</option>
			{/foreach}
		</select>
	</div>
	<!-- /tpl-Users-Modal-SwitchCompany -->
{/strip}
