{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Modal-Header -->
<div class="modal js-modal-data {if $LOCK_EXIT}static" data-keyboard="false{/if}" tabindex="-1" data-js="data" data-view="{$VIEW}" role="dialog">
	<div class="modal-dialog {$MODAL_SIZE}" role="document">
		<div class="modal-content">
			{foreach item=MODEL from=$MODAL_CSS}
				<link rel="{$MODEL->getRel()}" href="{$MODEL->getHref()}"/>
			{/foreach}
			{foreach item=MODEL from=$MODAL_JS}
				<script type="{$MODEL->getType()}" src="{$MODEL->getSrc()}"></script>
			{/foreach}
			<script type="text/javascript" {if $NONCE}nonce="{$NONCE}"{/if}>app.registerModalController();</script>
			<div class="modal-header">
				<h5 class="modal-title">
					{if $MODAL_ICON}
						<span class="{$MODAL_ICON} mr-2"></span>
					{/if}
					{$MODAL_TITLE}
				</h5>
				{if !$LOCK_EXIT}
					<button type="button" class="close" data-dismiss="modal"
							aria-label="{\App\Language::translate('LBL_CANCEL')}">
						<span aria-hidden="true">&times;</span>
					</button>
				{/if}
			</div>
<!-- /tpl-Base-Modal-Header -->
{/strip}
