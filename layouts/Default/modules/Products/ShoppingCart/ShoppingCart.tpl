{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    {assign var=CSS_CARD_CONTAINER value="box-shadow border rounded shopping-cart p-0"}
    {assign var=CSS_CARD_CONTENT value="row no-gutters p-3 m-0 product-border-b"}
	<div class="tpl-Products-ShoppingCart-ShoppingCart product-container js-products-container" data-check-stock-levels="{$CHECK_STOCK_LEVELS}" data-js="container">
		<div class="row no-gutters">
			<div class="col-12 col-lg-9">
				<div class="{$CSS_CARD_CONTAINER}">
					<div class="{$CSS_CARD_CONTENT} mb-4">
						<div class="col-6 d-flex align-items-center">
							<h6 class="mb-0 text-truncate"><span class="fas fa-shopping-cart mr-2"></span>{\App\Language::translate('LBL_SHIPPING_CART', $MODULE_NAME)}</h6>
						</div>
						<div class="col-6 pl-3 d-flex align-items-center justify-content-end fs-80">
							{include file=\App\Resources::templatePath("Pagination.tpl", $MODULE_NAME)}
						</div>
					</div>
					{assign var="COUNT_OF_RECORDS" value=count($RECORDS)}
					{assign var="COUNTER" value=1}
					{foreach name=foo item=RECORD key=CRM_ID from=$RECORDS}
						{include file=\App\Resources::templatePath("ShoppingCart/Product.tpl", $MODULE_NAME)}
						{assign var="COUNTER" value=$COUNTER + 1}
					{/foreach}
				</div>
				<form class="js-form-address" data-js="container">
					<div class="{$CSS_CARD_CONTAINER} my-3">
						<div class="{$CSS_CARD_CONTENT}">
							<h6 class="col-12 mb-4"><span class="fas fa-address-card mr-2"></span>{\App\Language::translate('LBL_ADDRESS', $MODULE_NAME)}</h6>
							{if !empty($ADDRESSES)}
								{if empty($ADDRESSES['data'])}
									<div class="alert alert-warning w-100" role="alert">
										{App\Language::translate('LBL_ADDRESS_IS_EMPTY', $MODULE_NAME)}
									</div>
								{else}
									<select class="select2 js-select-address form-control-sm" data-js="change">
										{foreach from=$ADDRESSES['data'] key=TYPE_ADDRESS item=ADDRESS}
											<option value={$TYPE_ADDRESS}>{$ADDRESS['addresslevel5'|cat:$TYPE_ADDRESS]}-{$ADDRESS['addresslevel8'|cat:$TYPE_ADDRESS]}-{$ADDRESS['buildingnumber'|cat:$TYPE_ADDRESS]}</option>
										{/foreach}
									</select>
								{/if}
							{/if}
						</div>
						<input type="hidden" class="js-addresses" value="{App\Purifier::encodeHTML(App\Json::encode($ADDRESSES))}">
						{if !(!empty($ADDRESSES) && empty($ADDRESSES['drequiredata']))}
							<div class="px-2 px-sm-4">
							{assign var=REQUIRED_FIELDS value=['addresslevel5', 'addresslevel7', 'addresslevel8', 'buildingnumber']}
									{foreach from=YF\Modules\Products\Model\CartView::ADDRESS_FIELDS item=FIELDNAME}
										<div class="row small">
											<label class="col-sm-2 col-form-label text-muted">
												{App\Language::translate('LBL_ADDRESS_'|cat:(strtoupper($FIELDNAME)), $MODULE_NAME)}
											</label>
											<div class="col-sm-10">
												<input type="text" name="{$FIELDNAME}"
												{if !empty($ADDRESSES)}
												readonly
												{elseif in_array($FIELDNAME, $REQUIRED_FIELDS)}
												data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"
												{/if} class="form-control{if !empty($ADDRESSES)}-plaintext{/if}" value=""
												>
											</div>
										</div>
									{/foreach}
							</div>
						{/if}
					</div>
					<div class="{$CSS_CARD_CONTAINER}">
						<div class="{$CSS_CARD_CONTENT}">
							<h6 class="mb-0"><span class="fas fa-dollar-sign mr-2"></span>{\App\Language::translate('LBL_METHOD_PAYMENTS', $MODULE_NAME)}</h6>
						</div>
						<div class="px-3">
							<div class="btn-group flex-wrap px-3 w-100" data-toggle="buttons">
								{foreach from=$PAYMENTS item=PAYMENT}
									<label class="btn btn-primary" data-toggle="collapse" data-target="#collapse-{$PAYMENT->getType()}">
										<input type="radio" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" class="js-method-payments" name="paymetsMethod" id="{$PAYMENT->getType()}" autocomplete="off">
										<span class="{$PAYMENT->getIcon()} mx-1"></span>
										{\App\Language::translate(strtoupper("LBL_"|cat:$PAYMENT->getType()), $MODULE_NAME)}
									</label>
								{/foreach}
							</div>
							<div id="payments-info-accordion" class="js-payments-info">
								{foreach from=$PAYMENTS item=PAYMENT}
									<div id="collapse-{$PAYMENT->getType()}" class="collapse js-{$PAYMENT->getType()}" data-parent="#payments-info-accordion">
										{include file=\App\Resources::templatePath("components/Payments/"|cat:{$PAYMENT->getType()}|cat:".tpl", $MODULE_NAME)}
									</div>
								{/foreach}
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-12 col-lg-3 pl-lg-3">
				{include file=\App\Resources::templatePath("components/Summary.tpl", $MODULE_NAME)}
			</div>
		</div>
	</div>
{/strip}
