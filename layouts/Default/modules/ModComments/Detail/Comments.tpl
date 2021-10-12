{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-ModComments-Detail-Comments -->
	{foreach from=$ENTRIES item=COMMENT name=commentLoop}
		{include file=\App\Resources::templatePath('Detail/CommentsPost.tpl', 'ModComments') MODULE_NAME='ModComments'}
	{/foreach}
	<!-- /tpl-ModComments-Detail-Comments -->
{/strip}
