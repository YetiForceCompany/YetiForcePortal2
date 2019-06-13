{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="c-input-rounded input-group js-search-group my-3" data-js="change|keyup">
        <div class="c-input-rounded__prepend input-group-prepend">
             <button class="btn btn-secondary js-search-cancel" type="button">
                    <span data-js="click" aria-hidden="true">&times;</span>
            </button>
        </div>
        <input type="text" class="c-input-rounded__input js-search form-control"
            value="{$SEARCH_TEXT}" autocomplete="off" placeholder="{\App\Language::translate('LBL_SEARCH_PRODUCT', $MODULE_NAME)}" data-js="keydown"/>
        <div class="c-input-rounded__append input-group-append">
            <button class="btn btn-secondary js-search-button" type="button">
                    <span class="fas fa-search"></span>
            </button>
        </div>
    </div>
{/strip}
