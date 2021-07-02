{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
  {assign var=CSS_CARD_CONTAINER value="box-shadow border rounded shopping-cart p-0"}
    {assign var=CSS_CARD_CONTENT value="row no-gutters p-3 m-0 product-border-b"}
	<div class="tpl-Products-ProceedToCheckout-ProceedToCheckout product-container js-products-container"
	data-reference-id="{{$REFERENCE_ID}}"
	data-reference-module="{{$REFERENCE_MODULE}}"
	data-js="container">
		<div class="row no-gutters">
			<div class="col-12 col-lg-9">
				<div class="{$CSS_CARD_CONTAINER}">
					<div class="{$CSS_CARD_CONTENT} mb-4">
						<div class="col-6 d-flex align-items-center">
							<h4 class="mb-0"><span class="fas fa-check mr-2"></span>{\App\Language::translate('LBL_VIEW_PROCEEDTOCHECKOUT', $MODULE_NAME)}</h4>
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
				<div class="{$CSS_CARD_CONTAINER} my-3">
					<div class="{$CSS_CARD_CONTENT}">
						<h4 class="col-12 mb-0"><span class="fas fa-address-card mr-2"></span>{\App\Language::translate('LBL_ADDRESS', $MODULE_NAME)}</h4>
					</div>
					<div class="px-3">
						{foreach from=YF\Modules\Products\Model\CartView::ADDRESS_FIELDS item=FIELDNAME}
							{if isset($ADDRESSES['fields'], $ADDRESSES['fields'][$FIELDNAME|cat:'a'])}
								<div class="row small">
									<label class="col-sm-2 col-form-label text-muted">{$ADDRESSES['fields'][$FIELDNAME|cat:'a']}:</label>
									<div class="col-sm-10">
										{$SELECTED_ADDRESS[$FIELDNAME]}
									</div>
								</div>
							{/if}
						{/foreach}
					</div>
				</div>
				<div class="{$CSS_CARD_CONTAINER} my-3">
					<div class="{$CSS_CARD_CONTENT}">
						<div class="col-6 d-flex align-items-center">
							<h4 class="mb-0"><span class="fas fa-exclamation-circle mr-2"></span>{\App\Language::translate('LBL_ATTENTION', $MODULE_NAME)}</h4>
						</div>
					</div>
					<div class="px-3 pt-3 pb-2">
						{$ATTENTION}
					</div>
				</div>
				<div class="{$CSS_CARD_CONTAINER}">
					<div class="{$CSS_CARD_CONTENT}">
						<div class="col-6 d-flex align-items-center">
							<h4 class="mb-0"><span class="fas fa-dollar-sign mr-2"></span>{\App\Language::translate('LBL_METHOD_PAYMENTS', $MODULE_NAME)}</h4>
						</div>
					</div>
					{if $SELECTED_PAYMENTS}
					<div class="px-3 pt-3 pb-2">
						<div class="h6">
							<span class="badge badge-primary">
								<span class="{$SELECTED_PAYMENTS->getIcon()} mx-1"></span>
								{\App\Language::translate(strtoupper("LBL_"|cat:$SELECTED_PAYMENTS->getType()), $MODULE_NAME)}
							</span>
						</div>
						{include file=\App\Resources::templatePath("components/Payments/"|cat:{$SELECTED_PAYMENTS->getType()}|cat:".tpl", $MODULE_NAME) PAYMENT=$SELECTED_PAYMENTS}
					</div>
					{/if}
				</div>
			</div>
			<div class="col-12 mt-3 mt-lg-0 col-lg-3 pl-lg-3">
				{include file=\App\Resources::templatePath("components/Summary.tpl", $MODULE_NAME)}
			</div>
		</div>
	</div>
{/strip}
