{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="tpl-Products-ProceedToCheckout-ProceedToCheckout product-container js-products-container"
	data-reference-id="{{$REFERENCE_ID}}"
	data-reference-module="{{$REFERENCE_MODULE}}"
	data-js="container">
		<div class="row">
			<div class="col-9">
				<div class="box-shadow border rounded shopping-cart p-0">
					<div class="row p-3 m-0 product-border-b mb-4">
						<div class="col-6 d-flex align-items-center">
							<h4 class="col-12 mb-4 font-weight-bold">{\App\Language::translate('LBL_VIEW_PROCEEDTOCHECKOUT', $MODULE_NAME)}</h4>
						</div>
						<div class="col-6 d-flex align-items-center justify-content-end">
							{include file=\App\Resources::templatePath("Pagination.tpl", $MODULE_NAME)}
						</div>
					</div>
					{assign var="COUNT_OF_RECORDS" value=count($RECORDS)}
					{assign var="COUNTER" value=1}
					{foreach item=RECORD key=CRM_ID from=$RECORDS}
						{include file=\App\Resources::templatePath("ProceedToCheckout/Product.tpl", $MODULE_NAME)}
						{assign var="COUNTER" value=$COUNTER + 1}
					{/foreach}
				</div>
				<div class="box-shadow border rounded shopping-cart p-0 my-2">
						<div class="row p-3 m-0 product-border-b">
							<span class="col-12 mb-4 font-weight-bold">{\App\Language::translate('LBL_ADDRESS', $MODULE_NAME)}</span>
						</div>
						{foreach from=YF\Modules\Products\Model\CartView::ADDRESS_FIELDS item=FIELDNAME}
							<div class="row mx-2">
								<label class="col-sm-2 col-form-label">{$ADDRESSES['fields'][$FIELDNAME|cat:'a']}:</label>
								<div class="col-sm-10">
									{$SELECTED_ADDRESS[$FIELDNAME]}
								</div>
							</div>
						{/foreach}
					</div>
			</div>
			<div class="col-3">
				{include file=\App\Resources::templatePath("ProceedToCheckout/Summary.tpl", $MODULE_NAME)}
			</div>
		</div>
	</div>
{/strip}
