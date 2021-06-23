{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-ModComments-Detail-Comments -->
	<div class="mt-2">
		{foreach from=$ENTRIES item=COMMENT name=commentLoop}
			{include file=\App\Resources::templatePath('Detail/CommentsPost.tpl', 'ModComments') MODULE_NAME='ModComments' SUB_COMMENT=false}
		{/foreach}
	</div>
<!-- /tpl-ModComments-Detail-Comments -->
{/strip}
