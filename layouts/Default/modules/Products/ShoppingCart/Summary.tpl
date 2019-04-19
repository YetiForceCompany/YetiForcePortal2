{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-ShoppingCart-Summary container m-3 p-3 box-shadow border rounded product-summary js-summary-container">
        <div class="row">
            <h4 class="col-12 mb-2 font-weight-bold">{\App\Language::translate('LBL_SUMMARY', $MODULE_NAME)}</h4>
        </div>
        <div class="row mb-2 pl-4">
            <div class="col-8">{\App\Language::translate('LBL_TOTAL_PRICE', $MODULE_NAME)}</div>
            <div class="col-4 js-total-price-netto">{$TOTAL_PRICE}</div>
        </div>
        <div class="row mb-2 product-line pl-4 pb-2">
            <div class="col-8">{\App\Language::translate('LBL_SHIPPING', $MODULE_NAME)}</div>
            <div class="col-4">0</div>
        </div>
        <div class="row mb-2 font-weight-bold">
            <div class="col-8">{\App\Language::translate('LBL_TOTAL_PRICE', $MODULE_NAME)} ({\App\Language::translate('LBL_INCLUDING_VAT', $MODULE_NAME)})</div>
            <div class="col-4 js-total-price-brutto">0</div>
        </div>
        <div class="row p-2 mb-4">
            <button class="btn btn-success m-auto product-btn-buy js-buy" type="button">
                <i class="fas fa-cart-arrow-down"></i> {\App\Language::translate('LBL_PROCEED_TO_CHECKOUT', $MODULE_NAME)}
            </button>
        </div>
    </div>
{/strip}
