{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-ShoppingCart-Summary p-3 box-shadow border rounded product-summary js-summary-container">
        <div class="row">
            <h4 class="col-12 mb-3"><span class="fas fa-list-alt mr-2"></span>{\App\Language::translate('LBL_SUMMARY', $MODULE_NAME)}</h4>
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
            {if \App\Config::getBool('addDelivery')}
                <div class="mb-2 d-flex justify-content-between">
                    <div class="text-muted text-truncated">{\App\Language::translate('LBL_SHIPPING', $MODULE_NAME)}</div>
                    <div class="text-nowrap js-shipping-price">{\App\Fields\Currency::formatToDisplay($SHIPPING_PRICE)}</div>
                </div>
            {/if}
            <div class="d-flex justify-content-between border-top">
                <div class="text-muted text-truncated">
                    {\App\Language::translate('LBL_TOTAL_PRICE', $MODULE_NAME)} ({\App\Language::translate('LBL_INCLUDING_VAT', $MODULE_NAME)})
                </div>
                <div class="font-weight-bold text-nowrap js-total-price-gross">{\App\Fields\Currency::formatToDisplay($TOTAL_PRICE_GROSS)}</div>
            </div>
        </div>
        <div class="row p-2 pt-5">
            {include file=\App\Resources::templatePath("components/{$VIEW}Btn.tpl", $MODULE_NAME)}
        </div>
    </div>
{/strip}
