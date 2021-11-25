{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-ModComments-Detail-CommentAdd -->
	<div class="m-1" data-js="container">
		<form>
			<input type="hidden" name="action" value="Save" />
			<input type="hidden" name="module" value="ModComments" />
			<input type="hidden" name="related_to" value="{$SOURCE_ID}" />
			<input type="hidden" name="relationOperation" value="true" />
			<input type="hidden" name="sourceModule" value="{$SOURCE_MODULE}" />
			<input type="hidden" name="sourceRecord" value="{$SOURCE_ID}" />
			{if !empty($PARENT_ID)}
				<input type="hidden" name="parent_comments" value="{$PARENT_ID}" />
			{/if}
			<div class="input-group input-group-sm">
				<span class="input-group-prepend">
					<div class="input-group-text"><span class="fas fa-comments"></span></div>
				</span>
				<div name="commentcontent" contenteditable="true"
					class="u-resize-v form-control js-comment-content"
					title="{\App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE', $MODULE_NAME)}"
					placeholder="{\App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE', $MODULE_NAME)}"></div>
				<div class="input-group-append">
					<button class="btn btn-success" type="submit" title="{\App\Language::translate('LBL_ADD', $MODULE_NAME)}">
						<span class="fas fa-plus"></span>
					</button>
				</div>
				{if !empty($EDIT_MODE)}
					<div class="input-group-append js-post-cancel">
						<button class="btn btn-danger" type="button" title="{\App\Language::translate('BTN_CANCEL', $MODULE_NAME)}">
							{\App\Language::translate('BTN_CANCEL', $MODULE_NAME)}
						</button>
					</div>
				{/if}
			</div>
		</form>
	</div>
	<!-- /tpl-Base-Widget-CommentAdd -->
{/strip}
