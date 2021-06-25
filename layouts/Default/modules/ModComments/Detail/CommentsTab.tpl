{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-ModComments-Detail-CommentsContent -->
<div class="js-widget-container card mt-2 u-border-none" data-js="container" data-type="Comments" data-url="{$URL}">
	{if \YF\Modules\Base\Model\Module::isPermittedByModule($MODULE_NAME, 'CreateView')}
		<div class="js-add-comment-block">
			{include file=\App\Resources::templatePath('Detail/CommentAdd.tpl', $MODULE_NAME) SOURCE_ID=$SOURCE_ID}
		</div>
	{/if}
	<div class="js-widget-container_content card-body p-1" data-js="container"></div>
</div>
{foreach item=SCRIPT from=$SCRIPTS}
	<script src="{$SCRIPT->getSrc()}"></script>
{/foreach}
<!-- /tpl-ModComments-Detail-CommentsContent -->
{/strip}
