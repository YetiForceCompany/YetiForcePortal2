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
							<h5 class="mb-0"><span class="fas fa-check mr-2"></span>{\App\Language::translate('LBL_VIEW_PROCEEDTOCHECKOUT', $MODULE_NAME)}</h5>
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
							<h5 class="col-12 mb-0"><span class="fas fa-address-card mr-2"></span>{\App\Language::translate('LBL_ADDRESS', $MODULE_NAME)}</h5>
					</div>
					<div class="px-2 px-sm-4">
						{foreach from=YF\Modules\Products\Model\CartView::ADDRESS_FIELDS item=FIELDNAME}
							<div class="row small">
								<label class="col-sm-2 col-form-label text-muted">{$ADDRESSES['fields'][$FIELDNAME|cat:'a']}:</label>
								<div class="col-sm-10">
									{$SELECTED_ADDRESS[$FIELDNAME]}
								</div>
							</div>
						{/foreach}
					</div>
				</div>
				<div class="box-shadow border rounded shopping-cart p-0">
					<div class="row p-3 m-0 product-border-b mb-4">
						<div class="col-6 d-flex align-items-center">
								<h5 class="mb-0"><span class="fas fa-dollar-sign mr-2"></span>{\App\Language::translate('LBL_METHOD_PAYMENTS', $MODULE_NAME)}</h5>
						</div>
					</div>
					{if $SELECTED_PAYMENTS}
					<div class="px-2 px-sm-4 h5">
						<span class="badge badge-primary">
							<span class="{$SELECTED_PAYMENTS->getIcon()} mx-1"></span>
							{\App\Language::translate(strtoupper("LBL_"|cat:$SELECTED_PAYMENTS->getType()), $MODULE_NAME)}
						</span>
						</div>
						{include file=\App\Resources::templatePath("ShoppingCart/Payments/"|cat:{$SELECTED_PAYMENTS->getType()}|cat:".tpl", $MODULE_NAME) PAYMENT=$SELECTED_PAYMENTS}
					{/if}
				</div>
			</div>
			<div class="col-3">
				{include file=\App\Resources::templatePath("ProceedToCheckout/Summary.tpl", $MODULE_NAME)}
			</div>
		</div>
	</div>
{/strip}
