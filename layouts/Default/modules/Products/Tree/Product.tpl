{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <!--tpl-Products-Tree-Product-->
    <div class="m-0 p-1 box-shadow product js-cart-item"
            data-id="{\App\Purifier::encodeHTML($CRM_ID)}"
            data-price-netto="{$RECORD->getRawValue('unit_price')}">
        <div class="row mb-4">
            <div class="product-image-contener mx-auto">
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
        <div class="row">
            <div class="col-12 fs-120 font-weight-bold">{$RECORD->getDisplayValue('productname')}</div>
        </div>
        <div class="row mb-2">
            <div class="col-12 fs-80 text-muted">EAN: {$RECORD->getDisplayValue('ean')}</div>
        </div>
        <div class="row mb-1">
            <div class="col-2">
                <button type="button" class="btn btn-sm btn-success js-add-to-cart" title="{\App\Language::translate('LBL_ADD_TO_CART', $MODULE_NAME)}" data-js="click">
                    <i class="fas fa-cart-plus mr-1"></i>
                </button>
            </div>
            <div class="input-group input-group-sm mb-3 col-4">
                <div class="input-group-prepend">
                    <button class="btn btn-sm btn-outline-secondary js-amount-dec" type="button">-</button>
                </div>
                <input class="input-group-prepend form-control js-amount" type="text" value="{if $RECORD->has('amountInShoppingCart')}{$RECORD->getDisplayValue('amountInShoppingCart')}{else}1{/if}">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-outline-secondary js-amount-inc" type="button">+</button>
                </div>
            </div>
            <div class="col-6">
                <div class="row">netto: {$RECORD->getDisplayValue('unit_price')}</div>
                <div class="row">brutto: {$RECORD->getDisplayValue('unit_price')}</div>
            </div>
        </div>
    </div>
    <!--/tpl-Products-Tree-Product-->
{/strip}
