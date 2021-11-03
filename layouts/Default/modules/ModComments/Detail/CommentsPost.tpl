{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-ModComments-Detail-CommentsPost -->
	{assign var="IS_CREATABLE" value=$COMMENT->getModuleModel()->isPermitted('CreateView')}
	<div class="js-post-container{if !$SUB_COMMENT} row{/if}">
		<div class="col-md-12 {if $SUB_COMMENT} pr-0{/if}">
			<div class="js-post-container_body border-bottom pb-2">
				<div class="p-1 u-border-none">
					<div class="d-flex">
						<div class="col px-0 ml-5 d-flex justify-content-between">
							<span class="small"> {$COMMENT->getCommentatorName()}</span>
							{assign var="CHILDREN_COUNT" value=$COMMENT->getRawValue('children_count')}
							<div>
								<button type="button" class="btn btn-sm text-info js-show-replies u-text-ellipsis mr-0 p-0 pl-1 {if !$CHILDREN_COUNT} d-none{/if}"
									data-url="{$COMMENT->getChildrenUrl()}"
									title="{$CHILDREN_COUNT}&nbsp;{if $CHILDREN_COUNT eq 1}{\App\Language::translate('LBL_REPLY_SINGLE',$MODULE_NAME)}{else}{\App\Language::translate('LBL_REPLIES',$MODULE_NAME)}{/if}"
									data-js="click">
									<span class="js-child-comments-count">{$CHILDREN_COUNT}</span>
									&nbsp;
									<span class="fas fa-share"></span>
								</button>
								{if $IS_CREATABLE}
									<button type="button" class="btn btn-sm text-success js-post-reply u-text-ellipsis mr-0 p-0 pl-1"
										title="{\App\Language::translate('LBL_REPLY',$MODULE_NAME)}"
										data-js="click">
										&nbsp;
										<span class="fas fa-share"></span>
									</button>
								{/if}
							</div>
						</div>
					</div>
					<div class="d-flex">
						<div class="avatar u-fs-2x px-2 d-flex justify-content-center align-items-end">
							<span class="fas fa-user"></span>
						</div>
						<div class="col py-1 px-2 pr-0 u-bg-gray">
							<div>
								{$COMMENT->getDisplayValue('commentcontent')}
							</div>
							<div class="u-fs-xs text-right">
								{$COMMENT->get('createdtime')}
							</div>
						</div>
					</div>
				</div>
				{if $IS_CREATABLE}
					<div class="js-reply-comment-block d-none">
						{include file=\App\Resources::templatePath('Detail/CommentAdd.tpl', $MODULE_NAME) SOURCE_ID=$COMMENT->getRawValue('related_to') EDIT_MODE=true PARENT_ID=$COMMENT->getId()}
					</div>
				{/if}
			</div>
		</div>
	</div>
	<!-- /tpl-ModComments-Detail-CommentsPost -->
{/strip}
