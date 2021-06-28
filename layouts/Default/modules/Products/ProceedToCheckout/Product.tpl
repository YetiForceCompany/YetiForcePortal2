{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <!--tpl-Products-ProceedToCheckout-Product-->
    <div class="d-flex flex-nowrap m-0 p-2 box-shadow product-shopping-cart {if $COUNTER < $COUNT_OF_RECORDS}product-border-b {/if}js-cart-item"
            data-id="{\App\Purifier::encodeHTML($CRM_ID)}"
            data-price-netto="{$RECORD->getRawValue('unit_price')}">
        <div class="d-flex pr-2 product-border-r">
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
					<div class="product-no-image m-auto" title="{$RECORD->getDisplayValue('productname')}">
						{$RECORD->getModuleModel()->getFieldModel('imagename')->getImg($IMAGES[0])}
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
            </div>
            <div class="col-auto d-flex flex-column justify-content-end ml-auto px-2">
                <div class="d-flex flex-wrap justify-content-between fs-80">
                    <span class="font-weight-bold mr-1 mr-lg-3">
                        {\App\Language::translate('LBL_QUANTITY', $MODULE_NAME)}:
                    </span>
                    <span>{$RECORD->getDisplayValue('amountInShoppingCart')}</span>
                </div>
                <div class="d-flex flex-wrap justify-content-between fs-80">
                    <span class="font-weight-bold mr-1 mr-lg-3">
                        {\App\Language::translate('LBL_PRICE', $MODULE_NAME)}:
                    </span>
                    <span>
                        {\App\Fields\Currency::formatToDisplay($RECORD->getDisplayValue('totalPriceGross'))}
                    </span>
                </div>
            </div>
       </div>
    </div>
    <!--/tpl-Products-ProceedToCheckout-Product-->
{/strip}
