{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<div class="tpl-Modal-Header modal js-modal-data " tabindex="-1" data-js="data" data-view="{$VIEW}"
	 role="dialog">
	<div class="modal-dialog {$MODAL_SIZE}" role="document">
		<div class="modal-content">
			{foreach item=MODEL from=$MODAL_CSS}
				<link rel="{$MODEL->getRel()}" href="{$MODEL->getHref()}"/>
			{/foreach}
			{foreach item=MODEL from=$MODAL_JS}
				<script type="{$MODEL->getType()}" src="{$MODEL->getSrc()}"></script>
			{/foreach}
			<script type="text/javascript">app.registerModalController();</script>
			<div class="modal-header">
				<h5 class="modal-title">
					{if $MODAL_ICON}
						<span class="{$MODAL_ICON} mr-2"></span>
					{/if}
					{$MODAL_TITLE}
				</h5>
					<button type="button" class="close" data-dismiss="modal"
							aria-label="{\App\Language::translate('LBL_CANCEL')}">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			{/strip}
