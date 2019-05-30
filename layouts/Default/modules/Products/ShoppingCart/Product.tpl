{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <!--tpl-Products-ShoppingCart-Product-->
    <div class="row m-0 p-1 box-shadow product-shopping-cart {if $COUNTER < $COUNT_OF_RECORDS}product-border-b {/if}js-cart-item"
            data-id="{\App\Purifier::encodeHTML($CRM_ID)}"
            data-qtyinstock="{$RECORD->getRawValue('qtyinstock')}"
            data-price-netto="{$RECORD->getRawValue('unit_price')}"
            data-price-gross="{$RECORD->getRawValue('unit_gross')}">
        <div class="col-2 product-border-r d-flex">
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
                    <img class="product-image" src="data:image/jpeg;base64,{$IMAGES[0]}" alt="{$RECORD->getDisplayValue('productname')}" title="{$RECORD->getDisplayValue('productname')}" />
                {/if}
            </div>
        </div>
        <div class="col-7 pl-5">
            <div class="fs-120 font-weight-bold"><a href="index.php?module=Products&view=Preview&record={$RECORD->getId()}">{$RECORD->getDisplayValue('productname')}</a></div>
            <div class="fs-80 text-muted">EAN: {$RECORD->getDisplayValue('ean')}</div>
            <div class="mt-5 row">
                <div class="col-4 p-0 m-0">
                 {if !$READONLY}
                    <button type="button" class="btn btn-sm btn-block btn-outline-danger js-remove-from-cart" data-js="click">
                        <i class="fas fa-trash mr-1"></i>
                        {\App\Language::translate('LBL_REMOVE_FROM_CART', $MODULE_NAME)}
                    </button>
                    {/if}

                </div>
                <div class="col-12 alert alert-warning d-none js-no-such-quantity" role="alert">
                    {\App\Language::translate('LBL_NO_SUCH_QUANTITY', $MODULE_NAME)}
                    {\App\Language::translate('LBL_MAXIMUM_AMOUNT', $MODULE_NAME)}
                    <span class="pl-2 js-maximum-quantity">{App\Fields\Integer::formatToDisplay($RECORD->getRawValue('qtyinstock'))}</span>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="col-12 mt-2 mb-5 d-flex justify-content-end">
                <div class="input-group input-group-sm col-10 c-cart-quantity d-flex align-items-center">
                    {if !$READONLY}
                        <div class="input-group-prepend">
                            <button class="btn btn-sm btn-outline-secondary c-cart-quantity__btn-circle js-amount-dec mr-2 mb-0" type="button">-</button>
                        </div>
                        <input class="form-control js-amount c-cart-quantity__input border text-center" type="text" value="{if $RECORD->has('amountInShoppingCart')}{$RECORD->getDisplayValue('amountInShoppingCart')}{else}1{/if}">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-outline-secondary c-cart-quantity__btn-circle js-amount-inc ml-2 mb-0" type="button">+</button>
                        </div>
                    {else}
                        <input class="form-control c-cart-quantity__input border text-center js-amount" disabled type="text" value="{if $RECORD->has('amountInShoppingCart')}{$RECORD->getDisplayValue('amountInShoppingCart')}{else}1{/if}">
                    {/if}
                </div>
            </div>
            <div class="col-12 text-secondary">
                {if !$READONLY}
                    <div class="col-12 text-right fs-80"><span class="font-weight-bold">{\App\Language::translate('LBL_NET_PRICE', $MODULE_NAME)}:</span> {$RECORD->getDisplayValue('unit_price')}</div>
                    <div class="col-12 text-right fs-80"><span class="font-weight-bold">{\App\Language::translate('LBL_GROSS_PRICE', $MODULE_NAME)}:</span> {$RECORD->getDisplayValue('unit_gross')}</div>
                {else}
                    <div class="col-12 text-right fs-80">
                        <span class="font-weight-bold">{\App\Language::translate('LBL_NET_PRICE', $MODULE_NAME)}:</span>
                        {\App\Fields\Currency::formatToDisplay($RECORD->getDisplayValue('priceNetto'))}
                    </div>
                    <div class="col-12 text-right fs-80">
                        <span class="font-weight-bold">{\App\Language::translate('LBL_GROSS_PRICE', $MODULE_NAME)}:</span>
                        {\App\Fields\Currency::formatToDisplay($RECORD->getDisplayValue('priceGross'))}
                    </div>
                {/if}

            </div>
        </div>
    </div>
    <!--/tpl-Products-ShoppingCart-Product-->
{/strip}
