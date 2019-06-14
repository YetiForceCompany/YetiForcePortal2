{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<div>
{foreach from=$PAYMENT->getBankAccountInfo() item=VALUE key=FIELDNAME}
  <div class="row small">
    <label class="col-sm-2 col-form-label text-muted">
      {App\Language::translate('LBL_'|cat:(strtoupper($FIELDNAME)), $MODULE_NAME)}
    </label>
    <div class="col-sm-10 pt-2">
      {$VALUE}
    </div>
</div>
{/foreach}
</div>
{/strip}
