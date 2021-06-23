{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-ModComments-CommentsContent -->
	{foreach from=$WIDGET->getEntries() item=COMMENT name=commentLoop}
		{include file=\App\Resources::templatePath('Detail/CommentsPost.tpl', $WIDGET->getRelatedModuleName()) MODULE_NAME=$WIDGET->getRelatedModuleName() SUB_COMMENT=false}
	{/foreach}
<!-- /tpl-ModComments-CommentsContent -->
{/strip}
