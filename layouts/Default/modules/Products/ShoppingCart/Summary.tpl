{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-ShoppingCart-Summary container p-3 box-shadow border rounded product-summary js-summary-container">
        <div class="row">
            <h5 class="col-12 mb-3"><span class="fas fa-list-alt mr-2"></span>{\App\Language::translate('LBL_SUMMARY', $MODULE_NAME)}</h5>
        </div>
        <div class="row mb-2 pl-4">
            <div class="col-8">{\App\Language::translate('LBL_TOTAL_PRICE', $MODULE_NAME)}</div>
            <div class="col-4 js-total-price-netto">{\App\Fields\Currency::formatToDisplay($TOTAL_PRICE)}</div>
        </div>
        {if \App\Config::getBool('addDelivery')}
            <div class="row mb-2 product-line pl-4 pb-2">
                <div class="col-8">{\App\Language::translate('LBL_SHIPPING', $MODULE_NAME)}</div>
                <div class="col-4 js-shipping-price">{\App\Fields\Currency::formatToDisplay($SHIPPING_PRICE)}</div>
            </div>
        {/if}
        <div class="row mb-2 font-weight-bold">
            <div class="col-8">{\App\Language::translate('LBL_TOTAL_PRICE', $MODULE_NAME)} ({\App\Language::translate('LBL_INCLUDING_VAT', $MODULE_NAME)})</div>
            <div class="col-4 pl-4 js-total-price-gross">{\App\Fields\Currency::formatToDisplay($TOTAL_PRICE_GROSS)}</div>
        </div>
        <div class="row p-2 mb-4">
            {if !(!empty($ADDRESSES) && empty($ADDRESSES['data']))}
                <a href="{$PROCCED_URL}" class="btn btn-raised btn-success m-auto js-btn-proceed-to-checkout">
                    <i class="fas fa-cart-arrow-down"></i> {\App\Language::translate('LBL_PROCEED_TO_CHECKOUT', $MODULE_NAME)}
                </a>
            {/if}
        </div>
    </div>
{/strip}
