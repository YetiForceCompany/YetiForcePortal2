{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <!--tpl-Products-ProceedToCheckout-Product-->
    <div class="row m-0 p-1 box-shadow product-shopping-cart {if $COUNTER < $COUNT_OF_RECORDS}product-border-b {/if}js-cart-item"
            data-id="{\App\Purifier::encodeHTML($CRM_ID)}"
            data-price-netto="{$RECORD->getRawValue('unit_price')}">
        <div class="col-2 product-border-r d-flex">
            <div class="product-shopping-cart-image-contener align-items-center m-auto">
                {assign var="IMAGES" value=$RECORD->get('imagename')}
                {if empty($IMAGES) }
                    <div class="product-no-image m-auto">
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
        <div class="col-8 pl-5">
            <div class="row fs-120 font-weight-bold">{$RECORD->getDisplayValue('productname')}</div>
            <div class="row fs-80 text-muted">EAN: {$RECORD->getDisplayValue('ean')}</div>
       </div>
        <div class="col-2">
            <div class="row mt-5">
                {\App\Language::translate('LBL_QUANTITY', $MODULE_NAME)}: {$RECORD->getDisplayValue('amountInShoppingCart')}
            </div>
            <div class="row">{\App\Language::translate('LBL_PRICE', $MODULE_NAME)}: {$RECORD->getDisplayValue('totalPriceNetto')}</div>
        </div>
    </div>
    <!--/tpl-Products-ProceedToCheckout-Product-->
{/strip}
