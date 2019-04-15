{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-ShoppingCart-Summary container box-shadow border border-secondary rounded js-summary-container">
        <div class="row">
            <div class="col-7">{\App\Language::translate('LBL_TOTAL_PRICE', $MODULE_NAME)}</div>
            <div class="col-5 js-total-price-netto">{$TOTAL_PRICE}</div>
        </div>
        <div class="row">
            <div class="col-7">{\App\Language::translate('LBL_SHIPPING', $MODULE_NAME)}</div>
            <div class="col-5">0</div>
        </div>
        <div class="row">
            <div class="col-7">{\App\Language::translate('LBL_PROCEED_TO_CHECKOUT', $MODULE_NAME)} ({\App\Language::translate('LBL_INCLUDING_VAT', $MODULE_NAME)})</div>
            <div class="col-5 js-total-price-brutto">0</div>
        </div>
        <div class="row p-2">
            <button class="btn btn-sm btn-success m-auto js-buy" type="button">
                <i class="fas fa-cart-arrow-down"></i> {\App\Language::translate('LBL_PROCEED_TO_CHECKOUT', $MODULE_NAME)}
            </button>
        </div>
    </div>
{/strip}
