{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="input-group js-search-group my-3" data-js="change|keyup">
        <div class="input-group-prepend">
             <button class="btn btn-outline-secondary o-category__button-search js-search-cancel border-right-0 mb-0" type="button">
                    <span class="u-cursor-pointer" data-js="click" aria-hidden="true">&times;</span>
            </button>
        </div>
        <input type="text" class="form-control u-font-size-13px js-search o-category__input-search o-chat__form-control border-right-0 border-left-0 border-top border-bottom"
            value="{$SEARCH_TEXT}" autocomplete="off" placeholder="{\App\Language::translate('LBL_SEARCH_PRODUCT', $MODULE_NAME)}" data-js="keydown"/>
        <div class="input-group-append">
            <button class="btn btn-outline-secondary o-category__button-search js-search-button border-left-0 mb-0" type="button">
                    <span class="fas fa-search"></span>
            </button>
        </div>
    </div>
{/strip}
