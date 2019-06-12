{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-ShoppingCart-Summary p-3 box-shadow border rounded product-summary js-summary-container">
        <div class="row">
            <h6 class="col-12 mb-3"><span class="fas fa-list-alt mr-2"></span>{\App\Language::translate('LBL_SUMMARY', $MODULE_NAME)}</h6>
        </div>
        <div class="d-flex flex-column small">
            <div class="mb-2 d-flex justify-content-between">
                <div class="text-muted text-truncated">
                    {\App\Language::translate('LBL_TOTAL_PRICE', $MODULE_NAME)}
                </div>
                <div class="js-total-price-netto text-nowrap">
                    {\App\Fields\Currency::formatToDisplay($TOTAL_PRICE)}
                </div>
            </div>
            <div class="mb-2 d-flex justify-content-between border-bottom">
                 <div class="text-muted text-truncated">{\App\Language::translate('LBL_SHIPPING', $MODULE_NAME)}</div>
                <div class="text-nowrap">0</div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="text-muted text-truncated">
                    {\App\Language::translate('LBL_TOTAL_PRICE', $MODULE_NAME)} ({\App\Language::translate('LBL_INCLUDING_VAT', $MODULE_NAME)})
                </div>
                <div class="font-weight-bold text-nowrap">{\App\Fields\Currency::formatToDisplay($TOTAL_PRICE_GROSS)}</div>
            </div>
        </div>
        <div class="row p-2 mb-4">
            {if !(!empty($ADDRESSES) && empty($ADDRESSES['data']))}
                <a href="{$PROCCED_URL}" class="btn btn-raised btn-success js-btn-proceed-to-checkout m-auto text-truncate">
                    <i class="fas fa-cart-arrow-down"></i> {\App\Language::translate('LBL_PROCEED_TO_CHECKOUT', $MODULE_NAME)}
                </a>
            {/if}
        </div>
    </div>
{/strip}
