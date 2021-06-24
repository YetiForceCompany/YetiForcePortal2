{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-Widget-CommentAdd -->
	<div class="js-add-comment-block m-1" data-js="container">
		<form>
			<input type="hidden" name="action" value="Save"/>
			<input type="hidden" name="module" value="ModComments"/>
			<input type="hidden" name="related_to" value="{$SOURCE_ID}"/>
			<input type="hidden" name="view" value="Detail"/>
			<div class="input-group input-group-sm">
				<span class="input-group-prepend">
					<div class="input-group-text"><span class="fas fa-comments"></span></div>
				</span>
				<textarea name="commentcontent" rows="1"
					data-validation-engine="validate[required]"
					class="u-resize-v form-control"
					title="{\App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE', $MODULE_NAME)}"
					placeholder="{\App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE', $MODULE_NAME)}"></textarea>
				<div class="input-group-append">
					<button class="btn btn-success" type="submit" title="{\App\Language::translate('LBL_ADD', $MODULE_NAME)}">
						<span class="fas fa-plus"></span>
					</button>
				</div>
			</div>
		</form>
	</div>
<!-- /tpl-Base-Widget-CommentAdd -->
{/strip}
