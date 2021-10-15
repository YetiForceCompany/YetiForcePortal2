{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!--tpl-Products-ShoppingCart-Product-->
	<div class="d-flex flex-nowrap m-0 p-2 box-shadow product-shopping-cart {if $COUNTER < $COUNT_OF_RECORDS}product-border-b {/if}js-cart-item"
		data-id="{\App\Purifier::encodeHTML($CRM_ID)}"
		data-qtyinstock="{$RECORD->getRawValue('qtyinstock')}"
		data-price-netto="{$RECORD->getRawValue('unit_price')}"
		data-price-gross="{$RECORD->getRawValue('unit_gross')}">
		<div class="d-flex pr-2 product-border-r">
			<div class="product-shopping-cart-image-contener align-items-center m-auto">
				{assign var="IMAGES" value=$RECORD->get('imagename')}
				{if empty($IMAGES) }
					<div class="product-no-image">
						<span class="fa-stack fa-2x product-no-image">
							<i class="fas fa-camera fa-stack-1x"></i>
							<i class="fas fa-ban fa-stack-2x"></i>
						</span>
					</div>
				{else}
					<div class="product-no-image m-auto" title="{$RECORD->getDisplayValue('productname')}">
						{$RECORD->getModuleModel()->getFieldModel('imagename')->getImg($IMAGES[0], 'c-max-h-fill')}
					</div>
				{/if}
			</div>
		</div>
		<div class="no-gutters px-2 row u-min-w-0 w-100">
			<div class="col-12 col-md-auto d-flex flex-nowrap flex-md-column justify-content-between u-min-w-0">
				<div class="d-flex flex-column u-min-w-0">
					<h6 class="text-truncate">
						<a href="index.php?module=Products&view=Preview&record={$RECORD->getId()}">{$RECORD->getDisplayValue('productname')}</a>
					</h6>
					<div class="fs-80 text-muted text-truncate">EAN: {$RECORD->getDisplayValue('ean')}</div>
					<div class="alert alert-warning d-none js-no-such-quantity" role="alert">
						{\App\Language::translate('LBL_NO_SUCH_QUANTITY', $MODULE_NAME)}
						{\App\Language::translate('LBL_MAXIMUM_AMOUNT', $MODULE_NAME)}
						<span class="pl-2 js-maximum-quantity">{App\Fields\Integer::formatToDisplay($RECORD->getRawValue('qtyinstock'))}</span>
					</div>
				</div>
				{if !$READONLY}
					<div>
						<button type="button" class="btn btn-sm btn-danger js-remove-from-cart" data-js="click">
							<i class="fas fa-trash"></i>
							<span class="d-none d-md-inline ml-1">
								{\App\Language::translate('LBL_REMOVE_FROM_CART', $MODULE_NAME)}
							</span>
						</button>
					</div>
				{/if}
			</div>
			<div class="col-12 col-md-auto d-flex flex-md-column justify-content-between ml-auto px-2">
				<div class="d-flex justify-content-end">
					<div class="input-group input-group-sm c-cart-quantity d-flex align-items-center">
						{if !$READONLY}
							<div class="input-group-prepend">
								<button class="btn btn-sm btn-secondary c-cart-quantity__btn-circle js-amount-dec mr-2 mb-0" type="button">-</button>
							</div>
							<input class="form-control js-amount c-cart-quantity__input border text-center" type="text" value="{if $RECORD->has('amountInShoppingCart')}{$RECORD->getDisplayValue('amountInShoppingCart')}{else}1{/if}">
							<div class="input-group-append">
								<button class="btn btn-sm btn-secondary c-cart-quantity__btn-circle js-amount-inc ml-2 mb-0" type="button">+</button>
							</div>
						{else}
							<input class="form-control c-cart-quantity__input border text-center js-amount" disabled type="text" value="{if $RECORD->has('amountInShoppingCart')}{$RECORD->getDisplayValue('amountInShoppingCart')}{else}1{/if}">
						{/if}
					</div>
				</div>
				<div class="text-secondary text-nowrap ml-2 u-min-w-0">
					{if !$READONLY}
						<div class="d-flex flex-wrap text-right fs-80">
							<span class="text-nowrap font-weight-bold mr-2">{\App\Language::translate('LBL_NET_PRICE', $MODULE_NAME)}:</span>
							<span class="text-nowrap">{$RECORD->getDisplayValue('unit_price')}</span>
						</div>
						<div class="d-flex flex-wrap text-right fs-80">
							<span class="text-nowrap font-weight-bold mr-2">{\App\Language::translate('LBL_GROSS_PRICE', $MODULE_NAME)}:</span>
							<span class="text-nowrap">{$RECORD->getDisplayValue('unit_gross')}</span>
						</div>
					{else}
						<div class="d-flex flex-wrap text-right fs-80">
							<span class="text-nowrap font-weight-bold mr-2">{\App\Language::translate('LBL_NET_PRICE', $MODULE_NAME)}:</span>
							<span class="text-nowrap">{\App\Fields\Currency::formatToDisplay($RECORD->getDisplayValue('priceNetto'))}</span>
						</div>
						<div class="d-flex flex-wrap text-right fs-80">
							<span class="text-nowrap font-weight-bold mr-2">{\App\Language::translate('LBL_GROSS_PRICE', $MODULE_NAME)}:</span>
							<span class="text-nowrap">{\App\Fields\Currency::formatToDisplay($RECORD->getDisplayValue('priceGross'))}</span>
						</div>
					{/if}

				</div>
			</div>
		</div>
	</div>
	<!--/tpl-Products-ShoppingCart-Product-->
{/strip}
