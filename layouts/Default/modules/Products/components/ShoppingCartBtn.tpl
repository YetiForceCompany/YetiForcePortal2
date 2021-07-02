{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
{if !(!empty($ADDRESSES) && empty($ADDRESSES['data']))}
    <a href="{$PROCCED_URL}" class="btn btn-raised btn-success js-btn-proceed-to-checkout m-auto text-truncate">
        <i class="fas fa-cart-arrow-down"></i> {\App\Language::translate('LBL_PROCEED_TO_CHECKOUT', $MODULE_NAME)}
    </a>
{/if}
{/strip}
