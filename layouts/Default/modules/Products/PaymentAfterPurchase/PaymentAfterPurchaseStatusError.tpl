{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <!-- tpl-Products-PaymentAfterPurchase-PaymentAfterPurchaseStatusError -->
    	<div class="alert alert-warning" role="alert">
            <p>{\App\Language::translate('LBL_UNSUCCESSFUL_TRANSACTION', $MODULE_NAME)}</p>
            {if !empty($ORDER_URL)}
                <hr>
                <p class="mb-0"><a href="{$ORDER_URL}" class="btn btn-danger">{\App\Language::translate('LBL_GO_TO_ORDER', $MODULE_NAME)}</a></p>
            {/if}
        </div>
    <!-- /tpl-Products-PaymentAfterPurchase-PaymentAfterPurchaseStatusError -->
{/strip}
