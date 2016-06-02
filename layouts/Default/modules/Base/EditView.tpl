{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	<div class="widget_header">
		<div class="row marginLRZero">
			<div class="col-xs-12 paddingLRZero">
				<div class="pull-left">
					{include file=FN::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
			</div>
		</div>
	</div>
	<hr>
	{foreach item=BLOCK from=$BLOCKS}
		<div class="panel panel-default col-xs-12 paddingLRZero">
			<div class="panel-heading">{$BLOCK['label']}</div>
			{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
				<div class='editFields col-sm-12 col-md-6 paddingLRZero'>
					<div class='editFieldName col-sm-6 col-md-6'>{$FIELD['label']}</div>
					<div class='editFieldValue col-sm-6 col-md-6'>
						<input class='form-control' type='text' name="{$FIELD['name']}" value='{$FIELD['defaultvalue']}'>
					</div>
				</div>
			{/foreach}
		</div>
	{/foreach}
{/strip}

