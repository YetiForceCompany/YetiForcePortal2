{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-Preview-Preview d-flex mt-3 js-preview" data-js="container">
        <input type="hidden" class="js-preview-record" value="{$RECORD->getId()}" data-js="val">
        <div class="col-4">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    {foreach from=$RECORD->get('imagename') item=IMAGE name=images}
                        <div class="carousel-item {if $smarty.foreach.images.index eq 0}active{/if}" >
                            <img class="d-block w-100" src="data:image/jpeg;base64,{$IMAGE}" alt="First slide">
                        </div>
                    {/foreach}
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-8">
            <h4>{$RECORD->get('productname')}</h4>
            <div class="col-12 row">
                <button class="btn btn-outline-success u-border-radius js-add-to-cart mb-0 mr-2" data-js="click"><i class="fas fa-cart-plus mr-1"></i></button>
                <div class="input-group input-group-sm col-2 d-flex align-items-center px-0 c-cart-quantity">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary js-amount-dec mr-2 c-cart-quantity__btn-circle mb-0" type="button">-</button>
                    </div>
                    <input class="input-group-prepend form-control js-amount text-center c-cart-quantity__input product-input-quantity border" type="text" value="1">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-outline-secondary js-amount-inc ml-2 c-cart-quantity__btn-circle mb-0" type="button">+</button>
                    </div>
                </div>
            </div>
            <hr>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-capitalize" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
                        {\App\Language::translate('LBL_DESCRIPTION', $MODULE_NAME)}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-capitalize" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">
                        {\App\Language::translate('LBL_DETAILS', $MODULE_NAME)}
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    {$RECORD->get('description')}
                </div>
                <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">

                </div>
            </div>
        </div>
    </div>
{/strip}
