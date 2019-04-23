{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-Tree-Search input-group js-search-group" data-js="change|keyup">
        <div class="input-group-prepend">
             <button class="btn btn-outline-secondary js-search-cancel mr-2 bmd-btn-icon" type="button">
                    <span class="u-cursor-pointer" data-js="click" aria-hidden="true">&times;</span>
            </button>
        </div>
        <input type="text" class="form-control u-font-size-13px js-search  rounded-0 o-chat__form-control"
            value="{$SEARCH_TEXT}" autocomplete="off" placeholder="{\App\Language::translate('LBL_SEARCH_PRODUCT', $MODULE_NAME)}" data-js="keydown"/>
        <div class="input-group-append">
         <button class="btn btn-outline-secondary js-search-button ml-2 bmd-btn-icon" type="button">
                    <span class="fas fa-search"></span>
            </button>
        </div>
    </div>
{/strip}
