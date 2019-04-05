{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-Tree-Search input-group js-search-group" data-js="change|keyup">
        <div class="input-group-prepend">
            <span class="input-group-text bg-white hide js-search-cancel border-bottom">
                <span class="u-cursor-pointer" data-js="click" aria-hidden="true">&times;</span>
            </span>
        </div>
        <input type="text" class="form-control u-font-size-13px js-search border-bottom rounded-0 o-chat__form-control"{' '}
            autocomplete="off"{' '}
            placeholder="{\App\Language::translate('LBL_SEARCH_PRODUCT', $MODULE_NAME)}"
            data-js="keydown"/>
        <div class="input-group-append">
            <span class="input-group-text bg-white border-bottom u-cursor-pointer js-search-button">
                <span class="fas fa-search"></span>
            </span>
        </div>
    </div>
{/strip}
