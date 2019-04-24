{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="contentsDiv" id="detailView">
		<div class="widget_header row">
			<div class="col-sm-12">
				<div class="float-left">
					{include file=\App\Resources::templatePath("BreadCrumbs.tpl",$MODULE_NAME)}
				</div>
				<div class="contentHeader">
					<span class="float-right">
						{if YF\Modules\Base\Model\Module::isPermitted($MODULE_NAME, 'EditView')}
							<a href="{$RECORD->getEditViewUrl()}" class="btn btn-outline-success btn-sm"
							title="{\App\Language::translate('BTN_EDIT')}"><span
										class="fas fa-pencil-alt"></span> &nbsp; <strong>{\App\Language::translate('BTN_EDIT', $MODULE_NAME)}</strong> </a>
						{/if}
					</span>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		{foreach item=BLOCK from=$BLOCKS}
			{if isset($FIELDS[$BLOCK['id']])}
				{assign var=COUNTER value=0}
				{assign var=COUNT value=0}
				<div class="card col-sm-12 px-0 blockContainer my-2">
					<div class="card-header">{$BLOCK['name']}</div>
					<div class="col-md-12 px-0 card-body py-0 blockContent">
						<div class="col-sm-12 px-0 d-flex">
							{foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
							{if $COUNTER eq 2}
						</div>
						<div class="col-sm-12 px-0 d-flex">
							{assign var=COUNTER value=0}
							{/if}
							<div class="col-sm-12 col-md-6 px-0 borderTop d-flex">
								<div class="col-md-3 fieldLabel pl-2 form-control-plaintext">
									<label class="col-form-label">
										{if $FIELD->isMandatory() eq true}<span class="redColor">*</span>{/if}
										{$FIELD->get('label')}
									</label>
								</div>
								<div class="fieldValue col-md-9 form-control-plaintext">
									{$FIELD->getDisplayValue()}
								</div>
								{assign var=COUNTER value=$COUNTER+1}
							</div>
							{assign var=COUNT value=$COUNT+1}
							{/foreach}
							{if $COUNT % 2 == 1}
								<div class="col-sm-12 col-md-6 px-0 borderTop">
									<div class="col-md-3 fieldLabel pl-2"></div>
									<div class="fieldValue col-md-9 form-control-plaintext"></div>
								</div>
							{/if}
						</div>
					</div>
				</div>
			{/if}
		{/foreach}
		{include file=\App\Resources::templatePath("Detail\Inventory.tpl",$MODULE_NAME)}
		{include file=\App\Resources::templatePath('CoreLog.tpl', $MODULE_NAME)}
	</div>
{/strip}
