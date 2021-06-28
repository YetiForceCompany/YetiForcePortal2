{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="widget_header row">
        <div class="col-sm-8">
            <div class="pull-left">
                {include file=\App\Resources::templatePath("BreadCrumbs.tpl", $MODULE_NAME)}
            </div>
        </div>
	</div>
    <div class="tpl-Products-Preview-Preview d-flex mt-3 js-preview js-cart-item"
			data-check-stock-levels="{$CHECK_STOCK_LEVELS}"
            data-qtyinstock="{$RECORD->getRawValue('qtyinstock')}"
            data-amount-in-shopping-cart="{$RECORD->getRawValue('amountInShoppingCart')}"
            data-price-netto="{$RECORD->getRawValue('unit_price')}"
            data-price-gross="{$RECORD->getRawValue('unit_gross')}"
            data-js="container">

        <input type="hidden" class="js-preview-record" value="{$RECORD->getId()}" data-js="val">
        <div class="col-4">
            {assign var="IMAGES" value=$RECORD->get('imagename')}
            {if empty($IMAGES)}
                <div class="product-image-contener text-center">
                     <div class="product-no-image m-auto">
                        <span class="fa-stack fa-2x product-no-image">
                            <i class="fas fa-camera fa-stack-1x"></i>
                            <i class="fas fa-ban fa-stack-2x"></i>
                        </span>
                    </div>
                </div>
            {else}
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        {foreach from=$IMAGES item=IMAGE name=images}
                             <div class="carousel-item {if $smarty.foreach.images.index eq 0}active{/if}" >
                            	{$RECORD->getModuleModel()->getFieldModel('imagename')->getImg($IMAGE, 'd-block w-100')}
                            </div>
                        {/foreach}
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">{\App\Language::translate('LBL_PREVIOUS', $MODULE_NAME)}</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">{\App\Language::translate('LBL_NEXT', $MODULE_NAME)}</span>
                    </a>
                </div>
            {/if}
        </div>
        <div class="col-8">
            <div class="w-100 d-flex align-items-center">
                <h4 class="mr-3">{$RECORD->getDisplayValue('productname')}</h4>
                <table class="u-fs-12px">
                    <tbody>
                        <tr>
                            <th class="px-1">{\App\Language::translate('LBL_NET_PRICE', $MODULE_NAME)}:</th>
                            <td class="px-1">{$RECORD->getDisplayValue('unit_price')}</td>
                        </tr>
                        <tr>
                            <th class="px-1">{\App\Language::translate('LBL_GROSS_PRICE', $MODULE_NAME)}:</th>
                            <td class="px-1">{$RECORD->getDisplayValue('unit_gross')}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-100 my-2 u-fs-12px">
                <span class="text-muted">{$FIELDS_LABEL['ean']}:</span> {$RECORD->getDisplayValue('ean')}
            </div>
            {assign var="COUNT_OF_RECORDS" value=count($RECORDS)}
            {if $COUNT_OF_RECORDS > 0 }
                <div>
                    {assign var="COUNTER" value=1}
                    {foreach item=RECORD key=CRM_ID from=$RECORDS}
                        {include file=\App\Resources::templatePath("Preview/Product.tpl", $MODULE_NAME)}
                        {assign var="COUNTER" value=$COUNTER + 1}
                    {/foreach}
                </div>
            {else}
                <div class="col-12 row">
                    <button class="btn btn-success u-border-radius js-add-to-cart mb-0 mr-2" data-js="click"><i class="fas fa-cart-plus mr-1"></i></button>
                    <div class="input-group input-group-sm col-2 d-flex align-items-center px-0 c-cart-quantity">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary js-amount-dec mr-2 c-cart-quantity__btn-circle mb-0" type="button">-</button>
                        </div>
                        <input class="input-group-prepend form-control js-amount text-center c-cart-quantity__input product-input-quantity border" type="text" value="1">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-secondary js-amount-inc ml-2 c-cart-quantity__btn-circle mb-0" type="button">+</button>
                        </div>
                    </div>
                </div>
            {/if}
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
                <div class="tab-pane fade show active p-3" id="description" role="tabpanel" aria-labelledby="description-tab">
                    {$RECORD->get('description')}
                </div>
                <div class="tab-pane fade p-3" id="details" role="tabpanel" aria-labelledby="details-tab">
                   {foreach item=BLOCK from=$BLOCKS}
                        {if isset($FIELDS[$BLOCK['id']])}
                            {foreach item=FIELD from=$FIELDS[$BLOCK['id']]}
                                    <div class="col-12 row">
                                        {if $FIELD->getName() !== 'description' && $FIELD->get('type') !== 'multiImage'}
                                            <div class="col-md-2 px-0">
                                                <label class="muted font-weight-bold">
                                                    {$FIELD->getLabel()}
                                                </label>
                                            </div>
                                            <div class="col-md-9 px-0">
                                                {$RECORD->getDisplayValue($FIELD->getName())}
                                            </div>
                                        {/if}
                                    </div>
                            {/foreach}
                        {/if}
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
{/strip}
