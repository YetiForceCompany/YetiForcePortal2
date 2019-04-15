{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <!--tpl-Products-Tree-Product-->
    {if !isset($SHOPPING_CART_VIEW)}
        {assign var="SHOPPING_CART_VIEW" value=false}
    {/if}
    <div class="m-3 p-1 box-shadow border border-secondary rounded product js-cart-item" data-id="{\App\Purifier::encodeHTML($CRM_ID)}">
        <div class="row">
            <div class="col-7">{$RECORD->getDisplayValue('productname')}</div>
            <div class="col-5">netto: {$RECORD->getDisplayValue('unit_price')}</div>
        </div>
        <div class="row">
            <div class="col-7">{$RECORD->getDisplayValue('ean')}</div>
            <div class="col-5">brutto: {$RECORD->getDisplayValue('unit_price')}</div>
    </div>
        <div class="row">
            <div class="product-image-contener mb-4 ml-4">
                {assign var="IMAGES" value=$RECORD->get('imagename')}
                {if empty($IMAGES) }
                    <div class="product-no-image">
                        <img src="{\App\Config::$logo}" class="img-responsive" alt="Logo" title="Logo">
                    </div>
                {else}
                    <img class="product-image" src="data:image/jpeg;base64,{$IMAGES[0]}" alt="{$RECORD->getDisplayValue('productname')}" title="{$RECORD->getDisplayValue('productname')}" />
                {/if}
            </div>
        </div>
        <div class="row mb-1">
            <div class="btn-group col-4" role="group" aria-label="Basic example">
                <button class="btn btn-sm btn-secondary js-amount-inc" type="button"><i class="fas fa-plus"></i></button>
                <input class="form-control js-amount" type="text" value="{if $RECORD->has('amountInShoppingCart')}{$RECORD->getDisplayValue('amountInShoppingCart')}{else}1{/if}">
                <button class="btn btn-sm btn-secondary js-amount-dec" type="button"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        {if $SHOPPING_CART_VIEW}
            <div class="row mb-1">
                <div class="col-12">
                    <button type="button" class="btn btn-sm btn-block add-to-cart js-remove-from-cart" data-js="click">
                        <i class="fas fa-cart-plus mr-1"></i>
                        {\App\Language::translate('LBL_REMOVE_FROM_CART', $MODULE_NAME)}
                    </button>
                </div>
            </div>
        {else}
            <div class="row mb-1">
                <div class="col-5">
                    <button type="button" class="btn btn-sm btn-block add-to-cart js-add-to-cart" data-js="click">
                        <i class="fas fa-cart-plus mr-1"></i>
                        {\App\Language::translate('LBL_ADD_TO_CART', $MODULE_NAME)}
                    </button>
                </div>
            </div>
        {/if}
    </div>
    <!--/tpl-Products-Tree-Product-->
{/strip}
