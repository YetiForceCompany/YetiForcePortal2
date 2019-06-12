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
        <div class="row mb-2 product-line pl-4 pb-2">
            <div class="col-8">{\App\Language::translate('LBL_SHIPPING', $MODULE_NAME)}</div>
            <div class="col-4">0</div>
        </div>
        <div class="row mb-2 font-weight-bold">
            <div class="col-8">{\App\Language::translate('LBL_TOTAL_PRICE', $MODULE_NAME)} ({\App\Language::translate('LBL_INCLUDING_VAT', $MODULE_NAME)})</div>
            <div class="col-4 pl-4 js-total-price-brutto">{\App\Fields\Currency::formatToDisplay($TOTAL_PRICE_GROSS)}</div>
        </div>
        <div class="row p-2 mb-4">
            <button class="btn btn-raised btn-success m-auto js-buy" type="button" data-js="click">
                <i class="fas fa-cart-arrow-down"></i> {\App\Language::translate('LBL_BUY', $MODULE_NAME)}
            </button>
        </div>
    </div>
{/strip}
