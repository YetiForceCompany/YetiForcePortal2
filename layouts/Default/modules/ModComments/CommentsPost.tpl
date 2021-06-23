{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-ModComments-CommentsPost -->
	<div class="{if $SUB_COMMENT}container pr-0{else}row{/if}">
		<div class="col-md-12 {if $SUB_COMMENT} pr-0{/if}">
			<div class="card u-border-none">
				<div class="card-header p-1 u-border-none">
					<div class="">
						<div class="float-left">
							<div class="avatar u-fs-2x mr-2">
								<span class="fas fa-user"></span>
							</div>
						</div>
						<div class="float-left">
							<div class="">{$COMMENT->getCommentatorName()}</div>
							<div class="u-fs-xs">{$COMMENT->getDisplayValue('createdtime')}</div>
						</div>
					</div>
				</div>
				<div class="card-body pt-1 pb-1 pr-0">
					<p>{$COMMENT->getDisplayValue('commentcontent')}</p>
				</div>
			</div>
			{foreach from=$COMMENT->getChildren() item=CHILD}
				{include file=\App\Resources::templatePath('CommentsPost.tpl', $MODULE_NAME) COMMENT=$CHILD SUB_COMMENT=true}
			{/foreach}
		</div>
	</div>
<!-- /tpl-ModComments-CommentsPost -->
{/strip}
