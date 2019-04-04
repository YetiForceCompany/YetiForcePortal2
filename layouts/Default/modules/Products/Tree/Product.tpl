{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-Tree-Product card m-3 box-shadow js-cart-item">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">{$RECORD->getDisplayValue('productname')}</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title pricing-card-title">{$RECORD->getDisplayValue('unit_price')}&nbsp;{$USER->getPreferences('currency_code')}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{$RECORD->getDisplayValue('ean')}</h6>
            <div class="product-image-contener mb-4">
                {assign var="IMAGES" value=$RECORD->get('imagename')}
                {if empty($IMAGES) }
                    <div class="product-no-image">
                        <img src="{\App\Config::$logo}" class="product-image" alt="Logo" title="Logo">
                    </div>
                {else}
                    <img class="product-image" src="data:image/jpeg;base64,{$IMAGES[0]}" alt="" title="" />
                {/if}
            </div>

            <div class="btn-group" role="group" aria-label="Basic example">
                <button class="btn btn-secondary js-amount-inc" type="button"><i class="fas fa-plus"></i></button>
                <input class="form-control js-amount" type="text" value="1">
                <button class="btn btn-secondary js-amount-dec" type="button"><i class="fas fa-minus"></i></button>
            </div>

            <div class="mb-2">
                <button type="button" class="btn btn-lg btn-block add-to-cart">
                    <i class="fas fa-cart-plus mr-1"></i>
                    {\App\Language::translate('LBL_ADD_TO_CART', $MODULE_NAME)}
                </button>
            </div>
        </div>
    </div>
{/strip}
