{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-ModComments-Detail-CommentsPost -->
	{assign var="IS_CREATABLE" value=$COMMENT->getModuleModel()->isPermitted('CreateView')}
	<div class="js-post-container{if !$SUB_COMMENT} row{/if}">
		<div class="col-md-12 {if $SUB_COMMENT} pr-0{/if}">
			<div class="card u-border-none js-post-container_body">
				<div class="card-header p-1 u-border-none">
					<div class="">
						<div class="float-left">
							<div class="avatar u-fs-2x mr-2">
								<span class="fas fa-user"></span>
							</div>
						</div>
						<div class="float-left">
							<div class="">{$COMMENT->getCommentatorName()}</div>
							<div class="u-fs-xs">
								{$COMMENT->getDisplayValue('createdtime')}
								{if $IS_CREATABLE}
									<button type="button" class="btn btn-sm text-success js-post-reply u-text-ellipsis mr-0 p-0 pl-1"
											title="{\App\Language::translate('LBL_REPLY',$MODULE_NAME)}"
											data-js="click">
										&nbsp;
										<span class="fas fa-share"></span>
									</button>
								{/if}
								{assign var="CHILDREN_COUNT" value=$COMMENT->getRawValue('children_count')}
								<button type="button" class="btn btn-sm text-info js-show-replies u-text-ellipsis mr-0 p-0 pl-1 {if !$CHILDREN_COUNT} d-none{/if}"
										data-url="{$COMMENT->getChildrenUrl()}"
										title="{$CHILDREN_COUNT}&nbsp;{if $CHILDREN_COUNT eq 1}{\App\Language::translate('LBL_REPLY',$MODULE_NAME)}{else}{\App\Language::translate('LBL_REPLIES',$MODULE_NAME)}{/if}"
										data-js="click">
									<span class="js-child-comments-count">{$CHILDREN_COUNT}</span>
									&nbsp;
									<span class="fas fa-share"></span>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body pt-1 pb-1 pr-0">
					<p>{$COMMENT->getDisplayValue('commentcontent')}</p>
				</div>
				{if $IS_CREATABLE}
					<div class="js-reply-comment-block d-none">
						{include file=\App\Resources::templatePath('Widget/CommentAdd.tpl', $MODULE_NAME) SOURCE_ID=$COMMENT->getRawValue('related_to') EDIT_MODE=true PARENT_ID=$COMMENT->getId()}
					</div>
				{/if}
			</div>
		</div>
	</div>
<!-- /tpl-ModComments-Detail-CommentsPost -->
{/strip}
